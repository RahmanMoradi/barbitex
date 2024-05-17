<?php

namespace App\Models\Traid\Market;

use anlutro\LaravelSettings\Facade as Settings;
use App\Events\Market\BalanceUpdateEvent;
use App\Helpers\Helper;
use App\Jobs\Portfolio\PortfolioCreateJob;
use App\Models\Balance\Balance;
use App\Models\Currency\Currency;
use App\Models\User;
use App\Models\Wallet;
use Illuminate\Support\Facades\Lang;

trait MarketOrderEvent
{
    public static function boot()
    {
        parent::boot();
        static::updated(function ($item) {
            if ($item->remaining == 0 && $item->status == 'done') {
                self::markAsDone($item);
                if (Helper::modules()['portfolio']) {
                    PortfolioCreateJob::dispatchNow($item);
                }
            }
        });
    }

    public static function markAsDone($item)
    {
        $currencySell = Currency::findOrFail($item->market->currency_sell);//usdt
        $currencyBuy = Currency::findOrFail($item->market->currency_buy);

        $balanceSell = Balance::where('user_id', $item->user_id)->where('currency', $currencySell->symbol)->first();
        $balanceBuy = Balance::where('user_id', $item->user_id)->where('currency', $currencyBuy->symbol)->first();
        if (!$balanceSell) {
            Balance::createUnique($currencySell->symbol, User::find($item->user_id), 0);
            $balanceSell = Balance::where('user_id', $item->user_id)->where('currency', $currencySell->symbol)->first();
        }
        if (!$balanceBuy) {
            Balance::createUnique($currencyBuy->symbol, User::find($item->user_id), 0);
            $balanceBuy = Balance::where('user_id', $item->user_id)->where('currency', $currencyBuy->symbol)->first();
        }

        if ($item->type == 'sell') {
            $wage = ($item->sumPrice * Settings::get('market_fee') / 100);
            $addBalance = ($item->sumPrice - $wage);
            $balanceSell->update([
                'balance' => $balanceSell->balance + ($addBalance),
                'balance_free' => $balanceSell->balance_free + ($addBalance)
            ]);//udst

            $balanceBuy->update([
                'balance' => $balanceBuy->balance - ($item->count),
                'balance_use' => $balanceBuy->balance_use - ($item->count)
            ]);
            self::addIncomeSite($item->id, $wage, $balanceSell->currency);
        } else {
            $wage = ($item->count * Settings::get('market_fee') / 100);
            $addBalance = ($item->count - $wage);
            $balanceBuy->update([
                'balance' => $balanceBuy->balance + ($addBalance),
                'balance_free' => $balanceBuy->balance_free + ($addBalance)
            ]);

            $balanceSell->update([
                'balance' => $balanceSell->balance - ($item->sumPrice),
                'balance_use' => $balanceSell->balance_use - ($item->sumPrice)
            ]);//usdt

            self::addIncomeSite($item->id, $wage, $balanceBuy->currency);
        }
        BalanceUpdateEvent::dispatch($item->user_id, $item->market, null);
    }

    private static function addIncomeSite($id, float $wage, $currency)
    {
        $description = Lang::get('increase credit for commission professional market', ['orderId' => $id]);
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
}
