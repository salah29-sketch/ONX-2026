@extends('layouts.front_tailwind')

@section('content')
<div class="bg-black text-white min-h-screen">
    <section class="max-w-7xl mx-auto px-6 md:px-10 pt-16 md:pt-24 pb-10">
        <div class="flex flex-col md:flex-row md:items-end md:justify-between gap-6">
            <div class="max-w-2xl">
                <p class="text-sm uppercase tracking-[0.25em] text-white/50 mb-3">ONX Portfolio</p>
                <h1 class="text-4xl md:text-6xl font-semibold leading-tight">
                    A visual selection of work crafted for events and brands.
                </h1>
                <p class="mt-4 text-white/60 text-base md:text-lg leading-relaxed">
                    Explore a curated collection of event coverage and commercial production with a cinematic presentation.
                </p>
            </div>

            <div>
                <button
                    id="randomShotBtn"
                    type="button"
                    class="inline-flex items-center justify-center rounded-full border border-white/20 px-6 py-3 text-sm font-medium text-white hover:bg-white hover:text-black transition duration-300"
                >
                    Discover a Shot
                </button>
            </div>
        </div>
    </section>

    <section class="max-w-7xl mx-auto px-6 md:px-10 pb-8">
        <div class="flex flex-wrap items-center gap-3">
            <button
                class="filter-btn active rounded-full border border-white/15 bg-white text-black px-5 py-2 text-sm font-medium transition"
                data-filter="all"
                type="button"
            >
                All
            </button>

            <button
                class="filter-btn rounded-full border border-white/15 px-5 py-2 text-sm font-medium text-white hover:bg-white hover:text-black transition"
                data-filter="event"
                type="button"
            >
                Events
            </button>

            <button
                class="filter-btn rounded-full border border-white/15 px-5 py-2 text-sm font-medium text-white hover:bg-white hover:text-black transition"
                data-filter="ads"
                type="button"
            >
                Ads
            </button>
        </div>
    </section>

    <section class="max-w-7xl mx-auto px-6 md:px-10 pb-16">
        <div id="portfolioGrid" class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
            @foreach($items as $index => $item)
                @php
                    $imageUrl = $item->image_path ? asset($item->image_path) : '';
                    $serviceLabel = $item->service_type === 'event' ? 'Events' : 'Ads';
                    $isVideo = $item->media_type === 'youtube' && !empty($item->youtube_video_id);
                    $cardSpanClass = $index % 5 === 3 ? 'xl:col-span-2' : '';
                @endphp

                <article
                    class="portfolio-card group relative overflow-hidden rounded-3xl bg-white/5 border border-white/10 {{ $cardSpanClass }}"
                    data-service="{{ $item->service_type }}"
                    data-title="{{ e($item->title) }}"
                    data-caption="{{ e($item->caption) }}"
                    data-media-type="{{ $item->media_type }}"
                    data-image="{{ $imageUrl }}"
                    data-youtube-id="{{ $item->youtube_video_id }}"
                    data-service-label="{{ $serviceLabel }}"
                >
                    <button
                        type="button"
                        class="portfolio-open-btn block w-full text-left relative h-[320px] md:h-[380px] xl:h-[420px]"
                    >
                        @if($imageUrl)
                            <img
                                src="{{ $imageUrl }}"
                                alt="{{ $item->title }}"
                                loading="lazy"
                                class="absolute inset-0 w-full h-full object-cover transition duration-700 ease-out group-hover:scale-105"
                            >
                        @else
                            <div class="absolute inset-0 flex items-center justify-center bg-white/5 text-white/40 text-sm font-medium">
                                No Image
                            </div>
                        @endif

                        @if($isVideo)
                            <div class="absolute inset-0 bg-black/25 backdrop-blur-[1px]"></div>

                            <div class="absolute inset-0 z-10 flex items-center justify-center">
                                <span class="flex h-20 w-20 items-center justify-center rounded-full border border-white/20 bg-black/40 backdrop-blur-md shadow-[0_20px_40px_rgba(0,0,0,0.4)] transition duration-300 group-hover:scale-110">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-9 w-9 text-white ml-1" viewBox="0 0 24 24" fill="currentColor">
                                        <path d="M8 5.14v14l11-7-11-7z"/>
                                    </svg>
                                </span>
                            </div>
                        @endif

                        <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/25 to-transparent transition duration-500"></div>

                        <div class="absolute top-4 left-4 right-4 flex items-center justify-between gap-3 z-20">
                            <div class="flex flex-wrap gap-2">
                                <span class="inline-flex items-center rounded-full bg-white/10 backdrop-blur px-3 py-1 text-xs font-medium text-white border border-white/10">
                                    {{ $serviceLabel }}
                                </span>

                                @if($isVideo)
                                    <span class="inline-flex items-center rounded-full bg-white/10 backdrop-blur px-3 py-1 text-xs font-medium text-white border border-white/10">
                                        Video
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="absolute bottom-0 left-0 right-0 p-6 md:p-7 z-20">
                            <div class="transform transition duration-500 group-hover:-translate-y-1">
                                <h3 class="text-xl md:text-2xl font-semibold leading-tight">
                                    {{ $item->title }}
                                </h3>

                                @if($item->caption)
                                    <p class="mt-2 text-sm md:text-base text-white/70 max-w-xl leading-relaxed">
                                        {{ $item->caption }}
                                    </p>
                                @endif
                            </div>
                        </div>
                    </button>
                </article>
            @endforeach
        </div>

        @if($items->count() > 9)
            <div class="mt-10 text-center">
                <button
                    id="loadMoreBtn"
                    type="button"
                    class="inline-flex items-center justify-center rounded-full border border-white/15 px-6 py-3 text-sm font-medium text-white hover:bg-white hover:text-black transition duration-300"
                >
                    Load More
                </button>
            </div>
        @endif
    </section>

    <section class="max-w-5xl mx-auto px-6 md:px-10 pb-20">
        <div class="rounded-[2rem] border border-white/10 bg-white/5 px-8 py-12 md:px-12 md:py-16 text-center">
            <p class="text-sm uppercase tracking-[0.25em] text-white/45 mb-4">Let’s Create</p>
            <h2 class="text-3xl md:text-5xl font-semibold leading-tight">
                Ready to create something like this?
            </h2>
            <p class="mt-4 text-white/60 max-w-2xl mx-auto leading-relaxed">
                Tell us what you want to produce, and let’s turn the next concept into a polished visual piece.
            </p>

            <div class="mt-8">
                <a
                    href="{{ route('booking') }}"
                    class="inline-flex items-center justify-center rounded-full bg-white text-black px-6 py-3 text-sm font-semibold hover:opacity-90 transition"
                >
                    Book Your Project
                </a>
            </div>
        </div>
    </section>
</div>

<div
    id="portfolioViewer"
    class="fixed inset-0 z-[999] hidden bg-black/95 backdrop-blur-sm"
    aria-hidden="true"
>
    <div class="absolute inset-0 flex flex-col">
        <div class="flex items-center justify-between px-4 md:px-8 py-4 border-b border-white/10">
            <div class="text-sm uppercase tracking-[0.2em] text-white/45">
                Portfolio Viewer
            </div>

            <button
                id="closeViewer"
                type="button"
                class="inline-flex items-center justify-center w-11 h-11 rounded-full border border-white/15 text-white hover:bg-white hover:text-black transition"
                aria-label="Close viewer"
            >
                ✕
            </button>
        </div>

        <div class="flex-1 relative overflow-hidden">
            <button
                id="prevItem"
                type="button"
                class="absolute left-4 md:left-8 top-1/2 -translate-y-1/2 z-10 w-12 h-12 rounded-full border border-white/15 bg-black/40 text-white hover:bg-white hover:text-black hover:scale-110 transition"
                aria-label="Previous item"
            >
                ←
            </button>

            <button
                id="nextItem"
                type="button"
                class="absolute right-4 md:right-8 top-1/2 -translate-y-1/2 z-10 w-12 h-12 rounded-full border border-white/15 bg-black/40 text-white hover:bg-white hover:text-black hover:scale-110 transition"
                aria-label="Next item"
            >
                →
            </button>

            <div class="h-full max-w-7xl mx-auto px-6 md:px-10 py-8 md:py-10 grid grid-cols-1 lg:grid-cols-[minmax(0,1.4fr)_380px] gap-8 items-center">
                <div class="relative rounded-[2rem] overflow-hidden border border-white/10 bg-white/5 min-h-[300px] md:min-h-[520px] flex items-center justify-center">
                    <div id="viewerMedia" class="w-full h-full flex items-center justify-center"></div>
                </div>

                <div class="space-y-5">
                    <div class="flex flex-wrap gap-2">
                        <span id="viewerService" class="inline-flex items-center rounded-full bg-white/10 px-3 py-1 text-xs font-medium text-white border border-white/10"></span>
                        <span id="viewerType" class="inline-flex items-center rounded-full bg-white/10 px-3 py-1 text-xs font-medium text-white border border-white/10 hidden"></span>
                    </div>

                    <div>
                        <h2 id="viewerTitle" class="text-3xl md:text-4xl font-semibold leading-tight"></h2>
                        <p id="viewerCaption" class="mt-4 text-white/65 leading-relaxed text-base md:text-lg"></p>
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
    const filterButtons = document.querySelectorAll('.filter-btn');
    const cards = Array.from(document.querySelectorAll('.portfolio-card'));
    const loadMoreBtn = document.getElementById('loadMoreBtn');
    const randomShotBtn = document.getElementById('randomShotBtn');

    const viewer = document.getElementById('portfolioViewer');
    const closeViewerBtn = document.getElementById('closeViewer');
    const prevItemBtn = document.getElementById('prevItem');
    const nextItemBtn = document.getElementById('nextItem');
    const viewerMedia = document.getElementById('viewerMedia');
    const viewerTitle = document.getElementById('viewerTitle');
    const viewerCaption = document.getElementById('viewerCaption');
    const viewerService = document.getElementById('viewerService');
    const viewerType = document.getElementById('viewerType');

    let currentFilter = 'all';
    let visibleCount = 9;
    let currentIndex = 0;

    function getFilteredCards() {
        if (currentFilter === 'all') return cards;
        return cards.filter(card => card.dataset.service === currentFilter);
    }

    function renderCards() {
        const filteredCards = getFilteredCards();

        cards.forEach(card => card.classList.add('hidden'));

        filteredCards.forEach((card, index) => {
            if (index < visibleCount) {
                card.classList.remove('hidden');
            }
        });

        if (loadMoreBtn) {
            if (filteredCards.length > visibleCount) {
                loadMoreBtn.classList.remove('hidden');
            } else {
                loadMoreBtn.classList.add('hidden');
            }
        }
    }

    function setActiveFilterButton(activeBtn) {
        filterButtons.forEach(btn => {
            btn.classList.remove('active', 'bg-white', 'text-black');
            btn.classList.add('text-white');

            if (btn === activeBtn) {
                btn.classList.add('active', 'bg-white', 'text-black');
                btn.classList.remove('text-white');
            }
        });
    }

    filterButtons.forEach(button => {
        button.addEventListener('click', () => {
            currentFilter = button.dataset.filter;
            visibleCount = 9;
            setActiveFilterButton(button);
            renderCards();
        });
    });

    if (loadMoreBtn) {
        loadMoreBtn.addEventListener('click', () => {
            visibleCount += 6;
            renderCards();
        });
    }

    function buildViewerMedia(card) {
        const mediaType = card.dataset.mediaType;
        const image = card.dataset.image;
        const youtubeId = card.dataset.youtubeId;

        if (mediaType === 'youtube' && youtubeId) {
            return `
                <div class="w-full aspect-video">
                    <iframe
                        class="w-full h-[300px] md:h-[520px]"
                        src="https://www.youtube.com/embed/${youtubeId}?autoplay=1&rel=0"
                        title="YouTube video player"
                        frameborder="0"
                        allow="autoplay; encrypted-media; picture-in-picture"
                        allowfullscreen
                    ></iframe>
                </div>
            `;
        }

        return `
            <img
                src="${image}"
                alt="${card.dataset.title}"
                class="max-h-[85vh] w-auto mx-auto object-contain"
            >
        `;
    }

    function openViewer(card) {
        const filteredCards = getFilteredCards().filter(item => !item.classList.contains('hidden'));
        currentIndex = filteredCards.indexOf(card);

        if (currentIndex === -1) currentIndex = 0;

        viewerMedia.innerHTML = buildViewerMedia(card);
        viewerTitle.textContent = card.dataset.title || '';
        viewerCaption.textContent = card.dataset.caption || '';
        viewerService.textContent = card.dataset.serviceLabel || '';

        if (card.dataset.mediaType === 'youtube') {
            viewerType.textContent = 'Video';
            viewerType.classList.remove('hidden');
        } else {
            viewerType.textContent = '';
            viewerType.classList.add('hidden');
        }

        viewer.classList.remove('hidden');
        document.body.classList.add('overflow-hidden');
        viewer.setAttribute('aria-hidden', 'false');
    }

    function closeViewer() {
        viewer.classList.add('hidden');
        viewer.setAttribute('aria-hidden', 'true');
        viewerMedia.innerHTML = '';
        document.body.classList.remove('overflow-hidden');
    }

    function navigateViewer(direction) {
        const filteredCards = getFilteredCards().filter(item => !item.classList.contains('hidden'));
        if (!filteredCards.length) return;

        currentIndex += direction;

        if (currentIndex < 0) currentIndex = filteredCards.length - 1;
        if (currentIndex >= filteredCards.length) currentIndex = 0;

        openViewer(filteredCards[currentIndex]);
    }

    document.querySelectorAll('.portfolio-open-btn').forEach((button, index) => {
        button.addEventListener('click', () => {
            openViewer(cards[index]);
        });
    });

    if (randomShotBtn) {
        randomShotBtn.addEventListener('click', () => {
            const filteredCards = getFilteredCards().filter(card => !card.classList.contains('hidden'));
            if (!filteredCards.length) return;

            const randomIndex = Math.floor(Math.random() * filteredCards.length);
            openViewer(filteredCards[randomIndex]);
        });
    }

    closeViewerBtn?.addEventListener('click', closeViewer);
    prevItemBtn?.addEventListener('click', () => navigateViewer(-1));
    nextItemBtn?.addEventListener('click', () => navigateViewer(1));

    viewer?.addEventListener('click', (event) => {
        if (event.target === viewer) {
            closeViewer();
        }
    });

    document.addEventListener('keydown', (event) => {
        if (viewer.classList.contains('hidden')) return;

        if (event.key === 'Escape') closeViewer();
        if (event.key === 'ArrowLeft') navigateViewer(-1);
        if (event.key === 'ArrowRight') navigateViewer(1);
    });

    renderCards();
});
</script>
@endpush