<?php

namespace App\Models\Webazin\Kucoin;

use KuCoin\SDK\Auth;
use KuCoin\SDK\PrivateApi\Account;
use KuCoin\SDK\PrivateApi\Deposit;
use KuCoin\SDK\PrivateApi\Order;
use KuCoin\SDK\PrivateApi\TradeFee;
use KuCoin\SDK\PrivateApi\WebSocketFeed;
use KuCoin\SDK\PrivateApi\Withdrawal;
use KuCoin\SDK\PublicApi\Currency;
use KuCoin\SDK\PublicApi\Symbol;
use Ratchet\Client\WebSocket;
use React\EventLoop\LoopInterface;

class Kucoin
{
    private $auth, $account, $deposit, $symbol, $currency, $withdrawal, $tradeFee, $order;

    public function __construct()
    {
        $this->auth = new Auth(
            config('webazin.kucoin.api_key'),
            config('webazin.kucoin.secret_key'),
            config('webazin.kucoin.password'),
            Auth::API_KEY_VERSION_V2);
    }

    public function websocket()
    {
        $api = new WebSocketFeed($this->auth);
        $query = ['connectId' => uniqid('', true)];
        $channels = [
            ['topic' => '/market/ticker:KCS-BTC'], // Subscribe multiple channels
            ['topic' => '/market/ticker:ETH-BTC'],
        ];

        $api->subscribePublicChannels($query, $channels, function (array $message, WebSocket $ws, LoopInterface $loop) use ($api) {
            var_dump($message);

            // Unsubscribe the channel
            // $ws->send(json_encode($api->createUnsubscribeMessage('/market/ticker:ETH-BTC')));

            // Stop loop
//             $loop->stop();
        }, function ($code, $reason) {
            echo "OnClose: {$code} {$reason}\n";
        });
    }

    public function account()
    {
        $this->account = new Account($this->auth);
        return $this->account;
    }

    public function deposit()
    {
        $this->deposit = new Deposit($this->auth);
        return $this->deposit;
    }

    public function symbol()
    {
        $this->symbol = new Symbol();
        return $this->symbol;
    }

    public function currency()
    {
        $this->currency = new Currency();
        return $this->currency;
    }

    public function withdrawal()
    {
        $this->withdrawal = new Withdrawal($this->auth);
        return $this->withdrawal;
    }

    public function tradeFee()
    {
        $this->tradeFee = new TradeFee($this->auth);
        return $this->tradeFee;
    }

    public function order()
    {
        $this->order = new Order($this->auth);
        return $this->order;
    }
}
