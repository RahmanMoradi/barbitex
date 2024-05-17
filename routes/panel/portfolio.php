<?php

Route::group(['prefix' => 'portfolio', 'namespace' => 'Portfolio', 'middleware' => 'userActive', 'cardActive'], function () {
    Route::view('/', 'panel.portfolio.portfolios');
});
