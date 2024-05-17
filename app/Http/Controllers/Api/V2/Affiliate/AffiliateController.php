<?php

namespace App\Http\Controllers\Api\V2\Affiliate;

use App\Http\Controllers\Controller;
use App\Http\Resources\AffiliateResource;
use App\Models\Order\Order;
use App\Models\User;
use App\Models\Wallet;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;

class AffiliateController extends Controller
{
    public function index()
    {
        $referrals = User::where('parent_id', Auth::guard('api')->id())->get();
        $referralsCount = $referrals->count();
        $orders = Order::whereIn('user_id', $referrals->pluck('id'))->where('status', 'done')->get();
        $commissions = Wallet::where('user_id', Auth::guard('api')->id())->where('description', 'LIKE', '%'.Lang::get('commission').'%')->sum('price');
        $commissionsAverage = Wallet::where('user_id', Auth::guard('api')->id())->where('description', 'LIKE', '%'.Lang::get('commission').'%')->avg('price');

        $collect = new Collection([
            'code' => Auth::guard('api')->id(),
            'referrals' => $referrals,
            'referralsCount' => $referralsCount,
            'orders' => $orders,
            'commissions' => $commissions,
            'commissionsAverage' => $commissionsAverage,
        ]);

        return $this->response(1, new AffiliateResource($collect), [], Lang::get('subcategories'));
    }
}
