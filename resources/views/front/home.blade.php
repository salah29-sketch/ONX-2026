@extends('layouts.front_tailwind')

@section('title', 'ONX | الصفحة الرئيسية')

@section('content')

{{-- HERO --}}
<section class="relative isolate overflow-hidden border-b border-white/10">
    <div class="absolute inset-0 -z-10">
        <img src="{{ asset('img/hero-bg1.jpg') }}"
             alt="ONX Hero"
             class="h-full w-full object-cover opacity-20">
        <div class="absolute inset-0 bg-gradient-to-b from-black/30 via-black/80 to-[#050505]"></div>
        <div class="absolute inset-0 bg-[radial-gradient(circle_at_70%_30%,rgba(255,106,0,0.14),transparent_28%),radial-gradient(circle_at_20%_80%,rgba(255,106,0,0.06),transparent_26%)]"></div>
    </div>

    <div class="mx-auto grid min-h-[82vh] max-w-7xl items-center gap-10 px-6 py-14 lg:grid-cols-[1.02fr_.98fr] lg:px-8 lg:py-16">
        {{-- Text --}}
        <div class="order-2 lg:order-1">
            <div class="mb-5 inline-flex items-center gap-3 rounded-full border border-white/10 bg-white/5 px-4 py-2 text-xs font-bold text-white/70 backdrop-blur">
                <span class="h-2.5 w-2.5 rounded-full bg-orange-500"></span>
                ONX • Creative Production
            </div>

            <h1 class="max-w-4xl text-4xl font-black leading-[1.08] text-white sm:text-5xl lg:text-6xl">
                نصنع
                <span class="text-orange-500">أفلامًا وإعلانات</span>
                وتجارب بصرية
                <span class="block">تترك انطباعًا لا يُنسى</span>
            </h1>

            <p class="mt-6 max-w-2xl text-sm leading-7 text-white/70 sm:text-base">
                شركة إنتاج بصري متخصصة في الإعلانات، الحفلات، والتغطيات الراقية.
                نحول الفكرة إلى صورة ذات حضور، ونقدم تنفيذًا يحترم التفاصيل، الإيقاع،
                والهوية البصرية للمشروع.
            </p>

            <div class="mt-8 flex flex-wrap gap-3">
                <a href="/booking"
                   class="inline-flex items-center justify-center rounded-full bg-orange-500 px-7 py-3 text-sm font-black text-black transition duration-300 hover:-translate-y-1 hover:bg-orange-400 hover:shadow-[0_0_30px_rgba(249,115,22,0.3)]">
                    احجز مشروعك
                </a>

                <a href="/services"
                   class="inline-flex items-center justify-center rounded-full border border-white/15 bg-white/5 px-7 py-3 text-sm font-extrabold text-white transition duration-300 hover:-translate-y-1 hover:border-orange-500/50 hover:bg-orange-500/10">
                    اكتشف الخدمات
                </a>
            </div>

            <div class="mt-8 grid max-w-3xl gap-3 sm:grid-cols-3">
                <div class="rounded-[20px] border border-white/10 bg-white/5 p-4 backdrop-blur-xl">
                    <div class="text-base font-black text-white">Cinema Look</div>
                    <div class="mt-2 text-xs leading-6 text-white/55">لقطات محسوبة وهوية بصرية ذات مزاج سينمائي</div>
                </div>

                <div class="rounded-[20px] border border-white/10 bg-white/5 p-4 backdrop-blur-xl">
                    <div class="text-base font-black text-white">Precise Flow</div>
                    <div class="mt-2 text-xs leading-6 text-white/55">تنفيذ منظم من الفكرة إلى التسليم بدون فوضى</div>
                </div>

                <div class="rounded-[20px] border border-white/10 bg-white/5 p-4 backdrop-blur-xl">
                    <div class="text-base font-black text-white">Brand Impact</div>
                    <div class="mt-2 text-xs leading-6 text-white/55">صورة ترفع قيمة البراند وتترك أثرًا واضحًا</div>
                </div>
            </div>
        </div>

        {{-- Visual --}}
        <div class="order-1 lg:order-2">
            <div class="relative mx-auto max-w-lg">
                <div class="absolute -inset-8 rounded-[38px] bg-orange-500/10 blur-3xl"></div>

                <div class="relative overflow-hidden rounded-[28px] border border-white/10 bg-white/5 shadow-[0_24px_80px_rgba(0,0,0,0.5)] backdrop-blur-xl">
                    <img src="{{ asset('img/events.jpg') }}"
                         alt="ONX Production"
                         class="h-[470px] w-full object-cover opacity-95">

                    <div class="absolute inset-0 bg-gradient-to-t from-black via-black/20 to-transparent"></div>

                    <div class="absolute left-0 right-0 top-0 flex items-start justify-between p-4">
                        <div class="inline-flex rounded-full border border-white/10 bg-black/35 px-3 py-1 text-[11px] font-extrabold tracking-[0.18em] text-white/70 backdrop-blur">
                            ONX FRAME
                        </div>
                        <div class="inline-flex rounded-full border border-orange-500/30 bg-orange-500/10 px-3 py-1 text-[11px] font-extrabold tracking-wide text-orange-300">
                            FEATURED VISUAL
                        </div>
                    </div>

                    <div class="absolute bottom-0 left-0 right-0 p-6">
                        <h2 class="text-2xl font-black text-white sm:text-3xl">
                            صورة تُحس قبل أن تُشاهد
                        </h2>
                        <p class="mt-2 max-w-lg text-sm leading-7 text-white/70">
                            من لحظة الفكرة إلى آخر frame، نشتغل على الإضاءة، الحركة، والمونتاج
                            كأن المشروع يملك نبضًا خاصًا به.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ABOUT --}}
<section class="mx-auto max-w-7xl px-6 py-20 lg:px-8">
    <div class="grid gap-6 lg:grid-cols-[1.08fr_.92fr]">
        <div class="relative overflow-hidden rounded-[30px] border border-white/10 bg-white/5 p-7 shadow-[0_20px_60px_rgba(0,0,0,0.3)] backdrop-blur-xl sm:p-8">
            <div class="absolute -left-20 top-10 h-36 w-36 rounded-full bg-orange-500/10 blur-3xl"></div>
            <div class="relative">
                <p class="mb-4 text-xs font-extrabold uppercase tracking-[0.25em] text-orange-400">
                    من نحن
                </p>
                <h2 class="max-w-3xl text-3xl font-black leading-tight sm:text-4xl">
                    لسنا مجرد تصوير ومونتاج،
                    بل بناء حضور بصري كامل.
                </h2>
                <p class="mt-6 max-w-3xl text-sm leading-8 text-white/70 sm:text-base">
                    ONX هي هوية إنتاجية تهتم بأن يبدو العمل قويًا، أنيقًا، ومؤثرًا.
                    سواء كان المشروع إعلانًا لعلامة تجارية أو تغطية لحفل يحتاج لمسة فاخرة،
                    فالهدف دائمًا واحد: إخراج بصري يرفع قيمة الصورة ويمنحها شخصية واضحة.
                </p>
            </div>
        </div>

        <div class="grid gap-4">
            <div class="rounded-[26px] border border-white/10 bg-white/5 p-6 shadow-[0_20px_50px_rgba(0,0,0,0.22)]">
                <div class="mb-3 text-3xl">🎬</div>
                <h3 class="text-xl font-black">رؤية سينمائية</h3>
                <p class="mt-3 text-sm leading-7 text-white/65">
                    لقطات مدروسة، إضاءة محسوبة، وإيقاع بصري يجعل العمل أكثر عمقًا وأناقة.
                </p>
            </div>

            <div class="rounded-[26px] border border-white/10 bg-white/5 p-6 shadow-[0_20px_50px_rgba(0,0,0,0.22)]">
                <div class="mb-3 text-3xl">⚡</div>
                <h3 class="text-xl font-black">تنفيذ احترافي</h3>
                <p class="mt-3 text-sm leading-7 text-white/65">
                    نشتغل بعقلية واضحة: تنظيم، جودة، وتسليم يحترم الوقت ويجعل العميل مطمئنًا.
                </p>
            </div>
        </div>
    </div>
</section>

{{-- SERVICES --}}
<section class="mx-auto max-w-7xl px-6 py-20 lg:px-8">
    <div class="mb-10 text-center">
        <p class="mb-3 text-xs font-extrabold uppercase tracking-[0.25em] text-orange-400">الخدمات</p>
        <h2 class="text-3xl font-black sm:text-4xl">حلول بصرية تُبنى لتُلفت وتُقنع</h2>
        <p class="mx-auto mt-4 max-w-2xl text-sm leading-8 text-white/65 sm:text-base">
            اختر الخدمة المناسبة، وسنحوّلها إلى تجربة بصرية تحمل توقيع ONX.
        </p>
    </div>

    <div class="grid gap-5 lg:grid-cols-2">
        <a href="/services/events"
           class="group relative overflow-hidden rounded-[30px] border border-white/10 bg-white/5 shadow-[0_20px_50px_rgba(0,0,0,0.32)] transition duration-500 hover:-translate-y-2 hover:border-orange-500/30">
            <div class="absolute inset-0">
                <img src="{{ asset('img/events.jpg') }}"
                     alt="تصوير الحفلات"
                     class="h-full w-full object-cover opacity-45 transition duration-700 group-hover:scale-110">
                <div class="absolute inset-0 bg-gradient-to-t from-black via-black/60 to-transparent"></div>
            </div>

            <div class="relative flex min-h-[360px] flex-col justify-end p-7 sm:p-8">
                <div class="mb-5 inline-flex w-fit rounded-full border border-white/10 bg-white/10 px-4 py-2 text-[11px] font-extrabold tracking-[0.18em] text-white/70 backdrop-blur">
                    EVENTS
                </div>
                <h3 class="text-2xl font-black sm:text-3xl">تصوير الحفلات</h3>
                <p class="mt-3 max-w-lg text-sm leading-8 text-white/70">
                    تغطية فاخرة للمناسبات والحفلات بأسلوب سينمائي يلتقط اللحظة،
                    الإحساس، وهيبة الحدث.
                </p>
                <div class="mt-6 text-sm font-extrabold text-orange-400">
                    استكشف الباقات ←
                </div>
            </div>
        </a>

        <a href="/services/marketing"
           class="group relative overflow-hidden rounded-[30px] border border-white/10 bg-white/5 shadow-[0_20px_50px_rgba(0,0,0,0.32)] transition duration-500 hover:-translate-y-2 hover:border-orange-500/30">
            <div class="absolute inset-0">
                <img src="{{ asset('img/marketing.jpg') }}"
                     alt="الإعلانات"
                     class="h-full w-full object-cover opacity-45 transition duration-700 group-hover:scale-110">
                <div class="absolute inset-0 bg-gradient-to-t from-black via-black/60 to-transparent"></div>
            </div>

            <div class="relative flex min-h-[360px] flex-col justify-end p-7 sm:p-8">
                <div class="mb-5 inline-flex w-fit rounded-full border border-white/10 bg-white/10 px-4 py-2 text-[11px] font-extrabold tracking-[0.18em] text-white/70 backdrop-blur">
                    ADS
                </div>
                <h3 class="text-2xl font-black sm:text-3xl">الإعلانات</h3>
                <p class="mt-3 max-w-lg text-sm leading-8 text-white/70">
                    إعلانات تجارية ومحتوى تسويقي يُبنى ليجذب الانتباه، يرفع القيمة،
                    ويمنح البراند حضورًا حقيقيًا.
                </p>
                <div class="mt-6 text-sm font-extrabold text-orange-400">
                    اطلب عرضًا ←
                </div>
            </div>
        </a>
    </div>
</section>

{{-- SHOWCASE --}}
<section class="mx-auto max-w-7xl px-6 py-20 lg:px-8">
    <div class="mb-10 flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
        <div>
            <p class="mb-3 text-sm font-extrabold uppercase tracking-[0.25em] text-orange-400">لقطات من الروح</p>
            <h2 class="text-3xl font-black sm:text-4xl">أعمال لا تكتفي بأن تبدو جميلة</h2>
        </div>
        <a href="/portfolio"
           class="inline-flex w-fit rounded-full border border-white/10 bg-white/5 px-5 py-3 text-sm font-extrabold text-white/80 transition hover:border-orange-500/40 hover:bg-orange-500/10 hover:text-white">
            شاهد الأعمال
        </a>
    </div>

    <div class="grid gap-6 md:grid-cols-2 xl:grid-cols-3">
        <div class="group overflow-hidden rounded-[28px] border border-white/10 bg-white/5">
            <div class="overflow-hidden">
                <img src="{{ asset('img/events.jpg') }}" alt=""
                     class="h-80 w-full object-cover transition duration-700 group-hover:scale-110">
            </div>
            <div class="p-6">
                <div class="text-xs font-extrabold tracking-[0.2em] text-orange-400">EVENT STORY</div>
                <h3 class="mt-2 text-xl font-black">تغطية بصرية لحفل فاخر</h3>
                <p class="mt-3 leading-7 text-white/65">
                    لحظات حية، تفاصيل مشغولة، ومونتاج يمنح المناسبة قيمة أكبر من مجرد التوثيق.
                </p>
            </div>
        </div>

        <div class="group overflow-hidden rounded-[28px] border border-white/10 bg-white/5">
            <div class="overflow-hidden">
                <img src="{{ asset('img/marketing.jpg') }}" alt=""
                     class="h-80 w-full object-cover transition duration-700 group-hover:scale-110">
            </div>
            <div class="p-6">
                <div class="text-xs font-extrabold tracking-[0.2em] text-orange-400">BRAND FILM</div>
                <h3 class="mt-2 text-xl font-black">فيلم إعلاني لعلامة تجارية</h3>
                <p class="mt-3 leading-7 text-white/65">
                    صورة محسوبة ورسالة واضحة تجعل الإعلان يبدو راقيًا بدل أن يكون مجرد ضجيج بصري.
                </p>
            </div>
        </div>

        <div class="group overflow-hidden rounded-[28px] border border-white/10 bg-white/5 md:col-span-2 xl:col-span-1">
            <div class="overflow-hidden">
                <img src="{{ asset('img/hero-bg1.jpg') }}" alt=""
                     class="h-80 w-full object-cover transition duration-700 group-hover:scale-110">
            </div>
            <div class="p-6">
                <div class="text-xs font-extrabold tracking-[0.2em] text-orange-400">VISUAL IDENTITY</div>
                <h3 class="mt-2 text-xl font-black">هوية بصرية بمزاج سينمائي</h3>
                <p class="mt-3 leading-7 text-white/65">
                    عندما تكون الصورة جزءًا من البراند نفسه، لا مجرد غلاف جميل فوق محتوى عادي.
                </p>
            </div>
        </div>
    </div>
</section>
{{-- WHY ONX --}}
<section class="mx-auto max-w-7xl px-6 py-20 lg:px-8">
    <div class="rounded-[34px] border border-white/10 bg-white/5 p-7 shadow-[0_25px_70px_rgba(0,0,0,0.35)] backdrop-blur-xl sm:p-8">
        <div class="mb-8 text-center">
            <p class="mb-3 text-xs font-extrabold uppercase tracking-[0.25em] text-orange-400">لماذا ONX</p>
            <h2 class="text-3xl font-black sm:text-4xl">لأن النتيجة النهائية يجب أن تبدو بمستوى يليق بك</h2>
        </div>

        <div class="grid gap-4 md:grid-cols-2 xl:grid-cols-4">
            <div class="rounded-[24px] border border-white/10 bg-black/20 p-5">
                <div class="mb-3 text-3xl">🎥</div>
                <h3 class="text-base font-black">زاوية نظر مدروسة</h3>
                <p class="mt-3 text-sm leading-7 text-white/65">
                    الصورة ليست مصادفة، بل قرار بصري محسوب من أول لقطة.
                </p>
            </div>

            <div class="rounded-[24px] border border-white/10 bg-black/20 p-5">
                <div class="mb-3 text-3xl">🧠</div>
                <h3 class="text-base font-black">فهم الهدف</h3>
                <p class="mt-3 text-sm leading-7 text-white/65">
                    نبدأ من فكرة المشروع، لا من الكاميرا فقط.
                </p>
            </div>

            <div class="rounded-[24px] border border-white/10 bg-black/20 p-5">
                <div class="mb-3 text-3xl">⚙️</div>
                <h3 class="text-base font-black">تنفيذ منظم</h3>
                <p class="mt-3 text-sm leading-7 text-white/65">
                    كل مرحلة لها مكانها، فلا يتحول المشروع إلى فوضى أنيقة من الخارج فقط.
                </p>
            </div>

            <div class="rounded-[24px] border border-white/10 bg-black/20 p-5">
                <div class="mb-3 text-3xl">🔥</div>
                <h3 class="text-base font-black">حضور بصري قوي</h3>
                <p class="mt-3 text-sm leading-7 text-white/65">
                    نبحث عن التأثير، لا عن مجرد “فيديو محترم وخلاص”.
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
            <p class="mb-3 text-xs font-extrabold uppercase tracking-[0.25em] text-orange-400">ابدأ الآن</p>
            <h2 class="text-3xl font-black sm:text-4xl">
                هل لديك مشروع يحتاج حضورًا بصريًا حقيقيًا؟
            </h2>
            <p class="mt-5 text-sm leading-8 text-white/70 sm:text-base">
                دعنا نحول فكرتك إلى عمل بصري فاخر يليق بالبراند، بالمناسبة،
                وبالصورة التي تريد أن يراك الناس بها.
            </p>

            <div class="mt-8 flex flex-wrap items-center justify-center gap-4">
                <a href="/booking"
                   class="inline-flex rounded-full bg-orange-500 px-7 py-3.5 text-sm font-black text-black transition duration-300 hover:-translate-y-1 hover:bg-orange-400 hover:shadow-[0_0_30px_rgba(249,115,22,0.35)]">
                    احجز الآن
                </a>

                <a href="https://wa.me/213540573518" target="_blank"
                   class="inline-flex rounded-full border border-white/15 bg-white/5 px-7 py-3.5 text-sm font-extrabold text-white transition duration-300 hover:-translate-y-1 hover:border-orange-500/50 hover:bg-orange-500/10">
                    واتساب
                </a>
            </div>
        </div>
    </div>
</section>

@endsection