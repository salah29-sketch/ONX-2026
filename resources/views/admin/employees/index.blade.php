@extends('layouts.admin')

@section('content')
<div class="db-page-head">
    <div>
        <h1 class="db-page-title">{{ trans('cruds.employee.title_singular') }}</h1>
        <div class="db-page-subtitle">{{ trans('cruds.employee.title_singular') }} {{ trans('global.list') }}</div>
    </div>
    @can('employee_create')
        <a class="db-btn-primary" href="{{ route('admin.employees.create') }}">
            <i class="fas fa-plus"></i>
            {{ trans('global.add') }} {{ trans('cruds.employee.title_singular') }}
        </a>
    @endcan
</div>

<div class="card db-card">
    <div class="db-card-header">
        <i class="fas fa-users mr-2"></i>
        {{ trans('cruds.employee.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body db-card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover ajaxTable datatable datatable-Employee db-table text-center">
                <thead>
                    <tr>
                        <th width="10"></th>
                        <th>{{ trans('cruds.employee.fields.id') }}</th>
                        <th>{{ trans('cruds.employee.fields.name') }}</th>
                        <th>{{ trans('cruds.employee.fields.email') }}</th>
                        <th>{{ trans('cruds.employee.fields.phone') }}</th>
                        <th>{{ trans('cruds.employee.fields.photo') }}</th>
                        <th>&nbsp;</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>
@endsection

@section('scripts')
@parent
<script>
    $(function () {
  let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
@can('employee_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}';
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.employees.massDestroy') }}",
    className: 'btn-danger',
    action: function (e, dt, node, config) {
      var ids = $.map(dt.rows({ selected: true }).data(), function (entry) {
          return entry.id
      });

      if (ids.length === 0) {
        alert('{{ trans('global.datatables.zero_selected') }}')

        return
      }

      if (confirm('{{ trans('global.areYouSure') }}')) {
        $.ajax({
          headers: {'x-csrf-token': _token},
          method: 'POST',
          url: config.url,
          data: { ids: ids, _method: 'DELETE' }})
          .done(function () { location.reload() })
      }
    }
  }
  dtButtons.push(deleteButton)
@endcan

  let dtOverrideGlobals = {
    buttons: dtButtons,
    processing: true,
    serverSide: true,
    retrieve: true,
    aaSorting: [],
    ajax: "{{ route('admin.employees.index') }}",
    columns: [
      { data: 'id', name: 'id' },
      { data: 'name', name: 'name' },
      { data: 'email', name: 'email' },
      { data: 'phone', name: 'phone' },
      { data: 'photo', name: 'photo', sortable: false, searchable: false },
      { data: 'actions', name: '{{ trans('global.actions') }}' }
    ],
    order: [[ 1, 'desc' ]],
    pageLength: 25,
  };
  $('.datatable-Employee').DataTable(dtOverrideGlobals);
    $('a[data-toggle="tab"]').on('shown.bs.tab', function(e){
        $($.fn.dataTable.tables(true)).DataTable()
            .columns.adjust();
    });
});
</script>
@endsection
