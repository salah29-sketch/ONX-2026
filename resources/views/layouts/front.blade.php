<!doctype html>
<html lang="ar" dir="rtl">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<title>@yield('title','ONX')</title>
<link rel="stylesheet" href="{{ asset('css/custom.css') }}">
<link rel="stylesheet" href="{{ asset('css/custom.css') }}">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;800&display=swap" rel="stylesheet">

<style>
.btn-onx-ghost i{ margin-left:6px; } /* لأن الصفحة RTL */
.onx-orange{
color:#ff6a00;
}
.onx-left{
flex:1;
}

.onx-center{
flex:1;
display:flex;
justify-content:center;
}

.onx-right{
flex:1;
display:flex;
justify-content:flex-end;
}    
.onx-footer{
margin-top:80px;
padding:60px 0 30px;
background:#070707;
border-top:1px solid rgba(255,255,255,.08);
}

.onx-footer-links li{
margin-bottom:8px;
}

.onx-footer-links a{
color:rgba(255,255,255,.7);
transition:.2s;
}

.onx-footer-links a:hover{
color:#ff6a00;
}

.onx-social{
width:40px;
height:40px;
border-radius:10px;
display:flex;
align-items:center;
justify-content:center;
background:rgba(255,255,255,.05);
border:1px solid rgba(255,255,255,.1);
color:white;
transition:.2s;
}

.onx-social:hover{
background:rgba(255,106,0,.15);
border-color:#ff6a00;
color:#ff6a00;
}
:root{
--bg:#0b0b0b;
--card:rgba(255,255,255,.06);
--border:rgba(255,255,255,.12);
--text:rgba(255,255,255,.92);
--muted:rgba(255,255,255,.72);
--orange:#ff6a00;
--shadow:0 14px 40px rgba(0,0,0,.45);
}

body{
font-family:'Cairo',sans-serif;
background:var(--bg);
color:var(--text);
}

a{color:inherit;text-decoration:none}

.onx-muted{color:var(--muted)}


/* NAVBAR */

.onx-nav{
padding:18px 0;
background:rgba(0,0,0,.35);
backdrop-filter:blur(12px);
border-bottom:1px solid rgba(255,255,255,.08);
}


/* LOGO */

.onx-logo{
font-size:30px;
font-weight:800;
letter-spacing:.5px;
}

.onx-dot{
  display:inline-block;
  width:8px;
  height:8px;
  border-radius:50%;
  background:#ff6a00;

  /* النقطة تكون ملاصقة للحرف X */
  margin-left:3px;
  margin-right:0;

  /* محاذاة جميلة مع النص */
  transform: translateY(2px);
}


/* LINKS */

.onx-link{
color:rgba(255,255,255,.75) !important;
font-weight:700;
position:relative;
padding:10px 2px;
transition:.2s;
}

.onx-link:hover{
color:white !important;
}

.onx-link.active{
color:white !important;
}

.onx-link.active::after{
content:"";
position:absolute;
left:0;
right:0;
bottom:-8px;
height:2px;
background:white;
border-radius:999px;
}


/* BUTTON */

.onx-cta-btn{
border:1px solid rgba(255,106,0,.5);
color:white;
font-weight:800;
padding:.6rem 1.3rem;
border-radius:12px;
background:transparent;
transition:.2s;
}

.onx-cta-btn:hover{
border-color:#ff6a00;
box-shadow:0 0 18px rgba(255,106,0,.35);
transform:translateY(-1px);
}


/* HERO */

.onx-hero{
min-height:68vh;
display:flex;
align-items:center;
position:relative;
overflow:hidden;
}

.onx-hero::before{
content:"";
position:absolute;
inset:0;

background:
linear-gradient(
to bottom,
rgba(0,0,0,.25),
rgba(0,0,0,.9)
),
url('{{ asset('img/hero-events.jpg') }}') center/cover no-repeat;

z-index:0;
pointer-events:none;
}

.onx-hero::after{
content:"";
position:absolute;
inset:-40%;

background:
radial-gradient(
circle,
rgba(255,106,0,.35),
transparent 60%
);

filter:blur(120px);

animation:heroGlowMove 14s ease-in-out infinite;

z-index:1;
pointer-events:none;
}
@keyframes heroGlowMove{

0%{
transform:translate(-20%,-10%) scale(1);
opacity:.35;
}

25%{
transform:translate(10%,5%) scale(1.2);
opacity:.5;
}

50%{
transform:translate(20%,15%) scale(1.1);
opacity:.4;
}

75%{
transform:translate(-10%,10%) scale(1.3);
opacity:.55;
}

100%{
transform:translate(-20%,-10%) scale(1);
opacity:.35;
}

}

.onx-hero>.container{
position:relative;
z-index:2;
}


/* BUTTONS */

.btn-onx{
background:var(--orange);
border:0;
color:#111;
font-weight:900;
border-radius:999px;
padding:.7rem 1.25rem;
}

.btn-onx-outline{
background:transparent;
border:1px solid rgba(255,255,255,.28);
color:var(--text);
font-weight:800;
border-radius:999px;
padding:.7rem 1.25rem;
}


/* CARDS */

.onx-section{padding:70px 0}

.onx-card{
background:var(--card);
border:1px solid var(--border);
border-radius:24px;
overflow:hidden;
box-shadow:var(--shadow);
backdrop-filter:blur(14px);
height:100%;
}

.onx-img{
height:280px;
width:100%;
object-fit:cover;
display:block;
}
/* ===== Restore lower sections styling ===== */

.onx-badge{
  display:inline-flex;
  align-items:center;
  gap:.5rem;
  padding:.45rem .8rem;
  border-radius:999px;
  border:1px solid rgba(255,255,255,.14);
  background: rgba(0,0,0,.25);
  color: var(--muted);
  font-weight:700;
  font-size:.9rem;
}

.onx-divider{
  height:1px;
  background: rgba(255,255,255,.10);
  margin: 22px 0;
}

.onx-feature{
background: rgba(255,255,255,.05);
border:1px solid rgba(255,255,255,.10);
border-radius:12px;
padding:10px;        /* كان أكبر */
height:auto;         /* لا تجعل ارتفاع ثابت */
text-align:center;
}


.onx-feature .icon{
width:36px;
height:36px;
border-radius:10px;
background:rgba(255,106,0,.14);
display:flex;
align-items:center;
justify-content:center;
font-size:16px;
margin:0 auto 8px;
color:#ff6a00;
}

.onx-cta{
  position:relative;
  overflow:hidden;
  background: rgba(255,255,255,.05);
  border:1px solid rgba(255,255,255,.10);
  border-radius:26px;
  padding:28px;
  backdrop-filter:blur(10px);
}

/* التوهج */
.onx-cta::before{
  content:"";
  position:absolute;
  inset:-60%;
  background:
    radial-gradient(closest-side at 30% 35%, rgba(255,106,0,.32), transparent 65%),
    radial-gradient(closest-side at 70% 65%, rgba(255,106,0,.18), transparent 70%);
  filter: blur(85px);
  opacity:.55;
  transform: translate3d(0,0,0) scale(1.1);
  animation: onxGlowMove 9s ease-in-out infinite;
  z-index:0;

  /* مهم جدًا حتى الأزرار تشتغل */
  pointer-events:none;
}

/* نخلي المحتوى فوق التوهج */
.onx-cta > *{
  position:relative;
  z-index:2;
}

/* حركة “شبه عشوائية” + نبض ضوء */
@keyframes onxGlowMove{
  0%{
    opacity:.28;
    transform: translate(-6%, -2%) scale(1.05);
    filter: blur(95px);
  }
  18%{
    opacity:.55;
    transform: translate(10%, -8%) scale(1.22);
    filter: blur(80px);
  }
  38%{
    opacity:.35;
    transform: translate(18%, 10%) scale(1.10);
    filter: blur(100px);
  }
  62%{
    opacity:.62;
    transform: translate(-12%, 14%) scale(1.28);
    filter: blur(78px);
  }
  82%{
    opacity:.40;
    transform: translate(-18%, 0%) scale(1.12);
    filter: blur(105px);
  }
  100%{
    opacity:.28;
    transform: translate(-6%, -2%) scale(1.05);
    filter: blur(95px);
  }
}

/* Improve section spacing on small screens */
.onx-section{ padding:70px 0; }
@media (max-width: 576px){
  .onx-section{ padding:48px 0; }
  .onx-img{ height:220px; }
}
/* زر شفاف + يتحول برتقالي فقط عند hover */
.btn-onx-ghost i{
margin-right:6px;
font-size:14px;
}
.btn-onx-ghost{
  background: rgba(255,255,255,.04);
  border: 1px solid rgba(255,255,255,.22);
  color: rgba(255,255,255,.92);
  font-weight: 800;
  border-radius: 999px;
  padding: .7rem 1.25rem;
  transition: .2s ease;
}

.btn-onx-ghost:hover{
  border-color: rgba(255,106,0,.70);
  background: rgba(255,106,0,.12);
  box-shadow: 0 0 22px rgba(255,106,0,.25);
  transform: translateY(-1px);
  color: #fff;
}


/* Hover effect للكروت */

.onx-card{
  transition: all .35s ease;
  position: relative;
}

.onx-card:hover{
  transform: translateY(-6px);
  border-color: rgba(255,106,0,.35);
  box-shadow:
    0 20px 50px rgba(0,0,0,.65),
    0 0 30px rgba(255,106,0,.15);
}

/* تكبير الصورة قليلاً */

.onx-img{
  transition: transform .6s ease;
}

.onx-card:hover .onx-img{
  transform: scale(1.05);
}

/* طبقة توهج خفيفة */

.onx-card::before{
  content:"";
  position:absolute;
  inset:0;
  border-radius:24px;
  background: radial-gradient(
    500px circle at var(--x,50%) var(--y,50%),
    rgba(255,106,0,.08),
    transparent 40%
  );
  opacity:0;
  transition:.3s;
  pointer-events:none;
}

.onx-card:hover::before{
  opacity:1;
}
/* ===== Events Pricing (Plans) ===== */

.onx-plan{
  transition: transform .25s ease, box-shadow .25s ease, border-color .25s ease;
}

.onx-plan:hover{
  transform: translateY(-6px);
  border-color: rgba(255,106,0,.25);
  box-shadow: 0 18px 60px rgba(0,0,0,.65);
}

/* الباقة الوسطى أكبر */
.onx-plan-featured{
  transform: scale(1.06);
  border-color: rgba(255,106,0,.28);
  position: relative;
}

/* Glow خفيف */
.onx-plan-featured::before{
  content:"";
  position:absolute;
  inset:-35%;
  background:
    radial-gradient(circle, rgba(255,106,0,.35), transparent 60%),
    radial-gradient(circle at 30% 40%, rgba(255,106,0,.22), transparent 65%);
  filter: blur(90px);
  opacity:.65;
  z-index:0;
  pointer-events:none;
  animation: planGlow 10s ease-in-out infinite;
}

/* ارفع المحتوى فوق glow */
.onx-plan-featured > *{
  position:relative;
  z-index:2;
}

@keyframes planGlow{
  0%   { opacity:.35; transform: translate(-8%,-6%) scale(1.05); }
  45%  { opacity:.75; transform: translate(10%,6%)  scale(1.25); }
  100% { opacity:.35; transform: translate(-8%,-6%) scale(1.05); }
}

/* قائمة أنيقة */
.onx-list{ padding-right:18px; }
.onx-list li{ margin-bottom:8px; }

/* زر Booking احترافي */
.btn-onx-book{
  background: rgba(255,255,255,.06);
  border: 1px solid rgba(255,255,255,.24);
  color: rgba(255,255,255,.92);
  font-weight: 900;
  border-radius: 999px;
  padding: .85rem 1.2rem;
  transition: .2s ease;
}

.btn-onx-book:hover{
  border-color: rgba(255,106,0,.75);
  background: rgba(255,106,0,.14);
  box-shadow: 0 0 26px rgba(255,106,0,.22);
  transform: translateY(-1px);
  color:#fff;
}

/* على الموبايل: لا نكبر الوسط كثير */
@media (max-width: 992px){
  .onx-plan-featured{ transform: none; }
}
</style>

@yield('styles')

</head>

<body>

<nav class="navbar navbar-expand-lg navbar-dark onx-nav" dir="ltr">
  <div class="container d-flex align-items-center justify-content-between gap-3">

    {{-- Left: Logo --}}
    <a class="navbar-brand fw-bold" href="/">
      <span class="onx-logo">ONX<span class="onx-dot"></span></span>
    </a>

    {{-- Toggler --}}
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#nav">
      <span class="navbar-toggler-icon"></span>
    </button>

    {{-- Center: Links --}}
    <ul class="navbar-nav gap-lg-4 align-items-lg-center">

<li class="nav-item">
<a class="nav-link onx-link" href="/">Accueil</a>
</li>

<li class="nav-item">
<a class="nav-link onx-link" href="/services">Services</a>
</li>

<li class="nav-item">
<a class="nav-link onx-link" href="/portfolio">Portfolio</a>
</li>

<li class="nav-item">
<a class="nav-link onx-link" href="/blog">Blog</a>
</li>



</ul>

    {{-- Right: Button --}}
    <div class="d-none d-lg-flex">
      <a class="btn onx-cta-btn" href="/booking">Commencer</a>
    </div>

  </div>
</nav>

@yield('content')

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

@yield('scripts')
<footer class="onx-footer">

<div class="container">

<div class="row g-4">

<div class="col-md-4">

<h4 class="fw-bold mb-3">
ONX
</h4>

<p class="onx-muted">
إنتاج مرئي احترافي للحفلات والإعلانات بجودة سينمائية.
</p>

</div>


<div class="col-md-4">

<h6 class="fw-bold mb-3">
الخدمات
</h6>

<ul class="list-unstyled onx-footer-links">

<li><a href="/services/events">تصوير الحفلات</a></li>

<li><a href="/services/ads">الإعلانات</a></li>

</ul>

</div>


<div class="col-md-4">

<h6 class="fw-bold mb-3">
تواصل
</h6>

<div class="d-flex gap-3">

<a class="onx-social" href="https://www.instagram.com/onx.edge/">
<i class="fab fa-instagram"></i>
</a>

<a class="onx-social" href="https://www.youtube.com/@onxedge">
<i class="fab fa-youtube"></i>
</a>

<a class="onx-social" href="https://wa.me/213540573518">
<i class="fab fa-whatsapp"></i>
</a>

</div>

</div>

</div>

<hr class="mt-4">

<p class="text-center onx-muted">
© ONX — onx-edge.com
</p>

</div>

</footer>
@stack('scripts')
</body>
</html>