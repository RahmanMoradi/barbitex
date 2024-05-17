<?php

Route::group(['prefix' => 'metaverse', 'namespace' => 'Metaverse'], function () {
    Route::get('/', 'MetaverseController@index');
});
