<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Booking\Booking;
use App\Models\Booking\BookingFile;
use App\Models\Booking\BookingPhoto;
use App\Models\Client\ClientMediaSeen;
use App\Models\Client\ClientMessage;
use App\Models\Client\ClientMessagesSeen;
use App\Models\Client\ClientSelectedPhoto;
use App\Models\Content\Testimonial;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use ZipArchive;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('client.auth');
    }

    /**
     * Helper: يرجع العميل الحالي مع type hint صحيح لـ Intelephense
     */
    private function client(): \App\Models\Client\Client
    {
        /** @var \App\Models\Client\Client $client */
        $client = Auth::guard('client')->user();
        return $client;
    }

    // ─── Dashboard ───────────────────────────────────────────────

    public function dashboard()
    {
        $client         = $this->client();
        $bookings       = $client->bookings()->with('photos')->latest()->take(5)->get();
        $unreadMessages = $this->clientUnreadMessagesCount($client);
        // الحجز النشط: مؤكد أو قيد التنفيذ؛ إن لم يوجد فأحدث حجز (ليظهر دائماً)
        $activeBooking  = $client->bookings()
            ->whereIn('status', ['confirmed', 'in_progress'])
            ->with(['photos', 'visibleFiles', 'payments'])
            ->latest()->first();
        if (!$activeBooking) {
            $activeBooking = $client->bookings()
                ->with(['photos', 'visibleFiles', 'payments'])
                ->latest()->first();
        }
        $lastMessage    = $client->messages()->latest()->first();
        $hasNewFilesOrVideo = $activeBooking && (
            (filled($activeBooking->final_video_path) || $activeBooking->visibleFiles->isNotEmpty())
            && !$client->mediaSeen()->where('booking_id', $activeBooking->id)->exists()
        );
        // رقم الطلب للعميل: 1، 2، 3... (حسب ترتيب الطلبات)، وليس الـ ID الداخلي
        $clientOrderMap = $this->clientOrderMap($client);

        return view('client.dashboard', compact(
            'client', 'bookings', 'unreadMessages', 'activeBooking',
            'lastMessage', 'hasNewFilesOrVideo', 'clientOrderMap'
        ));
    }

    /**
     * عدد رسائل العميل غير المقروءة من الإدارة — تُحسب فقط ما جاء بعد آخر زيارة لصفحة الرسائل.
     */
    private function clientUnreadMessagesCount(\App\Models\Client\Client $client): int
    {
        $query = $client->messages()->whereNull('admin_read_at');
        $lastSeen = ClientMessagesSeen::where('client_id', $client->id)->value('last_seen_at');
        if ($lastSeen) {
            $query->where('created_at', '>', $lastSeen);
        }
        return $query->count();
    }

    /**
     * خريطة: booking_id => رقم الطلب للعميل (1 = أول طلب، 2 = ثاني طلب، ...)
     */
    private function clientOrderMap(\App\Models\Client\Client $client): array
    {
        $ids = $client->bookings()->orderBy('created_at')->orderBy('id')->pluck('id');
        $map = [];
        foreach ($ids as $i => $id) {
            $map[$id] = $i + 1;
        }
        return $map;
    }

    // ─── Profile ─────────────────────────────────────────────────

    public function profile()
    {
        $client = $this->client();
        return view('client.profile', compact('client'));
    }

    public function updateProfile(Request $request)
    {
        $client = $this->client();
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
        $client = $this->client();
        if (!Hash::check($request->current_password, $client->password)) {
            return back()->withErrors(['current_password' => 'كلمة المرور الحالية غير صحيحة.']);
        }
        $client->password = $request->password;
        $client->save();
        return back()->with('success', 'تم تغيير كلمة المرور.');
    }

    // ─── Bookings ────────────────────────────────────────────────

    public function bookings()
    {
        $client         = $this->client();
        $bookings       = $client->bookings()->latest()->paginate(10);
        $clientOrderMap = $this->clientOrderMap($client);
        return view('client.bookings.index', compact('bookings', 'clientOrderMap'));
    }

    public function bookingDetail(Booking $booking)
    {
        $client = $this->client();
        if ($booking->client_id !== $client->id) abort(404);

        $booking->load(['photos', 'payments', 'visibleFiles']);
        $meta = app(\App\Services\BookingService::class)->getBookingMeta($booking);
        // رقم الطلب للعميل (1، 2، 3...) وليس الـ ID الداخلي
        $idx = $client->bookings()->orderBy('created_at')->orderBy('id')->pluck('id')->search($booking->id);
        $clientOrderNumber = $idx !== false ? $idx + 1 : 1;

        return view('client.bookings.detail', compact('booking', 'meta', 'clientOrderNumber'));
    }

    // ─── Payments (صفحة مدفوعاتي) ─────────────────────────────────

    public function payments()
    {
        $client         = $this->client();
        $bookings       = $client->bookings()->with(['payments', 'photos'])->latest()->get();
        $clientOrderMap = $this->clientOrderMap($client);
        return view('client.payments', compact('bookings', 'clientOrderMap'));
    }

    // ─── Media (الميديا: صور + فيديوهات + فلتر) ─────────────────────

    public function media(Request $request)
    {
        $client = $this->client();
        $filter = $request->get('filter', 'all'); // all | images | videos

        $bookingsWithPhotos = $client->bookings()
            ->whereHas('photos')
            ->with(['photos' => fn ($q) => $q->orderBy('sort_order')])
            ->latest()
            ->get();

        $videoFiles = BookingFile::whereHas('booking', fn ($q) => $q->where('client_id', $client->id))
            ->where('is_visible', true)
            ->where('type', 'video')
            ->with('booking:id,service_type,project_type,event_date')
            ->orderByDesc('created_at')
            ->get();

        $otherFiles = BookingFile::whereHas('booking', fn ($q) => $q->where('client_id', $client->id))
            ->where('is_visible', true)
            ->whereIn('type', ['pdf', 'zip', 'other'])
            ->with('booking:id,service_type,project_type')
            ->orderByDesc('created_at')
            ->get();

        // مصفوفة مسطحة لمعرض الصور (للاستخدام في Lightbox: الضغط يكبر الصورة + إعجاب)
        $galleryItems = [];
        foreach ($bookingsWithPhotos as $booking) {
            foreach ($booking->photos as $photo) {
                $galleryItems[] = [
                    'url'        => asset($photo->path),
                    'download'   => asset($photo->path),
                    'booking_id' => $booking->id,
                    'photo_id'   => $photo->id,
                ];
            }
        }
        $selectedPhotoIds = $client->selectedPhotos()->pluck('booking_photo_id')->toArray();

        // حجوزات تحتوي على ملفات ظاهرة — للتقسيم حسب الطلب في قسم "الملفات"
        $bookingsWithFiles = $client->bookings()
            ->whereHas('visibleFiles')
            ->with(['visibleFiles' => fn ($q) => $q->orderByDesc('created_at')])
            ->latest()
            ->get();

        // تسجيل أن العميل شاهد صفحة الميديا — لإخفاء تنبيه "ملفات جديدة" في لوحة التحكم
        $bookingIdsWithMedia = $client->bookings()
            ->where(function ($q) {
                $q->whereNotNull('final_video_path')->where('final_video_path', '!=', '')
                    ->orWhereHas('visibleFiles');
            })
            ->pluck('id');
        foreach ($bookingIdsWithMedia as $bookingId) {
            ClientMediaSeen::updateOrCreate(
                ['client_id' => $client->id, 'booking_id' => $bookingId],
                ['seen_at' => now()]
            );
        }

        $clientOrderMap = $this->clientOrderMap($client);

        return view('client.media.index', compact(
            'bookingsWithPhotos',
            'videoFiles',
            'otherFiles',
            'bookingsWithFiles',
            'clientOrderMap',
            'filter',
            'galleryItems',
            'selectedPhotoIds'
        ));
    }

    // ─── Files (ملفاتي — تحميلات PDF/ZIP، يُعاد توجيهها للميديا أو تبقى للتوافق)
    public function files()
    {
        return redirect()->route('client.media', ['filter' => 'videos']);
    }

    // ─── Invoice PDF ─────────────────────────────────────────────

    public function invoicePdf(Booking $booking)
    {
        $client = $this->client();
        if ($booking->client_id !== $client->id) abort(404);

        $booking->load(['payments', 'eventPackage', 'adPackage', 'eventLocation']);
        $meta = app(\App\Services\BookingService::class)->getBookingMeta($booking);

        $pdf = Pdf::loadView('client.bookings.invoice-pdf', compact('booking', 'meta', 'client'));
        return $pdf->download('invoice-' . $booking->id . '.pdf');
    }

    /**
     * ملخص الحجز للطباعة / التصدير (صفحة طباعة)
     */
    public function bookingSummary(Booking $booking)
    {
        $client = $this->client();
        if ($booking->client_id !== $client->id) abort(404);

        $booking->load(['photos', 'payments', 'visibleFiles']);
        $meta = app(\App\Services\BookingService::class)->getBookingMeta($booking);

        return view('client.bookings.summary', compact('booking', 'meta', 'client'));
    }

    // ─── File Download ───────────────────────────────────────────

    public function downloadFile(BookingFile $file)
    {
        $client  = $this->client();
        $booking = $file->booking;

        if ($booking->client_id !== $client->id) abort(403);
        if (!$file->is_visible) abort(403);

        // التحقق من الملف
        if (str_starts_with($file->path, 'storage/')) {
            $rel = str_replace('storage/', '', $file->path);
            if (!Storage::disk('public')->exists($rel)) {
                return back()->withErrors(['file' => 'الملف غير موجود.']);
            }
            return Storage::disk('public')->download($rel, $file->label);
        }

        // مسار مباشر
        $fullPath = public_path($file->path);
        if (!file_exists($fullPath)) {
            return back()->withErrors(['file' => 'الملف غير موجود.']);
        }

        return response()->download($fullPath, $file->label);
    }

    // ─── ZIP Download (selected photos) ──────────────────────────

    public function downloadSelectedPhotosZip(Booking $booking)
    {
        $client = $this->client();
        if ($booking->client_id !== $client->id) abort(403);

        $selectedIds = $client->selectedPhotos()
            ->whereIn('booking_photo_id', $booking->photos->pluck('id'))
            ->pluck('booking_photo_id');

        $photos = $booking->photos->whereIn('id', $selectedIds);

        if ($photos->isEmpty()) {
            return back()->withErrors(['zip' => 'لم تختر أي صور بعد.']);
        }

        // بناء ZIP في storage/temp
        $zipName = 'photos-booking-' . $booking->id . '-' . time() . '.zip';
        $zipPath = storage_path('app/tmp/' . $zipName);

        if (!is_dir(storage_path('app/tmp'))) {
            mkdir(storage_path('app/tmp'), 0755, true);
        }

        $zip = new ZipArchive();
        if ($zip->open($zipPath, ZipArchive::CREATE | ZipArchive::OVERWRITE) !== true) {
            return back()->withErrors(['zip' => 'فشل إنشاء ملف ZIP.']);
        }

        foreach ($photos as $photo) {
            $filePath = str_starts_with($photo->path, 'storage/')
                ? public_path($photo->path)
                : $photo->path;

            if (file_exists($filePath)) {
                $zip->addFile($filePath, basename($filePath));
            }
        }

        $zip->close();

        return response()->download($zipPath, 'صوري-المميزة.zip')->deleteFileAfterSend(true);
    }

    // ─── Messages ─────────────────────────────────────────────────

    public function messages()
    {
        $client   = $this->client();
        $messages = $client->messages()->latest()->paginate(15);

        // تسجيل أن العميل شاهد صفحة الرسائل — لإخفاء تنبيه الرسائل في الشريط الجانبي
        ClientMessagesSeen::updateOrCreate(
            ['client_id' => $client->id],
            ['last_seen_at' => now()]
        );

        return view('client.messages', compact('messages'));
    }

    public function storeMessage(Request $request)
    {
        $request->validate([
            'subject' => 'nullable|string|max:255',
            'message' => 'required|string|max:2000',
        ]);
        $client = $this->client();
        $client->messages()->create([
            'subject' => $request->subject,
            'message' => $request->message,
        ]);
        return back()->with('success', 'تم إرسال رسالتك.');
    }

    // ─── Reviews ──────────────────────────────────────────────────

    public function createReview()
    {
        $client = $this->client();
        $canReview = $client->bookings()->where('status', 'completed')->exists();
        if (!$canReview) {
            return redirect()->route('client.dashboard')
                ->with('info', 'يمكنك إضافة رأيك بعد اكتمال حجز واحد على الأقل.');
        }
        return view('client.review-create');
    }

    public function storeReview(Request $request)
    {
        $request->validate([
            'content' => 'required|string|max:2000',
            'rating'  => 'required|integer|min:1|max:5',
        ]);
        $client = $this->client();
        Testimonial::create([
            'client_id'   => $client->id,
            'client_name' => $client->name,
            'content'     => $request->content,
            'rating'      => $request->rating,
            'initial'     => mb_substr($client->name, 0, 1),
            'status'      => Testimonial::STATUS_PENDING,
            'is_active'   => false,
        ]);
        return redirect()->route('client.dashboard')
            ->with('success', 'تم إرسال رأيك. سيظهر في الموقع بعد المصادقة.');
    }

    // ─── Project Photos ───────────────────────────────────────────

    public function projectPhotos()
    {
        $client        = $this->client();
        $bookings      = $client->bookings()->whereHas('photos')->latest()->get();
        $selectedCount = $client->selectedPhotos()->count();
        return view('client.media.project-photos', compact('bookings', 'selectedCount'));
    }

    public function projectPhotosBooking(Booking $booking)
    {
        $client = $this->client();
        if ($booking->client_id !== $client->id) abort(404);

        $photos        = $booking->photos()->orderBy('sort_order')->get();
        $selectedIds   = $client->selectedPhotos()->pluck('booking_photo_id')->toArray();
        $selectedCount = $client->selectedPhotos()->count();

        return view('client.media.project-photos-booking',
            compact('booking', 'photos', 'selectedIds', 'selectedCount'));
    }

    public function toggleSelectedPhoto(Request $request)
    {
        $request->validate(['booking_photo_id' => 'required|exists:booking_photos,id']);
        $client = $this->client();
        $photo  = BookingPhoto::findOrFail($request->booking_photo_id);

        if ($photo->booking->client_id !== $client->id) {
            return response()->json(['ok' => false], 403);
        }

        $existing = ClientSelectedPhoto::where('client_id', $client->id)
            ->where('booking_photo_id', $photo->id)->first();

        if ($existing) {
            $existing->delete();
            return response()->json([
                'ok' => true, 'selected' => false,
                'count' => $client->selectedPhotos()->count(),
            ]);
        }

        if ($client->selectedPhotos()->count() >= 200) {
            return response()->json([
                'ok'      => false,
                'message' => 'الحد الأقصى 200 صورة مميزة.',
            ], 422);
        }

        ClientSelectedPhoto::create(['client_id' => $client->id, 'booking_photo_id' => $photo->id]);

        return response()->json([
            'ok' => true, 'selected' => true,
            'count' => $client->selectedPhotos()->count(),
        ]);
    }
}