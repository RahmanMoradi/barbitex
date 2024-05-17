<?php

namespace App\Http\Controllers\Api\V1\User;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;

class UserController extends Controller
{
    public function show()
    {
        return $this->response(1, [new UserResource(\Auth::guard('api')->user())], [], Lang::get('user information'));
    }
}
