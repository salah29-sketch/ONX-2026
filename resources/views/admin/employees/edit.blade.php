@extends('layouts.admin')

@section('content')
<div class="db-page-head">
    <div>
        <h1 class="db-page-title">{{ trans('global.edit') }} {{ trans('cruds.employee.title_singular') }}</h1>
        <div class="db-page-subtitle">{{ trans('cruds.employee.title_singular') }}</div>
    </div>
    <div class="db-page-head-actions">
        <a href="{{ route('admin.employees.show', $employee) }}" class="db-btn-secondary">
            <i class="fas fa-eye"></i>
            عرض
        </a>
        <a href="{{ route('admin.employees.index') }}" class="db-btn-secondary">
            <i class="fas fa-arrow-right"></i>
            {{ trans('global.back_to_list') }}
        </a>
    </div>
</div>

<div class="card db-card">
    <div class="db-card-header">
        <i class="fas fa-edit mr-2"></i>
        {{ trans('global.edit') }} {{ trans('cruds.employee.title_singular') }}
    </div>

    <div class="card-body db-card-body">
        <form action="{{ route("admin.employees.update", [$employee->id]) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                <label for="name" class="db-label">{{ trans('cruds.employee.fields.name') }}*</label>
                <input type="text" id="name" name="name" class="form-control db-input" value="{{ old('name', isset($employee) ? $employee->name : '') }}" required>
                @if($errors->has('name'))
                    <em class="invalid-feedback">
                        {{ $errors->first('name') }}
                    </em>
                @endif
                <p class="helper-block">
                    {{ trans('cruds.employee.fields.name_helper') }}
                </p>
            </div>
            <div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
                <label for="email" class="db-label">{{ trans('cruds.employee.fields.email') }}</label>
                <input type="email" id="email" name="email" class="form-control db-input" value="{{ old('email', isset($employee) ? $employee->email : '') }}">
                @if($errors->has('email'))
                    <em class="invalid-feedback">
                        {{ $errors->first('email') }}
                    </em>
                @endif
                <p class="helper-block">
                    {{ trans('cruds.employee.fields.email_helper') }}
                </p>
            </div>
            <div class="form-group {{ $errors->has('phone') ? 'has-error' : '' }}">
                <label for="phone" class="db-label">{{ trans('cruds.employee.fields.phone') }}</label>
                <input type="text" id="phone" name="phone" class="form-control db-input" value="{{ old('phone', isset($employee) ? $employee->phone : '') }}">
                @if($errors->has('phone'))
                    <em class="invalid-feedback">
                        {{ $errors->first('phone') }}
                    </em>
                @endif
                <p class="helper-block">
                    {{ trans('cruds.employee.fields.phone_helper') }}
                </p>
            </div>
            <div class="form-group {{ $errors->has('photo') ? 'has-error' : '' }}">
                <label for="photo" class="db-label">{{ trans('cruds.employee.fields.photo') }}</label>
                <div class="needsclick dropzone" id="photo-dropzone">

                </div>
                @if($errors->has('photo'))
                    <em class="invalid-feedback">
                        {{ $errors->first('photo') }}
                    </em>
                @endif
                <p class="helper-block">
                    {{ trans('cruds.employee.fields.photo_helper') }}
                </p>
            </div>
            <hr class="my-4">
            <h5 class="db-page-title mb-3">Réseaux sociaux</h5>

            <div class="form-group {{ $errors->has('facebook') ? 'has-error' : '' }}">
                <label for="facebook" class="db-label">Facebook</label>
                <input type="url" id="facebook" name="facebook" class="form-control db-input"
                    value="{{ old('facebook', $employee->facebook ?? '') }}">
                @if($errors->has('facebook'))
                    <em class="invalid-feedback">{{ $errors->first('facebook') }}</em>
                @endif
            </div>

            <div class="form-group {{ $errors->has('instagram') ? 'has-error' : '' }}">
                <label for="instagram" class="db-label">Instagram</label>
                <input type="url" id="instagram" name="instagram" class="form-control db-input"
                    value="{{ old('instagram', $employee->instagram ?? '') }}">
                @if($errors->has('instagram'))
                    <em class="invalid-feedback">{{ $errors->first('instagram') }}</em>
                @endif
            </div>

            <div class="form-group {{ $errors->has('twitter') ? 'has-error' : '' }}">
                <label for="twitter" class="db-label">Twitter</label>
                <input type="url" id="twitter" name="twitter" class="form-control db-input"
                    value="{{ old('twitter', $employee->twitter ?? '') }}">
                @if($errors->has('twitter'))
                    <em class="invalid-feedback">{{ $errors->first('twitter') }}</em>
                @endif
            </div>

            <div class="form-group {{ $errors->has('linkedin') ? 'has-error' : '' }}">
                <label for="linkedin" class="db-label">LinkedIn</label>
                <input type="url" id="linkedin" name="linkedin" class="form-control db-input"
                    value="{{ old('linkedin', $employee->linkedin ?? '') }}">
                @if($errors->has('linkedin'))
                    <em class="invalid-feedback">{{ $errors->first('linkedin') }}</em>
                @endif
            </div>

            <div class="db-form-actions db-form-actions-lg">
                <button type="submit" class="db-btn-success">
                    <i class="fas fa-save"></i>
                    {{ trans('global.save') }}
                </button>
                <a href="{{ route('admin.employees.index') }}" class="db-btn-secondary">
                    <i class="fas fa-times"></i>
                    إلغاء
                </a>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
    Dropzone.options.photoDropzone = {
    url: '{{ route('admin.employees.storeMedia') }}',
    maxFilesize: 2, // MB
    acceptedFiles: '.jpeg,.jpg,.png,.gif,.jfif',
    maxFiles: 1,
    addRemoveLinks: true,
    headers: {
      'X-CSRF-TOKEN': "{{ csrf_token() }}"
    },
    params: {
      size: 2,
      width: 4096,
      height: 4096
    },
    success: function (file, response) {
      $('form').find('input[name="photo"]').remove()
      $('form').append('<input type="hidden" name="photo" value="' + response.name + '">')
    },
    removedfile: function (file) {
      file.previewElement.remove()
      if (file.status !== 'error') {
        $('form').find('input[name="photo"]').remove()
        this.options.maxFiles = this.options.maxFiles + 1
      }
    },
    init: function () {
@if(isset($employee) && $employee->photo)
      var file = {!! json_encode($employee->photo) !!}
          this.options.addedfile.call(this, file)
      this.options.thumbnail.call(this, file, file.url)
      file.previewElement.classList.add('dz-complete')
      $('form').append('<input type="hidden" name="photo" value="' + file.file_name + '">')
      this.options.maxFiles = this.options.maxFiles - 1
@endif
    },
    error: function (file, response) {
        if ($.type(response) === 'string') {
            var message = response //dropzone sends it's own error messages in string
        } else {
            var message = response.errors.file
        }
        file.previewElement.classList.add('dz-error')
        _ref = file.previewElement.querySelectorAll('[data-dz-errormessage]')
        _results = []
        for (_i = 0, _len = _ref.length; _i < _len; _i++) {
            node = _ref[_i]
            _results.push(node.textContent = message)
        }

        return _results
    }
}
</script>
@stop
