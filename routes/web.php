<?php

use App\Http\Controllers\API\LandingController;
use App\Http\Controllers\AppUser\AdminController;
use App\Http\Controllers\AppUser\CompanyController;
use App\Http\Controllers\AppUser\SuperUserController;
use App\Http\Controllers\AppUser\UserController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\TownController;
use App\Http\Controllers\TripController;
use App\Http\Controllers\VehicleController;
use Illuminate\Support\Facades\Auth;
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
    return view('main');
})->name('main');

Auth::routes();

Route::group(['prefix' => 'superuser' ,'middleware' => 'permission:super-user'], function (){
    Route::get('dashboard',[SuperUserController::class,'renderView'])->name('superuser-dashboard');
//    Route::get('profile',[AdminController::class,'profile'])->name('superuser-profile');
//    Route::get('settings',[AdminController::class,'settings'])->name('superuser-settings');
});

Route::group(['prefix' => 'admin' , 'middleware' => 'permission:admin'], function (){
    Route::get('dashboard',[AdminController::class,'renderView'])->name('admin-dashboard');
//    Route::get('profile',[AdminController::class,'profile'])->name('admin-profile');
//    Route::get('settings',[AdminController::class,'settings'])->name('admin-settings');
});

Route::group(['prefix' => 'company' , 'middleware' => 'permission:company'], function (){
    Route::resource('vehicle',VehicleController::class);
    Route::resource('trip',TripController::class);
    Route::resource('town',TownController::class);
    Route::get('dashboard',[CompanyController::class,'renderView'])->name('company-dashboard');
//    Route::get('profile',[AdminController::class,'profile'])->name('company-profile');
//    Route::get('settings',[AdminController::class,'settings'])->name('company-settings');
});


Route::group(['prefix' => 'user' , 'middleware' => 'permission:user' ], function (){
    Route::get('dashboard',[UserController::class,'renderView'])->name('user-dashboard');
//    Route::get('profile',[AdminController::class,'profile'])->name('user-profile');
//    Route::get('settings',[AdminController::class,'settings'])->name('user-settings');
});

Route::post('/reservable', [LandingController::class, 'getReservableVehicles']);

