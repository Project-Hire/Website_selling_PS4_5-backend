<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\AuthController;
use \App\Http\Controllers\VerificationController;

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
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/re_register', [AuthController::class, 're_register']);
    Route::get('email/verify/{id}',[VerificationController::class,'verify'])->name('verification.verify');
    Route::post('email/verify_OTP',[VerificationController::class,'verify_OTP']);
    Route::post('email/logout_OTP',[VerificationController::class,'logout_OTP']);
});


