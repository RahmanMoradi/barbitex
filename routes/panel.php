<?php


//panel route
use Illuminate\Support\Facades\Route;

Route::group([], function () {
    Route::get('/', 'PanelController@index');

    Route::get('tickets', 'Ticket\TicketController@index');
    Route::get('ticket/{id}', 'Ticket\TicketController@show');
    if (Helper::modules()['referrals']) {
        Route::get('referrals', 'Referral\ReferralController@index');
    }
    Route::group(['prefix' => 'authentication'], function () {
        Route::get('{action}', 'Authentication\AuthenticationController@index');
    });

});

Route::group(['middleware' => ['userActive', 'cardActive', 'balanceError']], function () {
    if (Helper::modules()['wallet']) {
        Route::view('wallet', 'panel.wallet.index');
        Route::get('wallet/deposit/{currency}', 'WalletController@deposit')->name('panel.wallet.deposit');
        Route::get('wallet/withdraw/{currency}', 'WalletController@withdraw')->name('panel.wallet.withdraw');
        Route::get('wallet/transactions', 'WalletController@transactions')->name('panel.wallet.transactions');
        if (Helper::modules()['global_transfer']) {
            Route::get('wallet/transfer', 'WalletController@transfer')->name('panel.wallet.transfer');
        }
        if (Helper::modules()['cart_to_cart']) {
            Route::get('wallet/cart_to_cart', 'WalletController@cartToCart')->name('panel.wallet.cart_to_cart');
        }
    }
    if (Helper::modules()['market']) {
        Route::get('market/transactions', 'Market\MarketController@transactions')->name('panel.market.transactions');
    }
});

Route::get('config/theme/{theme}', 'PanelController@changeTheme')->name('panel.config.theme')->where('theme', 'dark|light');
if (Helper::modules()['orderPlane']) {
    include "panel/order.php";
}
if (Helper::modules()['portfolio']) {
    include "panel/portfolio.php";
}

if (Helper::modules()['vip']) {
    include "panel/vip.php";
}

Route::view('notifications', 'Notifications.notification-list')->name('panel.notifications');
