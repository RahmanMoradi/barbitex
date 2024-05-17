<?php

namespace App\Http\Controllers\Api\V1\Auth;

use anlutro\LaravelSettings\Facade as Setting;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Jobs\User\Login\setIsCodeUser;
use App\Models\Ticket\Ticket;
use App\Models\User\ValidCode;
use App\Notifications\User\SendLoginCodeNotification;
use App\Rules\IranMobile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use PragmaRX\Google2FA\Google2FA as Google2faVerify;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $emailLogin = 0;
        if (filter_var($request->email, FILTER_VALIDATE_EMAIL)) {
            $emailLogin = 1;
        }

        if ($emailLogin == 1) {
            $validate = Validator::make($request->all(), [
                'email' => ['required', 'email', 'exists:users,email'],
                'password' => 'required',
            ]);
            $condition = [
                'email' => $request->email,
                'password' => $request->password
            ];
        } else {
            $validate = Validator::make($request->all(), [
                'email' => ['required', new IranMobile, 'exists:users,mobile'],
                'password' => 'required',
            ]);
            $condition = [
                'mobile' => $request->email,
                'password' => $request->password
            ];
        }

        if ($validate->fails()) {
            return $this->validateResponseFail($validate);
        }
        if (Auth::attempt($condition, $request->has('remember'))) {
            $user = Auth::user();
            $user->update([
//                'api_token' => Str::random(60)
            ]);
            $valid = $user->two_factor_type;
            if ($user->two_factor_type && $user->two_factor_type != 'google') {
                setIsCodeUser::dispatchNow($user, false);
                $user->notify(new SendLoginCodeNotification());
            }
            if ($valid != 'none') {
                $message = Lang::get('you need validation to login');
                $valid == 'sms' ? $message .= Lang::get('code send successfully', ['type' => Lang::get('sms')]) :
                    ($valid == 'email' ? $message .= Lang::get('code send successfully', ['type' => Lang::get('email')]) : Lang::get('enter google authenticator code'));

                return $this->response(1, [new UserResource($user)], [],
                    $message, $valid);
            } else {
                return $this->response(1, [new UserResource($user)], [], Lang::get('operation completed successfully'), $valid);
            }
        } else {
            return $this->response(0, [], [], Lang::get('wrong username or password'));
        }
    }

    public function validateCode(Request $request)
    {
        $request->merge([
            'type' => Auth::guard('api')->user()->two_factor_type
        ]);
        switch ($request->get('type')) {
            case 'google':
                $validate = Validator::make($request->all(), [
                    'code' => 'required'
                ]);
                if ($validate->fails()) {
                    return $this->validateResponseFail($validate);
                }
                return $this->valdateG2f($request);
            case 'email':
                $validate = Validator::make($request->all(), [
                    'code' => 'required|exists:valid_codes,code'
                ]);
                if ($validate->fails()) {
                    return $this->validateResponseFail($validate);
                }
                $this->checkValidate($request);
                return $this->validateEmail($request);
            case 'sms':
                $validate = Validator::make($request->all(), [
                    'code' => 'required|exists:valid_codes,code'
                ]);
                if ($validate->fails()) {
                    return $this->validateResponseFail($validate);
                }
                $this->checkValidate($request);
                return $this->validateSms($request);
            case 'none':
                return $this->response(1, [new UserResource(Auth::guard('api')->user())], [], Lang::get('operation completed successfully'));
        }
    }

    private function valdateG2f(Request $request)
    {
        $user = Auth::guard('api')->user();

        // Enable Google2FA if Google Authenticator code matches secret
        $google2Fa = new Google2faVerify();
        $secret = $request->input('code');
        $valid = $google2Fa->verifyKey($user->google2fa_secret, $secret);
        // If Google2FA code is valid enable Google2FA
        if ($valid) {
            Auth::guard('api')->user()->update([
                'is_code_set' => 1
            ]);

            return $this->response(1, [new UserResource(Auth::guard('api')->user())], [], Lang::get('operation completed successfully'));
        } else {
            return $this->response(0, [], [], Lang::get('code is invalid'));
        }
    }

    private function validateSms(Request $request)
    {
        Auth::guard('api')->user()->markMobileAsVerified();

        return $this->response(1, [new UserResource(Auth::guard('api')->user())], [], Lang::get('operation completed successfully'));
    }

    private function validateEmail(Request $request)
    {
        Auth::guard('api')->user()->markEmailAsVerified();

        return $this->response(1, [new UserResource(Auth::guard('api')->user())], [], Lang::get('operation completed successfully'));
    }

    private function checkValidate(Request $request)
    {
        $code = ValidCode::where('user_id', Auth::guard('api')->id())->where('code', $request->code)->first();
        if (!$code) {
            return $this->response(0, [], [], Lang::get('code is invalid'));
        }
        Auth::guard('api')->user()->update([
            'is_code_set' => 1,
        ]);
    }
}
