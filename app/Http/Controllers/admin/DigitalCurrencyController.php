<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\DigitalCurrency\DigitalCurrency;
use Illuminate\Http\Request;

class DigitalCurrencyController extends Controller {
    public function index() {
        $digitalCurrencies = DigitalCurrency::all();

        return view( 'admin.currency.digital.index' , compact( 'digitalCurrencies' ) );
    }

    public function edit( DigitalCurrency $currency ) {
        return view( 'admin.currency.digital.edit' , compact( 'currency' ) );
    }

    public function update( DigitalCurrency $currency , Request $request ) {
        $request->validate( [
            'wage'       => 'required' ,
            'buy_price'  => 'required' ,
            'sell_price' => 'required' ,
        ] );
        $currency->update( $request->only( 'wage' , 'buy_price' , 'sell_price' ,'balance', 'description_buy' , 'description_sell' ) );

        $currency->update([
            'active' => $request->has('active') && $request->active == 'on'
        ]);

        foreach ( $currency->options as $option ) {
            $option->update( [
                'value' => $request->get( $option->id )
            ] );
        }
        flash( Lang::get('operation completed successfully') )->success();

        return back();
    }
}
