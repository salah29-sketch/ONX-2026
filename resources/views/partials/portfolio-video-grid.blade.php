@php
    $sectionId = $sectionId ?? 'portfolio-section';
    $title = $title ?? 'نماذج من الأعمال';
    $subtitle = $subtitle ?? 'أعمال مختارة';
    $description = $description ?? 'نماذج مختارة من الأعمال.';
    $items = $items ?? collect();
    $brandLabel = $brandLabel ?? 'WORK';
@endphp

@if(isset($items) && $items->count())
<section id="{{ $sectionId }}" class="mx-auto max-w-7xl px-6 py-20 lg:px-8">
    <div class="mb-10 flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
        <div>
            <p class="mb-3 text-sm font-extrabold uppercase tracking-[0.25em] text-orange-400">
                {{ $subtitle }}
            </p>

            <h2 class="text-3xl font-black sm:text-4xl">
                {{ $title }}
            </h2>

            <p class="mt-4 max-w-2xl text-sm leading-8 text-white/65 sm:text-base">
                {{ $description }}
            </p>
        </div>

        <a href="/portfolio"
           class="inline-flex w-fit rounded-full border border-white/10 bg-white/5 px-5 py-3 text-sm font-extrabold text-white/80 transition hover:border-orange-500/40 hover:bg-orange-500/10 hover:text-white">
            شاهد المزيد
        </a>
    </div>

    <div class="grid gap-6 md:grid-cols-2 xl:grid-cols-3">
        @foreach($items->take(3) as $item)
            @php
                $coverImage = null;

                if ($item->media_type === 'youtube' && !empty($item->youtube_video_id)) {
                    $coverImage = 'https://img.youtube.com/vi/' . $item->youtube_video_id . '/hqdefault.jpg';
                } elseif (!empty($item->image_path)) {
                    $coverImage = asset($item->image_path);
                }
            @endphp

            <div class="group relative overflow-hidden rounded-[28px] border border-white/10 bg-white/5 shadow-[0_20px_50px_rgba(0,0,0,0.35)]">
                <div class="relative h-[380px] w-full overflow-hidden">

                    @if($coverImage)
                        <img
                            src="{{ $coverImage }}"
                            alt="{{ $item->title }}"
                            class="h-full w-full object-cover transition duration-700 group-hover:scale-110 {{ $item->media_type === 'youtube' ? 'blur-[1.5px]' : '' }}"
                        >
                    @else
                        <div class="flex h-full w-full items-center justify-center bg-white/5 text-sm font-bold text-white/40">
                            لا توجد صورة
                        </div>
                    @endif

                    @if($item->media_type === 'youtube' && !empty($item->youtube_video_id))
                        <div class="absolute inset-0 bg-black/30 backdrop-blur-[2px]"></div>

                        <button
                            type="button"
                            onclick="openVideoModal('{{ $item->youtube_video_id }}')"
                            class="absolute inset-0 z-20 flex items-center justify-center"
                            aria-label="تشغيل الفيديو"
                        >
                            <span class="flex h-24 w-24 items-center justify-center rounded-full border border-white/20 bg-black/40 backdrop-blur-md shadow-[0_20px_40px_rgba(0,0,0,0.45)] transition duration-300 hover:scale-110">
                                <svg xmlns="http://www.w3.org/2000/svg"
                                     class="h-10 w-10 text-white ml-1"
                                     viewBox="0 0 24 24"
                                     fill="currentColor">
                                    <path d="M8 5.14v14l11-7-11-7z"/>
                                </svg>
                            </span>
                        </button>
                    @endif

                    <div class="absolute inset-0 bg-gradient-to-t from-black/85 via-black/30 to-transparent"></div>

                    <div class="absolute inset-x-0 bottom-0 z-30 p-5">
                        <div class="max-w-[80%]">
                            <div class="text-[10px] font-extrabold tracking-[0.22em] text-orange-400">
                                {{ $brandLabel }}
                            </div>

                            <h3 class="mt-2 text-xl font-black text-white sm:text-2xl">
                                {{ $item->title }}
                            </h3>

                            @if(!empty($item->caption))
                                <p class="mt-1 text-sm leading-6 text-white/70">
                                    {{ $item->caption }}
                                </p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</section>
@endif

<div
    id="videoModal"
    class="fixed inset-0 z-[9999] hidden items-center justify-center bg-black/80 p-4 backdrop-blur-sm"
>
    <div class="relative w-full max-w-5xl">
        <button
            type="button"
            onclick="closeVideoModal()"
            class="absolute -top-12 left-0 inline-flex h-10 w-10 items-center justify-center rounded-full bg-white/10 text-white transition hover:bg-white/20"
            aria-label="إغلاق"
        >
            ✕
        </button>

        <div class="relative overflow-hidden rounded-[24px] border border-white/10 bg-black shadow-[0_20px_60px_rgba(0,0,0,0.45)]" style="padding-top:56.25%;">
            <iframe
                id="videoFrame"
                class="absolute inset-0 h-full w-full"
                src=""
                title="YouTube video player"
                frameborder="0"
                allow="autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                allowfullscreen
            ></iframe>
        </div>
    </div>
</div>

@once
    @push('scripts')
    <script>
        function openVideoModal(videoId) {
            const modal = document.getElementById('videoModal');
            const frame = document.getElementById('videoFrame');

            frame.src = `https://www.youtube-nocookie.com/embed/${videoId}?autoplay=1&rel=0`;
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            document.body.style.overflow = 'hidden';
        }

        function closeVideoModal() {
            const modal = document.getElementById('videoModal');
            const frame = document.getElementById('videoFrame');

            frame.src = '';
            modal.classList.add('hidden');
            modal.classList.remove('flex');
            document.body.style.overflow = '';
        }

        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape') {
                closeVideoModal();
            }
        });

        document.addEventListener('click', function (e) {
            const modal = document.getElementById('videoModal');

            if (e.target === modal) {
                closeVideoModal();
            }
        });
    </script>
    @endpush
@endonce