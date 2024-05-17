<?php

Route::group(['prefix' => 'vip', 'namespace' => 'Vip', 'middleware' => 'role:manage-vip'], function () {
    Route::view('packages', 'admin.vip.packages');
});

