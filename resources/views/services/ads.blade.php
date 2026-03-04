@extends('layouts.front')

@section('title','Ads')

@section('content')

<section class="onx-section">

<div class="container">

<h1 class="fw-bold text-center mb-5">
إنتاج الإعلانات
</h1>

<div class="row g-4">

<div class="col-lg-6">
<div class="onx-card p-4">

<h3 class="fw-bold mb-3">إعلان حسب الطلب</h3>

<p class="onx-muted">
ننتج إعلان كامل حسب فكرة العميل
وتختلف التكلفة حسب:
</p>

<ul class="onx-muted">
<li>مدة الفيديو</li>
<li>عدد أيام التصوير</li>
<li>المعدات</li>
<li>الممثلين</li>
</ul>

<a href="/contact" class="btn btn-onx-ghost mt-3">
اطلب عرض سعر
</a>

</div>
</div>


<div class="col-lg-6">
<div class="onx-card p-4">

<h3 class="fw-bold mb-3">اشتراك شهري</h3>

<p class="onx-muted">
مناسب للشركات والمتاجر
</p>

<ul class="onx-muted">
<li>إعلانات شهرية</li>
<li>Reels</li>
<li>تصوير منتجات</li>
<li>مونتاج</li>
</ul>

<h4 class="mt-3">ابتداء من 60000 DA / شهر</h4>

<a href="/contact" class="btn btn-onx-ghost mt-3">
ابدأ الاشتراك
</a>

</div>
</div>

</div>

</div>

</section>

@endsection