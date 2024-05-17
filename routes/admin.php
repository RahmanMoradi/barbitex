<?php

//admin route
Route::group([], function () {
    Route::get('/', 'AdminController@index'); //done

    Route::get('currencies', 'CurrencyController@index')->middleware('role:currency-index'); //done

    Route::get('orders', 'OrderController@index')->middleware('role:manage-orders');

    Route::get('wallet/decrement', 'WalletController@decrement')->middleware('role:manage-users')->name('admin.wallet.index');
    Route::get('wallets', 'WalletController@list')->middleware('role:manage-users')->name('admin.wallet.list');
    Route::get('wallet/balance', 'WalletController@balance')->middleware('role:manage-users')->name('admin.wallet.balance');

    if (Helper::modules()['market']) {
        Route::get('markets', 'MarketController@index')->middleware('role:manage-market');
        Route::get('markets/commission', 'MarketController@commission')->middleware('role:manage-market');
    }

    Route::get('tickets', 'TicketController@index')->middleware('role:manage-tickets'); //done
    Route::get('ticket/{id}', 'TicketController@show')->middleware('role:manage-tickets'); //done

    Route::view('users', 'admin.users.index')->name('admin.user.index')->middleware('role:manage-users'); //done
    Route::get('user/{user}', 'UserController@show')->name('admin.user.show')->middleware('role:manage-users'); //done


    Route::get('documents', 'DocumentController@index')->middleware('role:manage-users'); //done

    Route::get('cards', 'CardController@index')->middleware('role:manage-users'); //done

    Route::get('settings', 'SettingController@index')->middleware('role:manage-settings'); //done
    Route::post('setting/store', 'SettingController@PriceStore')->name('admin.setting.store.price')->middleware('role:manage-settings'); //done
    Route::post('setting', 'SettingController@store')->name('admin.setting.store')->middleware('role:manage-settings'); //done
    Route::post('setting/pages', 'SettingController@pageStore')->name('admin.setting.store.page')->middleware('role:manage-settings'); //done
    Route::post('setting/payment', 'SettingController@payment')->name('admin.setting.store.payment')->middleware('role:manage-settings'); //done
    Route::post('setting/binance', 'SettingController@binance')->name('admin.setting.store.binance')->middleware('role:manage-settings'); //done
    Route::post('setting/userLevel', 'SettingController@userLevel')->name('admin.setting.store.userLevel')->middleware('role:manage-settings'); //done
    Route::post('setting/pwa', 'SettingController@pwa')->name('admin.setting.store.pwa')->middleware('role:manage-settings'); //done
    Route::post('setting/application', 'SettingController@application')->name('admin.setting.store.application')->middleware('role:manage-settings'); //done

    Route::get('posts', 'PostController@index')->middleware('role:manage-post');
    Route::get('posts/create', 'PostController@create')->middleware('role:manage-post')->name('admin.article.create');
    Route::get('posts/{post}', 'PostController@show')->middleware('role:manage-post')->name('admin.article.edit');
    Route::post('posts/edit/{post}', 'PostController@update')->middleware('role:manage-post')->name('admin.article.update');
    Route::post('posts', 'PostController@Store')->middleware('role:manage-post')->name('admin.article.store');
    Route::get('posts/category', 'PostController@category')->middleware('role:manage-post');
    Route::get('post/remove/{post}', 'PostController@remove')->middleware('role:manage-post')->name('admin.article.destroy');

    Route::get('admins', 'AdminController@admins')->name('admin.admin.index')->middleware('role:manage-admin');
    Route::post('admins', 'AdminController@store')->name('admin.admin.store')->middleware('role:manage-admin');
    Route::post('admin/edit/{admin}', 'AdminController@adminEdit')->name('admin.admin.update')->middleware('role:manage-admin');
    Route::get('admin/{admin}', 'AdminController@admin')->name('admin.admin.edit')->middleware('role:manage-admin');
    Route::get('admin/delete/{admin}', 'AdminController@destroy')->name('admin.admin.delete')->middleware('role:manage-admin');
    Route::post('admin/password/update', 'AdminController@changePassword')->name('admin.admin.update.password')->middleware('role:manage-admin');

    Route::resource('roles', 'RoleController', [
        'as' => 'admin',
        'expect' => ['show']
    ])->middleware('role:manage-roles');
    Route::resource('permissions', 'PermissionController', [
        'as' => 'admin',
        'expect' => ['show']
    ])->middleware('role:manage-roles');

    Route::post('/ckeditor/uploads', 'UploadController@upload')->name('admin.ckeditor.upload');

    Route::get('config/theme/{theme}', 'AdminController@changeTheme')->name('admin.config.theme')->where('theme', 'dark|light');


    if (Helper::modules()['vip']) {
        include "admin/vip.php";
    }

    if (Helper::modules()['tournament']) {
        include "admin/tournament.php";
    }

    Route::view('notifications', 'Notifications.notification-list')->name('admin.notifications');
    Route::view('logs', 'Logs.log-list')->name('admin.logs');
});
