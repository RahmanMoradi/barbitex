<?php

Route::group(['prefix' => 'accreditation', 'namespace' => 'Accreditation'], function () {
    Route::get('/', 'AccreditationController@index');
});
