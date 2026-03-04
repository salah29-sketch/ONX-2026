@extends('layouts.admin')
@section('content')
<div class="card">
  <div class="card-header">
    Event Packages
    <a class="btn btn-success float-right" href="{{ route('admin.event-packages.create') }}">Add Package</a>
  </div>

  <div class="card-body">
    <table class="table table-bordered table-striped table-hover ajaxTable datatable datatable-EventPackage">
      <thead>
        <tr>
          <th width="10"></th>
          <th>ID</th>
          <th>Name</th>
          <th>Subtitle</th>
          <th>Price</th>
          <th>Featured</th>
          <th>Active</th>
          <th>Sort</th>
          <th>&nbsp;</th>
        </tr>
      </thead>
    </table>
  </div>
</div>
@endsection

@section('scripts')
@parent
<script>
$(function () {
  let dtOverrideGlobals = {
    processing: true,
    serverSide: true,
    retrieve: true,
    ajax: "{{ route('admin.event-packages.index') }}",
    columns: [
      { data: 'placeholder', name: 'placeholder' },
      { data: 'id', name: 'id' },
      { data: 'name', name: 'name' },
      { data: 'subtitle', name: 'subtitle' },
      { data: 'price', name: 'price' },
      { data: 'is_featured', name: 'is_featured' },
      { data: 'is_active', name: 'is_active' },
      { data: 'sort_order', name: 'sort_order' },
      { data: 'actions', name: 'actions' },
    ],
    order: [[1, 'desc']],
    pageLength: 25,
  };
  $('.datatable-EventPackage').DataTable(dtOverrideGlobals);
});
</script>
@endsection