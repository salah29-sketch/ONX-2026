@extends('layouts.layout')

@section('content')

  <main class="main">

<style>
  .editable-image-wrapper:hover .upload-icon {
    display: block !important;
}
.upload-icon {
    pointer-events: none;
    transition: opacity 0.5s;
}
.editable-image-wrapper:hover .editable-image {
    filter: brightness(60%);
}

</style>


<section id="hero" class="hero section dark-background">
  <img src="{{ asset('img/hero-bg.jpg') }}" alt="" data-aos="fade-in">
  <div class="container">
    <div class="row justify-content-center text-center" data-aos="fade-up" data-aos-delay="100">
      <div class="col-xl-6 col-lg-8">
        <h1 ondblclick="makeEditable(this)" data-key="hero_title" class="editable-hover">
          {!!  editable('hero_title', 'Des solutions numériques puissantes avec ... ONX') !!}
        </h1>
        <h2><span ondblclick="makeEditable(this)" data-key="hero_subtitle">{!! editable('hero_subtitle', '.') !!}</span></h2>
        <p ondblclick="makeEditable(this)" data-key="hero_desc">
          {!! editable('hero_desc', 'Vers une communication innovante') !!}
        </p>
      </div>
    </div>

    <div class="row gy-4 mt-5 justify-content-center" data-aos="fade-up" data-aos-delay="200">
      @foreach ([1 => 'Précision', 2 => 'Impact', 3 => 'Communication', 4 => 'sans limites', 5 => 'Créativité'] as $i => $default)
      <div class="col-xl-2 col-md-4" data-aos="fade-up" data-aos-delay="{{ 200 + $i * 100 }}">
        <div class="icon-box">
          <i class="bi {{ ['','bi-binoculars','bi-bullseye','bi-fullscreen-exit','bi-card-list','bi-gem'][$i] }}"></i>
          <h3><a href="#" ondblclick="makeEditable(this)" data-key="hero_box_{{ $i }}">{{ editable('hero_box_' . $i, $default) }}</a></h3>
        </div>
      </div>
      @endforeach
    </div>
  </div>
</section>

 <section id="about" class="about section">
  <div class="container" data-aos="fade-up" data-aos-delay="100">
    <div class="row gy-4">
       <x-editable-image key="about_bg" default="img/about.jpg" class="col-lg-6 order-1 order-lg-2"/>

      <div class="col-lg-6 order-2 order-lg-1 content">

        <h3 ondblclick="makeEditable(this)" data-key="about_title">
        {!! editable('about_title', 'Pourquoi nous choisir ?') !!}
        </h3>

        <p class="fst-italic" ondblclick="makeEditable(this)" data-key="about_description">
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
      <x-editable-image key="features_bg" default="img/features-bg.jpg" class="features-image col-lg-6"/>

      <div class="col-lg-6">
        @for ($i = 1; $i <= 4; $i++)
        <div class="features-item d-flex {{ $i > 1 ? 'mt-5' : '' }} ps-0 ps-lg-3 pt-4 pt-lg-0" data-aos="fade-up" data-aos-delay="{{ 100 + $i * 100 }}">
          <i class="bi {{ ['','bi-camera-reels','bi-calendar2-event','bi-broadcast','bi-laptop'][$i] }} flex-shrink-0"></i>
          <div>
            <h4 ondblclick="makeEditable(this)" data-key="feature_{{ $i }}_title" class="editable-hover">
              {!! editable("feature_{$i}_title", 'Titre '.$i) !!}
            </h4>
            <p ondblclick="makeEditable(this)" data-key="feature_{{ $i }}_desc" class="editable-hover">
              {!! editable("feature_{$i}_desc", 'Description de l\'élément '.$i) !!}
            </p>
          </div>
        </div>
        @endfor
      </div>
    </div>
  </div>
</section>

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
  <!-- البطاقة -->
  <div class="col-lg-4 col-md-6" data-aos="fade-up">
    <div class="service-item position-relative cont" data-bs-toggle="modal" data-bs-target="#editServiceModal{{ $service->id }}">
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
    </div>
  </div>
  <!-- المودال الخاص بالخدمة -->
  <div class="modal fade" id="editServiceModal{{ $service->id }}" tabindex="-1" aria-labelledby="editServiceLabel{{ $service->id }}" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <form class="edit-service-form" data-id="{{ $service->id }}">
            <input type="hidden" name="locale" value="{{ app()->getLocale() }}">
          <div class="modal-header">
            <h5 class="modal-title">Modifier le service</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
            <input type="hidden" name="id" value="{{ $service->id }}">
          </div>
          <div class="modal-body">
            <div class="mb-3">
              <label>Titre</label>
              <input type="text" name="title" class="form-control" value="{{ $service->title }}">
            </div>
            <div class="mb-3">
              <label>Description</label>
              <textarea name="description" class="form-control" rows="2">{{ $service->description }}</textarea>
            </div>
            <div class="mb-3">
              <label>Fonctionnalités (une par ligne)</label>

               @php
    $featuresArray = is_array($service->features)
        ? $service->features
        : (is_string($service->features)
            ? json_decode($service->features, true) ?? []
            : []);
@endphp

<textarea name="features" class="form-control" rows="5">
{{ implode("\n", $featuresArray) }}
</textarea>

            </div>
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-primary">Enregistrer</button>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
          </div>
        </form>
      </div>
    </div>
  </div>
@endforeach

        </div>

      </div>

    </section><!-- /Services Section -->

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
            <li class="filter-active"> <a style="color:white;" href ="{{ route('portfolio.index')}}"> Consultez plus  </a> </li>
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

          <div class="col-lg-3 col-md-6 d-flex align-items-stretch" data-aos="fade-up" data-aos-delay="100">
            <div class="team-member">
              <div class="member-img">
                <x-editable-image key="team_bg" default="img/team-1.jpg" class="img-fluid"/>

                <div class="social">
                  <a href="https://www.instagram.com/salh_eddine21/"><i class="bi bi-facebook"></i></a>
                  <a href="https://www.facebook.com/salahhmz.22"><i class="bi bi-instagram"></i></a>
                  <a href=""><i class="bi bi-linkedin"></i></a>
                </div>
              </div>
              <div class="member-info">
                <h4>Hamzaoui Salah</h4>
                <span> </span>
              </div>
            </div>
          </div><!-- End Team Member -->

          <div class="col-lg-3 col-md-6 d-flex align-items-stretch" data-aos="fade-up" data-aos-delay="200">
            <div class="team-member">
              <div class="member-img">
                <img src="assets/img/team/team-2.jpg" class="img-fluid" alt="">
                <div class="social">
                  <a href=""><i class="bi bi-twitter-x"></i></a>
                  <a href=""><i class="bi bi-facebook"></i></a>
                  <a href=""><i class="bi bi-instagram"></i></a>
                  <a href=""><i class="bi bi-linkedin"></i></a>
                </div>
              </div>
              <div class="member-info">
                <h4>   </h4>
                <span>   </span>
              </div>
            </div>
          </div><!-- End Team Member -->

          <div class="col-lg-3 col-md-6 d-flex align-items-stretch" data-aos="fade-up" data-aos-delay="300">
            <div class="team-member">
              <div class="member-img">
                <img src="assets/img/team/team-3.jpg" class="img-fluid" alt="">
                <div class="social">
                  <a href=""><i class="bi bi-twitter-x"></i></a>
                  <a href=""><i class="bi bi-facebook"></i></a>
                  <a href=""><i class="bi bi-instagram"></i></a>
                  <a href=""><i class="bi bi-linkedin"></i></a>
                </div>
              </div>
              <div class="member-info">
                <h4>   </h4>
                <span> </span>
              </div>
            </div>
          </div><!-- End Team Member -->

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
		<iframe style="border:0; width: 100%; height: 270px;" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d38333.104778467634!2d-0.6675379745870587!3d35.201323889743065!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xd7f0030b5f78f73%3A0x24600b519acfdc29!2sSidi%20Bel%20Abb%C3%A8s!5e0!3m2!1sfr!2sdz!4v1736542624300!5m2!1sfr!2sdz" width="800" height="600" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div><!-- End Google Maps -->

        <div class="row gy-4">

          <div class="col-lg-4">
            <div class="info-item d-flex" data-aos="fade-up" data-aos-delay="300">
              <i class="bi bi-geo-alt flex-shrink-0"></i>
              <div>
                <h3>Adresse </h3>
                <p>Sidi Abel Abbes</p>
              </div>
            </div><!-- End Info Item -->

            <div class="info-item d-flex" data-aos="fade-up" data-aos-delay="400">
              <i class="bi bi-telephone flex-shrink-0"></i>
              <div>
                <h3>Téléphone</h3>
                <p>0540 57 35 18</p>
              </div>
            </div><!-- End Info Item -->

            <div class="info-item d-flex" data-aos="fade-up" data-aos-delay="500">
              <i class="bi bi-envelope flex-shrink-0"></i>
              <div>
                <h3>Email</h3>
                <p>contact@onx-edge.com</p>
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



<!-- Modal تأكيد الحفظ -->
<div class="modal fade" id="editConfirmModal" tabindex="-1" aria-labelledby="editConfirmLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editConfirmLabel">تأكيد التعديل</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="إغلاق"></button>
      </div>
      <div class="modal-body">
        هل تريد حفظ التعديل؟
      </div>
      <div class="modal-footer">
        <button type="button" id="cancelEditBtn" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
        <button type="button" id="confirmEditBtn" class="btn btn-primary">تأكيد</button>
      </div>
    </div>
  </div>

<script>
    const updateUrl = "{{ route('admin.editable.update') }}";
    const serivesList = "{{ route('admin.update.serivesList') }}" ;
    const uploadImage = "{{ route('admin.editable.uploadImage') }}";
</script>
<script src="{{ asset('js/admin-setting.js?v=2')}}"></script>
  </main>
 @endsection
