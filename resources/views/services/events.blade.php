@extends('layouts.front')
@section('title','Events')

@section('content')
<section class="onx-section">
  <div class="container">

    <h1 class="fw-bold text-center mb-2">باقات تصوير الحفلات</h1>
    <p class="text-center onx-muted mb-5">
      اختر الباقة المناسبة — رسوم إضافية للتنقل خارج الولاية.
    </p>

    {{-- ✅ احذف align-items-stretch لأنه يسبب تمدد غريب --}}
    <div class="row g-4 justify-content-center">

      @forelse($packages as $p)
        <div class="col-lg-4 d-flex plan-col">
          {{-- ✅ احذف p-4 و h-100 لأننا نتحكم بالـpadding والارتفاع من CSS --}}
          <div class="onx-card onx-plan text-center w-100 {{ $p->is_featured ? 'onx-plan-featured' : '' }}">

            {{-- Badge --}}
            <div class="onx-badge mx-auto mb-3"
                 style="{{ $p->is_featured ? 'border-color:rgba(255,106,0,.45);color:rgba(255,255,255,.9);' : '' }}">
              {{ $p->subtitle ?: ($p->is_featured ? 'الأكثر طلبًا' : 'Package') }}
            </div>

            {{-- Title --}}
            <h3 class="fw-bold mb-2">{{ $p->name }}</h3>

            {{-- Description --}}
            <p class="onx-muted mb-3">
              {{ $p->description ?: 'باقة مناسبة لتوثيق حفلتكم بجودة سينمائية.' }}
            </p>

            {{-- Features --}}
            <div class="features-wrap">

  <ul class="onx-muted mb-0 onx-list package-features-ltr features-list collapsed" dir="ltr">
    @foreach(($p->features ?? []) as $f)
      <li>
        <span class="feat-dot"></span>
        <span class="feat-text">{{ $f }}</span>
      </li>
    @endforeach
  </ul>

  @if(count($p->features ?? []) > 6)
    <button type="button"
            class="btn btn-link onx-more-btn p-0 mt-2"
            onclick="toggleFeatures(this)">
      عرض المزيد
    </button>
  @endif

</div>

            {{-- ✅ هذا الجزء يثبت السعر والزر في الأسفل --}}
            <div class="mt-auto">
              <div class="onx-price mb-3">
                <span class="fw-bold">
                  {{ number_format($p->price) }}
                </span>
                <span class="onx-muted">DA</span>
              </div>

              <a href="{{ route('booking') }}" class="btn btn-onx-book w-100">احجز الآن</a>
            </div>

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

    @if(!empty($travelNote))
      <div class="text-center onx-muted mt-4">{{ $travelNote }}</div>
    @endif

  </div>
</section>
@endsection

@push('scripts')
<script>
function toggleFeatures(btn){
  const list = btn.parentElement.querySelector('.features-list');
  const expanded = list.classList.contains('expanded');

  if(expanded){
    list.classList.remove('expanded');
    list.classList.add('collapsed');
    btn.textContent = 'عرض المزيد';
  }else{
    list.classList.remove('collapsed');
    list.classList.add('expanded');
    btn.textContent = 'إخفاء';
  }
}
</script>

@endpush