<!DOCTYPE html>
<html lang="fr" dir="ltr">

<head>
  <meta charset="utf-8">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>ONX </title>
  <meta name="description" content="">
  <meta name="keywords" content="">

  <!-- Favicons -->
  <link href="{{ asset('img/logo2.png') }}" rel="icon">
  <link href="{{ asset('img/apple-touch-icon.png') }}" rel="apple-touch-icon">

  <!-- Fonts -->
  <link href="https://fonts.googleapis.com" rel="preconnect">
  <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Raleway:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <link href="{{ asset('vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
    <link href="{{ asset('vendor/aos/aos.css') }}">
    <link href="{{ asset('vendor/swiper/swiper-bundle.min.css') }}" rel="stylesheet">
    <link href="{{ asset('vendor/glightbox/css/glightbox.min.css') }}" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    


  <!-- Main CSS File -->
  <link href="{{ asset('css/main.css') }}" rel="stylesheet">
  <link href="{{ asset('css/booking.css') }}" rel="stylesheet">
   @yield('styles')
  <style>
        body[dir="rtl"] .text-start {
    text-align: right !important;
    }
 .cont ul {
  list-style: none;
  padding: 0;
}

.cont ul li {
  padding: 10px 0 0 0;
  display: flex;
}

.cont ul i {
  color: var(--accent-color);
  margin-right: 0.5rem;
  margin-left: 0.5rem;
  line-height: 1.2;
  font-size: 1.25rem;
}
  </style>

</head>

<body class="{{ ($data ?? null) === 'index-page' ? 'index-page' : 'starter-page-page' }}">

  <header id="header" class="header d-flex align-items-center fixed-top">
    <div class="container-fluid container-xl position-relative d-flex align-items-center justify-content-between">

      <a href="{{ route('home')}}" class="logo d-flex align-items-center me-auto me-lg-0">
        <h1 class="sitename">ONX</h1>
        <span>.</span>
      </a>

      <nav id="navmenu" class="navmenu">
        <ul>
          <li><a class="nav-link" href="{{ route('home') }}" class="active">{{ __('home.home') }}<br></a></li>
          <li><a class="nav-link" href="{{ url('/#about') }}">{{ __('home.about') }}</a></li>
           <li><a class="nav-link" href="{{ url('/#services') }}">{{ __('home.services') }}</a></li>
          <li><a class="nav-link" href="{{ route('portfolio.index') }}">{{ __('home.portfolio') }}</a></li>
          <li><a class="nav-link" href="{{ url('/#team') }}">{{ __('home.team') }}</a></li>
          <li><a class="nav-link" href="{{ url('/#contact') }}">{{ __('home.contact') }}</a></li>
        </ul>
        <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
      </nav>
      <a class="btn-getstarted"   href="{{ url('/booking') }}">{{ __('home.start') }}</a>


     
</div>
  </header>

@yield('content')

  <footer id="footer" class="footer dark-background">

    <div class="footer-top">
      <div class="container">
        <div class="row gy-4">
          <div class="col-lg-4 col-md-6 footer-about">
            <a href="index.html" class="logo d-flex align-items-center">
              <span class="sitename">{{ $companySettings->company_name }}</span>
            </a>
            <div class="footer-contact pt-3">
              <p>Algerie</p>
              <p>{{ $companySettings->address  ?? 'address ' }}</p>
              <p class="mt-3"><strong>TEL:</strong> <span>{{ $companySettings->phone ?? 'telephone' }}</span></p>
              <p><strong>Email:</strong> <span>{{ $companySettings->email ?? 'email' }}</span></p>
            </div>
            <div class="social-links d-flex mt-4">
              <a href=">{{ $companySettings->facebook }}"><i class="bi bi-facebook"></i></a>
              <a href=">{{ $companySettings->instagram }}"><i class="bi bi-instagram"></i></a>
              <a href=">{{ $companySettings->linkedin }}"><i class="bi bi-linkedin"></i></a>
            </div>
          </div>

          <div class="col-lg-2 col-md-3 footer-links">
            <h4>{{ __('home.useful_links') }}</h4>
            <ul>
              <li><i class="bi bi-chevron-right"></i> <a href="#"> {{ __('home.home') }}</a></li>
              <li><i class="bi bi-chevron-right"></i> <a href="#">{{ __('home.about_us') }}</a></li>
              <li><i class="bi bi-chevron-right"></i> <a href="#"> {{ __('home.services') }}</a></li>
              <li><i class="bi bi-chevron-right"></i> <a href="#"> {{ __('home.terms') }}</a></li>
              <li><i class="bi bi-chevron-right"></i> <a href="#">{{ __('home.privacy') }}</a></li>
            </ul>
          </div>

          <div class="col-lg-4 col-md-5 footer-links">
            <h4>{{ __('home.our_services') }}</h4>
            <ul>
              <li><i class="bi bi-chevron-right"></i> <a href="#"> Production Audiovisuelle</a></li>
              <li><i class="bi bi-chevron-right"></i> <a href="#"> Organisation d’Événements (Événementiel)</a></li>
              <li><i class="bi bi-chevron-right"></i> <a href="#">Conception de Logos et Graphisme</a></li>
              <li><i class="bi bi-chevron-right"></i> <a href="#">Développement Web</a></li>
              <li><i class="bi bi-chevron-right"></i> <a href="#">Gestion des Réseaux Sociaux</a></li>
            </ul>
          </div>


        </div>
      </div>
    </div>

    <div class="copyright">
      <div class="container text-center">
        <p>© <span>Copyright</span> <strong class="px-1 sitename">ONX</strong> <span>All Rights Reserved</span></p>
        <div class="credits">
          Designed by <a href=" ">S.H</a>
        </div>
      </div>
    </div>

  </footer>

  <!-- Scroll Top -->
  <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>


<!-- jQuery: يجب أن يكون أولًا -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Bootstrap (يستخدم jQuery في بعض المكونات) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<!-- Select2 -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<!-- AngularJS (إذا كنت تستعمله لاحقًا في الكود) -->
<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.8.2/angular.min.js"></script>

<!-- بقية السكربتات -->
<script src="{{ asset('vendor/php-email-form/validate.js') }}"></script>
<script src="{{ asset('vendor/aos/aos.js') }}"></script>
<script src="{{ asset('vendor/swiper/swiper-bundle.min.js') }}"></script>
<script src="{{ asset('vendor/glightbox/js/glightbox.min.js') }}"></script>
<script src="{{ asset('vendor/imagesloaded/imagesloaded.pkgd.min.js') }}"></script>
<script src="{{ asset('vendor/isotope-layout/isotope.pkgd.min.js') }}"></script>
<script src="{{ asset('vendor/purecounter/purecounter_vanilla.js') }}"></script>
<script>
    window.addEventListener('scroll', function () {
  const body = document.body;
  const header = document.querySelector('.header');
  if (window.scrollY > 50) {
    body.classList.add('scrolled');
    header.classList.add('scrolled');
  } else {
    body.classList.remove('scrolled');
    header.classList.remove('scrolled');
  }
});

  // إظهار زر الصعود عند التمرير
  const scrollTopBtn = document.getElementById('scroll-top');

  window.addEventListener('scroll', () => {
    if (window.scrollY > 300) {
      scrollTopBtn.classList.add('active'); // نُفعّل الزر
    } else {
      scrollTopBtn.classList.remove('active'); // نخفيه
    }
  });

  // عند الضغط عليه نعود للأعلى
  scrollTopBtn.addEventListener('click', (e) => {
    e.preventDefault();
    window.scrollTo({ top: 0, behavior: 'smooth' });
  });
    </script>


@yield('scripts')

</body>

</html>
