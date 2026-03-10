<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Front\HomeController;
use App\Http\Controllers\Front\ServiceController;
use App\Http\Controllers\Front\PortfolioController;
use App\Http\Controllers\Front\BookingController;

/*
|--------------------------------------------------------------------------
| Front Routes — الواجهة الأمامية
|--------------------------------------------------------------------------
*/

// الصفحة الرئيسية
Route::get('/', [HomeController::class, 'index'])->name('home');

// الأعمال
Route::get('/portfolio', [PortfolioController::class, 'index'])->name('portfolio');

// الخدمات
Route::prefix('services')->name('services.')->group(function () {
    Route::get('/',          [ServiceController::class, 'index'])->name('index');
    Route::get('/events',    [ServiceController::class, 'events'])->name('events');
    Route::get('/marketing', [ServiceController::class, 'marketing'])->name('marketing');
});

// الحجز
Route::prefix('booking')->group(function () {
    Route::get('/',                       [BookingController::class, 'index'])->name('booking');
    Route::post('/',                      [BookingController::class, 'store'])->name('booking.store');
    Route::get('/booked-days',            [BookingController::class, 'bookedDays'])->name('booking.bookedDays');
    Route::get('/check-date',             [BookingController::class, 'checkDate'])->name('booking.check');
    Route::get('/confirmation/{booking}', [BookingController::class, 'confirmation'])->name('booking.confirmation');
    Route::get('/pdf/{booking}',          [BookingController::class, 'pdf'])->name('booking.pdf');
});

// Auth
Auth::routes(['register' => false]);