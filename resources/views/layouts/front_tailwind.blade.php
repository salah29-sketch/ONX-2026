<!doctype html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'ONX')</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700;800;900&display=swap" rel="stylesheet">

    <script type="module" src="http://localhost:5173/@vite/client"></script>
<script type="module" src="http://localhost:5173/resources/js/app.js"></script>

    <style>
        body { font-family: 'Cairo', sans-serif; }
    </style>
</head>
<body class="bg-[#050505] text-white antialiased selection:bg-orange-500/30 selection:text-white">

    {{-- الخلفية العامة --}}
    <div class="fixed inset-0 -z-10 overflow-hidden">
        <div class="absolute inset-0 bg-[radial-gradient(circle_at_top,rgba(255,106,0,0.16),transparent_32%),radial-gradient(circle_at_80%_20%,rgba(255,255,255,0.05),transparent_22%),linear-gradient(to_bottom,#070707,#050505,#020202)]"></div>
        <div class="absolute -top-24 right-[-120px] h-80 w-80 rounded-full bg-orange-500/10 blur-3xl"></div>
        <div class="absolute bottom-[-120px] left-[-100px] h-96 w-96 rounded-full bg-orange-400/10 blur-3xl"></div>
    </div>

    {{-- NAVBAR --}}
    <header class="sticky top-0 z-50 border-b border-white/10 bg-black/40 backdrop-blur-xl">
        <div class="mx-auto flex max-w-7xl items-center justify-between px-6 py-4 lg:px-8">
            <a href="/" class="flex items-center gap-2">
                <span class="text-2xl font-black tracking-[0.18em] text-white">ONX</span>
                <span class="h-2.5 w-2.5 rounded-full bg-orange-500 shadow-[0_0_20px_rgba(249,115,22,0.8)]"></span>
            </a>

            <nav class="hidden items-center gap-8 text-sm font-bold text-white/70 lg:flex">
                <a href="/" class="transition hover:text-white">الرئيسية</a>
                <a href="/services" class="transition hover:text-white">الخدمات</a>
                <a href="/portfolio" class="transition hover:text-white">الأعمال</a>
                <a href="/booking" class="transition hover:text-white">الحجز</a>
            </nav>

            <a href="/booking"
               class="hidden rounded-full border border-orange-500/40 bg-orange-500/10 px-5 py-2.5 text-sm font-extrabold text-white transition duration-300 hover:-translate-y-0.5 hover:border-orange-400 hover:bg-orange-500/20 hover:shadow-[0_0_24px_rgba(249,115,22,0.25)] lg:inline-flex">
                ابدأ مشروعك
            </a>
        </div>
    </header>

    <main>
        @yield('content')
    </main>

    {{-- FOOTER --}}
    <footer class="mt-24 border-t border-white/10 bg-black/50">
        <div class="mx-auto grid max-w-7xl gap-10 px-6 py-14 lg:grid-cols-3 lg:px-8">
            <div>
                <div class="mb-4 flex items-center gap-2">
                    <span class="text-2xl font-black tracking-[0.18em]">ONX</span>
                    <span class="h-2.5 w-2.5 rounded-full bg-orange-500"></span>
                </div>
                <p class="max-w-md leading-8 text-white/65">
                    إنتاج بصري فاخر للإعلانات والحفلات والمشاريع التي تحتاج صورة تُرى وتُحَس، لا مجرد فيديو يمر مرور الكرام.
                </p>
            </div>

            <div>
                <h3 class="mb-4 text-lg font-extrabold">روابط مهمة</h3>
                <ul class="space-y-3 text-white/65">
                    <li><a href="/" class="transition hover:text-white">الرئيسية</a></li>
                    <li><a href="/services" class="transition hover:text-white">الخدمات</a></li>
                    <li><a href="/portfolio" class="transition hover:text-white">الأعمال</a></li>
                    <li><a href="/booking" class="transition hover:text-white">الحجز</a></li>
                </ul>
            </div>

            <div>
                <h3 class="mb-4 text-lg font-extrabold">تواصل</h3>
                <div class="flex flex-wrap gap-3">
                    <a href="https://wa.me/213540573518" target="_blank"
                       class="rounded-full border border-white/10 bg-white/5 px-4 py-2 text-sm font-bold text-white/80 transition hover:border-orange-500/50 hover:bg-orange-500/10 hover:text-white">
                        واتساب
                    </a>
                    <a href="tel:+213540573518"
                       class="rounded-full border border-white/10 bg-white/5 px-4 py-2 text-sm font-bold text-white/80 transition hover:border-orange-500/50 hover:bg-orange-500/10 hover:text-white">
                        اتصال
                    </a>
                    <a href="/booking"
                       class="rounded-full border border-white/10 bg-white/5 px-4 py-2 text-sm font-bold text-white/80 transition hover:border-orange-500/50 hover:bg-orange-500/10 hover:text-white">
                        احجز الآن
                    </a>
                </div>
            </div>
        </div>

        <div class="border-t border-white/10 py-5 text-center text-sm text-white/40">
            © ONX — onx-edge.com
        </div>
    </footer>

</body>
</html>