<?php

namespace App\Http\Controllers\admin;

use App\Currency;
use App\Http\Controllers\Controller;
use App\Models\DigitalCurrency\DigitalOrder;
use App\Models\DigitalCurrency\DigitalSell;
use App\Models\Order;
use App\Post;
use http\Exception;
use Illuminate\Http\Request;

use webazin\KaveNegar\SMS;

class OrderController extends Controller
{


    public function index()
    {
        return view('admin.orders.index');
    }
}
