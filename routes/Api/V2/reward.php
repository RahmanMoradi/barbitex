<?php

Route::group(['prefix' => 'reward', 'namespace' => 'Reward'], function () {
    Route::get('/', 'RewardController@index');
});
