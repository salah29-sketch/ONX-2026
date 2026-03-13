@extends('client.layout')

@section('client_content')
<div class="mx-auto max-w-xl space-y-6">
    <h2 class="text-xl font-black text-gray-800">الملف الشخصي</h2>

    <form method="POST" action="{{ route('client.profile.update') }}" class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm space-y-4">
        @csrf
        @method('PUT')
        <div>
            <label class="mb-1 block text-sm font-bold text-gray-700">الاسم</label>
            <input type="text" name="name" value="{{ old('name', $client->name) }}" required class="w-full rounded-2xl border border-gray-200 bg-gray-50 px-4 py-3 text-gray-800 focus:border-amber-400 focus:ring-1 focus:ring-amber-400">
        </div>
        <div>
            <label class="mb-1 block text-sm font-bold text-gray-700">البريد</label>
            <input type="email" name="email" value="{{ old('email', $client->email) }}" class="w-full rounded-2xl border border-gray-200 bg-gray-50 px-4 py-3 text-gray-800 focus:border-amber-400 focus:ring-1 focus:ring-amber-400">
        </div>
        <div>
            <label class="mb-1 block text-sm font-bold text-gray-700">الهاتف</label>
            <input type="text" name="phone" value="{{ old('phone', $client->phone) }}" required class="w-full rounded-2xl border border-gray-200 bg-gray-50 px-4 py-3 text-gray-800 focus:border-amber-400 focus:ring-1 focus:ring-amber-400">
        </div>
        <button type="submit" class="rounded-full bg-amber-500 px-6 py-2 font-black text-white hover:bg-amber-600">حفظ</button>
    </form>

    <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm">
        <h3 class="font-black text-gray-800">تغيير كلمة المرور</h3>
        <form method="POST" action="{{ route('client.password.update') }}" class="mt-4 space-y-4">
            @csrf
            @method('PUT')
            <div>
                <label class="mb-1 block text-sm font-bold text-gray-700">كلمة المرور الحالية</label>
                <input type="password" name="current_password" required class="w-full rounded-2xl border border-gray-200 bg-gray-50 px-4 py-3 text-gray-800 focus:border-amber-400 focus:ring-1 focus:ring-amber-400">
            </div>
            <div>
                <label class="mb-1 block text-sm font-bold text-gray-700">كلمة المرور الجديدة</label>
                <input type="password" name="password" required minlength="6" class="w-full rounded-2xl border border-gray-200 bg-gray-50 px-4 py-3 text-gray-800 focus:border-amber-400 focus:ring-1 focus:ring-amber-400">
            </div>
            <div>
                <label class="mb-1 block text-sm font-bold text-gray-700">تأكيد كلمة المرور الجديدة</label>
                <input type="password" name="password_confirmation" required minlength="6" class="w-full rounded-2xl border border-gray-200 bg-gray-50 px-4 py-3 text-gray-800 focus:border-amber-400 focus:ring-1 focus:ring-amber-400">
            </div>
            <button type="submit" class="rounded-full bg-amber-500 px-6 py-2 font-black text-white hover:bg-amber-600">تغيير كلمة المرور</button>
        </form>
    </div>
</div>
@endsection
