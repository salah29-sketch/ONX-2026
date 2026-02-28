@extends('layouts.layout')

@section('styles')
<link href="https://cdn.jsdelivr.net/npm/glightbox/dist/css/glightbox.min.css" rel="stylesheet" />
<style>
.gallery-container { padding: 50px 20px; background: #f9f9f9; }
.gallery-filters { text-align: center; margin-bottom: 30px; }
.gallery-filters .btn { margin: 0 5px; }
.gallery-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
  gap: 15px;
}
.gallery-grid img {
  width: 100%;
  border-radius: 8px;
  transition: 0.3s;
}
.gallery-grid img:hover {
  transform: scale(1.03);
}

.page-title .heading{

    background-image: url('img/portfolio.jpg');
}

</style>
@endsection

@section('content')

  <main class="main">
   <!-- Page Title -->
       <!-- Page Title -->
    <div class="page-title" data-aos="fade">
      <div class="heading">
        <div class="container">
          <div class="row d-flex justify-content-center text-center">
            <div class="col-lg-8">
            </div>
          </div>
        </div>
      </div>
      <nav class="breadcrumbs">
        <div class="container">
          <ol>
            <li><a href="index.html">Home</a></li>
            <li class="current">Portfolio Details</li>
          </ol>
        </div>
      </nav>
    </div><!-- End Page Title -->



<section class="gallery-container">
  <div class="container">
    <h2 class="text-center">   </h2>
    <!-- ✅ الفلاتر -->
    <div class="gallery-filters">
      <a href="{{ route('portfolio') }}" class="btn btn-custom-filter {{ !$filter ? 'active' : '' }}">الكل</a>
      @foreach ($categories as $key => $label)
        <a href="{{ route('portfolio', ['category' => $key]) }}"
           class="btn btn-custom-filter {{ $filter == $key ? 'active' : '' }}">{{ $label }}</a>
      @endforeach
    </div>

        <!-- ✅ الشبكة -->
        <div id="gallery-grid" class="gallery-grid">
        @include('partials._gallery_items', ['items' => $items])
        </div>

        <!-- ✅ زر التحميل -->
        <div class="text-center mt-4">
<button id="load-more"
        class="btn btn-custom-filter"
        data-page="2"
        data-url="{{ route('portfolio') }}?category={{ $filter }}">
    <span class="btn-text">تحميل المزيد</span>
    <span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
</button>
    </div>


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

document.getElementById('load-more').addEventListener('click', function () {
    let button = this;
    let page = button.dataset.page;
    let url = button.dataset.url + '&page=' + page;

    // العناصر الداخلية
    let btnText = button.querySelector('.btn-text');
    let spinner = button.querySelector('.spinner-border');

    // عرض التحميل
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
                document.getElementById('gallery-grid').insertAdjacentHTML('beforeend', data);
                lightbox.reload();
                button.dataset.page = parseInt(page) + 1;
                btnText.textContent = 'تحميل المزيد';
                spinner.classList.add('d-none');
                button.disabled = false;
            }
        })
        .catch(err => {
            console.error(err);
            btnText.textContent = 'حدث خطأ';
            spinner.classList.add('d-none');
            button.disabled = false;
        });
});

</script>
@endsection
