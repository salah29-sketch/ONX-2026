@extends('client.layout')

@section('client_content')
<div class="mb-6">
    <a href="{{ route('client.project-photos') }}" class="text-sm font-bold text-orange-400 hover:underline">← صور مشروعي</a>
</div>
<h2 class="mb-2 text-xl font-black text-white">صور الحجز #{{ $booking->id }}</h2>
<p class="mb-6 text-sm text-white/60">اضغط على القلب لاختيار الصورة كمميزة للطباعة (الحد الأقصى 200 صورة). يمكنك المشاهدة والتحميل.</p>

<p class="mb-4 rounded-2xl border border-orange-500/20 bg-orange-500/10 px-4 py-2 text-sm font-bold text-orange-200">المختار: {{ $selectedCount }} / 200</p>

@if($photos->isEmpty())
    <div class="rounded-2xl border border-white/10 bg-white/5 p-8 text-center text-white/60">لا توجد صور لهذا الحجز بعد.</div>
@else
    <div class="grid grid-cols-2 gap-4 sm:grid-cols-3 md:grid-cols-4" id="photos-grid">
        @foreach($photos as $p)
            <div class="relative overflow-hidden rounded-2xl border border-white/10 bg-white/5" data-photo-id="{{ $p->id }}">
                <a href="{{ asset($p->path) }}" target="_blank" class="block aspect-square overflow-hidden">
                    <img src="{{ asset($p->path) }}" alt="صورة" class="h-full w-full object-cover">
                </a>
                <button type="button"
                        class="absolute bottom-2 right-2 rounded-full bg-black/60 p-2 text-lg transition hover:bg-orange-500/80 photo-fav"
                        data-id="{{ $p->id }}"
                        title="{{ in_array($p->id, $selectedIds) ? 'إلغاء التمييز' : 'اختيار كمميزة' }}">
                    @if(in_array($p->id, $selectedIds))
                        <span class="text-red-400">❤️</span>
                    @else
                        <span class="text-white/60">🤍</span>
                    @endif
                </button>
                <a href="{{ asset($p->path) }}" download class="absolute bottom-2 left-2 rounded-full bg-black/60 px-2 py-1.5 text-xs font-bold text-white/90 hover:bg-orange-500/80">تحميل</a>
            </div>
        @endforeach
    </div>
@endif

<script>
document.querySelectorAll('.photo-fav').forEach(function(btn) {
    btn.addEventListener('click', function(e) {
        e.preventDefault();
        var id = this.dataset.id;
        var heart = this.querySelector('span');
        var formData = new FormData();
        formData.append('_token', document.querySelector('meta[name="csrf-token"]').content);
        formData.append('booking_photo_id', id);
        fetch('{{ route("client.project-photos.toggle") }}', { method: 'POST', body: formData, headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' } })
            .then(r => r.json())
            .then(function(data) {
                if (data.ok) {
                    if (data.selected) { heart.textContent = '❤️'; heart.classList.remove('text-white/60'); heart.classList.add('text-red-400'); }
                    else { heart.textContent = '🤍'; heart.classList.add('text-white/60'); heart.classList.remove('text-red-400'); }
                    var counter = document.querySelector('.mb-4.rounded-2xl.border-orange-500');
                    if (counter) counter.innerHTML = 'المختار: ' + data.count + ' / 200';
                } else if (data.message) alert(data.message);
            });
    });
});
</script>
@endsection
