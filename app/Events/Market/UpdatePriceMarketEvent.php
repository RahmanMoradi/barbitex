<?php

namespace App\Events\Market;

use App\Models\Traid\Market\Market;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;

class UpdatePriceMarketEvent implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @var Market
     */
    private $market;
    private $seller;
    private $buyer;

    /**
     * Create a new event instance.
     *
     * @param Market $market
     */
    public function __construct(Market $market)
    {
        $this->market = $market;
        $this->seller = $this->getSeller();
        $this->buyer = $this->getBuyer();
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new Channel('market-update-price-' . $this->market->symbol);
    }

    private function getSeller()
    {
        $seller = DB::table('market_orders')
            ->orderByDesc('created_at')
            ->orderByDesc('price')
            ->where('type', 'sell')
            ->where('market_id', $this->market->id)
            ->whereStatus('init')
            ->limit('15')
            ->get()
            ->groupBy('price');

        $seller->map(function ($name) {
            $name[0]->allCount = $name->sum('remaining');
            $name[0]->allSumPrice = $name->sum('remaining') * $name[0]->price;
        });
        return $seller;
    }

    private function getBuyer()
    {
        $buyer = DB::table('market_orders')
            ->orderByDesc('created_at')
            ->orderBy('price')
            ->where('type', 'buy')
            ->where('market_id', $this->market->id)
            ->whereStatus('init')
            ->limit('15')->get()->groupBy('price');

        $buyer->map(function ($name) {
            $name[0]->allCount = $name->sum('remaining');
            $name[0]->allSumPrice = $name->sum('remaining') * $name[0]->price;
        });
        return $buyer;
    }

    public function broadcastWith()
    {
        return [
            'market' => $this->market,
            'seller' => $this->seller,
            'buyer' => $this->buyer
        ];
    }
//    public function broadcastAs()
//    {
//        return 'UpdatePriceMarketEvent';
//    }
}
