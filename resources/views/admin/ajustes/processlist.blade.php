@extends('layouts.admin.app')
@section('content')
<div class="row page-titles">
    <div class="col-md-5 col-8 align-self-center">
        <h3 class="text-themecolor">
            <a href="{{ route('dashboard') }}">
                Configuración de sistema
            </a>
        </h3>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('dashboard') }}">
                    Home
                </a>
            </li>
            <li class="breadcrumb-item active">
                Procesos de base de datos
            </li>
        </ol>
    </div>
</div>
@include('admin.ajustes.lista_procesos')
@endsection

