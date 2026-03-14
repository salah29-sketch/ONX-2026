<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\BookingService;
use App\Models\Booking\Booking;
use App\Models\Event\EventLocation;
use App\Models\Event\EventPackage;
use App\Models\Event\AdPackage;
use Illuminate\Http\Request;

class BookingsController extends Controller
{
    public function __construct(protected BookingService $bookingService)
    {
    }

    public function index(Request $request)
    {
        $query = Booking::with(['client', 'eventLocation', 'eventPackage', 'adPackage'])
            ->latest();

        if ($request->filled('service_type')) {
            $query->where('service_type', $request->service_type);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $bookings = $query->paginate(20);
        $bookings->appends($request->query());

        return view('admin.bookings.index', compact('bookings'));
    }

    public function show(Booking $booking)
    {
        $booking->load(['client', 'eventLocation', 'eventPackage', 'adPackage', 'photos', 'payments', 'files']);
        $eventLocations = EventLocation::pluck('name', 'id');
        $eventPackages = EventPackage::orderBy('name')->pluck('name', 'id');
        $adPackages = AdPackage::orderBy('name')->pluck('name', 'id');
        $clientSelectedPhotos = collect();
        if ($booking->client) {
            $selectedIds = $booking->client->selectedPhotos()->whereIn('booking_photo_id', $booking->photos->pluck('id'))->pluck('booking_photo_id');
            $clientSelectedPhotos = $booking->photos->whereIn('id', $selectedIds);
        }
        $photosPaginated = $booking->photos()->orderBy('id')->paginate(24)->withQueryString();

        return view('admin.bookings.show', compact('booking', 'eventLocations', 'eventPackages', 'adPackages', 'clientSelectedPhotos', 'photosPaginated'));
    }

    public function calendar()
    {
        $bookings = Booking::with(['eventPackage', 'adPackage'])
            ->whereIn('status', ['unconfirmed', 'confirmed', 'in_progress', 'completed'])
            ->whereNotNull('event_date')
            ->get();

        return view('admin.bookings.calendar', compact('bookings'));
    }

    public function updateStatus(Request $request, Booking $booking)
    {
        $data = $request->validate([
            'status' => 'required|in:unconfirmed,confirmed,in_progress,completed,cancelled',
        ]);

        $booking->update(['status' => $data['status']]);

        return redirect()
            ->route('admin.bookings.show', $booking->id)
            ->with('message', 'تم تحديث حالة الحجز بنجاح.');
    }

    public function updateDetails(Request $request, Booking $booking)
    {
        $rules = [
            'notes' => 'nullable|string',
            'status' => 'nullable|in:unconfirmed,confirmed,in_progress,completed,cancelled',
            'total_price' => 'nullable|numeric|min:0',
            'package_id' => 'nullable|integer',
        ];

        if ($booking->service_type === 'event') {
            $rules += [
                'event_date'            => 'required|date',
                'event_location_id'     => 'nullable',
                'custom_event_location' => 'nullable|string|max:255',
            ];
        }

        if ($booking->service_type === 'ads') {
            $rules += [
                'business_name' => 'nullable|string|max:255',
                'budget'        => 'nullable|numeric|min:0',
                'deadline'      => 'nullable|date',
            ];
        }

        $data = $request->validate($rules);

        // التحقق من التاريخ عبر الـ Service
        if ($booking->service_type === 'event' && isset($data['event_date'])) {
            if ($this->bookingService->isDateTakenForUpdate($data['event_date'], $booking->id)) {
                return back()->withErrors([
                    'event_date' => 'هذا التاريخ محجوز بالفعل لحجز آخر.',
                ])->withInput();
            }
        }

        $booking->update($data);

        return redirect()
            ->route('admin.bookings.show', $booking->id)
            ->with('message', 'تم تحديث تفاصيل الحجز بنجاح.');
    }

    public function updateFinalVideo(Request $request, Booking $booking)
    {
        $data = $request->validate([
            'final_video_path' => 'nullable|string|max:500',
        ]);
        $booking->update($data);
        return redirect()
            ->route('admin.bookings.show', $booking->id)
            ->with('message', 'تم تحديث رابط الفيديو النهائي.');
    }

    public function destroy(Booking $booking)
    {
        $booking->delete();

        return redirect()
            ->route('admin.bookings.index')
            ->with('message', 'تم حذف الحجز بنجاح.');
    }

    public function pdf(Booking $booking)
{
    $meta = $this->bookingService->getBookingMeta($booking);

    $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('admin.bookings.pdf', [
        'booking'      => $booking,
        'packageName'  => $meta['packageName'],
        'packagePrice' => $meta['packagePrice'],
        'locationName' => $meta['locationName'],
    ]);

    return $pdf->download('booking-' . $booking->id . '.pdf');
}
}
