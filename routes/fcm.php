<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('save-device-token', 'Fcm\FcmController@store');
Route::get('test', function () {
//    dd(Auth::guard('api')->user()->fcms->pluck('token')[0]);
    Auth::guard('api')->user()->notifyNow(new \App\Notifications\User\SendNotificationToUsers('تست عنوان','تست متن'));
});
