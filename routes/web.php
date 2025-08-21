<?php

use App\Http\Controllers\Controller\Admin\ReportController;
use App\Http\Controllers\Controller\Admin\AuthController as AdminAuthController;
use App\Http\Controllers\Controller\Admin\DashboardController;
use App\Http\Controllers\Controller\Admin\UserController;
use App\Http\Controllers\DownloadController;
use Illuminate\Support\Facades\Route;



/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

// Admin Routes
Route::prefix('admin')->group(function () {
    Route::get('/login', [AdminAuthController::class, 'showLoginForm'])->name('admin.login');
    Route::post('/login', [AdminAuthController::class, 'login']);

    Route::middleware('auth:admin')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
        Route::post('/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');
        Route::get('/profile', [AdminAuthController::class, 'profile'])->name('admin.profile');
        Route::post('/profile/update', [AdminAuthController::class, 'updateProfile'])->name('admin.profile.update');
        Route::post('/change-password', [AdminAuthController::class, 'changePassword'])->name('admin.password.change');
        Route::get('/settings', [AdminAuthController::class, 'settings'])->name('admin.settings');
        Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
        Route::get('/reports/{report}', [ReportController::class, 'show'])->name('reports.show');
        Route::delete('/reports/{report}', [ReportController::class, 'destroy'])->name('reports.destroy');
        Route::get('/reports/{report}/details', [ReportController::class, 'getReportDetails'])->name('reports.details');

        // User Management Routes
        Route::get('/users', [UserController::class, 'index'])->name('admin.users.index');
        Route::get('/users/create', [UserController::class, 'create'])->name('admin.users.create');
        Route::post('/users', [UserController::class, 'store'])->name('admin.users.store');
        Route::get('/users/{user}', [UserController::class, 'show'])->name('admin.users.show');
        Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('admin.users.edit');
        Route::put('/users/{user}', [UserController::class, 'update'])->name('admin.users.update');
        Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('admin.users.destroy');
        Route::post('/users/{user}/status', [UserController::class, 'updateStatus'])->name('admin.users.status.update');
    });
});


