@extends('client.layout')

@section('client_content')
<h2 class="mb-6 text-xl font-black text-white">إضافة رأيك</h2>
<p class="mb-6 text-sm text-white/60">رأيك يظهر في الموقع بعد مراجعته والمصادقة عليه من إدارة الموقع.</p>

<form method="POST" action="{{ route('client.review.store') }}" class="mx-auto max-w-xl rounded-2xl border border-white/10 bg-white/5 p-6 space-y-4">
    @csrf
    <div>
        <label class="mb-1 block text-sm font-bold text-white/80">رأيك (مطلوب)</label>
        <textarea name="content" rows="5" required maxlength="2000" class="w-full rounded-2xl border border-white/15 bg-white/5 px-4 py-3 text-white" placeholder="اكتب تجربتك معنا...">{{ old('content') }}</textarea>
    </div>
    <div>
        <label class="mb-1 block text-sm font-bold text-white/80">التقييم (1–5 نجوم)</label>
        <select name="rating" required class="w-full rounded-2xl border border-white/15 bg-white/5 px-4 py-3 text-white">
            @foreach([5,4,3,2,1] as $r)
                <option value="{{ $r }}" {{ old('rating', 5) == $r ? 'selected' : '' }}>{{ $r }} ★</option>
            @endforeach
        </select>
    </div>
    <button type="submit" class="w-full rounded-full bg-orange-500 py-3 font-black text-black hover:bg-orange-400">إرسال الرأي</button>
</form>
@endsection
