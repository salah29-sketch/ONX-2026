@foreach($items as $item)
    @php
        $cover = null;
        if ($item->media_type === 'youtube' && $item->youtube_video_id) {
            $cover = 'https://img.youtube.com/vi/' . $item->youtube_video_id . '/hqdefault.jpg';
        } elseif ($item->image_path) {
            $cover = asset($item->image_path);
        }

        $catLabel     = $categories[$item->category] ?? $item->category;
        $serviceLabel = $item->service_type === 'ads' ? 'BRAND WORK' : 'EVENT STORY';
    @endphp

    <div class="group relative overflow-hidden rounded-[24px] border border-white/10 bg-white/5 shadow-[0_20px_50px_rgba(0,0,0,0.35)] transition duration-500 hover:-translate-y-2 hover:border-orange-500/30">
        <div class="relative h-[300px] w-full overflow-hidden">

            @if($cover)
                <img src="{{ $cover }}"
                     alt="{{ $item->title }}"
                     class="h-full w-full object-cover transition duration-700 group-hover:scale-110">
            @else
                <div class="flex h-full w-full items-center justify-center bg-white/5 text-xs text-white/30">
                    لا توجد صورة
                </div>
            @endif

            <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/25 to-transparent"></div>

            {{-- يوتيوب أيقونة --}}
            @if($item->media_type === 'youtube')
                <div class="absolute inset-0 flex items-center justify-center opacity-0 transition duration-300 group-hover:opacity-100">
                    <div class="flex h-14 w-14 items-center justify-center rounded-full bg-orange-500/90 shadow-[0_0_30px_rgba(249,115,22,0.5)]">
                        <svg class="ml-1 h-5 w-5 text-black" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M8 5v14l11-7z"/>
                        </svg>
                    </div>
                </div>
            @endif

            <div class="absolute inset-x-0 bottom-0 p-4">
                <div class="flex items-center gap-2 mb-1.5">
                    <span class="text-[9px] font-extrabold tracking-[0.22em] text-orange-400 uppercase">{{ $serviceLabel }}</span>
                    <span class="text-white/20">•</span>
                    <span class="text-[9px] font-extrabold tracking-wide text-white/50 uppercase">{{ $catLabel }}</span>
                </div>

                <h3 class="text-base font-black text-white">{{ $item->title }}</h3>

                @if($item->caption)
                    <p class="mt-1 text-xs leading-5 text-white/60 line-clamp-2">{{ $item->caption }}</p>
                @endif

                @if($item->media_type === 'youtube' && $item->youtube_url)
                    <a href="{{ $item->youtube_url }}" target="_blank"
                       class="mt-3 inline-flex rounded-full border border-white/15 bg-white/5 px-3 py-1.5 text-[11px] font-extrabold text-white transition hover:border-orange-500/40 hover:bg-orange-500/10">
                        مشاهدة الفيديو ←
                    </a>
                @endif
            </div>
        </div>
    </div>
@endforeach