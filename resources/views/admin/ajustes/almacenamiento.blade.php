@extends('layouts.admin.app')
@section('content')
@livewireStyles
<div class="row page-titles">
    <div class="col-md-5 col-8 align-self-center">
        <h3 class="text-themecolor">
            <a href="{{ route('dashboard') }}">
                Explorador de archivos
            </a>
        </h3>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('dashboard') }}">
                    Home
                </a>
            </li>
            <li class="breadcrumb-item active">
                Datos guardados en sistema
            </li>
        </ol>
    </div>
</div>
<div class="row">
    <div class="col-md-8 col-xlg-9">
        <div class="row">
            <div class="col-lg-4">
                @livewire('ajustes.contratos')
            </div>
            <div class="col-lg-8">

            </div>
        </div>
    </div>
</div>
@endsection


@section('script')
@livewireScripts
<script>
    $(document).ready(function() {
    });
</script>
@endsection
