<?php

use App\Http\Controllers\Admin\Auth\LogInController;
use App\Http\Controllers\Admin\Auth\LogoutController;
use App\Http\Controllers\Admin\BlogController;
use App\Http\Controllers\TestController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => 'admin'], function () {
    Route::group(['prefix' => 'auth'], function () {
        Route::post('login', LogInController::class);
    });

    Route::group(['middleware' => 'auth:admin'], function () {
        Route::post('auth/logout', LogoutController::class);
        Route::resource('blogs', BlogController::class);
    });

    Route::post('test/{test}', [TestController::class, 'test']);

})->prefix('admin');


