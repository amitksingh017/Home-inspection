<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use Illuminate\Support\Facades\Route;

Route::group([
    'prefix' => config('admin.prefix')
], function () {

    if (false === config('admin.auth.custom')) {
        Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');

        Route::post('login', 'Auth\LoginController@login');

        Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');

        Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');

        Route::post('password/reset', 'Auth\ResetPasswordController@reset')->name('reset_password');

        Route::post('register', 'Auth\RegisterController@register')->name('register');
    }

    Route::group([
        'middleware' => 'auth:web'
    ], function () {

        if (false === config('admin.auth.custom')) {
            Route::post('logout', 'Auth\LoginController@logout')->name('logout');
        }

        Route::post('metrics', 'MetricController@load')
            ->name('metric');

        Route::post('multi-action/run', 'MultiActionController@run')
            ->name('multi-action.run');

        Route::get('dashboard', 'DashboardController@index')
            ->name('dashboard');

    });

});
