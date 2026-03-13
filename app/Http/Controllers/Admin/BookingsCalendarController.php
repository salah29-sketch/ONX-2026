<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Carbon\Carbon;

class BookingsCalendarController extends Controller
{
    public function index()
    {
        $eventBookings = Booking::with(['eventLocation', 'client'])
            ->where('service_type', 'event')
            ->whereNotNull('event_date')
            ->whereIn('status', ['unconfirmed', 'confirmed', 'in_progress', 'completed', 'cancelled'])
            ->orderBy('event_date')
            ->get();

        $calendarItems = $eventBookings->map(function ($booking) {
            $locationName = $booking->eventLocation?->name
                ?? $booking->custom_event_location
                ?? '—';
            $clientName = $booking->client?->name ?? $booking->name;

            return [
                'title'   => $clientName,
                'start'   => Carbon::parse($booking->event_date)->format('Y-m-d'),
                'url'     => route('admin.bookings.show', $booking->id),
                'status'  => $booking->status ?? 'unconfirmed',
                'service_type' => $booking->service_type ?? 'event',
                'location_name' => $locationName,
                'location' => $locationName,
            ];
        });

        // إحصائيات لجميع الحجوزات (للعرض في الأعلى)
        $stats = [
            'total'        => Booking::count(),
            'unconfirmed'  => Booking::whereIn('status', ['unconfirmed', 'new'])->count(),
            'confirmed'    => Booking::where('status', 'confirmed')->count(),
            'cancelled'    => Booking::where('status', 'cancelled')->count(),
        ];

        return view('admin.bookings.calendar', [
            'calendarItems' => $calendarItems,
            'stats'         => $stats,
        ]);
    }

    protected function statusLabel(string $status): string
    {
        return match ($status) {
            'unconfirmed' => 'غير مؤكد',
            'confirmed' => 'مؤكد',
            'in_progress' => 'قيد التنفيذ',
            'completed' => 'مكتمل',
            'cancelled' => 'ملغى',
            default => $status,
        };
    }
}