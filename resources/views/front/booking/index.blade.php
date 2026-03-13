@extends('layouts.front_tailwind')
@section('title', 'الحجز - ONX')
@section('meta_description', 'احجز خدمة التصوير أو الإعلانات مع ONX. اختر باقة الحفلات أو الإعلانات، حدد التاريخ، واتصل بنا. تصوير سينمائي واحترافي.')
@push('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

<style>
    :root {
        --onx-accent: 249 115 22;
        --onx-danger: 239 68 68;
        --onx-warning: 245 158 11;
    }

    .booking-calendar { direction: ltr; }

    .booking-calendar .flatpickr-calendar,
    .booking-calendar .flatpickr-calendar.inline {
        background: transparent;
        box-shadow: none !important;
        border: 0 !important;
        width: 100% !important;
    }

    .booking-calendar .flatpickr-months { display: none !important; }

    .booking-calendar .flatpickr-weekdays {
        width: 100% !important;
        display: block !important;
        margin-bottom: 8px;
    }

    .booking-calendar .flatpickr-weekdaycontainer {
        display: grid !important;
        grid-template-columns: repeat(7, minmax(0, 1fr)) !important;
        width: 100% !important;
    }

    .booking-calendar .flatpickr-weekday {
        display: flex !important;
        align-items: center;
        justify-content: center;
        width: 100% !important;
        max-width: 100% !important;
        color: rgba(255,255,255,.72) !important;
        font-size: 12px !important;
        font-weight: 800 !important;
        text-align: center !important;
        direction: ltr !important;
    }

    .booking-calendar .flatpickr-rContainer,
    .booking-calendar .flatpickr-days,
    .booking-calendar .dayContainer {
        width: 100% !important;
        min-width: 100% !important;
        max-width: 100% !important;
    }

    .booking-calendar .dayContainer {
        display: grid !important;
        grid-template-columns: repeat(7, minmax(0,1fr));
        gap: 4px;
    }

    .booking-calendar .flatpickr-day {
        width: 100% !important;
        max-width: none !important;
        min-width: 0 !important;
        margin: 0 !important;
        height: 38px !important;
        line-height: 38px !important;
        border-radius: 12px !important;
        color: rgba(255,255,255,.88);
        font-size: 13px !important;
        font-weight: 700 !important;
        border: 1px solid transparent;
        transition: .18s ease;
        background: transparent;
    }

    /* اليوم الحالي: بدون إطار */
    .booking-calendar .flatpickr-day.today {
        border-color: transparent !important;
        box-shadow: none !important;
    }

    /* اليوم المختار: برتقالي */
    .booking-calendar .flatpickr-day.selected,
    .booking-calendar .flatpickr-day.selected:hover {
        background: rgb(249,115,22) !important;
        border-color: rgb(249,115,22) !important;
        color: #111 !important;
        box-shadow: 0 4px 14px rgba(249,115,22,.35) !important;
    }

    /* hover للأيام العادية */
    .booking-calendar .flatpickr-day:not(.selected):not(.prevMonthDay):not(.nextMonthDay):not(.flatpickr-disabled):hover {
        background: rgba(249,115,22,.12) !important;
        border-color: rgba(249,115,22,.35) !important;
        color: rgba(249,115,22,.95) !important;
    }

    .booking-calendar .flatpickr-day.prevMonthDay,
    .booking-calendar .flatpickr-day.nextMonthDay {
        color: rgba(255,255,255,.22) !important;
        opacity: .45 !important;
    }

    .booking-calendar .flatpickr-day.flatpickr-disabled {
        opacity: .25 !important;
        color: rgba(255,255,255,.30) !important;
    }

    .service-card,
    .package-box,
    .onx-select-trigger,
    .onx-select-option,
    .onx-input,
    .onx-textarea {
        transition: .2s ease;
    }

    .service-card {
        position: relative;
        overflow: hidden;
        cursor: pointer;
    }
    .service-card::before {
        content: '';
        position: absolute;
        inset: 0;
        opacity: 0;
        transition: opacity .25s ease;
        border-radius: inherit;
    }
    .service-card[data-type="event"]::before {
        background: linear-gradient(135deg, rgba(249,115,22,.18) 0%, rgba(234,88,12,.06) 100%);
    }
    .service-card[data-type="ads"]::before {
        background: linear-gradient(135deg, rgba(139,92,246,.18) 0%, rgba(109,40,217,.06) 100%);
    }
    .service-card:hover::before,
    .service-card.active::before {
        opacity: 1;
    }
    .service-card[data-type="event"].active {
        border-color: rgba(249,115,22,.75);
        box-shadow: 0 0 0 1px rgba(249,115,22,.22) inset, 0 8px 32px rgba(249,115,22,.15);
    }
    .service-card[data-type="event"]:hover {
        border-color: rgba(249,115,22,.40);
    }
    .service-card[data-type="ads"].active {
        border-color: rgba(139,92,246,.75);
        box-shadow: 0 0 0 1px rgba(139,92,246,.22) inset, 0 8px 32px rgba(139,92,246,.15);
    }
    .service-card[data-type="ads"]:hover {
        border-color: rgba(139,92,246,.40);
    }
    .service-card .svc-icon {
        font-size: 22px;
        line-height: 1;
        margin-bottom: 6px;
        display: block;
    }

    .package-option {
        position: relative;
        display: block;
        cursor: pointer;
    }

    .package-option input {
        position: absolute;
        opacity: 0;
        pointer-events: none;
    }

    .package-option input:checked + .package-box {
        border-color: rgba(var(--onx-accent), .78);
        background: rgba(var(--onx-accent), .10);
        box-shadow: 0 0 0 1px rgba(var(--onx-accent), .22) inset;
    }

    .package-option input:checked + .package-box .package-check {
        opacity: 1;
        transform: scale(1);
    }

    .package-check {
        opacity: 0;
        transform: scale(.88);
        transition: .2s ease;
    }

    .onx-hidden-select { display: none !important; }

    .onx-select { position: relative; width: 100%; }

    .onx-select-trigger {
        width: 100%;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        border-radius: 12px;
        border: 1px solid rgba(255,255,255,.10);
        background: #111111;
        color: #ffffff;
        padding: 10px 14px;
        cursor: pointer;
        min-height: 44px;
    }

    .onx-select.open .onx-select-trigger,
    .onx-select-trigger:focus-visible,
    .onx-input:focus,
    .onx-textarea:focus {
        border-color: rgba(var(--onx-accent), .68);
        box-shadow: 0 0 0 3px rgba(var(--onx-accent), .16);
        outline: none;
    }

    .onx-select-label { color: #fff; font-size: 13px; font-weight: 700; }

    .onx-select-arrow {
        color: #fff;
        font-size: 11px;
        transition: transform .2s ease;
    }

    .onx-select.open .onx-select-arrow { transform: rotate(180deg); }

    .onx-select-dropdown {
        position: absolute;
        top: calc(100% + 6px);
        left: 0; right: 0;
        background: #111111;
        border: 1px solid rgba(255,255,255,.10);
        border-radius: 12px;
        max-height: 220px;
        overflow-y: auto;
        display: none;
        z-index: 60;
        box-shadow: 0 16px 40px rgba(0,0,0,.35);
    }

    .onx-select.open .onx-select-dropdown { display: block; }

    .onx-select-option {
        padding: 10px 14px;
        cursor: pointer;
        color: #fff;
        font-size: 13px;
        font-weight: 600;
    }

    .onx-select-option:hover { background: rgba(var(--onx-accent), .20); }

    .onx-select-option.selected {
        background: rgb(var(--onx-accent));
        color: #000;
        font-weight: 800;
    }

    .onx-input,
    .onx-textarea {
        width: 100%;
        border-radius: 14px;
        border: 1px solid rgba(255,255,255,.10);
        background: rgba(255,255,255,.05);
        padding: 7px 11px;
        font-size: 12px;
        color: white;
        outline: none;
    }

    .onx-input::placeholder,
    .onx-textarea::placeholder { color: rgba(255,255,255,.30); }

    .onx-field-error {
        border-color: rgba(var(--onx-danger), .65) !important;
        box-shadow: 0 0 0 3px rgba(var(--onx-danger), .12) !important;
    }

    .onx-sticky { position: sticky; top: 110px; }

    .onx-status-success {
        background: rgba(34,197,94,.10);
        border-color: rgba(34,197,94,.24);
        color: rgba(255,255,255,.92);
    }

    .onx-status-warning {
        background: rgba(var(--onx-warning), .10);
        border-color: rgba(var(--onx-warning), .24);
        color: rgba(255,255,255,.92);
    }

    .onx-status-danger {
        background: rgba(var(--onx-danger), .10);
        border-color: rgba(var(--onx-danger), .24);
        color: rgba(255,255,255,.92);
    }

    @media (max-width: 1023px) {
        .onx-sticky { position: static; top: auto; }
    }

    /* ── تأثير لوني حسب نوع الخدمة ── */
    #bookingCard {
        --svc-color: 249, 115, 22;
    }
    #bookingCard.mode-ads {
        --svc-color: 139, 92, 246;
    }
    #bookingCard {
        border-color: rgba(var(--svc-color), .28);
        background: rgba(var(--svc-color), .03);
        box-shadow: 0 0 0 1px rgba(var(--svc-color), .08) inset,
                    0 20px 60px rgba(0,0,0,.25),
                    0 0 80px rgba(var(--svc-color), .08);
    }
    .onx-input:focus,
    .onx-textarea:focus {
        border-color: rgba(var(--svc-color), .55) !important;
        box-shadow: 0 0 0 3px rgba(var(--svc-color), .12) !important;
    }
    .onx-select-trigger:focus-visible,
    .onx-select.open .onx-select-trigger {
        border-color: rgba(var(--svc-color), .55) !important;
        box-shadow: 0 0 0 3px rgba(var(--svc-color), .12) !important;
    }
    .onx-select-option.selected {
        background: rgb(var(--svc-color)) !important;
    }
    #bookingCard .booking-calendar .flatpickr-day.selected,
    #bookingCard .booking-calendar .flatpickr-day.selected:hover {
        background: rgb(var(--svc-color)) !important;
        border-color: rgb(var(--svc-color)) !important;
        box-shadow: 0 4px 14px rgba(var(--svc-color), .35) !important;
    }
    #bookingCard .booking-calendar .flatpickr-day:not(.selected):not(.prevMonthDay):not(.nextMonthDay):not(.flatpickr-disabled):hover {
        background: rgba(var(--svc-color), .12) !important;
        border-color: rgba(var(--svc-color), .35) !important;
        color: rgba(var(--svc-color), .95) !important;
    }


    /* ── تأثير لوني على الأزرار ── */
    #submitBtn {
        background: rgb(var(--svc-color));
        box-shadow: 0 4px 24px rgba(var(--svc-color), .35);
        transition: background .3s ease, box-shadow .3s ease, opacity .2s;
    }
    #submitBtn:not(:disabled):hover {
        background: rgba(var(--svc-color), .82);
        box-shadow: 0 6px 32px rgba(var(--svc-color), .50);
    }
    .hero-btn-primary {
        background: rgb(var(--svc-color)) !important;
        box-shadow: 0 4px 20px rgba(var(--svc-color), .30);
        transition: background .3s ease, box-shadow .3s ease;
    }
    .hero-btn-primary:hover {
        background: rgba(var(--svc-color), .82) !important;
        box-shadow: 0 6px 28px rgba(var(--svc-color), .45) !important;
    }
    .hero-btn-secondary {
        border-color: rgba(var(--svc-color), .30) !important;
        transition: border-color .3s ease, background .3s ease, color .3s ease;
    }
    .hero-btn-secondary:hover {
        border-color: rgba(var(--svc-color), .60) !important;
        background: rgba(var(--svc-color), .10) !important;
        color: white !important;
    }
    .hero-badge {
        border-color: rgba(var(--svc-color), .25) !important;
        background: rgba(var(--svc-color), .10) !important;
        color: rgb(var(--svc-color)) !important;
        transition: all .3s ease;
    }

</style>
@endpush

@section('content')
@php
    $monthNames = ['يناير','فبراير','مارس','أبريل','ماي','يونيو','يوليو','أغسطس','سبتمبر','أكتوبر','نوفمبر','ديسمبر'];
    $currentMonth = now()->month - 1;
    $currentYear = now()->year;
@endphp

{{-- Hero --}}
<section class="relative overflow-hidden border-b border-white/10">
    <div class="absolute inset-0">
        <img src="{{ asset('img/front/booking/booking-hero.png') }}" alt="الحجز" class="h-full w-full object-cover opacity-15">
        <div class="absolute inset-0 bg-gradient-to-b from-black/40 via-black/70 to-[#050505]"></div>
    </div>

    <div class="relative mx-auto max-w-7xl px-6 py-10 lg:px-8 lg:py-12">
        <div class="max-w-3xl">
            <span class="hero-badge inline-flex rounded-full border border-orange-500/25 bg-orange-500/10 px-4 py-1 text-[11px] font-extrabold tracking-wide text-orange-300">
                ONX BOOKING
            </span>

            <h1 class="mt-3 text-3xl font-black leading-tight text-white sm:text-4xl">
                احجز خدمتك بخطوات واضحة وسريعة
            </h1>

            <p class="mt-2 max-w-2xl text-sm leading-7 text-white/65">
                اختر نوع الخدمة، حدّد الباقة المناسبة، ثم أكمل تفاصيل الحجز. للحفلات يمكنك التحقق من التوفر مباشرة من التقويم.
            </p>

            <div class="mt-5 flex flex-wrap gap-3">
                <a href="#bookingForm" class="inline-flex rounded-full bg-orange-500 px-5 py-2 text-sm font-extrabold text-black transition hover:bg-orange-400" style="box-shadow:0 4px 20px rgba(249,115,22,.35)">
                    احجز الآن
                </a>
                <a href="{{ route('services.events') }}" class="inline-flex rounded-full border px-5 py-2 text-sm font-bold transition"
                   style="border-color:rgba(249,115,22,.40);background:rgba(249,115,22,.08);color:rgba(255,255,255,.85)"
                   onmouseover="this.style.borderColor='rgba(249,115,22,.70)';this.style.background='rgba(249,115,22,.18)';this.style.color='#fff'"
                   onmouseout="this.style.borderColor='rgba(249,115,22,.40)';this.style.background='rgba(249,115,22,.08)';this.style.color='rgba(255,255,255,.85)'">
                    باقات الحفلات
                </a>
                <a href="{{ route('services.marketing') }}" class="inline-flex rounded-full border px-5 py-2 text-sm font-bold transition"
                   style="border-color:rgba(139,92,246,.40);background:rgba(139,92,246,.08);color:rgba(255,255,255,.85)"
                   onmouseover="this.style.borderColor='rgba(139,92,246,.70)';this.style.background='rgba(139,92,246,.18)';this.style.color='#fff'"
                   onmouseout="this.style.borderColor='rgba(139,92,246,.40)';this.style.background='rgba(139,92,246,.08)';this.style.color='rgba(255,255,255,.85)'">
                    باقات الإعلانات
                </a>
            </div>
        </div>
    </div>
</section>

{{-- Booking Form --}}
<section id="bookingForm" class="mx-auto max-w-7xl px-6 py-7 lg:px-8">
    <div class="mb-6 text-center">
        <h2 class="text-xl font-black text-white">نظام الحجز</h2>
        <p class="mt-1.5 text-sm text-white/60">
            للحفلات والإعلانات: اختر يومًا من التقويم، ثم الباقة والتفاصيل.
        </p>

        <div class="mt-4 flex flex-wrap items-center justify-center gap-2 text-xs font-bold">
            <span class="rounded-full border border-white/10 bg-white/5 px-3 py-1 text-xs font-bold text-white/75">1. نوع الخدمة</span>
            <span class="rounded-full border border-white/10 bg-white/5 px-3 py-1 text-xs font-bold text-white/75">2. الباقة</span>
            <span class="rounded-full border border-white/10 bg-white/5 px-3 py-1 text-xs font-bold text-white/75">3. التفاصيل</span>
            <span class="rounded-full border border-white/10 bg-white/5 px-3 py-1 text-xs font-bold text-white/75">4. الإرسال</span>
        </div>
    </div>

    <div class="grid gap-6 lg:grid-cols-[minmax(0,1fr)_320px]">

        {{-- Main Form --}}
        <div id="bookingCard" class="rounded-[24px] border border-white/10 bg-white/[0.04] p-3 shadow-[0_20px_60px_rgba(0,0,0,0.25)] backdrop-blur-xl sm:p-4 transition-all duration-500">
            <form
                method="POST"
                action="{{ route('booking.store') }}"
                id="bookingFormEl"
                data-booked-days-url="{{ route('booking.bookedDays') }}"
                data-check-date-url="{{ route('booking.check') }}"
                class="space-y-3.5"
                novalidate
            >
                @csrf
                <input type="hidden" name="service_type" id="service_type" value="{{ old('service_type', 'event') }}">
                <input type="hidden" name="event_date"   id="event_date"   value="{{ old('event_date') }}">
                <input type="hidden" name="package_type" id="package_type" value="{{ old('package_type') }}">
                <input type="hidden" name="package_id"   id="package_id"   value="{{ old('package_id') }}">

                {{-- 1. نوع الخدمة --}}
                <div>
                    <div class="mb-2.5 text-sm font-extrabold text-white">اختر نوع الخدمة</div>
                    <div class="grid gap-3 sm:grid-cols-2">
                        <button type="button"
                            class="service-card onx-service-card {{ old('service_type', 'event') === 'event' ? 'active' : '' }} rounded-2xl border border-white/10 bg-white/[0.03] p-2.5 text-right transition"
                            data-type="event">
                            <span class="svc-icon">🎉</span>
                            <h3 class="text-sm font-black text-white">حفلات</h3>
                            <p class="mt-1 text-xs text-white/55">حجز تصوير الحفلات مع اختيار التاريخ والتحقق من التوفر.</p>
                        </button>

                        <button type="button"
                            class="service-card onx-service-card {{ old('service_type') === 'ads' ? 'active' : '' }} rounded-2xl border border-white/10 bg-white/[0.03] p-2.5 text-right transition"
                            data-type="ads">
                            <span class="svc-icon">📢</span>
                            <h3 class="text-sm font-black text-white">إعلانات</h3>
                            <p class="mt-1 text-xs text-white/55">اشتراك شهري أو إعلان حسب الطلب. يُطلب اختيار يوم من التقويم أيضًا.</p>
                        </button>
                    </div>
                </div>

                {{-- 2. الباقة --}}
                <div>
                    <div class="mb-2.5 flex items-center justify-between gap-3">
                        <div class="text-sm font-extrabold text-white">اختر الباقة</div>
                        <span id="packageContextBadge" class="rounded-full border border-white/10 bg-white/5 px-3 py-1 text-[11px] font-bold text-white/70">
                            {{ old('service_type', 'event') === 'ads' ? 'باقات الإعلانات' : 'باقات الحفلات' }}
                        </span>
                    </div>

                    @error('selected_package')
                        <p class="mb-2 text-xs font-bold text-red-300">{{ $message }}</p>
                    @enderror

                    <div id="eventPackagesSection" class="space-y-2.5" {{ old('service_type', 'event') === 'ads' ? 'style=display:none;' : '' }}>
                        @forelse($eventPackages as $p)
                            <label class="package-option block">
                                <input type="radio" name="selected_package" value="event:{{ $p->id }}"
                                    data-service="event" data-package-type="event"
                                    data-package-id="{{ $p->id }}" data-name="{{ $p->name }}"
                                    {{ old('selected_package') === 'event:'.$p->id ? 'checked' : '' }}>
                                <span class="package-box block rounded-2xl border border-white/10 bg-white/[0.03] p-3.5 hover:border-orange-500/40 hover:bg-orange-500/5">
                                    <span class="flex items-start justify-between gap-4">
                                        <span>
                                            <span class="block text-sm font-black text-white">{{ $p->name }}</span>
                                            <span class="mt-1 inline-flex items-center gap-1.5 text-[11px] font-bold text-white/45">
                                                <span class="package-check inline-flex h-4 w-4 items-center justify-center rounded-full bg-orange-500 text-[9px] text-black">✓</span>
                                                باقة مناسبة للحفلات
                                            </span>
                                        </span>
                                        <span class="shrink-0 text-left">
                                            @if(!empty($p->old_price))
                                                <span class="block text-xs text-white/35 line-through">{{ number_format((float) $p->old_price) }} دج</span>
                                            @endif
                                            <span class="block text-sm font-black" style="color:rgb(var(--svc-color))">{{ number_format((float) $p->price) }} دج</span>
                                        </span>
                                    </span>
                                </span>
                            </label>
                        @empty
                            <div class="rounded-2xl border border-white/10 bg-white/[0.03] p-4 text-center">
                                <p class="text-sm font-bold text-white">لا توجد باقات حفلات حالياً</p>
                                <p class="mt-1 text-xs text-white/50">أضفها من لوحة التحكم.</p>
                            </div>
                        @endforelse
                    </div>

                    <div id="adsPackagesSection" class="space-y-2.5" {{ old('service_type', 'event') === 'ads' ? '' : 'style=display:none;' }}>
                        @forelse($adMonthlyPackages as $p)
                            <label class="package-option block">
                                <input type="radio" name="selected_package" value="ad:{{ $p->id }}"
                                    data-service="ads" data-package-type="ads"
                                    data-package-id="{{ $p->id }}" data-name="{{ $p->name }}"
                                    {{ old('selected_package') === 'ad:'.$p->id ? 'checked' : '' }}>
                                <span class="package-box block rounded-2xl border border-white/10 bg-white/[0.03] p-3.5 hover:border-orange-500/40 hover:bg-orange-500/5">
                                    <span class="flex items-start justify-between gap-4">
                                        <span>
                                            <span class="block text-sm font-black text-white">{{ $p->name }}</span>
                                            <span class="mt-1 inline-flex items-center gap-1.5 text-[11px] font-bold text-white/45">
                                                <span class="package-check inline-flex h-4 w-4 items-center justify-center rounded-full bg-orange-500 text-[9px] text-black">✓</span>
                                                باقة إعلانية شهرية
                                            </span>
                                        </span>
                                        <span class="shrink-0 text-left text-sm font-black" style="color:rgb(var(--svc-color))">
                                            {{ $p->price ? number_format((float) $p->price).' دج' : ($p->price_note ?: '—') }}
                                        </span>
                                    </span>
                                </span>
                            </label>
                        @empty
                        @endforelse

                        @forelse($adCustomPackages as $p)
                            <label class="package-option block">
                                <input type="radio" name="selected_package" value="ad:{{ $p->id }}"
                                    data-service="ads" data-package-type="ads"
                                    data-package-id="{{ $p->id }}" data-name="{{ $p->name }}"
                                    {{ old('selected_package') === 'ad:'.$p->id ? 'checked' : '' }}>
                                <span class="package-box block rounded-2xl border border-white/10 bg-white/[0.03] p-3.5 hover:border-orange-500/40 hover:bg-orange-500/5">
                                    <span class="flex items-start justify-between gap-4">
                                        <span>
                                            <span class="block text-sm font-black text-white">{{ $p->name }}</span>
                                            <span class="mt-1 inline-flex items-center gap-1.5 text-[11px] font-bold text-white/45">
                                                <span class="package-check inline-flex h-4 w-4 items-center justify-center rounded-full bg-orange-500 text-[9px] text-black">✓</span>
                                                باقة حسب الطلب
                                            </span>
                                        </span>
                                        <span class="shrink-0 text-left text-sm font-black" style="color:rgb(var(--svc-color))">
                                            {{ $p->price_note ?: 'حسب الطلب' }}
                                        </span>
                                    </span>
                                </span>
                            </label>
                        @empty
                            @if(($adMonthlyPackages->count() ?? 0) === 0)
                                <div class="rounded-2xl border border-white/10 bg-white/[0.03] p-4 text-center">
                                    <p class="text-sm font-bold text-white">لا توجد باقات إعلانات حالياً</p>
                                    <p class="mt-1 text-xs text-white/50">أضفها من لوحة التحكم.</p>
                                </div>
                            @endif
                        @endforelse
                    </div>
                </div>

                {{-- التاريخ (مطلوب للحفلات والإعلانات) — يظهر التقويم دائماً في الشريط الجانبي --}}
                <div id="dateSection" class="space-y-3">
                    <div class="flex items-center justify-between gap-3">
                        <div class="text-sm font-extrabold text-white">التاريخ المختار</div>
                        <span class="rounded-full border border-white/10 bg-white/5 px-3 py-1 text-[11px] font-bold text-white/70">مطلوب</span>
                    </div>
                    <div>
                        <label class="mb-1.5 block text-xs font-bold text-white/70">اختر يومًا من التقويم</label>
                        <input class="onx-input {{ $errors->has('event_date') ? 'onx-field-error' : '' }}"
                            id="event_date_preview" placeholder="اختر من التقويم"
                            value="{{ old('event_date') }}" readonly>
                        @error('event_date')
                            <p class="mt-1.5 text-xs font-bold text-red-300">{{ $message }}</p>
                        @else
                            <p class="mt-1.5 text-xs text-white/45">الحفلات: تحقق من التوفر. الإعلانات: حدد اليوم المطلوب.</p>
                        @enderror
                    </div>
                </div>

                {{-- 3a. تفاصيل الحفلة (المكان — للحفلات فقط) --}}
                <div id="eventOnlySection" class="space-y-3" {{ old('service_type', 'event') === 'ads' ? 'style=display:none;' : '' }}>
                    <div class="flex items-center justify-between gap-3">
                        <div class="text-sm font-extrabold text-white">مكان الحفل</div>
                        <span class="rounded-full border border-white/10 bg-white/5 px-3 py-1 text-[11px] font-bold text-white/70">مطلوب للحفلات</span>
                    </div>

                    <div class="grid gap-3 md:grid-cols-2">
                        <div>
                            <label class="mb-1.5 block text-xs font-bold text-white/70">مكان الحفل</label>
                            <div class="onx-select" data-select="event_location_id">
                                <button type="button" class="onx-select-trigger">
                                    <span class="onx-select-label">{{ old('event_location_id') ? ($eventLocations[old('event_location_id')] ?? (old('event_location_id') === 'other' ? 'مكان آخر' : 'اختر المكان')) : 'اختر المكان' }}</span>
                                    <span class="onx-select-arrow">▼</span>
                                </button>
                                <div class="onx-select-dropdown">
                                    @foreach($eventLocations as $id => $name)
                                        <button type="button" class="onx-select-option {{ (string) old('event_location_id') === (string) $id ? 'selected' : '' }}" data-value="{{ $id }}">{{ $name }}</button>
                                    @endforeach
                                    <button type="button" class="onx-select-option {{ old('event_location_id') === 'other' ? 'selected' : '' }}" data-value="other">مكان آخر</button>
                                </div>
                            </div>
                            <select class="onx-hidden-select" name="event_location_id" id="event_location_id">
                                <option value="" {{ old('event_location_id') ? '' : 'selected' }} disabled>اختر المكان</option>
                                @foreach($eventLocations as $id => $name)
                                    <option value="{{ $id }}" {{ (string) old('event_location_id') === (string) $id ? 'selected' : '' }}>{{ $name }}</option>
                                @endforeach
                                <option value="other" {{ old('event_location_id') === 'other' ? 'selected' : '' }}>مكان آخر</option>
                            </select>
                            @error('event_location_id')
                                <p class="mt-1.5 text-xs font-bold text-red-300">{{ $message }}</p>
                            @enderror
                        </div>

                        <div id="customLocationWrap" class="md:col-span-2" {{ old('event_location_id') === 'other' ? '' : 'style=display:none;' }}>
                            <label class="mb-1.5 block text-xs font-bold text-white/70">اكتب مكان الحفل</label>
                            <input class="onx-input {{ $errors->has('custom_event_location') ? 'onx-field-error' : '' }}"
                                name="custom_event_location" id="custom_event_location"
                                value="{{ old('custom_event_location') }}" placeholder="أدخل المكان بالتفصيل">
                            @error('custom_event_location')
                                <p class="mt-1.5 text-xs font-bold text-red-300">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                {{-- 3b. تفاصيل الإعلان --}}
                <div id="adsOnlySection" class="space-y-3" {{ old('service_type', 'event') === 'ads' ? '' : 'style=display:none;' }}>
                    <div class="flex items-center justify-between gap-3">
                        <div class="text-sm font-extrabold text-white">تفاصيل الإعلان</div>
                        <span class="rounded-full border border-white/10 bg-white/5 px-3 py-1 text-[11px] font-bold text-white/70">اختياري جزئيًا</span>
                    </div>

                    <div class="grid gap-3 md:grid-cols-2">
                        <div>
                            <label class="mb-1.5 block text-xs font-bold text-white/70">اسم النشاط التجاري</label>
                            <input class="onx-input {{ $errors->has('business_name') ? 'onx-field-error' : '' }}"
                                name="business_name" value="{{ old('business_name') }}" placeholder="مثال: متجر ONX">
                            @error('business_name')
                                <p class="mt-1.5 text-xs font-bold text-red-300">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="mb-1.5 block text-xs font-bold text-white/70">الميزانية التقريبية</label>
                            <input type="number" min="0" class="onx-input {{ $errors->has('budget') ? 'onx-field-error' : '' }}"
                                name="budget" value="{{ old('budget') }}" placeholder="مثال: 30000">
                            @error('budget')
                                <p class="mt-1.5 text-xs font-bold text-red-300">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="md:col-span-2">
                            <label class="mb-1.5 block text-xs font-bold text-white/70">موعد التسليم المطلوب</label>
                            <input type="date" class="onx-input {{ $errors->has('deadline') ? 'onx-field-error' : '' }}"
                                name="deadline" id="deadline" value="{{ old('deadline') }}">
                            @error('deadline')
                                <p class="mt-1.5 text-xs font-bold text-red-300">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                {{-- 4. معلومات التواصل --}}
                <div class="space-y-3">
                    <div class="text-sm font-extrabold text-white">معلومات التواصل</div>

                    <div class="grid gap-3 md:grid-cols-2">
                        <div>
                            <label class="mb-1.5 block text-xs font-bold text-white/70">الاسم الكامل</label>
                            <input class="onx-input {{ $errors->has('name') ? 'onx-field-error' : '' }}"
                                name="name" value="{{ old('name') }}" required>
                            @error('name')
                                <p class="mt-1.5 text-xs font-bold text-red-300">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="mb-1.5 block text-xs font-bold text-white/70">الهاتف</label>
                            <input class="onx-input {{ $errors->has('phone') ? 'onx-field-error' : '' }}"
                                name="phone" value="{{ old('phone') }}" required>
                            @error('phone')
                                <p class="mt-1.5 text-xs font-bold text-red-300">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="md:col-span-2">
                            <label class="mb-1.5 block text-xs font-bold text-white/70">البريد الإلكتروني</label>
                            <input type="email" class="onx-input {{ $errors->has('email') ? 'onx-field-error' : '' }}"
                                name="email" value="{{ old('email') }}" placeholder="اختياري">
                            @error('email')
                                <p class="mt-1.5 text-xs font-bold text-red-300">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="md:col-span-2">
                            <label class="mb-1.5 block text-xs font-bold text-white/70">ملاحظات</label>
                            <textarea class="onx-textarea {{ $errors->has('notes') ? 'onx-field-error' : '' }}"
                                name="notes" rows="3" placeholder="أي تفاصيل إضافية...">{{ old('notes') }}</textarea>
                            @error('notes')
                                <p class="mt-1.5 text-xs font-bold text-red-300">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                {{-- Submit --}}
                <div class="flex flex-col items-center gap-2">
                    <button
                        class="rounded-full px-10 py-2.5 text-sm font-black text-black disabled:cursor-not-allowed disabled:opacity-40"
                        id="submitBtn" type="submit" disabled>
                        إرسال طلب الحجز
                    </button>
                    <p class="text-center text-xs font-bold text-white/55" id="submitHelp">
                        اختر نوع الخدمة والباقة للمتابعة.
                    </p>
                </div>
            </form>
        </div>

        {{-- Sidebar --}}
        <div class="onx-sticky space-y-4">

            {{-- التقويم --}}
            <div id="calendarCard" class="rounded-[20px] border border-white/10 bg-white/[0.04] p-3 backdrop-blur-xl transition-all duration-500">
                <div class="mb-3 flex items-center justify-between gap-3">
                    <h3 class="text-sm font-black text-white">التقويم</h3>
                    <div class="flex items-center gap-1.5 text-base leading-none">
                        <span title="متوفر">✅</span>
                        <span title="محجوز">❌</span>
                        <span title="قيد التأكيد">🟠</span>
                    </div>
                </div>

                <div class="mb-3 flex gap-2">
                    <div class="onx-select w-1/2" data-select="calendarMonthSelect">
                        <button type="button" class="onx-select-trigger">
                            <span class="onx-select-label">{{ $monthNames[$currentMonth] }}</span>
                            <span class="onx-select-arrow">▼</span>
                        </button>
                        <div class="onx-select-dropdown">
                            @foreach($monthNames as $index => $monthName)
                                <button type="button" class="onx-select-option {{ $index === $currentMonth ? 'selected' : '' }}" data-value="{{ $index }}">{{ $monthName }}</button>
                            @endforeach
                        </div>
                    </div>
                    <select id="calendarMonthSelect" class="onx-hidden-select">
                        @foreach($monthNames as $index => $monthName)
                            <option value="{{ $index }}" {{ $index === $currentMonth ? 'selected' : '' }}>{{ $monthName }}</option>
                        @endforeach
                    </select>

                    <div class="onx-select w-1/2" data-select="calendarYearSelect">
                        <button type="button" class="onx-select-trigger">
                            <span class="onx-select-label">{{ $currentYear }}</span>
                            <span class="onx-select-arrow">▼</span>
                        </button>
                        <div class="onx-select-dropdown">
                            @for($y = $currentYear - 1; $y <= $currentYear + 5; $y++)
                                <button type="button" class="onx-select-option {{ $y === $currentYear ? 'selected' : '' }}" data-value="{{ $y }}">{{ $y }}</button>
                            @endfor
                        </div>
                    </div>
                    <select id="calendarYearSelect" class="onx-hidden-select">
                        @for($y = $currentYear - 1; $y <= $currentYear + 5; $y++)
                            <option value="{{ $y }}" {{ $y === $currentYear ? 'selected' : '' }}>{{ $y }}</option>
                        @endfor
                    </select>
                </div>

                <div class="booking-calendar rounded-2xl border border-white/10 bg-white/[0.03] p-2.5">
                    <div id="onxCalendar"></div>
                </div>

                <div class="mt-3 rounded-2xl border border-white/10 bg-white/[0.03] px-4 py-2.5 text-sm font-bold text-white/85" id="onxStatus">
                    <div class="flex items-center justify-center gap-2">
                        <span class="h-2 w-2 rounded-full bg-white/30" id="onxDot"></span>
                        <span id="onxStatusText">اختر يومًا لعرض حالة التوفر</span>
                    </div>
                </div>


            </div>

            {{-- ملخص الحجز --}}
            <div class="rounded-[20px] border border-white/10 bg-white/[0.04] p-3 backdrop-blur-xl transition-all duration-500">
                <h3 class="mb-3 text-sm font-black text-white">ملخص الحجز</h3>
                <div class="space-y-2.5 text-sm">
                    <div class="flex items-center justify-between border-b border-white/8 pb-2.5">
                        <span class="text-white/50">الخدمة</span>
                        <span class="font-bold text-white" id="summaryService">حفلات</span>
                    </div>
                    <div class="flex items-center justify-between border-b border-white/8 pb-2.5">
                        <span class="text-white/50">الباقة</span>
                        <span class="font-bold text-white text-left" id="summaryPackage"><span class="text-white/35">لم يتم الاختيار</span></span>
                    </div>
                    <div class="flex items-center justify-between border-b border-white/8 pb-2.5" id="summaryDateRow">
                        <span class="text-white/50">التاريخ</span>
                        <span class="font-bold text-white" id="summaryDate"><span class="text-white/35">لم يتم الاختيار</span></span>
                    </div>
                    <div class="flex items-center justify-between border-b border-white/8 pb-2.5" id="summaryLocationRow">
                        <span class="text-white/50">المكان</span>
                        <span class="font-bold text-white" id="summaryLocation"><span class="text-white/35">غير محدد</span></span>
                    </div>
                    <div class="flex items-center justify-between border-b border-white/8 pb-2.5" id="summaryDeadlineRow" style="display:none;">
                        <span class="text-white/50">موعد التسليم</span>
                        <span class="font-bold text-white" id="summaryDeadline"><span class="text-white/35">غير محدد</span></span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-white/50">الحالة</span>
                        <span class="font-bold text-white" id="summaryStatus"><span class="text-white/35">بانتظار الاختيار</span></span>
                    </div>
                </div>
            </div>

            {{-- ملاحظات سريعة --}}
            <div class="rounded-[20px] border border-white/10 bg-white/[0.04] p-3 backdrop-blur-xl transition-all duration-500">
                <h3 class="mb-2.5 text-sm font-black text-white">ملاحظات سريعة</h3>
                <div class="space-y-2 text-xs leading-6 text-white/55">
                    <p>• الحفلات والإعلانات: اختر يومًا من التقويم (مطلوب) ثم الباقة والتفاصيل.</p>
                    <p>• للحفلات يتم التحقق من توفر اليوم؛ للإعلانات حدد اليوم المطلوب للتسليم أو التصوير.</p>
                    <p>• التأكيد النهائي يتم بعد مراجعة الطلب والتواصل معك.</p>
                </div>
            </div>

            </div>
    </div>
</section>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="{{ asset('js/booking.js?v=9') }}"></script>

{{-- ملء حقل الملاحظات من URL param إن وُجد --}}
<script>
(function () {
    const notes = new URLSearchParams(window.location.search).get('notes');
    if (!notes) return;
    document.addEventListener('DOMContentLoaded', function () {
        const field = document.querySelector('textarea[name="notes"]');
        if (field && !field.value.trim()) {
            field.value = decodeURIComponent(notes);
            field.classList.add('border-orange-500/60', 'ring-2', 'ring-orange-500/20');
            setTimeout(() => field.classList.remove('border-orange-500/60', 'ring-2', 'ring-orange-500/20'), 2200);
        }
    });
})();

/* booking.js handles everything else */
</script>
@endpush