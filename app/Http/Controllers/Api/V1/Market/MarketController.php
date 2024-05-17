<?php

namespace App\Http\Controllers\Api\V1\Market;

use anlutro\LaravelSettings\Facade as Settings;
use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Http\Resources\MarketOrderResource;
use App\Http\Resources\MarketResource;
use App\Livewire\Market\Order;
use App\Models\Balance\Balance;
use App\Models\Currency\Currency;
use App\Models\Traid\Market\Market;
use App\Models\Traid\Market\MarketOrder;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Validator;

class MarketController extends Controller
{
    public function index(Request $request)
    {
        $markets = Market::query();
        if ($request->has('search') && $request->get('search') != '') {
            $request->merge([
                'page' => null
            ]);
            $markets = $this->filter($markets, $request->get('search'));
        }
        $markets->whereStatus('1')->orderBy('id');
        $per_page = $request->get('per_page') ? $request->get('per_page') : $this::PER_PAGE;
        $list = MarketResource::collection($markets->with(['currencyBuyer', 'currencySeller'])->paginate($per_page))->response()->getData(true);
        $data = $list['data'];
        $meta = $list['meta'];
        return $this->response(1, $data, $meta, Lang::get('markets lists'));
    }

    public function show($id)
    {
        $market = Market::find($id);
        if (!$market) {
            return $this->response(0, [], [], Lang::get('market not found'));
        }
        return $this->response(1, [new MarketResource($market)], [], Lang::get('market information'));
    }

    public function store(Request $request)
    {
        $request->merge([
            'orderType' => $request->has('order_type') ? $request->order_type : 'limit',
            'order_type' => $request->has('order_type') ? $request->order_type : 'limit'
        ]);
        if (!Auth::guard('api')->check() || !Auth::guard('api')->user()->isActive()) {
            return $this->response(0, [], [], Lang::get('you have not yet verified'));
        }
        $market = Market::findOrFail($request->market_id);

        $typeText = $request->type === 'sell' ? Lang::get('sell') : Lang::get('buy');
        $time = Carbon::now()->timestamp;
        if ($request->orderType == 'limit') {
            $sum = (float)$request->count * (float)$request->price;
        } else {
            $sum = $request->type == 'sell' ? $request->count : $request->sum;
        }
        if ($request->type == 'buy' || $request->orderType == 'limit') {
            $min = Settings::get('min_market_buy');
        } else {
            $min = Settings::get('min_market_buy') / optional($market->currencyBuyer)->price;
        }
        if ($sum < $min) {
            return $this->response(0, [], [], Lang::get('minimum amount of trading', ['amount' => $min, 'currency' => 'USDT']));
        }
        $data = [
            'count' => $request->count ?: 0,
            'price' => $request->price ?: 0,
            'typeText' => $typeText,
            'type' => $request->type,
            'time' => $time,
            'order_type' => $request->orderType,
            'orderType' => $request->orderType,
            'sum' => $sum
        ];
        $validate = Validator::make($data, [
            'count' => 'required_if:orderType,limit|numeric',
            'price' => 'required_if:orderType,limit|numeric',
            'typeText' => 'required',
            'type' => 'required|in:sell,buy',
            'orderType' => 'required|in:limit,market',
            'time' => 'required',
            'sum' => 'required_if:orderType,market|numeric'
//        'sum' => "numeric|between:10,100000"
        ]);
        if ($validate->fails()) {
            return $this->validateResponseFail($validate);
        }
        return $this->orderStore($request, $market);
    }

    private function orderStore(Request $request, Market $market)
    {
        $userId = Auth::guard('api')->id();

        $currencyOne = $request->type == 'buy' ? Currency::find($market->currency_sell) : Currency::find($market->currency_buy);
        $currencyTwo = $request->type == 'buy' ? Currency::find($market->currency_buy) : Currency::find($market->currency_sell);

        $count = Helper::numberFormatPrecision($request->count, $request->type == 'buy' ? $currencyTwo->decimal_size : $currencyOne->decimal_size);

        $request->merge([
            'count' => $count
        ]);
        $balanceOne = Balance::where('user_id', $userId)->where('currency', $currencyOne->symbol)->first();
        $balanceTwo = Balance::where('user_id', $userId)->where('currency', $currencyTwo->symbol)->first();

        if (!$balanceOne) {
            Balance::createUnique($currencyOne->symbol, User::find($userId), 0);
            $balanceOne = Balance::where('user_id', $userId)->where('currency', $currencyOne->symbol)->first();
        }
        if (!$balanceTwo) {
            Balance::createUnique($currencyTwo->symbol, User::find($userId), 0);
            $balanceTwo = Balance::where('user_id', $userId)->where('currency', $currencyTwo->symbol)->first();
        }
        if ($request->type == 'buy') {
            if ($balanceOne->balance_free < ($request->count * $request->price)) {
                return $this->response(0, [], [], Lang::get('balance insufficient'));
            }
        } else {
            if ($balanceOne->balance_free < $request->count) {
                return $this->response(0, [], [], Lang::get('balance insufficient'));
            }
        }

        if ($request->type == 'buy') {
            switch ($request->orderType) {
                case 'limit':
                    $count = ($request->count * $request->price);
                    break;
                case 'market':
                    $count = $request->sum;
                    break;
            }
            $balanceOne->update([
                'balance_use' => $balanceOne->balance_use + $count,
                'balance_free' => $balanceOne->balance_free - $count
            ]);
        } else {
            $balanceOne->update([
                'balance_use' => $balanceOne->balance_use + $request->count,
                'balance_free' => $balanceOne->balance_free - $request->count
            ]);
        }
        $marketOrder = $this->marketOrder($market, $request);

        if ($marketOrder) {
            if ($request->orderType == 'market' && $request->type == 'sell') {
                $request->merge([
                    'count' => $marketOrder['size']
                ]);
            }
            $order = MarketOrder::create([
                'market_id' => $market->id,
                'market_order_id' => $marketOrder['orderId'],
                'user_id' => $userId,
                'count' => $request->orderType == 'limit' || $request->type == 'sell' ? $request->count :
                    Helper::numberFormatPrecision(($request->sum / $marketOrder['price']), optional($market->currencyBuyer)->decimal),
                'remaining' => $request->orderType == 'limit' || $request->type == 'sell' ? $request->count :
                    Helper::numberFormatPrecision(($request->sum / $marketOrder['price']), optional($market->currencyBuyer)->decimal),
                'price' => $request->price ? $request->price : $marketOrder['price'],
                'sumPrice' => $request->orderType == 'limit' ? ($request->count * $request->price) : ($request->type == 'sell' ? ($request->count * $marketOrder['price']) : $request->sum),
                'type' => $request->type,
                'status' => 'init'
            ]);
//            $order = MarketOrder::create([
//                'market_id' => $market->id,
//                'market_order_id' => $marketOrder['orderId'],
//                'user_id' => $userId,
//                'count' => $request->count,
//                'remaining' => $request->count,
//                'price' => $request->price,
//                'sumPrice' => $request->count * $request->price,
//                'type' => $request->type,
//                'status' => 'init'
//            ]);
            return $this->response('1', new MarketOrderResource($order), [], Lang::get('your order has been successfully registered'));
        } else {
            if ($request->type == 'buy') {
                $balanceOne->update([
                    'balance_use' => $balanceOne->balance_use - ($request->count * $request->price),
                    'balance_free' => $balanceOne->balance_free + ($request->count * $request->price)
                ]);
            } else {
                $balanceOne->update([
                    'balance_use' => $balanceOne->balance_use - $request->count,
                    'balance_free' => $balanceOne->balance_free + $request->count
                ]);
            }
            return $this->response(0, [], [], Lang::get('the operation failed'));
        }
    }

    private function marketOrder(Market $market, Request $request)
    {
        switch ($request->orderType) {
            case 'limit':
                return $market->service()->createOrder($market->symbol, $request->count, $request->price, $request->type);
            case 'market':
                return $market->service()->createOrderMarket($market->symbol, $request->type == 'buy' ? $request->sum : $request->count, $request->type);
        }
    }

    public function openOrder($market_id, Request $request)
    {
        $per_page = $request->get('per_page') ? $request->get('per_page') : $this::PER_PAGE;

        $orders = MarketOrder::query();
        $orders = $this->orderFilter($orders, $request);
        $orders = $orders->where('status', 'init')
            ->where('user_id', Auth::guard('api')->id())
            ->orderByDesc('created_at');
        if ($market_id != '-1') {
            $orders = $orders->where('market_id', $market_id);
        }
        $list = MarketOrderResource::collection($orders->paginate($per_page))->response()->getData(true);
        $data = $list['data'];
        $meta = $list['meta'];
        return $this->response('1', $data, $meta, Lang::get('open order list'));
    }

    public function orders($market_id, Request $request)
    {
        $per_page = $request->get('per_page') ? $request->get('per_page') : $this::PER_PAGE;

        $orders = MarketOrder::query();
        $orders = $this->orderFilter($orders, $request);
        $orders = $orders->where('user_id', Auth::guard('api')->id())
            ->orderByDesc('created_at');
        if ($market_id != '-1') {
            $orders = $orders->where('market_id', $market_id);
        }
        $list = MarketOrderResource::collection($orders->paginate($per_page))->response()->getData(true);
        $data = $list['data'];
        $meta = $list['meta'];
        return $this->response('1', $data, $meta, Lang::get('list of market orders'));
    }

    private function filter(\Illuminate\Database\Eloquent\Builder $markets, $search)
    {
        return $markets->where('symbol', 'LIKE', '%' . $search . '%');
    }

    public function cancel($id)
    {
        $order = MarketOrder::findOrFail($id);
        if ($order->user_id != Auth::guard('api')->id()) {
            return $this->response(0, [], [], Lang::get('illegal access'));
        }

        if ($order->status == 'init' && $order->remaining > 0) {
//            TODO REMAINING
            if ($order->market->service()->cancelOrder($order)) {
                return $this->response(1, [], [], Lang::get('operation completed successfully'));
            } else {
                return $this->response(1, [], [], Lang::get('the operation failed'));
            }
        } else {
            return $this->response(1, [], [], Lang::get('it is not possible to delete this order'));
        }
    }

    private function orderFilter($orders, Request $request)
    {
        if ($request->has('market') && $request->market != '') {
            $orders = $orders->whereHas('market', function ($q) use ($request) {
                $q->where('symbol', 'LIKE', '%' . $request->market . '%');
            });
        }
        if ($request->has('type') && $request->type != '') {
            $orders = $orders->where('type', $request->type);
        }
        if ($request->has('status') && $request->status != '') {
            $orders = $orders->where('status', $request->status);
        }


        return $orders;
    }
}
