<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ShipmentController;
use App\Http\Controllers\MidtransController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Raja Ongkir API routes
Route::prefix('shipping')->group(function () {
    Route::get('/provinces', [ShipmentController::class, 'getProvinces']);
    Route::get('/cities', [ShipmentController::class, 'getCities']);
    Route::post('/calculate', [ShipmentController::class, 'calculateShipping']);
    Route::post('/track', [ShipmentController::class, 'trackShipment']);
}); 

// Midtrans payment gateway routes
Route::post('/midtrans/notification', [MidtransController::class, 'notificationHandler']);
Route::get('/midtrans/finish', [MidtransController::class, 'finishRedirect']);
Route::get('/midtrans/unfinish', [MidtransController::class, 'unfinishRedirect']);
Route::get('/midtrans/error', [MidtransController::class, 'errorRedirect']);