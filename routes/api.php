<?php

use App\Http\Controllers\Api\Inspectors\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Inspectors\InspectorController;
use App\Http\Controllers\Api\Inspectors\ReportController;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group([

    'middleware' => 'api',
    'namespace' => 'Inspectors',
    'prefix' => 'auth/inspectors'

], function () {
    Route::post('login', 'AuthController@login');
    Route::post('reset', 'ForgotPasswordController@forgot');
});

Route::group([
    'middleware' => 'auth:inspector',
    'namespace' => 'Inspectors',
    'prefix' => 'inspector'

], function ($router) {
    Route::get('get-profile', [InspectorController::class,'getProfile'])->middleware('blocked');
    Route::post('edit-profile', 'InspectorController@editProfile')->middleware('blocked');
    Route::post('logout', 'AuthController@logout');
    Route::post('clientDetails', 'InspectorController@formData');
    Route::post('catData', 'InspectorController@catData');
    Route::post('catAllData', 'InspectorController@catAllData');
    Route::get('dataList', 'InspectorController@dataList');
    Route::post('getAllFormData', 'InspectorController@getAllFormData');
    Route::post('saveNarratives', 'InspectorController@saveNarratives');
    Route::post('deleteNarratives', 'InspectorController@deleteNarratives');
    Route::post('deleteClientData', 'InspectorController@deleteClientData');
    Route::post('comments', 'InspectorController@comments');
    Route::post('commentDelete', 'InspectorController@commentDelete');
    Route::post('getComment', 'InspectorController@getComment');
    
});

Route::group([
    'prefix' => 'inspector'
], function (){
    Route::post('refresh-token', [AuthController::class, 'refresh']);
});

Route::group([
    'middleware' => 'auth:inspector',
    'prefix' => 'reports'
], function (){
    Route::post('save', [ReportController::class, 'save'])->middleware('blocked');
});
