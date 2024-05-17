<?php

namespace App\Http\Controllers\admin\Prefect;

use App\Events\PayOrder;
use App\Http\Controllers\Controller;
use App\Models\Cart\Card;
use App\Models\Prefect\Buy;
use App\Models\Prefect\Sell;
use App\Models\Webazin\Pay;
use App\Models\Webazin\PrefectMoney\PerefectMoney;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Larabookir\Gateway\Zarinpal\Zarinpal;
use anlutro\LaravelSettings\Facade as Setting;

class PrefectController extends Controller {


    public function indexBuys() {
        $buys = Buy::all();

        return view( 'admin.prefect.buys' , compact( 'buys' ) );
    }

    public function indexSell() {
        $sells = Sell::all();

        return view( 'admin.prefect.sells' , compact( 'sells' ) );
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
            'voucher_number'        => 'required' ,
            'active_voucher_number' => 'required'
        ] );
        $buy = Buy::findOrFail( $id );
        $buy->update( $request->only( 'voucher_number' , 'active_voucher_number' ) );
        flash( Lang::get('operation completed successfully') );

        return back();

    }

    public function setDescription( Request $request , $id ) {
        $request->validate( [
            'description' => 'required' ,
        ] );
        $buy = Buy::findOrFail( $id );
        $buy->update( $request->only( 'description' ) );
        flash( Lang::get('operation completed successfully') );

        return back();
    }
}
