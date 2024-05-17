<?php

namespace App\Http\Controllers\Api\V1\Authentication;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Models\User\UserDocument;
use App\Models\User\ValidCode;
use App\Models\UserDoc;
use App\Models\Vsms;
use App\Notifications\Admin\SendNotificationToAdmin;
use App\Rules\IranMobile;
use App\Rules\IsNotPersian;
use App\Rules\NationalCode;
use App\Rules\PasswordRule;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use PragmaRX\Google2FA\Google2FA as Google2faVerify;
use webazin\KaveNegar\KavenegarApi;

class AuthenticationController extends Controller
{
    public function profile(Request $request)
    {

        $validate = Validator::make($request->all(), [
            'name' => 'required',
            'national_code' => ['required', new NationalCode, 'unique:users,national_code,' . Auth::guard('api')->id()],
            'birthday' => 'required',
            'doc' => 'required|image',
        ]);
        if ($validate->fails()) {
            return $this->validateResponseFail($validate);
        }
        $user = Auth::guard('api')->user();
        if ($user->docs && $user->docs->status == 'new') {
            return $this->response(0, [], [], Lang::get('you have already submitted your documents, wait for confirmation'));
        }
        if ($user->docs && $user->docs->status == 'accept') {
            return $this->response(0, [], [], Lang::get('you have already submitted your documents and your document has been verified'));
        }
        if ($user->docs) {
            Storage::disk('public')->delete($user->docs->title);
            $user->docs->update([
                'title' => $this->uploadFile('docs/image/', $request->doc),
                'status' => 'new'
            ]);
        } else {
            UserDocument::create([
                'user_id' => $user->id,
                'title' => $this->uploadFile('docs/image/', $request->doc)
            ]);
        }
        $user->update($request->only('national_code', 'birthday', 'name'));

//        Notification::send(User::whereRole(2)->get(), (new SendNotificationToAdmin('authImageStore'))->delay(now()->addSecond(3)));
        return $this->response(1, [new UserResource($user)], [], Lang::get('operation completed successfully'));
    }

    public function password(Request $request)
    {

        $validate = Validator::make($request->all(), [
            'old_password' => 'required',
            'password' => ['required', 'min:6', 'confirmed'],
        ]);
        if ($validate->fails()) {
            return $this->validateResponseFail($validate);
        }
        $user = Auth::guard('api')->user();
        if (Hash::check($request->old_password, $user->password)) {
            $user->update([
                'password' => Hash::make($request->password)
            ]);

            return $this->response(1, [new  UserResource($user)], [], Lang::get('operation completed successfully'));
        } else {
            return $this->response(0, [], [], Lang::get('old password incorrect'));
        }
    }

    public function smsLoginStatus(Request $request)
    {
        if (Auth::user()->two_factor_type == 'google') {
            return $this->response(0, [], [], Lang::get('disable tow-factor google authenticator'));
        }
        $request->validate([
            'status' => 'required|in:0,1'
        ]);
        Auth::guard('api')->user()->update([
            'two_factor_type' => $request->status ? 'sms' : 'none',
        ]);

        return $this->response(1, [new  UserResource(Auth::guard('api')->user())], [], Lang::get('operation completed successfully'));
    }

    public function emailLoginStatus(Request $request)
    {
        if (Auth::user()->two_factor_type == 'google') {
            return $this->response(0, [], [], Lang::get('disable tow-factor google authenticator'));
        }
        $request->validate([
            'status' => 'required|in:0,1'
        ]);
        Auth::guard('api')->user()->update([
            'two_factor_type' => $request->status ? 'email' : 'none',
        ]);

        return $this->response(1, [new  UserResource(Auth::guard('api')->user())], [], Lang::get('operation completed successfully'));
    }

    public function g2fLoginStatus(Request $request)
    {
        $request->validate([
            'status' => 'required|in:0,1',
            'code' => 'required'
        ]);
        $user = Auth::guard('api')->user();
        $google2Fa = new Google2faVerify();
        $secret = $request->input('code');
        $valid = $google2Fa->verifyKey($user->google2fa_secret, $secret);
        // If Google2FA code is valid enable Google2FA
        if ($valid) {
            Auth::guard('api')->user()->update([
                'two_factor_type' => $request->status ? 'google' : 'none',
            ]);

            return $this->response(1, [new UserResource($user)], null, Lang::get('operation completed successfully'));
        } else {
            return $this->response(0, [new UserResource($user)], null, Lang::get('code is invalid'));
        }
    }

    public function sendCode(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'mobile' => ['required', Rule::unique('users')->ignore(Auth::guard('api')->id()), new IranMobile]
        ]);

        if ($validate->fails()) {
            return $this->validateResponseFail($validate);
        }

        $check = ValidCode::where('user_id', Auth::guard('api')->id())->count();
        if ($check > 0) {
            return $this->response(0, [], [], Lang::get('you have just requested a code'));
        } else {
            Auth::guard('api')->user()->update([
                'mobile' => $request->mobile,
            ]);
            Auth::guard('api')->user()->sendMobileVerificationNotification();

            return $this->response(1, [], [], Lang::get('code send'));
        }
    }

    public function validateCode(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'code' => ['required', new IsNotPersian]
        ]);

        if ($validate->fails()) {
            return $this->validateResponseFail($validate);
        }

        $check = ValidCode::where('user_id', Auth::guard('api')->id())->where('code', $request->code)->where('type', 'sms')->first();
        if ($check) {
            Auth::guard('api')->user()->markMobileAsVerified();

            return $this->response(1, [], [], Lang::get('your mobile number has been confirmed'));
            $check->delete();
        } else {
            return $this->response(0, [], [], Lang::get('code is invalid'));
        }
    }
}
