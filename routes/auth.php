<?php

Route::get('panel/login', 'User\LoginController@show')->name('login');
Route::post('panel/login', 'User\LoginController@login')->name('login.login');
Route::view('panel/register', 'auth.register')->name('register');
Route::get('panel/validate/code', 'User\RegisterController@validateCode')->name('validate')->middleware('auth');
Route::post('panel/validate/code', 'User\RegisterController@validateCodePost')->name('register.validate')->middleware('auth');
Route::post('panel/register', 'User\RegisterController@register')->name('register.register');
Route::view('panel/ForgetPassword', 'auth.login')->name('ForgetPassword');
Route::post('panel/ForgetPassword', 'User\LoginController@forget')->name('ForgetPassword.post');
Route::get('panel/logout', function () {
    Auth::logout();
    Auth::guard('admin')->logout();
    flash('شما با موفقیت خارج شدید')->success();

    return redirect(route('login'));
})->name('logout');


Route::get('admin/login', 'Admin\LoginController@show')->name('admin.login');
Route::post('admin/login', 'Admin\LoginController@login')->name('admin.login.login');

Route::get('admin/validate/code', 'Admin\LoginController@validateCode')->name('admin.validate')->middleware('auth:admin');
Route::post('admin/validate/code', 'Admin\LoginController@validateCodePost')->name('admin.register.validate')->middleware('auth:admin');
