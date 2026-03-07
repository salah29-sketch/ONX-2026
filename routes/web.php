<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\ReservationController;

use App\Http\Controllers\Admin\HomeController as AdminHomeController;
use App\Http\Controllers\Admin\PermissionsController as AdminPermissionsController;
use App\Http\Controllers\Admin\EventPackagesController as AdminEventPackagesController;
use App\Http\Controllers\Admin\AdpackageController as AdminAdpackageController;
use App\Http\Controllers\Admin\RolesController as AdminRolesController;
use App\Http\Controllers\Admin\UsersController as AdminUsersController;
use App\Http\Controllers\Admin\ServicesController as AdminServicesController;
use App\Http\Controllers\Admin\EmployeesController as AdminEmployeesController;
use App\Http\Controllers\Admin\ClientsController as AdminClientsController;
use App\Http\Controllers\Admin\AppointmentsController as AdminAppointmentsController;
use App\Http\Controllers\Admin\SystemCalendarController as AdminSystemCalendarController;
use App\Http\Controllers\Admin\AdminController as AdminSettingsController;
use App\Http\Controllers\Admin\EditableContentController as AdminEditableContentController;
use App\Http\Controllers\Admin\GalleryController as AdminGalleryController;
use App\Http\Controllers\Admin\CompanyController as AdminCompanyController;
use App\Http\Controllers\Admin\EventLocationController as AdminEventLocationController;
use App\Http\Controllers\Admin\BookingsController as AdminBookingsController;
use App\Http\Controllers\Admin\BookingsCalendarController as AdminBookingsCalendarController;

/*
|--------------------------------------------------------------------------
| Front Routes (موقع الزوار)
|--------------------------------------------------------------------------
*/

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/portfolio', [HomeController::class, 'portfolio'])->name('portfolio');

Route::get('/services', [ServiceController::class, 'index'])->name('services.index');
Route::get('/services/events', [ServiceController::class, 'events'])->name('services.events');
Route::get('/services/marketing', [ServiceController::class, 'marketing'])->name('services.marketing');

/*
|--------------------------------------------------------------------------
| Booking Routes
|--------------------------------------------------------------------------
*/

Route::get('/booking', [BookingController::class, 'index'])->name('booking');
Route::get('/booking/booked-days', [BookingController::class, 'bookedDays'])->name('booking.bookedDays');
Route::get('/booking/check', [BookingController::class, 'checkDate'])->name('booking.check');

Route::post('/booking', [ReservationController::class, 'store'])->name('booking.store');
Route::get('/booking/confirmation/{booking}', [ReservationController::class, 'confirmation'])->name('booking.confirmation');
Route::get('/booking/{booking}/pdf', [ReservationController::class, 'pdf'])->name('booking.pdf');

/*
|--------------------------------------------------------------------------
| API Reservation (اختياري)
|--------------------------------------------------------------------------
*/

Route::post('/reservation-api', [ReservationController::class, 'store']);

/*
|--------------------------------------------------------------------------
| Misc
|--------------------------------------------------------------------------
*/

Route::get('/saleh', [HomeController::class, 'saleh']);
Route::redirect('/home', '/admin');

/*
|--------------------------------------------------------------------------
| Auth
|--------------------------------------------------------------------------
*/

Auth::routes(['register' => false]);

/*
|--------------------------------------------------------------------------
| Translation JS
|--------------------------------------------------------------------------
*/

Route::get('/lang.js', function () {
    $translations = [
        'booking' => __('booking'),
        'home'    => __('home'),
    ];

    $js = 'window.translations = ' . json_encode($translations, JSON_UNESCAPED_UNICODE) . ';';

    return response($js)->header('Content-Type', 'application/javascript');
});

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/

Route::group([
    'prefix' => 'admin',
    'as' => 'admin.',
    'middleware' => ['auth']
], function () {

    // Dashboard
    Route::get('/', [AdminHomeController::class, 'index'])->name('home');

    // Permissions
    Route::delete('permissions/destroy', [AdminPermissionsController::class, 'massDestroy'])->name('permissions.massDestroy');
    Route::resource('permissions', AdminPermissionsController::class);

    // Event Packages
    Route::resource('event-packages', AdminEventPackagesController::class);

    // Ad Packages
    Route::resource('adpackages', AdminAdpackageController::class);

    // Roles
    Route::delete('roles/destroy', [AdminRolesController::class, 'massDestroy'])->name('roles.massDestroy');
    Route::resource('roles', AdminRolesController::class);

    // Users
    Route::delete('users/destroy', [AdminUsersController::class, 'massDestroy'])->name('users.massDestroy');
    Route::resource('users', AdminUsersController::class);

    // Services
    Route::delete('services/destroy', [AdminServicesController::class, 'massDestroy'])->name('services.massDestroy');
    Route::post('services/media', [AdminServicesController::class, 'storeMedia'])->name('services.storeMedia');
    Route::resource('services', AdminServicesController::class);

    // Employees
    Route::delete('employees/destroy', [AdminEmployeesController::class, 'massDestroy'])->name('employees.massDestroy');
    Route::post('employees/media', [AdminEmployeesController::class, 'storeMedia'])->name('employees.storeMedia');
    Route::resource('employees', AdminEmployeesController::class);

    // Clients
    Route::delete('clients/destroy', [AdminClientsController::class, 'massDestroy'])->name('clients.massDestroy');
    Route::resource('clients', AdminClientsController::class);

    // Appointments
    Route::delete('appointments/destroy', [AdminAppointmentsController::class, 'massDestroy'])->name('appointments.massDestroy');
    Route::resource('appointments', AdminAppointmentsController::class);
    Route::post('appointments/{appointment}/confirm', [AdminAppointmentsController::class, 'confirm'])->name('appointments.confirm');

    // System Calendar
    Route::get('system-calendar', [AdminSystemCalendarController::class, 'index'])->name('systemCalendar');

    // Settings
    Route::get('settings/home', [AdminSettingsController::class, 'edit'])->name('settings.page');
    Route::post('settings/inlineUpdate', [AdminSettingsController::class, 'updateInline'])->name('update.inline');
    Route::post('settings/servUpdate', [AdminSettingsController::class, 'update'])->name('update.serivesList');

    Route::post('editable-content/update', [AdminEditableContentController::class, 'update'])->name('editable.update');
    Route::post('editable-content/upload-image', [AdminEditableContentController::class, 'uploadImage'])->name('editable.uploadImage');

    // Gallery
    Route::get('gallery', [AdminGalleryController::class, 'index'])->name('gallery.index');
    Route::post('gallery', [AdminGalleryController::class, 'store'])->name('gallery.store');
    Route::delete('gallery/{id}', [AdminGalleryController::class, 'destroy'])->name('gallery.destroy');
    Route::post('gallery/toggle-home/{id}', [AdminGalleryController::class, 'toggleHome'])->name('gallery.toggleHome');

    // Company
    Route::get('company', [AdminCompanyController::class, 'index'])->name('company');
    Route::post('company-settings', [AdminCompanyController::class, 'update'])->name('company.update');

    // Event Locations
    Route::delete('eventlocations/destroy', [AdminEventLocationController::class, 'massDestroy'])->name('eventlocations.massDestroy');
    Route::resource('eventlocations', AdminEventLocationController::class)->except(['show']);

    // Bookings
    Route::get('bookings-calendar', [AdminBookingsCalendarController::class, 'index'])->name('bookings.calendar');
    Route::post('bookings/{booking}/status', [AdminBookingsController::class, 'updateStatus'])->name('bookings.updateStatus');
    Route::post('bookings/{booking}/update-details', [AdminBookingsController::class, 'updateDetails'])->name('bookings.updateDetails');
    Route::resource('bookings', AdminBookingsController::class)->only(['index', 'show', 'destroy']);
});