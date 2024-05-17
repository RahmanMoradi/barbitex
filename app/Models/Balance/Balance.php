<?php

namespace App\Models\Balance;

use App\Events\Market\BalanceUpdateEvent;
use App\Helpers\Helper;
use App\Models\Currency\Currency;
use App\Models\User;
use App\Models\Wallet;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Balance extends Model
{
    use HasFactory, BalanceEvent;

    protected $guarded = ['id'];

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function currencyModel()
    {
        return $this->hasOne(Currency::class, 'symbol', 'currency');
    }

    public function wallet()
    {
        return $this->belongsTo(Wallet::class);
    }

    public static function createUnique($symbol, $user, $qty)
    {
        $balance = \App\Models\Balance\Balance::where('user_id', $user->id)->where('currency', $symbol)->first();
        if ($balance) {
            $balance->update([
                'balance' => $balance->balance + ($qty),
                'balance_free' => $balance->balance_free + ($qty),
            ]);
        } else {
            Balance::create([
                'user_id' => $user->id,
                'currency' => $symbol,
                'balance' => $qty,
                'balance_free' => $qty
            ]);
        }
    }

    public static function updateUnique($symbol, $user, $qty)
    {
        $balance = \App\Models\Balance\Balance::where('user_id', $user->id)->where('currency', $symbol)->first();
        if ($balance) {
            $balance->update([
                'balance' => $qty,
                'balance_free' => $qty
            ]);
        } else {
            Balance::create([
                'user_id' => $user->id,
                'currency' => $symbol,
                'balance' => $qty
            ]);
        }
    }

    public static function createUniqueAdmin($symbol, $qty)
    {
        $balance = \App\Models\Balance\Balance::where('user_id', 0)->where('currency', $symbol)->first();
        if ($balance) {
            $balance->update([
                'balance' => $balance->balance + ($qty),
                'balance_free' => $balance->balance_free + ($qty),
            ]);
        } else {
            Balance::create([
                'user_id' => 0,
                'currency' => $symbol,
                'balance' => $qty,
                'balance_free' => $qty
            ]);
        }
    }
}
