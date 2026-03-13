@extends('layouts.front_tailwind')
@section('title', 'Events')

@section('content')

<div x-data="eventsCompare()" x-init="init()">

{{-- HERO --}}
<section class="relative isolate overflow-hidden border-b border-white/10">
    <div class="absolute inset-0 -z-10">
        <img src="{{ asset('img/hero-events.jpg') }}"
             alt="باقات تصوير الحفلات"
             class="h-full w-full object-cover opacity-20">
        <div class="absolute inset-0 bg-gradient-to-b from-black/30 via-black/80 to-[#050505]"></div>
        <div class="absolute inset-0 bg-[radial-gradient(circle_at_70%_30%,rgba(255,106,0,0.14),transparent_28%),radial-gradient(circle_at_20%_80%,rgba(255,106,0,0.06),transparent_26%)]"></div>
    </div>

    <div class="mx-auto max-w-7xl px-6 py-20 text-center lg:px-8 lg:py-24">
        <div class="mx-auto max-w-4xl">
            <div class="mb-5 inline-flex items-center gap-2 rounded-full border border-white/10 bg-white/5 px-4 py-2 text-xs font-bold text-white/70 opacity-0 backdrop-blur animate-fade-in-up">
                <span class="h-2 w-2 rounded-full bg-orange-500"></span>
                ONX • Events
            </div>

            <h1 class="text-4xl font-black leading-tight text-white opacity-0 sm:text-5xl lg:text-6xl animate-fade-in-up animate-delay-100">
                باقات تصوير الحفلات
            </h1>

            <p class="mx-auto mt-6 max-w-2xl text-sm leading-8 text-white/70 opacity-0 sm:text-base animate-fade-in-up animate-delay-200">
                نوثّق لحظاتكم بأفضل جودة سينمائية. اختر الباقة المناسبة واترك الباقي علينا.
            </p>

            <div class="mt-8 flex flex-wrap items-center justify-center gap-3 opacity-0 animate-fade-in-up animate-delay-300">
                <a href="#Packages"
                   class="inline-flex items-center justify-center rounded-full bg-orange-500 px-7 py-3 text-sm font-black text-black transition duration-300 hover:-translate-y-1 hover:bg-orange-400 hover:shadow-[0_0_30px_rgba(249,115,22,0.3)] active:scale-[0.98]">
                    مشاهدة الباقات
                </a>

                <a href="https://wa.me/213540573518?text=سلام%20ONX%20حاب%20نستفسر%20على%20باقات%20تصوير%20الحفلات"
                   target="_blank"
                   class="inline-flex items-center justify-center rounded-full border border-white/15 bg-white/5 px-7 py-3 text-sm font-extrabold text-white transition duration-300 hover:-translate-y-1 hover:border-orange-500/50 hover:bg-orange-500/10 active:scale-[0.98]">
                    واتساب
                </a>
            </div>

            @if($travelNote)
            <div class="mt-6 opacity-0 animate-fade-in-up animate-delay-400">
                <p class="inline-flex items-center gap-2 border border-orange-500/30 bg-orange-500/10 text-orange-300 text-sm px-4 py-2 rounded-full">
                    <span>🚗</span> {{ $travelNote }}
                </p>
            </div>
            @endif
        </div>
    </div>
</section>



{{-- Packages --}}
<section id="Packages" class="mx-auto max-w-7xl px-6 py-20 lg:px-8">
    <div class="mb-10 text-center">
        <h2 class="text-3xl font-black sm:text-4xl">الباقات</h2>
        <p class="mx-auto mt-4 max-w-2xl text-sm leading-8 text-white/65 sm:text-base">
            اختر الباقة المناسبة — رسوم إضافية للتنقل خارج الولاية.
        </p>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 items-start">
        @forelse($Packages as $pkg)
        @php
            $pkgFeatures = is_array($pkg->features)
                ? $pkg->features
                : (json_decode($pkg->features, true) ?? []);
        @endphp

        <article class="rounded-[30px] border bg-white/5 backdrop-blur p-6 flex flex-col shadow-[0_20px_50px_rgba(0,0,0,0.32)] transition duration-300 hover:-translate-y-1
                        {{ $pkg->is_featured ? 'border-orange-500/50 shadow-[0_0_30px_rgba(249,115,22,0.15)]' : 'border-white/10' }}"
                 :class="{ 'border-blue-400 shadow-[0_0_30px_rgba(59,130,246,0.2)]': isIn({{ $pkg->id }}) }">

            {{-- Badge --}}
            @if($pkg->is_featured)
                <div class="mb-4 inline-flex w-fit self-center">
                    <span class="px-4 py-2 rounded-full text-[11px] font-black tracking-[0.18em]"
                          style="background:linear-gradient(135deg,#D4AF37,#F5D060);color:#1a1a1a">
                        ⭐ {{ $pkg->subtitle ?: 'الأكثر طلبًا' }}
                    </span>
                </div>
            @else
                <div class="mb-4 inline-flex w-fit self-center rounded-full border border-white/10 bg-white/10 px-4 py-2 text-[11px] font-extrabold tracking-[0.18em] text-white/70">
                    {{ $pkg->subtitle ?: 'PACKAGE' }}
                </div>
            @endif

            {{-- الاسم والوصف --}}
            <div class="text-center mb-6">
                <h3 class="text-2xl font-black text-white">{{ $pkg->name }}</h3>
                @if($pkg->description)
                <p class="mt-3 text-sm leading-7 text-white/70">{{ $pkg->description }}</p>
                @endif
            </div>

            {{-- السعر --}}
            <div class="mb-6 text-center">
                @if(!is_null($pkg->old_price) && (float)$pkg->old_price > (float)$pkg->price)
                    <div class="mb-1 text-lg font-bold text-white/35 line-through">
                        {{ number_format((float)$pkg->old_price) }}
                        <span class="text-sm">DA</span>
                    </div>
                @endif
                <div class="flex items-baseline justify-center gap-2">
                    <span class="text-3xl font-black text-white">
                        {{ $pkg->price !== null ? number_format((float)$pkg->price) : '—' }}
                    </span>
                    <span class="text-white/50 text-sm">DA</span>
                </div>
            </div>

            {{-- المميزات مع ✓ / ✕ --}}
            <div class="features-wrap mb-6 flex-1">
                <ul class="features-list collapsed space-y-2.5">
                    @foreach($allFeatures as $feature)
                    @php $has = in_array($feature, $pkgFeatures); @endphp
                    <li class="flex items-center justify-between text-sm gap-3 rounded-2xl border border-white/10 bg-black/20 px-4 py-3
                               {{ $has ? 'text-white/80' : 'text-white/30' }}">
                        <span>{{ $feature }}</span>
                        @if($has)
                            <span class="text-orange-400 shrink-0 font-black">✓</span>
                        @else
                            <span class="text-white/20 shrink-0">✕</span>
                        @endif
                    </li>
                    @endforeach
                </ul>
                @if(count($allFeatures) > 5)
                    <button type="button"
                            class="onx-more-btn mt-3 text-sm font-extrabold text-orange-400 transition hover:text-orange-300"
                            onclick="toggleFeatures(this)">
                        عرض المزيد
                    </button>
                @endif
            </div>

            {{-- الأزرار --}}
            <div class="mt-auto space-y-2 border-t border-white/10 pt-6">
                <a href="{{ route('booking') }}?package_id={{ $pkg->id }}&type=event"
                   class="block w-full text-center py-3.5 rounded-full font-black text-sm transition duration-300
                          {{ $pkg->is_featured
                              ? 'bg-orange-500 hover:bg-orange-400 text-black hover:shadow-[0_0_30px_rgba(249,115,22,0.3)]'
                              : 'border border-white/15 bg-white/5 text-white hover:border-orange-500/50 hover:bg-orange-500/10' }}">
                    احجز الآن
                </a>
                <button type="button"
                        @click="toggle({{ $pkg->id }}, '{{ addslashes($pkg->name) }}', {{ $pkg->price ?? 'null' }}, {{ $pkg->is_featured ? 'true' : 'false' }}, {{ json_encode($pkgFeatures) }})"
                        class="block w-full text-center py-2.5 rounded-full font-bold text-sm border transition duration-300"
                        :class="isIn({{ $pkg->id }})
                            ? 'border-blue-400/50 bg-blue-500/10 text-blue-300'
                            : 'border-white/10 bg-white/5 text-white/50 hover:border-white/20 hover:text-white/70'">
                    <span x-text="isIn({{ $pkg->id }}) ? '✓ تمت الإضافة للمقارنة' : '+ قارن هذه الباقة'"></span>
                </button>
            </div>
        </article>
        @empty
            <div class="rounded-[28px] border border-white/10 bg-white/5 p-8 text-center sm:col-span-2 lg:col-span-3">
                <h4 class="text-2xl font-black">لا توجد باقات بعد</h4>
                <p class="mt-3 text-sm leading-7 text-white/65">أضف الباقات من لوحة التحكم (Admin).</p>
            </div>
        @endforelse
    </div>

    {{-- زر عرض المقارنة المركزي --}}
    <div x-show="compareList.length >= 2"
         x-cloak
         x-transition
         class="mt-8 flex justify-center">
        <button @click="showModal = true"
                class="inline-flex items-center gap-2 rounded-full bg-orange-500 px-6 py-3 text-sm font-black text-black shadow-[0_0_20px_rgba(249,115,22,0.3)] transition duration-300 hover:bg-orange-400 hover:-translate-y-0.5">
            <span>⚖️</span>
            عرض مقارنة الباقات
            <span class="flex h-5 w-5 items-center justify-center rounded-full bg-black/20 text-xs font-black" x-text="compareList.length"></span>
        </button>
    </div>
</section>

{{-- HOW WE WORK --}}
<section class="mx-auto max-w-7xl px-6 py-20 lg:px-8">
    <div class="mb-8 text-center">
        <h2 class="text-3xl font-black sm:text-4xl">كيف نشتغل؟</h2>
        <p class="mt-4 text-sm leading-8 text-white/65 sm:text-base">
            خطوات بسيطة من الطلب إلى التسليم.
        </p>
    </div>

    <div class="grid gap-4 md:grid-cols-3">
        <div class="rounded-[24px] border border-white/10 bg-white/5 p-6 text-center">
            <div class="mx-auto mb-4 flex h-12 w-12 items-center justify-center rounded-full bg-orange-500 text-lg font-black text-black">1</div>
            <h3 class="text-lg font-black">اختيار الباقة</h3>
            <p class="mt-3 text-sm leading-7 text-white/65">حدد الباقة وموعد الحفل.</p>
        </div>

        <div class="rounded-[24px] border border-white/10 bg-white/5 p-6 text-center">
            <div class="mx-auto mb-4 flex h-12 w-12 items-center justify-center rounded-full bg-orange-500 text-lg font-black text-black">2</div>
            <h3 class="text-lg font-black">تأكيد الحجز</h3>
            <p class="mt-3 text-sm leading-7 text-white/65">نأكد المكان والتفاصيل معك.</p>
        </div>

        <div class="rounded-[24px] border border-white/10 bg-white/5 p-6 text-center">
            <div class="mx-auto mb-4 flex h-12 w-12 items-center justify-center rounded-full bg-orange-500 text-lg font-black text-black">3</div>
            <h3 class="text-lg font-black">التسليم</h3>
            <p class="mt-3 text-sm leading-7 text-white/65">مونتاج وتسليم حسب الباقة.</p>
        </div>
    </div>
</section>

{{-- EVENT WORKS --}}
@include('partials.portfolio-works-grid', [
    'items' => $eventWorks,
    'sectionSubtitle' => 'نماذج من أعمال الحفلات',
    'sectionTitle' => 'لقطات من أجواء حقيقية',
    'sectionDescription' => 'نظرة سريعة على أعمال مختارة من حفلات ومناسبات وثّقناها بأسلوب ONX.',
    'badgeText' => 'EVENT STORY',
])

{{-- TERMS + WHY --}}
<section class="mx-auto max-w-7xl px-6 py-20 lg:px-8">
    <div class="grid gap-6 lg:grid-cols-2">
        <div class="rounded-[30px] border border-white/10 bg-white/5 p-7 shadow-[0_20px_50px_rgba(0,0,0,0.28)]">
            <h3 class="text-2xl font-black">الشروط</h3>

            <div class="mt-6 space-y-4">
                <div class="rounded-[20px] border border-white/10 bg-black/20 p-4">
                    <div class="font-black text-white">التنقل خارج الولاية</div>
                    <div class="mt-2 text-sm leading-7 text-white/65">خارج سيدي بلعباس: تُضاف رسوم تنقل حسب الولاية.</div>
                </div>

                <div class="rounded-[20px] border border-white/10 bg-black/20 p-4">
                    <div class="font-black text-white">تأكيد الحجز</div>
                    <div class="mt-2 text-sm leading-7 text-white/65">يتم تأكيد الحجز بعد تحديد التاريخ والمكان.</div>
                </div>

                <div class="rounded-[20px] border border-white/10 bg-black/20 p-4">
                    <div class="font-black text-white">مدة التسليم</div>
                    <div class="mt-2 text-sm leading-7 text-white/65">تختلف حسب الباقة (مذكورة داخل كل باقة).</div>
                </div>

                <div class="rounded-[20px] border border-white/10 bg-black/20 p-4">
                    <div class="font-black text-white">إضافات اختيارية</div>
                    <div class="mt-2 text-sm leading-7 text-white/65">Drone / Reels ممكنة حسب توفر المكان.</div>
                </div>
            </div>
        </div>

        <div class="rounded-[30px] border border-white/10 bg-white/5 p-7 shadow-[0_20px_50px_rgba(0,0,0,0.28)]">
            <h3 class="text-2xl font-black">لماذا ONX؟</h3>

            <div class="mt-6 space-y-4">
                <div class="rounded-[20px] border border-white/10 bg-black/20 p-4">
                    <div class="font-black text-white">🎬 جودة سينمائية</div>
                    <div class="mt-2 text-sm leading-7 text-white/65">إضاءة وصوت ومعدات تعطي لقطة "فيلم".</div>
                </div>

                <div class="rounded-[20px] border border-white/10 bg-black/20 p-4">
                    <div class="font-black text-white">⚡ تنظيم واحتراف</div>
                    <div class="mt-2 text-sm leading-7 text-white/65">نشتغل بخطة واضحة قبل الحفل وأثناءه.</div>
                </div>

                <div class="rounded-[20px] border border-white/10 bg-black/20 p-4">
                    <div class="font-black text-white">✨ مونتاج نظيف</div>
                    <div class="mt-2 text-sm leading-7 text-white/65">تلوين خفيف + إيقاع مناسب للحفل.</div>
                </div>

                <div class="rounded-[20px] border border-white/10 bg-black/20 p-4">
                    <div class="font-black text-white">🤝 تواصل واضح</div>
                    <div class="mt-2 text-sm leading-7 text-white/65">نرد بسرعة ونبقى معك حتى بعد التسليم.</div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- CTA --}}
<section class="mx-auto max-w-7xl px-6 py-20 lg:px-8">
    <div class="relative overflow-hidden rounded-[34px] border border-orange-500/20 bg-gradient-to-br from-orange-500/12 via-white/5 to-white/5 p-8 shadow-[0_30px_90px_rgba(0,0,0,0.4)] sm:p-10">
        <div class="absolute -left-24 top-1/2 h-52 w-52 -translate-y-1/2 rounded-full bg-orange-500/10 blur-3xl"></div>
        <div class="absolute -right-16 top-0 h-36 w-36 rounded-full bg-white/5 blur-3xl"></div>

        <div class="relative z-10 grid gap-6 lg:grid-cols-[1fr_auto] lg:items-center">
            <div class="text-center lg:text-right">
                <h3 class="text-3xl font-black">جاهز نحجز لك الموعد؟</h3>
                <p class="mt-4 text-sm leading-8 text-white/70 sm:text-base">
                    تواصل معنا الآن، ونقترح لك الباقة الأنسب.
                </p>
            </div>

            <div class="flex flex-wrap items-center justify-center gap-3 lg:justify-start">
                <a href="tel:+213540573518"
                   class="inline-flex rounded-full border border-white/15 bg-white/5 px-6 py-3 text-sm font-extrabold text-white transition duration-300 hover:-translate-y-1 hover:border-orange-500/50 hover:bg-orange-500/10">
                    اتصال
                </a>

                <a href="https://wa.me/213540573518?text=سلام%20ONX%20حاب%20نحجز%20تصوير%20حفلة"
                   target="_blank"
                   class="inline-flex rounded-full border border-white/15 bg-white/5 px-6 py-3 text-sm font-extrabold text-white transition duration-300 hover:-translate-y-1 hover:border-orange-500/50 hover:bg-orange-500/10">
                    واتساب
                </a>

                <a href="{{ route('booking') }}"
                   class="inline-flex rounded-full bg-orange-500 px-6 py-3 text-sm font-black text-black transition duration-300 hover:-translate-y-1 hover:bg-orange-400 hover:shadow-[0_0_30px_rgba(249,115,22,0.35)]">
                    Booking
                </a>
            </div>
        </div>
    </div>
</section>

{{-- Modal المقارنة --}}
<div x-show="showModal"
     x-cloak
     @keydown.escape.window="showModal = false"
     class="fixed inset-0 z-50 flex items-center justify-center p-3 bg-black/80 backdrop-blur-sm">

    <div @click.outside="showModal = false"
         class="bg-[#0f0f0f] border border-white/10 rounded-[20px] shadow-2xl w-full max-w-3xl">

        {{-- Header --}}
        <div class="flex items-center justify-between px-4 py-3 border-b border-white/10">
            <h3 class="text-base font-black text-white">مقارنة الباقات</h3>
            <button @click="showModal = false" class="text-white/40 hover:text-white text-xl leading-none">×</button>
        </div>

        {{-- Table --}}
        <div class="overflow-x-auto">
            <table class="w-full text-xs text-right border-collapse">
                <thead>
                    <tr>
                        <th class="px-3 py-2 text-right text-white/50 font-bold bg-white/5 w-[40%]">الخاصية</th>
                        <template x-for="p in compareList" :key="p.id">
                            <th class="px-3 py-2 text-center text-white bg-white/5 font-black" x-text="p.name"></th>
                        </template>
                    </tr>
                </thead>
                <tbody>
                    <tr class="border-b border-white/5">
                        <td class="px-3 py-2 font-bold text-white/60">💰 السعر</td>
                        <template x-for="p in compareList" :key="p.id">
                            <td class="px-3 py-2 text-center font-black text-orange-400"
                                x-text="p.price ? Number(p.price).toLocaleString('ar-DZ') + ' دج' : 'حسب الطلب'"></td>
                        </template>
                    </tr>
                    <template x-for="feat in allModalFeatures" :key="feat">
                        <tr class="border-b border-white/5">
                            <td class="px-3 py-2 text-white/60" x-text="feat"></td>
                            <template x-for="p in compareList" :key="p.id">
                                <td class="px-3 py-2 text-center text-sm"
                                    x-text="p.features.includes(feat) ? '✅' : '❌'"></td>
                            </template>
                        </tr>
                    </template>
                </tbody>
            </table>
        </div>

        {{-- Footer --}}
        <div class="px-4 py-3 border-t border-white/10 flex flex-wrap gap-2 justify-end">
            <template x-for="p in compareList" :key="p.id">
                <a :href="`{{ route('booking') }}?package_id=${p.id}&type=event`"
                   class="bg-orange-500 hover:bg-orange-400 text-black px-5 py-2 rounded-full font-black text-xs transition-all">
                    احجز <span x-text="p.name"></span>
                </a>
            </template>
            <button @click="clear()"
                    class="border border-white/15 text-white/50 hover:text-red-400 hover:border-red-400/30 px-5 py-2 rounded-full font-bold text-xs transition-all">
                مسح الكل
            </button>
        </div>
    </div>
</div>

{{-- Video Modal --}}
<div id="videoModal" class="fixed inset-0 z-[9999] hidden items-center justify-center bg-black/80 p-4 backdrop-blur-sm">
    <div class="relative w-full max-w-5xl">
        <button type="button" onclick="closeVideoModal()"
                class="absolute -top-12 left-0 inline-flex h-10 w-10 items-center justify-center rounded-full bg-white/10 text-white transition hover:bg-white/20"
                aria-label="إغلاق">✕</button>
        <div class="relative overflow-hidden rounded-[24px] border border-white/10 bg-black shadow-[0_20px_60px_rgba(0,0,0,0.45)]" style="padding-top:56.25%;">
            <iframe id="videoFrame" class="absolute inset-0 h-full w-full" src=""
                    title="YouTube video player" frameborder="0"
                    allow="autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                    allowfullscreen></iframe>
        </div>
    </div>
</div>

</div>{{-- end x-data --}}

@endsection

@push('styles')
<style>
.features-list { overflow: hidden; }
.features-list.collapsed { max-height: 210px; }
.features-list.expanded  { max-height: 2000px; }
.features-list li { transition: opacity 0.2s ease; }
.features-list.collapsed li:nth-child(n+6) { opacity: 0; pointer-events: none; }
.features-list.expanded  li { opacity: 1; pointer-events: auto; }
</style>
@endpush

@push('scripts')
<script>
function eventsCompare() {
    return {
        compareList: [],
        showModal: false,
        init() {},
        isIn(id) { return this.compareList.some(p => p.id === id); },
        toggle(id, name, price, featured, features) {
            if (this.isIn(id)) { this.compareList = this.compareList.filter(p => p.id !== id); return; }
            if (this.compareList.length >= 3) { alert('يمكنك مقارنة 3 باقات كحد أقصى'); return; }
            this.compareList.push({ id, name, price, featured, features: features || [] });
        },
        clear() { this.compareList = []; this.showModal = false; },
        get allModalFeatures() {
            const s = new Set();
            this.compareList.forEach(p => (p.features || []).forEach(f => s.add(f)));
            return [...s];
        },
    };
}

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

document.addEventListener('keydown', e => { if (e.key === 'Escape') closeVideoModal(); });
document.addEventListener('click', e => {
    const modal = document.getElementById('videoModal');
    if (e.target === modal) closeVideoModal();
});

function toggleFeatures(btn) {
    const wrap = btn.closest('.features-wrap');
    const list = wrap.querySelector('.features-list');
    list.style.transition = 'max-height 0.35s ease';
    if (list.classList.contains('collapsed')) {
        list.classList.replace('collapsed', 'expanded');
        btn.textContent = 'إخفاء';
    } else {
        list.classList.replace('expanded', 'collapsed');
        btn.textContent = 'عرض المزيد';
    }
}
</script>
@endpush