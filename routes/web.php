<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Front\HomeController;
use App\Http\Controllers\Front\ServiceController;
use App\Http\Controllers\Front\PortfolioController;
use App\Http\Controllers\Front\BookingController;
use App\Http\Controllers\Front\ContactController;
use App\Http\Controllers\Front\FaqController;

/*
|--------------------------------------------------------------------------
| Front Routes — الواجهة الأمامية
|--------------------------------------------------------------------------
*/

// robots.txt ديناميكي (يستخدم APP_URL من .env)
Route::get('/robots.txt', function () {
    $base = rtrim(config('app.url'), '/');
    return response(
        "User-agent: *\nDisallow: /admin\nDisallow: /login\nAllow: /\n\nSitemap: {$base}/sitemap.xml\n",
        200,
        ['Content-Type' => 'text/plain; charset=UTF-8']
    );
})->name('robots');

// Sitemap للأرشفة ومحركات البحث
Route::get('/sitemap.xml', function () {
    $base = rtrim(config('app.url'), '/');
    $urls = [
        ['loc' => $base . '/', 'changefreq' => 'weekly', 'priority' => '1.0'],
        ['loc' => $base . '/portfolio', 'changefreq' => 'weekly', 'priority' => '0.9'],
        ['loc' => $base . '/services', 'changefreq' => 'weekly', 'priority' => '0.9'],
        ['loc' => $base . '/services/events', 'changefreq' => 'weekly', 'priority' => '0.8'],
        ['loc' => $base . '/services/marketing', 'changefreq' => 'weekly', 'priority' => '0.8'],
        ['loc' => $base . '/booking', 'changefreq' => 'weekly', 'priority' => '0.9'],
        ['loc' => $base . '/contact', 'changefreq' => 'monthly', 'priority' => '0.8'],
        ['loc' => $base . '/faq', 'changefreq' => 'monthly', 'priority' => '0.7'],
    ];
    $xml = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
    $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";
    foreach ($urls as $u) {
        $xml .= '  <url><loc>' . htmlspecialchars($u['loc']) . '</loc><changefreq>' . $u['changefreq'] . '</changefreq><priority>' . $u['priority'] . '</priority></url>' . "\n";
    }
    $xml .= '</urlset>';
    return response($xml, 200, ['Content-Type' => 'application/xml', 'Charset' => 'UTF-8']);
})->name('sitemap');

// الصفحة الرئيسية
Route::get('/', [HomeController::class, 'index'])->name('home');

// FAQ
Route::get('/faq', [FaqController::class, 'index'])->name('faq');

// صفحة حالة الخدمة (عامة)
Route::get('/status', function () {
    return view('front.status');
})->name('status');

// تواصل معنا (حد الإرسال: 5 رسائل في الدقيقة)
Route::get('/contact', [ContactController::class, 'index'])->name('contact');
Route::post('/contact', [ContactController::class, 'store'])->middleware('throttle:5,1')->name('contact.store');

// الأعمال
Route::get('/portfolio', [PortfolioController::class, 'index'])->name('portfolio');

// الخدمات
Route::prefix('services')->name('services.')->group(function () {
    Route::get('/',          [ServiceController::class, 'index'])->name('index');
    Route::get('/events',    [ServiceController::class, 'events'])->name('events');
    Route::get('/marketing', [ServiceController::class, 'marketing'])->name('marketing');
});

// الحجز (حد معدل الطلبات: 10 طلبات في الدقيقة لتقليل السبام)
Route::prefix('booking')->group(function () {
    Route::get('/',                       [BookingController::class, 'index'])->name('booking');
    Route::post('/',                      [BookingController::class, 'store'])->middleware('throttle:10,1')->name('booking.store');
    Route::get('/booked-days',            [BookingController::class, 'bookedDays'])->name('booking.bookedDays');
    Route::get('/check-date',             [BookingController::class, 'checkDate'])->name('booking.check');
    Route::get('/confirmation/{booking}', [BookingController::class, 'confirmation'])->name('booking.confirmation');
    Route::get('/pdf/{booking}',          [BookingController::class, 'pdf'])->name('booking.pdf');
});

// Auth
Auth::routes(['register' => false]);
// صفحة الحزم والخدمات
Route::get('/packages', [App\Http\Controllers\Front\ServiceController::class, 'packages'])->name('front.packages');

/*
|--------------------------------------------------------------------------
| منطقة العملاء — Client Area
|--------------------------------------------------------------------------
*/
Route::prefix('client')->name('client.')->group(function () {
    Route::get('login', [\App\Http\Controllers\Client\AuthController::class, 'showLoginForm'])->name('login');
    Route::post('login', [\App\Http\Controllers\Client\AuthController::class, 'login'])->middleware('throttle:5,1')->name('login.post');
    Route::get('set-password/{booking}', [\App\Http\Controllers\Client\AuthController::class, 'showSetPassword'])->name('set-password')->whereNumber('booking');
    Route::post('set-password', [\App\Http\Controllers\Client\AuthController::class, 'setPassword'])->name('set-password.post');

    Route::middleware('client.auth')->group(function () {
        Route::post('logout', [\App\Http\Controllers\Client\AuthController::class, 'logout'])->name('logout');
        Route::get('/', [\App\Http\Controllers\Client\DashboardController::class, 'dashboard'])->name('dashboard');
        Route::get('profile', [\App\Http\Controllers\Client\DashboardController::class, 'profile'])->name('profile');
        Route::put('profile', [\App\Http\Controllers\Client\DashboardController::class, 'updateProfile'])->name('profile.update');
        Route::put('password', [\App\Http\Controllers\Client\DashboardController::class, 'changePassword'])->name('password.update');
        Route::get('bookings', [\App\Http\Controllers\Client\DashboardController::class, 'bookings'])->name('bookings');
        Route::get('bookings/{booking}', [\App\Http\Controllers\Client\DashboardController::class, 'bookingDetail'])->name('bookings.show');
        Route::get('messages', [\App\Http\Controllers\Client\DashboardController::class, 'messages'])->name('messages');
        Route::post('messages', [\App\Http\Controllers\Client\DashboardController::class, 'storeMessage'])->name('messages.store');
        Route::get('review', [\App\Http\Controllers\Client\DashboardController::class, 'createReview'])->name('review.create');
        Route::post('review', [\App\Http\Controllers\Client\DashboardController::class, 'storeReview'])->name('review.store');
        Route::get('project-photos', [\App\Http\Controllers\Client\DashboardController::class, 'projectPhotos'])->name('project-photos');
        Route::get('project-photos/booking/{booking}', [\App\Http\Controllers\Client\DashboardController::class, 'projectPhotosBooking'])->name('project-photos.booking');
        Route::post('project-photos/toggle', [\App\Http\Controllers\Client\DashboardController::class, 'toggleSelectedPhoto'])->name('project-photos.toggle');
        Route::get('payments', [\App\Http\Controllers\Client\DashboardController::class, 'payments'])->name('payments');
        Route::get('subscriptions', [\App\Http\Controllers\Client\DashboardController::class, 'subscriptions'])->name('subscriptions');
        Route::post('subscriptions/{subscription}/renew', [\App\Http\Controllers\Client\DashboardController::class, 'renewSubscription'])->name('subscriptions.renew');
        Route::put('subscriptions/{subscription}/renewal-type', [\App\Http\Controllers\Client\DashboardController::class, 'updateSubscriptionRenewalType'])->name('subscriptions.renewal-type');
        Route::get('media', [\App\Http\Controllers\Client\DashboardController::class, 'media'])->name('media');
        Route::get('files', [\App\Http\Controllers\Client\DashboardController::class, 'files'])->name('files');
   // فاتورة PDF
        Route::get('bookings/{booking}/invoice',
        [\App\Http\Controllers\Client\DashboardController::class, 'invoicePdf'])
        ->name('bookings.invoice');
        Route::get('bookings/{booking}/summary',
        [\App\Http\Controllers\Client\DashboardController::class, 'bookingSummary'])
        ->name('bookings.summary');
        Route::get('bookings/{booking}/booking-pdf',
        [\App\Http\Controllers\Client\DashboardController::class, 'bookingPdf'])
        ->name('bookings.booking-pdf');

    // تحميل ملف
        Route::get('files/{file}/download',
        [\App\Http\Controllers\Client\DashboardController::class, 'downloadFile'])
        ->name('files.download');

    // تحميل الصور المميزة ZIP
        Route::post('project-photos/booking/{booking}/zip',
        [\App\Http\Controllers\Client\DashboardController::class, 'downloadSelectedPhotosZip'])
        ->name('project-photos.zip');
   
        });
});