<?php

namespace App\Http\Controllers\Api\V1\Vip;

use App\Http\Controllers\Controller;
use App\Http\Resources\ArticleResource;
use App\Http\Resources\CurrencyResource;
use App\Models\Article\Article;
use App\Models\Balance\Balance;
use App\Models\Currency\Currency;
use App\Models\vip\VipPackage;
use App\Models\vip\VipUsers;
use App\Models\Wallet;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;

class VipController extends Controller
{
    public function index(Request $request)
    {
        $articles = Article::query()->where('vip', 1)->orderByDesc('created_at');
        $per_page = $request->get('per_page') ? $request->get('per_page') : $this::PER_PAGE;
        $list = ArticleResource::collection($articles->paginate($per_page))->response()->getData(true);
        $data = $list['data'];
        $meta = $list['meta'];
        return $this->response(1, $data, $meta, Lang::get('vip content'));
    }

    public function packs()
    {
        $packs = VipPackage::all();
        return $this->response(1, $packs, [], Lang::get('vip packs'));

    }

    public function buy(Request $request)
    {
        $pack = VipPackage::find($request->pack_id);
        $vip = VipUsers::where('user_id', Auth::guard('api')->id())->first();
        if (Auth::guard('api')->user()->balance < $pack->price) {
            return $this->response(0, [], [], Lang::get('balance insufficient'));
        }
        Wallet::create([
            'admin_id' => 0,
            'user_id' => Auth::guard('api')->id(),
            'currency' => 'IRT',
            'price' => -$pack->price,
            'description' => Lang::get('credit deduction for purchasing vip pack'),
            'type' => 'decrement',
            'status' => 'done'
        ]);
        Balance::createUnique('IRT', Auth::guard('api')->user(), -$pack->price);
        if ($vip) {
            $days = optional(Auth::guard('api')->user()->vip)->expire_at > Carbon::now() ?
                Carbon::now()->diffInDays($vip->expire_at) : 0;

            $vip->update([
                'package_id' => $pack->id,
                'user_id' => Auth::guard('api')->id(),
                'expire_at' => $days > 0 ? Carbon::now()->addDays($days + $pack->days) : Carbon::now()->addDays($pack->days)
            ]);
        } else {
            VipUsers::create([
                'package_id' => $pack->id,
                'user_id' => Auth::guard('api')->id(),
                'expire_at' => Carbon::now()->addDays($pack->days),
                'start_at' => Carbon::now()
            ]);
        }
        return $this->response(1, [], [], Lang::get('operation completed successfully'));
    }
}
