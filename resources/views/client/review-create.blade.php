@extends('client.layout')

@section('client_content')
<h2 class="mb-6 text-xl font-black text-gray-800">إضافة رأيك</h2>
<p class="mb-6 text-sm text-gray-500">رأيك يظهر في الموقع بعد مراجعته والمصادقة عليه من إدارة الموقع.</p>

<form method="POST" action="{{ route('client.review.store') }}" class="mx-auto max-w-xl rounded-2xl border border-gray-200 bg-white p-6 shadow-sm space-y-4">
    @csrf
    <div>
        <label class="mb-1 block text-sm font-bold text-gray-700">رأيك (مطلوب)</label>
        <textarea name="content" rows="5" required maxlength="2000" class="w-full rounded-2xl border border-gray-200 bg-gray-50 px-4 py-3 text-gray-800 focus:border-amber-400 focus:ring-1 focus:ring-amber-400" placeholder="اكتب تجربتك معنا...">{{ old('content') }}</textarea>
    </div>
    <div>
        <label class="mb-2 block text-sm font-bold text-gray-700">التقييم (1–5 نجوم)</label>
        <input type="hidden" name="rating" id="rating-input" value="{{ old('rating', 5) }}" required>
        <div class="flex items-center gap-1" id="star-rating" role="group" aria-label="اختر التقييم">
            @for($s = 1; $s <= 5; $s++)
                <button type="button" class="star-btn text-3xl leading-none transition focus:outline-none focus:ring-2 focus:ring-amber-400 focus:ring-offset-2 rounded p-0.5" data-value="{{ $s }}" aria-label="{{ $s }} نجوم" title="{{ $s }} نجوم">
                    <span class="star-empty text-gray-300">☆</span>
                    <span class="star-filled text-amber-500 hidden">★</span>
                </button>
            @endfor
        </div>
        <p class="mt-1 text-xs text-gray-500" id="rating-label">5 نجوم</p>
    </div>
    <button type="submit" class="w-full rounded-full bg-amber-500 py-3 font-black text-white hover:bg-amber-600">إرسال الرأي</button>
</form>

<script>
(function() {
    var container = document.getElementById('star-rating');
    var input = document.getElementById('rating-input');
    var label = document.getElementById('rating-label');
    if (!container || !input) return;
    var selected = parseInt(input.value, 10) || 5;

    function renderStars(value) {
        if (label) label.textContent = value + ' نجوم';
        container.querySelectorAll('.star-btn').forEach(function(btn) {
            var v = parseInt(btn.getAttribute('data-value'), 10);
            var empty = btn.querySelector('.star-empty');
            var filled = btn.querySelector('.star-filled');
            if (v <= value) {
                if (empty) empty.classList.add('hidden');
                if (filled) filled.classList.remove('hidden');
            } else {
                if (empty) empty.classList.remove('hidden');
                if (filled) filled.classList.add('hidden');
            }
        });
    }

    container.querySelectorAll('.star-btn').forEach(function(btn) {
        btn.addEventListener('click', function() {
            selected = parseInt(this.getAttribute('data-value'), 10);
            input.value = selected;
            renderStars(selected);
        });
        btn.addEventListener('mouseenter', function() {
            renderStars(parseInt(this.getAttribute('data-value'), 10));
        });
    });
    container.addEventListener('mouseleave', function() {
        renderStars(selected);
    });

    renderStars(selected);
})();
</script>
@endsection
