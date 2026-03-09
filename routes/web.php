<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// ─── Front Controllers ───────────────────────────────────────────────────────
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\PortfolioController;

// ─── Admin Controllers ────────────────────────────────────────────────────────
use App\Http\Controllers\Admin\HomeController           as AdminHomeController;
use App\Http\Controllers\Admin\PermissionsController    as AdminPermissionsController;
use App\Http\Controllers\Admin\EventPackagesController  as AdminEventPackagesController;
use App\Http\Controllers\Admin\AdPackagesController     as AdminAdPackagesController;
use App\Http\Controllers\Admin\RolesController          as AdminRolesController;
use App\Http\Controllers\Admin\UsersController          as AdminUsersController;
use App\Http\Controllers\Admin\ServicesController       as AdminServicesController;
use App\Http\Controllers\Admin\EmployeesController      as AdminEmployeesController;
use App\Http\Controllers\Admin\ClientsController        as AdminClientsController;
use App\Http\Controllers\Admin\CompanyController        as AdminCompanyController;
use App\Http\Controllers\Admin\EventLocationController  as AdminEventLocationController;
use App\Http\Controllers\Admin\BookingsController       as AdminBookingsController;
use App\Http\Controllers\Admin\BookingsCalendarController as AdminBookingsCalendarController;
use App\Http\Controllers\Admin\PortfolioItemsController as AdminPortfolioItemsController;
use App\Http\Controllers\Admin\EditableContentController as AdminEditableContentController;

// ─── Removed (unused) ─────────────────────────────────────────────────────────
// AdminAppointmentsController   → صفحة المواعيد غير مستخدمة
// AdminSystemCalendarController → التقويم القديم غير مستخدم
// AdminSettingsController       → settings/home غير مستخدم (استُبدل بـ company)
// AdminGalleryController        → gallery القديم استُبدل بـ portfolio-items
// ──────────────────────────────────────────────────────────────────────────────


/*
|--------------------------------------------------------------------------
| الصفحات الرئيسية (Front)
|--------------------------------------------------------------------------
*/

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/portfolio', [PortfolioController::class, 'index'])->name('portfolio.index');

Route::get('/services',           [ServiceController::class, 'index'])->name('services.index');
Route::get('/services/events',    [ServiceController::class, 'events'])->name('services.events');
Route::get('/services/marketing', [ServiceController::class, 'marketing'])->name('services.marketing');


/*
|--------------------------------------------------------------------------
| الحجوزات (Booking)
|--------------------------------------------------------------------------
*/

Route::get('/booking',                        [BookingController::class, 'index'])->name('booking');
Route::get('/booking/booked-days',            [BookingController::class, 'bookedDays'])->name('booking.bookedDays');
Route::get('/booking/check',                  [BookingController::class, 'checkDate'])->name('booking.check');

Route::post('/booking',                       [ReservationController::class, 'store'])->name('booking.store');
Route::get('/booking/confirmation/{booking}', [ReservationController::class, 'confirmation'])->name('booking.confirmation');
Route::get('/booking/{booking}/pdf',          [ReservationController::class, 'pdf'])->name('booking.pdf');


/*
|--------------------------------------------------------------------------
| المصادقة (Auth) — بدون تسجيل مفتوح
|--------------------------------------------------------------------------
*/

Auth::routes(['register' => false]);


/*
|--------------------------------------------------------------------------
| لوحة التحكم (Admin)
|--------------------------------------------------------------------------
*/

Route::group([
    'prefix'     => 'admin',
    'as'         => 'admin.',
    'middleware' => ['auth'],
], function () {

    // ── الرئيسية ──────────────────────────────────────────────────────────
    Route::get('/', [AdminHomeController::class, 'index'])->name('home');


    // ── إدارة الصلاحيات والأدوار والمستخدمين ──────────────────────────────
    Route::delete('permissions/destroy', [AdminPermissionsController::class, 'massDestroy'])->name('permissions.massDestroy');
    Route::resource('permissions', AdminPermissionsController::class);

    Route::delete('roles/destroy', [AdminRolesController::class, 'massDestroy'])->name('roles.massDestroy');
    Route::resource('roles', AdminRolesController::class);

    Route::delete('users/destroy', [AdminUsersController::class, 'massDestroy'])->name('users.massDestroy');
    Route::resource('users', AdminUsersController::class);


    // ── الخدمات ───────────────────────────────────────────────────────────
    Route::delete('services/destroy', [AdminServicesController::class, 'massDestroy'])->name('services.massDestroy');
    Route::post('services/media',     [AdminServicesController::class, 'storeMedia'])->name('services.storeMedia');
    Route::resource('services', AdminServicesController::class);


    // ── الموظفون ──────────────────────────────────────────────────────────
    Route::delete('employees/destroy', [AdminEmployeesController::class, 'massDestroy'])->name('employees.massDestroy');
    Route::post('employees/media',     [AdminEmployeesController::class, 'storeMedia'])->name('employees.storeMedia');
    Route::resource('employees', AdminEmployeesController::class);


    // ── العملاء ───────────────────────────────────────────────────────────
    Route::delete('clients/destroy', [AdminClientsController::class, 'massDestroy'])->name('clients.massDestroy');
    Route::resource('clients', AdminClientsController::class);


    // ── الحجوزات ──────────────────────────────────────────────────────────
    Route::get('bookings-calendar',                    [AdminBookingsCalendarController::class, 'index'])->name('bookings.calendar');
    Route::post('bookings/{booking}/status',           [AdminBookingsController::class, 'updateStatus'])->name('bookings.updateStatus');
    Route::post('bookings/{booking}/update-details',   [AdminBookingsController::class, 'updateDetails'])->name('bookings.updateDetails');
    Route::resource('bookings', AdminBookingsController::class)->only(['index', 'show', 'destroy']);


    // ── باقات الأحداث والإعلانات ──────────────────────────────────────────
    Route::resource('event-packages', AdminEventPackagesController::class);
    Route::resource('ad-packages',    AdminAdPackagesController::class);


    // ── قاعات الأفراح ─────────────────────────────────────────────────────
    Route::delete('eventlocations/destroy', [AdminEventLocationController::class, 'massDestroy'])->name('eventlocations.massDestroy');
    Route::resource('eventlocations', AdminEventLocationController::class)->except(['show']);


    // ── البورتفوليو ───────────────────────────────────────────────────────
    Route::resource('portfolio-items', AdminPortfolioItemsController::class);


    // ── المحتوى القابل للتعديل ────────────────────────────────────────────
    Route::post('editable-content/update',        [AdminEditableContentController::class, 'update'])->name('editable.update');
    Route::post('editable-content/upload-image',  [AdminEditableContentController::class, 'uploadImage'])->name('editable.uploadImage');


    // ── إعدادات الشركة ────────────────────────────────────────────────────
    Route::get('company',          [AdminCompanyController::class, 'index'])->name('company');
    Route::post('company-settings',[AdminCompanyController::class, 'update'])->name('company.update');

});
