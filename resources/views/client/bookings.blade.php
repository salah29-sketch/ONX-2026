@extends('client.layout')

@section('title', 'حجوزاتي - بوابة العملاء')

@push('styles')
<style>
.booking-card { border-radius: 20px; border: 1px solid #e5e7eb; background: #fff; padding: 20px; margin-bottom: 16px; text-decoration: none; color: inherit; display: block; transition: border-color .2s, box-shadow .2s; box-shadow: 0 1px 3px rgba(0,0,0,.04); }
.booking-card:hover { border-color: #fcd34d; box-shadow: 0 4px 12px rgba(0,0,0,.06); }
.booking-card-header { display: flex; justify-content: space-between; align-items: flex-start; gap: 12px; flex-wrap: wrap; }
.booking-card-id { font-size: 1.1rem; font-weight: 900; color: #1f2937; }
.booking-card-meta { font-size: 13px; color: #6b7280; margin-top: 4px; }
.booking-card-status { padding: 6px 12px; border-radius: 999px; font-size: 12px; font-weight: 800; }
.booking-card-status.completed { background: #dcfce7; color: #166534; }
.booking-card-status.confirmed, .booking-card-status.in_progress { background: #fef3c7; color: #b45309; }
.booking-card-status.new, .booking-card-status.unconfirmed { background: #f3f4f6; color: #4b5563; }
.booking-card-status.cancelled { background: #fee2e2; color: #b91c1c; }
.booking-timeline { display: flex; gap: 6px; margin-top: 14px; }
.booking-timeline-dot { width: 10px; height: 10px; border-radius: 50%; background: #e5e7eb; transition: background .3s; }
.booking-timeline-dot.done { background: #f59e0b; }
.booking-timeline-dot.active { background: #f59e0b; box-shadow: 0 0 8px rgba(245,158,11,.35); }
.empty-bookings { text-align: center; padding: 48px 24px; border-radius: 20px; border: 1px solid #e5e7eb; background: #fff; color: #6b7280; box-shadow: 0 1px 3px rgba(0,0,0,.04); }
.empty-bookings .icon { font-size: 48px; margin-bottom: 16px; opacity: .6; }
</style>
@endpush

@section('client_content')
<div class="mb-6">
    <h1 class="text-2xl font-black text-gray-800">📋 حجوزاتي</h1>
    <p class="mt-1 text-sm text-gray-500">كل حجوزاتك مع تتبع المراحل</p>
</div>

@php $clientOrderMap = $clientOrderMap ?? []; @endphp
@forelse($bookings as $b)
    @php
        $step = $b->statusStep();
        $serviceLabel = $b->service_type === 'event' ? 'تصوير فعاليات' : 'إعلانات';
        $serviceDate = $b->event_date ?? $b->deadline ?? $b->created_at;
    @endphp
    <a href="{{ route('client.bookings.show', $b) }}" class="booking-card">
        <div class="booking-card-header">
            <div>
                <span class="booking-card-id">الطلب {{ $clientOrderMap[$b->id] ?? $b->id }}</span>
                <p class="booking-card-meta">
                    {{ $serviceLabel }}
                    · تاريخ الخدمة: {{ $serviceDate->format('d/m/Y') }}
                </p>
            </div>
            <span class="booking-card-status {{ $b->status }}">{{ $b->statusLabel() }}</span>
        </div>
        <div class="booking-timeline" title="استلام الطلب → تأكيد الحجز → قيد التنفيذ → مكتمل">
            @foreach([1,2,3,4] as $s)
                <span class="booking-timeline-dot {{ $step >= $s ? ($step > $s ? 'done' : 'active') : '' }}"></span>
            @endforeach
        </div>
        <p class="text-xs text-gray-500 mt-2">اضغط لعرض التفاصيل والمدفوعات والملفات ←</p>
    </a>
@empty
    <div class="empty-bookings">
        <div class="icon">📋</div>
        <p class="font-bold text-gray-700">لا توجد حجوزات</p>
        <p class="mt-2 text-sm text-gray-500">عند إتمام حجز من صفحة الحجز في الموقع، ستظهر هنا.</p>
    </div>
@endforelse

<div class="mt-6">{{ $bookings->links() }}</div>
@endsection
