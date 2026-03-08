<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EventLocation;
use App\Models\Booking;
use App\Models\EventPackage;
use App\Models\Adpackage;
use Carbon\Carbon;

class BookingController extends Controller
{
    public function index()
    {
        $eventLocations = EventLocation::pluck('name', 'id');

        $eventPackages = EventPackage::where('is_active', true)
            ->orderByDesc('is_featured')
            ->orderBy('sort_order')
            ->get();

        $adMonthlyPackages = Adpackage::where('is_active', true)
            ->where('type', 'monthly')
            ->orderByDesc('is_featured')
            ->orderBy('sort_order')
            ->get();

        $adCustomPackages = Adpackage::where('is_active', true)
            ->where('type', 'custom')
            ->orderByDesc('is_featured')
            ->orderBy('sort_order')
            ->get();

        return view('booking.index', compact(
            'eventLocations',
            'eventPackages',
            'adMonthlyPackages',
            'adCustomPackages'
        ));
    }

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
            'name'         => 'required|string|max:255',
            'phone'        => 'required|string|max:50',
            'email'        => 'nullable|email|max:255',
            'notes'        => 'nullable|string',
        ];

        if ($serviceType === 'event') {
            $rules = array_merge($rules, [
                'event_date'            => 'required|date|after_or_equal:today',
                'event_location_id'     => 'nullable',
                'custom_event_location' => 'nullable|string|max:255',
            ]);
        }

        if ($serviceType === 'ads') {
            $rules = array_merge($rules, [
                'business_name' => 'nullable|string|max:255',
                'budget'        => 'nullable|numeric|min:0',
                'deadline'      => 'nullable|date|after_or_equal:today',
            ]);
        }

        $validated = $request->validate($rules);

        if ($serviceType === 'event') {
            $dateCheck = $this->getDateStatus($validated['event_date']);

            if ($dateCheck['status'] !== 'available') {
                return back()
                    ->withErrors(['event_date' => 'هذا التاريخ غير متاح للحجز.'])
                    ->withInput();
            }
        }

        $booking = new Booking();

        $booking->service_type = $validated['service_type'];
        $booking->package_type = $validated['package_type'];
        $booking->package_id   = $validated['package_id'];

        $booking->name  = $validated['name'];
        $booking->phone = $validated['phone'];
        $booking->email = $validated['email'] ?? null;
        $booking->notes = $validated['notes'] ?? null;

        if ($serviceType === 'event') {
            $booking->event_date = $validated['event_date'];

            if (($validated['event_location_id'] ?? null) === 'other') {
                $booking->event_location_id = null;
                $booking->custom_event_location = $validated['custom_event_location'] ?? null;
            } else {
                $booking->event_location_id = !empty($validated['event_location_id'])
                    ? $validated['event_location_id']
                    : null;
                $booking->custom_event_location = $validated['custom_event_location'] ?? null;
            }

            $booking->business_name = null;
            $booking->budget = null;
            $booking->deadline = null;
        } else {
            $booking->event_date = null;
            $booking->event_location_id = null;
            $booking->custom_event_location = null;

            $booking->business_name = $validated['business_name'] ?? null;
            $booking->budget        = $validated['budget'] ?? null;
            $booking->deadline      = $validated['deadline'] ?? null;
        }

        // الحالة الافتراضية: غير مؤكد = برتقالي
        $booking->status = 'unconfirmed';

        $booking->save();

        return redirect()
            ->route('booking.index')
            ->with('message', 'تم إرسال طلب الحجز بنجاح، سنراجع طلبك ونتواصل معك قريبًا.');
    }

    public function bookedDays(Request $request)
    {
        $serviceType = $request->query('service_type', 'event');

        if ($serviceType !== 'event') {
            return response()->json([
                'confirmed_days' => [],
                'pending_days'   => [],
            ]);
        }

        $bookings = Booking::where('service_type', 'event')
            ->whereNotNull('event_date')
            ->get();

        $confirmedDays = [];
        $pendingDays = [];

        foreach ($bookings as $booking) {
            $day = Carbon::parse($booking->event_date)->format('Y-m-d');

            // أحمر
            if (in_array($booking->status, ['confirmed', 'in_progress', 'completed'], true)) {
                $confirmedDays[] = $day;
                continue;
            }

            // برتقالي
            if ($booking->status === 'unconfirmed') {
                $pendingDays[] = $day;
            }
        }

        return response()->json([
            'confirmed_days' => array_values(array_unique($confirmedDays)),
            'pending_days'   => array_values(array_unique($pendingDays)),
        ]);
    }

    public function checkDate(Request $request)
    {
        $date = $request->query('date');
        $serviceType = $request->query('service_type', 'event');

        if (!$date) {
            return response()->json([
                'status'  => 'error',
                'message' => 'اختر تاريخًا.'
            ], 422);
        }

        if ($serviceType !== 'event') {
            return response()->json([
                'status'  => 'available',
                'message' => '✅ هذا اليوم متاح'
            ]);
        }

        $result = $this->getDateStatus($date);

        return response()->json([
            'status'  => $result['status'],
            'message' => $result['message'],
        ]);
    }

    protected function getDateStatus(string $date): array
    {
        $bookings = Booking::where('service_type', 'event')
            ->whereDate('event_date', $date)
            ->get();

        foreach ($bookings as $booking) {
            // أحمر
            if (in_array($booking->status, ['confirmed', 'in_progress', 'completed'], true)) {
                return [
                    'status'  => 'booked',
                    'message' => '🔴 هذا اليوم محجوز ومؤكد',
                ];
            }

            // برتقالي
            if ($booking->status === 'unconfirmed') {
                return [
                    'status'  => 'pending',
                    'message' => '🟠 هذا اليوم محجوز وغير مؤكد',
                ];
            }
        }

        return [
            'status'  => 'available',
            'message' => '✅ هذا اليوم متاح',
        ];
    }
}