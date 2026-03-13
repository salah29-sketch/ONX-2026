@extends('layouts.front_tailwind')

@section('title', 'ONX | الأعمال')
@section('meta_description', 'أعمال ONX — نماذج من مشاريعنا في الإعلانات، الفعاليات، والتجارب البصرية. تصوير حفلات وإعلانات تجارية بأسلوب سينمائي.')
@section('content')

{{-- HERO --}}
<section class="relative isolate overflow-hidden border-b border-white/10">
    <div class="absolute inset-0 -z-10">
        @php
            $heroItem = isset($featuredItems) && $featuredItems->count()
                ? $featuredItems->first()
                : ($items->first() ?? null);

            $heroImage = $heroItem && !empty($heroItem->image_path)
                ? asset($heroItem->image_path)
                : asset('img/events.jpg');
        @endphp

        <img src="{{ $heroImage }}"
             alt="ONX Portfolio"
             class="h-full w-full object-cover opacity-20">

        <div class="absolute inset-0 bg-gradient-to-b from-black/30 via-black/80 to-[#050505]"></div>
        <div class="absolute inset-0 bg-[radial-gradient(circle_at_70%_30%,rgba(255,106,0,0.14),transparent_28%),radial-gradient(circle_at_20%_80%,rgba(255,106,0,0.06),transparent_26%)]"></div>
    </div>

    <div class="mx-auto grid min-h-[72vh] max-w-7xl items-center gap-10 px-6 py-14 lg:grid-cols-[1.02fr_.98fr] lg:px-8 lg:py-16">
        <div class="order-2 lg:order-1">
            <div class="mb-4 inline-flex items-center gap-2 rounded-full border border-white/10 bg-white/5 px-3 py-1.5 text-[11px] font-bold text-white/70 opacity-0 backdrop-blur animate-fade-in-up">
                <span class="h-2 w-2 rounded-full bg-orange-500"></span>
                ONX • Portfolio
            </div>

            <h1 class="max-w-4xl text-3xl font-black leading-[1.1] text-white opacity-0 sm:text-4xl lg:text-5xl animate-fade-in-up animate-delay-100">
                أعمال
                <span class="text-orange-500">تُرى وتُتذكر</span>
                <span class="block">وتكشف أسلوبنا في الصورة</span>
            </h1>

            <p class="mt-5 max-w-2xl text-xs leading-7 text-white/70 opacity-0 sm:text-sm animate-fade-in-up animate-delay-200">
                هنا نستعرض نماذج من مشاريعنا في الإعلانات، الفعاليات، والتجارب البصرية
                التي صُممت لتكون أنيقة، واضحة، ومؤثرة من أول لقطة إلى آخر frame.
            </p>

            <div class="mt-7 flex flex-wrap gap-3 opacity-0 animate-fade-in-up animate-delay-300">
                <a href="#portfolio-grid"
                   class="inline-flex items-center justify-center rounded-full bg-orange-500 px-6 py-2.5 text-xs font-black text-black transition duration-300 hover:-translate-y-1 hover:bg-orange-400 hover:shadow-[0_0_30px_rgba(249,115,22,0.3)] active:scale-[0.98]">
                    استكشف الأعمال
                </a>

                <a href="/booking"
                   class="inline-flex items-center justify-center rounded-full border border-white/15 bg-white/5 px-6 py-2.5 text-xs font-extrabold text-white transition duration-300 hover:-translate-y-1 hover:border-orange-500/50 hover:bg-orange-500/10 active:scale-[0.98]">
                    ابدأ مشروعك
                </a>
            </div>

            <div class="mt-7 grid max-w-3xl gap-3 sm:grid-cols-3">
                <div class="rounded-[18px] border border-white/10 bg-white/5 p-3.5 opacity-0 backdrop-blur-xl transition duration-300 hover:-translate-y-0.5 hover:border-white/20 animate-fade-in-up animate-delay-400">
                    <div class="text-sm font-black text-white">Visual Impact</div>
                    <div class="mt-1.5 text-[11px] leading-5 text-white/55">مشاريع تعكس حضورًا بصريًا يلفت ويثبت في الذاكرة</div>
                </div>

                <div class="rounded-[18px] border border-white/10 bg-white/5 p-3.5 opacity-0 backdrop-blur-xl transition duration-300 hover:-translate-y-0.5 hover:border-white/20 animate-fade-in-up animate-delay-500">
                    <div class="text-sm font-black text-white">Curated Work</div>
                    <div class="mt-1.5 text-[11px] leading-5 text-white/55">أعمال منتقاة تعبّر عن أسلوب ONX في التنفيذ والإخراج</div>
                </div>

                <div class="rounded-[18px] border border-white/10 bg-white/5 p-3.5 opacity-0 backdrop-blur-xl transition duration-300 hover:-translate-y-0.5 hover:border-white/20 animate-fade-in-up animate-delay-600">
                    <div class="text-sm font-black text-white">Brand Presence</div>
                    <div class="mt-1.5 text-[11px] leading-5 text-white/55">صورة ترفع قيمة المشروع وتمنحه هيئة تليق به</div>
                </div>
            </div>
        </div>

        <div class="order-1 lg:order-2 opacity-0 animate-fade-in-up animate-delay-300">
            <div class="relative mx-auto max-w-lg">
                <div class="absolute -inset-8 rounded-[38px] bg-orange-500/10 blur-3xl"></div>

                <div class="relative overflow-hidden rounded-[24px] border border-white/10 bg-white/5 shadow-[0_24px_80px_rgba(0,0,0,0.5)] backdrop-blur-xl">
                    <img src="{{ $heroImage }}"
                         alt="{{ $heroItem->title ?? 'ONX Portfolio' }}"
                         class="h-[400px] w-full object-cover opacity-95">

                    <div class="absolute inset-0 bg-gradient-to-t from-black via-black/20 to-transparent"></div>

                    <div class="absolute left-0 right-0 top-0 flex items-start justify-between p-3.5">
                        <div class="inline-flex rounded-full border border-white/10 bg-black/35 px-2.5 py-1 text-[10px] font-extrabold tracking-[0.18em] text-white/70 backdrop-blur">
                            ONX FRAME
                        </div>
                        <div class="inline-flex rounded-full border border-orange-500/30 bg-orange-500/10 px-2.5 py-1 text-[10px] font-extrabold tracking-wide text-orange-300">
                            FEATURED VISUAL
                        </div>
                    </div>

                    <div class="absolute bottom-0 left-0 right-0 p-5">
                        <h2 class="text-xl font-black text-white sm:text-2xl">
                            {{ $heroItem->title ?? 'صورة تُحس قبل أن تُشاهد' }}
                        </h2>
                        <p class="mt-1.5 max-w-lg text-xs leading-6 text-white/70">
                            {{ $heroItem->caption ?? 'نماذج من أعمالنا التي توازن بين الجمال، التنظيم، والتأثير البصري الواضح.' }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- FEATURED --}}
@if(isset($featuredItems) && $featuredItems->count())
<section class="mx-auto max-w-7xl px-6 py-16 lg:px-8">
    <div class="mb-8 flex flex-col gap-3 items-center text-center opacity-0 animate-fade-in-up animate-delay-200">
        <div>
            <p class="mb-2 text-xs font-extrabold uppercase tracking-[0.25em] text-orange-400">أعمال مختارة</p>
            <h2 class="text-2xl font-black sm:text-3xl">مشاريع نحب أن تبدأ بها</h2>
        </div>

        <p class="text-xs leading-7 text-white/65 sm:text-sm">
            مجموعة مختارة من الأعمال التي تعبّر عن أسلوبنا في الإعلانات والفعاليات
            عندما تكون الصورة جزءًا من قيمة المشروع نفسه.
        </p>
    </div>

    <div class="grid gap-5 md:grid-cols-2 xl:grid-cols-3">
        @foreach($featuredItems->take(3) as $item)
            @php
                $coverImage = null;

                if ($item->media_type === 'youtube' && !empty($item->youtube_video_id)) {
                    $coverImage = 'https://img.youtube.com/vi/' . $item->youtube_video_id . '/hqdefault.jpg';
                } elseif (!empty($item->image_path)) {
                    $coverImage = asset($item->image_path);
                }

                $serviceLabel = $categories[$item->service_type] ?? 'أعمال';
                $stagger = ['animate-delay-300', 'animate-delay-400', 'animate-delay-500'][$loop->index % 3];
            @endphp

            <article
                class="portfolio-card group relative overflow-hidden rounded-[24px] border border-white/10 bg-white/5 opacity-0 shadow-[0_20px_50px_rgba(0,0,0,0.35)] transition duration-300 hover:-translate-y-1 hover:border-white/20 animate-fade-in-up {{ $stagger }}"
                data-service="{{ $item->service_type }}"
                data-title="{{ e($item->title) }}"
                data-caption="{{ e($item->caption) }}"
                data-media-type="{{ $item->media_type }}"
                data-image="{{ $item->image_path ? asset($item->image_path) : '' }}"
                data-youtube-id="{{ $item->youtube_video_id }}"
                data-service-label="{{ $serviceLabel }}"
            >
                <button type="button" class="portfolio-open-btn block w-full text-right">
                    <div class="relative h-[320px] w-full overflow-hidden">
                        @if($coverImage)
                            <img src="{{ $coverImage }}"
                                 alt="{{ $item->title }}"
                                 class="h-full w-full object-cover transition duration-700 grayscale group-hover:grayscale-0 group-hover:scale-110">
                        @else
                            <div class="flex h-full w-full items-center justify-center bg-white/5 text-xs font-bold text-white/40">
                                لا توجد صورة
                            </div>
                        @endif

                        <div class="absolute inset-0 bg-gradient-to-t from-black/85 via-black/30 to-transparent"></div>

                        <div class="absolute inset-x-0 top-0 flex items-center justify-between p-4">
                            <div class="inline-flex rounded-full border border-white/10 bg-white/10 px-3 py-1.5 text-[10px] font-extrabold tracking-[0.18em] text-white/70 backdrop-blur">
                                {{ $serviceLabel }}
                            </div>

                            @if($item->media_type === 'youtube' && !empty($item->youtube_video_id))
                                <div class="inline-flex rounded-full border border-orange-500/30 bg-orange-500/10 px-3 py-1.5 text-[10px] font-extrabold tracking-wide text-orange-300">
                                    فيديو
                                </div>
                            @endif
                        </div>

                        <div class="absolute inset-x-0 bottom-0 p-4">
                            <div class="max-w-[85%]">
                                <h3 class="text-lg font-black text-white sm:text-xl">
                                    {{ $item->title }}
                                </h3>

                                @if(!empty($item->caption))
                                    <p class="mt-1 text-xs leading-5 text-white/70 line-clamp-2">
                                        {{ $item->caption }}
                                    </p>
                                @endif
                            </div>

                            <div class="mt-3 inline-flex rounded-full border border-white/15 bg-white/5 px-3 py-1.5 text-[11px] font-extrabold text-white transition group-hover:border-orange-500/40 group-hover:bg-orange-500/10">
                                فتح المعاينة
                            </div>
                        </div>
                    </div>
                </button>
            </article>
        @endforeach
    </div>
</section>
@endif

{{-- FILTERS + GRID --}}
<section id="portfolio-grid" class="mx-auto max-w-7xl px-6 py-16 lg:px-8">
    <div class="mb-8 flex flex-col gap-4 opacity-0 sm:flex-row sm:items-end sm:justify-between animate-fade-in-up animate-delay-200">
        <div>
            <p class="mb-2 text-xs font-extrabold uppercase tracking-[0.25em] text-orange-400">كل الأعمال</p>
            <h2 class="text-2xl font-black sm:text-3xl">نماذج من شغلنا</h2>
        </div>

        <button
            id="randomShotBtn"
            type="button"
            class="inline-flex w-fit rounded-full border border-white/10 bg-white/5 px-4 py-2.5 text-xs font-extrabold text-white/80 transition duration-200 hover:border-orange-500/40 hover:bg-orange-500/10 hover:text-white active:scale-[0.98]"
        >
            اختر عملاً عشوائيًا
        </button>
    </div>

    <div class="mb-8 flex flex-wrap gap-3">
        <button
            class="filter-btn inline-flex rounded-full bg-orange-500 px-5 py-2.5 text-xs font-black text-black transition duration-200 active:scale-[0.98]"
            type="button"
            data-filter="all"
        >
            الكل
        </button>

        @foreach($categories as $key => $label)
            <button
                class="filter-btn inline-flex rounded-full border border-white/15 bg-white/5 px-5 py-2.5 text-xs font-extrabold text-white transition duration-200 hover:border-orange-500/40 hover:bg-orange-500/10 active:scale-[0.98]"
                type="button"
                data-filter="{{ $key }}"
            >
                {{ $label }}
            </button>
        @endforeach
    </div>

    @if(isset($items) && $items->count())
        <div id="portfolioGrid" class="grid gap-5 md:grid-cols-2 xl:grid-cols-3">
            @foreach($items as $item)
                @php
                    $coverImage = null;

                    if ($item->media_type === 'youtube' && !empty($item->youtube_video_id)) {
                        $coverImage = 'https://img.youtube.com/vi/' . $item->youtube_video_id . '/hqdefault.jpg';
                    } elseif (!empty($item->image_path)) {
                        $coverImage = asset($item->image_path);
                    }

                    $serviceLabel = $categories[$item->service_type] ?? 'أعمال';
                @endphp

                <article
                    class="portfolio-card group relative overflow-hidden rounded-[24px] border border-white/10 bg-white/5 shadow-[0_20px_50px_rgba(0,0,0,0.35)] transition duration-300 hover:-translate-y-1 hover:border-white/20"
                    data-service="{{ $item->service_type }}"
                    data-title="{{ e($item->title) }}"
                    data-caption="{{ e($item->caption) }}"
                    data-media-type="{{ $item->media_type }}"
                    data-image="{{ $item->image_path ? asset($item->image_path) : '' }}"
                    data-youtube-id="{{ $item->youtube_video_id }}"
                    data-service-label="{{ $serviceLabel }}"
                >
                    <button type="button" class="portfolio-open-btn block w-full text-right">
                        <div class="relative h-[320px] w-full overflow-hidden">
                            @if($coverImage)
                                <img src="{{ $coverImage }}"
                                     alt="{{ $item->title }}"
                                     class="h-full w-full object-cover transition duration-700 group-hover:grayscale-0 group-hover:scale-110">
                            @else
                                <div class="flex h-full w-full items-center justify-center bg-white/5 text-xs font-bold text-white/40">
                                    لا توجد صورة
                                </div>
                            @endif

                            <div class="absolute inset-0 bg-gradient-to-t from-black/85 via-black/30 to-transparent"></div>

                            <div class="absolute inset-x-0 top-0 flex items-center justify-between p-4">
                                <div class="inline-flex rounded-full border border-white/10 bg-white/10 px-3 py-1.5 text-[10px] font-extrabold tracking-[0.18em] text-white/70 backdrop-blur">
                                    {{ $serviceLabel }}
                                </div>

                                <div class="flex items-center gap-2">
                                    @if(!empty($item->is_featured))
                                        <div class="inline-flex rounded-full border border-orange-500/30 bg-orange-500/10 px-3 py-1.5 text-[10px] font-extrabold tracking-wide text-orange-300">
                                            مميز
                                        </div>
                                    @endif

                                    @if($item->media_type === 'youtube' && !empty($item->youtube_video_id))
                                        <div class="inline-flex rounded-full border border-white/10 bg-white/10 px-3 py-1.5 text-[10px] font-extrabold tracking-wide text-white/75">
                                            فيديو
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <div class="absolute inset-x-0 bottom-0 p-4">
                                <div class="max-w-[85%]">
                                    <h3 class="text-lg font-black text-white sm:text-xl">
                                        {{ $item->title }}
                                    </h3>

                                    @if(!empty($item->caption))
                                        <p class="mt-1 text-xs leading-5 text-white/70 line-clamp-2">
                                            {{ $item->caption }}
                                        </p>
                                    @endif
                                </div>

                                <div class="mt-3 inline-flex rounded-full border border-white/15 bg-white/5 px-3 py-1.5 text-[11px] font-extrabold text-white transition group-hover:border-orange-500/40 group-hover:bg-orange-500/10">
                                    فتح المعاينة
                                </div>
                            </div>
                        </div>
                    </button>
                </article>
            @endforeach
        </div>

        @if($items->count() > 6)
            <div class="mt-8 text-center">
                <button
                    id="loadMoreBtn"
                    type="button"
                    class="inline-flex rounded-full border border-white/15 bg-white/5 px-5 py-2.5 text-xs font-extrabold text-white transition hover:border-orange-500/40 hover:bg-orange-500/10"
                >
                    عرض المزيد
                </button>
            </div>
        @endif
    @else
        <div class="rounded-[24px] border border-white/10 bg-white/5 p-7 text-center text-sm text-white/60">
            لا توجد أعمال منشورة حاليًا. أضف الأعمال من لوحة التحكم لتظهر هنا.
        </div>
    @endif
</section>

{{-- CTA --}}
<section class="mx-auto max-w-7xl px-6 py-16 lg:px-8">
    <div class="relative overflow-hidden rounded-[30px] border border-orange-500/20 bg-gradient-to-br from-orange-500/12 via-white/5 to-white/5 p-7 shadow-[0_30px_90px_rgba(0,0,0,0.4)] sm:p-9">
        <div class="absolute -left-24 top-1/2 h-52 w-52 -translate-y-1/2 rounded-full bg-orange-500/10 blur-3xl"></div>
        <div class="absolute -right-16 top-0 h-36 w-36 rounded-full bg-white/5 blur-3xl"></div>

        <div class="relative z-10 mx-auto max-w-3xl text-center">
            <p class="mb-2 text-[11px] font-extrabold uppercase tracking-[0.25em] text-orange-400">ابدأ الآن</p>
            <h2 class="text-2xl font-black sm:text-3xl">
                هل لديك فكرة تحتاج تنفيذًا بصريًا أنيقًا؟
            </h2>
            <p class="mt-4 text-xs leading-7 text-white/70 sm:text-sm">
                سواء كان مشروعك إعلانًا، فعالية، أو محتوى بصريًا لعلامتك التجارية،
                يمكننا تحويله إلى عمل يليق بالصورة التي تريد تقديمها.
            </p>

            <div class="mt-7 flex flex-wrap items-center justify-center gap-3">
                <a href="/booking"
                   class="inline-flex rounded-full bg-orange-500 px-6 py-3 text-xs font-black text-black transition duration-300 hover:-translate-y-1 hover:bg-orange-400 hover:shadow-[0_0_30px_rgba(249,115,22,0.35)]">
                    احجز الآن
                </a>

                <a href="/services"
                   class="inline-flex rounded-full border border-white/15 bg-white/5 px-6 py-3 text-xs font-extrabold text-white transition duration-300 hover:-translate-y-1 hover:border-orange-500/50 hover:bg-orange-500/10">
                    اكتشف الخدمات
                </a>
            </div>
        </div>
    </div>
</section>

{{-- VIEWER --}}
<div
    id="portfolioViewer"
    class="fixed inset-0 z-[999] hidden bg-black/95 backdrop-blur-sm"
    aria-hidden="true"
>
    <div class="absolute inset-0 flex flex-col">
        <div class="flex items-center justify-between px-4 md:px-8 py-4 border-b border-white/10">
            <div class="text-sm uppercase tracking-[0.2em] text-white/45">
                معرض الاعمال
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
           {{-- زر السهم الأيسر (prev) --}}
<button
    id="prevItem"
    type="button"
    class="absolute left-4 md:left-8 top-1/2 -translate-y-1/2 z-10 w-12 h-12 rounded-full border border-white/15 bg-black/40 text-orange-500 flex items-center justify-center hover:bg-white hover:text-black hover:scale-110 transition"
    aria-label="Previous item"
></button>

{{-- زر السهم الأيمن (next) --}}
<button
    id="nextItem"
    type="button"
    class="absolute right-4 md:right-8 top-1/2 -translate-y-1/2 z-10 w-12 h-12 rounded-full border border-white/15 bg-black/40 text-orange-500 flex items-center justify-center hover:bg-white hover:text-black hover:scale-110 transition"
    aria-label="Next item"
></button>

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