<?php

use App\Http\Controllers\API\AppUser\AdminController;
use App\Http\Controllers\API\AppUser\CompanyController;
use App\Http\Controllers\API\Auth\passportAuthController;
use App\Http\Controllers\API\AppUser\SuperUserController;
use App\Http\Controllers\API\LandingController;
use App\Http\Controllers\API\ReserveController;
use App\Http\Controllers\API\TownController;
use App\Http\Controllers\API\TripController;
use App\Http\Controllers\API\VehicleController;
use App\Http\Controllers\API\ZarinPallController;
use App\Models\Trip;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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

//    Route::get('user', [passportAuthController::class, 'authenticatedUserDetails']);

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

    Route::post('/temporaryreserve', [ReserveController::class,'temporaryReserve']);//2

    Route::post('/store', [ReserveController::class, 'store'])->name('store_tickets');

    Route::get('/receipts', [ReserveController::class, 'receipts']);//3

});

Route::get('/landing', [LandingController::class, 'getLandingData']);

Route::get('/reservables', [LandingController::class, 'getReservableVehicles']);

Route::get('/businfo', [ReserveController::class, 'busInfo']);

Route::get('order',[ZarinPallController::class, 'order']);
Route::post('shop',[ZarinPallController::class,'add_order']);

Route::get('tst',[LandingController::class, 'tst']);

//Route::get('/free',[ReserveController::class,'findFreeSeats2'] );

//Route::post('/flush',function (Request $request){
//     $request->session()->flush();
//});
//Route::post('/sessions',function (Request $request){
//    dd($request->session()->all());
//});
