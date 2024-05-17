<?php

namespace App\Models\Webazin\Mexc;

use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Whoops\Exception\ErrorException;


/**
 * @method get_asset_deposit_address_list(string[] $data)
 * @method get_asset_withdraw(string[] $data)
 * @method post_order_place(string[] $data)
 * @method get_account_info()
 */
class Mexc
{
    protected $spotUrl = 'https://www.mexc.com/open/api/v2';
    protected $contractUrl = 'https://contract.mexc.com/api/v1';
    protected $key, $secret;
    protected $nonce = '';
    protected $signature = '';
    protected $headers = [];
    protected $type = '';
    protected $path = '';
    protected $data = [];
    protected $options = [];
    protected $authentication = true;
    protected $platform = '';
    protected $version = '';

    public function __construct()
    {
        $this->nonce = time() * 1000;
        $this->key = config('webazin.mexc.key');
        $this->secret = config('webazin.mexc.secret');
    }

    public function __call($name, $arguments)
    {
        $urlArray = explode('_', $name);
        $method = $urlArray[0];

        $url = implode('/', array_slice($urlArray, 1));

        return $this->request($method, $url, $arguments ? $arguments[0] : null);
    }

    private function request($method, $url, $params = [])
    {
        $this->type = $method;
        $this->data = $params;
        $this->signature();

        $fullUrl = $this->getUrl($url);
        if ($method == 'get') {
            $fullUrl .= empty($params) ? '' : '?' . http_build_query($params);
        } else {
            $params = $params;
        }
        $response = Http::withHeaders($this->headers())->{$method}($fullUrl, $params)->json();
        if (!isset($response['code']) || $response['code'] != 200) {
            throw new ErrorException(
                isset($response['error']) ? $response['error'] : $response['msg'],
                isset($response['status']) ? $response['status'] : $response['code']);
        }
        return $response['data'];
    }

    private function getUrl($url)
    {
        return $this->spotUrl . '/' . $url;
    }

    protected function signature()
    {
        if ($this->authentication == false) return;

        if ($this->type == 'get') {
            $params = empty($this->data) ? '' : implode('&', $this->sort($this->data));
        } else {
            $params = empty($this->data) ? '' : json_encode($this->data);
        }

        //accessKey+时间戳+获取到的参数字符串
        $what = $this->key . $this->nonce . $params;
        //echo $what.PHP_EOL;
        $this->signature = hash_hmac("sha256", $what, $this->secret);
    }

    /**
     *
     * */
    protected function headers()
    {
        return [
            'Content-Type' => 'application/json',
            'ApiKey' => $this->key,
            'Request-Time' => $this->nonce,
            'Signature' => $this->signature,
        ];
    }

    protected function sort($param)
    {
        $u = [];
        $sort_rank = [];
        foreach ($param as $k => $v) {
            $u[] = $k . "=" . urlencode($v);
            $sort_rank[] = ord($k);
        }
        asort($u);

        return $u;
    }

    public function requestContract()
    {
        $url = $this->contractUrl . '/private/account/assets';

        $response = Http::withHeaders($this->headers())->get($url)->json();
        dd($response);
    }
}
