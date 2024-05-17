<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MarketController extends Controller
{
    public function index()
    {
        return view('admin.market.index');
    }

    public function commission()
    {
        return view('admin.market.commission');
    }
}
