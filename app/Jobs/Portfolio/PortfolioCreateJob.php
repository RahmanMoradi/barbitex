<?php

namespace App\Jobs\Portfolio;

use App\Models\Admin\Admin;
use App\Models\Balance\Balance;
use App\Models\Portfolio\Portfolio;
use App\Models\User;
use App\Notifications\Admin\SendNotificationToAdmin;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Notification;

class PortfolioCreateJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $order;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($order)
    {
        $this->order = $order;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        try {
            $class = get_class($this->order);
            Portfolio::create([
                'order_id' => $class === 'App\Models\Order\Order' ? $this->order->id : null,
                'market_order_id' => $class === 'App\Models\Traid\Market\MarketOrder' ? $this->order->id : null,
                'user_id' => $this->order->user_id,
                'symbol' => $class === 'App\Models\Order\Order' ? $this->order->currency->symbol : $this->order->market->symbol
            ]);
        }catch (\Exception $exception){
            //
        }
    }
}
