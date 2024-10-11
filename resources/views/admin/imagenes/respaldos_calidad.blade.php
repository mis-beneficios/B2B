@extends('layouts.admin.app')
@section('content')
<div class="row page-titles">
    <div class="col-md-5 col-8 align-self-center">
        <h3 class="text-themecolor">
            Respaldos de calidad
        </h3>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('dashboard') }}">
                    Inicio
                </a>
            </li>
            <li class="breadcrumb-item active">
                Respaldos de calidad
            </li>
        </ol>
    </div>
</div>
@livewire('respaldos.calidades')
@endsection

