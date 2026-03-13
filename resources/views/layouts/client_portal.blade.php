<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'بوابة العملاء - ONX')</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700;800;900&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    @vite(['resources/css/app.css'])
    @vite(['resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.13.5/dist/cdn.min.js"></script>
    <style>
        body { font-family: 'Cairo', sans-serif; }
        [x-cloak] { display: none !important; }
    </style>
    @stack('styles')
</head>
<body class="min-h-screen bg-[#f5f6f8] text-gray-800 antialiased selection:bg-amber-200 selection:text-gray-900">

    {{-- خلفية (الوضع الفاتح؛ الوضع الليلي يُطبّق عبر class على body) --}}
    <div class="fixed inset-0 -z-10 overflow-hidden portal-bg">
        <div class="absolute inset-0 bg-[#f5f6f8]"></div>
        <div class="absolute top-0 right-0 w-[60%] h-[70%] bg-amber-50/80 blur-[100px] rounded-full"></div>
        <div class="absolute bottom-0 left-0 w-[50%] h-[50%] bg-orange-50/60 blur-[80px] rounded-full"></div>
    </div>

    @yield('client_portal_body')

    @stack('scripts')
</body>
</html>
