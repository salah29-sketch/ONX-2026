@extends('layouts.app')

@push('styles')
<style>
    /* ===== FILTER BUTTONS ===== */
    .filter-btn {
        position: relative;
        overflow: hidden;
        transition: all 0.3s ease;
    }
    .filter-btn.active {
        background: linear-gradient(135deg, #f97316, #ea580c);
        border-color: #f97316;
        color: #000;
        font-weight: 800;
        box-shadow: 0 0 24px rgba(249,115,22,0.35);
    }
    .filter-btn:not(.active):hover {
        border-color: rgba(249,115,22,0.5);
        background: rgba(249,115,22,0.08);
        color: #fff;
    }

    /* ===== PORTFOLIO CARDS ===== */
    .portfolio-card {
        transition: transform 0.4s cubic-bezier(0.25,0.46,0.45,0.94),
                    box-shadow 0.4s ease,
                    opacity 0.4s ease;
    }
    .portfolio-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 24px 60px rgba(0,0,0,0.6), 0 0 0 1px rgba(249,115,22,0.2);
    }
    .portfolio-card .card-img {
        transition: transform 0.7s cubic-bezier(0.25,0.46,0.45,0.94);
    }
    .portfolio-card:hover .card-img {
        transform: scale(1.07);
    }

    /* ===== ORANGE GLOW BADGE ===== */
    .badge-orange {
        background: rgba(249,115,22,0.15);
        border: 1px solid rgba(249,115,22,0.35);
        color: #fb923c;
        backdrop-filter: blur(8px);
    }
    .badge-default {
        background: rgba(255,255,255,0.07);
        border: 1px solid rgba(255,255,255,0.12);
        backdrop-filter: blur(8px);
    }

    /* ===== GRID ANIMATION ===== */
    .portfolio-card.hidden-card {
        opacity: 0;
        pointer-events: none;
        transform: translateY(12px) scale(0.97);
    }

    /* ===== VIEWER OVERLAY ===== */
    #portfolioViewer {
        animation: fadeIn 0.25s ease;
    }
    @keyframes fadeIn {
        from { opacity: 0; }
        to   { opacity: 1; }
    }
    #viewerInner {
        animation: slideUp 0.3s cubic-bezier(0.25,0.46,0.45,0.94);
    }
    @keyframes slideUp {
        from { transform: translateY(20px); opacity: 0; }
        to   { transform: translateY(0);    opacity: 1; }
    }

    /* ===== RANDOM SHOT BUTTON ===== */
    #randomShotBtn {
        position: relative;
        overflow: hidden;
    }
    #randomShotBtn::before {
        content: '';
        position: absolute;
        inset: 0;
        background: linear-gradient(135deg, rgba(249,115,22,0.15), transparent);
        opacity: 0;
        transition: opacity 0.3s ease;
    }
    #randomShotBtn:hover::before { opacity: 1; }

    /* ===== HEADING ACCENT ===== */
    .accent-dot {
        display: inline-block;
        width: 10px; height: 10px;
        background: #f97316;
        border-radius: 50%;
        box-shadow: 0 0 16px rgba(249,115,22,0.8);
        margin-right: 4px;
    }

    /* ===== VIEWER CLOSE ===== */
    #closeViewer:hover {
        background: rgba(249,115,22,0.15);
        border-color: rgba(249,115,22,0.4);
        color: #fb923c;
    }

    /* ===== SCROLL REVEAL ===== */
    .reveal {
        opacity: 0;
        transform: translateY(30px);
        transition: opacity 0.6s ease, transform 0.6s ease;
    }
    .reveal.visible {
        opacity: 1;
        transform: translateY(0);
    }
</style>
@endpush

@section('content')

{{-- ======================================================
     HERO SECTION
====================================================== --}}
<section class="max-w-7xl mx-auto px-6 lg:px-8 pt-16 md:pt-24 pb-12">
    <div class="flex flex-col md:flex-row md:items-end md:justify-between gap-8">

        {{-- النص --}}
        <div class="max-w-2xl reveal">

            <p class="text-xs uppercase tracking-[0.3em] text-orange-500/80 mb-4 font-bold flex items-center gap-2">
                <span class="accent-dot"></span>
                ONX Portfolio &nbsp;·&nbsp; معرض الأعمال
            </p>

            <h1 class="text-4xl md:text-6xl font-black leading-tight text-white">
                أعمال صُنعت<br>
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-orange-400 to-orange-600">لتُرى وتُحَس</span>
            </h1>

            <p class="mt-5 text-white/55 text-base md:text-lg leading-relaxed font-medium">
                مجموعة مختارة من إنتاجات الفعاليات والإعلانات التجارية — بأسلوب سينمائي يترك أثراً.
                <br class="hidden md:block">
                <span class="text-white/35 text-sm">A curated selection of event &amp; commercial productions.</span>
            </p>

        </div>

        {{-- زر Discover --}}
        <button
            id="randomShotBtn"
            type="button"
            class="reveal self-start md:self-auto inline-flex items-center gap-3 rounded-full border border-orange-500/40 bg-orange-500/10 px-6 py-3.5 text-sm font-extrabold text-white transition duration-300 hover:-translate-y-0.5 hover:border-orange-400 hover:shadow-[0_0_28px_rgba(249,115,22,0.3)]"
        >
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-orange-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12a7.5 7.5 0 0115 0m-15 0a7.5 7.5 0 1015 0M12 9v3l2 2"/>
            </svg>
            <span>اكتشف لقطة · Discover a Shot</span>
        </button>

    </div>
</section>

{{-- ======================================================
     FILTER SECTION
====================================================== --}}
<section class="max-w-7xl mx-auto px-6 lg:px-8 pb-10">
    <div class="flex flex-wrap items-center gap-3 reveal">

        <button class="filter-btn active rounded-full border border-transparent px-5 py-2.5 text-sm font-bold transition"
            data-filter="all">
            الكل &nbsp;<span class="text-[10px] opacity-60">All</span>
        </button>

        <button class="filter-btn rounded-full border border-white/15 px-5 py-2.5 text-sm font-bold text-white/70 transition"
            data-filter="event">
            فعاليات &nbsp;<span class="text-[10px] opacity-50">Events</span>
        </button>

        <button class="filter-btn rounded-full border border-white/15 px-5 py-2.5 text-sm font-bold text-white/70 transition"
            data-filter="ads">
            إعلانات &nbsp;<span class="text-[10px] opacity-50">Ads</span>
        </button>

    </div>
</section>

{{-- ======================================================
     PORTFOLIO GRID
====================================================== --}}
<section class="max-w-7xl mx-auto px-6 lg:px-8 pb-24">

    <div id="portfolioGrid" class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-5">

        @foreach($items as $index => $item)

        @php
            $imageUrl       = $item->image_path ? asset($item->image_path) : '';
            $serviceLabel   = $item->service_type === 'event' ? 'فعاليات' : 'إعلانات';
            $serviceLabelEn = $item->service_type === 'event' ? 'Events' : 'Ads';
            $isVideo        = $item->media_type === 'youtube';
        @endphp

        <article
            class="portfolio-card reveal group relative overflow-hidden rounded-3xl border border-white/10 bg-white/[0.03] cursor-pointer"
            data-service="{{ $item->service_type }}"
            data-title="{{ e($item->title) }}"
            data-caption="{{ e($item->caption) }}"
            data-media-type="{{ $item->media_type }}"
            data-image="{{ $imageUrl }}"
            data-youtube-id="{{ $item->youtube_video_id }}"
            data-service-label="{{ $serviceLabel }}"
            style="animation-delay: {{ $index * 60 }}ms"
        >
            <button type="button" class="portfolio-open-btn relative block w-full h-[320px] md:h-[360px] xl:h-[400px]">

                {{-- الصورة --}}
                @if($imageUrl)
                <img
                    src="{{ $imageUrl }}"
                    alt="{{ $item->title }}"
                    class="card-img absolute inset-0 w-full h-full object-cover"
                    loading="lazy"
                />
                @endif

                {{-- Gradient Overlay --}}
                <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/25 to-transparent"></div>

                {{-- Orange glow on hover --}}
                <div class="absolute inset-0 bg-gradient-to-t from-orange-950/30 to-transparent opacity-0 group-hover:opacity-100 transition duration-500"></div>

                {{-- Badges --}}
                <div class="absolute top-4 right-4 flex gap-2">
                    <span class="badge-orange rounded-full px-3 py-1 text-xs font-bold">
                        {{ $serviceLabel }}
                    </span>
                    @if($isVideo)
                    <span class="badge-default rounded-full px-3 py-1 text-xs font-bold text-white/70 flex items-center gap-1">
                        <svg class="h-3 w-3" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M6.3 2.84A1.5 1.5 0 004 4.11v11.78a1.5 1.5 0 002.3 1.27l9.34-5.89a1.5 1.5 0 000-2.54L6.3 2.84z"/>
                        </svg>
                        Video
                    </span>
                    @endif
                </div>

                {{-- Play icon (video only) --}}
                @if($isVideo)
                <div class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition duration-300">
                    <div class="w-16 h-16 rounded-full bg-orange-500/90 flex items-center justify-center shadow-[0_0_40px_rgba(249,115,22,0.5)] backdrop-blur">
                        <svg class="h-7 w-7 text-black ml-1" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M6.3 2.84A1.5 1.5 0 004 4.11v11.78a1.5 1.5 0 002.3 1.27l9.34-5.89a1.5 1.5 0 000-2.54L6.3 2.84z"/>
                        </svg>
                    </div>
                </div>
                @endif

                {{-- Card Info --}}
                <div class="absolute bottom-0 left-0 right-0 p-5 text-right">
                    <h3 class="text-xl md:text-2xl font-black leading-tight text-white group-hover:text-orange-100 transition duration-300">
                        {{ $item->title }}
                    </h3>
                    @if($item->caption)
                    <p class="mt-1.5 text-sm text-white/55 leading-relaxed line-clamp-2">
                        {{ $item->caption }}
                    </p>
                    @endif

                    {{-- Arrow indicator --}}
                    <div class="mt-3 flex justify-end">
                        <span class="inline-flex items-center gap-1.5 text-xs font-bold text-orange-500/70 group-hover:text-orange-400 transition duration-300">
                            عرض التفاصيل
                            <svg class="h-3.5 w-3.5 -rotate-45 group-hover:-translate-y-0.5 group-hover:translate-x-0.5 transition duration-300" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14M12 5l7 7-7 7"/>
                            </svg>
                        </span>
                    </div>
                </div>

            </button>
        </article>

        @endforeach

    </div>

    {{-- Empty State --}}
    <div id="emptyState" class="hidden text-center py-24">
        <div class="text-6xl mb-4 opacity-20">◎</div>
        <p class="text-white/40 font-bold text-lg">لا توجد أعمال في هذا التصنيف</p>
        <p class="text-white/25 text-sm mt-1">No items found in this category</p>
    </div>

</section>

{{-- ======================================================
     PORTFOLIO VIEWER
====================================================== --}}
<div
    id="portfolioViewer"
    class="fixed inset-0 z-[999] hidden bg-black/95 backdrop-blur-md"
    role="dialog"
    aria-modal="true"
>
    <div id="viewerInner" class="absolute inset-0 flex flex-col">

        {{-- Header --}}
        <div class="flex items-center justify-between px-6 py-4 border-b border-white/10">
            <div class="flex items-center gap-3">
                <span class="text-xs uppercase tracking-[0.25em] text-orange-500/70 font-bold">ONX · معرض الأعمال</span>
            </div>
            <button
                id="closeViewer"
                class="w-10 h-10 rounded-full border border-white/15 text-white/70 font-bold transition duration-300 flex items-center justify-center"
                aria-label="إغلاق"
            >✕</button>
        </div>

        {{-- Media --}}
        <div class="flex-1 flex items-center justify-center p-6 md:p-10 overflow-auto">
            <div class="max-w-5xl w-full">

                {{-- Media Container --}}
                <div class="rounded-3xl overflow-hidden border border-white/10 bg-black/60 relative flex items-center justify-center shadow-[0_40px_80px_rgba(0,0,0,0.8)]">
                    <div id="viewerMedia" class="w-full"></div>
                </div>

                {{-- Info --}}
                <div class="mt-6 text-right">
                    <div class="flex items-start justify-between gap-4">
                        <div class="flex-1">
                            <h2 id="viewerTitle" class="text-2xl md:text-3xl font-black text-white leading-tight"></h2>
                            <p id="viewerCaption" class="mt-2 text-white/55 leading-relaxed"></p>
                        </div>
                        <span id="viewerBadge" class="badge-orange rounded-full px-4 py-1.5 text-sm font-bold whitespace-nowrap mt-1"></span>
                    </div>
                </div>

            </div>
        </div>

    </div>
</div>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {

    // ── Scroll Reveal ──────────────────────────────────────────
    const observer = new IntersectionObserver((entries) => {
        entries.forEach((e, i) => {
            if (e.isIntersecting) {
                setTimeout(() => e.target.classList.add('visible'), i * 60);
                observer.unobserve(e.target);
            }
        });
    }, { threshold: 0.1 });
    document.querySelectorAll('.reveal').forEach(el => observer.observe(el));

    // ── Data ───────────────────────────────────────────────────
    const cards        = Array.from(document.querySelectorAll('.portfolio-card'));
    const viewer       = document.getElementById('portfolioViewer');
    const viewerMedia  = document.getElementById('viewerMedia');
    const viewerTitle  = document.getElementById('viewerTitle');
    const viewerCaption= document.getElementById('viewerCaption');
    const viewerBadge  = document.getElementById('viewerBadge');
    const closeViewer  = document.getElementById('closeViewer');
    const emptyState   = document.getElementById('emptyState');

    // ── Open Viewer ────────────────────────────────────────────
    function openCard(card) {
        const { mediaType, image, youtubeId, title, caption, serviceLabel } = card.dataset;

        if (mediaType === 'youtube' && youtubeId) {
            viewerMedia.innerHTML = `
                <div class="aspect-video">
                    <iframe class="w-full h-full" src="https://www.youtube.com/embed/${youtubeId}?autoplay=1&rel=0" allowfullscreen allow="autoplay"></iframe>
                </div>`;
        } else {
            viewerMedia.innerHTML = `<img src="${image}" class="max-h-[72vh] w-auto mx-auto object-contain" alt="${title}" />`;
        }

        viewerTitle.textContent   = title;
        viewerCaption.textContent = caption;
        viewerBadge.textContent   = serviceLabel;

        viewer.classList.remove('hidden');
        document.body.classList.add('overflow-hidden');
    }

    cards.forEach(card => {
        card.querySelector('.portfolio-open-btn').addEventListener('click', () => openCard(card));
    });

    // ── Close Viewer ───────────────────────────────────────────
    function closeViewerFn() {
        viewer.classList.add('hidden');
        viewerMedia.innerHTML = '';
        document.body.classList.remove('overflow-hidden');
    }
    closeViewer.addEventListener('click', closeViewerFn);
    viewer.addEventListener('click', e => { if (e.target === viewer) closeViewerFn(); });
    document.addEventListener('keydown', e => { if (e.key === 'Escape') closeViewerFn(); });

    // ── Filter ─────────────────────────────────────────────────
    document.querySelectorAll('.filter-btn').forEach(btn => {
        btn.addEventListener('click', () => {
            document.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('active'));
            btn.classList.add('active');

            const filter = btn.dataset.filter;
            let visible = 0;

            cards.forEach(card => {
                const match = filter === 'all' || card.dataset.service === filter;
                card.classList.toggle('hidden-card', !match);
                if (match) visible++;
            });

            emptyState.classList.toggle('hidden', visible > 0);
        });
    });

    // ── Random Shot ────────────────────────────────────────────
    document.getElementById('randomShotBtn').addEventListener('click', () => {
        const visible = cards.filter(c => !c.classList.contains('hidden-card'));
        if (!visible.length) return;
        openCard(visible[Math.floor(Math.random() * visible.length)]);
    });

});
</script>
@endpush