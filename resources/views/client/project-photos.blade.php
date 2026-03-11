@extends('client.layout')

@section('client_content')
<h2 class="mb-2 text-xl font-black text-white">صور مشروعي</h2>
<p class="mb-6 text-sm text-white/60">اختر من هنا مشروعك لمشاهدة الصور، تحميلها، أو تحديد حتى 200 صورة كمميزة للطباعة (نحن نرى ما تختاره).</p>

@if($selectedCount > 0)
    <p class="mb-4 rounded-2xl border border-orange-500/20 bg-orange-500/10 px-4 py-2 text-sm font-bold text-orange-200">عدد الصور المميزة المختارة: {{ $selectedCount }} / 200</p>
@endif

@forelse($bookings as $b)
    <a href="{{ route('client.project-photos.booking', $b) }}" class="mb-4 flex items-center justify-between rounded-2xl border border-white/10 bg-white/5 p-4 transition hover:border-orange-500/30">
        <div>
            <span class="font-black text-white">#{{ $b->id }}</span>
            <span class="mr-2 text-sm text-white/60">— {{ $b->created_at->format('Y-m-d') }}</span>
        </div>
        <span class="text-sm text-white/70">{{ $b->photos->count() }} صورة</span>
    </a>
@empty
    <div class="rounded-2xl border border-white/10 bg-white/5 p-8 text-center text-white/60">
        لا توجد صور لمشاريعك بعد. سيتم إضافتها من إدارة الموقع.
    </div>
@endforelse
@endsection
