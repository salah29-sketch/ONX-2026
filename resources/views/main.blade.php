@extends('layouts.layout')

@section('content')


  <main class="main">
    <!-- Hero Section -->
    <section id="hero" class="hero section dark-background">

      <img src="{{ asset('img/hero-bg1.jpg') }}" alt="" data-aos="fade-in">

      <div class="container">

        <div class="row justify-content-center text-center" data-aos="fade-up" data-aos-delay="100">
          <div class="col-xl-6 col-lg-8">
            <h2> {!!  editable('hero_title', 'Donnez vie à vos moments les plus importants') !!}<span>.</span></h2>
            <p> {!! editable('hero_desc', 'Vers une communication innovante') !!}</p>
          </div>
        </div>

        <div class="row gy-4 mt-5 justify-content-center" data-aos="fade-up" data-aos-delay="200">
              @foreach ([1 => 'Production', 2 => 'Émotion', 3 => 'Création', 4 => 'Digital', 5 => 'Excellence'] as $i => $default)
      <div class="col-xl-2 col-md-4" data-aos="fade-up" data-aos-delay="{{ 200 + $i * 100 }}">
        <div class="icon-box">
          <i class="bi {{ ['','bi-camera-reels','bi-stars','bi-vector-pen','bi-code-slash','bi-gem'][$i] }}"></i>
          <h3><a href="#" data-key="hero_box_{{ $i }}">{{ editable('hero_box_' . $i, $default) }}</a></h3>
        </div>
      </div>
      @endforeach
        </div>
      </div>
    </section><!-- /Hero Section -->

    <!-- About Section -->
    <section id="about" class="about section">

      <div class="container" data-aos="fade-up" data-aos-delay="100">

        <div class="row gy-4">
          <div class="col-lg-6 order-1 order-lg-2">
            <x-public-image key="about_bg" default="img/default.jpg" class="rounded shadow" />

          </div>
          <div class="col-lg-6 order-2 order-lg-1 content">
            <h3> {!! editable('about_title', 'Pourquoi nous choisir ?') !!}</h3>
            <p class="fst-italic">
                  {!! editable('about_description', 'Nous travaillons avec vous pour concrétiser votre vision...') !!}
            </p>
              <ul>
          <li>
            <i class="bi bi-check2-all"></i>
            <span ondblclick="makeEditable(this)" data-key="about_point_1">
              {!! editable('about_point_1', 'Contactez-nous dès aujourd’hui pour démarrer votre prochain projet !') !!}
            </span>
          </li>
        </ul>



          </div>
        </div>

      </div>

    </section>


    <section id="features" class="features section">

      <div class="container">

        <div class="row gy-4">
          <div class="features-image col-lg-6" data-aos="fade-up" data-aos-delay="100">
               <x-public-image key="features_bg" default="img/features-bg.jpg" class="features-image col-lg-6" />
             </div>

        <div class="col-lg-6">
          @for ($i = 1; $i <= 4; $i++)
            <div class="features-item d-flex {{ $i > 1 ? 'mt-5' : '' }} ps-0 ps-lg-3 pt-4 pt-lg-0" data-aos="fade-up" data-aos-delay="{{ 100 + $i * 100 }}">
              <i class="bi {{ ['','bi-camera-reels','bi-calendar2-event','bi-broadcast','bi-laptop'][$i] }} flex-shrink-0"></i>

              <div>
                <h4> {!! editable("feature_{$i}_title", 'Titre '.$i) !!}</h4>
                <p>L  {!! editable("feature_{$i}_desc", 'Description de l\'élément '.$i) !!}</p>
              </div>
            </div><!-- End Features Item-->
         @endfor
          </div>
        </div>

      </div>

    </section><!-- /Features Section -->

    <!-- Services Section -->
    <section id="services" class="services section">

      <!-- Section Title -->
      <div class="container section-title" data-aos="fade-up">
        <h2>Services</h2>
        <p>Check our Services</p>
      </div><!-- End Section Title -->

      <div class="container">

        <div class="row gy-4">
         @foreach($services as $service)
            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="500">
                <div class="service-item position-relative cont">
                <div class="icon">
                <i class="bi {{ $service->icon }}"></i>
                </div>
                <a href="#" class="stretched-link"><h3>{{ $service->title }}</h3></a>
                    <ul>
                        @php
                                        $features = $service->features ?? []; // حتى لو null يرجع []
                                    @endphp
                                    @if (!empty($features))
                                            @foreach(json_decode($service->features) as $feature)
                                                    <li><i class="bi bi-check2-all"></i> <span>{{ $feature }}</span></li>
                                                @endforeach
                                                @else
                                        <p>Aucune fonctionnalité.</p>
                                    @endif

                </ul>
                <a href="service-details.html" class="stretched-link"></a>
                </div>
            </div><!-- End Service Item -->
         @endforeach

        </div>

      </div>

    </section><!-- /Services Section -->


    <section id="call-to-action" class="call-to-action section dark-background">

      <img src="img/cta-bg.jpg" alt="">

      <div class="container">
        <div class="row justify-content-center" data-aos="zoom-in" data-aos-delay="100">
          <div class="col-xl-10">
            <div class="text-center">
              <h3>Réservation</h3>
              <p>Découvrez le meilleur photographe pour vos moments. Explorez des talents d'exception et transformez vos occasions spéciales en souvenirs éternels.</p>
              <a class="cta-btn" href="{{ route('booking')}}">Réservez</a>
            </div>
          </div>
        </div>
      </div>

    </section>

    <!-- Portfolio Section -->
    <section id="portfolio" class="portfolio section">

      <!-- Section Title -->
      <div class="container section-title" data-aos="fade-up">
        <h2>Portfolio</h2>
        <p>Consultez notre portfolio</p>
      </div><!-- End Section Title -->

      <div class="container">

        <div class="isotope-layout" data-default-filter="*" data-layout="masonry" data-sort="original-order">

          <ul class="portfolio-filters isotope-filters" data-aos="fade-up" data-aos-delay="100">
            <li class="filter-active"> <a style="color:white;" href ="{{ route('portfolio')}}"> Consultez plus  </a> </li>
          </ul>

          <div class="row gy-4 isotope-container" data-aos="fade-up" data-aos-delay="200">
      @foreach($homepageImages as $item)
            <div class="col-lg-4 col-md-6 portfolio-item isotope-item filter-product">
              <img src="{{ asset($item->image_path) }}" class="img-fluid" alt="">
              <div class="portfolio-info">
                <h4>{{ $item->title }}</h4>
                <p>{{ asset($item->description) }}</p>
                <a href="{{ asset($item->image_path) }}" title="Product 3" data-gallery="portfolio-gallery-product" class="glightbox preview-link"><i class="bi bi-zoom-in"></i></a>
                <a href="{{ asset($item->image_path) }}" title="{{ $item->title }}" class="details-link"><i class="bi bi-link-45deg"></i></a>
              </div>
            </div><!-- End Portfolio Item -->
        @endforeach

          </div><!-- End Portfolio Container -->

        </div>

      </div>

    </section><!-- /Portfolio Section -->


    <!-- Team Section -->
    <section id="team" class="team section">

      <!-- Section Title -->
      <div class="container section-title" data-aos="fade-up">
        <h2>Team</h2>
        <p>Notre équipe</p>
      </div><!-- End Section Title -->

      <div class="container">

        <div class="row gy-4">
    @foreach($employees as $employee)
          <div class="col-lg-3 col-md-6 d-flex align-items-stretch" data-aos="fade-up" data-aos-delay="100">
            <div class="team-member">
              <div class="member-img">
                @if($photo = $employee->photo)
 <img src="{{ $photo->url }}" alt="Photo de {{ $employee->name }}"  class="img-fluid" >
                @endif
             <div class="social">
                  <a href="{{ $employee->facebook}}"><i class="bi bi-facebook"></i></a>
                  <a href="{{ $employee->instagram}}"><i class="bi bi-instagram"></i></a>
                  <a href=""><i class="bi bi-linkedin"></i></a>
                </div>
              </div>
              <div class="member-info">
                <h4>{{ $employee->name}}</h4>
             @if($employee && $employee->services)
    {!! $employee->services->map(function($service) {
        return '<span class="label label-info label-many">' . e($service->name) . '</span>';
    })->implode(' ') !!}
@endif

              </div>
            </div>
          </div><!-- End Team Member -->
   @endforeach

          </div><!-- End Team Member -->

        </div>

      </div>

    </section><!-- /Team Section -->

    <!-- Contact Section -->
    <section id="contact" class="contact section">

      <!-- Section Title -->
      <div class="container section-title" data-aos="fade-up">
        <h2>Contact</h2>
        <p>Contact Us</p>
      </div><!-- End Section Title -->

      <div class="container" data-aos="fade-up" data-aos-delay="100">

        <div class="mb-4" data-aos="fade-up" data-aos-delay="200">
         {!! $companySettings->map_embed !!}
    </div><!-- End Google Maps -->

        <div class="row gy-4">

          <div class="col-lg-4">
            <div class="info-item d-flex" data-aos="fade-up" data-aos-delay="300">
              <i class="bi bi-geo-alt flex-shrink-0"></i>
              <div>
                <h3>Adresse </h3>
                <p>{{ $companySettings->address ?? 'email' }}</p>
              </div>
            </div><!-- End Info Item -->

            <div class="info-item d-flex" data-aos="fade-up" data-aos-delay="400">
              <i class="bi bi-telephone flex-shrink-0"></i>
              <div>
                <h3>Téléphone</h3>
                <p>{{ $companySettings->phone ?? 'phone' }}</p>
              </div>
            </div><!-- End Info Item -->

            <div class="info-item d-flex" data-aos="fade-up" data-aos-delay="500">
              <i class="bi bi-envelope flex-shrink-0"></i>
              <div>
                <h3>Email</h3>
                <p>{{ $companySettings->email ?? 'email' }}</p>
              </div>
            </div><!-- End Info Item -->

          </div>

          <div class="col-lg-8">
            <form action="forms/contact.php" method="post" class="php-email-form" data-aos="fade-up" data-aos-delay="200">
              <div class="row gy-4">

                <div class="col-md-6">
                  <input type="text" name="name" class="form-control" placeholder="Your Name" required="">
                </div>

                <div class="col-md-6 ">
                  <input type="email" class="form-control" name="email" placeholder="Your Email" required="">
                </div>

                <div class="col-md-12">
                  <input type="text" class="form-control" name="subject" placeholder="Subject" required="">
                </div>

                <div class="col-md-12">
                  <textarea class="form-control" name="message" rows="6" placeholder="Message" required=""></textarea>
                </div>

                <div class="col-md-12 text-center">
                  <div class="loading">Loading</div>
                  <div class="error-message"></div>
                  <div class="sent-message">Your message has been sent. Thank you!</div>

                  <button type="submit">Send Message</button>
                </div>

              </div>
            </form>
          </div><!-- End Contact Form -->

        </div>

      </div>

    </section><!-- /Contact Section -->

  </main>
 @endsection
