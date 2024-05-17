<?php

Route::group(['prefix' => 'portfolio', 'namespace' => 'Portfolio', 'middleware' => ['userActiveApi']], function () {
    Route::get('/', 'PortfolioController@index');
});
