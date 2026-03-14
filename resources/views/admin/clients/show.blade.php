@extends('layouts.admin')

@section('content')
<div class="db-page-head">
    <div>
        <h1 class="db-page-title">تفاصيل العميل</h1>
        <div class="db-page-subtitle">عرض بيانات العميل والحجوزات المرتبطة به.</div>
    </div>

    <div class="db-page-head-actions">
        <a href="{{ route('admin.clients.edit', $client) }}" class="db-btn-primary">
            <i class="fas fa-edit"></i>
            تعديل
        </a>
        <a href="{{ route('admin.clients.index') }}" class="db-btn-secondary">
            <i class="fas fa-arrow-right"></i>
            رجوع
        </a>
    </div>
</div>

@if(session('message'))
    <div class="alert alert-success mb-4">{{ session('message') }}</div>
@endif

@if(session('new_password_once'))
    <div class="alert alert-warning mb-4">
        <strong>كلمة المرور الجديدة (احفظها، لن تُعرض مرة أخرى):</strong><br>
        <code class="d-inline-block mt-2 p-2 bg-light rounded">{{ session('new_password_once') }}</code><br>
        <span class="text-muted small">اسم المستخدم للدخول: {{ session('client_login_identifier') }}</span>
    </div>
@endif

<div class="card db-card mb-4">
    <div class="db-card-header">بيانات العميل</div>

    <div class="card-body db-card-body">
        <div class="db-detail-grid">
            <div class="db-detail-item">
                <div class="db-detail-label">الاسم</div>
                <div class="db-detail-value">{{ $client->name ?? '—' }}</div>
            </div>

            <div class="db-detail-item">
                <div class="db-detail-label">البريد الإلكتروني</div>
                <div class="db-detail-value">{{ $client->email ?? '—' }}</div>
            </div>

            <div class="db-detail-item">
                <div class="db-detail-label">الهاتف</div>
                <div class="db-detail-value">{{ $client->phone ?? '—' }}</div>
            </div>

            <div class="db-detail-item">
                <div class="db-detail-label">عدد الحجوزات</div>
                <div class="db-detail-value">{{ $client->bookings->count() }}</div>
            </div>

            <div class="db-detail-item">
                <div class="db-detail-label">تاريخ الإضافة</div>
                <div class="db-detail-value">{{ $client->created_at?->format('Y-m-d H:i') ?? '—' }}</div>
            </div>

            <div class="db-detail-item">
                <div class="db-detail-label">آخر تحديث</div>
                <div class="db-detail-value">{{ $client->updated_at?->format('Y-m-d H:i') ?? '—' }}</div>
            </div>
        </div>
    </div>
</div>

<div class="card db-card mb-4 border-primary">
    <div class="db-card-header bg-light">الدخول وكلمة المرور</div>
    <div class="card-body db-card-body">
        <div class="row mb-3">
            <div class="col-md-4">
                <strong>كلمة السر:</strong>
                @if($client->hasPassword())
                    <span class="badge badge-success">معرّفة</span>
                @else
                    <span class="badge badge-secondary">غير معرّفة</span>
                @endif
            </div>
            <div class="col-md-4">
                <strong>إمكانية الدخول:</strong>
                @if($client->login_disabled)
                    <span class="badge badge-danger">معطّل</span>
                @else
                    <span class="badge badge-success">مفعّل</span>
                @endif
            </div>
        </div>
        <div class="d-flex flex-wrap gap-2">
            <form action="{{ route('admin.clients.toggle-login', $client) }}" method="POST" class="d-inline">
                @csrf
                @if($client->login_disabled)
                    <button type="submit" class="btn btn-success btn-sm">تفعيل الدخول</button>
                @else
                    <button type="submit" class="btn btn-warning btn-sm" onclick="return confirm('تعطيل دخول هذا العميل؟');">تعطيل الدخول</button>
                @endif
            </form>
            <form action="{{ route('admin.clients.reset-password', $client) }}" method="POST" class="d-inline" onsubmit="return confirm('سيتم إنشاء كلمة مرور جديدة وعرضها مرة واحدة. متابعة؟');">
                @csrf
                <button type="submit" class="btn btn-info btn-sm">إعادة تعيين كلمة المرور</button>
            </form>
        </div>
        <p class="text-muted small mt-2 mb-0">كلمات السر مخزّنة مشفّرة ولا يمكن عرضها. استخدم «إعادة تعيين كلمة المرور» لتعيين كلمة جديدة وعرضها مرة واحدة.</p>
    </div>
</div>

<div class="card db-card">
    <div class="db-card-header">الحجوزات المرتبطة بهذا العميل</div>

    <div class="card-body db-card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-striped db-table text-center">
                <thead>
                    <tr>
                        <th>#</th>  
                        <th>الخدمة</th>
                        <th>الباقة</th>
                        <th>التاريخ</th>
                        <th>الحالة</th>
                        <th>تاريخ الإنشاء</th>
                        <th>إجراءات</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($client->bookings as $booking)
                        <tr>
                            <td>{{ $booking->id }}</td>

                            <td>
                                {{ $booking->service_type === 'event' ? 'حفلات' : 'إعلانات' }}
                            </td>

                            <td>
                                @if($booking->service_type === 'event' && $booking->eventPackage)
                                    {{ $booking->eventPackage->name }}
                                @elseif($booking->service_type === 'ads' && $booking->adPackage)
                                    {{ $booking->adPackage->name }}
                                @else
                                    —
                                @endif
                            </td>

                            <td>{{ $booking->event_date ?: '—' }}</td>

                            <td>
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
                            </td>

                            <td>{{ $booking->created_at?->format('Y-m-d H:i') }}</td>

                            <td>
                                <div class="db-actions">
                                    <a href="{{ route('admin.bookings.show', $booking->id) }}" class="db-icon-btn db-view-btn" title="عرض الحجز">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7">
                                <div class="db-empty">
                                    <i class="fas fa-calendar-times"></i>
                                    لا توجد حجوزات مرتبطة بهذا العميل.
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection