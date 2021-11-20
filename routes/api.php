<?php

use App\Http\Controllers\API\AppUser\AdminController;
use App\Http\Controllers\API\AppUser\CompanyController;
use App\Http\Controllers\API\Auth\passportAuthController;
use App\Http\Controllers\API\AppUser\SuperUserController;
use App\Http\Controllers\API\LandingController;
use App\Http\Controllers\API\TownController;
use App\Http\Controllers\API\TripController;
use App\Http\Controllers\API\VehicleController;
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

//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user();
//});

//routes/api.php
Route::post('register', [passportAuthController::class, 'register']);
Route::post('login', [passportAuthController::class, 'login']);

//add this middleware to ensure that every request is authenticated
Route::middleware('auth:api')->name('api.')->group(function () {

    Route::get('user', [passportAuthController::class, 'authenticatedUserDetails']);

    Route::group(['prefix' => 'superuser', 'middleware' => 'apipermission:super-user'], function () {
        Route::get('dashboard', [SuperUserController::class, 'renderView'])->name('superuser-dashboard');
    });

    Route::group(['prefix' => 'admin', 'middleware' => 'apipermission:admin'], function () {
        Route::get('dashboard', [AdminController::class, 'index'])->name('admin-dashboard');
    });

    Route::group(['prefix' => 'company', 'middleware' => 'apipermission:company'], function () {
        Route::resource('vehicle', VehicleController::class);
        Route::resource('trip', TripController::class);
        Route::resource('town', TownController::class);
        Route::get('dashboard', [CompanyController::class, 'index'])->name('company-dashboard');
    });

});

Route::get('/landing', [LandingController::class, 'getLandingData']);
Route::post('/reservable', [LandingController::class, 'getReservableVehicles']);
