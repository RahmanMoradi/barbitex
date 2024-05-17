<?php

Route::group(['prefix' => 'order', 'namespace' => 'Order', 'middleware' => ['userActive', 'cardActive', 'balanceError']], function () {
    Route::view('create', 'panel.order.create')->name('order.create');
    Route::view('show/{order}', 'panel.order.show',['order'])->name('order.show');
});
