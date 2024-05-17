<?php

namespace App\Events\Binance;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class GetNewAskFromBinance implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $asks;
    public $bids;
    public $symbol;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($symbol, $asks = null, $bids = null)
    {
        $this->symbol = $symbol;
        $this->asks = $asks;
        $this->bids = $bids;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new Channel('ask-bid-channel-' . $this->symbol);
    }

    public function broadcastAs()
    {
        return "AskBid";
    }

    public function broadcastWith()
    {
        return [
            'symbol' => $this->symbol,
            'asks' => $this->asks,
            'bids' => $this->bids
        ];
    }
}
