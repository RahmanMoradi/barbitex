<?php

namespace App\Listeners\Market;

use App\Events\Market\OrderPalcedEvent;
use App\Models\User;
use App\Notifications\Test\TestNotification;
use App\Notifications\User\SendNotificationToUsers;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Lang;

class OrderPlacedListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param OrderPalcedEvent $event
     * @return void
     */
    public function handle(OrderPalcedEvent $event)
    {
        $user = User::where('id', $event->order->user_id)
            ->first();
        $user->notify(new SendNotificationToUsers(Lang::get('order done'), Lang::get('order done',['orderId' => $event->order->id]), Lang::get('show'), '/panel/market/transactions'));
    }
}
