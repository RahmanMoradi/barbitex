<?php

namespace App\Http\Controllers\panel\Authentication;

use App\Http\Controllers\Controller;

class AuthenticationController extends Controller
{
    public function index()
    {
        return view('panel.authentication.index');
    }
}
