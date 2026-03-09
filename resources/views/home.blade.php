@extends('layouts.admin')

@section('content')

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <strong>{{ trans('global.dashboard') }}</strong>
            </div>
            <div class="card-body">
                <div class="row gy-3">

                    <div class="col-lg-3 col-md-6">
                        <a href="{{ route('admin.bookings.index') }}" class="text-decoration-none">
                            <div class="card text-white bg-primary h-100">
                                <div class="card-body d-flex align-items-center gap-3">
                                    <i class="fas fa-calendar-check fa-2x"></i>
                                    <div>
                                        <div class="h5 mb-0">{{ $bookingsCount ?? 0 }}</div>
                                        <small>Réservations</small>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>

                    <div class="col-lg-3 col-md-6">
                        <a href="{{ route('admin.clients.index') }}" class="text-decoration-none">
                            <div class="card text-white bg-success h-100">
                                <div class="card-body d-flex align-items-center gap-3">
                                    <i class="fas fa-users fa-2x"></i>
                                    <div>
                                        <div class="h5 mb-0">{{ $clientsCount ?? 0 }}</div>
                                        <small>Clients</small>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>

                    <div class="col-lg-3 col-md-6">
                        <a href="{{ route('admin.portfolio-items.index') }}" class="text-decoration-none">
                            <div class="card text-white bg-warning h-100">
                                <div class="card-body d-flex align-items-center gap-3">
                                    <i class="fas fa-images fa-2x"></i>
                                    <div>
                                        <div class="h5 mb-0">{{ $portfolioCount ?? 0 }}</div>
                                        <small>Portfolio</small>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>

                    <div class="col-lg-3 col-md-6">
                        <a href="{{ route('admin.bookings.calendar') }}" class="text-decoration-none">
                            <div class="card text-white bg-info h-100">
                                <div class="card-body d-flex align-items-center gap-3">
                                    <i class="fas fa-calendar-alt fa-2x"></i>
                                    <div>
                                        <div class="h5 mb-0">&rarr;</div>
                                        <small>Calendrier</small>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

@endsection
