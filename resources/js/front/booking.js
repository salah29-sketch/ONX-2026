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
    let visibleCount = 6;
    let currentIndex = 0;

    if (!cards.length) return;

    function getFilteredCards() {
        if (currentFilter === 'all') return cards;
        return cards.filter(card => card.dataset.service === currentFilter);
    }

    function getVisibleFilteredCards() {
        return getFilteredCards().filter(card => !card.classList.contains('hidden'));
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
            btn.classList.remove('bg-orange-500', 'text-black');
            btn.classList.add('border', 'border-white/15', 'bg-white/5', 'text-white');

            if (btn === activeBtn) {
                btn.classList.remove('border', 'border-white/15', 'bg-white/5', 'text-white');
                btn.classList.add('bg-orange-500', 'text-black');
            }
        });
    }

    filterButtons.forEach(button => {
        button.addEventListener('click', () => {
            currentFilter = button.dataset.filter;
            visibleCount = 6;
            setActiveFilterButton(button);
            renderCards();
        });
    });

    if (loadMoreBtn) {
        loadMoreBtn.addEventListener('click', () => {
            visibleCount += 3;
            renderCards();
        });
    }

    function buildViewerMedia(card) {
        const mediaType = card.dataset.mediaType;
        const image = card.dataset.image;
        const youtubeId = card.dataset.youtubeId;

        if (mediaType === 'youtube' && youtubeId) {
            return `
                <div class="aspect-video w-full">
                    <iframe
                        class="h-[320px] w-full md:h-[520px]"
                        src="https://www.youtube-nocookie.com/embed/${youtubeId}?autoplay=1&rel=0"
                        title="YouTube video player"
                        frameborder="0"
                        allow="autoplay; encrypted-media; picture-in-picture"
                        allowfullscreen
                    ></iframe>
                </div>
            `;
        }

        if (image) {
            return `
                <img
                    src="${image}"
                    alt="${card.dataset.title || ''}"
                    class="max-h-[75vh] w-auto max-w-full object-contain"
                >
            `;
        }

        return `<div class="text-sm text-white/50">لا توجد معاينة متاحة</div>`;
    }

    function openViewer(card) {
        const visibleCards = getVisibleFilteredCards();
        currentIndex = visibleCards.indexOf(card);

        if (currentIndex === -1) currentIndex = 0;

        viewerMedia.innerHTML = buildViewerMedia(card);
        viewerTitle.textContent = card.dataset.title || '';
        viewerCaption.textContent = card.dataset.caption || '';
        viewerService.textContent = card.dataset.serviceLabel || '';

        if (card.dataset.mediaType === 'youtube') {
            viewerType.textContent = 'فيديو';
            viewerType.classList.remove('hidden');
        } else {
            viewerType.textContent = '';
            viewerType.classList.add('hidden');
        }

        viewer.classList.remove('hidden');
        document.body.classList.add('overflow-hidden');
    }

    function closeViewer() {
        if (!viewer) return;

        viewer.classList.add('hidden');
        viewerMedia.innerHTML = '';
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

    document.querySelectorAll('.portfolio-open-btn').forEach((button, index) => {
        button.addEventListener('click', () => {
            openViewer(cards[index]);
        });
    });

    if (randomShotBtn) {
        randomShotBtn.addEventListener('click', () => {
            const visibleCards = getVisibleFilteredCards();
            if (!visibleCards.length) return;

            const randomIndex = Math.floor(Math.random() * visibleCards.length);
            openViewer(visibleCards[randomIndex]);
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
        if (!viewer || viewer.classList.contains('hidden')) return;

        if (event.key === 'Escape') closeViewer();
        if (event.key === 'ArrowLeft') navigateViewer(1);
        if (event.key === 'ArrowRight') navigateViewer(-1);
    });

    renderCards();
});