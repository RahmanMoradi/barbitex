<?php

Route::group(['prefix' => 'vip', 'namespace' => 'Vip', 'middleware' => ['cardActive', 'balanceError']], function () {
    Route::view('/', 'panel.vip.index')->middleware('isVip');
    Route::view('buy', 'panel.vip.index');
});
