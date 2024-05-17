<?php

use App\Helpers\Helper;
use Illuminate\Http\Request;
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
Route::prefix('v2')->namespace('V2')->group(function () {
    Route::group(['middleware' => ['auth:api', 'isCodeSetApi']], function () {
        //Home Route
        Route::group(['prefix' => 'home', 'namespace' => 'Home'], function () {
            Route::get('currencies', 'HomeController@currencies');
            Route::get('currency/{id}', 'HomeController@currency');
            Route::get('oscillation', 'HomeController@oscillation');
        });

        if (Helper::modules()['wallet']) {
            //Wallet Route
            include 'wallet.php';
        }
        //user Route
        Route::group(['prefix' => 'user', 'namespace' => 'User'], function () {
            Route::get('info', 'UserController@show');
        });

        if (Helper::modules()['orderPlane']) {
            //orderPlane Route
            include 'orderPlane.php';
        }

        if (Helper::modules()['market']) {
            //market Route
            include 'market.php';
        }

        if (Helper::modules()['portfolio']) {
            //market Route
            include 'portfolio.php';
        }

        //ticket Route
        Route::group(['prefix' => 'ticket', 'namespace' => 'Ticket'], function () {
            Route::get('category', 'TicketController@category');
            Route::get('index', 'TicketController@index');
            Route::get('{id}', 'TicketController@show');
            Route::post('store', 'TicketController@store');
            Route::post('answer', 'TicketController@update');
        });

        //authentication Route
        Route::group(['prefix' => 'authentication', 'namespace' => 'Authentication'], function () {
            Route::post('profile', 'AuthenticationController@profile');
            Route::post('password', 'AuthenticationController@password');

            Route::post('sms_login_status', 'AuthenticationController@smsLoginStatus');
            Route::post('email_login_status', 'AuthenticationController@emailLoginStatus');
            Route::post('g2f_login_status', 'AuthenticationController@g2fLoginStatus');

            //validate mobile
            Route::post('sendCode', 'AuthenticationController@sendCode');
            Route::post('validateCode', 'AuthenticationController@validateCode');
        });

        //card Route
        Route::group(['prefix' => 'card', 'namespace' => 'Card'], function () {
            Route::post('store', 'CardController@store');
            Route::get('bank/list', 'CardController@bankList');
        });
    });

    Route::group(['prefix' => 'auth', 'namespace' => 'Auth'], function () {
        //login
        Route::post('login', 'LoginController@login');
        Route::post('login/validate', 'LoginController@validateCode')->middleware('auth:api');
        //register
        Route::post('register', 'RegisterController@register');
        Route::post('register/validate', 'LoginController@validateCode')->middleware('auth:api');

        Route::post('password/forget', 'ForgetController@forget');
    });

    Route::group(['prefix' => 'page', 'namespace' => 'Page'], function () {
        Route::get('info', 'PageController@page');
    });

    Route::group(['prefix' => 'application', 'namespace' => 'Application'], function () {
        Route::get('version', 'ApplicationController@index');
    });

    include 'affiliate.php';

    if (Helper::modules()['vip']) {
        //vip Route
        include 'vip.php';
    }
    if (Helper::modules()['discount']) {
        //discount Route
        include 'discount.php';
    }
    if (Helper::modules()['accreditation']) {
        //accreditation Route
        include 'accreditation.php';
    }
    if (Helper::modules()['reward']) {
        //reward Route
        include 'reward.php';
    }
    if (Helper::modules()['metaverse']) {
        //metaverse Route
        include 'metaverse.php';
    }
    if (Helper::modules()['analysis']) {
        //analysis Route
        include 'analysis.php';
    }
    if (Helper::modules()['airdrop']) {
        //airdrop Route
        include 'airdrop.php';
    }
});
