{{-- resources/views/front/packages/index.blade.php --}}
@extends('layouts.front')

@section('title', 'باقاتنا')

@section('content')

<style>
    /* ── Google Fonts ── */
    @import url('https://fonts.googleapis.com/css2?family=Tajawal:wght@300;400;500;700;900&display=swap');

    .packages-page { font-family: 'Tajawal', sans-serif; }

    /* ── بطاقة الباقة ── */
    .pkg-card {
        transition: transform 0.25s ease, box-shadow 0.25s ease, border-color 0.25s ease;
    }
    .pkg-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 20px 40px rgba(0,0,0,0.12);
    }
    .pkg-card.featured {
        border-color: #D4AF37;
        box-shadow: 0 8px 30px rgba(212,175,55,0.2);
    }
    .pkg-card.selected-for-compare {
        border-color: #3B82F6;
        box-shadow: 0 8px 30px rgba(59,130,246,0.25);
    }

    /* ── الشريط السفلي للمقارنة ── */
    #compare-bar {
        transition: transform 0.35s cubic-bezier(0.34, 1.56, 0.64, 1);
    }
    #compare-bar.hidden-bar {
        transform: translateY(100%);
    }

    /* ── جدول المقارنة ── */
    .compare-table th { background: #1E293B; color: #F8FAFC; }
    .compare-table td { border-bottom: 1px solid #E2E8F0; }
    .compare-table tr:last-child td { border-bottom: none; }

    /* ── الفلتر النشط ── */
    .filter-btn.active {
        background: #1E293B;
        color: #fff;
    }

    /* ── badge ── */
    .badge-featured {
        background: linear-gradient(135deg, #D4AF37 0%, #F5D060 100%);
        color: #1a1a1a;
    }

    /* ── تحريك البطاقات عند الظهور ── */
    @keyframes fadeUp {
        from { opacity: 0; transform: translateY(20px); }
        to   { opacity: 1; transform: translateY(0); }
    }
    .pkg-card { animation: fadeUp 0.4s ease both; }
</style>

<div class="packages-page min-h-screen bg-slate-50" x-data="packagesApp()" x-init="init()">

    {{-- ══════════════════ Hero ══════════════════ --}}
    <div class="bg-slate-900 text-white py-16 px-4 text-center">
        <h1 class="text-4xl md:text-5xl font-black mb-3">اختر باقتك المثالية</h1>
        <p class="text-slate-400 text-lg max-w-xl mx-auto">باقات مصممة لتناسب احتياجاتك سواء كانت حفل، إعلان، أو مشروع تجاري</p>
    </div>

    {{-- ══════════════════ الفلاتر ══════════════════ --}}
    <div class="sticky top-0 z-30 bg-white shadow-sm border-b border-slate-100">
        <div class="max-w-6xl mx-auto px-4 py-3 flex flex-wrap gap-2 items-center justify-between">

            {{-- أزرار النوع --}}
            <div class="flex gap-2">
                <button @click="setFilter('all')"
                        :class="{ 'active': filter === 'all' }"
                        class="filter-btn px-4 py-2 rounded-full text-sm font-bold border border-slate-200 text-slate-700 transition-all">
                    الكل
                </button>
                <button @click="setFilter('event')"
                        :class="{ 'active': filter === 'event' }"
                        class="filter-btn px-4 py-2 rounded-full text-sm font-bold border border-slate-200 text-slate-700 transition-all">
                    📸 باقات التصوير
                </button>
                <button @click="setFilter('ad')"
                        :class="{ 'active': filter === 'ad' }"
                        class="filter-btn px-4 py-2 rounded-full text-sm font-bold border border-slate-200 text-slate-700 transition-all">
                    📢 باقات الإعلان
                </button>
            </div>

            {{-- زر المقارنة --}}
            <button x-show="compareList.length >= 2"
                    @click="showCompareModal = true"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-full text-sm font-bold transition-all flex items-center gap-2">
                <span>مقارنة</span>
                <span class="bg-white text-blue-600 rounded-full w-5 h-5 text-xs flex items-center justify-center font-black"
                      x-text="compareList.length"></span>
            </button>
        </div>
    </div>

    {{-- ══════════════════ شبكة الباقات ══════════════════ --}}
    <div class="max-w-6xl mx-auto px-4 py-10">

        {{-- باقات التصوير --}}
        <template x-if="filter === 'all' || filter === 'event'">
            <div>
                <template x-if="filter === 'all'">
                    <h2 class="text-2xl font-black text-slate-800 mb-6 flex items-center gap-2">
                        <span class="w-1 h-7 bg-amber-400 rounded-full inline-block"></span>
                        باقات التصوير
                    </h2>
                </template>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-12">
                    @foreach($eventPackages as $index => $pkg)
                    <div class="pkg-card bg-white rounded-2xl border-2 p-6 flex flex-col cursor-pointer
                                {{ $pkg['is_featured'] ? 'featured' : 'border-slate-100' }}"
                         style="animation-delay: {{ $index * 0.07 }}s"
                         :class="{ 'selected-for-compare': isInCompare('event', {{ $pkg['id'] }}) }">

                        {{-- الرأس --}}
                        <div class="flex items-start justify-between mb-4">
                            <div>
                                @if($pkg['is_featured'])
                                <span class="badge-featured text-xs font-black px-3 py-1 rounded-full inline-block mb-2">⭐ الأكثر طلباً</span>
                                @endif
                                <h3 class="text-xl font-black text-slate-900">{{ $pkg['name'] }}</h3>
                                @if($pkg['subtitle'])
                                <p class="text-slate-500 text-sm mt-0.5">{{ $pkg['subtitle'] }}</p>
                                @endif
                            </div>
                        </div>

                        {{-- السعر --}}
                        <div class="mb-5">
                            @if($pkg['price'])
                            <div class="flex items-baseline gap-2">
                                <span class="text-3xl font-black text-slate-900">{{ number_format($pkg['price'], 0) }}</span>
                                <span class="text-slate-500 text-sm">دج</span>
                                @if($pkg['old_price'])
                                <span class="text-slate-400 line-through text-sm">{{ number_format($pkg['old_price'], 0) }} دج</span>
                                @endif
                            </div>
                            @else
                            <span class="text-lg font-bold text-amber-600">حسب الطلب</span>
                            @endif
                        </div>

                        {{-- الوصف --}}
                        @if($pkg['description'])
                        <p class="text-slate-600 text-sm mb-5 leading-relaxed">{{ $pkg['description'] }}</p>
                        @endif

                        {{-- المميزات --}}
                        @if($pkg['features'])
                        <ul class="space-y-2 mb-6 flex-1">
                            @foreach(is_array($pkg['features']) ? $pkg['features'] : json_decode($pkg['features'], true) ?? [] as $feature)
                            <li class="flex items-start gap-2 text-sm text-slate-700">
                                <svg class="w-4 h-4 text-emerald-500 mt-0.5 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" clip-rule="evenodd"/>
                                </svg>
                                {{ $feature }}
                            </li>
                            @endforeach
                        </ul>
                        @endif

                        {{-- الأزرار --}}
                        <div class="mt-auto space-y-2">
                            <a href="{{ route('front.booking') }}?package_id={{ $pkg['id'] }}&type=event"
                               class="block w-full text-center py-3 rounded-xl font-bold text-sm transition-all
                                      {{ $pkg['is_featured'] ? 'bg-amber-400 hover:bg-amber-500 text-slate-900' : 'bg-slate-900 hover:bg-slate-700 text-white' }}">
                                احجز الآن
                            </a>
                            <button @click="toggleCompare('event', {{ $pkg['id'] }}, '{{ addslashes($pkg['name']) }}')"
                                    class="block w-full text-center py-2 rounded-xl text-xs font-bold border transition-all"
                                    :class="isInCompare('event', {{ $pkg['id'] }})
                                        ? 'border-blue-400 text-blue-600 bg-blue-50'
                                        : 'border-slate-200 text-slate-500 hover:border-blue-300 hover:text-blue-500'">
                                <span x-text="isInCompare('event', {{ $pkg['id'] }}) ? '✓ تمت الإضافة للمقارنة' : '+ أضف للمقارنة'"></span>
                            </button>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </template>

        {{-- باقات الإعلان --}}
        <template x-if="filter === 'all' || filter === 'ad'">
            <div>
                <template x-if="filter === 'all'">
                    <h2 class="text-2xl font-black text-slate-800 mb-6 flex items-center gap-2">
                        <span class="w-1 h-7 bg-blue-400 rounded-full inline-block"></span>
                        باقات الإعلان
                    </h2>
                </template>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($adPackages as $index => $pkg)
                    <div class="pkg-card bg-white rounded-2xl border-2 p-6 flex flex-col
                                {{ $pkg['is_featured'] ? 'featured' : 'border-slate-100' }}"
                         style="animation-delay: {{ $index * 0.07 }}s"
                         :class="{ 'selected-for-compare': isInCompare('ad', {{ $pkg['id'] }}) }">

                        {{-- الرأس --}}
                        <div class="flex items-start justify-between mb-4">
                            <div>
                                @if($pkg['is_featured'])
                                <span class="badge-featured text-xs font-black px-3 py-1 rounded-full inline-block mb-2">⭐ الأكثر طلباً</span>
                                @endif
                                @if($pkg['type'] === 'monthly')
                                <span class="bg-blue-100 text-blue-700 text-xs font-bold px-2 py-0.5 rounded-full inline-block mb-2">شهري</span>
                                @else
                                <span class="bg-purple-100 text-purple-700 text-xs font-bold px-2 py-0.5 rounded-full inline-block mb-2">مخصص</span>
                                @endif
                                <h3 class="text-xl font-black text-slate-900">{{ $pkg['name'] }}</h3>
                                @if($pkg['subtitle'])
                                <p class="text-slate-500 text-sm mt-0.5">{{ $pkg['subtitle'] }}</p>
                                @endif
                            </div>
                        </div>

                        {{-- السعر --}}
                        <div class="mb-5">
                            @if($pkg['price'])
                            <div class="flex items-baseline gap-2">
                                <span class="text-3xl font-black text-slate-900">{{ number_format($pkg['price'], 0) }}</span>
                                <span class="text-slate-500 text-sm">دج</span>
                                @if($pkg['old_price'])
                                <span class="text-slate-400 line-through text-sm">{{ number_format($pkg['old_price'], 0) }} دج</span>
                                @endif
                            </div>
                            @if($pkg['price_note'])
                            <p class="text-amber-600 text-xs mt-1 font-medium">{{ $pkg['price_note'] }}</p>
                            @endif
                            @else
                            <span class="text-lg font-bold text-amber-600">{{ $pkg['price_note'] ?? 'حسب الطلب' }}</span>
                            @endif
                        </div>

                        {{-- الوصف --}}
                        @if($pkg['description'])
                        <p class="text-slate-600 text-sm mb-5 leading-relaxed">{{ $pkg['description'] }}</p>
                        @endif

                        {{-- المميزات --}}
                        @if($pkg['features'])
                        <ul class="space-y-2 mb-6 flex-1">
                            @foreach(is_array($pkg['features']) ? $pkg['features'] : json_decode($pkg['features'], true) ?? [] as $feature)
                            <li class="flex items-start gap-2 text-sm text-slate-700">
                                <svg class="w-4 h-4 text-emerald-500 mt-0.5 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" clip-rule="evenodd"/>
                                </svg>
                                {{ $feature }}
                            </li>
                            @endforeach
                        </ul>
                        @endif

                        {{-- الأزرار --}}
                        <div class="mt-auto space-y-2">
                            <a href="{{ route('front.booking') }}?package_id={{ $pkg['id'] }}&type=ad"
                               class="block w-full text-center py-3 rounded-xl font-bold text-sm transition-all
                                      {{ $pkg['is_featured'] ? 'bg-amber-400 hover:bg-amber-500 text-slate-900' : 'bg-slate-900 hover:bg-slate-700 text-white' }}">
                                احجز الآن
                            </a>
                            <button @click="toggleCompare('ad', {{ $pkg['id'] }}, '{{ addslashes($pkg['name']) }}')"
                                    class="block w-full text-center py-2 rounded-xl text-xs font-bold border transition-all"
                                    :class="isInCompare('ad', {{ $pkg['id'] }})
                                        ? 'border-blue-400 text-blue-600 bg-blue-50'
                                        : 'border-slate-200 text-slate-500 hover:border-blue-300 hover:text-blue-500'">
                                <span x-text="isInCompare('ad', {{ $pkg['id'] }}) ? '✓ تمت الإضافة للمقارنة' : '+ أضف للمقارنة'"></span>
                            </button>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </template>

        {{-- رسالة فارغة --}}
        <template x-if="filter !== 'all' && filter !== 'event' && filter !== 'ad'">
            <div class="text-center py-20 text-slate-400">
                <p class="text-5xl mb-4">📦</p>
                <p class="text-xl font-bold">لا توجد باقات متاحة</p>
            </div>
        </template>
    </div>

    {{-- ══════════════════ Modal المقارنة ══════════════════ --}}
    <div x-show="showCompareModal"
         x-cloak
         @keydown.escape.window="showCompareModal = false"
         class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/70 backdrop-blur-sm">

        <div @click.outside="showCompareModal = false"
             class="bg-white rounded-2xl shadow-2xl w-full max-w-4xl max-h-[90vh] overflow-auto">

            <div class="flex items-center justify-between p-6 border-b border-slate-100">
                <h3 class="text-xl font-black text-slate-900">مقارنة الباقات</h3>
                <button @click="showCompareModal = false"
                        class="text-slate-400 hover:text-slate-700 text-2xl leading-none">×</button>
            </div>

            <div class="p-6 overflow-x-auto">
                <table class="compare-table w-full text-sm text-right border-collapse">
                    <thead>
                        <tr>
                            <th class="p-3 text-right rounded-tl-lg">الخاصية</th>
                            <template x-for="pkg in compareList" :key="pkg.uid">
                                <th class="p-3 text-center min-w-[140px]" x-text="pkg.name"></th>
                            </template>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- السعر --}}
                        <tr class="hover:bg-slate-50">
                            <td class="p-3 font-bold text-slate-700">💰 السعر</td>
                            <template x-for="pkg in compareList" :key="pkg.uid">
                                <td class="p-3 text-center font-black text-slate-900" x-text="pkg.price ? pkg.price + ' دج' : 'حسب الطلب'"></td>
                            </template>
                        </tr>
                        {{-- نوع الباقة --}}
                        <tr class="hover:bg-slate-50">
                            <td class="p-3 font-bold text-slate-700">📁 النوع</td>
                            <template x-for="pkg in compareList" :key="pkg.uid">
                                <td class="p-3 text-center text-slate-600" x-text="pkg.type === 'event' ? 'تصوير' : 'إعلان'"></td>
                            </template>
                        </tr>
                        {{-- مميز --}}
                        <tr class="hover:bg-slate-50">
                            <td class="p-3 font-bold text-slate-700">⭐ الأكثر طلباً</td>
                            <template x-for="pkg in compareList" :key="pkg.uid">
                                <td class="p-3 text-center" x-text="pkg.is_featured ? '✓' : '—'"></td>
                            </template>
                        </tr>
                        {{-- المميزات --}}
                        <template x-for="(feature, i) in allFeatures" :key="i">
                            <tr class="hover:bg-slate-50">
                                <td class="p-3 text-slate-700" x-text="feature"></td>
                                <template x-for="pkg in compareList" :key="pkg.uid">
                                    <td class="p-3 text-center">
                                        <span x-text="pkg.features && pkg.features.includes(feature) ? '✅' : '❌'"></span>
                                    </td>
                                </template>
                            </tr>
                        </template>
                    </tbody>
                </table>
            </div>

            <div class="p-6 border-t border-slate-100 flex flex-wrap gap-3 justify-end">
                <template x-for="pkg in compareList" :key="pkg.uid">
                    <a :href="`{{ url(route('front.booking')) }}?package_id=${pkg.id}&type=${pkg.type}`"
                       class="bg-slate-900 hover:bg-slate-700 text-white px-6 py-2 rounded-xl font-bold text-sm transition-all">
                        احجز <span x-text="pkg.name"></span>
                    </a>
                </template>
                <button @click="clearCompare()"
                        class="border border-slate-200 text-slate-500 hover:text-red-500 hover:border-red-200 px-6 py-2 rounded-xl font-bold text-sm transition-all">
                    مسح الكل
                </button>
            </div>
        </div>
    </div>

</div>

{{-- ══════════════════ Alpine.js ══════════════════ --}}
<script>
function packagesApp() {
    return {
        filter: 'all',
        compareList: [],
        showCompareModal: false,

        // ── بيانات الباقات لجدول المقارنة ──
        allPackages: {
            event: @json($eventPackages),
            ad:    @json($adPackages),
        },

        init() {
            // يمكن استعادة قائمة المقارنة من sessionStorage إن أردت
        },

        setFilter(f) {
            this.filter = f;
        },

        isInCompare(type, id) {
            return this.compareList.some(p => p.type === type && p.id === id);
        },

        toggleCompare(type, id, name) {
            if (this.isInCompare(type, id)) {
                this.compareList = this.compareList.filter(p => !(p.type === type && p.id === id));
                return;
            }
            if (this.compareList.length >= 3) {
                alert('يمكنك مقارنة 3 باقات كحد أقصى');
                return;
            }
            // ابحث عن بيانات الباقة الكاملة
            const pkg = this.allPackages[type].find(p => p.id === id);
            this.compareList.push({
                uid:        type + '-' + id,
                id:         id,
                type:       type,
                name:       name,
                price:      pkg?.price ?? null,
                is_featured: pkg?.is_featured ?? false,
                features:   pkg?.features ? (Array.isArray(pkg.features) ? pkg.features : JSON.parse(pkg.features)) : [],
            });
        },

        clearCompare() {
            this.compareList = [];
            this.showCompareModal = false;
        },

        // جمع كل المميزات الفريدة من الباقات المختارة
        get allFeatures() {
            const set = new Set();
            this.compareList.forEach(pkg => {
                (pkg.features || []).forEach(f => set.add(f));
            });
            return [...set];
        },
    }
}
</script>

@endsection