<?php

namespace App\Http\Controllers\admin;

use Ghanem\Rating\Models\Rating;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RateController extends Controller {

    public function index() {
        $rates = Rating::OrderByDesc( 'created_at' )->get();

        return view( 'admin.rate.rates' , compact( 'rates' ) );
    }

    public function action( $action , $id ) {
        $rate = Rating::find( $id );
        if ( $action == 'active' || $action == 'deactive' ) {
            $rate->status = $action;
            $rate->save();
        } elseif ( $action = 'remove' ) {
            $rate->delete();
        }

        return back();
    }
}
