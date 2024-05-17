<?php

namespace App\Events\Market;

use App\Helpers\Helper;
use App\Models\Balance\Balance;
use App\Models\Currency\Currency;
use App\Models\Traid\Market\Market;
use App\Models\Traid\Market\MarketOrder;
use App\Models\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class BalanceUpdateEvent implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    private $market, $userId, $balanceOne, $balanceTwo, $currency, $currencyModel, $isWallet = false;

    /**
     * Create a new event instance.
     *
     * @param Market|null $market
     * @param null $currency
     * @param $userId
     */
    public function __construct($userId, Market $market = null, $currency = null)
    {
        if ($currency) {
            if (Helper::modules()['api_version'] === 2) {
                $currency = Currency::where('symbol', $currency)->first();
            }else{
                if ($currency == 'IRT') {
                    $currency = [
                        'symbol' => 'IRT',
                        'decimal' => 0,
                        'receive_price' => '0',
                        'irt_price' => '0',
                        'send_price' => '0',
                    ];
                } else {
                    $currency = Currency::where('symbol', $currency)->first();
                }
            }
            $this->currencyModel = $currency;
            $this->currency = isset($currency->symbol) ? $currency->symbol : $currency['symbol'];
        }
        if ($market === null) {
            $this->isWallet = true;
            if ($this->currencyModel) {
                $this->market = Market::where('currency_sell', $this->currencyModel->id)
                    ->orWhere('currency_buy', $this->currencyModel->id)
                    ->first();
            } else {
                $this->market = null;
            }
        } else {
            $this->market = $market;
        }
        $balanceOne = Balance::where('user_id', $userId)->where('currency', $market ? optional($market->currencyBuyer)->symbol : $this->currency)->first();
        $balanceTwo = Balance::where('user_id', $userId)->where('currency', $market ? optional($market->currencySeller)->symbol : $this->currency)->first();
        $this->userId = $userId;
        $this->balanceOne = $balanceOne ? Helper::numberFormatPrecision($balanceOne->balance_free, ($market != null ? optional($market->currencyBuyer)->decimal : (isset($currency->decimal) ? $currency->decimal : $currency['decimal']))) : 0;
        $this->balanceTwo = $balanceTwo ? Helper::numberFormatPrecision($balanceTwo->balance_free, ($market != null ? optional($market->currencySeller)->decimal : (isset($currency->decimal) ? $currency->decimal : $currency['decimal']))) : 0;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return [
            new PrivateChannel('balance-Update-' . $this->userId),
            new Channel('balance-Update-' . $this->userId),
        ];
    }

    public function broadcastAs()
    {
        return "BalanceUpdate";
    }

    public function broadCastWith()
    {
        return [
            "id" => $this->market ? optional($this->market)->id : null,
            "isWallet" => $this->isWallet,
            "marketId" => $this->market ? optional($this->market)->id : null,
            "icon" => $this->market ? optional(optional($this->market)->currencyBuyer)->iconUrl : null,
            "symbol" => $this->market ? optional($this->market)->symbol : null,
            "currency" => $this->currency,
            "price" => "0",
            "percent" => "0",
            "decimal" => $this->market ? optional(optional($this->market)->currencyBuyer)->decimal : null,
            "BalanceOne" => $this->balanceOne,
            "BalanceTwo" => $this->balanceTwo,
            "irtPrice" => $this->currencyModel['irt_price']
        ];
    }
}
