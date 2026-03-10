@extends('layouts.admin')

@section('content')
<div class="db-page-head">
    <div>
        <h1 class="db-page-title">تفاصيل الحجز #{{ $booking->id }}</h1>
        <div class="db-page-subtitle">عرض بيانات الحجز وتحديث حالته.</div>
    </div>

    <a href="{{ route('admin.bookings.index') }}" class="db-btn-secondary">
        <i class="fas fa-arrow-right"></i>
        رجوع
    </a>
</div>



<div class="card db-card mb-4">
    <div class="db-card-header">بيانات الحجز</div>

    <div class="card-body db-card-body">
        <div class="db-detail-grid">

            <div class="db-detail-item">
                <div class="db-detail-label">الاسم</div>
                <div class="db-detail-value">{{ $booking->name ?? '—' }}</div>
            </div>

            <div class="db-detail-item">
                <div class="db-detail-label">العميل</div>
                <div class="db-detail-value">
                    @if($booking->client)
                        <a href="{{ route('admin.clients.show', $booking->client->id) }}">
                            {{ $booking->client->name }}
                        </a>
                    @else
                        —
                    @endif
                </div>
            </div>

            <div class="db-detail-item">
                <div class="db-detail-label">الهاتف</div>
                <div class="db-detail-value">{{ $booking->phone ?? '—' }}</div>
            </div>

            <div class="db-detail-item">
                <div class="db-detail-label">البريد الإلكتروني</div>
                <div class="db-detail-value">{{ $booking->email ?? '—' }}</div>
            </div>

            <div class="db-detail-item">
                <div class="db-detail-label">نوع الخدمة</div>
                <div class="db-detail-value">
                    {{ $booking->service_type === 'event' ? 'حفلات' : 'إعلانات' }}
                </div>
            </div>

            <div class="db-detail-item">
                <div class="db-detail-label">اسم الباقة</div>
                <div class="db-detail-value">
                    @if($booking->service_type === 'event')
                        {{ $booking->eventPackage->name ?? '—' }}
                    @else
                        {{ $booking->adPackage->name ?? '—' }}
                    @endif
                </div>
            </div>

            <div class="db-detail-item">
                <div class="db-detail-label">تاريخ الحفل</div>
                <div class="db-detail-value">{{ $booking->event_date ?? '—' }}</div>
            </div>

            <div class="db-detail-item">
                <div class="db-detail-label">مكان الحفل</div>
                <div class="db-detail-value">
                    {{ $booking->custom_event_location ?: ($booking->eventLocation->name ?? '—') }}
                </div>
            </div>

            <div class="db-detail-item">
                <div class="db-detail-label">اسم النشاط التجاري</div>
                <div class="db-detail-value">{{ $booking->business_name ?? '—' }}</div>
            </div>

            <div class="db-detail-item">
                <div class="db-detail-label">الميزانية</div>
                <div class="db-detail-value">{{ $booking->budget ?? '—' }}</div>
            </div>

            <div class="db-detail-item">
                <div class="db-detail-label">موعد التسليم</div>
                <div class="db-detail-value">{{ $booking->deadline ?? '—' }}</div>
            </div>

            <div class="db-detail-item">
                <div class="db-detail-label">الحالة الحالية</div>
                <div class="db-detail-value">
                    @php
                        $statusClass = match($booking->status) {
                            'unconfirmed' => 'db-badge-new',
                            'confirmed' => 'db-badge-confirmed',
                            'in_progress' => 'db-badge-progress',
                            'completed' => 'db-badge-completed',
                            'cancelled' => 'db-badge-cancelled',
                            default => 'db-badge-new'
                        };

                        $statusLabel = match($booking->status) {
                            'unconfirmed' => 'غير مؤكد',
                            'confirmed' => 'مؤكد',
                            'in_progress' => 'قيد التنفيذ',
                            'completed' => 'مكتمل',
                            'cancelled' => 'ملغى',
                            default => $booking->status
                        };
                    @endphp

                    <span class="db-badge {{ $statusClass }}">
                        {{ $statusLabel }}
                    </span>
                </div>
            </div>

            <div class="db-detail-item" style="grid-column:1/-1;">
                <div class="db-detail-label">الملاحظات</div>
                <div class="db-detail-value">{{ $booking->notes ?? '—' }}</div>
            </div>

            <div class="db-detail-item">
                <div class="db-detail-label">تاريخ الإنشاء</div>
                <div class="db-detail-value">{{ $booking->created_at?->format('Y-m-d H:i') ?? '—' }}</div>
            </div>

            <div class="db-detail-item">
                <div class="db-detail-label">آخر تحديث</div>
                <div class="db-detail-value">{{ $booking->updated_at?->format('Y-m-d H:i') ?? '—' }}</div>
            </div>

        </div>
    </div>
</div>
<div class="card db-card mb-4">
    <div class="db-card-header">تعديل بيانات الحجز</div>

    <div class="card-body db-card-body">
        <form action="{{ route('admin.bookings.updateDetails', $booking->id) }}" method="POST">
            @csrf
            @method('PATCH') 
            <div class="row">
                @if($booking->service_type === 'event')
                    <div class="col-md-4 mb-3">
                        <label class="db-label">تاريخ الحفل</label>
                        <input
                            type="date"
                            name="event_date"
                            value="{{ $booking->event_date }}"
                            class="form-control db-input"
                        >
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="db-label">مكان الحفل</label>
                        <select name="event_location_id" class="form-control db-input">
                            <option value="">— اختر —</option>
                            @foreach($eventLocations as $id => $name)
                                <option value="{{ $id }}" {{ (string)$booking->event_location_id === (string)$id ? 'selected' : '' }}>
                                    {{ $name }}
                                </option>
                            @endforeach
                            <option value="other" {{ $booking->custom_event_location ? 'selected' : '' }}>مكان آخر</option>
                        </select>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="db-label">مكان مخصص</label>
                        <input
                            type="text"
                            name="custom_event_location"
                            value="{{ $booking->custom_event_location }}"
                            class="form-control db-input"
                        >
                    </div>
                @endif

                <div class="col-12 mb-3">
                    <label class="db-label">ملاحظات</label>
                    <textarea name="notes" class="form-control db-input" rows="4">{{ $booking->notes }}</textarea>
                </div>
            </div>

            <div class="db-form-actions">
                <button class="db-btn-success">
                    <i class="fas fa-save"></i>
                    حفظ البيانات
                </button>
            </div>
        </form>
    </div>
</div>
<div class="card db-card">
    <div class="db-card-header">تحديث حالة الحجز</div>

    <div class="card-body db-card-body">
        <form action="{{ route('admin.bookings.updateStatus', $booking->id) }}" method="POST">
            @csrf
            @method('PATCH')
            <div class="row">
                <div class="col-md-4 mb-3">
                    <label class="db-label">الحالة</label>
                    <select name="status" class="form-control db-input">
                        <option value="unconfirmed" {{ $booking->status === 'unconfirmed' ? 'selected' : '' }}>غير مؤكد</option>
                        <option value="confirmed" {{ $booking->status === 'confirmed' ? 'selected' : '' }}>مؤكد</option>
                        <option value="in_progress" {{ $booking->status === 'in_progress' ? 'selected' : '' }}>قيد التنفيذ</option>
                        <option value="completed" {{ $booking->status === 'completed' ? 'selected' : '' }}>مكتمل</option>
                        <option value="cancelled" {{ $booking->status === 'cancelled' ? 'selected' : '' }}>ملغى</option>
                    </select>
                </div>
            </div>

            <div class="db-form-actions">
                <button class="db-btn-success">
                    <i class="fas fa-save"></i>
                    حفظ الحالة
                </button>
            </div>
        </form>
    </div>
</div>
@endsection