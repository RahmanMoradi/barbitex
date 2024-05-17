<?php

namespace App\Http\Controllers\Api\V2\Auth;

use anlutro\LaravelSettings\Facade as Setting;
use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Models\Ticket\Ticket;
use App\Models\Tiket;
use App\Models\User;
use App\Notifications\EmailSendLoginCodeNotification;
use App\Notifications\User\SendLoginCodeNotification;
use App\Rules\IranMobile;
use App\Rules\PasswordRule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class RegisterController extends Controller
{
    public function register(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
            'parent_id' => ['exists:users,id', 'nullable'],
        ]);
        if ($validate->fails()) {
            return $this->validateResponseFail($validate);
        }
        $user = $this->create($request->all());
        Auth::loginUsingId($user->id);
        $user->notify(new SendLoginCodeNotification());

        $message = Lang::get('you need validation to login') . ' ' . Lang::get('code send successfully', ['type' => 'email']);
        return $this->response(1, [[
            "id" => $user->id,
            "name" => null,
            "father_name" => null,
            "national_code" => '1',
            "user_name" => '1',
            "birthday" => null,
            "email" => null,
            "phone" => '1',
            "mobile" => null,
            "balance" => "",
            'type' => 'email',
            'api_token' => $user->api_token,
            'setting' => [
                'is_sms_login' => 1,
                'is_g2f_login' => 1,
                'notification_email' => 1,
                'notification_sms' => 1,
                'notification_app' => 1,
                'google2fa_secret' => 1,
                'status' => false,
                'phone_status' => 0,
                'mobile_status' => null,
                'doc_status' => -1,
                'doc_status_fa' => Lang::get('waiting for upload'),
                'doc_status_color' => 'red',
                'card_status' => false,
                'card_status_color' => 'red',
                'usd_price' => Setting::get('dollar_buy_pay'),
            ],
            'accountancy' => [
                'day_buy' => Helper::numberFormatPrecision($user->day_buy, 0),
                'max_buy' => Helper::numberFormatPrecision($user->max_buy, 0),
                'remaining' => Helper::numberFormatPrecision(($user->max_buy - $user->day_buy), 0),
            ],
            'info' => [
                'tickets' => [
                    'all' => Ticket::where('user_id', $user->id)->count(),
                    'open' => Ticket::where('user_id', $user->id)->where('status', 1)->count(),
                ]
            ]
        ]], [], $message, $valid = 'email');
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param array $data
     *
     * @return \App\User
     */
    protected function create(array $data)
    {
        return User::create([
            'parent_id' => isset($data['parent_id']) ? $data['parent_id'] : null,
            'email' => $data['email'],
            'is_code_set' => 0,
            'two_factor_type' => 'email',
            'api_token' => Str::random(60),
            'password' => Hash::make($data['password']),
        ]);
    }
}
