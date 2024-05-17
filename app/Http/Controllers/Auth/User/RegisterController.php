<?php

namespace App\Http\Controllers\Auth\User;

use anlutro\LaravelSettings\Facade as Setting;
use App\Models\User;
use App\Http\Controllers\Controller;
use App\Models\User\ValidCode;
use App\Models\Vsms;
use App\Notifications\Admin\SendNotificationToAdmin;
use App\Notifications\User\SendLoginCodeNotification;
use App\Rules\IranMobile;
use App\Rules\IsNotPersian;
use Arcanedev\NoCaptcha\NoCaptchaV3;
use Arcanedev\NoCaptcha\Rules\CaptchaRule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use PragmaRX\Google2FA\Google2FA as Google2faVerify;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */


    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/panel';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('validateCode', 'validateCodePost');
    }

    public function validateCode()
    {
        if (Auth::user()->two_factor_type && Auth::user()->two_factor_type != 'google') {
            Auth::user()->notify(new SendLoginCodeNotification());
        }
        return view('auth.register');
    }

    public function validateCodePost(Request $request)
    {
        $request->validate([
            'code' => 'required'
        ]);
        if (Auth::user()->two_factor_type == 'sms' || Auth::user()->two_factor_type == 'email') {
            return $this->validateSms($request);
        } elseif (Auth::user()->two_factor_type == 'google') {
            return $this->valdateG2f($request);
        } elseif (Auth::user()->two_factor_type == 'none') {
            Auth::user()->update([
                'is_code_set' => 1
            ]);
            return redirect($this->redirectTo);
        }
    }

    private
    function valdateG2f(Request $request)
    {
        $user = Auth::user();

        // Enable Google2FA if Google Authenticator code matches secret
        $google2Fa = new Google2faVerify();
        $secret = $request->input('code');
        $valid = $google2Fa->verifyKey($user->google2fa_secret, $secret);
        // If Google2FA code is valid enable Google2FA
        if ($valid) {
            Auth::user()->update([
                'is_code_set' => 1
            ]);

            return redirect($this->redirectTo);
        } else {
            flash(Lang::get('the operation failed'))->error();

            return back();
        }
    }

    private
    function validateSms(Request $request)
    {
        $user = Auth::user();
        $code = ValidCode::where('user_id', $user->id)->first();

        if (!$code || $code->code != $request->code) {
            flash(Lang::get('code is invalid') . ' ' . Lang::get('code send'))->error()->important();

            return back();
        }
        $type = $user->two_factor_type;
        if ($type == 'email' || $type == 'none') {
            $user->markEmailAsVerified();
        } else if ($type == 'sms') {
            $user->markMobileAsVerified();
        }
        $user->update([
            'is_code_set' => 1,
        ]);

        $code->delete();

        return redirect($this->redirectTo);
    }

    public
    function register(Request $request)
    {
        $dataValidate = [
            'password' => ['required', 'string', 'min:6', 'confirmed'],
            'parent_id' => ['exists:users,id', 'nullable'],
            'terms' => ['accepted'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users']
        ];
        if (Setting::get('registerField') == 'mobile') {
            $dataValidate = $dataValidate + ['mobile' => ['required', 'unique:users', new IranMobile]];
        }
        $request->validate($dataValidate);

        if (Setting::get('NOCAPTCHA_Active') == 1) {
            $request->validate([
                'g-recaptcha-response' => ['required', new CaptchaRule],
            ]);
        }

        $user = $this->create($request->all());
        Auth::loginUsingId($user->id);
//        Notification::send(User::whereRole(2)->get(), (new SendNotificationToAdmin('userRegister', $user->name))->delay(now()->addSecond(10)));

        return redirect($this->redirectTo);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param array $data
     *
     * @return \App\User
     */
    protected
    function create(array $data)
    {
        return User::create([
            'parent_id' => $data['parent_id'] ?? null,
            'email' => $data['email'],
            'mobile' => $data['mobile'] ?? null,
            'name' => $data['name'] ?? null,
            'is_code_set' => 0,
            'two_factor_type' => Setting::get('registerField') == 'mobile' ? 'sms' : 'email',
            'api_token' => Str::random(60),
            'password' => Hash::make($data['password']),
        ]);
    }
}
