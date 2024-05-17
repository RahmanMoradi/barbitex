<?php

Route::group(['prefix' => 'affiliate', 'namespace' => 'Affiliate'], function () {
    Route::get('index', 'AffiliateController@index');
});
