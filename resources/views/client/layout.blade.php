@extends('layouts.front_tailwind')

@section('title', 'منطقة العملاء - ONX')

@section('content')
<div class="mx-auto max-w-7xl px-4 py-6 lg:px-6">
    <div class="flex flex-col gap-6 lg:flex-row">
        {{-- قائمة جانبية مثل لوحة تحكم خاصة بالعميل --}}
        <aside class="w-full shrink-0 lg:w-56">
            <div class="rounded-2xl border border-white/10 bg-white/5 p-4 backdrop-blur">
                <div class="mb-4 border-b border-white/10 pb-3">
                    <h2 class="text-sm font-black text-orange-400">منطقة العملاء</h2>
                    <p class="mt-1 text-xs text-white/50">لوحتك الخاصة</p>
                </div>
                <nav class="space-y-1">
                    <a href="{{ route('client.dashboard') }}" class="flex items-center gap-2 rounded-xl px-3 py-2.5 text-sm font-bold transition {{ request()->routeIs('client.dashboard') ? 'bg-orange-500/20 text-orange-300' : 'text-white/70 hover:bg-white/5 hover:text-white' }}">
                        <span>📋</span> لوحة التحكم
                    </a>
                    <a href="{{ route('client.bookings') }}" class="flex items-center gap-2 rounded-xl px-3 py-2.5 text-sm font-bold transition {{ request()->routeIs('client.bookings*') && !request()->routeIs('client.photos*') && !request()->routeIs('client.review*') ? 'bg-orange-500/20 text-orange-300' : 'text-white/70 hover:bg-white/5 hover:text-white' }}">
                        <span>📅</span> حجوزاتي
                    </a>
                    <a href="{{ route('client.project-photos') }}" class="flex items-center gap-2 rounded-xl px-3 py-2.5 text-sm font-bold transition {{ request()->routeIs('client.project-photos*') ? 'bg-orange-500/20 text-orange-300' : 'text-white/70 hover:bg-white/5 hover:text-white' }}">
                        <span>🖼️</span> صور مشروعي
                    </a>
                    <a href="{{ route('client.messages') }}" class="flex items-center gap-2 rounded-xl px-3 py-2.5 text-sm font-bold transition {{ request()->routeIs('client.messages*') ? 'bg-orange-500/20 text-orange-300' : 'text-white/70 hover:bg-white/5 hover:text-white' }}">
                        <span>✉️</span> رسائلي
                    </a>
                    <a href="{{ route('client.review.create') }}" class="flex items-center gap-2 rounded-xl px-3 py-2.5 text-sm font-bold transition {{ request()->routeIs('client.review*') ? 'bg-orange-500/20 text-orange-300' : 'text-white/70 hover:bg-white/5 hover:text-white' }}">
                        <span>⭐</span> إضافة رأي
                    </a>
                    <a href="{{ route('client.profile') }}" class="flex items-center gap-2 rounded-xl px-3 py-2.5 text-sm font-bold transition {{ request()->routeIs('client.profile*') ? 'bg-orange-500/20 text-orange-300' : 'text-white/70 hover:bg-white/5 hover:text-white' }}">
                        <span>👤</span> الملف الشخصي
                    </a>
                </nav>
                <form action="{{ route('client.logout') }}" method="POST" class="mt-4 pt-4 border-t border-white/10">
                    @csrf
                    <button type="submit" class="w-full rounded-xl border border-red-500/30 bg-red-500/10 px-3 py-2.5 text-sm font-bold text-red-300 hover:bg-red-500/20">تسجيل الخروج</button>
                </form>
            </div>
        </aside>

        <main class="min-w-0 flex-1">
            @if(session('success'))
                <div class="mb-6 rounded-2xl border border-orange-500/30 bg-orange-500/10 p-4 text-sm font-bold text-orange-200">{{ session('success') }}</div>
            @endif
            @if($errors->any())
                <div class="mb-6 rounded-2xl border border-red-500/30 bg-red-500/10 p-4 text-sm text-red-200">
                    <ul class="list-disc list-inside">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
                </div>
            @endif
            @yield('client_content')
        </main>
    </div>
</div>
@endsection
