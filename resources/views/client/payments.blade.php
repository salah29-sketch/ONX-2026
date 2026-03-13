@extends('client.layout')

@section('title', 'مدفوعاتي - بوابة العملاء')

@push('styles')
<style>
.panel-pay { background: #fff; border: 1px solid #e5e7eb; border-radius: 20px; overflow: hidden; margin-bottom: 20px; box-shadow: 0 1px 3px rgba(0,0,0,.04); }
.panel-pay-head { padding: 18px 20px; border-bottom: 1px solid #e5e7eb; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 12px; }
.panel-pay-body { padding: 20px; }
.pay-bar-wrap { background: #f3f4f6; border-radius: 999px; height: 10px; overflow: hidden; margin: 12px 0 8px; }
.pay-bar { height: 100%; border-radius: 999px; transition: width .6s ease; }
.pay-bar.green { background: linear-gradient(90deg, #22c55e, #4ade80); }
.pay-bar.amber { background: linear-gradient(90deg, #f59e0b, #fbbf24); }
.pay-bar.red { background: linear-gradient(90deg, #dc2626, #ef4444); }
.pay-row { display: flex; align-items: center; justify-content: space-between; gap: 10px; padding: 12px 14px; background: #f9fafb; border: 1px solid #e5e7eb; border-radius: 12px; margin-bottom: 8px; }
.pay-row-meta { font-size: 11px; color: #6b7280; }
.pay-row-amount { font-size: 15px; font-weight: 900; color: #15803d; }
.empty-state-portal { text-align: center; padding: 48px 24px; color: #6b7280; background: #fff; border: 1px solid #e5e7eb; border-radius: 20px; box-shadow: 0 1px 3px rgba(0,0,0,.04); }
.empty-state-portal .icon { font-size: 48px; margin-bottom: 16px; opacity: .6; }
</style>
@endpush

@section('client_content')
<div class="mb-6">
    <h1 class="text-2xl font-black text-gray-800">💰 المدفوعات</h1>
    <p class="mt-1 text-sm text-gray-500">ملخص المبالغ والدفعات لكل حجز</p>
</div>

@php $clientOrderMap = $clientOrderMap ?? []; @endphp
@forelse($bookings as $booking)
    @php
        $meta = app(\App\Services\BookingService::class)->getBookingMeta($booking);
        $pct = $booking->paymentPercent();
        $barClass = $booking->isFullyPaid() ? 'green' : ($booking->remainingAmount() > 0 ? 'red' : 'amber');
    @endphp
    <div class="panel-pay">
        <div class="panel-pay-head">
            <div>
                <a href="{{ route('client.bookings.show', $booking) }}" class="font-black text-gray-800 hover:text-amber-600">
                    الطلب {{ $clientOrderMap[$booking->id] ?? $booking->id }}
                </a>
                <p class="text-sm text-gray-500 mt-0.5">
                    {{ $booking->service_type === 'event' ? 'تصوير فعاليات' : 'إعلانات' }}
                    @if($booking->event_date)
                        · {{ $booking->event_date->format('d/m/Y') }}
                    @endif
                </p>
            </div>
            <a href="{{ route('client.bookings.invoice', $booking->id) }}" class="rounded-xl border border-amber-300 bg-amber-50 px-4 py-2 text-sm font-bold text-amber-700 hover:bg-amber-100" target="_blank">
                تحميل الفاتورة PDF
            </a>
        </div>
        <div class="panel-pay-body">
            @if($booking->total_price)
                <div class="flex flex-wrap gap-4 text-sm">
                    <span class="text-gray-600">الإجمالي: <strong class="text-gray-800">{{ number_format($booking->total_price, 0) }} DA</strong></span>
                    <span class="text-green-600">مدفوع: <strong>{{ number_format($booking->paidAmount(), 0) }} DA</strong></span>
                    <span class="{{ $booking->remainingAmount() > 0 ? 'text-red-600' : 'text-green-600' }}">
                        متبقي: <strong>{{ number_format($booking->remainingAmount(), 0) }} DA</strong>
                    </span>
                </div>
                <div class="pay-bar-wrap">
                    <div class="pay-bar {{ $barClass }}" style="width: {{ $pct }}%;"></div>
                </div>
                <p class="text-xs text-gray-500">{{ $pct }}% مسدّد @if($booking->isFullyPaid()) · ✅ مكتمل @endif</p>

                @if($booking->payments->isNotEmpty())
                    <p class="mt-4 mb-2 text-xs font-bold uppercase tracking-wider text-gray-500">سجل الدفعات</p>
                    @foreach($booking->payments as $pay)
                        <div class="pay-row">
                            <div>
                                <span class="font-bold text-gray-800">{{ $pay->typeLabel() }}</span>
                                <p class="pay-row-meta">{{ $pay->methodLabel() }} · {{ $pay->paid_at->format('d/m/Y') }}</p>
                            </div>
                            <span class="pay-row-amount">+ {{ number_format($pay->amount, 0) }} DA</span>
                        </div>
                    @endforeach
                @endif
            @else
                <p class="text-sm text-gray-500">سيتم تحديد السعر من قِبل الفريق قريباً.</p>
            @endif
        </div>
    </div>
@empty
    <div class="empty-state-portal rounded-2xl border border-white/10 bg-white/5">
        <div class="icon">💰</div>
        <p class="font-bold text-gray-700">لا توجد حجوزات بعد</p>
        <p class="mt-2 text-sm text-gray-500">عند وجود حجز، ستظهر هنا ملخصات المدفوعات والدفعات.</p>
    </div>
@endforelse
@endsection
