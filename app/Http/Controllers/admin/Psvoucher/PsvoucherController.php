<?php

namespace App\Http\Controllers\admin\Psvoucher;

use anlutro\LaravelSettings\Facade as Setting;
use App\Events\PayOrder;
use App\Models\Cart\Card;
use App\Models\PsVoucher\Buy;
use App\Models\PsVoucher\Sell;
use App\Models\Webazin\Pay;
use App\Models\Webazin\PsVoucher\PsVoucher;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Larabookir\Gateway\Zarinpal\Zarinpal;

class PsvoucherController extends Controller {
    public function indexBuys() {
        $buys = Buy::all();

        return view( 'admin.psvoucher.buys' , compact( 'buys' ) );
    }


    public function indexSell() {
        $sells = Sell::all();

        return view( 'admin.psvoucher.sells' , compact( 'sells' ) );
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

    public function setManualVoucher( Request $request , $id ) {
        $request->validate( [
            'voucher_code' => 'required' ,
        ] );
        $buy = Buy::findOrFail( $id );
        $buy->update( $request->only( 'voucher_code' ) );
        flash( Lang::get('operation completed successfully') );

        return back();

    }
}
