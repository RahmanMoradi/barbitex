<?php

Route::group(['prefix' => 'market', 'namespace' => 'Market', 'middleware' => ['balanceErrorApi']], function () {
    Route::get('list', 'MarketController@index');
    Route::get('{id}', 'MarketController@show');
    Route::post('store', 'MarketController@store')->middleware('cardActiveApi', 'userActiveApi');
    Route::get('order/open/{market_id}', 'MarketController@openOrder');
    Route::get('order/all/{market_id}', 'MarketController@orders');
    Route::get('order/cancel/{market_id}', 'MarketController@cancel');
});
