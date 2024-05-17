<?php

namespace App\Models\Webazin\Bybit;

use Lin\Bybit\BybitAccount;
use Lin\Bybit\BybitLinear;
use Lin\Bybit\BybitSpot;

class Bybit
{
    public $key, $secret;

    public function __construct()
    {
        $this->key = config('webazin.bybit.key');
        $this->secret = config('webazin.bybit.secret');
    }

    public function spot()
    {
        $bybit = new BybitSpot($this->key, $this->secret);
        $bybit->setOptions([
            //Set the request timeout to 60 seconds by default
//            'timeout' => 10,

            //If you are developing locally and need an agent, you can set this
            //'proxy'=>true,
            //More flexible Settings
            /* 'proxy'=>[
             'http'  => 'http://127.0.0.1:12333',
             'https' => 'http://127.0.0.1:12333',
             'no'    =>  ['.cn']
             ], */
            //Close the certificate
            //'verify'=>false,
        ]);
        return $bybit;
    }

    public function account()
    {
        $bybit = new BybitAccount($this->key, $this->secret);
        $bybit->setOptions([
            //Set the request timeout to 60 seconds by default
//            'timeout' => 10,

            //If you are developing locally and need an agent, you can set this
            //'proxy'=>true,
            //More flexible Settings
            /* 'proxy'=>[
             'http'  => 'http://127.0.0.1:12333',
             'https' => 'http://127.0.0.1:12333',
             'no'    =>  ['.cn']
             ], */
            //Close the certificate
            //'verify'=>false,
        ]);
        return $bybit;
    }
}
