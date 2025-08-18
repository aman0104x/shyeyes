<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ReportController;
use App\Http\Controllers\Api\MessageController;
use App\Http\Controllers\Api\ProfileController;
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

Route::post('/login', [AuthController::class, 'login']);
Route::post('/register/step1', [AuthController::class, 'step1']);


Route::middleware('auth:sanctum')->group(function () {
    Route::post('/register/step2', [AuthController::class, 'step2']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/report', [ReportController::class, 'store'])->name('report.store');
    Route::get('/messages/{userId}', [MessageController::class, 'getMessages']);
    Route::post('/messages', [MessageController::class, 'sendMessage']);
    Route::get('/profile', [ProfileController::class, 'getProfile']);
});
