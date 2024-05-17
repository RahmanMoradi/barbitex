<?php

Route::group(['prefix' => 'vip', 'namespace' => 'Vip','middleware' => ['balanceErrorApi']], function () {
    Route::get('/', 'VipController@index')->middleware('isVipApi');
    Route::get('packs', 'VipController@packs');
    Route::post('buy', 'VipController@buy');
});
