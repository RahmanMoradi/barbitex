<?php

namespace App\Http\Controllers\Fcm;

use App\Http\Controllers\Controller;
use App\Models\Webazin\Fcm\Fcm;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;

class FcmController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'fcm_token' => 'required',
        ]);

        $check = Fcm::where('user_id', Auth::guard('admin-api')->check() ? Auth::guard('admin-api')->id() : Auth::guard('api')->id())->where('token', $request->fcm_token)->count();
        if ($check > 0) {
            return $this->response(0, [], [], Lang::get('the token has already been registered'));
        }
        Fcm::create([
            'user_id' => Auth::guard('admin-api')->check() ? Auth::guard('admin-api')->id() : Auth::guard('api')->id(),
            'token' => $request->fcm_token,
            'type' => Auth::guard('admin-api')->check() ? 'admin' : 'user',
            'device' => $request->has('device') ? $request->device : 'web',
        ]);

        return $this->response(1, [], [], Lang::get('operation completed successfully'));
    }
}
