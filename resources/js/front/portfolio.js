function initPortfolioPage() {
    const cards = Array.from(document.querySelectorAll('.portfolio-card'));
    if (!cards.length) return;

    const filterButtons = document.querySelectorAll('.filter-btn');
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
    let visibleCount = 6;
    let currentIndex = 0;

    // ─── SVG Icons ───────────────────────────────────────────────────────────────
    const iconArrowLeft = `
        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24"
             fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M15 18l-6-6 6-6"/>
        </svg>`;

    const iconArrowRight = `
        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24"
             fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M9 18l6-6-6-6"/>
        </svg>`;

    const iconClose = `
        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24"
             fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <line x1="18" y1="6" x2="6" y2="18"/>
            <line x1="6" y1="6" x2="18" y2="18"/>
        </svg>`;

    const iconCalendar = `
        <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24"
             fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
            <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/>
            <line x1="16" y1="2" x2="16" y2="6"/>
            <line x1="8" y1="2" x2="8" y2="6"/>
            <line x1="3" y1="10" x2="21" y2="10"/>
        </svg>`;

    // ─── inject icons into nav buttons ───────────────────────────────────────────
    if (prevItemBtn)    prevItemBtn.innerHTML    = iconArrowLeft;
    if (nextItemBtn)    nextItemBtn.innerHTML    = iconArrowRight;
    if (closeViewerBtn) closeViewerBtn.innerHTML = iconClose;

    // ─── helpers ─────────────────────────────────────────────────────────────────
    function getFilteredCards() {
        if (currentFilter === 'all') return cards;
        return cards.filter((card) => card.dataset.service === currentFilter);
    }

    function getVisibleFilteredCards() {
        return getFilteredCards().filter((card) => !card.classList.contains('hidden'));
    }

    function renderCards() {
        const filteredCards = getFilteredCards();
        cards.forEach((card) => card.classList.add('hidden'));
        filteredCards.forEach((card, index) => {
            if (index < visibleCount) card.classList.remove('hidden');
        });
        if (loadMoreBtn) {
            filteredCards.length > visibleCount
                ? loadMoreBtn.classList.remove('hidden')
                : loadMoreBtn.classList.add('hidden');
        }
    }

    function setActiveFilterButton(activeBtn) {
        filterButtons.forEach((btn) => {
            btn.classList.remove('bg-orange-500', 'text-black');
            btn.classList.add('border', 'border-white/15', 'bg-white/5', 'text-white');
        });
        activeBtn.classList.remove('border', 'border-white/15', 'bg-white/5', 'text-white');
        activeBtn.classList.add('bg-orange-500', 'text-black');
    }

    function buildViewerMedia(card) {
        const mediaType  = card.dataset.mediaType;
        const image      = card.dataset.image;
        const youtubeId  = card.dataset.youtubeId;

        if (mediaType === 'youtube' && youtubeId) {
            return `
                <div class="aspect-video w-full">
                    <iframe
                        class="w-full h-[300px] md:h-[520px]"
                        src="https://www.youtube-nocookie.com/embed/${youtubeId}?autoplay=1&rel=0"
                        title="YouTube video player"
                        frameborder="0"
                        allow="autoplay; encrypted-media; picture-in-picture"
                        allowfullscreen
                    ></iframe>
                </div>`;
        }

        if (image) {
            return `
                <img
                    src="${image}"
                    alt="${card.dataset.title || ''}"
                    class="max-h-[85vh] w-auto mx-auto object-contain"
                >`;
        }

        return `<div class="text-sm text-white/50">لا توجد معاينة متاحة</div>`;
    }

    // ─── build booking URL with item notes ───────────────────────────────────────
    function buildBookingUrl(card) {
        const title        = card.dataset.title        || '';
        const caption      = card.dataset.caption      || '';
        const serviceLabel = card.dataset.serviceLabel || '';
        const mediaType    = card.dataset.mediaType    || '';

        const notes = [
            `الخدمة: ${serviceLabel}`,
            `العمل: ${title}`,
            caption ? `الوصف: ${caption}` : '',
            mediaType === 'youtube' ? 'النوع: فيديو' : 'النوع: صورة',
        ].filter(Boolean).join(' | ');

        return `/booking?notes=${encodeURIComponent(notes)}`;
    }

    // ─── open / close viewer ─────────────────────────────────────────────────────
    function openViewer(card) {
        if (!viewer || !viewerMedia || !viewerTitle || !viewerCaption || !viewerService || !viewerType) {
            console.error('Portfolio viewer elements are missing');
            return;
        }

        const visibleCards = getVisibleFilteredCards();
        currentIndex = visibleCards.indexOf(card);
        if (currentIndex === -1) currentIndex = 0;

        viewerMedia.innerHTML   = buildViewerMedia(card);
        viewerTitle.textContent = card.dataset.title        || '';
        viewerCaption.textContent = card.dataset.caption    || '';
        viewerService.textContent = card.dataset.serviceLabel || '';

        if (card.dataset.mediaType === 'youtube') {
            viewerType.textContent = 'فيديو';
            viewerType.classList.remove('hidden');
        } else {
            viewerType.textContent = '';
            viewerType.classList.add('hidden');
        }

        // ── booking button ────────────────────────────────────────────────────────
        const existingBookBtn = document.getElementById('viewerBookBtn');
        if (existingBookBtn) existingBookBtn.remove();

        const bookBtn = document.createElement('a');
        bookBtn.id        = 'viewerBookBtn';
        bookBtn.href      = buildBookingUrl(card);
        bookBtn.innerHTML = `${iconCalendar}<span>احجز خدمة مشابهة</span>`;
        bookBtn.className = [
            'inline-flex items-center gap-2 mt-5',
            'rounded-full bg-orange-500 px-5 py-2.5',
            'text-xs font-black text-black',
            'transition duration-300',
            'hover:-translate-y-1 hover:bg-orange-400',
            'hover:shadow-[0_0_28px_rgba(249,115,22,0.4)]',
        ].join(' ');

        // append after viewerCaption's parent container
        const infoPanel = viewerCaption.closest('.space-y-5');
        if (infoPanel) {
            infoPanel.appendChild(bookBtn);
        }

        viewer.classList.remove('hidden');
        document.body.classList.add('overflow-hidden');
    }

    function closeViewer() {
        if (!viewer) return;
        viewer.classList.add('hidden');
        if (viewerMedia) viewerMedia.innerHTML = '';
        const existingBookBtn = document.getElementById('viewerBookBtn');
        if (existingBookBtn) existingBookBtn.remove();
        document.body.classList.remove('overflow-hidden');
    }

    function navigateViewer(direction) {
        const visibleCards = getVisibleFilteredCards();
        if (!visibleCards.length) return;
        currentIndex += direction;
        if (currentIndex < 0) currentIndex = visibleCards.length - 1;
        if (currentIndex >= visibleCards.length) currentIndex = 0;
        openViewer(visibleCards[currentIndex]);
    }

    // ─── event listeners ─────────────────────────────────────────────────────────
    filterButtons.forEach((button) => {
        button.addEventListener('click', function () {
            currentFilter = this.dataset.filter;
            visibleCount  = 6;
            setActiveFilterButton(this);
            renderCards();
        });
    });

    if (loadMoreBtn) {
        loadMoreBtn.addEventListener('click', function () {
            visibleCount += 3;
            renderCards();
        });
    }

    document.addEventListener('click', function (event) {
        const openBtn = event.target.closest('.portfolio-open-btn');
        if (openBtn) {
            const card = openBtn.closest('.portfolio-card');
            if (card) openViewer(card);
        }
        if (event.target === viewer) closeViewer();
    });

    if (randomShotBtn) {
        randomShotBtn.addEventListener('click', function () {
            const visibleCards = getVisibleFilteredCards();
            if (!visibleCards.length) return;
            openViewer(visibleCards[Math.floor(Math.random() * visibleCards.length)]);
        });
    }

    if (closeViewerBtn) closeViewerBtn.addEventListener('click', closeViewer);
    if (prevItemBtn)    prevItemBtn.addEventListener('click', () => navigateViewer(-1));
    if (nextItemBtn)    nextItemBtn.addEventListener('click', () => navigateViewer(1));

    document.addEventListener('keydown', function (event) {
        if (!viewer || viewer.classList.contains('hidden')) return;
        if (event.key === 'Escape')      closeViewer();
        if (event.key === 'ArrowLeft')   navigateViewer(-1);
        if (event.key === 'ArrowRight')  navigateViewer(1);
    });

    renderCards();
    console.log('portfolio.js initialized');
}

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initPortfolioPage);
} else {
    initPortfolioPage();
}