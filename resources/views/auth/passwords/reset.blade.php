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
            <div class="col-lg-5 col-md-8">
                <div class="breadcrumb_iner">
                    <div class="breadcrumb_iner_item">
                        <div class="login-box card">
                            <div class="card-body">
                                @if (session('status'))
                                <div class="alert alert-danger" role="alert">
                                    {{ session('status') }}
                                </div>
                                @endif
                                <form action="{{ route('password.update') }}" class="form-horizontal form-material" method="POST">
                                    @csrf
                                    <h3 class="box-title m-b-20 text-center">
                                        {{ __('messages.login.restablecer') }}
                                    </h3>
                                    <input name="token" type="hidden" value="{{ $token }}">
                                        <div class="form-group">
                                            <div class="">
                                                <input autocomplete="username" autofocus="" class="form-control @error('username') is-invalid @enderror" id="username" name="username" placeholder="{{ __('messages.login.correo') }}" required="" type="username" value="{{ $username ?? old('username') }}">
                                                    @error('username')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>
                                                            {{ $message }}
                                                        </strong>
                                                    </span>
                                                    @enderror
                                                </input>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="">
                                                <input autocomplete="new-password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" placeholder="{{ __('messages.login.contrasena') }}" required="" type="password">
                                                    @error('password')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>
                                                            {{ $message }}
                                                        </strong>
                                                    </span>
                                                    @enderror
                                                </input>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="">
                                                <input autocomplete="new-password" class="form-control" id="password-confirm" name="password_confirmation" placeholder="{{ __('messages.login.confirmar') }}" required="" type="password">
                                                </input>
                                            </div>
                                        </div>
                                        <div class="form-group mb-0 justify-content-center">
                                            <div class="">
                                                <button class="btn btn-primary btn-block" type="submit">
                                                    {{ __('messages.login.restablecer') }}
                                                </button>
                                            </div>
                                        </div>
                                    </input>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
