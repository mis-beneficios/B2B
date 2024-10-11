@extends('layouts.admin.app')
@section('content')
@livewireStyles
@livewireScripts
<style>
    .span_blocks{

    }
</style>
<div class="row page-titles">
    <div class="col-md-8 col-12 align-self-center">
        <h3 class="text-themecolor">
            Calendario de seguimientos a empresas: <em class="text-dark">{{ $concal->empresa }}</em>
        </h3>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('dashboard') }}">
                    Inicio
                </a>
            </li>
            <li class="breadcrumb-item active">
                Seguimientos
            </li>
        </ol>
    </div>
</div>
<div class="row">
    <div class="col-lg-5 col-md-12 col-sm-12">
        @livewire('concal.edit', ['concal_id' => $concal->id])
    </div>
    <div class="col-lg-7 col-md-12">
        @livewire('concal.actividades', ['concal_id' => $concal->id])
    </div>
</div>
@endsection
@section('script')
<script>
    $('body .actividad_text').summernote({
        height: 300,
    });
</script>
@endsection