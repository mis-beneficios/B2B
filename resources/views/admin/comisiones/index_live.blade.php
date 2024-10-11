@extends('layouts.admin.app')
@section('content')
@livewireStyles
@livewireScripts
<div class="row page-titles">
    <div class="col-md-5 col-8 align-self-center">
        <h3 class="text-themecolor">
            Comisiones LW
        </h3>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('dashboard') }}">
                    Home
                </a>
            </li>
            <li class="breadcrumb-item active">
                Comisiones
            </li>
        </ol>
    </div>
</div>
@if (Auth::user()->role == 'admin')
    @livewire('comisiones.actualizar')
@endif
@livewire('comisiones.index')
@endsection

