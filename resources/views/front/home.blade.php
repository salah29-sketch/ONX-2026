@extends('layouts.front_tailwind')

@section('title', 'ONX | الصفحة الرئيسية')

@section('content')

{{-- HERO --}}
<section class="relative isolate overflow-hidden">
    <div class="absolute inset-0 -z-10">
        <img src="{{ asset('img/hero-bg1.jpg') }}"
             alt="ONX Hero"
             class="h-full w-full object-cover opacity-30">
        <div class="absolute inset-0 bg-gradient-to-b from-black/40 via-black/70 to-[#050505]"></div>
        <div class="absolute inset-0 bg-[radial-gradient(circle_at_center,rgba(255,106,0,0.12),transparent_36%)]"></div>
    </div>

    <div class="mx-auto grid min-h-[92vh] max-w-7xl items-center gap-14 px-6 py-20 lg:grid-cols-2 lg:px-8">
        <div class="order-2 lg:order-1">
            <div class="mb-5 inline-flex items-center gap-2 rounded-full border border-white/10 bg-white/5 px-4 py-2 text-sm font-bold text-white/70 backdrop-blur">
                <span class="h-2 w-2 rounded-full bg-orange-500"></span>
                ONX • Creative Production
            </div>

            <h1 class="max-w-3xl text-4xl font-black leading-tight text-white sm:text-5xl lg:text-6xl">
                نصنع <span class="text-orange-500">أفلامًا وإعلانات</span> وتجارب بصرية
                تترك انطباعًا لا يُنسى
            </h1>

            <p class="mt-6 max-w-2xl text-base leading-8 text-white/70 sm:text-lg">
                شركة إنتاج بصري متخصصة في الإعلانات، الحفلات، والتغطيات الراقية.
                نحول الفكرة إلى صورة ذات حضور، ونقدّم تنفيذًا يحترم التفاصيل، الإيقاع، والهوية.
            </p>

            <div class="mt-8 flex flex-wrap gap-4">
                <a href="/booking"
                   class="inline-flex items-center rounded-full bg-orange-500 px-7 py-3.5 text-sm font-black text-black transition duration-300 hover:-translate-y-1 hover:bg-orange-400 hover:shadow-[0_0_30px_rgba(249,115,22,0.35)]">
                    احجز مشروعك
                </a>

                <a href="/services"
                   class="inline-flex items-center rounded-full border border-white/15 bg-white/5 px-7 py-3.5 text-sm font-extrabold text-white transition duration-300 hover:-translate-y-1 hover:border-orange-500/50 hover:bg-orange-500/10">
                    اكتشف الخدمات
                </a>
            </div>

            <div class="mt-10 grid max-w-2xl grid-cols-3 gap-4">
                <div class="rounded-2xl border border-white/10 bg-white/5 p-4 backdrop-blur">
                    <div class="text-2xl font-black text-white">Cinema</div>
                    <div class="mt-1 text-sm text-white/55">نظرة سينمائية</div>
                </div>
                <div class="rounded-2xl border border-white/10 bg-white/5 p-4 backdrop-blur">
                    <div class="text-2xl font-black text-white">Fast</div>
                    <div class="mt-1 text-sm text-white/55">تسليم منظم</div>
                </div>
                <div class="rounded-2xl border border-white/10 bg-white/5 p-4 backdrop-blur">
                    <div class="text-2xl font-black text-white">Impact</div>
                    <div class="mt-1 text-sm text-white/55">أثر بصري واضح</div>
                </div>
            </div>
        </div>

        <div class="order-1 lg:order-2">
            <div class="relative mx-auto max-w-xl">
                <div class="absolute -inset-8 rounded-[40px] bg-orange-500/10 blur-3xl"></div>

                <div class="relative overflow-hidden rounded-[32px] border border-white/10 bg-white/5 shadow-[0_25px_80px_rgba(0,0,0,0.55)] backdrop-blur-xl">
                    <img src="{{ asset('img/events.jpg') }}"
                         alt="ONX Production"
                         class="h-[520px] w-full object-cover opacity-90">

                    <div class="absolute inset-0 bg-gradient-to-t from-black via-black/25 to-transparent"></div>

                    <div class="absolute bottom-0 left-0 right-0 p-6">
                        <div class="mb-3 inline-flex rounded-full border border-orange-500/30 bg-orange-500/10 px-3 py-1 text-xs font-extrabold tracking-wide text-orange-300">
                            FEATURED VISUAL
                        </div>
                        <h2 class="text-2xl font-black text-white sm:text-3xl">
                            صورة تُحس قبل أن تُشاهد
                        </h2>
                        <p class="mt-2 max-w-md text-sm leading-7 text-white/70">
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
    <div class="grid gap-8 lg:grid-cols-[1.1fr_.9fr]">
        <div class="rounded-[32px] border border-white/10 bg-white/5 p-8 shadow-[0_20px_70px_rgba(0,0,0,0.35)] backdrop-blur-xl">
            <p class="mb-4 text-sm font-extrabold uppercase tracking-[0.25em] text-orange-400">
                من نحن
            </p>
            <h2 class="text-3xl font-black leading-tight sm:text-4xl">
                لسنا مجرد تصوير ومونتاج،
                بل بناء حضور بصري كامل.
            </h2>
            <p class="mt-6 max-w-3xl text-base leading-8 text-white/70">
                ONX هي هوية إنتاجية تهتم بأن يبدو العمل قويًا، أنيقًا، ومؤثرًا.
                سواء كان المشروع إعلانًا لعلامة تجارية أو تغطية لحفل يحتاج لمسة فاخرة،
                فالهدف دائمًا واحد: إخراج بصري يرفع قيمة الصورة ويمنحها شخصية.
            </p>
        </div>

        <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-1">
            <div class="rounded-[28px] border border-white/10 bg-white/5 p-6">
                <div class="mb-3 text-3xl">🎬</div>
                <h3 class="text-xl font-black">رؤية سينمائية</h3>
                <p class="mt-3 leading-7 text-white/65">
                    لقطات مدروسة، إضاءة محسوبة، وإيقاع بصري يجعل العمل أكثر عمقًا وأناقة.
                </p>
            </div>

            <div class="rounded-[28px] border border-white/10 bg-white/5 p-6">
                <div class="mb-3 text-3xl">⚡</div>
                <h3 class="text-xl font-black">تنفيذ احترافي</h3>
                <p class="mt-3 leading-7 text-white/65">
                    نشتغل بعقلية واضحة: تنظيم، جودة، وتسليم يجعل العميل مطمئنًا لا مشتتًا.
                </p>
            </div>
        </div>
    </div>
</section>

{{-- SERVICES --}}
<section class="mx-auto max-w-7xl px-6 py-20 lg:px-8">
    <div class="mb-10 text-center">
        <p class="mb-3 text-sm font-extrabold uppercase tracking-[0.25em] text-orange-400">الخدمات</p>
        <h2 class="text-3xl font-black sm:text-4xl">حلول بصرية تُبنى لتُلفت وتُقنع</h2>
        <p class="mx-auto mt-4 max-w-2xl leading-8 text-white/65">
            اختر الخدمة المناسبة، وسنحولها إلى تجربة بصرية تحمل توقيع ONX.
        </p>
    </div>

    <div class="grid gap-6 lg:grid-cols-2">
        <a href="/services/events"
           class="group relative overflow-hidden rounded-[32px] border border-white/10 bg-white/5 shadow-[0_20px_60px_rgba(0,0,0,0.35)] transition duration-500 hover:-translate-y-2 hover:border-orange-500/30">
            <div class="absolute inset-0">
                <img src="{{ asset('img/events.jpg') }}" alt="تصوير الحفلات"
                     class="h-full w-full object-cover opacity-40 transition duration-700 group-hover:scale-110">
                <div class="absolute inset-0 bg-gradient-to-t from-black via-black/60 to-transparent"></div>
            </div>

            <div class="relative p-8 sm:p-10">
                <div class="mb-20 inline-flex rounded-full border border-white/10 bg-white/10 px-4 py-2 text-xs font-extrabold text-white/70 backdrop-blur">
                    EVENTS
                </div>
                <h3 class="text-3xl font-black">تصوير الحفلات</h3>
                <p class="mt-4 max-w-lg leading-8 text-white/70">
                    تغطية فاخرة للمناسبات والحفلات بأسلوب سينمائي يلتقط اللحظة،
                    الإحساس، وهيبة الحدث.
                </p>
                <div class="mt-8 text-sm font-extrabold text-orange-400">
                    استكشف الباقات ←
                </div>
            </div>
        </a>

        <a href="/services/marketing"
           class="group relative overflow-hidden rounded-[32px] border border-white/10 bg-white/5 shadow-[0_20px_60px_rgba(0,0,0,0.35)] transition duration-500 hover:-translate-y-2 hover:border-orange-500/30">
            <div class="absolute inset-0">
                <img src="{{ asset('img/marketing.jpg') }}" alt="الإعلانات"
                     class="h-full w-full object-cover opacity-40 transition duration-700 group-hover:scale-110">
                <div class="absolute inset-0 bg-gradient-to-t from-black via-black/60 to-transparent"></div>
            </div>

            <div class="relative p-8 sm:p-10">
                <div class="mb-20 inline-flex rounded-full border border-white/10 bg-white/10 px-4 py-2 text-xs font-extrabold text-white/70 backdrop-blur">
                    ADS
                </div>
                <h3 class="text-3xl font-black">الإعلانات</h3>
                <p class="mt-4 max-w-lg leading-8 text-white/70">
                    إعلانات تجارية ومحتوى تسويقي يُبنى ليجذب الانتباه، يرفع القيمة،
                    ويعطي البراند حضورًا حقيقيًا.
                </p>
                <div class="mt-8 text-sm font-extrabold text-orange-400">
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
    <div class="rounded-[36px] border border-white/10 bg-white/5 p-8 shadow-[0_25px_80px_rgba(0,0,0,0.4)] backdrop-blur-xl sm:p-10">
        <div class="mb-10 text-center">
            <p class="mb-3 text-sm font-extrabold uppercase tracking-[0.25em] text-orange-400">لماذا ONX</p>
            <h2 class="text-3xl font-black sm:text-4xl">لأن النتيجة النهائية يجب أن تبدو بمستوى يليق بك</h2>
        </div>

        <div class="grid gap-5 md:grid-cols-2 xl:grid-cols-4">
            <div class="rounded-[24px] border border-white/10 bg-black/20 p-6">
                <div class="mb-3 text-3xl">🎥</div>
                <h3 class="text-lg font-black">زاوية نظر مدروسة</h3>
                <p class="mt-3 leading-7 text-white/65">
                    الصورة ليست مصادفة، بل قرار بصري محسوب من أول لقطة.
                </p>
            </div>

            <div class="rounded-[24px] border border-white/10 bg-black/20 p-6">
                <div class="mb-3 text-3xl">🧠</div>
                <h3 class="text-lg font-black">فهم الهدف</h3>
                <p class="mt-3 leading-7 text-white/65">
                    نبدأ من فكرة المشروع، لا من الكاميرا فقط.
                </p>
            </div>

            <div class="rounded-[24px] border border-white/10 bg-black/20 p-6">
                <div class="mb-3 text-3xl">⚙️</div>
                <h3 class="text-lg font-black">تنفيذ منظم</h3>
                <p class="mt-3 leading-7 text-white/65">
                    كل مرحلة لها مكانها، فلا يتحول المشروع إلى فوضى أنيقة من الخارج فقط.
                </p>
            </div>

            <div class="rounded-[24px] border border-white/10 bg-black/20 p-6">
                <div class="mb-3 text-3xl">🔥</div>
                <h3 class="text-lg font-black">حضور بصري قوي</h3>
                <p class="mt-3 leading-7 text-white/65">
                    نبحث عن التأثير، لا عن مجرد “فيديو محترم وخلاص”.
                </p>
            </div>
        </div>
    </div>
</section>

{{-- CTA --}}
<section class="mx-auto max-w-7xl px-6 py-20 lg:px-8">
    <div class="relative overflow-hidden rounded-[36px] border border-orange-500/20 bg-gradient-to-br from-orange-500/12 via-white/5 to-white/5 p-8 shadow-[0_30px_100px_rgba(0,0,0,0.45)] sm:p-12">
        <div class="absolute -left-24 top-1/2 h-56 w-56 -translate-y-1/2 rounded-full bg-orange-500/10 blur-3xl"></div>
        <div class="absolute -right-16 top-0 h-40 w-40 rounded-full bg-white/5 blur-3xl"></div>

        <div class="relative z-10 mx-auto max-w-3xl text-center">
            <p class="mb-3 text-sm font-extrabold uppercase tracking-[0.25em] text-orange-400">ابدأ الآن</p>
            <h2 class="text-3xl font-black sm:text-5xl">
                هل لديك مشروع يحتاج حضورًا بصريًا حقيقيًا؟
            </h2>
            <p class="mt-5 leading-8 text-white/70">
                دعنا نحول فكرتك إلى عمل بصري فاخر يليق بالبراند، بالمناسبة، وبالصورة التي تريد أن يراك الناس بها.
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