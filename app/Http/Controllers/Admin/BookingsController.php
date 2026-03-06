<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\EventLocation;
use Illuminate\Http\Request;

class BookingsController extends Controller
{
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
        $booking->load(['client', 'eventLocation', 'eventPackage', 'adPackage']);
        $eventLocations = EventLocation::pluck('name', 'id');

        return view('admin.bookings.show', compact('booking', 'eventLocations'));
    }

    public function updateStatus(Request $request, Booking $booking)
    {
        $data = $request->validate([
            'status' => 'required|in:unconfirmed,confirmed,in_progress,completed,cancelled',
        ]);

        $booking->update([
            'status' => $data['status'],
        ]);

        return redirect()
            ->route('admin.bookings.show', $booking->id)
            ->with('message', 'تم تحديث حالة الحجز بنجاح.');
    }

    public function updateDetails(Request $request, Booking $booking)
    {
        $rules = [
            'notes' => 'nullable|string',
        ];

        if ($booking->service_type === 'event') {
            $rules = array_merge($rules, [
                'event_date' => 'required|date',
                'event_location_id' => 'nullable',
                'custom_event_location' => 'nullable|string|max:255',
            ]);
        }

        if ($booking->service_type === 'ads') {
            $rules = array_merge($rules, [
                'business_name' => 'nullable|string|max:255',
                'budget' => 'nullable|numeric|min:0',
                'deadline' => 'nullable|date',
            ]);
        }

        $data = $request->validate($rules);

        if ($booking->service_type === 'event') {
            $exists = Booking::where('id', '!=', $booking->id)
                ->where('service_type', 'event')
                ->whereDate('event_date', $data['event_date'])
                ->whereIn('status', ['unconfirmed', 'confirmed', 'in_progress'])
                ->exists();

            if ($exists) {
                return back()->withErrors([
                    'event_date' => 'هذا التاريخ محجوز بالفعل لحجز آخر.',
                ])->withInput();
            }

            if (($request->input('event_location_id') === 'other') && !$request->filled('custom_event_location')) {
                return back()->withErrors([
                    'custom_event_location' => 'اكتب مكان الحفل.',
                ])->withInput();
            }

            $booking->event_date = $data['event_date'];

            if (($request->input('event_location_id') ?? null) === 'other') {
                $booking->event_location_id = null;
                $booking->custom_event_location = $request->input('custom_event_location');
            } else {
                $booking->event_location_id = $request->input('event_location_id') ?: null;
                $booking->custom_event_location = $request->input('custom_event_location');
            }
        }

        if ($booking->service_type === 'ads') {
            $booking->business_name = $data['business_name'] ?? null;
            $booking->budget = $data['budget'] ?? null;
            $booking->deadline = $data['deadline'] ?? null;
        }

        $booking->notes = $data['notes'] ?? null;
        $booking->save();

        return redirect()
            ->route('admin.bookings.show', $booking->id)
            ->with('message', 'تم تحديث بيانات الحجز بنجاح.');
    }

    public function destroy(Booking $booking)
    {
        $booking->delete();

        return redirect()
            ->route('admin.bookings.index')
            ->with('message', 'تم حذف الحجز بنجاح.');
    }
}