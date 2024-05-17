<?php

namespace App\Events\Market;

use App\Models\Traid\Market\Market;
use App\Models\Traid\Market\MarketHistory;
use App\Models\Traid\Market\MarketOrder;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class OrderPalcedEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @var Market
     */
    private $market;

    public $order;

    /**
     * Create a new event instance.
     *
     * @param Market $market
     * @param MarketOrder $order
     */
    public function __construct(Market $market, MarketOrder $order)
    {
        \App\Jobs\Traid\Market\MarketHistoryCreateJob::dispatchNow($market);
        $this->market = $market;
        $this->order = $order;
        $this->market->update([
            'price' => $order->price,
            'change_24' => (($order->price * 100) / $this->market->average_24) - 100,
            'last_price' => $order->price
        ]);
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new Channel('market-order-placed-' . $this->market->symbol);
    }

    public function broadcastWith()
    {
//        return [
//            'market' => $this->market,
//            'markets' => $this->markets,
//            'dataCharts' => $this->getDataCharts(),
//            'orders' => $this->getOrders(),
//        ];
    }

    private function getBalance()
    {
        $user = User::find($this->order->user_id);
        $balances = collect([
            'buy' => $user->balances->where('currency', $this->market->currencyBuyer->symbol)->first(),
            'sell' => $user->balances->where('currency', $this->market->currencySeller->symbol)->first()
        ]);
        return $balances;
    }
}
