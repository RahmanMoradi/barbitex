<?php

namespace App\Models\Order;

use anlutro\LaravelSettings\Facade as Setting;
use App\Helpers\Helper;
use App\Jobs\Portfolio\PortfolioCreateJob;
use App\Models\Admin\Admin;
use App\Models\Balance\Balance;
use App\Models\User;
use App\Models\Wallet;
use App\Services\TraitService\SendNotification;
use Illuminate\Support\Facades\Lang;

trait OrderEvent
{
    public static function boot()
    {
        parent::boot();
        static::updated(function ($item) {
            if ($item->type == 'buy' && $item->status == 'done') {
                dispatch_now(function () use ($item) {
                    self::calculateParentWage($item);
                });
            }
            if ($item->status == 'done' && Helper::modules()['portfolio']) {
                PortfolioCreateJob::dispatch($item);
            }
            self::addDayBuy($item);
        });
    }

    private static function calculateParentWage(Order $order)
    {
        $percent = $order->currency->symbol == 'USDT' ? Setting::get('dollar_sell_pay_percent') : Setting::get('currency_sell_pay_percent');
        $wage = ($order->price * $percent) / 100;
        try {
            if (Setting::get('referralPercent') > 0 && isset(optional($order->user)->parent_id)) {
                $commission = $order->price * (Setting::get('referralPercent') / 100);
                Wallet::create([
                    'user_id' => optional($order->user)->parent_id,
                    'currency' => 'IRT',
                    'price' => $commission,
                    'type' => 'increment',
                    'description' => Lang::get('order commission number', ['orderId' => $order->id]),
                    'status' => 'done'
                ]);
                $user = User::find(optional($order->user)->parent_id);
                Balance::createUnique('IRT', $user, $commission);
                $wage = $wage - $commission;
            }

        } catch (\Exception $exception) {
            foreach (Admin::all() as $admin) {
                SendNotification::sendMessage($admin, $exception->getMessage());
            }
        }
        self::addIncomeSite($order->id, $wage, 'IRT');
    }

    private static function addIncomeSite($id, float $wage, $currency)
    {
        $description = Lang::get('increase credit for commission simple market', ['orderId' => $id]);
        Wallet::create([
            'admin_id' => 0,
            'user_id' => 0,
            'currency' => $currency,
            'price' => $wage,
            'description' => $description,
            'type' => 'increment',
            'status' => 'done'
        ]);

        Balance::createUniqueAdmin($currency, $wage);
    }

    public static function addDayBuy(Order $order)
    {
        optional($order->user)->update([
            'day_buy' => optional($order->user)->day_buy + $order->price
        ]);
    }
}
