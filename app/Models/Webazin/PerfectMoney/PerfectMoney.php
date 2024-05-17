<?php

namespace App\Models\Webazin\PerfectMoney;


use App\Models\DigitalCurrency\DigitalCurrency;
use Carbon\Carbon;
use App\Helpers\Helper;

class PerfectMoney
{
    /**
     * @var string
     */
    protected $account_id;

    /**
     * @var string
     */
    protected $passphrase;

    /**
     * @var string
     */
    protected $alt_passphrase;

    /**
     * @var string
     */
    protected $merchant_id;

    /**
     * @var array
     */
    protected $ssl_fix = [
        'ssl' => [
            'verify_peer' => false,
//            'verify_peer_name' => false
        ]
    ];


    public function __construct()
    {
        $this->account_id = Helper::decrypt(config('webazin.perfectmoney.account_id'));
        $this->passphrase = Helper::decrypt(config('webazin.perfectmoney.passphrase'));
        $this->alt_passphrase = Helper::decrypt(config('webazin.perfectmoney.alt_passphrase'));
        $this->merchant_id = Helper::decrypt(config('webazin.perfectmoney.merchant_id'));
    }

    /**
     * get the balance for the wallet
     *
     * @return array
     */
    public function getBalance()
    {

        // Get data from the server
        $url = file_get_contents('https://perfectmoney.is/acct/balance.asp?AccountID=' . $this->account_id . '&PassPhrase=' . $this->passphrase, false, stream_context_create($this->ssl_fix));
        if (!$url) {
            return ['status' => 'error', 'message' => 'Connection error'];
        }
        // searching for hidden fields
        if (!preg_match_all("/<input name='(.*)' type='hidden' value='(.*)'>/", $url, $result, PREG_SET_ORDER)) {
            return ['status' => 'error', 'message' => 'Invalid output'];
        }

        // putting data to array (return error, if have any)
        $data = [];
        foreach ($result as $item) {
            if ($item[1] == 'ERROR') {
                $data['balance'] = [
                    'currency' => $item[1],
                    'balance' => 0
                ];
//                return [ 'status' => 'error' , 'message' => $item[ 2 ] ];
            } else {
                if ($item[1] == $this->merchant_id) {
                    $data['balance'] = [
                        'currency' => $item[1],
                        'balance' => $item[2]
                    ];
                }
            }
        }
        $data['status'] = 'success';

        return $data;


    }

    /**
     * Send Money
     *
     * @param string $account
     * @param double $amount
     * @param string $descripion
     * @param string $payment_id
     *
     * @return array
     */

    public function sendMoney($account, $amount, $descripion = '', $payment_id = '')
    {

        // trying to open URL to process PerfectMoney Spend request
        $url = file_get_contents('https://perfectmoney.is/acct/confirm.asp?AccountID=' . urlencode(trim($this->account_id)) . '&PassPhrase=' . urlencode(trim($this->passphrase)) . '&Payer_Account=' . urlencode(trim($this->merchant_id)) . '&Payee_Account=' . urlencode(trim($account)) . '&Amount=' . $amount . (empty($descripion) ? '' : '&Memo=' . urlencode(trim($descripion))) . (empty($payment_id) ? '' : '&PAYMENT_ID=' . urlencode(trim($payment_id))), false, stream_context_create($this->ssl_fix));
        if (!$url) {
            return ['status' => 'error', 'message' => 'Connection error'];
        }
        // searching for hidden fields
        if (!preg_match_all("/<input name='(.*)' type='hidden' value='(.*)'>/", $url, $result, PREG_SET_ORDER)) {
            return ['status' => 'error', 'message' => 'Invalid output'];
        }
        // putting data to array (return error, if have any)
        $data = [];
        foreach ($result as $item) {
            if ($item[1] == 'ERROR') {
                return ['status' => 'error', 'message' => $item[2]];
            } else {
                $data['data'][$item[1]] = $item[2];
            }
        }


        $data['status'] = 'success';

        return $data;

    }

    public function generateHash(Request $request)
    {

        $string = '';
        $string .= $request->input('PAYMENT_ID') . ':';
        $string .= $request->input('PAYEE_ACCOUNT') . ':';
        $string .= $request->input('PAYMENT_AMOUNT') . ':';
        $string .= $request->input('PAYMENT_UNITS') . ':';
        $string .= $request->input('PAYMENT_BATCH_NUM') . ':';
        $string .= $request->input('PAYER_ACCOUNT') . ':';
        $string .= strtoupper(md5($this->alt_passphrase)) . ':';
        $string .= $request->input('TIMESTAMPGMT');

        return strtoupper(md5($string));

    }

    public function createVoucher($account, $amount)
    {
        $f = fopen('https://perfectmoney.is/acct/ev_create.asp?AccountID=' . $this->account_id . '&PassPhrase=' . $this->passphrase . '&Payer_Account=' . urlencode(trim($account)) . '&Amount=' . (float)$amount . '', 'rb', false, stream_context_create($this->ssl_fix));

        if ($f === false) {
            echo 'error openning url';
        }

// getting data
        $out = array();
        $out = "";
        while (!feof($f)) {
            $out .= fgets($f);
        }

        fclose($f);

// searching for hidden fields
        if (!preg_match_all("/<input name='(.*)' type='hidden' value='(.*)'>/", $out, $result, PREG_SET_ORDER)) {
            echo 'Ivalid output';
            exit;
        }
        $ar = [];
        foreach ($result as $item) {
            $key = $item[1];
            $ar[$key] = $item[2];
        }

        return $ar;
    }

    public function activeVoucher($ev_number, $ev_code)
    {
        $f = fopen('https://perfectmoney.is/acct/ev_activate.asp?AccountID=' . $this->account_id . '&PassPhrase=' . $this->passphrase . '&Payee_Account=' . $this->merchant_id . '&ev_number=' . $ev_number . '&ev_code=' . $ev_code . '', 'rb', false, stream_context_create($this->ssl_fix));
        if ($f === false) {
            echo 'error openning url';
        }

// getting data
        $out = array();
        $out = "";
        while (!feof($f)) {
            $out .= fgets($f);
        }

        fclose($f);
//        dd( $out );
// searching for hidden fields
        if (!preg_match_all("/<input name='(.*)' type='hidden' value='(.*)'>/", $out, $result, PREG_SET_ORDER)) {
            echo 'Ivalid output';
            exit;
        }
        $ar = [];

        foreach ($result as $item) {
            $key = $item[1];
            $ar[$key] = $item[2];
        }

        return $ar;

    }

}
