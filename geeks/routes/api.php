<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Apicontroller;
use App\Http\Controllers\AuthController;
use PHPUnit\TextUI\XmlConfiguration\Group;

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

Route::group([

    'prefix' => 'auth'

], function () {

    Route::post('CreateUser', [AuthController::class, 'CreateUser']);
    Route::post('login', [AuthController::class, 'login']);
    Route::get('GetUsers', [AuthController::class, 'GetUsers']);
    Route::get('GetUser/{id}', [AuthController::class, 'GetUser']);
    Route::put('UpdateUser/{id}', [AuthController::class, 'UpdateUser']);
    Route::delete('DeleteUser/{id}', [AuthController::class, 'DeleteUser']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('refresh', 'AuthController@refresh');
    Route::post('me', 'AuthController@me');

});