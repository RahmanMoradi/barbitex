<?php

namespace App\Http\Controllers\Api\V1\Wallet;

use anlutro\LaravelSettings\Facade as Setting;
use anlutro\LaravelSettings\Facade as Settings;
use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Http\Resources\BalanceResource;
use App\Http\Resources\WalletResource;
use App\Models\Balance\Balance;
use App\Models\Currency\Currency;
use App\Models\Network\Network;
use App\Models\Traid\Market\Market;
use App\Models\User;
use App\Models\Wallet;
use App\Models\Webazin\Binance\Facades\Binance;
use App\Models\Webazin\Kucoin\Facades\Kucoin;
use App\Notifications\Admin\SendNotificationToAdmin;
use http\Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Validator;
use Larabookir\Gateway\Exceptions\RetryException;
use Larabookir\Gateway\Gateway;

class WalletController extends Controller
{
    /**
     * @var mixed
     */
    public $sellQty;

    public function index(Request $request)
    {
        $per_page = $request->get('per_page') ? $request->get('per_page') : $this::PER_PAGE;
        $irt = new Currency();
        $irt->id = '-1';
        $irt->symbol = 'IRT';
        $irt->icon = 'images/iran.svg';
        $irt->decimal = '0';
        $irt->name = Lang::get('IRT');
        $irt->price = '0';
        $irt->receive_price = '0';
        $irt->irt_price = '0';
        $irt->send_price = '0';
        $irt->sum_buy = '0';
        $irt->sum_sell = '0';
        $irt->count = '0';
        $irt->position = 1;
        $irt->active = 1;
        if ($request->has('search') && $request->search != '') {
            $currencies = Currency::with('networks')->where('active', 1)
                ->where('name', 'LIKE', '%' . $request->search . '%')
                ->orWhere('symbol', 'LIKE', '%' . $request->search . '%')
                ->get();
            if ($request->search == Lang::get('IRT') || $request->search == 'IRT') {
                $currencies->prepend($irt);
            }
        } else {
            $currencies = Currency::with('networks')->where('active', 1)->get();
            $currencies->prepend($irt);
        }

        $balances = collect();
        $irtCount = '0';
        $usdCount = '0';
        foreach ($currencies as $currency) {
            $count = Balance::where('user_id', Auth::guard('api')->id())
                ->where('currency', $currency->symbol)
                ->first();
            if ($request->has('filter') && $request->get('filter') == 'count') {
                if ($count && Helper::numberFormatPrecision($count->balance, $currency->decimal) > 0) {
                    $balances->push([
                        'balance' => $count ? Helper::numberFormatPrecision($count->balance, $currency->decimal) : '0',
                        'balance_free' => $count ? Helper::numberFormatPrecision($count->balance_free, $currency->decimal) : '0',
                        'currency' => $currency,
                        'markets' => Market::where('currency_buy', $currency->id)->where('status', 1)->get()
                    ]);
                }
            } else {
                $balances->push([
                    'balance' => $count ? Helper::numberFormatPrecision($count->balance, $currency->decimal) : '0',
                    'balance_free' => $count ? Helper::numberFormatPrecision($count->balance_free, $currency->decimal) : '0',
                    'currency' => $currency,
                    'markets' => Market::where('currency_buy', $currency->id)->where('status', 1)->get()
                ]);
            }
            $irtCount += $currency->symbol == 'IRT' ?
                ($count ? Helper::numberFormatPrecision($count->balance_free, $currency->decimal) : '0') : ((($count ? Helper::numberFormatPrecision($count->balance_free, $currency->decimal) : '0') * $currency->price) * Setting::get('dollar_pay'));

            $usdCount += $currency->symbol == 'IRT' ?
                ($count ? Helper::numberFormatPrecision($count->balance_free, $currency->decimal) : '0') / Setting::get('dollar_pay') : ((($count ? Helper::numberFormatPrecision($count->balance_free, $currency->decimal) : '0') * $currency->price));
        }
        if ($request->has('page') && $request->get('page') > 1) {
            $assets = [];
        } else {
            $assets = $balances->all();
        }
        $list = BalanceResource::collection($assets)->response()->getData(true);
        $data = $list['data'];
//        $meta = $list['meta'];
        return $this->response(1, $data, [
            'irt' => number_format($irtCount, 0, '', ''),
            'usd' => $usdCount > 1 ? number_format($usdCount, 0, '', '') : '0'
        ], Lang::get('balances'));
    }

    //deposit

    public function deposit($symbol)
    {
        $currency = Currency::where('symbol', $symbol)->with('networks')->first();
        return $this->response(1, $currency, [], Lang::get('deposit'));
    }

    public function depositStore(Request $request, $currency)
    {
        if ($currency == 'IRT') {
            return $this->depositIRT($request);
        } else {
            return $this->depositCrypto($request, $currency);
        }
    }

    private function depositCrypto(Request $request, $currency)
    {
        $validate = Validator::make($request->all(), [
            'txid' => 'required'
        ]);
        if ($validate->fails()) {
            return $this->validateResponseFail($validate);
        }
        if (Helper::CheckTxidFromDb($request->txid)) {
            return $this->response(0, [], [], Lang::get('this transaction has already been registered'));
        }
        $dbCurrency = Currency::where('symbol', $currency)->first();
        $response = $dbCurrency->service()->checkDeposit($dbCurrency, $request->txid);
        if ($response['status'] == 1) {
            $amount = Helper::numberFormatPrecision($response['amount'], $dbCurrency->decimal);

            $wallet = Wallet::create([
                'user_id' => Auth::guard('api')->id(),
                'currency' => $currency,
                'price' => $amount,
                'type' => 'increment',
                'status' => Settings::get('autoDeposit') == '1' ? 'done' : 'new',
                'description' => $request->txid,
            ]);
            if (Settings::get('autoDeposit') == '1') {
                Balance::createUnique($currency, Auth::guard('api')->user(), $amount);
            }
            return $this->response(1, [], [], Lang::get('operation completed successfully'));
        } else {
            return $this->response(0, [], [], Lang::get('the transaction is invalid'));
        }
    }

    private function depositIRT(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'price' => 'required',
        ]);
        if ($validate->fails()) {
            return $this->validateResponseFail($validate);
        }

        $wallet = Wallet::create([
            'user_id' => Auth::guard('api')->id(),
            'currency' => 'IRT',
            'price' => $request->price,
            'type' => 'increment',
            'description' => $request->description,
            'status' => 'process'
        ]);
        try {
            $gateway = Gateway::make(Helper::get_defult_pay());
            $gateway->setCallback(route('api.wallet.callback', ['wallet' => $wallet, 'api_token' => Auth::guard('api')->user()->api_token]));
            $gateway->price((int)$request->price)->ready();
            $refId = $gateway->refId();
            $transID = $gateway->transactionId();

            return $this->response(1, [$gateway->getLink()], null, Lang::get('transfer to port'));
        } catch (Exception $e) {
            return $this->response(0, [], [], $e->getMessage());
        }
    }

    public function depositCallback(Wallet $wallet)
    {
        if ($wallet->user_id != Auth::guard('api')->id()) {
            return $this->response(0, [], [], Lang::get('illegal access'));
        }
        try {
            $gateway = Gateway::verify();
            $trackingCode = $gateway->trackingCode();
            $refId = $gateway->refId();
            $cardNumber = $gateway->cardNumber();
            $wallet->update([
                'status' => 'done'
            ]);
            Balance::createUnique('IRT', Auth::user(), $wallet->price);

//            Notification::send( User::whereRole( 2 )->get() , new SendNotificationToAdmin( 'orderCreate' , $order->id ) );
            return view('api.wallet.callback', compact('wallet'));
        } catch (\Exception $e) {
            $wallet->update([
                'status' => 'cancel'
            ]);
            return view('api.wallet.callback', compact('wallet'));
        } catch (RetryException $e) {
            return view('api.wallet.callback', compact('wallet'));
        }
    }

    //withdrawal

    public function withdrawalStore(Request $request, $currency)
    {
        if ($currency == 'IRT') {
            $validate = Validator::make($request->all(), [
                'price' => 'required|numeric|min:50000',
                'card_id' => 'required'
            ]);
            if ($validate->fails()) {
                return $this->validateResponseFail($validate);
            }
            return $this->withdrawalIrt($request);
        } else {
            $validate = Validator::make($request->all(), [
                'qty' => 'required',
                'wallet' => 'required',
                'network' => 'required',
//                'tag' => $this->getCurrency()->tag ? 'required' : 'nullable'
            ]);
            if ($validate->fails()) {
                return $this->validateResponseFail($validate);
            }
            return $this->withdrawalCrypto($request, $currency);
        }
    }

    public function history(Request $request)
    {
        $per_page = $request->get('per_page') ? $request->get('per_page') : $this::PER_PAGE;
        $wallets = Wallet::query();
        $wallets = $wallets->orderByDesc('updated_at');
        $wallets = $wallets->where('user_id', Auth::guard('api')->id());
        $wallets = $wallets->paginate($per_page);

        $list = WalletResource::collection($wallets)->response()->getData(true);
        $data = $list['data'];
        $meta = $list['meta'];
        return $this->response(1, $data, $meta, Lang::get('list of transactions'));
    }

    private function withdrawalIrt(Request $request)
    {
        $walletCount = Auth::guard('api')->user()->balance;
        if ($request->price > $walletCount) {
            return $this->response(0, [], [], Lang::get('balance insufficient'));
        }
        $wallet = Wallet::create([
            'user_id' => Auth::guard('api')->id(),
            'card_id' => $request->card_id,
            'currency' => 'IRT',
            'price' => -$request->price,
            'type' => 'decrement',
            'status' => 'new',
            'description' => $request->description
        ]);
        Balance::createUnique('IRT', User::find($wallet->user_id), $wallet->price);

//        Notification::send(User::whereRole(2)->get(), new SendNotificationToAdmin('walletDecrement', $wallet->price));

        return $this->response(1, [$wallet], null, Lang::get('your request has been successfully registered'));
    }

    private function withdrawalCrypto(Request $request, $currency)
    {
        $request->merge([
            'wallet' => $request->wallet
        ]);

        $walletCount = Balance::where('user_id', Auth::guard('api')->id())->where('currency', $currency)->first();
        $walletCount = $walletCount ? $walletCount->balance : 0;
        if ($request->qty > $walletCount) {
            return $this->response(0, [], [], Lang::get('site inventory is not enough'));
        }
        if ($request->qty == 0) {
            return $this->response(0, [], [], Lang::get('the requested amount must not be zero'));
        }
        $network = Network::where('coin', $currency)->where('network', $request->network)->first();
        if ($request->qty < $network->withdrawMin) {
            return $this->response(0, [], [], Lang::get('min in network', ['name' => $network->coin, 'network' => $network->network]));
        }
        if ($network->tag) {
//            $validate = Validator::make($request->all(), [
//                'tag' => 'required'
//            ]);
//            if ($validate->fails()) {
//                return $this->validateResponseFail($validate);
//            }
        }
        try {
            $wallet = Wallet::create([
                'user_id' => Auth::guard('api')->id(),
                'network_id' => $network->id,
                'currency' => $currency,
                'price' => -$request->qty,
                'type' => 'decrement',
                'status' => Settings::get('autoWithdraw') == '1' ? 'done' : 'new',
                'wallet' => $request->wallet,
                'tag' => $request->tag,
                'description' => $request->decsription
            ]);
            Balance::createUnique($currency, Auth::guard('api')->user(), -$request->qty);
            if (Settings::get('autoWithdraw') == '1') {
                $this->withdrawFromMarket($wallet);
            }
        } catch (\Exception $exception) {
            return $this->response(0, [], [], Lang::get('the operation failed'));
        }
        return $this->response(1, [], [], Lang::get('withdrawal request was registered', ['id' => $wallet->id]));
    }

    private function withdrawFromMarket(Wallet $wallet)
    {
        $wallet->update([
            'admin_id' => 0
        ]);
        $wallet->currencyRelation->service()->withdraw($wallet);
    }
}
