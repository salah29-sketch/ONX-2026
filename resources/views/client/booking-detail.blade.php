@extends('client.layout')

@section('client_content')
<div class="mb-6">
    <a href="{{ route('client.bookings') }}" class="text-sm font-bold text-orange-400 hover:underline">← حجوزاتي</a>
</div>
<h2 class="mb-6 text-xl font-black text-white">تفاصيل الحجز #{{ $booking->id }}</h2>

<div class="space-y-4 rounded-2xl border border-white/10 bg-white/5 p-6">
    <p><span class="text-white/60">الحالة:</span> <strong class="text-white">{{ $booking->status }}</strong></p>
    @if($booking->event_date)
        <p><span class="text-white/60">التاريخ:</span> {{ $booking->event_date->format('Y-m-d') }}</p>
    @endif
    @if(!empty($meta['locationName']))
        <p><span class="text-white/60">المكان:</span> {{ $meta['locationName'] }}</p>
    @endif
    @if($booking->notes)
        <p><span class="text-white/60">ملاحظات:</span> {{ $booking->notes }}</p>
    @endif
    @if($booking->photos->isNotEmpty())
        <p><a href="{{ route('client.project-photos.booking', $booking) }}" class="font-bold text-orange-400 hover:underline">🖼️ مشاهدة صور المشروع واختيار المميزة للطباعة ({{ $booking->photos->count() }} صورة)</a></p>
    @endif
</div>

@if(!empty($meta['package']))
@php $pkg = $meta['package']; @endphp
<div class="mt-6 rounded-2xl border border-orange-500/20 bg-orange-500/5 p-6">
    <h3 class="mb-4 text-lg font-black text-white">تفاصيل الباقة</h3>
    <div class="space-y-3">
        <div>
            <span class="text-white/60 text-sm">اسم الباقة</span>
            <p class="font-bold text-white text-lg">{{ $pkg->name }}</p>
        </div>
        @if($pkg->subtitle)
            <div>
                <span class="text-white/60 text-sm">وصف مختصر</span>
                <p class="text-white/90">{{ $pkg->subtitle }}</p>
            </div>
        @endif
        @if($pkg->description)
            <div>
                <span class="text-white/60 text-sm">التفاصيل</span>
                <div class="mt-1 text-white/85 leading-relaxed">{{ $pkg->description }}</div>
            </div>
        @endif
        <div class="flex flex-wrap items-baseline gap-3 pt-2">
            @if(isset($pkg->old_price) && $pkg->old_price > 0)
                <span class="text-white/45 line-through text-sm">{{ number_format((float) $pkg->old_price) }} دج</span>
            @endif
            <span class="text-xl font-black text-orange-400">
                @if(isset($pkg->price) && $pkg->price !== null && $pkg->price !== '')
                    {{ number_format((float) $pkg->price) }} دج
                @else
                    {{ $pkg->price_note ?? '—' }}
                @endif
            </span>
        </div>
        @if(!empty($pkg->features) && is_array($pkg->features))
            <div class="pt-3 border-t border-white/10">
                <span class="text-white/60 text-sm">المميزات</span>
                <ul class="mt-2 space-y-1.5">
                    @foreach($pkg->features as $f)
                        <li class="flex items-center gap-2 text-white/85">
                            <span class="text-orange-400">✓</span>
                            {{ is_string($f) ? $f : ($f['text'] ?? $f['title'] ?? json_encode($f)) }}
                        </li>
                    @endforeach
                </ul>
            </div>
        @endif
    </div>
</div>
@else
<div class="mt-6 rounded-2xl border border-white/10 bg-white/5 p-6">
    <h3 class="mb-2 text-lg font-black text-white">الباقة</h3>
    <p class="text-white/70">{{ $meta['packageName'] ?? '—' }}</p>
    @if(isset($meta['packagePrice']) && $meta['packagePrice'] !== null && $meta['packagePrice'] !== '')
        <p class="mt-2 text-lg font-bold text-orange-400">{{ number_format((float) $meta['packagePrice']) }} دج</p>
    @elseif(!empty($meta['packageName']))
        <p class="mt-2 text-white/60 text-sm">السعر حسب الاتفاق أو الباقة.</p>
    @endif
</div>
@endif

@if($booking->final_video_path)
    <div class="mt-8">
        <h3 class="mb-4 font-black text-white">الفيديو النهائي</h3>
        <div class="rounded-2xl border border-white/10 bg-white/5 p-4">
            @if(str_contains($booking->final_video_path, 'youtube.com') || str_contains($booking->final_video_path, 'youtu.be'))
                <iframe class="aspect-video w-full rounded-xl" src="{{ $booking->final_video_path }}" allowfullscreen></iframe>
            @else
                <video class="w-full rounded-xl" controls src="{{ asset($booking->final_video_path) }}"></video>
            @endif
        </div>
    </div>
@else
    <p class="mt-6 text-sm text-white/50">الفيديو النهائي سيظهر هنا عندما يتم رفعه من إدارة الموقع.</p>
@endif
@endsection
