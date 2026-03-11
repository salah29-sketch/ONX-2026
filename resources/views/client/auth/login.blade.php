@extends('layouts.front_tailwind')

@section('title', 'دخول العملاء - ONX')

@section('content')
<section class="mx-auto max-w-md px-6 py-16">
    <div class="rounded-[24px] border border-white/10 bg-white/5 p-6 backdrop-blur-xl">
        <h1 class="text-xl font-black text-white">دخول منطقة العملاء</h1>
        <p class="mt-2 text-sm text-white/60">أدخل البريد الإلكتروني أو رقم الهاتف وكلمة المرور.</p>

        <form method="POST" action="{{ route('client.login.post') }}" class="mt-6 space-y-4">
            @csrf
            <div>
                <label class="mb-1 block text-sm font-bold text-white/80">البريد أو الهاتف</label>
                <input type="text" name="login" value="{{ old('login') }}" required
                       class="w-full rounded-2xl border border-white/15 bg-white/5 px-4 py-3 text-white placeholder-white/40 focus:border-orange-500/50">
            </div>
            <div>
                <label class="mb-1 block text-sm font-bold text-white/80">كلمة المرور</label>
                <input type="password" name="password" required
                       class="w-full rounded-2xl border border-white/15 bg-white/5 px-4 py-3 text-white placeholder-white/40 focus:border-orange-500/50">
            </div>
            <label class="flex items-center gap-2 text-sm text-white/70">
                <input type="checkbox" name="remember"> تذكرني
            </label>
            <button type="submit" class="w-full rounded-full bg-orange-500 py-3 font-black text-black hover:bg-orange-400">دخول</button>
        </form>

        <p class="mt-6 text-center text-xs text-white/50">
            بعد الحجز يمكنك ضبط كلمة المرور من صفحة تأكيد الحجز أو من الرابط الذي نرسله لك.
        </p>
    </div>
</section>
@endsection
