<?php

namespace App\Http\Controllers\Api\V2\Auth;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Jobs\User\Login\setIsCodeUser;
use App\Models\User;
use App\Models\User\ValidCode;
use App\Notifications\User\SendLoginCodeNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Lang;

class ForgetController extends Controller
{
    public function forget(Request $request)
    {
        $user = User::whereEmail($request->email)->first();
        if (!$user) {
            return $this->response(0, [], [], Lang::get('user not found'));
        }
        setIsCodeUser::dispatchNow($user, false);
        Auth::login($user);
        if ($request->has('level') && $request->level == 2) {
            $request->validate([
                'code' => 'required|numeric',
                'password' => 'required|confirmed',
                'email' => 'required',
            ]);

            $vsms = ValidCode::whereCode($request->input('code'))->where('user_id', Auth::id())->first();
            if (!$vsms) {
                return $this->response(0, [], [], Lang::get('code is invalid'));
            } else {
                $vsms->delete();
                $user->update([
                    'password' => Hash::make($request->input('password'))
                ]);

                return $this->response(1, [], [], Lang::get('operation completed successfully'));
            }
        } else {
            $request->validate([
                'email' => 'required|exists:users,email'
            ]);

            Auth::user()->notify(new SendLoginCodeNotification('email'));
            $email = $user->email;
            return $this->response(1, [
                'email' => $email
            ], [], Lang::get('code send successfully', ['type' => 'email']));
        }
    }
}
