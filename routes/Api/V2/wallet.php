<?php

Route::group(['prefix' => 'wallet', 'namespace' => 'Wallet', 'middleware' => ['balanceErrorApi']], function () {
    Route::get('assets', 'WalletController@index');
    //Deposit
    Route::get('deposit/{symbol}', 'WalletController@deposit');
    Route::post('deposit/{symbol}', 'WalletController@depositStore')->middleware('userActiveApi', 'cardActiveApi');
    Route::any('deposit/callback/{wallet}', 'WalletController@depositCallback')->name('api.wallet.callback');
    //withdrawal
    Route::post('withdrawal/{symbol}', 'WalletController@withdrawalStore')->middleware('userActiveApi', 'cardActiveApi');

    Route::get('history', 'WalletController@history');

    if (Helper::modules()['global_transfer']) {
        Route::post('transfer', 'WalletController@transfer');
    }
});
