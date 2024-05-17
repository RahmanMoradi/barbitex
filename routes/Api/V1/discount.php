<?php

Route::group(['prefix' => 'discount', 'namespace' => 'Discount'], function () {
    Route::get('/', 'DiscountController@index');
});
