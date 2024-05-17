<?php

namespace App\Http\Controllers\admin;

use anlutro\LaravelSettings\Facade as Setting;
use App\Helpers\Helper;
use App\Rules\IsNotPersian;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Lang;

class SettingController extends Controller
{

    public function index()
    {
        return view('admin.settings.index');
    }

    public function store(Request $request)
    {
        Setting::set($request->only('title', 'description', 'meta_tag', 'meta_description', 'email', 'phone', 'mobile',
            'address', 'theme', 'referralPercent', 'script', 'telegram', 'instagram', 'authText', 'account',
            'NOCAPTCHA_SECRET', 'NOCAPTCHA_SITEKEY', 'NOCAPTCHA_Active', 'app_debug', 'adminMessage', 'min_buy', 'min_sell',
            'autoDeposit', 'autoWithdraw', 'market_fee', 'min_market_buy', 'facebook', 'pinterest', 'skype', 'youtube',
            'whatsapp', 'twitter', 'guestShowMarket', 'marketNameFa', 'homeChart', 'homeCalculator', 'panelV4', 'withdraw_irt_fee',
            'registerField'));
        Setting::set('copyright', Lang::get('designed by'));
        Setting::set('creatortitle', Lang::get('webazin'));
        Setting::set('creatorlink', Lang::get('webazin.net'));
        if ($request->has('logo')) {
            $this->deleteFile(Setting::get('logo'));
            Setting::set('logo', $this->uploadFile('/logo', $request->file('logo')));
        }
        if ($request->has('favicon')) {
            $this->deleteFile(Setting::get('favicon'));
            Setting::set('favicon', $this->uploadFile('/favicon', $request->file('favicon')));
        }
        if ($request->has('authImage')) {
            $this->deleteFile(Setting::get('authImage'));
            Setting::set('authImage', $this->uploadFile('/authImage', $request->file('authImage')));
        }

        if ($request->has('no-captcha.secret') && $request->has('no-captcha.sitekey')) {
            $this->setEnvironmentValue('NOCAPTCHA_SECRET', 'no-captcha.secret', Setting::get('NOCAPTCHA_SECRET'));
            $this->setEnvironmentValue('NOCAPTCHA_SITEKEY', 'no-captcha.sitekey', Setting::get('NOCAPTCHA_SITEKEY'));
        }
//        $this->setEnvironmentValue('APP_DEBUG', 'app.debug', Setting::get('app_debug'));


        Setting::save();
        flash(Lang::get('operation completed successfully'))->success();

        return back();
    }

    public function PriceStore(Request $request)
    {
        if ($request->has('usdAutoUpdate')) {
            Setting::set('usdAutoUpdate', $request->usdAutoUpdate == 'on');
        } else {
            if ($request->has('autoUpdates')) {
                $request->validate([
                    'dollar_sell_pay_percent' => ['required', new IsNotPersian],
                    'dollar_buy_pay_percent' => ['required', new IsNotPersian]
                ]);
                Setting::set($request->only('dollar_sell_pay_percent', 'dollar_buy_pay_percent'));

            } else {
                $request->validate([
                    'dollar_sell_pay' => ['required', new IsNotPersian],
                    'dollar_buy_pay' => ['required', new IsNotPersian]
                ]);
                Setting::set($request->only('dollar_sell_pay', 'dollar_buy_pay'));
            }
        }
        Setting::save();
        flash(Lang::get('operation completed successfully'))->success();

        return back();
    }

    public function page()
    {
        return view('admin.setting.pages');
    }

    public function pageStore(Request $request)
    {
        Setting::set('about', $request->about);
        Setting::set('ask', $request->ask);
        Setting::set('wage', $request->wage);
        Setting::set('help', $request->help);
        Setting::set('terms', $request->terms);
        Setting::set('contact', $request->contact);
        Setting::set('cooperation', $request->cooperation);
        Setting::set('applicationPage', $request->applicationPage);
        Setting::save();

        return back();
    }

    public function payment(Request $request)
    {
        $this->globalStore($request);
        $this->setEnvironmentValue('IDPAYAPI', 'gateway.idpay.api-key', Setting::get('idpay_api'));

        $this->setEnvironmentValue('PAYIRAPI', 'gateway.payir.api', Setting::get('payir_api'));

        $this->setEnvironmentValue('NEXTPAYAPI', 'gateway.nextpay.api-key', Setting::get('nextpay_api'));

        $this->setEnvironmentValue('ZARINPALMERCHANT', 'gateway.zarinpal.merchant-id', Setting::get('zarinpal_merchant'));

        $this->setEnvironmentValue('MELLAT_USERNAME', 'gateway.mellat.username', Setting::get('mellat_username'));
        $this->setEnvironmentValue('MELLAT_PASSWORD', 'gateway.mellat.password', Setting::get('mellat_password'));
        $this->setEnvironmentValue('MELLAT_TERMINAL_ID', 'gateway.mellat.terminalId', Setting::get('mellat_terminal_id'));

        $this->setEnvironmentValue('SADADMERCHENT', 'gateway.sadad.merchant', Setting::get('sadad_merchent'));
        $this->setEnvironmentValue('SADADKEY', 'gateway.sadad.transactionKey', Setting::get('sadad_transactionKey'));
        $this->setEnvironmentValue('SADADTERMINALID', 'gateway.sadad.terminalId', Setting::get('sadad_terminal_id'));

        $this->setEnvironmentValue('DEFULT_PAY', 'gateway.default_pay', Setting::get('default_pay'));

        $this->setEnvironmentValue('ZIBAL_MERCHANT', 'gateway.zibal.merchant', Setting::get('zibal-merchant'));

        return back();
    }

    private function globalStore($request)
    {
        Setting::set($request->except('_token', 'logo'));
        Setting::save();
    }

    private function setEnvironmentValue($environmentName, $configKey, $newValue)
    {
        file_put_contents(App::environmentFilePath(), str_replace(
            $environmentName . '=' . Config::get($configKey),
            $environmentName . '=' . $newValue,
            file_get_contents(App::environmentFilePath())
        ));

        if (file_exists(App::getCachedConfigPath())) {
            Artisan::call("config:cache");
        }
    }

    public function binance(Request $request)
    {
        if (in_array('binance', \App\Helpers\Helper::markets())) {
            if ($request->has('binance.api_key')) {
                Setting::set($request->only('binance.api_key', 'binance.secret_key'));
                $this->setEnvironmentValue('BINANCE_API_KEY', 'webazin.binance.api_key', Setting::get('binance.api_key'));
                $this->setEnvironmentValue('BINANCE_SECRET_KEY', 'webazin.binance.secret_key', Setting::get('binance.secret_key'));
            }
        }
        if (in_array('kucoin', \App\Helpers\Helper::markets())) {
            if ($request->has('kucoin.api_key')) {
                Setting::set($request->only('kucoin.api_key', 'kucoin.secret_key', 'kucoin.password'));
                $this->setEnvironmentValue('KUCOIN_API_KEY', 'webazin.kucoin.api_key', Setting::get('kucoin.api_key'));
                $this->setEnvironmentValue('KUCOIN_SECRET_KEY', 'webazin.kucoin.secret_key', Setting::get('kucoin.secret_key'));
                $this->setEnvironmentValue('KUCOIN_PASSWORD', 'webazin.kucoin.password', Setting::get('kucoin.password'));
            }
        }
        if (in_array('perfectmoney', \App\Helpers\Helper::markets())) {
            if ($request->has('perfectmoney.account_id')) {
                Setting::set($request->only('perfectmoney.account_id', 'perfectmoney.passphrase', 'perfectmoney.alternate_passphrase', 'perfectmoney.merchant_id'));
                $this->setEnvironmentValue('PERFECTMONEY_ACCOUNT_ID', 'webazin.perfectmoney.account_id', Setting::get('perfectmoney.account_id'));
                $this->setEnvironmentValue('PERFECTMONEY_PASSPHRASE', 'webazin.perfectmoney.passphrase', Setting::get('perfectmoney.passphrase'));
                $this->setEnvironmentValue('PERFECTMONEY_ALTERNATE_PASSPHRASE', 'webazin.perfectmoney.alt_passphrase', Setting::get('perfectmoney.alternate_passphrase'));
                $this->setEnvironmentValue('PERFECTMONEY_MERCHANT_ID', 'webazin.perfectmoney.merchant_id', Setting::get('perfectmoney.merchant_id'));
            }
        }
        if ($request->has('kavenegar_api')) {
            Setting::set($request->only('kavenegar_api'));
            $this->setEnvironmentValue('KAVENEGAR_API', 'kavenegar.apiKey', Setting::get('kavenegar_api'));
        }

        if ($request->has('mail.mailer')) {
            Setting::set($request->only('mail.mailer', 'mail.host', 'mail.port', 'mail.encryption', 'mail.username', 'mail.password', 'mail.from_address', 'mail.from_name'));
            $this->setEnvironmentValue('MAIL_MAILER', 'mail.default', Setting::get('mail.mailer'));
            $this->setEnvironmentValue('MAIL_HOST', 'mail.mailers.smtp.host', Setting::get('mail.host'));
            $this->setEnvironmentValue('MAIL_PORT', 'mail.mailers.smtp.port', Setting::get('mail.port'));
//            $this->setEnvironmentValue('MAIL_ENCRYPTION', 'mail.mailers.smtp.encryption', Setting::get('mail.encryption'));
            $this->setEnvironmentValue('MAIL_USERNAME', 'mail.mailers.smtp.username', Setting::get('mail.username'));
            $this->setEnvironmentValue('MAIL_PASSWORD', 'mail.mailers.smtp.password', Setting::get('mail.password'));
            $this->setEnvironmentValue('MAIL_FROM_ADDRESS', 'mail.from.address', Setting::get('mail.from_address'));
            $this->setEnvironmentValue('MAIL_FROM_NAME', 'mail.from.name', Setting::get('mail.from_name'));
        }


        Setting::save();

        flash(Lang::get('operation completed successfully'))->success();

        return back();
    }

    public function userLevel(Request $request)
    {
        Setting::set($request->only('userLevel.bronze.maxDayBuy', 'userLevel.silver.maxDayBuy', 'userLevel.silver.percent'
            , 'userLevel.silver.sumPrice', 'userLevel.gold.maxDayBuy', 'userLevel.gold.percent',
            'userLevel.gold.sumPrice'));
        Setting::save();
        flash(Lang::get('operation completed successfully'))->success();

        return back();
    }

    public function currency(Request $request)
    {
        $this->globalStore($request);
        $this->setEnvironmentValue('PREFECTMONEY_ACCOUNT_ID', 'webazin.perfectmoney.account_id', Setting::get('perfectmoney.account_id'));
        $this->setEnvironmentValue('PREFECTMONEY_PASSPHRASE', 'webazin.perfectmoney.passphrase', Setting::get('perfectmoney.passphrase'));
        $this->setEnvironmentValue('PREFECTMONEY_ALTERNATE_PASSPHRASE', 'webazin.perfectmoney.alternate_passphrase', Setting::get('perfectmoney.alternate_passphrase'));
        $this->setEnvironmentValue('PREFECTMONEY_MERCHANT_ID', 'webazin.perfectmoney.marchant_id', Setting::get('perfectmoney.marchant_id'));

        $this->setEnvironmentValue('PS_VOUCHER_API_KRY', 'webazin.ps_voucher.api_key', Setting::get('ps_voucher.api_key'));
        $this->setEnvironmentValue('PS_VOUCHER_SEC_KRY', 'webazin.ps_voucher.sec_key', Setting::get('ps_voucher.sec_key'));
        $this->setEnvironmentValue('PS_VOUCHER_WORTH_VALUE', 'webazin.ps_voucher.worth_value', Setting::get('ps_voucher.worth_value'));

        $this->setEnvironmentValue('COINEX_ACCESS_ID', 'webazin.coinex.access_id', Setting::get('coinex.access_id'));
        $this->setEnvironmentValue('COINEX_SECRET_KEY', 'webazin.coinex.secret_key', Setting::get('coinex.secret_key'));

        return back();
    }

    public function pwa(Request $request)
    {
        $this->globalStore($request);

        if ($request->has('pwa.icon')) {
            $this->deleteFile(Setting::get('pwa.icon'));
            Setting::set('pwa.icon', $this->uploadFile('/pwa', $request->file('pwa.icon')));
        }

        if ($request->has('pwa.splash')) {
            $this->deleteFile(Setting::get('pwa.splash'));
            Setting::set('pwa.splash', $this->uploadFile('/pwa', $request->file('pwa.splash')));
        }

        Setting::save();

        $this->setEnvironmentValue('PWA_NAME', 'laravelpwa.name', Setting::get('pwa.name'));
        $this->setEnvironmentValue('PWA_SHORT_NAME', 'laravelpwa.manifest.short_name', Setting::get('pwa.short_name'));
        $this->setEnvironmentValue('PWA_START_URL', 'laravelpwa.manifest.start_url', Setting::get('pwa.start_url'));
        $this->setEnvironmentValue('PWA_BACK_COLOR', 'laravelpwa.manifest.background_color', '"' . Setting::get('pwa.background_color') . '"');
        $this->setEnvironmentValue('PWA_THEME_COLOR', 'laravelpwa.manifest.theme_color', '"' . Setting::get('pwa.theme_color') . '"');
        $this->setEnvironmentValue('PWA_STATUS_BAR', 'laravelpwa.manifest.status_bar', '"' . Setting::get('pwa.status_bar') . '"');
        $this->setEnvironmentValue('PWA_ICON', 'laravelpwa.manifest.icons.72x72.path', asset(Setting::get('pwa.icon')));
        $this->setEnvironmentValue('PWA_SPLASH', 'laravelpwa.manifest.splash.640x1136', asset(Setting::get('pwa.splash')));

        return back();
    }

    public function application(Request $request)
    {
        $request->merge([
            'application.force_download' => $request->get('application.force_download') == 1 ? true : false
        ]);

        Setting::set($request->only('application.text_id', 'application.title', 'application.message', 'application.version', 'application.force_download', 'application.link', 'application.home_message'));

        if ($request->has('application.bg-message')) {
            $this->deleteFile(Setting::get('application.bg-message'));
            Setting::set('application.bg-message', $this->uploadFile('/application', $request->file('application.bg-message')));
        } else {
            Setting::set('application.bg-message', Setting::get('application.bg-message'));
        }


        Setting::save();
        flash(Lang::get('operation completed successfully'))->success();

        return back();
    }
}
