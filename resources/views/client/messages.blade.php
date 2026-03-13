@extends('client.layout')

@section('client_content')
<h2 class="mb-6 text-xl font-black text-gray-800">رسائلي للشركة</h2>

<div class="mb-8 rounded-2xl border border-gray-200 bg-white p-6 shadow-sm">
    <h3 class="font-black text-gray-800">إرسال رسالة جديدة</h3>
    <p class="mt-1 text-sm text-gray-500">الفريق يرد عادةً خلال 24 ساعة</p>
    <form method="POST" action="{{ route('client.messages.store') }}" class="mt-4 space-y-4">
        @csrf
        <div>
            <label class="mb-1 block text-sm font-bold text-gray-700">الموضوع (اختياري)</label>
            <input type="text" name="subject" value="{{ old('subject') }}" class="w-full rounded-2xl border border-gray-200 bg-gray-50 px-4 py-3 text-gray-800 focus:border-amber-400 focus:ring-1 focus:ring-amber-400">
        </div>
        <div>
            <label class="mb-1 block text-sm font-bold text-gray-700">الرسالة</label>
            <textarea name="message" rows="4" required class="w-full rounded-2xl border border-gray-200 bg-gray-50 px-4 py-3 text-gray-800 focus:border-amber-400 focus:ring-1 focus:ring-amber-400">{{ old('message') }}</textarea>
        </div>
        <button type="submit" class="rounded-full bg-amber-500 px-6 py-2 font-black text-white hover:bg-amber-600">إرسال</button>
    </form>
</div>

<div class="space-y-3">
    @forelse($messages as $m)
        <div class="rounded-2xl border border-gray-200 bg-white p-4 shadow-sm">
            @if($m->subject)<p class="font-bold text-gray-800">{{ $m->subject }}</p>@endif
            <p class="mt-1 text-sm text-gray-600">{{ Str::limit($m->message, 120) }}</p>
            <p class="mt-2 text-xs text-gray-400">{{ $m->created_at->format('Y-m-d H:i') }}</p>
        </div>
    @empty
        <p class="rounded-2xl border border-gray-200 bg-white py-8 text-center text-gray-500 shadow-sm">لا توجد رسائل.</p>
    @endforelse
</div>
<div class="mt-6">{{ $messages->links() }}</div>
@endsection
