<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Services\BookingService;
use App\Models\Booking\Booking;
use App\Models\Event\EventLocation;
use App\Models\Event\EventPackage;
use App\Models\Event\AdPackage;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function __construct(protected BookingService $bookingService)
    {
    }

    /**
     * صفحة الحجز الرئيسية
     */
public function index(Request $request)
{
    $eventLocations = EventLocation::pluck('name', 'id');
 
    $eventPackages = EventPackage::where('is_active', true)
        ->orderByDesc('is_featured')
        ->orderBy('sort_order')
        ->get();
 
    $adMonthlyPackages = AdPackage::where('is_active', true)
        ->where('type', 'monthly')
        ->orderByDesc('is_featured')
        ->orderBy('sort_order')
        ->get();
 
    $adCustomPackages = AdPackage::where('is_active', true)
        ->where('type', 'custom')
        ->orderByDesc('is_featured')
        ->orderBy('sort_order')
        ->get();
 
    // ── قيم افتراضية ──
    $preselectedPackage     = null;
    $preselectedPackageType = null;
 
    // ── استقبال الباقة المختارة من صفحة الخدمات ──
    $packageId   = $request->query('package_id');
    $packageType = $request->query('type'); // 'event' | 'ads'
 
    if ($packageId && $packageType) {
        if ($packageType === 'event') {
            $preselectedPackage = EventPackage::find($packageId);
        } elseif ($packageType === 'ads') {
            $preselectedPackage = AdPackage::find($packageId);
        }
 
        if ($preselectedPackage) {
            $preselectedPackageType = $packageType;
        }
    }
 
    return view('front.booking.index', compact(
        'eventLocations',
        'eventPackages',
        'adMonthlyPackages',
        'adCustomPackages',
        'preselectedPackage',
        'preselectedPackageType'
    ));
}

    /**
     * حفظ الحجز الجديد
     */
    public function store(Request $request)
    {
        $serviceType = $request->input('service_type');

        if (!in_array($serviceType, ['event', 'ads'], true)) {
            return back()
                ->withErrors(['service_type' => 'نوع الخدمة غير صالح.'])
                ->withInput();
        }

        $rules = [
            'service_type' => 'required|in:event,ads',
            'package_type' => 'required|string|max:50',
            'package_id'   => 'required|integer',
            'ads_type'     => 'nullable|in:monthly,custom',
            'name'         => 'required|string|max:255',
            'phone'        => 'required|string|max:50',
            'email'        => 'nullable|email|max:255',
            'notes'        => 'nullable|string',
            ];

        if ($serviceType === 'event') {
            $rules += [
                'event_date'            => 'required|date|after_or_equal:today',
                'event_location_id'     => 'nullable',
                'custom_event_location' => 'nullable|string|max:255',
            ];
        }

        if ($serviceType === 'ads') {
            $rules += [
                'event_date'    => 'required|date|after_or_equal:today',
                'business_name' => 'nullable|string|max:255',
                'budget'        => 'nullable|numeric|min:0', // للشهرية يُخفى من النموذج والسعر من الباقة
                'deadline'      => 'nullable|date|after_or_equal:today',
            ];
        }

        $validated = $request->validate($rules);

        // التحقق من التاريخ للحفلات
        if ($serviceType === 'event') {
            $dateCheck = $this->bookingService->getDateStatus($validated['event_date']);

            if ($dateCheck['status'] !== 'available') {
                return back()
                    ->withErrors(['event_date' => 'هذا التاريخ غير متاح للحجز.'])
                    ->withInput();
            }
        }

        // إيجاد أو إنشاء العميل
        $client = $this->bookingService->findOrCreateClient($validated);

        // إنشاء الحجز
        $booking = $this->bookingService->createBooking($validated, $client);

        // منح العميل كلمة مرور تلقائية إذا لم يكن لديه (تُعرض في صفحة التأكيد وفي PDF)
        $clientLogin = $client->email ?: $client->phone;
        if (!$client->password) {
            $plainPassword = \Illuminate\Support\Str::random(10);
            $client->password = $plainPassword;
            $client->save();
            $bid = $booking->id;
            session()->put('booking_' . $bid . '_client_login', $clientLogin);
            session()->put('booking_' . $bid . '_client_password', $plainPassword);
            session()->flash('client_login', $clientLogin);
            session()->flash('client_password', $plainPassword);
            return redirect()->route('booking.confirmation', $booking->id)
                ->with('client_login', $clientLogin)
                ->with('client_password', $plainPassword);
        }

        return redirect()->route('booking.confirmation', $booking->id);
    }

    /**
     * التحقق من توفر التاريخ (AJAX)
     */
    public function checkDate(Request $request)
    {
        $date        = $request->input('date');
        $serviceType = $request->input('service_type');

        if (!$date || !strtotime($date)) {
            return response()->json(['status' => 'error', 'message' => 'تاريخ غير صالح.'], 422);
        }

        if ($serviceType !== 'event') {
            return response()->json(['status' => 'available', 'message' => '✅ هذا اليوم متاح']);
        }

        $result = $this->bookingService->getDateStatus($date);

        return response()->json([
            'status'  => $result['status'],
            'message' => $result['message'],
        ]);
    }

    /**
     * صفحة تأكيد الحجز
     */
    public function confirmation(Booking $booking)
    {
        $meta = $this->bookingService->getBookingMeta($booking);
        $bid = $booking->id;
        $clientLogin   = session('client_login') ?: session('booking_' . $bid . '_client_login');
        $clientPassword = session('client_password') ?: session('booking_' . $bid . '_client_password');
        if (!$clientLogin && $booking->client) {
            $clientLogin = $booking->client->email ?: $booking->client->phone;
        }

        return view('front.booking.confirmation', [
            'booking'        => $booking,
            'packageName'   => $meta['packageName'],
            'packagePrice'  => $meta['packagePrice'],
            'locationName'  => $meta['locationName'],
            'clientLogin'   => $clientLogin,
            'clientPassword' => $clientPassword,
        ]);
    }

    /**
     * تحميل PDF الحجز
     */
    public function pdf(Booking $booking)
    {
        $meta = $this->bookingService->getBookingMeta($booking);
        $client = $booking->client;
        $clientLogin   = session('booking_' . $booking->id . '_client_login') ?: session('client_login') ?: ($client ? ($client->email ?: $client->phone) : ($booking->email ?: $booking->phone));
        $clientPassword = session('booking_' . $booking->id . '_client_password') ?: session('client_password');

        $pdf = Pdf::loadView('front.booking.pdf', [
            'booking'        => $booking,
            'packageName'   => $meta['packageName'],
            'packagePrice'  => $meta['packagePrice'],
            'locationName'  => $meta['locationName'],
            'clientLogin'   => $clientLogin,
            'clientPassword' => $clientPassword,
        ]);

        // إزالة كلمة السر من الجلسة بعد تضمينها في PDF (للمرور الواحد فقط)
        session()->forget('booking_' . $booking->id . '_client_password');
        session()->forget('booking_' . $booking->id . '_client_login');

        return $pdf->download('booking-' . $booking->id . '.pdf');
    }
}