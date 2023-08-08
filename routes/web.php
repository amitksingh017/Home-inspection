<?php

use App\Http\Controllers\Admins\Auth\LoginController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return redirect()->route('dashboard');
});

Route::group(['prefix'=>'admin', 'middleware'=>'auth:web'], function(){
    
    Route::get('profile', 'UserController@index')->name('users.index');
    Route::get('profile/edit', 'UserController@edit')->name('users.edit');
    Route::post('profile', 'UserController@store')->name('users.store');

    Route::post('change-password', 'UserController@changePassword')->name('change.password');

    Route::resource('inspectors', 'InspectorController');
    Route::get('inspectors/update-password/{inspector}', 'InspectorController@updatePassword')->name('inspectors.update-password');
    Route::post('inspectors/change-password/{inspector}', 'InspectorController@changePassword')->name('inspectors.change-password');

    Route::resource('regions', 'RegionController');
    Route::resource('reports', 'ReportController');
    Route::get('reports/download/{id}', 'ReportController@download')->name('report.download');
});

Route::group(['prefix'=>'admin', 'middleware'=>['auth:web', 'can:super-admin']], function(){

});

Route::group([
    'middleware' => 'auth:web'
], function () {

    if (false === config('admin.auth.custom')) {
        Route::get('logout', 'Auth\LoginController@logout')->name('logout');
    }
});

Route::group(['prefix' => 'admin'], function (){
    Route::post('login', [LoginController::class,'login'])->name('login');
});

Route::get('password_reset/{token}', 'ResetPasswordController@resetPasswordForm')->name('password.form');
Route::post('/save_password', 'ResetPasswordController@reset')->name('save.password');
Route::get('password_changed', 'ResetPasswordController@passwordSuccessfullyChanged')->name('password.changed');