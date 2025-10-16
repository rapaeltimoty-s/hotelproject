<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

/**
 * Public controllers
 */
use App\Http\Controllers\HotelController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\BookingController;

/**
 * Auth basic (tanpa Breeze)
 */
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;

/**
 * Admin controllers
 */
use App\Http\Controllers\Admin\DashboardController as AdminDashboard;
use App\Http\Controllers\Admin\HotelController     as AdminHotel;
use App\Http\Controllers\Admin\RoomController      as AdminRoom;
use App\Http\Controllers\Admin\BookingController   as AdminBooking;

/**
 * Middleware class (langsung pakai class supaya tidak tergantung alias)
 */
use App\Http\Middleware\EnsureUserIsAdmin;

/* ----------------- Landing ----------------- */
Route::get('/', fn () => view('home'))->name('home');

/* Alias "dashboard" agar link lama tidak error */
Route::get('/dashboard', function () {
    if (Auth::check() && Auth::user()->role === 'admin') {
        return redirect()->route('admin.dashboard');
    }
    return redirect()->route('home');
})->name('dashboard');

/* ----------------- Publik ------------------ */
Route::get('/hotels',               [HotelController::class, 'index'])->name('hotels.index');
Route::get('/hotels/{hotel}',       [HotelController::class, 'show'])->name('hotels.show');
Route::get('/hotels/{hotel}/rooms', [RoomController::class,  'index'])->name('rooms.index');

/* --------------- Auth basic ---------------- */
Route::middleware('guest')->group(function () {
    Route::get('/login',    [LoginController::class,    'showLoginForm'])->name('login');
    Route::post('/login',   [LoginController::class,    'login'])->name('login.attempt');

    Route::get('/register', [RegisterController::class, 'showRegisterForm'])->name('register');
    Route::post('/register',[RegisterController::class, 'register'])->name('register.store');
});
Route::post('/logout', [LoginController::class, 'logout'])
    ->name('logout')
    ->middleware('auth');

/* --------------- Customer ------------------ */
Route::middleware('auth')->group(function () {
    Route::get('/bookings',       [BookingController::class, 'index'])->name('bookings.index');
    Route::get('/booking/create', [BookingController::class, 'create'])->name('bookings.create');
    Route::post('/booking',       [BookingController::class, 'store'])->name('bookings.store');
});

/* ----------------- Admin ------------------- */
/* Pakai class middleware langsung agar tidak tergantung alias 'is_admin' */
Route::middleware(['auth', EnsureUserIsAdmin::class])
    ->prefix('admin')->as('admin.')
    ->group(function () {
        Route::get('/dashboard', [AdminDashboard::class, 'index'])->name('dashboard');

        Route::resource('/hotels', AdminHotel::class);
        Route::resource('/rooms',  AdminRoom::class);

        Route::get('/bookings',                     [AdminBooking::class, 'index'])->name('bookings.index');
        Route::patch('/bookings/{booking}/confirm', [AdminBooking::class, 'confirm'])->name('bookings.confirm');
        Route::patch('/bookings/{booking}/cancel',  [AdminBooking::class, 'cancel'])->name('bookings.cancel');
    });
