<?php

Route::group(['prefix' => 'analysis', 'namespace' => 'Analysis'], function () {
    Route::get('/', 'AnalysisController@index');
});
