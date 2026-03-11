@extends('client.layout')

@section('client_content')
<div class="mx-auto max-w-xl space-y-6">
    <h2 class="text-xl font-black text-white">الملف الشخصي</h2>

    <form method="POST" action="{{ route('client.profile.update') }}" class="rounded-[24px] border border-white/10 bg-white/5 p-6 space-y-4">
        @csrf
        @method('PUT')
        <div>
            <label class="mb-1 block text-sm font-bold text-white/80">الاسم</label>
            <input type="text" name="name" value="{{ old('name', $client->name) }}" required class="w-full rounded-2xl border border-white/15 bg-white/5 px-4 py-3 text-white">
        </div>
        <div>
            <label class="mb-1 block text-sm font-bold text-white/80">البريد</label>
            <input type="email" name="email" value="{{ old('email', $client->email) }}" class="w-full rounded-2xl border border-white/15 bg-white/5 px-4 py-3 text-white">
        </div>
        <div>
            <label class="mb-1 block text-sm font-bold text-white/80">الهاتف</label>
            <input type="text" name="phone" value="{{ old('phone', $client->phone) }}" required class="w-full rounded-2xl border border-white/15 bg-white/5 px-4 py-3 text-white">
        </div>
        <button type="submit" class="rounded-full bg-orange-500 px-6 py-2 font-black text-black hover:bg-orange-400">حفظ</button>
    </form>

    <div class="rounded-[24px] border border-white/10 bg-white/5 p-6">
        <h3 class="font-black text-white">تغيير كلمة المرور</h3>
        <form method="POST" action="{{ route('client.password.update') }}" class="mt-4 space-y-4">
            @csrf
            @method('PUT')
            <div>
                <label class="mb-1 block text-sm font-bold text-white/80">كلمة المرور الحالية</label>
                <input type="password" name="current_password" required class="w-full rounded-2xl border border-white/15 bg-white/5 px-4 py-3 text-white">
            </div>
            <div>
                <label class="mb-1 block text-sm font-bold text-white/80">كلمة المرور الجديدة</label>
                <input type="password" name="password" required minlength="6" class="w-full rounded-2xl border border-white/15 bg-white/5 px-4 py-3 text-white">
            </div>
            <div>
                <label class="mb-1 block text-sm font-bold text-white/80">تأكيد كلمة المرور الجديدة</label>
                <input type="password" name="password_confirmation" required minlength="6" class="w-full rounded-2xl border border-white/15 bg-white/5 px-4 py-3 text-white">
            </div>
            <button type="submit" class="rounded-full bg-orange-500 px-6 py-2 font-black text-black hover:bg-orange-400">تغيير كلمة المرور</button>
        </form>
    </div>
</div>
@endsection
