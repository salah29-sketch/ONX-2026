@extends('layouts.admin')

@section('content')

<div class="card">
    <div class="card-header">
        marketing Packages
        <a class="btn btn-success float-right" href="{{ route('admin.adPackages.create') }}">
            Add Package
        </a>
    </div>

    <div class="card-body">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Type</th>
                    <th>Price</th>
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
                            @if($package->price)
                                {{ number_format($package->price) }} DA
                            @else
                                {{ $package->price_note }}
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
                            <a class="btn btn-xs btn-info"
                               href="{{ route('admin.adPackages.show', $package->id) }}">
                                View
                            </a>

                            <a class="btn btn-xs btn-warning"
                               href="{{ route('admin.adPackages.edit', $package->id) }}">
                                Edit
                            </a>

                            <form action="{{ route('admin.adPackages.destroy', $package->id) }}"
                                  method="POST"
                                  style="display:inline-block">
                                @csrf
                                @method('DELETE')

                                <input type="submit"
                                       class="btn btn-xs btn-danger"
                                       value="Delete"
                                       onclick="return confirm('Delete package?')">
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@endsection