@extends('client.layout')

@section('client_content')
<h2 class="mb-2 text-xl font-black text-gray-800">صور مشروعي</h2>
<p class="mb-6 text-sm text-gray-600">اختر من هنا مشروعك لمشاهدة الصور، تحميلها، أو تحديد حتى 200 صورة كمميزة للطباعة (نحن نرى ما تختاره).</p>

@if($selectedCount > 0)
    <p class="portal-selected-count mb-4 rounded-2xl border border-amber-300 bg-amber-50 px-4 py-2 text-sm font-bold text-amber-800">عدد الصور المميزة المختارة: {{ $selectedCount }} / 200</p>
@endif

@forelse($bookings as $b)
    <a href="{{ route('client.project-photos.booking', $b) }}" class="mb-4 flex items-center justify-between rounded-2xl border border-gray-200 bg-white p-4 shadow-sm transition hover:border-amber-300 hover:shadow-md">
        <div>
            <span class="font-black text-gray-800">#{{ $b->id }}</span>
            <span class="mr-2 text-sm text-gray-500">— {{ $b->created_at->format('Y-m-d') }}</span>
        </div>
        <span class="text-sm text-gray-600">{{ $b->photos->count() }} صورة</span>
    </a>
@empty
    <div class="rounded-2xl border border-gray-200 bg-white p-8 text-center text-gray-500 shadow-sm">
        لا توجد صور لمشاريعك بعد. سيتم إضافتها من إدارة الموقع.
    </div>
@endforelse
@endsection
