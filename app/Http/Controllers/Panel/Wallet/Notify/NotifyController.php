<?php

namespace App\Http\Controllers\Panel\Wallet\Notify;

use App\Http\Controllers\Controller;
use App\Models\Balance\Balance;
use App\Models\Btc\BtcData;
use App\Models\Currency\Currency;
use App\Models\Doge\DogeData;
use App\Models\Ltc\LtcData;
use App\Models\Wallet;
use App\Services\Btc;
use App\Services\Doge;
use App\Services\Ltc;
use http\Client\Curl\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class NotifyController extends Controller
{
    public function get($symbol, Request $request)
    {
//        if ($this->chekTxid($symbol, $request->get('tx'))) {
//            $currency = Currency::where('symbol', strtoupper($symbol))->first();
//
//            switch ($symbol) {
//                case 'btc':
//                    $btc = new Btc();
//                    $this->transactionCheck($btc, $request->get('tx'), 'btc');
//                    break;
//                case 'ltc':
//                    $ltc = new Ltc();
//                    $this->transactionCheck($ltc, $request->get('tx'), 'ltc');
//
//                    break;
//                case 'doge':
//                    $doge = new Doge();
//                    $transaction = $doge->getTransaction([$request->get('tx')]);
//                    if ($transaction['result']) {
//                        $amount = $transaction['result']['amount'];
//                        $details = $transaction['result']['details'];
//                        foreach ($details as $detail) {
//                            $address = $detail['address'];
//                            if ($detail['category'] == 'receive') {
//                                $this->addBalanceToUser($symbol, $amount, $address, $request->get('tx'));
//                            }
//                        }
//                    }
//                    break;
//            }
//        }
    }

    private function chekTxid($symbol, $tx)
    {
        $txid = DB::table('txids')->where('txid', $tx)->first();
        if (!$txid) {
            return true;
        }
        return false;
    }

    private function addBalanceToUser($symbol, $amount, $address, $txid)
    {
        switch ($symbol) {
            case 'btc':
                $data = BtcData::where('address_base_58', $address)->first();
                if ($data) {
                    Balance::createUnique($symbol, \App\Models\User::find($data->user_id), $amount);
                    $this->addTxid($data->user_id, $symbol, $txid);
                    $this->addTransaction(strtoupper($symbol), $amount, $txid, $data->user_id);
                }
                break;
            case 'ltc':
                $data = LtcData::where('address_base_58', $address)->first();
                if ($data) {
                    $this->addTxid($data->user_id, $symbol, $txid);
                    Balance::createUnique($symbol, \App\Models\User::find($data->user_id), $amount);
                    $this->addTransaction(strtoupper($symbol), $amount, $txid, $data->user_id);
                }
                break;
            case 'doge':
                $data = DogeData::where('address_base_58', $address)->first();
                if ($data) {
                    Balance::createUnique($symbol, \App\Models\User::find($data->user_id), $amount);
                    $this->addTxid($data->user_id, $symbol, $txid);
                    $this->addTransaction(strtoupper($symbol), $amount, $txid, $data->user_id);
                }
                break;
        }
    }

    private function addTxid($user_id, $symbol, $txid)
    {
        DB::table('txids')->insert([
            'user_id' => $user_id,
            'symbol' => $symbol,
            'txid' => $txid
        ]);
    }

    private function addTransaction($symbol, $amount, $txid, $userId)
    {
        $wallet = Wallet::create([
            'user_id' => $userId,
            'currency' => $symbol,
            'price' => $amount,
            'type' => 'increment',
            'description' => $txid,
            'status' => 'done'
        ]);
    }

    private function transactionCheck($service, $txid, $symbol)
    {
        $accounts = \App\Models\User::all();
        foreach ($accounts as $account) {
            $transaction = $service->getTransaction($account->id . '', $txid);
            if ($transaction) {
                $amount = $transaction['amount'];
                $details = $transaction['details'];
                foreach ($details as $detail) {
                    $address = $detail['address'];
                    $this->addBalanceToUser($symbol, $amount, $address, $txid);
                }
            }
        }
    }
}
