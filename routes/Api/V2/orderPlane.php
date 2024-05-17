<?php

Route::group(['prefix' => 'order', 'namespace' => 'Order', 'middleware' => ['userActiveApi', 'cardActiveApi','balanceErrorApi']], function () {
    Route::get('index', 'OrderController@index');
    Route::get('{id}', 'OrderController@show');
    Route::post('store', 'OrderController@store');
});
