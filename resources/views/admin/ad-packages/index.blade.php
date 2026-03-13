@extends('layouts.admin')

@section('content')
<div class="db-page-head">
    <div>
        <h1 class="db-page-title">باقات الإعلانات (Marketing Packages)</h1>
        <div class="db-page-subtitle">إدارة باقات التسويق والإعلان.</div>
    </div>
    <a class="db-btn-primary" href="{{ route('admin.ad-packages.create') }}">
        <i class="fas fa-plus"></i>
        إضافة باقة
    </a>
</div>

<div class="card db-card">
    <div class="db-card-header">
        <i class="fas fa-bullhorn mr-2"></i>
        قائمة الباقات
    </div>

    <div class="card-body db-card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-striped db-table text-center">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Type</th>
                    <th>Price</th>
                    <th>Old Price</th>
                    <th>Features</th>
                    <th>Featured</th>
                    <th>Active</th>
                    <th width="160"></th>
                </tr>
            </thead>

            <tbody>
                @foreach($adPackages as $package)
                    <tr>
                        <td>{{ $package->id }}</td>

                        <td>
                            <strong>{{ $package->name }}</strong>
                            <br>
                            <small>{{ $package->subtitle }}</small>
                        </td>

                        <td>
                            {{ $package->type == 'monthly' ? 'Monthly' : 'Custom' }}
                        </td>

                        <td>
                            @if(!is_null($package->price))
                                {{ number_format((float) $package->price, 0) }} DA
                            @else
                                {{ $package->price_note ?: '—' }}
                            @endif
                        </td>

                        <td>
                            @if(!is_null($package->old_price))
                                {{ number_format((float) $package->old_price, 0) }} DA
                            @else
                                —
                            @endif
                        </td>

                        <td>
                            @php
                                $features = is_array($package->features)
                                    ? $package->features
                                    : (json_decode($package->features ?? '[]', true) ?: []);
                            @endphp

                            @if(count($features))
                                <ul class="mb-0 pl-3">
                                    @foreach(array_slice($features, 0, 3) as $feature)
                                        <li>{{ $feature }}</li>
                                    @endforeach
                                </ul>

                                @if(count($features) > 3)
                                    <small>...</small>
                                @endif
                            @else
                                —
                            @endif
                        </td>

                        <td>
                            @if($package->is_featured)
                                ⭐
                            @endif
                        </td>

                        <td>
                            {{ $package->is_active ? 'Yes' : 'No' }}
                        </td>

                        <td>
                            <div class="db-actions">
                                <a class="db-icon-btn db-view-btn" href="{{ route('admin.ad-packages.show', $package->id) }}" title="عرض">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a class="db-icon-btn db-edit-btn" href="{{ route('admin.ad-packages.edit', $package->id) }}" title="تعديل">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.ad-packages.destroy', $package->id) }}" method="POST" class="d-inline" onsubmit="return confirm('حذف الباقة؟');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="db-icon-btn db-delete-btn" title="حذف">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="mt-3">{{ $adPackages->links() }}</div>
        </div>
    </div>
</div>
@endsection