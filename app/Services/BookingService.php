<?php

namespace App\Services;

use App\Models\Booking;
use App\Models\Client;
use App\Models\EventPackage;
use App\Models\Adpackage;
use App\Models\EventLocation;

class BookingService
{
    /**
     * التحقق من حالة تاريخ الحجز
     */
    public function getDateStatus(string $date): array
    {
        $bookings = Booking::where('service_type', 'event')
            ->whereDate('event_date', $date)
            ->get();

        foreach ($bookings as $booking) {
            if (in_array($booking->status, ['confirmed', 'in_progress', 'completed'], true)) {
                return [
                    'status'  => 'booked',
                    'message' => '🔴 هذا اليوم محجوز ومؤكد',
                ];
            }

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

    /**
     * إيجاد أو إنشاء العميل
     */
    public function findOrCreateClient(array $data): Client
    {
        $client = Client::where('phone', $data['phone'])
            ->when(!empty($data['email']), function ($query) use ($data) {
                $query->orWhere('email', $data['email']);
            })
            ->first();

        if (!$client) {
            $client = Client::create([
                'name'  => $data['name'],
                'phone' => $data['phone'],
                'email' => $data['email'] ?? null,
            ]);
        } else {
            $client->update([
                'name'  => $data['name'],
                'phone' => $data['phone'],
                'email' => $data['email'] ?? $client->email,
            ]);
        }

        return $client;
    }

    /**
     * إنشاء الحجز بعد التحقق
     */
    public function createBooking(array $data, Client $client): Booking
    {
        $data['client_id'] = $client->id;
        $data['status']    = 'unconfirmed';

        return Booking::create($data);
    }

    /**
     * جلب بيانات الباقة والموقع لصفحة التأكيد والـ PDF
     */
    public function getBookingMeta(Booking $booking): array
    {
        $packageName  = null;
        $packagePrice = null;

        if ($booking->package_type === EventPackage::class) {
            $package = EventPackage::find($booking->package_id);
            if ($package) {
                $packageName  = $package->name;
                $packagePrice = $package->price;
            }
        }

        if ($booking->package_type === Adpackage::class) {
            $package = Adpackage::find($booking->package_id);
            if ($package) {
                $packageName  = $package->name;
                $packagePrice = $package->price;
            }
        }

        $locationName = null;

        if (!empty($booking->custom_event_location)) {
            $locationName = $booking->custom_event_location;
        } elseif (!empty($booking->event_location_id) && $booking->event_location_id !== 'other') {
            $location     = EventLocation::find($booking->event_location_id);
            $locationName = $location ? $location->name : null;
        }

        return [
            'packageName'  => $packageName,
            'packagePrice' => $packagePrice,
            'locationName' => $locationName,
        ];
    }

    /**
     * التحقق من أن التاريخ غير محجوز مسبقاً (عند التعديل من Admin)
     */
    public function isDateTakenForUpdate(string $date, int $excludeBookingId): bool
    {
        return Booking::where('id', '!=', $excludeBookingId)
            ->where('service_type', 'event')
            ->whereDate('event_date', $date)
            ->whereIn('status', ['unconfirmed', 'confirmed', 'in_progress'])
            ->exists();
    }

    /**
     * التحقق من أن التاريخ غير محجوز مسبقاً (عند الحجز الجديد)
     */
    public function isDateTaken(string $date): bool
    {
        return Booking::where('service_type', 'event')
            ->whereDate('event_date', $date)
            ->whereIn('status', ['unconfirmed', 'confirmed', 'in_progress'])
            ->exists();
    }
}
