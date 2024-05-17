<?php // Code within app\Helpers\Helper.php

namespace App\Helpers;

use Config;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Larabookir\Gateway\Asanpardakht\Asanpardakht;
use Larabookir\Gateway\Azinpay\Azinpay;
use Larabookir\Gateway\Bahamta\Bahamta;
use Larabookir\Gateway\Idpay\Idpay;
use Larabookir\Gateway\Mellat\Mellat;
use Larabookir\Gateway\Mrpay\Mrpay;
use Larabookir\Gateway\Nextpay\Nextpay;
use Larabookir\Gateway\OmidPay\OmidPay;
use Larabookir\Gateway\Payir\Payir;
use Larabookir\Gateway\Paystar\Paystar;
use Larabookir\Gateway\Poolam\Poolam;
use Larabookir\Gateway\Sadad\Sadad;
use Larabookir\Gateway\Saman\Saman;
use Larabookir\Gateway\Yekpay\Yekpay;
use Larabookir\Gateway\Zarinpal\Zarinpal;
use Larabookir\Gateway\Zibal\Zibal;
use anlutro\LaravelSettings\Facade as Setting;

class Helper
{
    const BUYFROMRTL = false;
    const RTLSANDBOX = false;

    public static function applClasses()
    {
        $data = config('webazin.theme');

        $layoutClasses = [
            'theme' => $data['theme'],
            'sidebarCollapsed' => $data['sidebarCollapsed'],
            'navbarColor' => $data['navbarColor'],
            'menuType' => $data['menuType'],
            'navbarType' => $data['navbarType'],
            'footerType' => $data['footerType'],
            'sidebarClass' => 'menu-expanded',
            'bodyClass' => $data['bodyClass'],
            'pageHeader' => $data['pageHeader'],
            'blankPage' => $data['blankPage'],
            'blankPageClass' => '',
            'contentLayout' => $data['contentLayout'],
            'sidebarPositionClass' => '',
            'contentsidebarClass' => '',
            'mainLayoutType' => $data['mainLayoutType'],
        ];


        //Theme
        $layoutClasses['theme'] = Auth::check() && Auth::user()->theme ? Auth::user()->theme : 'dark';
        if ($layoutClasses['theme'] == 'dark') {
            $layoutClasses['theme'] = "dark-layout";
            $layoutClasses['navbarColor'] = "navbar-dark";
        } elseif ($layoutClasses['theme'] == 'semi-dark') {
            $layoutClasses['theme'] = "semi-dark-layout";
            $layoutClasses['navbarColor'] = "navbar-light";

        } else {
            $layoutClasses['theme'] = "light";
            $layoutClasses['navbarColor'] = "navbar-light";

        }

        //menu Type
        switch ($layoutClasses['menuType']) {
            case "static":
                $layoutClasses['menuType'] = "menu-static";
                break;
            default:
                $layoutClasses['menuType'] = "menu-fixed";
        }


        //navbar
        switch ($layoutClasses['navbarType']) {
            case "static":
                $layoutClasses['navbarType'] = "navbar-static";
                $layoutClasses['navbarClass'] = "navbar-static-top";
                break;
            case "sticky":
                $layoutClasses['navbarType'] = "navbar-sticky";
                $layoutClasses['navbarClass'] = "fixed-top";
                break;
            case "hidden":
                $layoutClasses['navbarType'] = "navbar-hidden";
                break;
            default:
                $layoutClasses['navbarType'] = "navbar-floating";
                $layoutClasses['navbarClass'] = "floating-nav";
        }

        // sidebar Collapsed
        if ($layoutClasses['sidebarCollapsed'] == 'true') {
            $layoutClasses['sidebarClass'] = "menu-collapsed";
        }

        // sidebar Collapsed
        if ($layoutClasses['blankPage'] == 'true') {
            $layoutClasses['blankPageClass'] = "blank-page";
        }

        //footer
        switch ($layoutClasses['footerType']) {
            case "sticky":
                $layoutClasses['footerType'] = "fixed-footer";
                break;
            case "hidden":
                $layoutClasses['footerType'] = "footer-hidden";
                break;
            default:
                $layoutClasses['footerType'] = "footer-static";
        }

        //Cotntent Sidebar
        switch ($layoutClasses['contentLayout']) {
            case "content-left-sidebar":
                $layoutClasses['sidebarPositionClass'] = "sidebar-left";
                $layoutClasses['contentsidebarClass'] = "content-right";
                break;
            case "content-right-sidebar":
                $layoutClasses['sidebarPositionClass'] = "sidebar-right";
                $layoutClasses['contentsidebarClass'] = "content-left";
                break;
            case "content-detached-left-sidebar":
                $layoutClasses['sidebarPositionClass'] = "sidebar-detached sidebar-left";
                $layoutClasses['contentsidebarClass'] = "content-detached content-right";
                break;
            case "content-detached-right-sidebar":
                $layoutClasses['sidebarPositionClass'] = "sidebar-detached sidebar-right";
                $layoutClasses['contentsidebarClass'] = "content-detached content-left";
                break;
            default:
                $layoutClasses['sidebarPositionClass'] = "";
                $layoutClasses['contentsidebarClass'] = "";
        }

        return $layoutClasses;
    }

    public static function updatePageConfig($pageConfigs)
    {
        $demo = 'custom';
        if (isset($pageConfigs)) {
            if (count($pageConfigs) > 0) {
                foreach ($pageConfigs as $config => $val) {
                    Config::set('custom.' . $demo . '.' . $config, $val);
                }
            }
        }
    }

    public static function get_defult_pay()
    {
        $pay = null;
        switch (env('DEFULT_PAY')) {
            case ('Yekpay'):
                $pay = new Yekpay();
                break;
            case ('Zibal'):
                $pay = new Zibal();
                break;
            case ('Mrpay'):
                $pay = new Mrpay();
                break;
            case ('Bahamta'):
                $pay = new Bahamta();
                break;
            case('Zarinpal'):
                $pay = new Zarinpal();
                break;
            case ('Mellat'):
                $pay = new Mellat();
                break;
            case ('Sadad'):
                $pay = new Sadad();
                break;
            case('Saman'):
                $pay = new Saman();
                break;
            case ('Asan'):
                $pay = new Asanpardakht();
                break;
            case ('Nextpay'):
                $pay = new Nextpay();
                break;
            case ('Idpay'):
                $pay = new Idpay();
                break;
            case ('Payping'):
                $pay = new Payping();
                break;
            case ('Poolam'):
                $pay = new Poolam();
                break;
            case ('Paystar'):
                $pay = new Paystar();
                break;
            case ('Vendar'):
                $pay = new Vendar();
                break;
            case ('OmidPay'):
                $pay = new OmidPay();
                break;
            default:
                $pay = new Payir();
                break;
        }

        return $pay;
    }

    public static function payments(): array
    {
        return [
//            'Yekpay',
//            'Zibal',
//            'Mrpay',
//            'Bahamta',
//            'Zarinpal',
            'Mellat',
//            'Sadad',
//            'Saman',
//            'Asan',
            'Nextpay',
            'Idpay',
//            'Payping',
//            'Poolam',
//            'Paystar',
//            'Vendar',
            'Payir',
        ];
    }

    public static function encrypt($string, $key = 5)
    {
        if ($string == "" || $string == null) {
            return "";
        }
        $result = '';
        for ($i = 0, $k = strlen($string); $i < $k; $i++) {
            $char = substr($string, $i, 1);
            $keychar = substr($key, ($i % strlen($key)) - 1, 1);
            $char = chr(ord($char) + ord($keychar));
            $result .= $char;
        }
        return Crypt::encrypt($result);
    }

    public static function decrypt($string, $key = 5)
    {
        $result = '';
        $string = Crypt::decrypt($string);
        for ($i = 0, $k = strlen($string); $i < $k; $i++) {
            $char = substr($string, $i, 1);
            $keychar = substr($key, ($i % strlen($key)) - 1, 1);
            $char = chr(ord($char) - ord($keychar));
            $result .= $char;
        }

        return $result;
    }

    public static function numberFormatPrecision($number, $precision = 2, $separator = '.')
    {
        $number = Helper::formatAmountWithNoE($number, $precision);
        $numberParts = explode($separator, $number);
        $response = $numberParts[0];
        if (count($numberParts) > 1 && $precision > 0) {
            $response .= $separator;
            $response .= substr($numberParts[1], 0, $precision);
        }
        return (float)$response;
    }

    public static function numberFormatPrecisionString($number, $precision = 2, $separator = '.')
    {
        $numberParts = explode($separator, $number);
        $response = $numberParts[0];
        if (count($numberParts) > 1 && $precision > 0) {
            $response .= $separator;
            if (strlen($numberParts[1]) < $precision) {
                for ($i = 0; $i < $precision; $i++) {
                    $numberParts[1] .= '0';
                }
            }
            $response .= substr($numberParts[1], 0, $precision);
        }
        return $response;
    }

    public static function formatAmountWithNoE($amount, $decimal)
    {
        $amount = (string)$amount; // cast the number in string
        $pos = stripos($amount, 'E-'); // get the E- position
        $there_is_e = $pos !== false; // E- is found

        if ($there_is_e) {
            $decimals = intval(substr($amount, $pos + $decimal, strlen($amount))); // extract the decimals
            $amount = number_format($amount, $decimals, '.', ','); // format the number without E-
        }

        return $amount;
    }

    public static function markets(): array
    {
        return [
            'binance',
            'kucoin',
//            'mexc',
            'manual',
//            'perfectmoney'
        ];
    }

    public static function AddTxidToDb($txid, $symbol)
    {
        DB::table('txids')->insert([
            'txid' => $txid,
            'symbol' => $symbol,
            'user_id' => Auth::id()
        ]);
    }

    public static function CheckTxidFromDb($txid): bool
    {
        $check = DB::table('txids')
            ->where('txid', $txid)->first();
        if ($check) {
            return true;
        } else {
            return false;
        }
    }

    public static function getBroadcasterPrefix()
    {
        switch (env('BROADCAST_DRIVER')) {
            case 'pusher' :
                return '';
            case 'redis':
                return env('APP_NAME') . '_database_';
        }
    }

    public static function modules(): array
    {
        return [
            'wallet' => true,
            'market' => true,
            'marketOrder' => true,
            'orderPlane' => true,
            'portfolio' => true,
            'application' => false,
            'referrals' => true,
            'vip' => true,
            'discount' => false,
            'accreditation' => false,
            'reward' => false,
            'cooperation' => false,
            'firebase' => false,
            'metaverse' => false,
            'airdrop' => false,
            'analysis' => false,
            'tournament' => false,
            'api_version' => 2,
            'global_transfer' => true,
            'cart_to_cart' => true
        ];
    }

    public static function convertPersianToEnglish($string)
    {
        $persian = ['۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'];
        $english = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];

        return str_replace($persian, $english, $string);
    }

    public static function getAdminCarts(): array
    {
        return [
            ['مهدی فرهادپور', '6219861905009584', 'بانک سامان'],
            ['مهدی فرهادپور', '6063731046083276', 'بانک مهر'],
        ];
    }
}
