@extends('layouts.pagina.app')
@if (env('APP_PAIS_ID') == 1)
    @php
        $imagen = 'images/login.jpeg'
    @endphp
@else
    @php
        $imagen = 'images/eu/paso3.jpg'
    @endphp
@endif
<style>
    .breadcrumb_bg_1 {
        background-image: url("{{ asset($imagen) }}");
        background-position: center;
        background-repeat: no-repeat;
        background-size: cover;
    }

    .errors {
        font-size: 12px;
    }
                    <style>
    .payment input{
        height: 42px !important;
        background: #fff !important;
        color: #000000 !important;
        font-size: 16px;
        border-radius: 0px;
        -webkit-box-shadow: none !important;
        box-shadow: none !important;
    }
    .card {
        position: relative;
        display: -webkit-box;
        display: -ms-flexbox;
        display: flex;
        -webkit-box-orient: vertical;
        -webkit-box-direction: normal;
        -ms-flex-direction: column;
        flex-direction: column;
        min-width: 0;
        word-wrap: break-word;
        background-color: #fff;
        background-clip: border-box;
        /* border: 1px solid rgba(0, 0, 0, 0.125); */
        /*border-radius: 0.25rem;*/
    }

    .breadcrumb .overlay_h {
        opacity: .01; 
    }
</style>
@section('content')
<section class="breadcrumb breadcrumb_bg_1">
    <div class="overlay_h">
    </div>
    <div class="container">
        <div class="row d-flex justify-content-center">
            <div class="col-lg-4">
                <div class="breadcrumb_iner">
                    <div class="breadcrumb_iner_item">
                        <div class="login-box card">
                            <div class="card-body">
                                {{--
                                <form action="index.html" class="form-horizontal form-material" id="loginform">
                                    --}}
                                    <form action="{{ route('login_custom') }}" class="form-horizontal form-material" id="loginform" method="post">
                                        @csrf
                                        <h3 class="box-title m-b-20 text-center">
                                            {{ __('messages.login.titulo') }}
                                        </h3>
                                        <div class="form-group ">
                                            <div class="col-xs-12">
                                                <input class="form-control" id="username" name="username" onblur="this.placeholder = 'Correo electrónico'" onfocus="this.placeholder = ''" placeholder="{!! trans('messages.login.correo')!!}" required="" type="email">
                                                </input>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-xs-12">
                                                <input class="form-control" id="pass_hash" name="pass_hash" onblur="this.placeholder = 'Contraseña'" onfocus="this.placeholder = ''" placeholder="{!! trans('messages.login.contrasena')!!}" required="" type="password">
                                                </input>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-md-12">
                                                <a class="text-dark pull-right" href="{{ route('password.request') }}" id="to-recover">
                                                    <i class="fa fa-lock m-r-5">
                                                    </i>
                                                    {{ __('messages.login.forgot_pass') }}
                                                </a>
                                            </div>
                                        </div>
                                        <div class="form-group text-center m-t-20">
                                            <div class="col-xs-12">
                                                <button class="btn btn-info btn-sm btn-block text-uppercase waves-effect waves-light" id="btnLogin" type="submit">
                                                    {{ __('messages.login.submit') }}
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                    {{--
                                </form>
                                --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
