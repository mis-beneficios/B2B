@extends('layouts.admin.app')
@livewireStyles
@livewireScripts
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
                Configuraciones
            </li>
        </ol>
    </div>
</div>
<div class="row">
    <div class="col-md-12 col-xlg-12">
        <div class="row">
            <div class="col-lg-4">
               @livewire('ajustes.images')
            </div>
            <div class="col-lg-4">
               @livewire('ajustes.image-preload')
            </div>
            <div class="col-lg-4">
               @livewire('ajustes.calendario')
            </div>
            <div class="col-lg-4">
               @livewire('ajustes.data-base')
            </div>
        </div>
    </div>
    <div class="col-md-12">
        {{-- @livewire('ajustes.contratos') --}}
        @livewire('ajustes.file-explore')
        {{-- <livewire:file-explorer /> --}}
    </div>
    <div class="col-md-12">
        @livewire('ajustes.file-explore-s3')
        {{-- @livewire('ajustes.bucket') --}}
    </div>
</div>
@endsection


@section('script')
<script>
window.addEventListener('alert', event => { 
    toastr[event.detail.type](event.detail.message, 
    event.detail.title ?? ''), toastr.options = {
        "closeButton": true,
        "progressBar": true,
    }
});
</script>
@endsection
