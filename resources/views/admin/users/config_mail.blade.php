@extends('layouts.admin.app')
@section('content')
<div class="row page-titles">
    <div class="col-md-5 col-8 align-self-center">
        <h3 class="text-themecolor">
            Configura tu correo electronico
        </h3>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('dashboard') }}">
                    Home
                </a>
            </li>
            <li class="breadcrumb-item active">
                Configurar Mail
            </li>
        </ol>
    </div>
</div>
<div class="row">
    <div class="col-lg-6 col-md-6">
        <div class="card">
            <div class="card-body">
            <h4 class="card-title">Configurar correo electrónico</h4> 
            <h6 class="card-subtitle"> Esta configuración servirá para enviar los correos, cupones e información que el sistema manda automáticamente desde la dirección ingresada a continuación</h6>
                <form class="form" method="post" action="{{ route('save.mail') }}">
                    @csrf
                    <input type="hidden" value="{{ Auth::user()->id }}" name="user_id">
                    <div class="form-group m-t-40 row">
                        <label for="example-text-input" class="col-3 col-form-label">Tipo de conexión</label>
                        <div class="col-9">
                            <input class="form-control" type="text" value="SMTP" id="type" name="type">
                        </div>
                    </div>
                    <div class="form-group m-t-40 row">
                        <label for="example-text-input" class="col-3 col-form-label">Host</label>
                        <div class="col-9">
                            <input class="form-control" type="text" value="smtppro.zoho.com" id="host" name="host">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="example-search-input" class="col-3 col-form-label">Puerto</label>
                        <div class="col-9">
                            <input class="form-control" type="search" value="465" id="port" name="port">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="example-tel-input" class="col-3 col-form-label">Encriptación</label>
                        <div class="col-9">
                            <input class="form-control" type="text" value="SSL" id="encryption" name="encryption">
                        </div>
                    </div>
                   
                    <div class="form-group row">
                        <label for="example-email-input" class="col-3 col-form-label">Correo electrónico</label>
                        <div class="col-9">
                            <input class="form-control" type="email" value="" id="email" name="email">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="example-url-input" class="col-3 col-form-label">Contraseña</label>
                        <div class="col-9">
                            <input class="form-control" type="text" value="" id="password" name="password">
                        </div>
                    </div>
                     {{-- <div class="form-group row">
                        <label for="example-password-input" class="col-3 col-form-label">Dirección saliente</label>
                        <div class="col-9">
                            <input class="form-control" type="password" value="" id="">
                        </div>
                    </div> --}}
                    <div class="form-group row">
                        <label for="example-number-input" class="col-3 col-form-label">Nombre</label>
                        <div class="col-9">
                            <input class="form-control" type="text" value="{{ Auth::user()->fullName }}" id="from_name" name="from_name">
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-12">
                        <button type="submit" class="btn btn-primary btn-block">Configurar</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
<script>
    $(document).ready(function() {
       
    });
</script>
@endsection
