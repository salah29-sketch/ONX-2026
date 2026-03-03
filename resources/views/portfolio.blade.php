@extends('layouts.layout')

@section('styles')
<link href="https://cdn.jsdelivr.net/npm/glightbox/dist/css/glightbox.min.css" rel="stylesheet" />

<style>

  /* ===== Portfolio Item Hover ===== */
  .portfolio-item {
    overflow: hidden;
    border-radius: 12px;
    position: relative;
  }

  .portfolio-item img {
    width: 100%;
    aspect-ratio: 4 / 3;   /* 🔥 النسبة المطلوبة */
    object-fit: cover;     /* يمنع التشويه */
    display: block;
    transition: transform 0.4s ease;
    border-radius: 12px;
  }

  .portfolio-item:hover img {
    transform: scale(1.05);
  }

  .portfolio-overlay {
    position: absolute;
    inset: 0;
    background: rgba(0, 0, 0, 0.55);
    opacity: 0;
    transition: 0.4s ease;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 20px;
  }

  .portfolio-item:hover .portfolio-overlay {
    opacity: 1;
  }

  /* ===== Gallery Layout ===== */
  .gallery-container {
    padding: 50px 20px;
    background: #f9f9f9;
  }

  .gallery-filters {
    text-align: center;
    margin-bottom: 30px;
  }

  .gallery-filters .btn {
    margin: 0 5px;
  }

  .gallery-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 20px;
  }

  .page-title .heading {
    background-image: url('{{ asset("img/portfolio.jpg") }}');
    background-size: cover;
    background-position: center;
  }
  .portfolio-img{
  width: 100%;
  aspect-ratio: 4 / 3;
  object-fit: cover;
  display: block;
  border-radius: 12px;
</style>
@endsection

@section('content')
<main class="main">

  <!-- Page Title -->
  <div class="page-title" data-aos="fade">
    <div class="heading">
      <div class="container">
        <div class="row d-flex justify-content-center text-center">
          <div class="col-lg-8"></div>
        </div>
      </div>
    </div>

    <nav class="breadcrumbs">
      <div class="container">
        <ol>
          <li><a href="{{ url('/') }}">Home</a></li>
          <li class="current">Portfolio</li>
        </ol>
      </div>
    </nav>
  </div>

  <section class="gallery-container">
    <div class="container">

      <!-- Filters -->
      <div class="gallery-filters">
        <a href="{{ route('portfolio') }}"
           class="btn btn-custom-filter {{ empty($filter) ? 'active' : '' }}">
           الكل
        </a>

        @foreach ($categories as $key => $label)
          <a href="{{ route('portfolio', ['category' => $key]) }}"
             class="btn btn-custom-filter {{ ($filter === $key) ? 'active' : '' }}">
             {{ $label }}
          </a>
        @endforeach
      </div>

      <!-- Gallery Grid -->
      <div id="gallery-grid" class="gallery-grid">
        @include('partials._gallery_items', ['items' => $items])
      </div>

      <!-- Load More -->
      @if(method_exists($items, 'count') ? $items->count() : count($items))
        <div class="text-center mt-4">
          <button
            id="load-more"
            class="btn btn-custom-filter"
            data-page="2"
            data-filter="{{ $filter ?? '' }}"
            data-url="{{ route('portfolio') }}"
          >
            <span class="btn-text">تحميل المزيد</span>
            <span class="spinner-border spinner-border-sm d-none"></span>
          </button>
        </div>
      @endif

    </div>
  </section>

</main>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/glightbox/dist/js/glightbox.min.js"></script>

<script>
  const lightbox = GLightbox({
    selector: '.glightbox',
    touchNavigation: true,
    loop: true,
    zoomable: true,
    autoplayVideos: true
  });

  const loadMoreBtn = document.getElementById('load-more');

  if (loadMoreBtn) {
    loadMoreBtn.addEventListener('click', function () {
      const button = this;
      const page = button.dataset.page;
      const baseUrl = button.dataset.url;
      const filter = button.dataset.filter;

      const params = new URLSearchParams();
      if (filter) params.set('category', filter);
      params.set('page', page);

      const url = baseUrl + '?' + params.toString();

      const btnText = button.querySelector('.btn-text');
      const spinner = button.querySelector('.spinner-border');

      btnText.textContent = 'جار التحميل...';
      spinner.classList.remove('d-none');
      button.disabled = true;

      fetch(url, { headers: { 'X-Requested-With': 'XMLHttpRequest' }})
        .then(res => res.text())
        .then(data => {
          if (data.trim() === '') {
            btnText.textContent = 'لا مزيد من الصور';
            spinner.classList.add('d-none');
          } else {
            document.getElementById('gallery-grid')
              .insertAdjacentHTML('beforeend', data);
            lightbox.reload();
            button.dataset.page = parseInt(page, 10) + 1;
            btnText.textContent = 'تحميل المزيد';
            spinner.classList.add('d-none');
            button.disabled = false;
          }
        })
        .catch(() => {
          btnText.textContent = 'حدث خطأ';
          spinner.classList.add('d-none');
          button.disabled = false;
        });
    });
  }
</script>
@endsection