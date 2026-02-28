@extends('layouts.admin')
@section('content')
<div class="content">
     <div class="card">
   <div class="card-header d-flex justify-content-between align-items-center">
  <span>🖥️ معاينة الموقع العام</span>

  <button onclick="iframeBack()" class="btn btn-outline-primary btn-sm">
    ← back
  </button>
</div>

<script>
function iframeBack() {
    // نحن داخل iframe
    if (window.history.length > 1) {
      window.history.back();
    } else {
      // لا يوجد تاريخ سابق، نرجع إلى الصفحة الرئيسية داخل iframe
      window.location.href = "{{ route('admin.settings.page') }}";
    }

}
</script>
    <div class="card-body p-0">
        <iframe src="{{ url('admin/settings/home') }}" width="100%" height="900px" frameborder="0"></iframe>
    </div>
</div>
</div>
@endsection
@section('scripts')
@parent

@endsection
