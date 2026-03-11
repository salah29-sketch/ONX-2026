<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\ClientMessage;
use App\Models\BookingPhoto;
use App\Models\ClientSelectedPhoto;
use App\Models\Testimonial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('client.auth');
    }

    public function dashboard()
    {
        $client = Auth::guard('client')->user();
        $bookings = $client->bookings()->latest()->take(5)->get();
        $unreadMessages = $client->messages()->whereNull('admin_read_at')->count();
        return view('client.dashboard', compact('client', 'bookings', 'unreadMessages'));
    }

    public function profile()
    {
        $client = Auth::guard('client')->user();
        return view('client.profile', compact('client'));
    }

    public function updateProfile(Request $request)
    {
        $client = Auth::guard('client')->user();
        $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'required|string|max:50',
        ]);
        $client->update($request->only('name', 'email', 'phone'));
        return back()->with('success', 'تم تحديث البيانات.');
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password'         => 'required|string|min:6|confirmed',
        ]);
        $client = Auth::guard('client')->user();
        if (!Hash::check($request->current_password, $client->password)) {
            return back()->withErrors(['current_password' => 'كلمة المرور الحالية غير صحيحة.']);
        }
        $client->password = $request->password;
        $client->save();
        return back()->with('success', 'تم تغيير كلمة المرور.');
    }

    public function bookings()
    {
        $client = Auth::guard('client')->user();
        $bookings = $client->bookings()->latest()->paginate(10);
        return view('client.bookings', compact('bookings'));
    }

    public function bookingDetail(Booking $booking)
    {
        $client = Auth::guard('client')->user();
        if ($booking->client_id !== $client->id) {
            abort(404);
        }
        $booking->load('photos');
        $meta = app(\App\Services\BookingService::class)->getBookingMeta($booking);
        return view('client.booking-detail', compact('booking', 'meta'));
    }

    public function messages()
    {
        $client = Auth::guard('client')->user();
        $messages = $client->messages()->latest()->paginate(15);
        return view('client.messages', compact('messages'));
    }

    public function storeMessage(Request $request)
    {
        $request->validate([
            'subject' => 'nullable|string|max:255',
            'message' => 'required|string|max:2000',
        ]);
        $client = Auth::guard('client')->user();
        $client->messages()->create([
            'subject' => $request->subject,
            'message' => $request->message,
        ]);
        return back()->with('success', 'تم إرسال رسالتك.');
    }

    public function createReview()
    {
        return view('client.review-create');
    }

    public function storeReview(Request $request)
    {
        $request->validate([
            'content' => 'required|string|max:2000',
            'rating'  => 'required|integer|min:1|max:5',
        ]);
        $client = Auth::guard('client')->user();
        Testimonial::create([
            'client_id'   => $client->id,
            'client_name' => $client->name,
            'content'     => $request->content,
            'rating'      => $request->rating,
            'initial'     => mb_substr($client->name, 0, 1),
            'status'      => Testimonial::STATUS_PENDING,
            'is_active'   => false,
        ]);
        return redirect()->route('client.dashboard')->with('success', 'تم إرسال رأيك. سيظهر في الموقع بعد المصادقة.');
    }

    /** قائمة مشاريعك التي تحتوي على صور (مشاهدة وتحميل واختيار حتى 200 مميزة) */
    public function projectPhotos()
    {
        $client = Auth::guard('client')->user();
        $bookings = $client->bookings()->whereHas('photos')->latest()->get();
        $selectedCount = $client->selectedPhotos()->count();
        return view('client.project-photos', compact('bookings', 'selectedCount'));
    }

    /** صور حجز واحد: مشاهدة، تحميل، اختيار كمميزة (حد 200 إجمالاً) */
    public function projectPhotosBooking(Booking $booking)
    {
        $client = Auth::guard('client')->user();
        if ($booking->client_id !== $client->id) {
            abort(404);
        }
        $photos = $booking->photos()->orderBy('sort_order')->get();
        $selectedIds = $client->selectedPhotos()->pluck('booking_photo_id')->toArray();
        $selectedCount = $client->selectedPhotos()->count();
        return view('client.project-photos-booking', compact('booking', 'photos', 'selectedIds', 'selectedCount'));
    }

    /** تفعيل/إلغاء اختيار صورة كمميزة (الحد 200) */
    public function toggleSelectedPhoto(Request $request)
    {
        $request->validate(['booking_photo_id' => 'required|exists:booking_photos,id']);
        $client = Auth::guard('client')->user();
        $photo = BookingPhoto::findOrFail($request->booking_photo_id);
        if ($photo->booking->client_id !== $client->id) {
            return response()->json(['ok' => false], 403);
        }
        $existing = ClientSelectedPhoto::where('client_id', $client->id)->where('booking_photo_id', $photo->id)->first();
        if ($existing) {
            $existing->delete();
            return response()->json(['ok' => true, 'selected' => false, 'count' => $client->selectedPhotos()->count()]);
        }
        if ($client->selectedPhotos()->count() >= 200) {
            return response()->json(['ok' => false, 'message' => 'الحد الأقصى 200 صورة مميزة.'], 422);
        }
        ClientSelectedPhoto::create(['client_id' => $client->id, 'booking_photo_id' => $photo->id]);
        return response()->json(['ok' => true, 'selected' => true, 'count' => $client->selectedPhotos()->count()]);
    }
}
