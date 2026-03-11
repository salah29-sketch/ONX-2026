@extends('client.layout')

@section('client_content')
<div class="grid gap-6 md:grid-cols-2">
    <div class="rounded-[24px] border border-white/10 bg-white/5 p-6">
        <h2 class="text-lg font-black text-white">مرحباً، {{ $client->name }}</h2>
        <p class="mt-2 text-sm text-white/60">من هنا يمكنك متابعة حجوزاتك، إرسال رسائل، إضافة رأيك، ورفع صورك.</p>
    </div>
    <div class="rounded-[24px] border border-white/10 bg-white/5 p-6">
        <h2 class="text-lg font-black text-white">روابط سريعة</h2>
        <ul class="mt-3 space-y-2 text-sm">
            <li><a href="{{ route('client.bookings') }}" class="font-bold text-orange-400 hover:underline">حجوزاتي وتتبع الطلب</a></li>
            <li><a href="{{ route('client.messages') }}" class="font-bold text-orange-400 hover:underline">رسائلي للشركة</a> @if($unreadMessages)<span class="text-red-400">({{ $unreadMessages }})</span>@endif</li>
            <li><a href="{{ route('client.review.create') }}" class="font-bold text-orange-400 hover:underline">إضافة رأي (يظهر بعد المصادقة)</a></li>
            <li><a href="{{ route('client.project-photos') }}" class="font-bold text-orange-400 hover:underline">صور مشروعي (مشاهدة، تحميل، اختيار 200 مميزة)</a></li>
        </ul>
    </div>
</div>

@if($bookings->isNotEmpty())
    <div class="mt-8">
        <h2 class="mb-4 text-lg font-black text-white">آخر حجوزاتك</h2>
        <div class="space-y-3">
            @foreach($bookings as $b)
                <a href="{{ route('client.bookings.show', $b) }}" class="block rounded-2xl border border-white/10 bg-white/5 p-4 transition hover:border-orange-500/30">
                    <div class="flex justify-between">
                        <span class="font-bold text-white">#{{ $b->id }}</span>
                        <span class="text-sm text-white/60">{{ $b->created_at->format('Y-m-d') }}</span>
                    </div>
                    <p class="mt-1 text-sm text-white/70">الحالة: {{ $b->status }}</p>
                </a>
            @endforeach
        </div>
        <a href="{{ route('client.bookings') }}" class="mt-4 inline-block text-sm font-bold text-orange-400 hover:underline">عرض الكل</a>
    </div>
@endif
@endsection
