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
 * Checkout & Payment
 */
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\PaymentController;

/**
 * Admin controllers
 */
use App\Http\Controllers\Admin\DashboardController as AdminDashboard;
use App\Http\Controllers\Admin\HotelController     as AdminHotel;
use App\Http\Controllers\Admin\RoomController      as AdminRoom;
use App\Http\Controllers\Admin\BookingController   as AdminBooking;
use App\Http\Controllers\Admin\PaymentController   as AdminPayment;

/**
 * Middleware class (tanpa alias)
 */
use App\Http\Middleware\EnsureUserIsAdmin;

/* ------------------------------------------------------------------
| Landing + alias dashboard
-------------------------------------------------------------------*/
Route::get('/', fn () => view('home'))->name('home');

/**
 * Alias "dashboard":
 * - Admin  -> ke admin.dashboard
 * - User/Guest -> ke home
 */
Route::get('/dashboard', function () {
    if (Auth::check() && Auth::user()->role === 'admin') {
        return redirect()->route('admin.dashboard');
    }
    return redirect()->route('home');
})->name('dashboard');

/* ------------------------------------------------------------------
| Public (tanpa login)
-------------------------------------------------------------------*/
Route::get('/hotels',               [HotelController::class, 'index'])->name('hotels.index');
Route::get('/hotels/{hotel}',       [HotelController::class, 'show'])->name('hotels.show');
Route::get('/hotels/{hotel}/rooms', [RoomController::class,  'index'])->name('rooms.index');

/* ------------------------------------------------------------------
| Authentication (basic)
-------------------------------------------------------------------*/
Route::middleware('guest')->group(function () {
    Route::get('/login',    [LoginController::class,    'showLoginForm'])->name('login');
    Route::post('/login',   [LoginController::class,    'login'])->name('login.attempt');

    Route::get('/register', [RegisterController::class, 'showRegisterForm'])->name('register');
    Route::post('/register',[RegisterController::class, 'register'])->name('register.store');
});

/** Logout POST (aman) */
Route::post('/logout', [LoginController::class, 'logout'])
    ->name('logout')
    ->middleware('auth');

/** (Opsional) Logout GET — praktis (hapus jika tak diperlukan) */
Route::get('/logout', function () {
    if (Auth::check()) {
        Auth::logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();
    }
    return redirect()->route('home')->with('status', 'Berhasil logout.');
})->name('logout.get');

/* ------------------------------------------------------------------
| Customer (wajib login)
-------------------------------------------------------------------*/
Route::middleware('auth')->group(function () {
    // Booking
    Route::get('/bookings',       [BookingController::class, 'index'])->name('bookings.index');
    Route::get('/booking/create', [BookingController::class, 'create'])->name('bookings.create');
    Route::post('/booking',       [BookingController::class, 'store'])->name('bookings.store');

    // Checkout & pembayaran
    Route::get ('/checkout/{booking}',     [CheckoutController::class,'show'])->name('checkout.show');
    Route::post('/checkout/{booking}/pay', [PaymentController::class,'create'])->name('payments.create');
});

// Hasil pembayaran (finish URL)
Route::get('/payments/result', [PaymentController::class,'result'])->name('payments.result');

// MOCK (dev tanpa server key)
Route::get ('/payments/mock',        [PaymentController::class,'mock'])->name('payments.mock');
Route::post('/payments/mock/notify', [PaymentController::class,'mockNotify'])->name('payments.mock.notify');

// Webhook (provider → server kamu)
Route::post('/payments/notify', [PaymentController::class,'notify'])->name('payments.notify');

/* ------------------------------------------------------------------
| Admin (wajib login + role admin)
-------------------------------------------------------------------*/
Route::middleware(['auth', EnsureUserIsAdmin::class])
    ->prefix('admin')
    ->as('admin.')
    ->group(function () {
        Route::get('/dashboard', [AdminDashboard::class, 'index'])->name('dashboard');

        // CRUD Hotels & Rooms
        Route::resource('/hotels', AdminHotel::class);
        Route::resource('/rooms',  AdminRoom::class);

        // Booking management
        Route::get('/bookings',                     [AdminBooking::class, 'index'])->name('bookings.index');
        Route::patch('/bookings/{booking}/confirm', [AdminBooking::class, 'confirm'])->name('bookings.confirm');
        Route::patch('/bookings/{booking}/cancel',  [AdminBooking::class, 'cancel'])->name('bookings.cancel');

        // Payments (admin)
        Route::get   ('/payments',                    [AdminPayment::class,'index'])->name('payments.index');
        Route::get   ('/payments/export/csv',         [AdminPayment::class,'exportCsv'])->name('payments.export.csv');
        Route::get   ('/payments/{payment}',          [AdminPayment::class,'show'])->name('payments.show');
        Route::patch ('/payments/{payment}/mark-paid',[AdminPayment::class,'markPaid'])->name('payments.markPaid');
        Route::patch ('/payments/{payment}/mark-failed',[AdminPayment::class,'markFailed'])->name('payments.markFailed');
        Route::post  ('/payments/{payment}/refund',   [AdminPayment::class,'refund'])->name('payments.refund');
    });
