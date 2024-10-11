@extends('layouts.admin.app')
@section('content')
<div class="row mt-3">
    <div class="col-lg-3 col-md-6">
        <a href="{{ route('paquetes.index') }}">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex flex-row">
                        <div class="round round-lg align-self-center round-primary">
                            <i class="fas fa-file-pdf">
                            </i>
                        </div>
                        <div class="m-l-10 align-self-center">
                            <h3 class="m-b-0 font-lgiht">
                                {{ count(Auth::user()->contratos) }}
                            </h3>
                            <h5 class="text-muted m-b-0">
                                {{ __('messages.cliente.contratos') }}
                            </h5>
                        </div>
                    </div>
                </div>
            </div>
        </a>
    </div>
    <div class="col-lg-3 col-md-6">
        <a href="{{ route('tarjetas.index') }}">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex flex-row">
                        <div class="round round-lg align-self-center round-info">
                            <i class="ti-wallet">
                            </i>
                        </div>
                        <div class="m-l-10 align-self-center">
                            <h3 class="m-b-0 font-light">
                                {{ count(Auth::user()->tarjetas) }}
                            </h3>
                            <h5 class="text-muted m-b-0">
                                {{ __('messages.cliente.tarjetas') }}
                            </h5>
                        </div>
                    </div>
                </div>
            </div>
        </a>
    </div>
    <div class="col-lg-3 col-md-6">
        <a href="{{ route('reservaciones.index') }}">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex flex-row">
                        <div class="round round-lg align-self-center round-danger">
                            <i class="fas fa-calendar-alt">
                            </i>
                        </div>
                        <div class="m-l-10 align-self-center">
                            <h3 class="m-b-0 font-lgiht">
                                {{ count(Auth::user()->reservaciones) }}
                            </h3>
                            <h5 class="text-muted m-b-0">
                                {{ __('messages.cliente.reservaciones') }}
                            </h5>
                        </div>
                    </div>
                </div>
            </div>
        </a>
    </div>
</div>
@if (env('APP_PAIS_ID') == 1 && env('APP_ID') == 'mb')
<div class="row">
    <div class="col-md-12">
        <img class="img-fluid" src="https://admin.beneficiosvacacionales.mx/{{ $cal_temp }}"/>
    </div>
</div>
@endif
@endsection
