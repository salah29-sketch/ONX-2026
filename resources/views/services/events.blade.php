@extends('layouts.front')
@section('title','Events')

@section('content')

<section class="onx-section">
  <div class="container">

    <h1 class="fw-bold text-center mb-2">باقات تصوير الحفلات</h1>
    <p class="text-center onx-muted mb-5">
      اختر الباقة المناسبة — رسوم إضافية للتنقل خارج الولاية.
    </p>

    <div class="row g-4 align-items-stretch justify-content-center">

      @forelse($packages as $p)

        <div class="col-lg-4">
          <div class="onx-card onx-plan p-4 text-center h-100 {{ $p->is_featured ? 'onx-plan-featured' : '' }}">

            {{-- Badge --}}
            <div class="onx-badge mx-auto mb-3"
                 style="{{ $p->is_featured ? 'border-color:rgba(255,106,0,.45);color:rgba(255,255,255,.9);' : '' }}">
              {{ $p->subtitle ?: ($p->is_featured ? 'الأكثر طلبًا' : 'Package') }}
            </div>

            {{-- Title --}}
            <h3 class="fw-bold mb-2">{{ $p->name }}</h3>

            {{-- Description --}}
            @if($p->description)
              <p class="onx-muted mb-4">{{ $p->description }}</p>
            @else
              <p class="onx-muted mb-4">باقة مناسبة لتوثيق حفلتكم بجودة سينمائية.</p>
            @endif

            {{-- Features --}}
            <ul class="text-start onx-muted mb-4 onx-list">
              @foreach(($p->features ?? []) as $f)
                <li>{{ $f }}</li>
              @endforeach
            </ul>

            {{-- Price --}}
            <div class="onx-price mb-4">
               <span class="fw-bold" style="font-size:{{ $p->is_featured ? '32px' : '28px' }};">
                {{ number_format($p->price) }}
                 </span>
               <span class="onx-muted">DA</span>
            </div>

            {{-- Booking --}}
            <a href="{{ route('booking') }}" class="btn btn-onx-book w-100">احجز الآن</a>

          </div>
        </div>

      @empty

        <div class="col-lg-8">
          <div class="onx-card p-4 text-center">
            <h4 class="fw-bold mb-2">لا توجد باقات بعد</h4>
            <p class="onx-muted mb-0">أضف الباقات من لوحة التحكم (Admin).</p>
          </div>
        </div>

      @endforelse

    </div>

    {{-- Travel note (اختياري من الكنترولر) --}}
    @if(!empty($travelNote))
      <div class="text-center onx-muted mt-4">{{ $travelNote }}</div>
    @endif

  </div>
</section>

@endsection