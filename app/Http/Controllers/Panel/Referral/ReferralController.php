<?php

namespace App\Http\Controllers\Panel\Referral;

use App\Http\Controllers\Controller;
use App\Models\Traid\Market\MarketOrder;
use App\Models\User;
use App\Models\Wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;

class ReferralController extends Controller {
    public function index() {
        $referrals          = User::where( 'parent_id' , Auth::id() )->get();
        $referralsCount     = $referrals->count();
        $orders             = MarketOrder::whereIn( 'user_id' , $referrals->pluck( 'id' ) )->where( 'status' , 'success' )->get();
        $commissions        = Wallet::whereIn( 'user_id' , $referrals->pluck( 'id' ) )->where( 'description' , 'LIKE' , '%'.Lang::get('commission').'%' )->sum( 'price' );
        $commissionsAverage = Wallet::whereIn( 'user_id' , $referrals->pluck( 'id' ) )->where( 'description' , 'LIKE' , '%'.Lang::get('commission').'%' )->avg( 'price' );

        return view( 'panel.referral.index' , compact( 'referrals' , 'referralsCount' , 'orders' , 'commissions' , 'commissionsAverage' ) );
    }
}
