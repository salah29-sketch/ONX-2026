@extends('layouts.admin')

@section('content')
<div class="db-page-head">
    <div>
        <h1 class="db-page-title">الحجوزات</h1>
        <div class="db-page-subtitle">مراجعة كل طلبات الحجز وتتبع حالتها.</div>
    </div>

    <a href="{{ route('admin.bookings.calendar') }}" class="db-btn-primary">
        <i class="fas fa-calendar-alt"></i>
        تقويم المراقبة
    </a>
</div>



<div class="db-filter-bar">
    <form method="GET">
        <div class="row">
            <div class="col-md-3 mb-2">
                <label class="db-label">نوع الخدمة</label>
                <select name="service_type" class="form-control db-input">
                    <option value="">الكل</option>
                    <option value="event" {{ request('service_type') === 'event' ? 'selected' : '' }}>Mariage</option>
                    <option value="ads" {{ request('service_type') === 'ads' ? 'selected' : '' }}>Pub</option>
                </select>
            </div>

            <div class="col-md-3 mb-2">
                <label class="db-label">الحالة</label>
                <select name="status" class="form-control db-input">
                    <option value="">الكل</option>
                    <option value="unconfirmed" {{ request('status') === 'unconfirmed' ? 'selected' : '' }}>غير مؤكد</option>
                    <option value="confirmed" {{ request('status') === 'confirmed' ? 'selected' : '' }}>مؤكد</option>
                    <option value="in_progress" {{ request('status') === 'in_progress' ? 'selected' : '' }}>قيد التنفيذ</option>
                    <option value="completed" {{ request('status') === 'completed' ? 'selected' : '' }}>مكتمل</option>
                    <option value="cancelled" {{ request('status') === 'cancelled' ? 'selected' : '' }}>ملغى</option>
                </select>
            </div>

            <div class="col-md-2 mb-2">
                <label class="db-label">من</label>
                <input type="date" name="date_from" value="{{ request('date_from') }}" class="form-control db-input">
            </div>

            <div class="col-md-2 mb-2">
                <label class="db-label">إلى</label>
                <input type="date" name="date_to" value="{{ request('date_to') }}" class="form-control db-input">
            </div>

            <div class="col-md-2 mb-2 d-flex align-items-end">
                <button class="db-btn-primary w-100 justify-content-center">
                    <i class="fas fa-filter"></i>
                    فلترة
                </button>
            </div>
        </div>
    </form>
</div>

<div class="card db-card">
    <div class="db-card-header">قائمة الحجوزات</div>

    <div class="card-body db-card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-striped db-table text-center">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>الاسم</th>
                        <th>الهاتف</th>
                        <th>الخدمة</th>
                        <th>التاريخ</th>
                        <th>المكان</th>
                        <th>الحالة</th>
                        <th>تاريخ الإنشاء</th>
                        <th>إجراءات</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($bookings as $booking)
                        <tr>
                            <td>{{ $booking->id }}</td>
                            <td>{{ $booking->name }}</td>
                            <td>{{ $booking->phone }}</td>
                            <td>{{ $booking->service_type === 'event' ? 'mariage' : 'PUB' }}</td>
                            <td> @if($booking->event_date)
                                     {{ \Carbon\Carbon::parse($booking->event_date)->format('Y/m/d') }}
                                @else
                                      —
                                @endif
                            </td>
                            <td>{{ $booking->custom_event_location ?: ($booking->eventLocation->name ?? '—') }}</td>

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
                                    <a href="{{ route('admin.bookings.show', $booking->id) }}" class="db-icon-btn db-view-btn" title="عرض">
                                        <i class="fas fa-eye"></i>
                                    </a>

                                    <form action="{{ route('admin.bookings.destroy', $booking->id) }}" method="POST" onsubmit="return confirm('هل أنت متأكد من الحذف؟');">
                                        @csrf
                                        @method('DELETE')
                                        <button class="db-icon-btn db-delete-btn" title="حذف">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9">
                                <div class="db-empty">
                                    <i class="fas fa-calendar-times"></i>
                                    لا توجد حجوزات حاليًا.
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-3">
            {{ $bookings->links() }}
        </div>
    </div>
</div>
@endsection