<?php

namespace App\Models\Currency;

use App\Jobs\Currency\BalanceTableCreateForUsers;
use App\Models\Network\Network;
use App\Models\Webazin\Binance\Facades\Binance;
use App\Models\Webazin\Kucoin\Facades\Kucoin;
use BaconQrCode\Renderer\Image\SvgImageBackEnd;
use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;
use BaconQrCode\Writer;

trait CurrencyEvents
{

    public static function boot()
    {
        parent::boot();

        static::created(function ($item) {
            self::createNetworks($item);
            self::burnTxids($item);
            BalanceTableCreateForUsers::dispatchNow($item->symbol);
        });
    }

    public function adminUpdate()
    {
        $this->fireModelEvent('adminUpdated', true);
        self::createNetworks($this);
//        self::setDecimalSize($this);
    }

    private static function createNetworks(Currency $currency)
    {
        $currency->service()->createNetworkList($currency);
    }

    public static function setDecimalSize(Currency $currency)
    {
        $currency->service()->setDecimalSize($currency);
    }

    public static function burnTxids(Currency $currency)
    {
        $currency->service()->burnTxids($currency);

    }
}
