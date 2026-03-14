<?php

namespace App\Services;

use App\Models\Appointment;
use App\Models\Employee;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Mail\BookingConfirmationMail;

class AppointmentService
{
    /**
     * Create a new appointment from a public booking request.
     *
     * @param array $data Validated data (name, email, phone, date, services, event_location_id, custom_event_location)
     * @param int   $clientId
     * @return Appointment
     */
    public function createFromBooking(array $data, int $clientId): Appointment
    {
        $randomEmployee = Employee::inRandomOrder()->first();

        $appointment = Appointment::create([
            'client_id'             => $clientId,
            'employee_id'           => optional($randomEmployee)->id,
            'start_time'            => $data['date'],
            'finish_time'           => Carbon::parse($data['date'])->addHours(4),
            'status'                => 0,
            'event_location_id'     => isset($data['event_location_id']) && is_numeric($data['event_location_id'])
                                        ? $data['event_location_id']
                                        : null,
            'custom_event_location' => ($data['event_location_id'] ?? null) === 'other'
                                        ? ($data['custom_event_location'] ?? null)
                                        : null,
            'price'                 => $data['total_price'] ?? 0,
        ]);

        $appointment->services()->sync($data['services']);

        return $appointment;
    }

    /**
     * Confirm an appointment, optionally saving a deposit amount.
     */
    public function confirm(Appointment $appointment, ?float $deposit = null): Appointment
    {
        if ($deposit !== null) {
            $appointment->deposit = $deposit;
        }

        $appointment->status = 1;
        $appointment->save();

        return $appointment;
    }

    /**
     * Send booking confirmation email. Logs failure without throwing.
     */
    public function sendConfirmationEmail(array $mailData): bool
    {
        try {
            Mail::to($mailData['email'])->send(new BookingConfirmationMail($mailData));
            return true;
        } catch (\Exception $e) {
            Log::error('فشل إرسال بريد تأكيد الحجز: ' . $e->getMessage());
            return false;
        }
    }
}
