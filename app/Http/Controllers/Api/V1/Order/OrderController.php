<?php

namespace App\Http\Controllers\Api\V1\Order;

use anlutro\LaravelSettings\Facade as Setting;
use anlutro\LaravelSettings\Facade as Settings;
use App\Helpers\Helper;
use App\Http\Resources\CardResource;
use App\Http\Resources\OrderResource;
use App\Models\Balance\Balance;
use App\Models\Currency\Currency;
use App\Models\Order\Order;
use App\Models\Wallet;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{

    public function index(Request $request)
    {
        $per_page = $request->get('per_page') ? $request->get('per_page') : $this::PER_PAGE;
        $user_id = Auth::guard('api')->id();
        $orders = Order::query();
        $orders = $this->filter($orders, $request);
        $orders = $orders->where('user_id', $user_id)->orderby('created_at', 'desc');

        $list = OrderResource::collection($orders->paginate($per_page))->response()->getData(true);
        $data = $list['data'];
        $meta = $list['meta'];

        return $this->response(1, $data, $meta, Lang::get('list orders'));

    }

    public function show($id)
    {
        $order = Order::where('user_id', Auth::guard('api')->id())->findOrFail($id);
        return $this->response(1, [new OrderResource($order)], null, Lang::get('order information'));
    }

    public function store(Request $request)
    {
        $currency = Currency::findOrFail($request->currency_id);
        if ($currency->active)
        $this->calculateBalance($request, $currency);
        $this->validateMyForm($request, $currency);

        $minBalance = $request->type == 'buy' ? $request->price : $request->qty;
        $minPrice = $request->type == 'buy' ? Setting::get('min_buy') : Setting::get('min_sell');
        $maxPrice = $request->type == 'buy' ? \Auth::guard('api')->user()->max_buy : 99999999999;
        $validate = Validator::make($request->all(), [
            'type' => 'required|in:buy,sell',
            'currency_id' => 'required|numeric',
            'qty' => 'required|numeric',
            'price' => "required|numeric|between:$minPrice,$maxPrice",
            'balance' => "required|numeric|min:$minBalance",
        ]);
        if ($validate->fails()) {
            return $this->validateResponseFail($validate);
        }
        $this->decrementBalance($request, $currency);
        $order = $this->createOrder($request, $currency);
        $this->incrementBalance($request, $order, $currency);
        if ($currency->symbol != 'USDT') {
            $currency->service()->tradToCurrency($order);
        }
        return $this->response(1, [new OrderResource($order)], null, Lang::get('your order has been successfully registered'));
    }

    private function validateMyForm(Request $request, $currency)
    {
        if ($currency->symbol != 'USDT') {
            $currency->service()->getLastPrice($currency);
            $currency = Currency::where('symbol', $currency->symbol)->first();
        }
        $request->merge([
            'qty' => Helper::numberFormatPrecision($request->qty, $currency->decimal_size),
        ]);
        $price = (float)$request->qty * ($request->type == 'buy' ? (float)$currency->send_price : (float)$currency->receive_price);

        $request->merge([
            'price' => Helper::numberFormatPrecision($price, 0),
            'usdt_price' => $request->type == 'buy' ? Setting::get('dollar_buy_pay') : Setting::get('dollar_sell_pay'),
        ]);
    }

    private function decrementBalance(Request $request, $currency)
    {
        $typeTxt = $request->type == 'buy' ? Lang::get('buy') : Lang::get('sell');
        Wallet::create(
            [
                'user_id' => Auth::guard('api')->id(),
                'currency' => $request->type == 'sell' ? $currency->symbol : 'IRT',
                'price' => $request->type == 'sell' ? $request->qty : $request->price,
                'wallet' => 'global_wallet',
                'description' => Lang::get('withdrawal for order', ['type' => $typeTxt]),
                'type' => 'decrement',
                'status' => 'done'
            ]
        );
        Balance::createUnique($request->type == 'buy' ? 'IRT' :
            $currency->symbol, Auth::guard('api')->user(),
            $request->type == 'buy' ? -$request->price : -$request->qty);
    }

    private function calculateBalance(Request $request, $currency)
    {
        $balanceCurrency = Balance::where('user_id', \Auth::guard('api')->id())->where('currency', $request->type == 'buy' ? 'IRT' : $currency->symbol)->first();
        if (!$balanceCurrency) {
            Balance::createUnique($request->type == 'buy' ? 'IRT' : $currency->symbol, \Auth::guard('api')->user(), 0);
            $balanceCurrency = Balance::where('user_id', \Auth::guard('api')->id())->where('currency', $request->type == 'buy' ? 'IRT' : $currency->symbol)->first();
        }
        $request->merge([
            'balance' => $balanceCurrency->balance_free
        ]);
    }

    private function createOrder(Request $request, $currency)
    {
        try {
            $data = [
                'currency_id' => $currency->id,
                'user_id' => Auth::guard('api')->id(),
                'type' => $request->type,
                'qty' => $request->qty,
                'price' => $request->price,
                'usdt_price' => $request->usdt_price,
            ];
            return Order::create($data);
        } catch (Exception $exception) {
            flash(Lang::get('the operation failed'))->error()->livewire($this);
        }
    }

    private function incrementBalance(Request $request, $order, $currency)
    {
        Wallet::create(
            [
                'user_id' => \Auth::guard('api')->id(),
                'currency' => $request->type == 'buy' ? $currency->symbol : 'IRT',
                'price' => $request->type == 'buy' ? $request->qty : $request->price,
                'wallet' => 'global_wallet',
                'description' => Lang::get('deposit for order number', ['orderId' => $order->id]),
                'type' => 'increment',
                'status' => Settings::get('autoDeposit') == '1' ? 'done' : 'new',
            ]
        );
        if (Settings::get('autoDeposit') == '1') {
            Balance::createUnique($request->type == 'buy' ? $currency->symbol : 'IRT',
                Auth::user(), $request->type == 'buy' ? $request->qty : $request->price);
        }
        $order->update([
            'status' => 'done'
        ]);
    }

    private function filter($orders, Request $request)
    {
        if ($request->has('currency') && $request->currency != '') {
            $orders = $orders->whereHas('currency', function ($q) use ($request) {
                $q->where('symbol', 'LIKE', '%' . $request->currency . '%');
                $q->orWhere('name', 'LIKE', '%' . $request->currency . '%');
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
