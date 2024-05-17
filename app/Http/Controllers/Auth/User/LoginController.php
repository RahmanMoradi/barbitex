<?php

namespace App\Http\Controllers\Auth\User;

use App\Http\Controllers\Controller;
use App\Jobs\User\Login\setIsCodeUser;
use App\Models\User\ValidCode;
use App\Models\Vsms;
use App\Notifications\Admin\SendNotificationToAdmin;
use App\Notifications\EmailSendLoginCodeNotification;
use App\Models\User;
use App\Notifications\User\SendLoginCodeNotification;
use App\Rules\IranMobile;
use App\Rules\IsNotPersian;
use Arcanedev\NoCaptcha\Rules\CaptchaRule;
use Artesaos\SEOTools\Facades\JsonLd;
use Artesaos\SEOTools\Facades\SEOMeta;
use Artesaos\SEOTools\Facades\SEOTools;
use Artesaos\SEOTools\Facades\TwitterCard;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Notification;
use anlutro\LaravelSettings\Facade as Setting;

class LoginController extends Controller
{

    public function show()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $emailLogin = 0;
        if (filter_var($request->email, FILTER_VALIDATE_EMAIL)) {
            $emailLogin = 1;
        }

        if ($emailLogin == 1) {
            $request->validate([
                'email' => ['required', 'email', 'exists:users,email'],
                'password' => 'required',
            ]);
        } else {
            $request->validate([
                'email' => ['required', new IranMobile, 'exists:users,mobile'],
                'password' => 'required',
            ]);
        }
        if (Setting::get('NOCAPTCHA_Active') == 1) {
            $request->validate([
                'g-recaptcha-response' => ['required', new CaptchaRule],
            ]);
        }
        if ($emailLogin == 1) {
            if (Auth::attempt($request->only('email', 'password'), $request->has('remember'))) {
                $user = Auth::user();
                $valid = $user->two_factor_type;
                if ($valid != 'none') {
                    setIsCodeUser::dispatchNow($user, false);
                    return redirect(route('validate'));

                } else {
                    return redirect('panel');
                }
            } else {
                flash(Lang::get('wrong username or password'))->error()->important();

                return back();
            }
        } else {
            $condition = [
                'mobile' => $request->email,
                'password' => $request->password
            ];
            if (Auth::attempt($condition, $request->has('remember'))) {
                $user = Auth::user();
                $valid = $user->two_factor_type;
                if ($valid != 'none') {
                    $user->update([
                        'two_factor_type' => 'sms'
                    ]);
                    setIsCodeUser::dispatchNow($user, false);
                    return redirect(route('validate'));

                } else {
                    return redirect('panel');
                }
            } else {
                flash(Lang::get('wrong username or password'))->error()->important();

                return back();
            }
        }
    }

    public function mobileACtive(Request $request)
    {
        $request->validate([
            'code' => 'required|numeric'
        ]);

        $vsms = Vsms::whereCode($request->input('code'))->where('user_id', Auth::id())->first();
        if (!$vsms) {
            flash(Lang::get('code is invalid'))->important()->error();

            $code = 1;

            return view('dashboard.auth.login', compact('code'));
        }
        if ($vsms->user_id != Auth::id()) {
            return back()->withErrors(['code' => Lang::get('code is invalid')]);
        } else {
            setIsCodeUser::dispatchNow(Auth::user(), true);
//            setIsCodeUser::dispatch( Auth::user() , false )->delay(now()->addMinutes(25));
            Notification::send(User::whereRole(2)->get(), (new SendNotificationToAdmin('userLogin', Auth::user()->name))->delay(now()->addSecond(3)));
            $vsms->delete();
            if (Auth::user()->role == 1) {
                return redirect('panel');
            } elseif (Auth::user()->role == 2) {
                return redirect('wa-admin');
            }
        }
    }

    public function forget(Request $request)
    {
        $user = User::whereEmail($request->email)->first();
        if (!$user) {
            flash(Lang::get('user not found'))->error();
            return back();
        }
        Auth::login($user);
        if ($request->has('level') && $request->level == 2) {
            $request->validate([
                'code' => 'required|numeric',
                'password' => 'required|confirmed',
                'email' => 'required',
            ]);

            $validCode = ValidCode::where('user_id', Auth::id())->first();
            $code = $validCode->code === $request->input('code');
            if (!$code) {
                flash(Lang::get('code is invalid'))->important()->error();

                return back();
            } else {
                $validCode->delete();
                $user->update([
                    'password' => \Hash::make($request->input('password'))
                ]);
                if ($user->two_factor_type === 'none') {
                    setIsCodeUser::dispatchNow($user, true);
                }

                flash(Lang::get('password changed'))->error();

                return redirect(route('login'));
            }
        } else {
            setIsCodeUser::dispatchNow($user, false);

            $request->validate([
                'email' => 'required|exists:users,email'
            ]);

            Auth::user()->notify(new SendLoginCodeNotification('email'));
            $email = $user->email;

            return redirect(route('ForgetPassword', 'code=1&email=' . $email));
        }
    }
}
