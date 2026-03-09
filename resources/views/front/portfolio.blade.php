@extends('layouts.front_tailwind')

@section('title', 'ONX | الأعمال')

@section('content')

{{-- HEADER --}}
<section class="relative isolate overflow-hidden border-b border-white/10 py-20">
    <div class="absolute inset-0 -z-10">
        <div class="absolute inset-0 bg-[radial-gradient(circle_at_60%_40%,rgba(255,106,0,0.12),transparent_30%)]"></div>
    </div>
    <div class="mx-auto max-w-7xl px-6 lg:px-8">
        <div class="mb-4 inline-flex items-center gap-2 rounded-full border border-white/10 bg-white/5 px-3 py-1.5 text-[11px] font-bold text-white/70 backdrop-blur">
            <span class="h-2 w-2 rounded-full bg-orange-500"></span>
            ONX • Portfolio
        </div>
        <h1 class="text-3xl font-black leading-[1.1] sm:text-4xl lg:text-5xl">
            أعمال لا تكتفي
            <span class="text-orange-500">بأن تبدو جميلة</span>
        </h1>
        <p class="mt-4 max-w-xl text-xs leading-7 text-white/65 sm:text-sm">
            كل مشروع هنا كان فكرة، تحوّلت إلى صورة، ثم إلى حضور بصري يترك أثرًا.
        </p>
    </div>
</section>

{{-- FILTERS --}}
<section class="mx-auto max-w-7xl px-6 py-8 lg:px-8">
    <div class="flex flex-wrap gap-2">
        <a href="{{ route('portfolio') }}"
           class="rounded-full px-4 py-2 text-xs font-extrabold transition duration-200
                  {{ empty($filter) ? 'bg-orange-500 text-black shadow-[0_0_20px_rgba(249,115,22,0.3)]' : 'border border-white/10 bg-white/5 text-white/70 hover:border-orange-500/40 hover:bg-orange-500/10 hover:text-white' }}">
            الكل
        </a>
        @foreach($categories as $key => $label)
            <a href="{{ route('portfolio', ['category' => $key]) }}"
               class="rounded-full px-4 py-2 text-xs font-extrabold transition duration-200
                      {{ $filter === $key ? 'bg-orange-500 text-black shadow-[0_0_20px_rgba(249,115,22,0.3)]' : 'border border-white/10 bg-white/5 text-white/70 hover:border-orange-500/40 hover:bg-orange-500/10 hover:text-white' }}">
                {{ $label }}
            </a>
        @endforeach
    </div>
</section>

{{-- GRID --}}
<section class="mx-auto max-w-7xl px-6 pb-24 lg:px-8">

    @if($items->count())
        <div id="portfolio-grid" class="grid gap-5 sm:grid-cols-2 xl:grid-cols-3">
            @include('partials._portfolio_items', ['items' => $items, 'categories' => $categories])
        </div>

        {{-- LOAD MORE --}}
        @if($items->hasMorePages())
            <div class="mt-10 text-center">
                <button id="load-more"
                        data-page="2"
                        data-filter="{{ $filter ?? '' }}"
                        class="inline-flex items-center gap-2 rounded-full border border-white/10 bg-white/5 px-7 py-3 text-xs font-extrabold text-white/80 transition hover:border-orange-500/40 hover:bg-orange-500/10 hover:text-white">
                    <span class="btn-text">تحميل المزيد</span>
                    <svg class="spinner hidden h-4 w-4 animate-spin" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"></path>
                    </svg>
                </button>
            </div>
        @endif

    @else
        {{-- EMPTY STATE --}}
        <div class="rounded-[28px] border border-white/10 bg-white/5 p-14 text-center backdrop-blur-xl">
            <div class="mx-auto mb-4 flex h-16 w-16 items-center justify-center rounded-full border border-white/10 bg-white/5 text-3xl">
                🎬
            </div>
            <h3 class="mb-2 text-base font-black text-white">لا توجد أعمال حالياً</h3>
            <p class="text-sm text-white/50">لا توجد أعمال في هذا التصنيف، جرّب تصنيفاً آخر.</p>
            <a href="{{ route('portfolio') }}"
               class="mt-5 inline-flex rounded-full border border-white/10 bg-white/5 px-5 py-2.5 text-xs font-extrabold text-white/80 transition hover:border-orange-500/40 hover:bg-orange-500/10 hover:text-white">
                عرض الكل
            </a>
        </div>
    @endif

</section>

{{-- CTA --}}
<section class="mx-auto max-w-7xl px-6 pb-20 lg:px-8">
    <div class="relative overflow-hidden rounded-[30px] border border-orange-500/20 bg-gradient-to-br from-orange-500/12 via-white/5 to-white/5 p-7 shadow-[0_30px_90px_rgba(0,0,0,0.4)] sm:p-9">
        <div class="absolute -left-24 top-1/2 h-52 w-52 -translate-y-1/2 rounded-full bg-orange-500/10 blur-3xl"></div>
        <div class="absolute -right-16 top-0 h-36 w-36 rounded-full bg-white/5 blur-3xl"></div>
        <div class="relative z-10 mx-auto max-w-3xl text-center">
            <p class="mb-2 text-[11px] font-extrabold uppercase tracking-[0.25em] text-orange-400">ابدأ مشروعك</p>
            <h2 class="text-2xl font-black sm:text-3xl">
                هل تريد مشروعاً يليق بهذا المستوى؟
            </h2>
            <p class="mt-4 text-xs leading-7 text-white/70 sm:text-sm">
                دعنا نحوّل فكرتك إلى عمل بصري فاخر يحمل توقيع ONX.
            </p>
            <div class="mt-7 flex flex-wrap items-center justify-center gap-3">
                <a href="/booking"
                   class="inline-flex rounded-full bg-orange-500 px-6 py-3 text-xs font-black text-black transition duration-300 hover:-translate-y-1 hover:bg-orange-400 hover:shadow-[0_0_30px_rgba(249,115,22,0.35)]">
                    احجز الآن
                </a>
                <a href="https://wa.me/213540573518" target="_blank"
                   class="inline-flex rounded-full border border-white/15 bg-white/5 px-6 py-3 text-xs font-extrabold text-white transition duration-300 hover:-translate-y-1 hover:border-orange-500/50 hover:bg-orange-500/10">
                    واتساب
                </a>
            </div>
        </div>
    </div>
</section>

@endsection

@push('scripts')
<script>
const btn = document.getElementById('load-more');
if (btn) {
    btn.addEventListener('click', function () {
        const page   = this.dataset.page;
        const filter = this.dataset.filter;
        const text   = this.querySelector('.btn-text');
        const spin   = this.querySelector('.spinner');

        const params = new URLSearchParams({ page });
        if (filter) params.set('category', filter);

        text.textContent = 'جار التحميل...';
        spin.classList.remove('hidden');
        btn.disabled = true;

        fetch(`{{ route('portfolio') }}?${params}`, {
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        })
        .then(r => r.json())
        .then(({ html, hasMore }) => {
            document.getElementById('portfolio-grid').insertAdjacentHTML('beforeend', html);
            btn.dataset.page = parseInt(page) + 1;
            if (!hasMore) {
                btn.remove();
            } else {
                text.textContent = 'تحميل المزيد';
                spin.classList.add('hidden');
                btn.disabled = false;
            }
        })
        .catch(() => {
            text.textContent = 'حدث خطأ، حاول مجدداً';
            spin.classList.add('hidden');
            btn.disabled = false;
        });
    });
}
</script>
@endpush