@extends('layouts.admin')

@section('content')
<div class="db-page-head">
    <div>
        <h1 class="db-page-title">إضافة عميل</h1>
        <div class="db-page-subtitle">إضافة عميل جديد إلى قاعدة البيانات. يجب تعبئة الاسم على الأقل.</div>
    </div>

    <a href="{{ route('admin.clients.index') }}" class="db-btn-secondary">
        <i class="fas fa-arrow-right"></i>
        رجوع
    </a>
</div>

@if($errors->any())
    <div class="alert alert-danger db-alert">
        <strong>يرجى تصحيح الأخطاء التالية:</strong>
        <ul class="mb-0 mt-2">
            @foreach($errors->all() as $err)
                <li>{{ $err }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="card db-card db-card-form">
    <div class="db-card-header">
        <i class="fas fa-user-plus mr-2"></i>
        بيانات العميل
    </div>

    <div class="card-body db-card-body">
        <form method="POST" action="{{ route('admin.clients.store') }}" class="db-form-client">
            @csrf

            <div class="row">
                <div class="col-md-6 mb-4">
                    <label class="db-label required" for="name">
                        <i class="fas fa-user text-muted mr-1"></i>
                        الاسم
                    </label>
                    <input
                        class="form-control db-input {{ $errors->has('name') ? 'is-invalid' : '' }}"
                        type="text"
                        name="name"
                        id="name"
                        value="{{ old('name', '') }}"
                        placeholder="اسم العميل الكامل"
                        autofocus
                    >
                    @if($errors->has('name'))
                        <div class="invalid-feedback">{{ $errors->first('name') }}</div>
                    @endif
                </div>

                <div class="col-md-6 mb-4">
                    <label class="db-label" for="phone">
                        <i class="fas fa-phone text-muted mr-1"></i>
                        الهاتف
                    </label>
                    <input
                        class="form-control db-input {{ $errors->has('phone') ? 'is-invalid' : '' }}"
                        type="text"
                        name="phone"
                        id="phone"
                        value="{{ old('phone', '') }}"
                        placeholder="مثال: 05xxxxxxxx"
                    >
                    @if($errors->has('phone'))
                        <div class="invalid-feedback">{{ $errors->first('phone') }}</div>
                    @endif
                </div>

                <div class="col-md-12 mb-4">
                    <label class="db-label" for="email">
                        <i class="fas fa-envelope text-muted mr-1"></i>
                        البريد الإلكتروني
                    </label>
                    <input
                        class="form-control db-input {{ $errors->has('email') ? 'is-invalid' : '' }}"
                        type="email"
                        name="email"
                        id="email"
                        value="{{ old('email', '') }}"
                        placeholder="example@domain.com"
                    >
                    @if($errors->has('email'))
                        <div class="invalid-feedback">{{ $errors->first('email') }}</div>
                    @endif
                </div>
            </div>

            <div class="db-form-actions db-form-actions-lg">
                <button class="db-btn-success" type="submit">
                    <i class="fas fa-save"></i>
                    حفظ العميل
                </button>
                <a href="{{ route('admin.clients.index') }}" class="db-btn-secondary">
                    <i class="fas fa-times"></i>
                    إلغاء
                </a>
            </div>
        </form>
    </div>
</div>
@endsection