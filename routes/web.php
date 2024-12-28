<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\IdBadgeController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ReservationHistoryController;
use Illuminate\Support\Facades\Route;

Route::get('/register', function () {
    return view('register');
});
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/profile/edit', [AuthController::class, 'edit'])->name('profile.edit');
    Route::put('/profile/update', [AuthController::class, 'update'])->name('profile.update');
    Route::put('/profile/update-password', [AuthController::class, 'updatePassword'])->name('profile.update.password');
});

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::resource('admin', AdminController::class);
    Route::resource('user', UserController::class);
    Route::resource('id-badges', IdBadgeController::class);
});
Route::middleware(['auth', 'role:user'])->group(function () {
    Route::resource('reservation', ReservationController::class);
    Route::resource('reservation-history', ReservationHistoryController::class);
    Route::get('/reservations/export/all', [ReservationController::class, 'exportAll'])->name('reservation.export.all');
    Route::get('/reservations/export/user', [ReservationController::class, 'exportUser'])->name('reservation.export.user');
});
