<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DetailStayController;
use App\Http\Controllers\VehicleController;
use App\Http\Controllers\VehicleTypeController;

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

// Auth Routes
Route::group(
    ['prefix' => 'auth'],
    function ($router) {

        Route::post('/register', [AuthController::class, 'register'])->name('register');
        Route::post('/login', [AuthController::class, 'login'])->name('login');
        Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
        Route::post('/refresh', [AuthController::class, 'refresh'])->name('refresh');
        Route::post('/me', [AuthController::class, 'me'])->name('me');
    }
);


Route::group(['prefix' => 'catalogs'], function ($router) {
    // Vehicule Types
    Route::resource('/vehicle-types', VehicleTypeController::class)->names('api.catalogs.vehicle-types');

    // Vehicles
    Route::resource('/vehicles', VehicleController::class)->names('api.catalogs.vehicles');
});

Route::group(['prefix' => 'transactions'], function ($route) {

    // vehicle checkIn
    Route::post('/check-in-register', [DetailStayController::class, 'checkInRegister'])->name('api.transaction.check-in-register');
    Route::post('/check-out-register', [DetailStayController::class, 'checkOutRegister'])->name('api.transaction.check-out-register');
    Route::post('/resident-report', [DetailStayController::class, 'residentReport'])->name('api.transaction.resident-report');
    Route::post('/start-month', [DetailStayController::class, 'startMonth'])->name('api.transaction.start-month');
});
