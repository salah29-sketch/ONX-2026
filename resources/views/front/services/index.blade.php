@extends('layouts.front_tailwind')

@section('title', 'خدماتنا')

@section('content')

{{-- HERO --}}
<section class="relative isolate overflow-hidden border-b border-white/10">
    <div class="absolute inset-0 -z-10">
        <img src="{{ asset('img/hero-bg1.jpg') }}"
             alt="خدمات ONX"
             class="h-full w-full object-cover opacity-20">
        <div class="absolute inset-0 bg-gradient-to-b from-black/30 via-black/80 to-[#050505]"></div>
        <div class="absolute inset-0 bg-[radial-gradient(circle_at_70%_30%,rgba(255,106,0,0.14),transparent_28%),radial-gradient(circle_at_20%_80%,rgba(255,106,0,0.06),transparent_26%)]"></div>
    </div>

    <div class="mx-auto max-w-7xl px-6 py-20 lg:px-8 lg:py-24">
        <div class="mx-auto max-w-4xl text-center">
            <div class="mb-5 inline-flex items-center gap-2 rounded-full border border-white/10 bg-white/5 px-4 py-2 text-xs font-bold text-white/70 opacity-0 backdrop-blur animate-fade-in-up">
                <span class="h-2 w-2 rounded-full bg-orange-500"></span>
                ONX • Services
            </div>

            <h1 class="text-4xl font-black leading-tight text-white opacity-0 sm:text-5xl lg:text-6xl animate-fade-in-up animate-delay-100">
                خدمات الإنتاج الإبداعي
            </h1>

            <p class="mx-auto mt-6 max-w-2xl text-sm leading-8 text-white/70 opacity-0 sm:text-base animate-fade-in-up animate-delay-200">
                حفلات وإعلانات بجودة سينمائية — من سيدي بلعباس إلى كل الولايات.
            </p>

            <div class="mt-8 flex flex-wrap items-center justify-center gap-3 opacity-0 animate-fade-in-up animate-delay-300">
                <a href="/services/events"
                   class="inline-flex items-center justify-center rounded-full bg-orange-500 px-7 py-3 text-sm font-black text-black transition duration-300 hover:-translate-y-1 hover:bg-orange-400 hover:shadow-[0_0_30px_rgba(249,115,22,0.3)] active:scale-[0.98]">
                    تصوير الحفلات
                </a>

                <a href="/services/marketing"
                   class="inline-flex items-center justify-center rounded-full border border-white/15 bg-white/5 px-7 py-3 text-sm font-extrabold text-white transition duration-300 hover:-translate-y-1 hover:border-orange-500/50 hover:bg-orange-500/10 active:scale-[0.98]">
                    الإعلانات
                </a>
            </div>
        </div>
    </div>
</section>

{{-- SERVICES CARDS --}}
<section class="mx-auto max-w-7xl px-6 py-20 lg:px-8">
    <div class="mb-10 text-center opacity-0 animate-fade-in-up animate-delay-200">
        <h2 class="text-3xl font-black sm:text-4xl">خدماتنا</h2>
        <p class="mx-auto mt-4 max-w-2xl text-sm leading-8 text-white/65 sm:text-base">
            اختر الخدمة المناسبة وابدأ معنا بسهولة.
        </p>
    </div>

    <div class="grid gap-6 lg:grid-cols-2">
        {{-- Events --}}
        <div class="group relative overflow-hidden rounded-[30px] border border-white/10 bg-white/5 opacity-0 shadow-[0_20px_50px_rgba(0,0,0,0.32)] transition duration-500 hover:-translate-y-2 hover:border-orange-500/30 animate-fade-in-up animate-delay-300">
            <div class="absolute inset-0">
                <img src="{{ asset('img/events.jpg') }}"
                     alt="تصوير الحفلات"
                     class="h-full w-full object-cover opacity-45 transition duration-700 group-hover:scale-110">
                <div class="absolute inset-0 bg-gradient-to-t from-black via-black/60 to-transparent"></div>
            </div>

            <div class="relative flex min-h-[380px] flex-col justify-end p-7 sm:p-8">
                <div class="mb-5 inline-flex w-fit rounded-full border border-white/10 bg-white/10 px-4 py-2 text-[11px] font-extrabold tracking-[0.18em] text-white/70 backdrop-blur">
                    EVENTS
                </div>

                <h3 class="text-2xl font-black sm:text-3xl">تصوير الحفلات</h3>
                <p class="mt-4 max-w-lg text-sm leading-8 text-white/70">
                    باقات ثابتة لتوثيق حفلاتكم بجودة سينمائية.
                </p>

                <div class="mt-7">
                    <a href="/services/events"
                       class="inline-flex rounded-full border border-white/15 bg-white/5 px-6 py-3 text-sm font-extrabold text-white transition hover:border-orange-500/50 hover:bg-orange-500/10">
                        شاهد الباقات
                    </a>
                </div>
            </div>
        </div>

        {{-- Marketing --}}
        <div class="group relative overflow-hidden rounded-[30px] border border-white/10 bg-white/5 opacity-0 shadow-[0_20px_50px_rgba(0,0,0,0.32)] transition duration-500 hover:-translate-y-2 hover:border-orange-500/30 animate-fade-in-up animate-delay-400">
            <div class="absolute inset-0">
                <img src="{{ asset('img/marketing.jpg') }}"
                     alt="الإعلانات"
                     class="h-full w-full object-cover opacity-45 transition duration-700 group-hover:scale-110">
                <div class="absolute inset-0 bg-gradient-to-t from-black via-black/60 to-transparent"></div>
            </div>

            <div class="relative flex min-h-[380px] flex-col justify-end p-7 sm:p-8">
                <div class="mb-5 inline-flex w-fit rounded-full border border-white/10 bg-white/10 px-4 py-2 text-[11px] font-extrabold tracking-[0.18em] text-white/70 backdrop-blur">
                    Marketing
                </div>

                <h3 class="text-2xl font-black sm:text-3xl">الإعلانات</h3>
                <p class="mt-4 max-w-lg text-sm leading-8 text-white/70">
                    إعلانات حسب الطلب + اشتراك شهري بسعر ثابت.
                </p>

                <div class="mt-7">
                    <a href="/services/marketing"
                       class="inline-flex rounded-full border border-white/15 bg-white/5 px-6 py-3 text-sm font-extrabold text-white transition hover:border-orange-500/50 hover:bg-orange-500/10">
                        اطلب عرض سعر
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- WHY ONX --}}
<section class="mx-auto max-w-7xl px-6 py-20 lg:px-8">
    <div class="rounded-[34px] border border-white/10 bg-white/5 p-7 shadow-[0_25px_70px_rgba(0,0,0,0.35)] backdrop-blur-xl sm:p-8">
        <div class="mb-8 text-center">
            <h2 class="text-3xl font-black sm:text-4xl">
                لماذا <span class="text-orange-500">ONX</span>؟
            </h2>
            <p class="mt-4 text-sm leading-8 text-white/65 sm:text-base">
                أشياء بسيطة تفرق في النتيجة النهائية.
            </p>
        </div>

        <div class="grid gap-4 md:grid-cols-3">
            <div class="rounded-[24px] border border-white/10 bg-black/20 p-5 text-center">
                <div class="mb-3 text-3xl">🎬</div>
                <h3 class="text-base font-black">جودة سينمائية</h3>
                <p class="mt-3 text-sm leading-7 text-white/65">
                    معدات وإضاءة ولقطات محسوبة تعطيك Cinema Look حقيقي.
                </p>
            </div>

            <div class="rounded-[24px] border border-white/10 bg-black/20 p-5 text-center">
                <div class="mb-3 text-3xl">⚡</div>
                <h3 class="text-base font-black">تسليم سريع</h3>
                <p class="mt-3 text-sm leading-7 text-white/65">
                    تسليم في الوقت المتفق عليه حسب نوع الخدمة.
                </p>
            </div>

            <div class="rounded-[24px] border border-white/10 bg-black/20 p-5 text-center">
                <div class="mb-3 text-3xl">🤝</div>
                <h3 class="text-base font-black">تواصل واضح</h3>
                <p class="mt-3 text-sm leading-7 text-white/65">
                    نبقى معك خطوة بخطوة حتى تكون راضيًا 100%.
                </p>
            </div>
        </div>
    </div>
</section>

{{-- CTA --}}
<section class="mx-auto max-w-7xl px-6 py-20 lg:px-8">
    <div class="relative overflow-hidden rounded-[34px] border border-orange-500/20 bg-gradient-to-br from-orange-500/12 via-white/5 to-white/5 p-8 shadow-[0_30px_90px_rgba(0,0,0,0.4)] sm:p-10">
        <div class="absolute -left-24 top-1/2 h-52 w-52 -translate-y-1/2 rounded-full bg-orange-500/10 blur-3xl"></div>
        <div class="absolute -right-16 top-0 h-36 w-36 rounded-full bg-white/5 blur-3xl"></div>

        <div class="relative z-10 mx-auto max-w-3xl text-center">
            <h2 class="text-3xl font-black sm:text-4xl">
                جاهز تبدأ مشروعك؟
            </h2>
            <p class="mt-5 text-sm leading-8 text-white/70 sm:text-base">
                تواصل معنا الآن وسنساعدك في اختيار الخدمة المناسبة.
            </p>

            <div class="mt-8 flex flex-wrap items-center justify-center gap-4">
                <a href="https://wa.me/213540573518" target="_blank"
                   class="inline-flex rounded-full border border-white/15 bg-white/5 px-7 py-3.5 text-sm font-extrabold text-white transition duration-300 hover:-translate-y-1 hover:border-orange-500/50 hover:bg-orange-500/10">
                    واتساب
                </a>

                <a href="tel:+213540573518"
                   class="inline-flex rounded-full border border-white/15 bg-white/5 px-7 py-3.5 text-sm font-extrabold text-white transition duration-300 hover:-translate-y-1 hover:border-orange-500/50 hover:bg-orange-500/10">
                    اتصال
                </a>

                <a href="/booking"
                   class="inline-flex rounded-full bg-orange-500 px-7 py-3.5 text-sm font-black text-black transition duration-300 hover:-translate-y-1 hover:bg-orange-400 hover:shadow-[0_0_30px_rgba(249,115,22,0.35)]">
                    Booking
                </a>
            </div>
        </div>
    </div>
</section>

@endsection