<?php

namespace App\Services;

use App\Models\Booking\Booking;
use App\Models\Client\Client;
use App\Models\Event\EventPackage;
use App\Models\Event\AdPackage;
use App\Models\Event\EventLocation;

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
     * إيجاد أو إنشاء العميل عند الحجز
     */
    public function findOrCreateClient(array $data): Client
    {
        $phone = trim((string) ($data['phone'] ?? ''));
        $email = isset($data['email']) ? trim((string) $data['email']) : null;
        $name  = trim((string) ($data['name'] ?? ''));
        if ($name === '') {
            $name = $phone ?: $email ?: 'عميل';
        }

        $client = $phone ? Client::where('phone', $phone)->first() : null;
        if (!$client && $email) {
            $client = Client::where('email', $email)->first();
        }

        if (!$client) {
            $client = Client::create([
                'name'  => $name,
                'phone' => $phone ?: null,
                'email' => $email ?: null,
            ]);
        } else {
            $client->update([
                'name'  => $name,
                'phone' => $phone ?: $client->phone,
                'email' => $email ?? $client->email,
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
     *
     * الإصلاح: نتحقق أن الباقة موجودة فعلاً في الجدول الصحيح.
     * إذا كان service_type = 'ads' لكن package_id يشير لباقة حفل → لا نعرضها.
     */
    public function getBookingMeta(Booking $booking): array
    {
        $packageName  = null;
        $packagePrice = null;
        $package      = null;

        if ($booking->package_id) {
            if ($booking->service_type === 'event') {
                // نبحث فقط في event_packages
                $candidate = EventPackage::find($booking->package_id);
                if ($candidate) {
                    $package      = $candidate;
                    $packageName  = $candidate->name;
                    $packagePrice = $candidate->price;
                }
                // إذا لم يُوجد في event_packages → الباقة غير صحيحة، نتركها فارغة

            } elseif ($booking->service_type === 'ads') {
                // نبحث فقط في ad_packages
                $candidate = AdPackage::find($booking->package_id);
                if ($candidate) {
                    $package      = $candidate;
                    $packageName  = $candidate->name;
                    $packagePrice = $candidate->price ?? $candidate->price_note;
                }
                // إذا لم يُوجد في ad_packages → الباقة غير صحيحة، نتركها فارغة
                // هذا يمنع ظهور باقة حفلات بدل باقة إعلانات
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
            'package'      => $package,
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