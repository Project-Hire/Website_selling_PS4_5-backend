<?php

use App\Http\Controllers\AdvertisementController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CDGameController;
use App\Http\Controllers\GameConsoleController;
use App\Http\Controllers\GiftCardController;
use App\Http\Controllers\TrademarkController;
use App\Http\Controllers\VerificationController;
use App\Http\Controllers\AccessoryController;
use App\Http\Controllers\PaymentAccessoryController;
use App\Http\Controllers\PaymentCDGameController;
use App\Http\Controllers\VoucherController;

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

Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'
], function ($router) {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/refresh', [AuthController::class, 'refresh']);
    Route::get('/user-profile', [AuthController::class, 'userProfile']);
    Route::post('/update_profile', [AuthController::class, 'updateProfile']);
    Route::post('/change_password', [AuthController::class, 'changePassword']);
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/re_register', [AuthController::class, 're_register']);

    Route::post('email/verify_OTP',[VerificationController::class,'verify_OTP']);
    Route::post('email/logout_OTP',[VerificationController::class,'logout_OTP']);
});

Route::group([
    'middleware' => 'api',
    'prefix' => 'advertise'
], function ($router) {
    Route::get('/', [AdvertisementController::class, 'index']);
    Route::post('/store', [AdvertisementController::class, 'store']);
    Route::get('/detail/{id}', [AdvertisementController::class, 'detail']);
    Route::post('/delete/{id}', [AdvertisementController::class, 'delete']);
    Route::put('/update', [AdvertisementController::class, 'update']);
});

Route::group([
    'middleware' => 'api',
    'prefix' => 'cd_games'
], function ($router) {
    Route::get('/', [CDGameController::class, 'index']);
    Route::get('/detail/{id}', [CDGameController::class, 'detail']);
    Route::post('/store', [CDGameController::class, 'store']);
    Route::post('/delete/{id}', [CDGameController::class, 'delete']);
    Route::post('/update', [CDGameController::class, 'update']);

});

Route::group([
    'middleware' => 'api',
    'prefix' => 'trademarks'
], function ($router) {
    Route::get('/', [TrademarkController::class, 'index']);
    Route::get('/detail/{id}', [TrademarkController::class, 'detail']);
    Route::post('/store', [TrademarkController::class, 'store']);
    Route::post('/delete/{id}', [TrademarkController::class, 'delete']);
    Route::post('/update', [TrademarkController::class, 'update']);
});

Route::group([
    'middleware' => 'api',
    'prefix' => 'game_consoles'
], function ($router) {
    Route::get('/', [GameConsoleController::class, 'index']);
    Route::get('/detail/{id}', [GameConsoleController::class, 'detail']);
    Route::post('/store', [GameConsoleController::class, 'store']);
    Route::post('/delete/{id}', [GameConsoleController::class, 'delete']);
    Route::post('/update', [GameConsoleController::class, 'update']);
});

Route::group([
    'middleware' => 'api',
    'prefix' => 'gift_card'
], function ($router) {
    Route::get('/', [GiftCardController::class, 'index']);
    Route::get('/detail/{id}', [GiftCardController::class, 'detail']);
    Route::post('/store', [GiftCardController::class, 'store']);
    Route::post('/delete/{id}', [GiftCardController::class, 'delete']);
    Route::post('/update', [GiftCardController::class, 'update']);
});

Route::group([
    'middleware' => 'api',
    'prefix' => 'accessory'
], function ($router) {
    Route::get('/', [AccessoryController::class, 'index']);
    Route::get('/detail/{id}', [AccessoryController::class, 'detail']);
    Route::post('/store', [AccessoryController::class, 'store']);
    Route::post('/delete/{id}', [AccessoryController::class, 'delete']);
    Route::post('/update', [AccessoryController::class, 'update']);
});

Route::group([
    'middleware' => 'api',
    'prefix' => 'payment_accessory'
], function ($router) {
    Route::get('/', [PaymentAccessoryController::class, 'index']);
    Route::get('/detail/{id}', [PaymentAccessoryController::class, 'detail']);
    Route::post('/store', [PaymentAccessoryController::class, 'store']);
    Route::post('/delete/{id}', [PaymentAccessoryController::class, 'delete']);
});

Route::group([
    'middleware' => 'api',
    'prefix' => 'payment_cdGame'
], function ($router) {
    Route::get('/', [PaymentCDGameController::class, 'index']);
    Route::get('/detail/{id}', [PaymentCDGameController::class, 'detail']);
    Route::post('/store', [PaymentCDGameController::class, 'store']);
    Route::post('/delete/{id}', [PaymentCDGameController::class, 'delete']);
    Route::get('/history', [PaymentCDGameController::class, 'paymentByUserID']);
});

Route::group([
    'middleware' => 'api',
    'prefix' => 'voucher'
], function ($router) {
    Route::get('/', [VoucherController::class, 'index']);
    Route::post('/get-voucher', [VoucherController::class, 'getVoucherDiscount']);
});
