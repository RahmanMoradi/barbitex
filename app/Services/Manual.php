<?php

namespace App\Services;

use App\Events\Currency\UpdatePrice;
use App\Models\Currency\Currency;
use App\Models\Network\Network;
use App\Models\Traid\Market\MarketOrder;
use App\Models\Wallet;
use App\Services\InterFaceService\Withdrawal;
use App\Services\TraitService\QrSaveTrait;
use App\Services\TraitService\SendNotification;
use App\Models\Webazin\Coinmarketcap\Facades\Coinmarketcap as Api;
use Illuminate\Support\Facades\Lang;

class Manual implements Withdrawal
{
    use QrSaveTrait, SendNotification;

    public static function withdraw(Wallet $wallet)
    {
        return false;
    }

    public static function checkDeposit($currency, $txidRequest)
    {
        return false;
    }

    public function createOrder($symbol, $count, $price, $type)
    {
        return null;
    }

    public function createNetworkList(Currency $currency)
    {
        Network::where('coin', strtoupper($currency->symbol))->delete();
        try {
            $network = Network::where('coin', 'ETH')->where('network', 'ERC20')->first();
            if (!$network) {
                $network = Network::where('coin', 'ETH')
                    ->orderBy('withdrawFee')->first();
            }
            if ($network) {
                $data = [
                    'network' => $network->network,
                    'name' => $network->name,
                    'addressRegex' => '',
                    'address' => $network->address,
                    'tag' => $network->tag,
                    'memoRegex' => $network->memoRegex,
                    'withdrawFee' => $network->withdrawFee,
                    'withdrawMin' => $network->withdrawMin,
                    'withdrawMax' => $network->withdrawMax,
                    'minConfirm' => $network->minConfirm,
                    'unLockConfirm' => 0,
                    'isDefault' => 1
                ];
                Network::create($data + [
                        'coin' => strtoupper($currency->symbol),
                    ]);

            } else {
                flash(Lang::get('there is no eth network'));
            }
        } catch (\Exception $exception) {
            flash($exception->getMessage())->error();
        }
    }

    public function tradToCurrency($order)
    {

    }

    public function getLastPrice(Currency $currency)
    {
        $time = gmdate("H:i:s");
        $time = explode(":", $time);
        $mins = ['00'];
        $seconds = ['00', '01', '02', '03', '05', '06', '07', '08', '09', '10'];

        if (in_array($time[1], $mins) && in_array($time[2], $seconds)) {
            if ($currency->symbol != 'USDT') {
                $response = Api::getLastPrice([
                    'symbol' => $currency->symbol,
                ]);
                $currency->update([
                    'price' => $response['price'],
                    'percent' => number_format($response['percent_change_24h'], 2)
                ]);
                event(new UpdatePrice($currency->symbol));
            } else {
                $currency->update([
                    'price' => 1,
                    'percent' => 0
                ]);
            }
        }
    }

    public function cancelOrder(MarketOrder $order)
    {
        return false;
    }

    public function createOrderMarket($symbol, $funds, $type)
    {
        return null;
    }

    public function checkActive(MarketOrder $order)
    {
        return false;
    }

    public function setDecimalSize(Currency $currency)
    {

    }

    public function burnTxids(Currency $currency)
    {

    }

    public function setTxid(Wallet $wallet)
    {

    }
}
