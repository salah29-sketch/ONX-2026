@extends('layouts.front')
@section('title','Booking')

@section('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<link rel="stylesheet" href="{{ asset('css/booking.css') }}">
@endsection

@section('content')

<section class="onx-hero-booking">
  <div class="onx-hero-overlay"></div>

  <div class="container text-center">
    <span class="onx-badge mb-3">📅 ONX EDGE • BOOKING</span>

    <h1 class="fw-bold mb-3">احجز خدمتك بسهولة</h1>

    <p class="onx-muted mb-4">
      اختر نوع الخدمة، حدّد الباقة، ثم اختر التاريخ المناسب وسنراجع طلبك بسرعة.
    </p>

    <div class="d-flex justify-content-center gap-2 flex-wrap">
      <a class="btn btn-onx-ghost" href="#bookingForm">ابدأ الحجز</a>
      <a class="btn btn-onx-ghost" href="/services/events">باقات الحفلات</a>
      <a class="btn btn-onx-ghost" href="/services/marketing">باقات الإعلانات</a>
    </div>
  </div>
</section>

@if(session('message'))
  <div class="container mt-4">
    <div class="onx-card p-3 text-center" style="border:1px solid rgba(25,135,84,.35); background:rgba(25,135,84,.08);">
      <strong style="color:#9ef0b3;">{{ session('message') }}</strong>
    </div>
  </div>
@endif

@if($errors->any())
  <div class="container mt-4">
    <div class="alert alert-danger" style="border-radius:16px;">
      <ul class="mb-0">
        @foreach($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
  </div>
@endif

<section id="bookingForm" class="onx-section">
  <div class="container">

    <div class="text-center mb-4">
      <h2 class="fw-bold mb-2">نظام الحجز</h2>
      <p class="onx-muted mb-0">للحفلات: اختر من التقويم وتحقق من توفر اليوم. للإعلانات: اختر الباقة وأرسل مباشرة.</p>
    </div>

    <div class="onx-booking-shell">

      <div class="onx-card onx-form-card">
        <form
          method="POST"
          action="{{ route('booking.store') }}"
          id="bookingFormEl"
          data-booked-days-url="{{ route('booking.bookedDays') }}"
          data-check-date-url="{{ route('booking.check') }}"
        >
          @csrf

          <input type="hidden" name="service_type" id="service_type" value="event">
          <input type="hidden" name="event_date" id="event_date">
          <input type="hidden" name="package_type" id="package_type">
          <input type="hidden" name="package_id" id="package_id">

          {{-- الخدمة --}}
          <div class="mb-4">
            <div class="onx-block-title">اختر نوع الخدمة</div>

            <div class="onx-service-switch">
              <div class="onx-service-card active" data-type="event">
                <h4 class="fw-bold mb-2">حفلات</h4>
                <p class="onx-muted mb-0">حجز تصوير الحفلات</p>
              </div>

              <div class="onx-service-card" data-type="ads">
                <h4 class="fw-bold mb-2">إعلانات</h4>
                <p class="onx-muted mb-0">اشتراك أو إعلان حسب الطلب</p>
              </div>
            </div>
          </div>

          {{-- الباقات --}}
          <div class="mb-4">
            <div class="d-flex align-items-center justify-content-between gap-2 mb-3 flex-wrap">
              <div class="onx-block-title mb-0">اختر الباقة</div>
              <span class="onx-mini-badge" id="packageContextBadge">باقات الحفلات</span>
            </div>

            {{-- حفلات --}}
            <div id="eventPackagesSection" class="onx-simple-Packages">
              @forelse($eventPackages as $p)
                <label class="onx-simple-option">
                  <input
                    type="radio"
                    name="selected_package"
                    value="event:{{ $p->id }}"
                    data-service="event"
                    data-package-type="event"
                    data-package-id="{{ $p->id }}"
                    data-name="{{ $p->name }}"
                  >
                  <span class="onx-simple-option-body">
                    <span class="title">{{ $p->name }}</span>
                    <span class="price">{{ number_format((float) $p->price) }} DA</span>
                  </span>
                </label>
              @empty
                <div class="onx-panel text-center">
                  <h5 class="fw-bold mb-2">لا توجد باقات حفلات حالياً</h5>
                  <p class="onx-muted mb-0">أضفها من لوحة التحكم.</p>
                </div>
              @endforelse
            </div>

            {{-- إعلانات --}}
            <div id="adsPackagesSection" class="onx-simple-Packages" style="display:none;">
              @forelse($adMonthlyPackages as $p)
                <label class="onx-simple-option">
                  <input
                    type="radio"
                    name="selected_package"
                    value="ad:{{ $p->id }}"
                    data-service="ads"
                    data-package-type="ads"
                    data-package-id="{{ $p->id }}"
                    data-name="{{ $p->name }}"
                  >
                  <span class="onx-simple-option-body">
                    <span class="title">{{ $p->name }}</span>
                    <span class="price">
                      {{ $p->price ? number_format((float) $p->price).' DA' : ($p->price_note ?: '—') }}
                    </span>
                  </span>
                </label>
              @empty
              @endforelse

              @forelse($adCustomPackages as $p)
                <label class="onx-simple-option">
                  <input
                    type="radio"
                    name="selected_package"
                    value="ad:{{ $p->id }}"
                    data-service="ads"
                    data-package-type="ads"
                    data-package-id="{{ $p->id }}"
                    data-name="{{ $p->name }}"
                  >
                  <span class="onx-simple-option-body">
                    <span class="title">{{ $p->name }}</span>
                    <span class="price">{{ $p->price_note ?: 'حسب الطلب' }}</span>
                  </span>
                </label>
              @empty
                @if(($adMonthlyPackages->count() ?? 0) === 0)
                  <div class="onx-panel text-center">
                    <h5 class="fw-bold mb-2">لا توجد باقات إعلانات حالياً</h5>
                    <p class="onx-muted mb-0">أضفها من لوحة التحكم.</p>
                  </div>
                @endif
              @endforelse
            </div>
          </div>

          {{-- الحفلات --}}
          <div class="mb-4" id="eventOnlySection">
            <div class="onx-block-title">التاريخ وتفاصيل الحفلة</div>

            <div class="row g-3">
              <div class="col-md-6">
                <div class="onx-label">التاريخ المختار</div>
                <input class="form-control onx-input" id="event_date_preview" placeholder="اختر من التقويم" readonly>
                <div class="onx-help mt-1">اختر يومًا من التقويم، وسيظهر لك إن كان متاحًا أو محجوزًا.</div>
              </div>

              <div class="col-md-6">
                <div class="onx-label">مكان الحفل</div>
                <select class="form-control onx-input" name="event_location_id" id="event_location_id">
                  <option value="" selected disabled>اختر</option>
                  @foreach($eventLocations as $id => $name)
                    <option value="{{ $id }}">{{ $name }}</option>
                  @endforeach
                  <option value="other">مكان آخر</option>
                </select>
              </div>

              <div class="col-12" id="customLocationWrap" style="display:none;">
                <div class="onx-label">اكتب مكان الحفل</div>
                <input class="form-control onx-input" name="custom_event_location" id="custom_event_location">
              </div>
            </div>
          </div>

          {{-- الإعلانات --}}
          <div class="mb-4" id="adsOnlySection" style="display:none;">
            <div class="onx-block-title">تفاصيل الإعلان</div>

            <div class="row g-3">
              <div class="col-md-6">
                <div class="onx-label">اسم النشاط التجاري</div>
                <input class="form-control onx-input" name="business_name">
              </div>

              <div class="col-md-6">
                <div class="onx-label">الميزانية التقريبية</div>
                <input type="number" min="0" class="form-control onx-input" name="budget">
              </div>

              <div class="col-12">
                <div class="onx-label">موعد التسليم المطلوب</div>
                <input type="date" class="form-control onx-input" name="deadline" id="deadline">
              </div>
            </div>
          </div>

          {{-- التواصل --}}
          <div class="mb-3">
            <div class="onx-block-title">معلومات التواصل</div>

            <div class="row g-3">
              <div class="col-md-6">
                <div class="onx-label">الاسم الكامل</div>
                <input class="form-control onx-input" name="name" required>
              </div>

              <div class="col-md-6">
                <div class="onx-label">الهاتف</div>
                <input class="form-control onx-input" name="phone" required>
              </div>

              <div class="col-12">
                <div class="onx-label">البريد الإلكتروني</div>
                <input type="email" class="form-control onx-input" name="email" placeholder="اختياري">
              </div>

              <div class="col-12">
                <div class="onx-label">ملاحظات</div>
                <textarea class="form-control onx-input" name="notes" rows="4" placeholder="أي تفاصيل إضافية..."></textarea>
              </div>
            </div>
          </div>

          <div class="mt-4">
            <button class="btn btn-onx-book w-100 onx-submit" id="submitBtn" type="submit" disabled>
              إرسال طلب الحجز
            </button>
            <div class="onx-help text-center mt-2" id="submitHelp">
              للحفلات: اختر باقة ويومًا متاحًا. للإعلانات: اختر الباقة ثم أرسل مباشرة.
            </div>
          </div>
        </form>
      </div>

      <div class="d-grid gap-3">
        <div class="onx-card onx-side-card" id="calendarCard">
          <div class="d-flex align-items-center justify-content-between gap-2 mb-3 flex-wrap">
            <h5 class="fw-bold mb-0">التقويم</h5>
            <span class="onx-mini-badge">للحفلات فقط</span>
          </div>

          <div class="onx-calendar-toolbar">
            <select id="calendarMonthSelect" class="onx-calendar-select"></select>
            <select id="calendarYearSelect" class="onx-calendar-select"></select>
          </div>

          <div class="onx-calendar-shell">
            <div id="onxCalendar"></div>
          </div>

          <div class="mt-3">
            <div class="onx-status" id="onxStatus">
              <span class="dot" id="onxDot"></span>
              <span id="onxStatusText">اختر يومًا</span>
            </div>

            <div class="onx-help text-center mt-2">
              الأيام المحجوزة تظهر بالأحمر. بعد اختيار اليوم ستظهر حالة التوفر مباشرة.
            </div>
          </div>
        </div>

        <div class="onx-card onx-side-card">
          <h5 class="fw-bold mb-3">ملخص الحجز</h5>

          <div class="onx-summary">
            <div class="onx-summary-row">
              <div class="k">الخدمة</div>
              <div class="v" id="summaryService">حفلات</div>
            </div>

            <div class="onx-summary-row">
              <div class="k">الباقة</div>
              <div class="v" id="summaryPackage"><span class="onx-empty">لم يتم الاختيار</span></div>
            </div>

            <div class="onx-summary-row">
              <div class="k">التاريخ</div>
              <div class="v" id="summaryDate"><span class="onx-empty">لم يتم الاختيار</span></div>
            </div>

            <div class="onx-summary-row">
              <div class="k">الحالة</div>
              <div class="v" id="summaryStatus"><span class="onx-empty">بانتظار الاختيار</span></div>
            </div>
          </div>
        </div>
      </div>

    </div>
  </div>
</section>

<section class="onx-section pt-0">
  <div class="container">
    <div class="row g-4 align-items-stretch">
      <div class="col-lg-6">
        <div class="onx-panel h-100">
          <h3 class="fw-bold mb-3">الشروط</h3>

          <div class="onx-qa">
            <div class="onx-qa-item">
              <div class="q">الحفلات</div>
              <div class="a">الأيام المحجوزة لا يمكن اختيارها، ويجب تحديد يوم متاح قبل الإرسال.</div>
            </div>

            <div class="onx-qa-item">
              <div class="q">الإعلانات</div>
              <div class="a">الإعلانات لا ترتبط بالتقويم ويمكن إرسال الطلب مباشرة بعد اختيار الباقة.</div>
            </div>

            <div class="onx-qa-item">
              <div class="q">تأكيد الحجز</div>
              <div class="a">التأكيد النهائي يتم بعد مراجعة الطلب والتواصل معك.</div>
            </div>
          </div>
        </div>
      </div>

      <div class="col-lg-6">
        <div class="onx-panel h-100">
          <h3 class="fw-bold mb-3">لماذا ONX؟</h3>

          <div class="onx-qa">
            <div class="onx-qa-item">
              <div class="q">🎬 تجربة واضحة</div>
              <div class="a">اختيار مباشر للخدمة والباقة والتاريخ بدون تعقيد.</div>
            </div>

            <div class="onx-qa-item">
              <div class="q">⚡ تحقق فوري</div>
              <div class="a">بمجرد اختيار اليوم تعرف مباشرة هل هو متاح أم محجوز.</div>
            </div>

            <div class="onx-qa-item">
              <div class="q">🤝 تواصل سريع</div>
              <div class="a">نراجع الطلبات بسرعة ونؤكد التفاصيل بأوضح طريقة.</div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="{{ asset('js/booking.js') }}"></script>
@endsection