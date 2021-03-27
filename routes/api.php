<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\MentalStateController;
use App\Http\Controllers\PhysicalActivityController;
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

// Auth routes
Route::post('/auth/register', [AuthController::class, 'register']);
Route::post('/auth/login', [AuthController::class, 'login']);

Route::group(['middleware' => ['auth:sanctum']], function () {

    Route::post('/auth/logout', [AuthController::class, 'logout']);

    Route::apiResource('physicalactivities',PhysicalActivityController::class);
    Route::apiResource('mentalstates',MentalStateController::class);


    Route::get('/user', function(Request $request) {
        return auth()->user();
    });


});




