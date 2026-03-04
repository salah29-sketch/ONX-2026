<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\BookingConfirmationMail;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\ServiceController;


Route::get('/', [HomeController::class ,'index'])->name('home');
Route::get('/portfolio', [HomeController::class ,'portfolio'])->name('portfolio');
Route::get('/booking', [HomeController::class ,'booking'])->name('booking');
Route::post('/check-appointment', [HomeController::class, 'checkAvailability']);
Route::get('/services', [ServiceController::class, 'index'])->name('services.index');
Route::get('/services/events', [ServiceController::class, 'events'])->name('services.events');
Route::get('/services/ads', [ServiceController::class, 'ads'])->name('services.ads');
// Route::post('/reservation-api', [ReservationController::class, 'store']);


Route::post('/reservation-api', [ReservationController::class, 'store']);

Route::get('/saleh' , [HomeController::class , 'saleh']);

Route::redirect('/home', '/admin');
Auth::routes(['register' => false]);

Route::get('/lang.js', function () {
    $translations = [
        'booking' => __('booking'),
        'home' => __('home'),
        // أضف ملفات لغة أخرى هنا حسب الحاجة
    ];

    $js = 'window.translations = ' . json_encode($translations, JSON_UNESCAPED_UNICODE) . ';';
    return response($js)->header('Content-Type', 'application/javascript');
});



Route::group(['prefix' => 'admin', 'as' => 'admin.', 'namespace' => 'Admin', 'middleware' => ['auth']], function () {
    Route::get('/', 'HomeController@index')->name('home');
    // Permissions
    Route::delete('permissions/destroy', 'PermissionsController@massDestroy')->name('permissions.massDestroy');
    Route::resource('permissions', 'PermissionsController');

    // event-packages
    Route::resource('event-packages', 'EventPackagesController');

    // Roles
    Route::delete('roles/destroy', 'RolesController@massDestroy')->name('roles.massDestroy');
    Route::resource('roles', 'RolesController');

    // Users
    Route::delete('users/destroy', 'UsersController@massDestroy')->name('users.massDestroy');
    Route::resource('users', 'UsersController');

    // Services
    Route::delete('services/destroy', 'ServicesController@massDestroy')->name('services.massDestroy');
    Route::post('services/media', 'ServicesController@storeMedia')->name('services.storeMedia');
    Route::resource('services', 'ServicesController');

    // Employees
    Route::delete('employees/destroy', 'EmployeesController@massDestroy')->name('employees.massDestroy');
    Route::post('employees/media', 'EmployeesController@storeMedia')->name('employees.storeMedia');
    Route::resource('employees', 'EmployeesController');

    // Clients
    Route::delete('clients/destroy', 'ClientsController@massDestroy')->name('clients.massDestroy');
    Route::resource('clients', 'ClientsController');

    // Appointments
    Route::delete('appointments/destroy', 'AppointmentsController@massDestroy')->name('appointments.massDestroy');
    Route::resource('appointments', 'AppointmentsController');
    Route::POST('appointments/{appointment}/confirm', 'AppointmentsController@confirm')->name('appointments.confirm');


    Route::get('system-calendar', 'SystemCalendarController@index')->name('systemCalendar');


    Route::get('settings/home' ,  'AdminController@edit')->name('settings.page');
    Route::post('settings/inlineUpdate' ,'AdminController@updateInline' )->name('update.inline');
    Route::post('settings/servUpdate' ,'AdminController@update' )->name('update.serivesList');
    Route::post('editable-content/update', 'EditableContentController@update')->name('editable.update');
    Route::post('editable-content/upload-image', 'EditableContentController@uploadImage')->name('editable.uploadImage');


    Route::get('/gallery', 'GalleryController@index')->name('gallery.index');
    Route::post('/gallery', 'GalleryController@store')->name('gallery.store');
    Route::delete('/gallery/{id}', 'GalleryController@destroy')->name('gallery.destroy');
    Route::post('/admin/gallery/toggle-home/{id}', 'GalleryController@toggleHome')->name('gallery.toggleHome');


    Route::get('/company' , 'CompanyController@index')->name('company');
    Route::post('/company-settings','CompanyController@update')->name('company.update');

    Route::get('/booking-notes', 'AdminBookingNoteController@edit')->name('booking_notes.edit');
    Route::post('/booking-notes', 'AdminBookingNoteController@update')->name('booking_notes.update');



     Route::delete('event-locations/destroy', 'EventLocationController@massDestroy')->name('event-locations.massDestroy');
     Route::post('event-locations/media', 'EventLocationController@storeMedia')->name('event-locations.storeMedia');
     Route::resource('event-locations', 'EventLocationController');



});
