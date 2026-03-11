@extends('client.layout')

@section('client_content')
<h2 class="mb-6 text-xl font-black text-white">رسائلي للشركة</h2>

<div class="mb-8 rounded-2xl border border-white/10 bg-white/5 p-6">
    <h3 class="font-black text-white">إرسال رسالة جديدة</h3>
    <form method="POST" action="{{ route('client.messages.store') }}" class="mt-4 space-y-4">
        @csrf
        <div>
            <label class="mb-1 block text-sm font-bold text-white/80">الموضوع (اختياري)</label>
            <input type="text" name="subject" value="{{ old('subject') }}" class="w-full rounded-2xl border border-white/15 bg-white/5 px-4 py-3 text-white">
        </div>
        <div>
            <label class="mb-1 block text-sm font-bold text-white/80">الرسالة</label>
            <textarea name="message" rows="4" required class="w-full rounded-2xl border border-white/15 bg-white/5 px-4 py-3 text-white">{{ old('message') }}</textarea>
        </div>
        <button type="submit" class="rounded-full bg-orange-500 px-6 py-2 font-black text-black hover:bg-orange-400">إرسال</button>
    </form>
</div>

<div class="space-y-3">
    @forelse($messages as $m)
        <div class="rounded-2xl border border-white/10 bg-white/5 p-4">
            @if($m->subject)<p class="font-bold text-white">{{ $m->subject }}</p>@endif
            <p class="mt-1 text-sm text-white/70">{{ Str::limit($m->message, 120) }}</p>
            <p class="mt-2 text-xs text-white/50">{{ $m->created_at->format('Y-m-d H:i') }}</p>
        </div>
    @empty
        <p class="text-center text-white/60">لا توجد رسائل.</p>
    @endforelse
</div>
<div class="mt-6">{{ $messages->links() }}</div>
@endsection
