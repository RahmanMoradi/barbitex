<?php

namespace App\Services\InterFaceService;

use App\Models\Currency\Currency;
use App\Models\Order\Order;
use App\Models\Traid\Market\MarketOrder;
use App\Models\Wallet;

interface Withdrawal
{
    public static function withdraw(Wallet $wallet);

    public static function checkDeposit(Currency $currency, $txid);

    public function createOrder($symbol, $count, $price, $type);

    public function createOrderMarket($symbol, $funds, $type);

    public function createNetworkList(Currency $currency);

    public function tradToCurrency(Order $order);

    public function getLastPrice(Currency $currency);

    public function cancelOrder(MarketOrder $order);

    public function checkActive(MarketOrder $order);

    public function burnTxids(Currency $currency);

    public function setTxid(Wallet $wallet);
}
