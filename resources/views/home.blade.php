@extends('layouts.admin')

@section('content')
<div class="db-page-head">
    <div>
        <h1 class="db-page-title">{{ trans('global.dashboard') }}</h1>
        <div class="db-page-subtitle">نظرة سريعة على الحجوزات والعملاء والمحتوى.</div>
    </div>
</div>

{{-- بطاقات الإحصائيات الرئيسية --}}
<div class="db-dash-row">
    <a href="{{ route('admin.bookings.index') }}" class="db-dash-stat">
        <div class="db-dash-stat-body">
            <div class="db-dash-stat-icon primary">
                <i class="fas fa-calendar-check"></i>
            </div>
            <div>
                <div class="db-dash-stat-num">{{ $bookingsCount ?? 0 }}</div>
                <div class="db-dash-stat-label">الحجوزات</div>
            </div>
        </div>
    </a>
    <a href="{{ route('admin.clients.index') }}" class="db-dash-stat">
        <div class="db-dash-stat-body">
            <div class="db-dash-stat-icon success">
                <i class="fas fa-users"></i>
            </div>
            <div>
                <div class="db-dash-stat-num">{{ $clientsCount ?? 0 }}</div>
                <div class="db-dash-stat-label">العملاء</div>
            </div>
        </div>
    </a>
    <a href="{{ route('admin.portfolio-items.index') }}" class="db-dash-stat">
        <div class="db-dash-stat-body">
            <div class="db-dash-stat-icon warning">
                <i class="fas fa-images"></i>
            </div>
            <div>
                <div class="db-dash-stat-num">{{ $portfolioCount ?? 0 }}</div>
                <div class="db-dash-stat-label">الأعمال (Portfolio)</div>
            </div>
        </div>
    </a>
    <a href="{{ route('admin.bookings.calendar') }}" class="db-dash-stat">
        <div class="db-dash-stat-body">
            <div class="db-dash-stat-icon info">
                <i class="fas fa-calendar-alt"></i>
            </div>
            <div>
                <div class="db-dash-stat-num">→</div>
                <div class="db-dash-stat-label">التقويم</div>
            </div>
        </div>
    </a>
</div>

{{-- تنبيهات سريعة --}}
@if(($unconfirmedBookingsCount ?? 0) > 0 || ($unreadMessagesCount ?? 0) > 0)
<div class="db-dash-alerts">
    @if(($unconfirmedBookingsCount ?? 0) > 0)
        <a href="{{ route('admin.bookings.index') }}?status=unconfirmed" class="db-dash-alert-card">
            <div>
                <span class="num">{{ $unconfirmedBookingsCount }}</span>
                <span class="label d-block mt-1">حجوزات تحتاج تأكيد</span>
            </div>
            <span class="go">عرض ←</span>
        </a>
    @endif
    @if(($unreadMessagesCount ?? 0) > 0)
        <a href="{{ route('admin.client-messages.index') }}" class="db-dash-alert-card">
            <div>
                <span class="num">{{ $unreadMessagesCount }}</span>
                <span class="label d-block mt-1">رسائل غير مقروءة</span>
            </div>
            <span class="go">عرض ←</span>
        </a>
    @endif
</div>
@endif

{{-- آخر الحجوزات --}}
<div class="card db-card db-dash-recent">
    <div class="db-card-header d-flex justify-content-between align-items-center">
        <span><i class="fas fa-list mr-2"></i> آخر الحجوزات</span>
        <a href="{{ route('admin.bookings.index') }}" class="btn btn-sm btn-light" style="border-radius:10px; font-weight:700;">كل الحجوزات</a>
    </div>
    <div class="card-body db-card-body">
        @if(isset($recentBookings) && $recentBookings->isNotEmpty())
            <div class="table-responsive">
                <table class="table table-bordered table-hover db-table mb-0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>العميل / الاسم</th>
                            <th>تاريخ الحفل</th>
                            <th>الحالة</th>
                            <th width="90">إجراء</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($recentBookings as $b)
                            <tr>
                                <td>{{ $b->id }}</td>
                                <td>
                                    @if($b->client)
                                        <strong>{{ $b->client->name }}</strong>
                                    @else
                                        {{ $b->name ?? '—' }}
                                    @endif
                                </td>
                                <td>{{ $b->event_date ? $b->event_date->format('Y-m-d') : '—' }}</td>
                                <td>
                                    @php
                                        $badge = match($b->status) {
                                            'unconfirmed', 'new' => 'db-badge-new',
                                            'confirmed' => 'db-badge-confirmed',
                                            'in_progress' => 'db-badge-progress',
                                            'completed' => 'db-badge-completed',
                                            'cancelled' => 'db-badge-cancelled',
                                            default => 'db-badge',
                                        };
                                    @endphp
                                    <span class="db-badge {{ $badge }}">{{ $b->statusLabel() }}</span>
                                </td>
                                <td>
                                    <a href="{{ route('admin.bookings.show', $b->id) }}" class="db-icon-btn db-view-btn" title="عرض">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="db-empty py-5">
                <i class="fas fa-calendar-times"></i>
                <p class="mb-0 mt-2">لا توجد حجوزات بعد.</p>
                <a href="{{ route('admin.bookings.index') }}" class="db-btn-primary mt-3">الحجوزات</a>
            </div>
        @endif
    </div>
</div>
@endsection
