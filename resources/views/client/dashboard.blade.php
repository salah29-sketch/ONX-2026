@extends('client.layout')

@section('title', 'مساحتك الخاصة - ONX')

@push('styles')
<style>
.hero-card { background: #fff; border: 1px solid #e5e7eb; border-radius: 24px; padding: 28px; margin-bottom: 24px; position: relative; overflow: hidden; box-shadow: 0 1px 3px rgba(0,0,0,.04); }
.hero-card::before { content: ''; position: absolute; top: -50%; right: -30%; width: 80%; height: 80%; background: radial-gradient(circle, rgba(245,158,11,.06) 0%, transparent 70%); pointer-events: none; }
.hero-greeting { font-size: 1.1rem; color: #6b7280; margin-bottom: 4px; }
.hero-title { font-size: 1.75rem; font-weight: 900; color: #1f2937; margin: 0 0 8px; }
.hero-countdown { display: inline-flex; align-items: center; gap: 8px; padding: 10px 18px; border-radius: 999px; background: #fef3c7; color: #b45309; font-size: 1rem; font-weight: 800; margin-top: 12px; border: 1px solid #fde68a; }
.hero-countdown-muted { background: #f3f4f6; color: #4b5563; border-color: #e5e7eb; }
.dash-steps { display: flex; align-items: flex-start; gap: 0; margin-top: 20px; position: relative; }
.dash-step { flex: 1; display: flex; flex-direction: column; align-items: center; gap: 8px; position: relative; z-index: 2; min-width: 0; }
.dash-step-line { flex: 1; height: 2px; min-width: 8px; background: #e5e7eb; position: relative; top: -18px; z-index: 1; align-self: flex-start; margin-top: 18px; }
.dash-step-line.done { background: #f59e0b !important; background-color: #f59e0b; }
.dash-step-line.active { background: #f59e0b !important; background-color: #f59e0b; }
.dash-step-circle { width: 36px; height: 36px; border-radius: 50%; border: 2px solid #e5e7eb; background: #f3f4f6; color: #9ca3af; font-size: 12px; font-weight: 900; display: flex; align-items: center; justify-content: center; transition: all .3s; }
.dash-step.done .dash-step-circle { background: #f59e0b; border-color: #f59e0b; color: #fff; }
.dash-step.active .dash-step-circle { border-color: #f59e0b; color: #fff; background: #f59e0b; }
.dash-step-label { font-size: 10px; font-weight: 700; color: #6b7280; text-align: center; }
.dash-step.done .dash-step-label, .dash-step.active .dash-step-label { color: #1f2937; }
.stat-card { background: #fff; border: 1px solid #e5e7eb; border-radius: 18px; padding: 20px; box-shadow: 0 1px 3px rgba(0,0,0,.04); }
.stat-value { font-size: 1.5rem; font-weight: 900; }
.stat-label { font-size: 12px; color: #6b7280; margin-top: 4px; }
.alert-new { border-radius: 16px; padding: 16px 20px; margin-bottom: 20px; font-size: 14px; font-weight: 700; display: flex; align-items: center; gap: 12px; background: #dcfce7; border: 1px solid #bbf7d0; color: #166534; }
.msg-preview { background: #fff; border: 1px solid #e5e7eb; border-radius: 16px; padding: 16px; box-shadow: 0 1px 3px rgba(0,0,0,.04); }
.msg-preview .text-\[var\(--gold\)\] { color: #b45309; }
.empty-state { text-align: center; padding: 32px 20px; color: #6b7280; border-radius: 20px; border: 1px solid #e5e7eb; background: #fff; box-shadow: 0 1px 3px rgba(0,0,0,.04); }
.empty-state .icon { font-size: 40px; margin-bottom: 12px; opacity: .6; }
</style>
@endpush

@section('client_content')
{{-- إشعار: فيديو أو ملفات جاهزة --}}
@if(!empty($hasNewFilesOrVideo))
    <a href="{{ route('client.media', ['filter' => 'videos']) }}" class="block alert-new">
        <span>🎬</span>
        <span>لديك فيديو أو ملفات جاهزة للتحميل — اضغط هنا</span>
    </a>
@endif

{{-- Hero Card: ترحيب + الحجز النشط + Countdown + Timeline --}}
<div class="hero-card">
    <p class="hero-greeting">مرحباً،</p>
    <h1 class="hero-title">{{ $client->name }}</h1>

    @if($activeBooking)
        <p class="text-gray-600 text-sm">
            {{ $activeBooking->service_type === 'event' ? '🎬 تصوير فعاليات' : '📢 إعلانات' }}
            @if($activeBooking->event_date)
                · {{ ar_date($activeBooking->event_date, 'l d F') }}
            @endif
        </p>
        @if($activeBooking->event_date && $activeBooking->event_date->isFuture())
            <div class="hero-countdown">باقي {{ $activeBooking->event_date->diffInDays(now()) }} يوم 🎉</div>
        @elseif(in_array($activeBooking->status, ['confirmed', 'in_progress']))
            <div class="hero-countdown">✅ {{ $activeBooking->statusLabel() }}</div>
        @else
            <div class="hero-countdown hero-countdown-muted">{{ $activeBooking->statusLabel() }}</div>
        @endif

        @php $step = $activeBooking->statusStep(); @endphp
        <div class="dash-steps">
            @foreach([1 => 'استلام الطلب', 2 => 'تأكيد الحجز', 3 => 'قيد التنفيذ', 4 => 'مكتمل'] as $s => $label)
                <div class="dash-step {{ $step >= $s ? ($step > $s ? 'done' : 'active') : '' }}">
                    <div class="dash-step-circle">
                        @if($step > $s)<i class="bi bi-check-lg"></i>@else{{ $s }}@endif
                    </div>
                    <div class="dash-step-label">{{ $label }}</div>
                </div>
                @if($s < 4)<div class="dash-step-line {{ $step > $s ? 'done' : ($step === $s ? 'active' : '') }}"></div>@endif
            @endforeach
        </div>
        <p class="mt-4 rounded-xl border border-amber-200 bg-amber-50/50 px-4 py-2.5 text-sm text-amber-800">
            <span class="font-bold">معلومة التسليم:</span> {{ $activeBooking->deliveryInfoText() }}
        </p>
        @if($activeBooking->service_type === 'event' && $activeBooking->event_date && $activeBooking->event_date->isFuture())
            <p class="mt-2 text-xs text-gray-500">تذكير: نسلّم المنتج خلال شهر كحد أقصى من يوم الحفل.</p>
        @endif
    @else
        <p class="text-gray-500 text-sm mt-2">مساحتك الخاصة لمتابعة حجوزاتك وملفاتك.</p>
    @endif
</div>

{{-- 3 بطاقات: مدفوع / متبقي / صور --}}
@if($activeBooking)
<div class="grid grid-cols-1 gap-4 sm:grid-cols-3 mb-6">
    <div class="stat-card">
        <div class="stat-value text-green-600">{{ number_format($activeBooking->paidAmount(), 0) }} <span class="text-xs font-bold text-gray-500">DA</span></div>
        <div class="stat-label">المبلغ المدفوع</div>
    </div>
    <div class="stat-card">
        <div class="stat-value {{ $activeBooking->remainingAmount() > 0 ? 'text-red-600' : 'text-green-600' }}">
            {{ number_format($activeBooking->remainingAmount(), 0) }} <span class="text-xs font-bold text-gray-500">DA</span>
        </div>
        <div class="stat-label">المتبقي</div>
    </div>
    <div class="stat-card">
        <div class="stat-value text-gray-800">{{ $activeBooking->photos->count() }}</div>
        <div class="stat-label">صور مرفوعة</div>
    </div>
</div>
@endif

{{-- آخر رسالة + زر رد --}}
@if(isset($lastMessage))
<div class="msg-preview mb-6">
    <p class="text-xs font-bold text-gray-500 mb-2">آخر رسالة</p>
    <p class="text-gray-700 text-sm line-clamp-2">{{ Str::limit($lastMessage->message, 120) }}</p>
    <a href="{{ route('client.messages') }}" class="mt-3 inline-flex items-center gap-2 text-sm font-bold text-amber-600 hover:underline">
        اذهب للرسائل <i class="bi bi-arrow-left"></i>
    </a>
</div>
@endif

{{-- آخر حجوزاتك --}}
<div class="mb-4 flex items-center justify-between">
    <h2 class="text-lg font-black text-white">آخر حجوزاتك</h2>
    @if($bookings->isNotEmpty())
        <a href="{{ route('client.bookings') }}" class="text-sm font-bold text-amber-600 hover:underline">عرض الكل</a>
    @endif
</div>

@if($bookings->isNotEmpty())
    @php $clientOrderMap = $clientOrderMap ?? []; @endphp
    <div class="space-y-3">
        @foreach($bookings as $b)
            @php
                $bStep = $b->statusStep();
                $serviceLabel = $b->service_type === 'event' ? 'تصوير فعاليات' : 'إعلانات';
                $serviceDate = $b->event_date ?? $b->deadline ?? $b->created_at;
            @endphp
            <a href="{{ route('client.bookings.show', $b) }}" class="block rounded-2xl border border-gray-200 bg-white p-4 transition hover:border-amber-300 hover:shadow-sm">
                <div class="flex justify-between items-start gap-2">
                    <div>
                        <span class="font-bold text-gray-800">الطلب {{ $clientOrderMap[$b->id] ?? $b->id }}</span>
                        <span class="text-sm text-gray-500 mr-2">· {{ $serviceLabel }}</span>
                        <span class="text-sm text-gray-500 mr-2">· {{ $serviceDate->format('d/m/Y') }}</span>
                        <span class="text-xs px-2 py-0.5 rounded-full {{ $b->status === 'completed' ? 'bg-green-100 text-green-700' : ($b->status === 'confirmed' || $b->status === 'in_progress' ? 'bg-amber-100 text-amber-800' : 'bg-gray-100 text-gray-600') }}">{{ $b->statusLabel() }}</span>
                    </div>
                    <span class="text-gray-400 text-xs">التفاصيل ←</span>
                </div>
                <div class="flex gap-1 mt-2" title="مراحل الطلب">
                    @foreach([1,2,3,4] as $s)
                        <span class="w-2 h-2 rounded-full {{ $bStep >= $s ? 'bg-amber-500' : 'bg-gray-200' }}"></span>
                    @endforeach
                </div>
            </a>
        @endforeach
    </div>
@else
    <div class="empty-state">
        <div class="icon">📋</div>
        <p class="font-bold text-gray-700">لا توجد حجوزات بعد</p>
        <p class="mt-2 text-sm text-gray-500">عند إتمام حجز من الموقع، ستظهر هنا وتستطيع متابعتها من مساحتك.</p>
    </div>
@endif
@endsection
