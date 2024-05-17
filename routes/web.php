<?php

use anlutro\LaravelSettings\Facade as Setting;
use App\Broadcasting\SmsChanel;
use App\Events\Currency\UpdatePrice;
use App\Events\Market\BalanceUpdateEvent;
use App\Jobs\User\Vip\VipArticleNotificationToUsers;
use App\Models\Admin\Admin;
use App\Models\Network\Network;
use App\Models\Traid\Market\MarketOrder;
use App\Models\User;
use App\Models\vip\VipUsers;
use App\Models\Webazin\Binance\Facades\Binance as Api;
use App\Models\Webazin\Kucoin\Facades\Kucoin;
use App\Notifications\Admin\SendNotificationToAdmin;
use App\Notifications\User\SendLoginCodeNotification;
use App\Notifications\User\SendNotificationToUsers;
use App\Services\TraitService\SendNotification;
use Carbon\Carbon;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
use phpseclib\Net\SSH2;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/', 'Home\HomeController@index');
Route::get('blog', 'Home\BlogController@index')->name('home.blog');
Route::get('blog/{slug}', 'Home\BlogController@show')->name('home.blog.show');
Route::get('page/{page}', 'Home\PageController@show')->name('home.page.show');
Route::post('search', 'Home\BlogController@search')->name('search');
Route::any('/wallet/callback/{wallet}', 'Panel\WalletController@callback')->name('panel.wallet.callback');
Route::get('/wallet/perfectmoney/redirect/{wallet}', 'Panel\WalletController@redirectPm')->name('panel.wallet.redirect.perfectmoney');
Route::any('/wallet/perfectmoney/callback/{hash}', 'Panel\WalletController@callbackPm')->name('panel.wallet.callback.perfectmoney');
Route::get('chart/{symbol}', function ($symbol) {
    $market = \App\Models\Traid\Market\Market::where('symbol', $symbol)->firstOrFail();
    return view('charts.chart', compact('market'));
});
Route::get('old-to-new', 'Convert\ConvertController@index');

include "market/markets.php";

Route::any('redirect/{refId}', function ($refId) {
    return view('gateway::mellat-redirector')->with(compact('refId'));
});

Route::get('ref/{id}', function ($id) {
    return redirect(\route('register', ['ref' => $id]));
});

Route::get('clear', function () {
    \Illuminate\Support\Facades\Artisan::call('optimize:clear');
});

Route::get('test2', function () {
    \Illuminate\Support\Facades\Artisan::call('key:generate');
});

Route::get('getIp', function () {
    \Illuminate\Support\Facades\Artisan::call('queue:clear');
    return \Illuminate\Support\Facades\Http::get('ipinfo.io/ip')->body();
});

Route::get('cron/{type}', function ($type) {
    if ($type === 'currency-price') {
        \Illuminate\Support\Facades\Artisan::call('currency:getUsdtPrice');
        \Illuminate\Support\Facades\Artisan::call('currency:getPrice');
    }
    if ($type === 'queue') {
        \Illuminate\Support\Facades\Artisan::call('queue:work --stop-when-empty');
    }
    if ($type === 'schedule') {
        \Illuminate\Support\Facades\Artisan::call('schedule:run');
    }
});
Route::view('wallet/redirect', 'gateway::mellat-redirector')->name('panel.wallet.redirect');
Auth::routes(['verify' => true]);
