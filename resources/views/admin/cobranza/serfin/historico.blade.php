@extends('layouts.admin.app')
@livewireStyles
@livewireScripts
@section('content')
<div class="row page-titles">
    <div class="col-md-5 col-8 align-self-center">
        <h3 class="text-themecolor">
            <a href="{{ route('dashboard') }}">
                Historial de archivos SERFIN
            </a>
        </h3>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('dashboard') }}">
                    Inicio
                </a>
            </li>
            <li class="breadcrumb-item active">
                Historico
            </li>
        </ol>
    </div>
</div>
<div class="row">
    <div class="col-md-12 col-xlg-12">
      	@livewire('serfin.historico')
    </div>
</div>
@endsection

