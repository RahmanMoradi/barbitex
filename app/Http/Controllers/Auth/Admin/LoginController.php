<?php

namespace App\Http\Controllers\Auth\Admin;

use App\Http\Controllers\Controller;
use App\Jobs\User\Login\setIsCodeUser;
use App\Models\User\ValidCode;
use App\Notifications\User\SendLoginCodeNotification;
use App\Rules\IranMobile;
use App\Rules\IsNotPersian;
use Arcanedev\NoCaptcha\Rules\CaptchaRule;
use Artesaos\SEOTools\Facades\JsonLd;
use Artesaos\SEOTools\Facades\SEOMeta;
use Artesaos\SEOTools\Facades\SEOTools;
use Artesaos\SEOTools\Facades\TwitterCard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Notification;
use anlutro\LaravelSettings\Facade as Setting;

class LoginController extends Controller
{

    public function show()
    {
        return view('auth.admin.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email', 'exists:admins,email'],
            'password' => 'required',
        ]);

        if (Setting::get('NOCAPTCHA_Active') == 1) {
            $request->validate([
                'g-recaptcha-response' => ['required', new CaptchaRule],
            ]);
        }

        if (Auth::guard('admin')->attempt($request->only('email', 'password'), $request->has('remember'))) {
            $user = Auth::guard('admin')->user();
            $valid = $user->two_factor_type;
            if ($valid != 'none') {
                setIsCodeUser::dispatchNow($user, false);
                return redirect(route('admin.validate'));

            } else {
                return redirect('wa-admin');
            }
        } else {
            flash(Lang::get('wrong username or password'))->error();

            return back();
        }
    }

    public function validateCode()
    {
        if (Auth::guard('admin')->user()->two_factor_type && Auth::guard('admin')->user()->two_factor_type != 'google') {
            Auth::guard('admin')->user()->notify(new SendLoginCodeNotification());
        }
        return view('auth.admin.register');
    }

    public function validateCodePost(Request $request)
    {
        $request->validate([
            'code' => 'required'
        ]);

        return $this->validateSms($request);

    }

    private function validateSms(Request $request)
    {
        $user = Auth::guard('admin')->user();
        $code = ValidCode::where('user_id', $user->id)->where('code', $request->code)->first();
        if (!$code) {
            flash(Lang::get('code is invalid').' '.Lang::get('code send'))->error()->important();

            return back();
        }

        $user->update([
            'is_code_set' => 1,
        ]);

        $code->delete();

        return redirect('wa-admin');
    }
}
