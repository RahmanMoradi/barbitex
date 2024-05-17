<?php

Route::group(['prefix' => 'airdrop', 'namespace' => 'Airdrop'], function () {
    Route::get('/', 'AirdropController@index');
});
