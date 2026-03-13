@extends('layouts.admin')

@section('content')
<div class="db-page-head">
    <div>
        <h1 class="db-page-title">{{ trans('global.show') }} {{ trans('cruds.employee.title') }}</h1>
        <div class="db-page-subtitle">{{ trans('cruds.employee.title_singular') }}</div>
    </div>
    <a href="{{ route('admin.employees.index') }}" class="db-btn-secondary">
        <i class="fas fa-arrow-right"></i>
        {{ trans('global.back_to_list') }}
    </a>
</div>

<div class="card db-card">
    <div class="db-card-header">
        <i class="fas fa-user mr-2"></i>
        {{ trans('global.show') }} {{ trans('cruds.employee.title') }}
    </div>

    <div class="card-body db-card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-striped db-table">
                <tbody>
                    <tr>
                        <th>{{ trans('cruds.employee.fields.id') }}</th>
                        <td>{{ $employee->id }}</td>
                    </tr>
                    <tr>
                        <th>{{ trans('cruds.employee.fields.name') }}</th>
                        <td>{{ $employee->name }}</td>
                    </tr>
                    <tr>
                        <th>{{ trans('cruds.employee.fields.email') }}</th>
                        <td>{{ $employee->email }}</td>
                    </tr>
                    <tr>
                        <th>{{ trans('cruds.employee.fields.phone') }}</th>
                        <td>{{ $employee->phone }}</td>
                    </tr>
                    <tr>
                        <th>{{ trans('cruds.employee.fields.photo') }}</th>
                        <td>
                            @if($employee->photo)
                                <a href="{{ $employee->photo->getUrl() }}" target="_blank">
                                    <img src="{{ $employee->photo->getUrl('thumb') }}" width="50px" height="50px" alt="">
                                </a>
                            @else
                                —
                            @endif
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="db-form-actions mt-3">
            <a href="{{ route('admin.employees.index') }}" class="db-btn-secondary">
                <i class="fas fa-arrow-right"></i>
                {{ trans('global.back_to_list') }}
            </a>
        </div>
    </div>
</div>
@endsection
