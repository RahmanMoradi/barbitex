<?php

namespace App\Models\Webazin\Coinmarketcap;

use Illuminate\Support\Facades\Http;

class Coinmarketcap
{
    protected $url = 'https://pro-api.coinmarketcap.com/';
    protected $api_key;

    public function __construct()
    {
        $this->api_key = env('COINMARKETCAP_APIKEY');
    }

    private function request($method, $params)
    {
        $response = Http::withHeaders([
            'Accepts' => 'application/json',
            'X-CMC_PRO_API_KEY' => $this->api_key
        ])->get($this->getUrl($method), $params);
        if ($response->status() == 200) {
            return $response->collect();
        } else {
            return false;
        }
    }

    private function getUrl($method)
    {
        return $this->url . $method;
    }

    public function getLastPrice($params)
    {
        $response = $this->request("v1/cryptocurrency/quotes/latest", $params);
        if ($response) {
            return
                [
                    'price' => $response['data']["{$params['symbol']}"]['quote']['USD']['price'],
                    'percent_change_24h' => $response['data']["{$params['symbol']}"]['quote']['USD']['percent_change_24h'],
                ];
        }
    }

}
