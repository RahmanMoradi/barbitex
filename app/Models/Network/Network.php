<?php

namespace App\Models\Network;

use App\Models\Bch\BchData;
use App\Models\Bnb\BnbData;
use App\Models\Btc\BtcData;
use App\Models\Doge\DogeData;
use App\Models\Eth\EthData;
use App\Models\Ltc\LtcData;
use App\Models\Tron\TronData;
use App\Services\Btc;
use App\Services\Eth;
use App\Services\Ltc;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Network extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function getWalletDataClass()
    {
        switch ($this->network) {
            case 'TRX':
                return new TronData;
            case  'BTC':
                return new BtcData;
            case  'ETH':
                return new EthData;
            case  'LTC':
                return new LtcData;
            case 'BCH':
                return new BchData;
            case 'DOGE':
                return new DogeData;
            case 'BNB':
                return new BnbData;
        }
    }
}
