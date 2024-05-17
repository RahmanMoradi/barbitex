<?php

namespace App\Http\Controllers\Admin\Webmoney;

use anlutro\LaravelSettings\Facade as Setting;
use App\Models\Webmoney\Buy;
use App\Models\Webmoney\Sell;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Larabookir\Gateway\Zarinpal\Zarinpal;

class WebmoneyController extends Controller {
    public function indexBuys() {
        $buys = Buy::orderByDesc('created_at')->get();

        return view( 'admin.webmoney.buys' , compact( 'buys' ) );
    }


    public function indexSell() {
        $sells = Sell::orderByDesc('created_at')->get();

        return view( 'admin.webmoney.sells' , compact( 'sells' ) );
    }

    public function pay( Request $request , $id ) {
        $request->validate( [
            'tracking_code' => 'required'
        ] );

        $sell = Sell::findOrFail( $id );
        $sell->update( [
            'tracking_code' => $request->input( 'tracking_code' ) ,
            'status'        => 'pay'
        ] );

        return back();
    }
}
