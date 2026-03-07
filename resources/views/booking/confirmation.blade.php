@extends('layouts.front')
@section('title', 'تأكيد الحجز')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/booking.css') }}">
@endsection

@section('content')

<section class="onx-hero-booking onx-hero-confirmation">
    <div class="onx-hero-overlay"></div>

    <div class="container text-center">
        <span class="onx-badge mb-3">✅ ONX EDGE • CONFIRMATION</span>

        <h1 class="fw-bold mb-3">تم استلام طلبك بنجاح</h1>

        <p class="onx-muted mb-4">
            طلبك وصلنا بنجاح وهو الآن قيد المراجعة. ستظهر لك هنا كل التفاصيل الأساسية الخاصة بالحجز.
        </p>

        <div class="d-flex justify-content-center gap-2 flex-wrap">
            <a class="btn btn-onx-ghost" href="{{ route('booking') }}">حجز جديد</a>
            <a class="btn btn-onx-book" target="_blank"
               href="https://wa.me/213540573518?text={{ urlencode(
                    'السلام عليكم، أرسلت طلب حجز عبر موقع ONX.' . "\n" .
                    'رقم الطلب: #' . $booking->id . "\n" .
                    'الاسم: ' . $booking->name . "\n" .
                    'نوع الخدمة: ' . ($booking->service_type === 'event' ? 'حفلات' : 'إعلانات')
               ) }}">
                تواصل عبر WhatsApp
            </a>
        </div>
    </div>
</section>

<section class="onx-section">
    <div class="container">
        <div class="onx-booking-shell">

            <div class="onx-card onx-form-card">
                <div class="onx-confirm-success mb-4">
                    <div class="onx-confirm-icon">✓</div>
                    <div>
                        <h3 class="fw-bold mb-1">تم إنشاء الطلب بنجاح</h3>
                        <p class="onx-muted mb-0">
                            هذا الطلب مسجل مبدئيًا داخل النظام، والتأكيد النهائي يتم بعد مراجعة الإدارة والتواصل معك.
                        </p>
                    </div>
                </div>

                <div class="onx-block-title">بيانات الطلب</div>

                <div class="onx-confirm-grid">
                    <div class="onx-confirm-item">
                        <span class="label">رقم الطلب</span>
                        <strong>#{{ $booking->id }}</strong>
                    </div>

                    <div class="onx-confirm-item">
                        <span class="label">الحالة</span>
                        @if($booking->status === 'confirmed')
                            <span class="onx-status-badge confirmed">مؤكد</span>
                        @elseif($booking->status === 'unconfirmed')
                            <span class="onx-status-badge pending">غير مؤكد</span>
                        @else
                            <span class="onx-status-badge neutral">{{ $booking->status }}</span>
                        @endif
                    </div>

                    <div class="onx-confirm-item">
                        <span class="label">نوع الخدمة</span>
                        <strong>{{ $booking->service_type === 'event' ? 'حفلات' : 'إعلانات' }}</strong>
                    </div>

                    <div class="onx-confirm-item">
                        <span class="label">الباقة</span>
                        <strong>{{ $packageName ?: 'لم يتم تحديد باقة' }}</strong>
                    </div>
                </div>

                <div class="onx-divider my-4"></div>

                <div class="onx-block-title">معلومات العميل</div>

                <div class="onx-confirm-grid">
                    <div class="onx-confirm-item">
                        <span class="label">الاسم الكامل</span>
                        <strong>{{ $booking->name }}</strong>
                    </div>

                    <div class="onx-confirm-item">
                        <span class="label">الهاتف</span>
                        <strong>{{ $booking->phone }}</strong>
                    </div>

                    <div class="onx-confirm-item">
                        <span class="label">البريد الإلكتروني</span>
                        <strong>{{ $booking->email ?: 'غير مضاف' }}</strong>
                    </div>

                    @if($booking->service_type === 'ads' && !empty($booking->business_name))
                        <div class="onx-confirm-item">
                            <span class="label">اسم النشاط التجاري</span>
                            <strong>{{ $booking->business_name }}</strong>
                        </div>
                    @endif
                </div>

                <div class="onx-divider my-4"></div>

                <div class="onx-block-title">تفاصيل الخدمة</div>

                <div class="onx-confirm-grid">
                    @if($booking->service_type === 'event')
                        <div class="onx-confirm-item">
                            <span class="label">تاريخ الحفل</span>
                            <strong>{{ \Carbon\Carbon::parse($booking->event_date)->format('Y-m-d') }}</strong>
                        </div>

                        <div class="onx-confirm-item">
                            <span class="label">مكان الحفل</span>
                            <strong>{{ $locationName ?: 'سيتم تأكيده لاحقًا' }}</strong>
                        </div>
                    @endif

                    @if($booking->service_type === 'ads')
                        <div class="onx-confirm-item">
                            <span class="label">الميزانية</span>
                            <strong>{{ $booking->budget ? number_format((float) $booking->budget) . ' DA' : 'غير محددة' }}</strong>
                        </div>

                        <div class="onx-confirm-item">
                            <span class="label">موعد التسليم</span>
                            <strong>{{ $booking->deadline ?: 'غير محدد' }}</strong>
                        </div>
                    @endif
                </div>

                @if(!empty($booking->notes))
                    <div class="onx-divider my-4"></div>

                    <div class="onx-block-title">الملاحظات</div>
                    <div class="onx-panel">
                        <p class="mb-0">{{ $booking->notes }}</p>
                    </div>
                @endif
            </div>

            <div class="d-grid gap-3">
                <div class="onx-card onx-side-card">
                    <div class="d-flex align-items-center justify-content-between gap-2 mb-3 flex-wrap">
                        <h5 class="fw-bold mb-0">ملخص سريع</h5>
                        <span class="onx-mini-badge">ONX</span>
                    </div>

                    <div class="onx-summary">
                        <div class="onx-summary-row">
                            <div class="k">رقم الطلب</div>
                            <div class="v">#{{ $booking->id }}</div>
                        </div>

                        <div class="onx-summary-row">
                            <div class="k">الخدمة</div>
                            <div class="v">{{ $booking->service_type === 'event' ? 'حفلات' : 'إعلانات' }}</div>
                        </div>

                        <div class="onx-summary-row">
                            <div class="k">الحالة</div>
                            <div class="v">
                                @if($booking->status === 'unconfirmed')
                                    <span class="onx-status-badge pending">غير مؤكد</span>
                                @elseif($booking->status === 'confirmed')
                                    <span class="onx-status-badge confirmed">مؤكد</span>
                                @else
                                    <span class="onx-status-badge neutral">{{ $booking->status }}</span>
                                @endif
                            </div>
                        </div>

                        <div class="onx-summary-row">
                            <div class="k">الباقة</div>
                            <div class="v">{{ $packageName ?: '—' }}</div>
                        </div>
                    </div>
                </div>

                <div class="onx-panel">
                    <h5 class="fw-bold mb-3">ماذا يحدث الآن؟</h5>

                    <div class="onx-qa">
                        <div class="onx-qa-item">
                            <div class="q">1) تم تسجيل الطلب</div>
                            <div class="a">تم حفظ طلبك داخل النظام بحالة غير مؤكد.</div>
                        </div>

                        <div class="onx-qa-item">
                            <div class="q">2) تتم المراجعة</div>
                            <div class="a">سيتم التحقق من التفاصيل ومراجعة الطلب من طرف الإدارة.</div>
                        </div>

                        <div class="onx-qa-item">
                            <div class="q">3) التواصل والتأكيد</div>
                            <div class="a">بعد مراجعة الطلب يتم التواصل معك لتأكيد الحجز أو استكمال الخطوات التالية.</div>
                        </div>
                    </div>

                    <div class="mt-4 d-grid gap-2">
    <a href="{{ route('booking.pdf', $booking->id) }}" class="btn btn-onx-book">
        تحميل PDF
    </a>

    <a href="{{ route('booking') }}" class="btn btn-onx-ghost">
        العودة إلى صفحة الحجز
    </a>

    <a href="https://wa.me/213540573518?text={{ urlencode(
        'السلام عليكم، هذا رقم طلبي في ONX: #' . $booking->id
    ) }}" target="_blank" class="btn btn-onx-ghost">
        إرسال رقم الطلب عبر WhatsApp
    </a>
</div>
                </div>
            </div>

        </div>
    </div>
</section>

@endsection