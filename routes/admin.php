<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\BookingsController;
use App\Http\Controllers\Admin\PortfolioItemsController;
use App\Http\Controllers\Admin\EventPackagesController;
use App\Http\Controllers\Admin\AdPackagesController;
use App\Http\Controllers\Admin\ClientsController;
use App\Http\Controllers\Admin\EmployeesController;
use App\Http\Controllers\Admin\EventLocationController;
use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\Admin\RolesController;
use App\Http\Controllers\Admin\PermissionsController;
use App\Http\Controllers\Admin\CompanyController;
use App\Http\Controllers\Admin\BookingsCalendarController;
use App\Http\Controllers\Admin\FaqController;
use App\Http\Controllers\Admin\TestimonialController;
use App\Http\Controllers\Admin\ClientMessagesController;
use App\Http\Controllers\Admin\BookingPaymentsController;
use App\Http\Controllers\Admin\BookingFilesController;

/*
|--------------------------------------------------------------------------
| Admin Routes — لوحة الإدارة
|--------------------------------------------------------------------------
*/

Route::prefix('admin')->name('admin.')->middleware(['auth'])->group(function () {

    // Dashboard
    Route::get('/',     [HomeController::class, 'index'])->name('home');

    // ─── المدفوعات ────────────────────────────────────────
    Route::post('bookings/payments',
        [\App\Http\Controllers\Admin\BookingPaymentsController::class, 'store'])
        ->name('bookings.payments.store');

    Route::delete('bookings/payments/{payment}',
        [\App\Http\Controllers\Admin\BookingPaymentsController::class, 'destroy'])
        ->name('bookings.payments.destroy');

    Route::patch('bookings/{booking}/total',
        [\App\Http\Controllers\Admin\BookingPaymentsController::class, 'updateTotal'])
        ->name('bookings.payments.update-total');

    // ─── الملفات ──────────────────────────────────────────
    Route::post('bookings/files',
        [\App\Http\Controllers\Admin\BookingFilesController::class, 'store'])
        ->name('bookings.files.store');

    Route::patch('bookings/files/{file}/toggle',
        [\App\Http\Controllers\Admin\BookingFilesController::class, 'toggleVisibility'])
        ->name('bookings.files.toggle');

    Route::delete('bookings/files/{file}',
        [\App\Http\Controllers\Admin\BookingFilesController::class, 'destroy'])
        ->name('bookings.files.destroy');

    // ─── الحجوزات ────────────────────────────────────────
    Route::get('bookings/calendar', [BookingsCalendarController::class, 'index'])->name('bookings.calendar');
    Route::get('bookings/{booking}/pdf',               [BookingsController::class, 'pdf'])->name('bookings.pdf');
    Route::patch('bookings/{booking}/status',          [BookingsController::class, 'updateStatus'])->name('bookings.updateStatus');
    Route::patch('bookings/{booking}/details',         [BookingsController::class, 'updateDetails'])->name('bookings.updateDetails');
    Route::patch('bookings/{booking}/final-video',   [BookingsController::class, 'updateFinalVideo'])->name('bookings.finalVideo');
    Route::resource('bookings', BookingsController::class)->only(['index', 'show', 'destroy']);
    Route::post('bookings/photos', [\App\Http\Controllers\Admin\BookingPhotosController::class, 'store'])->name('bookings.photos.store');
    Route::delete('bookings/photos/{photo}', [\App\Http\Controllers\Admin\BookingPhotosController::class, 'destroy'])->name('bookings.photos.destroy');

    // ─── البورتفوليو ──────────────────────────────────────
    Route::resource('portfolio-items', PortfolioItemsController::class);

    // ─── الأسئلة الشائعة ─────────────────────────────────
    Route::resource('faqs', FaqController::class)->except(['show']);

    // ─── آراء العملاء ───────────────────────────────────
    Route::post('testimonials/{testimonial}/approve', [TestimonialController::class, 'approve'])->name('testimonials.approve');
    Route::post('testimonials/{testimonial}/reject', [TestimonialController::class, 'reject'])->name('testimonials.reject');
    Route::resource('testimonials', TestimonialController::class)->except(['show']);

    // ─── الباقات ──────────────────────────────────────────
    Route::resource('event-packages', EventPackagesController::class);
    Route::resource('ad-packages',    AdPackagesController::class);

    // ─── العملاء ──────────────────────────────────────────
    Route::post('clients/{client}/toggle-login', [ClientsController::class, 'toggleLogin'])->name('clients.toggle-login');
    Route::post('clients/{client}/reset-password', [ClientsController::class, 'resetPassword'])->name('clients.reset-password');
    Route::delete('clients/destroy', [ClientsController::class, 'massDestroy'])->name('clients.massDestroy');
    Route::resource('clients', ClientsController::class);
    Route::get('client-messages', [ClientMessagesController::class, 'index'])->name('client-messages.index');
    Route::get('client-messages/{message}', [ClientMessagesController::class, 'show'])->name('client-messages.show');
    Route::patch('client-messages/{message}/read', [ClientMessagesController::class, 'markRead'])->name('client-messages.mark-read');

    // ─── الموظفون ─────────────────────────────────────────
    Route::delete('employees/destroy', [EmployeesController::class, 'massDestroy'])->name('employees.massDestroy');
    Route::resource('employees', EmployeesController::class);

    // ─── قاعات الأفراح ────────────────────────────────────
    Route::resource('eventlocations', EventLocationController::class);


    // ─── المستخدمون والصلاحيات ───────────────────────────
    Route::delete('permissions/destroy', [PermissionsController::class, 'massDestroy'])->name('permissions.massDestroy');
    Route::resource('permissions', PermissionsController::class);

    Route::delete('roles/destroy', [RolesController::class, 'massDestroy'])->name('roles.massDestroy');
    Route::resource('roles', RolesController::class);

    Route::delete('users/destroy', [UsersController::class, 'massDestroy'])->name('users.massDestroy');
    Route::resource('users', UsersController::class);

    // ─── الشركة ───────────────────────────────────────────
    Route::get('company',        [CompanyController::class, 'index'])->name('company');
    Route::get('company/edit',   [CompanyController::class, 'edit'])->name('company.edit');
    Route::patch('company',      [CompanyController::class, 'update'])->name('company.update');

});
