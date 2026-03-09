@extends('layouts.front_tailwind')
@section('title', 'marketing')

@section('content')

{{-- HERO --}}
<section class="relative isolate overflow-hidden border-b border-white/10">
    <div class="absolute inset-0 -z-10">
        <img src="{{ asset('img/hero-marketing.jpg') }}"
             alt="إنتاج الإعلانات"
             class="h-full w-full object-cover opacity-20">
        <div class="absolute inset-0 bg-gradient-to-b from-black/30 via-black/80 to-[#050505]"></div>
        <div class="absolute inset-0 bg-[radial-gradient(circle_at_70%_30%,rgba(255,106,0,0.14),transparent_28%),radial-gradient(circle_at_20%_80%,rgba(255,106,0,0.06),transparent_26%)]"></div>
    </div>

    <div class="mx-auto max-w-7xl px-6 py-20 text-center lg:px-8 lg:py-24">
        <div class="mx-auto max-w-4xl">
            <div class="mb-5 inline-flex items-center gap-2 rounded-full border border-white/10 bg-white/5 px-4 py-2 text-xs font-bold text-white/70 backdrop-blur">
                <span class="h-2 w-2 rounded-full bg-orange-500"></span>
                ONX • Marketing
            </div>

            <h1 class="text-4xl font-black leading-tight text-white sm:text-5xl lg:text-6xl">
                إنتاج الإعلانات
            </h1>

            <p class="mx-auto mt-6 max-w-2xl text-sm leading-8 text-white/70 sm:text-base">
                اشتراك شهري للمحتوى + إعلان حسب الطلب حسب مشروعك.
            </p>

            <div class="mt-8 flex flex-wrap items-center justify-center gap-3">
                <a href="#monthly"
                   class="inline-flex items-center justify-center rounded-full bg-orange-500 px-7 py-3 text-sm font-black text-black transition duration-300 hover:-translate-y-1 hover:bg-orange-400 hover:shadow-[0_0_30px_rgba(249,115,22,0.3)]">
                    الباقات الشهرية
                </a>

                <a href="#custom"
                   class="inline-flex items-center justify-center rounded-full border border-white/15 bg-white/5 px-7 py-3 text-sm font-extrabold text-white transition duration-300 hover:-translate-y-1 hover:border-orange-500/50 hover:bg-orange-500/10">
                    حسب الطلب
                </a>
            </div>
        </div>
    </div>
</section>

{{-- MONTHLY --}}
<section id="monthly" class="mx-auto max-w-7xl px-6 py-20 lg:px-8">
    <div class="mb-10 text-center">
        <h2 class="text-3xl font-black sm:text-4xl">الباقات الشهرية</h2>
        <p class="mx-auto mt-4 max-w-2xl text-sm leading-8 text-white/65 sm:text-base">
            مناسبة للمتاجر والشركات لصناعة محتوى ثابت.
        </p>
    </div>

    <div class="grid gap-6 md:grid-cols-2 xl:grid-cols-3">
        @forelse($monthly as $p)
            <article class="flex flex-col rounded-[22px] border {{ $p->is_featured ? 'border-orange-500/30' : 'border-white/10' }} bg-white/5 p-4 shadow-[0_20px_50px_rgba(0,0,0,0.32)]">
                @if($p->is_featured)
                    <div class="mb-4 inline-flex w-fit self-center rounded-full border border-orange-500/30 bg-orange-500/10 px-4 py-2 text-[11px] font-extrabold tracking-[0.18em] text-orange-300">
                        {{ $p->subtitle ?: 'الأكثر طلبًا' }}
                    </div>
                @else
                    <div class="mb-4 inline-flex w-fit self-center rounded-full border border-white/10 bg-white/10 px-4 py-2 text-[11px] font-extrabold tracking-[0.18em] text-white/70">
                        {{ $p->subtitle ?: 'MONTHLY' }}
                    </div>
                @endif

                <div class="text-center">
                    <h3 class="text-2xl font-black">{{ $p->name }}</h3>
                    <p class="mt-3 text-sm leading-7 text-white/70">{{ $p->description }}</p>
                </div>

                @php
                    $features = is_array($p->features)
                        ? $p->features
                        : (json_decode($p->features ?? '[]', true) ?: []);
                @endphp

                @if(count($features))
                    <div class="mt-6">
                        <div class="features-wrap">
                            <ul class="features-list collapsed space-y-2 text-sm text-white/65" dir="ltr">
                                @foreach($features as $feature)
                                    <li class="flex items-start gap-3 rounded-2xl border border-white/10 bg-black/20 px-4 py-3">
                                        <span class="mt-1 h-2 w-2 rounded-full bg-orange-500"></span>
                                        <span class="text-left leading-6">{{ $feature }}</span>
                                    </li>
                                @endforeach
                            </ul>

                            @if(count($features) > 3)
                                <button
                                    type="button"
                                    class="onx-more-btn mt-3 text-sm font-extrabold text-orange-400 transition hover:text-orange-300"
                                    onclick="toggleFeatures(this)">
                                    عرض المزيد
                                </button>
                            @endif
                        </div>
                    </div>
                @endif

                <div class="mt-auto border-t border-white/10 pt-6 text-center">
                    @if(!is_null($p->old_price) && !is_null($p->price) && (float) $p->old_price > (float) $p->price)
                        <div class="mb-2 text-lg font-bold text-white/35 line-through">
                            {{ number_format((float) $p->old_price, 0) }}
                            <span class="text-sm font-bold text-white/35">DA</span>
                        </div>
                    @endif

                    <div class="mb-3 text-2xl font-black text-white">
                        @if(!is_null($p->price))
                            {{ number_format((float) $p->price, 0) }}
                            <span class="text-base font-bold text-white/50">DA / شهر</span>
                        @else
                            <span class="text-xl">{{ $p->price_note }}</span>
                        @endif
                    </div>

                    <a href="https://wa.me/213540573518?text=سلام%20ONX%20حاب%20اشتراك%20شهري:%20{{ urlencode($p->name) }}"
                       target="_blank"
                       class="inline-flex w-full items-center justify-center rounded-full {{ $p->is_featured ? 'bg-orange-500 text-black hover:bg-orange-400' : 'border border-white/15 bg-white/5 text-white hover:border-orange-500/50 hover:bg-orange-500/10' }} px-6 py-3.5 text-sm font-black transition duration-300">
                        ابدأ الاشتراك
                    </a>
                </div>
            </article>
        @empty
            <div class="rounded-[28px] border border-white/10 bg-white/5 p-8 text-center md:col-span-2 xl:col-span-3">
                <h4 class="text-2xl font-black">لا توجد باقات شهرية بعد</h4>
                <p class="mt-3 text-sm leading-7 text-white/65">
                    أضفها من لوحة التحكم.
                </p>
            </div>
        @endforelse
    </div>
</section>

{{-- CUSTOM --}}
<section id="custom" class="mx-auto max-w-7xl px-6 py-20 lg:px-8">
    <div class="mb-10 text-center">
        <h2 class="text-3xl font-black sm:text-4xl">إعلان حسب الطلب</h2>
        <p class="mx-auto mt-4 max-w-2xl text-sm leading-8 text-white/65 sm:text-base">
            نحسب السعر حسب الفكرة، مدة الفيديو، أيام التصوير…
        </p>
    </div>

    <div class="grid items-start gap-6 lg:grid-cols-2">
        @forelse($custom as $p)
            <article class="self-start rounded-[22px] border {{ $p->is_featured ? 'border-orange-500/30' : 'border-white/10' }} bg-white/5 p-4 shadow-[0_20px_50px_rgba(0,0,0,0.32)]">
                @if($p->is_featured)
                    <div class="mb-4 inline-flex w-fit self-center rounded-full border border-orange-500/30 bg-orange-500/10 px-4 py-2 text-[11px] font-extrabold tracking-[0.18em] text-orange-300">
                        {{ $p->subtitle ?: 'الأكثر طلبًا' }}
                    </div>
                @else
                    <div class="mb-4 inline-flex w-fit self-center rounded-full border border-white/10 bg-white/10 px-4 py-2 text-[11px] font-extrabold tracking-[0.18em] text-white/70">
                        {{ $p->subtitle ?: 'CUSTOM' }}
                    </div>
                @endif

                <div class="text-center">
                    <h3 class="text-xl font-black">{{ $p->name }}</h3>
                    <p class="mt-1 text-sm leading-5 text-white/70">{{ $p->description }}</p>
                </div>

                @php
                    $features = is_array($p->features)
                        ? $p->features
                        : (json_decode($p->features ?? '[]', true) ?: []);
                @endphp

                @if(count($features))
                    <div class="mt-6">
                        <div class="features-wrap">
                            <ul class="features-list collapsed space-y-2 text-sm text-white/65" dir="ltr">
                                @foreach($features as $f)
                                    <li class="flex items-start gap-3 rounded-xl border border-white/10 bg-black/20 px-3 py-2.5">
                                        <span class="mt-1 h-2 w-2 rounded-full bg-orange-500"></span>
                                        <span class="text-left leading-6">{{ $f }}</span>
                                    </li>
                                @endforeach
                            </ul>

                            @if(count($features) > 3)
                                <button
                                    type="button"
                                    class="onx-more-btn mt-3 text-sm font-extrabold text-orange-400 transition hover:text-orange-300"
                                    onclick="toggleFeatures(this)">
                                    عرض المزيد
                                </button>
                            @endif
                        </div>
                    </div>
                @endif

                <div class="mt-6 border-t border-white/10 pt-6 text-center">
                    @if(!is_null($p->old_price) && !is_null($p->price) && (float) $p->old_price > (float) $p->price)
                        <div class="mb-2 text-lg font-bold text-white/35 line-through">
                            {{ number_format((float) $p->old_price, 0) }}
                            <span class="text-sm font-bold text-white/35">DA</span>
                        </div>
                    @endif

                    <div class="mb-4 text-xl font-black text-white">
                        @if(!is_null($p->price))
                            {{ number_format((float) $p->price, 0) }} DA
                        @else
                            {{ $p->price_note ?: 'حسب الطلب' }}
                        @endif
                    </div>

                    <a href="https://wa.me/213540573518?text=سلام%20ONX%20حاب%20عرض%20سعر%20إعلان:%20{{ urlencode($p->name) }}"
                       target="_blank"
                       class="inline-flex w-full items-center justify-center rounded-full {{ $p->is_featured ? 'bg-orange-500 text-black hover:bg-orange-400' : 'border border-white/15 bg-white/5 text-white hover:border-orange-500/50 hover:bg-orange-500/10' }} px-6 py-3.5 text-sm font-black transition duration-300">
                        اطلب عرض سعر
                    </a>
                </div>
            </article>
        @empty
            <div class="rounded-[28px] border border-white/10 bg-white/5 p-8 text-center lg:col-span-2">
                <h4 class="text-2xl font-black">لا توجد عروض حسب الطلب بعد</h4>
                <p class="mt-3 text-sm leading-7 text-white/65">
                    أضفها من لوحة التحكم.
                </p>
            </div>
        @endforelse
    </div>
</section>

{{-- MARKETING WORKS --}}
@if(isset($marketingWorks) && $marketingWorks->count())
<section class="mx-auto max-w-7xl px-6 py-20 lg:px-8">
    <div class="mb-10 flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
        <div>
            <p class="mb-3 text-sm font-extrabold uppercase tracking-[0.25em] text-orange-400">نماذج من الأعمال الإعلانية</p>
            <h2 class="text-3xl font-black sm:text-4xl">إعلانات تحمل حضورًا بصريًا حقيقيًا</h2>
            <p class="mt-4 max-w-2xl text-sm leading-8 text-white/65 sm:text-base">
                أمثلة مختارة من أعمال ONX الإعلانية المصممة لتجذب الانتباه وتخدم الرسالة.
            </p>
        </div>

        <a href="/portfolio"
           class="inline-flex w-fit rounded-full border border-white/10 bg-white/5 px-5 py-3 text-sm font-extrabold text-white/80 transition hover:border-orange-500/40 hover:bg-orange-500/10 hover:text-white">
            شاهد المزيد
        </a>
    </div>

    <div class="grid gap-6 md:grid-cols-2 xl:grid-cols-3">
        @foreach($marketingWorks->take(3) as $item)
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
                        <img src="{{ $coverImage }}"
                             alt="{{ $item->title }}"
                             class="h-full w-full object-cover transition duration-700 group-hover:scale-110">
                    @else
                        <div class="flex h-full w-full items-center justify-center bg-white/5 text-sm font-bold text-white/40">
                            لا توجد صورة
                        </div>
                    @endif

                    <div class="absolute inset-0 bg-gradient-to-t from-black/85 via-black/30 to-transparent"></div>

                    <div class="absolute inset-x-0 bottom-0 p-5">
                        <div class="max-w-[80%]">
                            <div class="text-[10px] font-extrabold tracking-[0.22em] text-orange-400">
                                BRAND WORK
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

                        @if($item->media_type === 'youtube' && !empty($item->youtube_video_id))
    <button
        type="button"
        onclick="openVideoModal('{{ $item->youtube_video_id }}')"
        class="absolute inset-0 z-10 flex items-center justify-center bg-black/10 transition duration-300 hover:bg-black/20"
        aria-label="تشغيل الفيديو"
    >
        <span class="flex h-20 w-20 items-center justify-center rounded-full bg-white/20 backdrop-blur border border-white/20 shadow-[0_10px_30px_rgba(0,0,0,0.35)]">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-white mr-1" viewBox="0 0 24 24" fill="currentColor">
                <path d="M8 5.14v14l11-7-11-7z"/>
            </svg>
        </span>
    </button>
@endif
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</section>
@endif

{{-- CTA --}}
<section class="mx-auto max-w-7xl px-6 py-20 lg:px-8">
    <div class="relative overflow-hidden rounded-[34px] border border-orange-500/20 bg-gradient-to-br from-orange-500/12 via-white/5 to-white/5 p-8 shadow-[0_30px_90px_rgba(0,0,0,0.4)] sm:p-10">
        <div class="absolute -left-24 top-1/2 h-52 w-52 -translate-y-1/2 rounded-full bg-orange-500/10 blur-3xl"></div>
        <div class="absolute -right-16 top-0 h-36 w-36 rounded-full bg-white/5 blur-3xl"></div>

        <div class="relative z-10 grid gap-6 lg:grid-cols-[1fr_auto] lg:items-center">
            <div class="text-center lg:text-right">
                <h3 class="text-3xl font-black">حاب إعلان احترافي يبيع؟</h3>
                <p class="mt-4 text-sm leading-8 text-white/70 sm:text-base">
                    أرسل الفكرة ونقترح عليك السيناريو والمدة الأنسب.
                </p>
            </div>

            <div class="flex flex-wrap items-center justify-center gap-3 lg:justify-start">
                <a href="tel:+213540573518"
                   class="inline-flex rounded-full border border-white/15 bg-white/5 px-6 py-3 text-sm font-extrabold text-white transition duration-300 hover:-translate-y-1 hover:border-orange-500/50 hover:bg-orange-500/10">
                    اتصال
                </a>

                <a href="https://wa.me/213540573518"
                   target="_blank"
                   class="inline-flex rounded-full bg-orange-500 px-6 py-3 text-sm font-black text-black transition duration-300 hover:-translate-y-1 hover:bg-orange-400 hover:shadow-[0_0_30px_rgba(249,115,22,0.35)]">
                    واتساب
                </a>
            </div>
        </div>
    </div>
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
</section>

@endsection

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
function toggleFeatures(btn) {
    const wrap = btn.closest('.features-wrap');
    const list = wrap.querySelector('.features-list');

    if (list.classList.contains('collapsed')) {
        list.classList.remove('collapsed');
        list.classList.add('expanded');
        btn.textContent = 'إخفاء';
    } else {
        list.classList.remove('expanded');
        list.classList.add('collapsed');
        btn.textContent = 'عرض المزيد';
    }
}
</script>
@endpush