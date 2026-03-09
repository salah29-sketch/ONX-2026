@extends('layouts.front_tailwind')
@section('title', 'booking - ONX')

@push('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

<style>
    .booking-calendar {
        direction: ltr;
    }

    .booking-calendar .flatpickr-calendar,
    .booking-calendar .flatpickr-calendar.inline {
        background: transparent !important;
        box-shadow: none !important;
        border: 0 !important;
        width: 100% !important;
    }

    .booking-calendar .flatpickr-months {
        display: none !important;
    }

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
        color: white !important;
        font-size: 13px !important;
        font-weight: 700 !important;
        border: 1px solid transparent !important;
    }

    .booking-calendar .flatpickr-day.today {
        border-color: rgba(249,115,22,.55) !important;
        box-shadow: inset 0 0 0 1px rgba(249,115,22,.55);
    }

    .booking-calendar .flatpickr-day.selected {
        background: rgba(249,115,22,.95) !important;
        border-color: rgba(249,115,22,.95) !important;
        color: #111 !important;
    }

    .booking-calendar .flatpickr-day.onx-booked-day {
        background: rgba(239,68,68,.18) !important;
        border-color: rgba(239,68,68,.55) !important;
    }

    .booking-calendar .flatpickr-day.onx-pending-day {
        background: rgba(245,158,11,.18) !important;
        border-color: rgba(245,158,11,.55) !important;
    }

    .booking-calendar .flatpickr-day.prevMonthDay,
    .booking-calendar .flatpickr-day.nextMonthDay {
        color: rgba(255,255,255,.28) !important;
        opacity: .55 !important;
    }

    .booking-calendar .flatpickr-day.prevMonthDay:hover,
    .booking-calendar .flatpickr-day.nextMonthDay:hover {
        color: rgba(255,255,255,.45) !important;
        background: rgba(255,255,255,.04) !important;
    }

    .booking-calendar .flatpickr-day.flatpickr-disabled {
        opacity: .35 !important;
    }

    .service-card.active {
        border-color: rgba(249,115,22,.75);
        background: rgba(249,115,22,.10);
        box-shadow: 0 0 0 1px rgba(249,115,22,.25) inset;
    }

    .package-option input {
        position: absolute;
        opacity: 0;
        pointer-events: none;
    }

    .package-option input:checked + .package-box {
        border-color: rgba(249,115,22,.75);
        background: rgba(249,115,22,.10);
        box-shadow: 0 0 0 1px rgba(249,115,22,.25) inset;
    }

    .onx-hidden-select {
        display: none !important;
    }

    .onx-select {
        position: relative;
        width: 100%;
    }

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
        transition: .2s ease;
        min-height: 44px;
    }

    .onx-select.open .onx-select-trigger {
        border-color: rgba(249,115,22,.65);
        box-shadow: 0 0 0 3px rgba(249,115,22,.16);
    }

    .onx-select-label {
        color: #fff;
        font-size: 13px;
        font-weight: 700;
    }

    .onx-select-arrow {
        color: #fff;
        font-size: 11px;
        transition: transform .2s ease;
    }

    .onx-select.open .onx-select-arrow {
        transform: rotate(180deg);
    }

    .onx-select-dropdown {
        position: absolute;
        top: calc(100% + 6px);
        left: 0;
        right: 0;
        background: #111111;
        border: 1px solid rgba(255,255,255,.10);
        border-radius: 12px;
        max-height: 220px;
        overflow-y: auto;
        display: none;
        z-index: 60;
        box-shadow: 0 16px 40px rgba(0,0,0,.35);
    }

    .onx-select.open .onx-select-dropdown {
        display: block;
    }

    .onx-select-option {
        padding: 10px 14px;
        cursor: pointer;
        color: #fff;
        font-size: 13px;
        font-weight: 600;
        transition: .15s ease;
    }

    .onx-select-option:hover {
        background: rgba(249,115,22,.20);
    }

    .onx-select-option.selected {
        background: #f97316;
        color: #000;
        font-weight: 800;
    }
</style>
@endpush

@section('content')
<section class="relative overflow-hidden border-b border-white/10">
    <div class="absolute inset-0">
        <img
            src="{{ asset('img/front/booking/booking-hero.png') }}"
            alt="Booking Hero"
            class="h-full w-full object-cover opacity-15"
        >
        <div class="absolute inset-0 bg-gradient-to-b from-black/40 via-black/70 to-[#050505]"></div>
    </div>

    <div class="relative mx-auto max-w-7xl px-6 py-14 lg:px-8 lg:py-16">
        <div class="max-w-3xl">
            <span class="inline-flex rounded-full border border-orange-500/25 bg-orange-500/10 px-4 py-1 text-[11px] font-extrabold tracking-wide text-orange-300">
                ONX BOOKING
            </span>

            <h1 class="mt-4 text-3xl font-black leading-tight text-white sm:text-4xl">
                احجز خدمتك بسهولة
            </h1>

            <p class="mt-3 max-w-2xl text-sm leading-7 text-white/65 sm:text-base">
                اختر نوع الخدمة، حدّد الباقة المناسبة، ثم أكمل تفاصيل الحجز بخطوات واضحة وسريعة.
            </p>

            <div class="mt-6 flex flex-wrap gap-3">
                <a href="#bookingForm"
                   class="inline-flex rounded-full bg-orange-500 px-5 py-2.5 text-sm font-extrabold text-black transition hover:bg-orange-400">
                    ابدأ الحجز
                </a>

                <a href="{{ route('services.events') }}"
                   class="inline-flex rounded-full border border-white/10 bg-white/5 px-5 py-2.5 text-sm font-bold text-white/80 transition hover:border-orange-500/40 hover:bg-orange-500/10 hover:text-white">
                    باقات الحفلات
                </a>

                <a href="{{ route('services.marketing') }}"
                   class="inline-flex rounded-full border border-white/10 bg-white/5 px-5 py-2.5 text-sm font-bold text-white/80 transition hover:border-orange-500/40 hover:bg-orange-500/10 hover:text-white">
                    باقات الإعلانات
                </a>
            </div>
        </div>
    </div>
</section>

@if(session('message'))
    <section class="mx-auto mt-6 max-w-7xl px-6 lg:px-8">
        <div class="rounded-2xl border border-emerald-500/30 bg-emerald-500/10 px-4 py-3 text-sm font-bold text-emerald-300">
            {{ session('message') }}
        </div>
    </section>
@endif

@if($errors->any())
    <section class="mx-auto mt-6 max-w-7xl px-6 lg:px-8">
        <div class="rounded-2xl border border-red-500/30 bg-red-500/10 p-4 text-sm text-red-200">
            <ul class="space-y-1">
                @foreach($errors->all() as $error)
                    <li>• {{ $error }}</li>
                @endforeach
            </ul>
        </div>
    </section>
@endif

<section id="bookingForm" class="mx-auto max-w-7xl px-6 py-10 lg:px-8">
    <div class="mb-8 text-center">
        <h2 class="text-2xl font-black text-white">نظام الحجز</h2>
        <p class="mt-2 text-sm text-white/60">
            للحفلات: اختر من التقويم وتحقق من التوفر. للإعلانات: اختر الباقة وأرسل مباشرة.
        </p>
    </div>

    <div class="grid gap-6 lg:grid-cols-[minmax(0,1fr)_320px]">
        {{-- الفورم --}}
        <div class="rounded-[28px] border border-white/10 bg-white/[0.04] p-5 shadow-[0_20px_60px_rgba(0,0,0,0.25)] backdrop-blur-xl sm:p-6">
            <form
                method="POST"
                action="{{ route('booking.store') }}"
                id="bookingFormEl"
                data-booked-days-url="{{ route('booking.bookedDays') }}"
                data-check-date-url="{{ route('booking.check') }}"
                class="space-y-7"
            >
                @csrf

                <input type="hidden" name="service_type" id="service_type" value="event">
                <input type="hidden" name="event_date" id="event_date">
                <input type="hidden" name="package_type" id="package_type">
                <input type="hidden" name="package_id" id="package_id">

                <div>
                    <div class="mb-3 text-sm font-extrabold text-white">اختر نوع الخدمة</div>

                    <div class="grid gap-3 sm:grid-cols-2">
                        <div
                            class="service-card onx-service-card active cursor-pointer rounded-2xl border border-white/10 bg-white/[0.03] p-4 transition hover:border-orange-500/40 hover:bg-orange-500/5"
                            data-type="event"
                        >
                            <h3 class="text-base font-black text-white">حفلات</h3>
                            <p class="mt-1 text-sm text-white/55">حجز تصوير الحفلات مع اختيار التاريخ.</p>
                        </div>

                        <div
                            class="service-card onx-service-card cursor-pointer rounded-2xl border border-white/10 bg-white/[0.03] p-4 transition hover:border-orange-500/40 hover:bg-orange-500/5"
                            data-type="ads"
                        >
                            <h3 class="text-base font-black text-white">إعلانات</h3>
                            <p class="mt-1 text-sm text-white/55">اشتراك شهري أو إعلان حسب الطلب.</p>
                        </div>
                    </div>
                </div>

                <div>
                    <div class="mb-3 flex items-center justify-between gap-3">
                        <div class="text-sm font-extrabold text-white">اختر الباقة</div>
                        <span id="packageContextBadge" class="rounded-full border border-white/10 bg-white/5 px-3 py-1 text-[11px] font-bold text-white/70">
                            باقات الحفلات
                        </span>
                    </div>

                    <div id="eventPackagesSection" class="space-y-3">
                        @forelse($eventPackages as $p)
                            <label class="package-option block cursor-pointer">
                                <input
                                    type="radio"
                                    name="selected_package"
                                    value="event:{{ $p->id }}"
                                    data-service="event"
                                    data-package-type="event"
                                    data-package-id="{{ $p->id }}"
                                    data-name="{{ $p->name }}"
                                >

                                <span class="package-box block rounded-2xl border border-white/10 bg-white/[0.03] p-4 transition hover:border-orange-500/40 hover:bg-orange-500/5">
                                    <span class="flex items-center justify-between gap-4">
                                        <span class="block text-sm font-black text-white">{{ $p->name }}</span>

                                        <span class="shrink-0 text-left">
                                            @if(!empty($p->old_price))
                                                <span class="block text-xs text-white/35 line-through">
                                                    {{ number_format((float) $p->old_price) }} DA
                                                </span>
                                            @endif
                                            <span class="block text-sm font-black text-orange-300">
                                                {{ number_format((float) $p->price) }} DA
                                            </span>
                                        </span>
                                    </span>
                                </span>
                            </label>
                        @empty
                            <div class="rounded-2xl border border-white/10 bg-white/[0.03] p-5 text-center">
                                <p class="text-sm font-bold text-white">لا توجد باقات حفلات حالياً</p>
                                <p class="mt-1 text-xs text-white/50">أضفها من لوحة التحكم.</p>
                            </div>
                        @endforelse
                    </div>

                    <div id="adsPackagesSection" class="space-y-3" style="display:none;">
                        @forelse($adMonthlyPackages as $p)
                            <label class="package-option block cursor-pointer">
                                <input
                                    type="radio"
                                    name="selected_package"
                                    value="ad:{{ $p->id }}"
                                    data-service="ads"
                                    data-package-type="ads"
                                    data-package-id="{{ $p->id }}"
                                    data-name="{{ $p->name }}"
                                >

                                <span class="package-box block rounded-2xl border border-white/10 bg-white/[0.03] p-4 transition hover:border-orange-500/40 hover:bg-orange-500/5">
                                    <span class="flex items-center justify-between gap-4">
                                        <span class="block text-sm font-black text-white">{{ $p->name }}</span>
                                        <span class="shrink-0 text-left text-sm font-black text-orange-300">
                                            {{ $p->price ? number_format((float) $p->price).' DA' : ($p->price_note ?: '—') }}
                                        </span>
                                    </span>
                                </span>
                            </label>
                        @empty
                        @endforelse

                        @forelse($adCustomPackages as $p)
                            <label class="package-option block cursor-pointer">
                                <input
                                    type="radio"
                                    name="selected_package"
                                    value="ad:{{ $p->id }}"
                                    data-service="ads"
                                    data-package-type="ads"
                                    data-package-id="{{ $p->id }}"
                                    data-name="{{ $p->name }}"
                                >

                                <span class="package-box block rounded-2xl border border-white/10 bg-white/[0.03] p-4 transition hover:border-orange-500/40 hover:bg-orange-500/5">
                                    <span class="flex items-center justify-between gap-4">
                                        <span class="block text-sm font-black text-white">{{ $p->name }}</span>
                                        <span class="shrink-0 text-left text-sm font-black text-orange-300">
                                            {{ $p->price_note ?: 'حسب الطلب' }}
                                        </span>
                                    </span>
                                </span>
                            </label>
                        @empty
                            @if(($adMonthlyPackages->count() ?? 0) === 0)
                                <div class="rounded-2xl border border-white/10 bg-white/[0.03] p-5 text-center">
                                    <p class="text-sm font-bold text-white">لا توجد باقات إعلانات حالياً</p>
                                    <p class="mt-1 text-xs text-white/50">أضفها من لوحة التحكم.</p>
                                </div>
                            @endif
                        @endforelse
                    </div>
                </div>

                <div id="eventOnlySection" class="space-y-4">
                    <div class="text-sm font-extrabold text-white">التاريخ وتفاصيل الحفلة</div>

                    <div class="grid gap-4 md:grid-cols-2">
                        <div>
                            <label class="mb-2 block text-xs font-bold text-white/70">التاريخ المختار</label>
                            <input
                                class="w-full rounded-2xl border border-white/10 bg-white/5 px-4 py-3 text-sm text-white outline-none placeholder:text-white/30 focus:border-orange-500/50"
                                id="event_date_preview"
                                placeholder="اختر من التقويم"
                                readonly
                            >
                            <p class="mt-2 text-xs leading-6 text-white/45">
                                اختر يومًا من التقويم، وستظهر حالة التوفر مباشرة.
                            </p>
                        </div>

                        <div>
                            <label class="mb-2 block text-xs font-bold text-white/70">مكان الحفل</label>

                            <div class="onx-select" data-select="event_location_id">
                                <div class="onx-select-trigger">
                                    <span class="onx-select-label">Choisir</span>
                                    <span class="onx-select-arrow">▼</span>
                                </div>

                                <div class="onx-select-dropdown">
                                    @foreach($eventLocations as $id => $name)
                                        <div class="onx-select-option" data-value="{{ $id }}">{{ $name }}</div>
                                    @endforeach
                                    <div class="onx-select-option" data-value="other">Autre lieu</div>
                                </div>
                            </div>

                            <select
                                class="onx-hidden-select"
                                name="event_location_id"
                                id="event_location_id"
                            >
                                <option value="" selected disabled>Choisir</option>
                                @foreach($eventLocations as $id => $name)
                                    <option value="{{ $id }}">{{ $name }}</option>
                                @endforeach
                                <option value="other">Autre lieu</option>
                            </select>
                        </div>

                        <div id="customLocationWrap" class="md:col-span-2" style="display:none;">
                            <label class="mb-2 block text-xs font-bold text-white/70">اكتب مكان الحفل</label>
                            <input
                                class="w-full rounded-2xl border border-white/10 bg-white/5 px-4 py-3 text-sm text-white outline-none placeholder:text-white/30 focus:border-orange-500/50"
                                name="custom_event_location"
                                id="custom_event_location"
                            >
                        </div>
                    </div>
                </div>

                <div id="adsOnlySection" class="space-y-4" style="display:none;">
                    <div class="text-sm font-extrabold text-white">تفاصيل الإعلان</div>

                    <div class="grid gap-4 md:grid-cols-2">
                        <div>
                            <label class="mb-2 block text-xs font-bold text-white/70">اسم النشاط التجاري</label>
                            <input
                                class="w-full rounded-2xl border border-white/10 bg-white/5 px-4 py-3 text-sm text-white outline-none placeholder:text-white/30 focus:border-orange-500/50"
                                name="business_name"
                            >
                        </div>

                        <div>
                            <label class="mb-2 block text-xs font-bold text-white/70">الميزانية التقريبية</label>
                            <input
                                type="number"
                                min="0"
                                class="w-full rounded-2xl border border-white/10 bg-white/5 px-4 py-3 text-sm text-white outline-none placeholder:text-white/30 focus:border-orange-500/50"
                                name="budget"
                            >
                        </div>

                        <div class="md:col-span-2">
                            <label class="mb-2 block text-xs font-bold text-white/70">موعد التسليم المطلوب</label>
                            <input
                                type="date"
                                class="w-full rounded-2xl border border-white/10 bg-white/5 px-4 py-3 text-sm text-white outline-none focus:border-orange-500/50"
                                name="deadline"
                                id="deadline"
                            >
                        </div>
                    </div>
                </div>

                <div class="space-y-4">
                    <div class="text-sm font-extrabold text-white">معلومات التواصل</div>

                    <div class="grid gap-4 md:grid-cols-2">
                        <div>
                            <label class="mb-2 block text-xs font-bold text-white/70">الاسم الكامل</label>
                            <input
                                class="w-full rounded-2xl border border-white/10 bg-white/5 px-4 py-3 text-sm text-white outline-none placeholder:text-white/30 focus:border-orange-500/50"
                                name="name"
                                required
                            >
                        </div>

                        <div>
                            <label class="mb-2 block text-xs font-bold text-white/70">الهاتف</label>
                            <input
                                class="w-full rounded-2xl border border-white/10 bg-white/5 px-4 py-3 text-sm text-white outline-none placeholder:text-white/30 focus:border-orange-500/50"
                                name="phone"
                                required
                            >
                        </div>

                        <div class="md:col-span-2">
                            <label class="mb-2 block text-xs font-bold text-white/70">البريد الإلكتروني</label>
                            <input
                                type="email"
                                class="w-full rounded-2xl border border-white/10 bg-white/5 px-4 py-3 text-sm text-white outline-none placeholder:text-white/30 focus:border-orange-500/50"
                                name="email"
                                placeholder="اختياري"
                            >
                        </div>

                        <div class="md:col-span-2">
                            <label class="mb-2 block text-xs font-bold text-white/70">ملاحظات</label>
                            <textarea
                                class="w-full rounded-2xl border border-white/10 bg-white/5 px-4 py-3 text-sm text-white outline-none placeholder:text-white/30 focus:border-orange-500/50"
                                name="notes"
                                rows="4"
                                placeholder="أي تفاصيل إضافية..."
                            ></textarea>
                        </div>
                    </div>
                </div>

                <div class="pt-2">
                    <button
                        class="w-full rounded-full bg-orange-500 px-5 py-3 text-sm font-black text-black transition hover:bg-orange-400 disabled:cursor-not-allowed disabled:opacity-40"
                        id="submitBtn"
                        type="submit"
                        disabled
                    >
                        إرسال طلب الحجز
                    </button>

                    <p class="mt-3 text-center text-xs text-white/45" id="submitHelp">
                        للحفلات: اختر باقة ويومًا متاحًا. للإعلانات: اختر الباقة ثم أرسل مباشرة.
                    </p>
                </div>
            </form>
        </div>

        {{-- sidebar --}}
        <div class="space-y-4">
            <div id="calendarCard" class="rounded-[28px] border border-white/10 bg-white/[0.04] p-5 backdrop-blur-xl">
                <div class="mb-4 flex items-center justify-between gap-3">
                    <h3 class="text-sm font-black text-white">calendrier</h3>
                    <span class="rounded-full border border-white/10 bg-white/5 px-3 py-1 text-[11px] font-bold text-white/70">
                        للحفلات فقط
                    </span>
                </div>

                <div class="mb-4 flex gap-2">
                    <div class="onx-select w-1/2" data-select="calendarMonthSelect">
                        <div class="onx-select-trigger">
                            <span class="onx-select-label">Mars</span>
                            <span class="onx-select-arrow">▼</span>
                        </div>

                        <div class="onx-select-dropdown">
                            <div class="onx-select-option" data-value="0">Janvier</div>
                            <div class="onx-select-option" data-value="1">Février</div>
                            <div class="onx-select-option selected" data-value="2">Mars</div>
                            <div class="onx-select-option" data-value="3">Avril</div>
                            <div class="onx-select-option" data-value="4">Mai</div>
                            <div class="onx-select-option" data-value="5">Juin</div>
                            <div class="onx-select-option" data-value="6">Juillet</div>
                            <div class="onx-select-option" data-value="7">Août</div>
                            <div class="onx-select-option" data-value="8">Septembre</div>
                            <div class="onx-select-option" data-value="9">Octobre</div>
                            <div class="onx-select-option" data-value="10">Novembre</div>
                            <div class="onx-select-option" data-value="11">Décembre</div>
                        </div>
                    </div>

                    <select id="calendarMonthSelect" class="onx-hidden-select">
                        <option value="0">Janvier</option>
                        <option value="1">Février</option>
                        <option value="2" selected>Mars</option>
                        <option value="3">Avril</option>
                        <option value="4">Mai</option>
                        <option value="5">Juin</option>
                        <option value="6">Juillet</option>
                        <option value="7">Août</option>
                        <option value="8">Septembre</option>
                        <option value="9">Octobre</option>
                        <option value="10">Novembre</option>
                        <option value="11">Décembre</option>
                    </select>

                    <div class="onx-select w-1/2" data-select="calendarYearSelect">
                        <div class="onx-select-trigger">
                            <span class="onx-select-label">{{ now()->year }}</span>
                            <span class="onx-select-arrow">▼</span>
                        </div>

                        <div class="onx-select-dropdown">
                            @for($y = now()->year - 2; $y <= now()->year + 5; $y++)
                                <div class="onx-select-option {{ $y === now()->year ? 'selected' : '' }}" data-value="{{ $y }}">{{ $y }}</div>
                            @endfor
                        </div>
                    </div>

                    <select id="calendarYearSelect" class="onx-hidden-select">
                        @for($y = now()->year - 2; $y <= now()->year + 5; $y++)
                            <option value="{{ $y }}" {{ $y === now()->year ? 'selected' : '' }}>{{ $y }}</option>
                        @endfor
                    </select>
                </div>

                <div class="booking-calendar rounded-2xl border border-white/10 bg-white/[0.03] p-3">
                    <div id="onxCalendar"></div>
                </div>

                <div class="mt-4 rounded-2xl border border-white/10 bg-white/[0.03] px-4 py-3 text-sm font-bold text-white/85" id="onxStatus">
                    <div class="flex items-center justify-center gap-2">
                        <span class="h-2.5 w-2.5 rounded-full bg-white/30" id="onxDot"></span>
                        <span id="onxStatusText">اختر يومًا</span>
                    </div>
                </div>

                <p class="mt-3 text-center text-xs leading-6 text-white/45">
                    الأيام المؤكدة بالأحمر، والمؤقتة بالبرتقالي.
                </p>
            </div>

            <div class="rounded-[28px] border border-white/10 bg-white/[0.04] p-5 backdrop-blur-xl">
                <h3 class="mb-4 text-sm font-black text-white">ملخص الحجز</h3>

                <div class="space-y-3 text-sm">
                    <div class="flex items-center justify-between border-b border-white/8 pb-3">
                        <span class="text-white/50">الخدمة</span>
                        <span class="font-bold text-white" id="summaryService">حفلات</span>
                    </div>

                    <div class="flex items-center justify-between border-b border-white/8 pb-3">
                        <span class="text-white/50">الباقة</span>
                        <span class="font-bold text-white" id="summaryPackage">
                            <span class="text-white/35">لم يتم الاختيار</span>
                        </span>
                    </div>

                    <div class="flex items-center justify-between border-b border-white/8 pb-3">
                        <span class="text-white/50">التاريخ</span>
                        <span class="font-bold text-white" id="summaryDate">
                            <span class="text-white/35">لم يتم الاختيار</span>
                        </span>
                    </div>

                    <div class="flex items-center justify-between">
                        <span class="text-white/50">الحالة</span>
                        <span class="font-bold text-white" id="summaryStatus">
                            <span class="text-white/35">بانتظار الاختيار</span>
                        </span>
                    </div>
                </div>
            </div>

            <div class="rounded-[28px] border border-white/10 bg-white/[0.04] p-5 backdrop-blur-xl">
                <h3 class="mb-3 text-sm font-black text-white">ملاحظات سريعة</h3>
                <div class="space-y-3 text-xs leading-6 text-white/55">
                    <p>• الحفلات تحتاج اختيار يوم متاح قبل الإرسال.</p>
                    <p>• الإعلانات لا تعتمد على التقويم ويمكن إرسالها مباشرة.</p>
                    <p>• التأكيد النهائي يتم بعد مراجعة الطلب والتواصل معك.</p>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="{{ asset('js/booking.js?v=3') }}"></script>
@endpush