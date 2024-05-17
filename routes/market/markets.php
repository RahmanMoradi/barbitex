<?php
if (Helper::modules()['market']) {
    Route::group(['namespace' => 'Panel\Market', 'prefix' => 'market', 'middleware' => ['balanceError']], function () {
        Route::get('/', 'MarketController@redirect')->name('market.redirect');
        Route::get('{market_symbol}', 'MarketController@show')->name('market.market');
    });

    Route::group(['namespace' => 'Panel\Market', 'prefix' => 'v2/market', 'middleware' => ['balanceError']], function () {
        Route::get('{market_symbol}', 'MarketController@showV2')->name('market.market.v2');
    });
}
