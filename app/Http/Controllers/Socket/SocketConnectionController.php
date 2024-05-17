<?php

namespace App\Http\Controllers\Socket;

use App\Events\Binance\GetNewAskFromBinance;
use App\Events\Binance\GetTicker;
use App\Http\Controllers\Controller;
use App\Models\Webazin\Binance\Facades\Binance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class SocketConnectionController extends Controller
{
    public function AskBid()
    {
        Binance::depthCache(["ETHUSDT","BTCUSDT"], function ($api, $symbol, $depth) {
            $limit = 14;
            $data = $api->depth($symbol, $limit);
            Cache::store('redis')->delete("$symbol-asks");
            Cache::store('redis')->delete("$symbol-bids");
            Cache::store('redis')->put("$symbol-asks", $data['asks'], 60);
            Cache::store('redis')->put("$symbol-bids", $data['bids'], 60);
            event(new GetNewAskFromBinance($symbol, array_reverse($data['asks']), $data['bids']));
        });
    }

    public function tickerUpdate()
    {
        Binance::ticker(false, function ($api, $symbol, $ticker) {
            Cache::store('redis')->delete("$symbol-ticker");
            Cache::store('redis')->put("$symbol-ticker", $ticker, 60);
            event(new GetTicker($symbol, $ticker));
        });
    }
}
