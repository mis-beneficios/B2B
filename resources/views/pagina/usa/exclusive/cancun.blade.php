@extends('layouts.pagina.app')
<style>
    .errors {
        font-size: 12px;
    }
    .client_review{
        background-color: #008cc5;
    }
</style>
@section('content')
<section class="breadcrumb breadcrumb_bg" style="background-image: url(https://wallpaperaccess.com/full/1292239.jpg);">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="breadcrumb_iner">
                    <div class="breadcrumb_iner_item text-center">
                        <h2 class="text-uppercase">
                            Grand Oasis
                        </h2>
                        <p class="lead" style="font-size: 28px;">
                            Compra ahora  Down Payment $35 DLLS
                        </p>
                        <p>
                            Numero de licencia en Estados Unidos:
                            <b class="text-themecolor">
                                ST39383
                            </b>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<div class="text-center mt-3 mb-3 pb-3">
    <div id="typed-strings">
        <h1 class="text-warning text-uppercase" id="typed">
            24 pagos quincenales de $27 dlls por persona
        </h1>
        <p class="mb-3">
            Aplica minimo dos personas
        </p>
        <a class="btn-warning btn btn- waves-effect waves-light" href="#form_compra_eu" style="color: white;">
            Comprar ahora
        </a>
    </div>
</div>
<section class="about_us m-4">
    <div class="container">
        <div class="row m-4">
            <div class="col-md-12">
                <div class="about_text text-justify">
                    <h2 class="text-center">
                        GRAND OASIS CANCUN
                    </h2>
                    <p class="text-justify">
                        Una extensa oferta de entretenimiento y espectáculos, comodidad total, amplios espacios y mar azul turquesa, son las características de este resort todo incluido, ubicado en una de las playas más hermosas de Cancún.
                    </p>
                    <p>
                        Grand Oasis Cancún ofrece experiencias de día y noche, actividades para todos los gustos y gran variedad de gastronomía internacional para toda la familia.
                    </p>
                    <p>
                        Además, sus amplias instalaciones cuentan con áreas exclusivas para adultos, ideales para disfrutar unas vacaciones en pareja o entre amigos.
                    </p>
                    <p>
                        En el confort de sus habitaciones nuestros huéspedes encuentran el mejor descanso, además de una bella decoración que se engrandece con increíbles vistas al mar o al atardecer.
                    </p>
                </div>
            </div>
        </div>
        <div class="row align-items-center">
            <div class="col-lg-6">
                <div class="carousel slide" data-ride="carousel" id="carousel-example-generic">
                    <div class="carousel-inner" role="listbox">
                        <div class="carousel-item active">
                            <img alt="First slide" src="{{ asset('images/eu/grand_oasis_cancun/01.webp') }}">
                            </img>
                        </div>
                        <div class="carousel-item">
                            <img alt="First slide" src="{{ asset('images/eu/grand_oasis_cancun/02.webp') }}">
                            </img>
                        </div>
                        <div class="carousel-item">
                            <img alt="First slide" src="{{ asset('images/eu/grand_oasis_cancun/03.webp') }}">
                            </img>
                        </div>
                        <div class="carousel-item">
                            <img alt="First slide" src="{{ asset('images/eu/grand_oasis_cancun/04.webp') }}">
                            </img>
                        </div>
                        <div class="carousel-item">
                            <img alt="First slide" src="{{ asset('images/eu/grand_oasis_cancun/05.webp') }}">
                            </img>
                        </div>
                        <div class="carousel-item">
                            <img alt="First slide" src="{{ asset('images/eu/grand_oasis_cancun/06.webp') }}">
                            </img>
                        </div>
                        <div class="carousel-item">
                            <img alt="First slide" src="{{ asset('images/eu/grand_oasis_cancun/07.webp') }}">
                            </img>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="about_text">
                    <h2 class="text-center">
                        Hotel
                    </h2>
                    <ul class="unordered-list">
                        <li>
                            Resort familiar todo incluido con áreas solo para adultos.
                        </li>
                        <li>
                            1,378 habitaciones con vista al mar, al jardín o a la puesta de sol.
                        </li>
                        <li>
                            Restaurantes con cocina japonesa, mexicana, internacional, mariscos, etc.
                        </li>
                        <li>
                            Alberca de 400 metros de largo.
                        </li>
                        <li>
                            Amplios beach clubs con camas balinesas, camastros y albercas con servicio de bebidas y snacks.
                        </li>
                        <li>
                            Playa con 650 metros de arena blanca. * Entretenimiento de día y noche.
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row m-4">
            <div class="col-md-12">
                <div class="about_text text-justify">
                    <h2 class="text-center">
                        GRAND OASIS PALM
                    </h2>
                    <p class="text-justify">
                        Este resort todo incluido cuenta con excelente ubicación en la playa de Cancún y ofrece diferentes áreas para disfrutar una estancia en familia o pasar unas vacaciones de relajación en áreas exclusivas para los adultos.
                    </p>
                    <p>
                        Grand Oasis Palm ofrece un mundo de diversión para los más pequeños, siempre bajo cuidado de expertos en el KiddO Zone. Y para pasar tiempo de calidad en familia, el fantástico Pirata's Bay, es un área frente al mar con juegos y aventuras pirata para chicos y grandes.
                    </p>
                    <p>
                        Este hotel cuenta con áreas solo para adultos: restaurantes y bares, entretenimiento nocturno y spa.
                    </p>
                    <p>
                        Otro beneficio de Grand Oasis Palm son sus renombrados restaurantes: Careyes, Alma, Maki Taco, Cocoa y The White Box.
                    </p>
                </div>
            </div>
        </div>
        <div class="row align-items-center">
            <div class="col-lg-6">
                <div class="about_text">
                    <h2 class="text-center">
                        Hotel
                    </h2>
                    <ul class="unordered-list">
                        <li>
                            Habitaciones y suites con vistas espectaculares y espacio para familias de hasta 2 adultos y 3 niños.
                        </li>
                        <li>
                            Gran diversidad de opciones culinarias todo incluido: restaurantes gourmet, restaurantes de cocina mexicana, italiana, japonesa, internacional, mariscos, sushi y snacks.
                        </li>
                        <li>
                            Kiddo Zone: área de atracciones para niños bajo cuidado y supervisión de expertos.
                        </li>
                        <li>
                            Zonas exclusivas para los adultos.
                        </li>
                        <li>
                            Zonas de interacción familiar: Yucatán Jurassic River, Pirata’s Bay Pool & Beach Park y The Arcade.
                        </li>
                        <li>
                            Tour en barco pirata para toda la familia (2 veces por semana).
                        </li>
                        <li>
                            Tour de noche en barco pirata solo para adultos (2 veces por semana).
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="carousel slide" data-ride="carousel" id="carousel-example-generic">
                    <div class="carousel-inner" role="listbox">
                        <div class="carousel-item active">
                            <img alt="First slide" src="{{ asset('images/eu/grand_oasis_palm/01.webp') }}">
                            </img>
                        </div>
                        <div class="carousel-item">
                            <img alt="First slide" src="{{ asset('images/eu/grand_oasis_palm/02.webp') }}">
                            </img>
                        </div>
                        <div class="carousel-item">
                            <img alt="First slide" src="{{ asset('images/eu/grand_oasis_palm/03.webp') }}">
                            </img>
                        </div>
                        <div class="carousel-item">
                            <img alt="First slide" src="{{ asset('images/eu/grand_oasis_palm/04.webp') }}">
                            </img>
                        </div>
                        <div class="carousel-item">
                            <img alt="First slide" src="{{ asset('images/eu/grand_oasis_palm/05.webp') }}">
                            </img>
                        </div>
                        <div class="carousel-item">
                            <img alt="First slide" src="{{ asset('images/eu/grand_oasis_palm/06.webp') }}">
                            </img>
                        </div>
                        <div class="carousel-item">
                            <img alt="First slide" src="{{ asset('images/eu/grand_oasis_palm/07.webp') }}">
                            </img>
                        </div>
                        <div class="carousel-item">
                            <img alt="First slide" src="{{ asset('images/eu/grand_oasis_palm/08.webp') }}">
                            </img>
                        </div>
                        <div class="carousel-item">
                            <img alt="First slide" src="{{ asset('images/eu/grand_oasis_palm/09.webp') }}">
                            </img>
                        </div>
                        <div class="carousel-item">
                            <img alt="First slide" src="{{ asset('images/eu/grand_oasis_palm/10.webp') }}">
                            </img>
                        </div>
                        <div class="carousel-item">
                            <img alt="First slide" src="{{ asset('images/eu/grand_oasis_palm/11.webp') }}">
                            </img>
                        </div>
                        <div class="carousel-item">
                            <img alt="First slide" src="{{ asset('images/eu/grand_oasis_palm/12.webp') }}">
                            </img>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <h4 class="text-danger mt-4 text-center">
        Importante: No aplica del 23 de Diciembre del 2022 al 03 de Enero del 2023
    </h4>
</section>
<section class="hotel_list single_page_hotel_list mt-5">
    <div class="text-center">
        <h1>
            ¡Compra ahora y paga después, tienes un año para viajar!
        </h1>
    </div>
    <form action="{{ route('process-payment.create') }}" id="form_compra_eu" method="post">
        @csrf
        <div class="container">
            <div class="row justify-content-start">
                <div class="col-xl-12" style="margin-bottom: -20px;">
                    <div class="section_tittle" id="titulo">
                        <h2 class="text-center">
                            Paso 1
                        </h2>
                        <p class="text-center">
                            Selecciona tu hotel.
                        </p>
                    </div>
                </div>
                <div class="col-md-12 ">
                    <div class="row">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>
                                        Estancia
                                    </th>
                                    <th>
                                        # Personas
                                    </th>
                                    <th>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($estancias as $estancia)
                                <tr>
                                    <td>
                                        <div class="radio " style="font-size: 20px; color: #000">
                                            <label class="text-uppercase">
                                                <input checked="" class="paquete" id="" name="estancia_id" type="radio" value="{{ $estancia->id }}">
                                                    {{ $estancia->title }}
                                                    <br/>
                                                    <strong>
                                                        $54 dlls al mes por persona
                                                    </strong>
                                                </input>
                                            </label>
                                        </div>
                                    </td>
                                    <td style="width: 150px;">
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <button class="btn btn-outline-secondary numRes" data-id="{{ $loop->index }}" id="numRes{{ $loop->index }}" type="button">
                                                    -
                                                </button>
                                            </div>
                                            <input class="form-control" data-id="{{ $loop->index }}" id="num_pax{{ $loop->index }}" name="num_pax" type="text" value="2">
                                            </input>
                                            <div class="input-group-append">
                                                <button class="btn btn-outline-secondary numSum" data-id="{{ $loop->index }}" id="numSum{{ $loop->index }}" type="button">
                                                    +
                                                </button>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <button class="btn btn-warning waves-effect waves-light btn-xs" data-id="" data-target="#modalPuntacana" data-toggle="modal" type="button">
                                            Ver detalles
                                        </button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{--  @foreach ($estancias as $estancia)
                        <div class="col-md-6 col-xs-6 mt-2">
                            <div class="radio " style="font-size: 20px; color: #000">
                                <label class="text-uppercase">
                                    <input checked="" class="paquete" id="" name="estancia_id" type="radio" value="{{ $estancia->id }}">
                                        {{ $estancia->title }}
                                        <br/>
                                        <strong>
                                            $54 dlls al mes por persona
                                        </strong>
                                    </input>
                                </label>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <label for="">
                                Número de personas
                            </label>
                            <select class="form-control" id="" name="num_personas">
                                <option value="2">
                                    2
                                </option>
                                <option value="3">
                                    3
                                </option>
                                <option value="4">
                                    4
                                </option>
                                <option value="5">
                                    5
                                </option>
                                <option value="6">
                                    6
                                </option>
                            </select>
                        </div>
                        <div class="col-md-4 col-xs-4 mt-3">
                            <button class="btn btn-warning waves-effect waves-light btn-xs" data-id="" data-target="#modalPuntacana" data-toggle="modal" type="button">
                                Ver detalles
                            </button>
                        </div>
                        @endforeach --}}
                        <span class="text-danger error-paquete errors">
                        </span>
                    </div>
                </div>
                {{--
                <div class="col-md-12 mt-2 pt-2 mb-5 pt-5">
                    <div class="text-center">
                        <button class="btn btn-primary" type="button">
                            Review our High & Low Seeason Calendar
                        </button>
                    </div>
                </div>
                --}}
                @guest
                {{-- @include('pagina.usa.elementos.form_sales') --}}
                <div class="col-xl-12 mt-5" style="margin-bottom: -20px;">
                    <div class="section_tittle" id="titulo">
                        <h2 class="text-center">
                            Paso 2
                        </h2>
                        <p class="text-center">
                            Información de contacto
                        </p>
                    </div>
                </div>
                <div class="col-md-10 offset-md-1">
                    <div class="row" id="form_data">
                        <div class="col-lg-4 col-md-6 col-sm-12 form-group">
                            <label for="nombre">
                                Nombre (s)
                            </label>
                            <input aria-describedby="Nombre" class="form-control error" id="nombre" name="nombre" placeholder="Nombre (s)" type="text" value="{{ request()->session()->get('nombre') }}">
                                <span class="text-danger error-nombre errors">
                                </span>
                            </input>
                        </div>
                        <div class="col-lg-4 col-md-6 col-sm-12 form-group">
                            <label for="apellidos">
                                Apellidos
                            </label>
                            <input aria-describedby="apellidos" class="form-control" id="apellidos" name="apellidos" placeholder="Apellidos" type="text" value="{{ request()->session()->get('apellidos') }}">
                                <span class="text-danger error-apellidos errors">
                                </span>
                            </input>
                        </div>
                        <div class="col-md-4 form-group">
                            <label for="telefono">
                                Teléfono
                            </label>
                            <input aria-describedby="telefono" class="form-control" id="telefono" name="telefono" placeholder="1234567890" type="text" value="{{ request()->session()->get('telefono') }}">
                                <span class="text-danger error-telefono errors">
                                </span>
                            </input>
                        </div>
                        <div class="col-lg-4 col-md-8 form-group">
                            <label for="username">
                                Email
                            </label>
                            <input aria-describedby="username" class="form-control" id="username" name="username" placeholder="ejemplo@dominio.com" type="email" value="{{ request()->session()->get('username') }}">
                                <span class="text-danger error-username errors">
                                </span>
                            </input>
                        </div>
                        <div class="col-lg-4 col-md-6 form-group">
                            <label for="password">
                                Crear contraseña
                            </label>
                            <input aria-describedby="password" class="form-control" id="password" name="password" type="password">
                                <span class="text-danger error-password errors">
                                </span>
                            </input>
                        </div>
                        <div class="col-lg-4 col-md-6 form-group">
                            <label for="confirmar_password">
                                Confirma contraseña
                            </label>
                            <input class="form-control" id="password_confirmation" name="password_confirmation" type="password">
                            </input>
                        </div>
                        {{--
                        <div class="col-md-3 form-group">
                            <label for="cp">
                                Codigo Postal
                            </label>
                            <input aria-describedby="cp" class="form-control" id="cp" name="cp" placeholder="12345" type="text" value="{{ request()->session()->get('cp') }}">
                                <span class="text-danger error-cp errors">
                                </span>
                            </input>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="cp">
                                Ciudad
                            </label>
                            <input class="form-control" id="ciudad" name="ciudad" placeholder="Ciudad" type="text" value=""/>
                            <span class="text-danger error-ciudad errors">
                            </span>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="cp">
                                Estado
                            </label>
                            <input class="form-control" id="estado" name="estado" placeholder="Estado" type="text" value=""/>
                            <span class="text-danger error-estado errors">
                            </span>
                        </div>
                        <div class="col-md-12 form-group">
                            <label for="direccion">
                                Dirección
                            </label>
                            <input aria-describedby="direccion" class="form-control" id="direccion" name="direccion" placeholder="Dirección" type="text" value="{{ request()->session()->get('direccion') }}">
                                <span class="text-danger error-direccion errors">
                                </span>
                            </input>
                        </div>
                        --}}
                    </div>
                </div>
                @endguest
                <div class="col-md-10 offset-md-1">
                    <div class="row">
                        <div class="col-md-12">
                            <button class="btn btn-primary" data-id="user_data" id="btnSiguiente" type="button">
                                Siguiente paso
                                <i class="fas fa-arrow-right">
                                </i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</section>
<div class="container mt-5 mb-5 text-center">
    <div class="row">
        <div class="col-md-6">
            <div class="carousel slide" data-ride="carousel" id="carousel-example-generic">
                <div class="carousel-inner" role="listbox">
                    <div class="carousel-item active">
                        <img alt="First slide" src="{{ asset('images/eu/grand_oasis_palm/01.webp') }}">
                        </img>
                    </div>
                    <div class="carousel-item">
                        <img alt="First slide" src="{{ asset('images/eu/grand_oasis_palm/02.webp') }}">
                        </img>
                    </div>
                    <div class="carousel-item">
                        <img alt="First slide" src="{{ asset('images/eu/grand_oasis_palm/03.webp') }}">
                        </img>
                    </div>
                    <div class="carousel-item">
                        <img alt="First slide" src="{{ asset('images/eu/grand_oasis_palm/04.webp') }}">
                        </img>
                    </div>
                    <div class="carousel-item">
                        <img alt="First slide" src="{{ asset('images/eu/grand_oasis_palm/05.webp') }}">
                        </img>
                    </div>
                    <div class="carousel-item">
                        <img alt="First slide" src="{{ asset('images/eu/grand_oasis_palm/06.webp') }}">
                        </img>
                    </div>
                    <div class="carousel-item">
                        <img alt="First slide" src="{{ asset('images/eu/grand_oasis_palm/07.webp') }}">
                        </img>
                    </div>
                    <div class="carousel-item">
                        <img alt="First slide" src="{{ asset('images/eu/grand_oasis_palm/08.webp') }}">
                        </img>
                    </div>
                    <div class="carousel-item">
                        <img alt="First slide" src="{{ asset('images/eu/grand_oasis_palm/09.webp') }}">
                        </img>
                    </div>
                    <div class="carousel-item">
                        <img alt="First slide" src="{{ asset('images/eu/grand_oasis_palm/10.webp') }}">
                        </img>
                    </div>
                    <div class="carousel-item">
                        <img alt="First slide" src="{{ asset('images/eu/grand_oasis_palm/11.webp') }}">
                        </img>
                    </div>
                    <div class="carousel-item">
                        <img alt="First slide" src="{{ asset('images/eu/grand_oasis_palm/12.webp') }}">
                        </img>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="carousel slide" data-ride="carousel" id="carousel-example-generic">
                <div class="carousel-inner" role="listbox">
                    <div class="carousel-item active">
                        <img alt="First slide" src="{{ asset('images/eu/grand_oasis_cancun/01.webp') }}">
                        </img>
                    </div>
                    <div class="carousel-item">
                        <img alt="First slide" src="{{ asset('images/eu/grand_oasis_cancun/02.webp') }}">
                        </img>
                    </div>
                    <div class="carousel-item">
                        <img alt="First slide" src="{{ asset('images/eu/grand_oasis_cancun/03.webp') }}">
                        </img>
                    </div>
                    <div class="carousel-item">
                        <img alt="First slide" src="{{ asset('images/eu/grand_oasis_cancun/04.webp') }}">
                        </img>
                    </div>
                    <div class="carousel-item">
                        <img alt="First slide" src="{{ asset('images/eu/grand_oasis_cancun/05.webp') }}">
                        </img>
                    </div>
                    <div class="carousel-item">
                        <img alt="First slide" src="{{ asset('images/eu/grand_oasis_cancun/06.webp') }}">
                        </img>
                    </div>
                    <div class="carousel-item">
                        <img alt="First slide" src="{{ asset('images/eu/grand_oasis_cancun/07.webp') }}">
                        </img>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
{{--
<div class="container">
    <div class="row p-5">
        <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12" style="background-color: rgba(23 162 184) !important;">
            <p class="vc_custom_heading mt-4" style="color: #ffffff;text-align: center; padding: 10px;font-weight: 400; ">
                My Travel Benefits
                <em>
                    by Optucorp
                </em>
                ofrece los programas de viajes mas asequible.
            </p>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-6 col-xs-6" style="background-color: rgba(32,155,225,.65) !important;">
            <p class="vc_custom_heading" style="color: #ffffff;text-align: center; padding: 25px 10px;font-weight: 400;">
                Sin fechas restrigidas
                <br>
                    sin intereses
                    <br>
                        Reserve ahora, pague despues
                    </br>
                </br>
            </p>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-6 col-xs-6" style="background-color: rgba(255 193 7) !important;">
            <p class="vc_custom_heading" style="color: #000000;text-align: center; padding: 25px 10px;font-weight: 400;">
                Las opciones de pagos hacen que viajar sea pan comido.
            </p>
        </div>
    </div>
</div>
--}}
<div aria-hidden="true" aria-labelledby="modalPuntacana" class="modal fade mt-4 pt-4 mb-4 pb-4" id="modalPuntacana" tabindex="-1">
    <div class="modal-dialog ">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="" style="color: black">
                    Detalles de la estancia
                </h5>
                <button aria-label="Close" class="close" data-dismiss="modal" type="button">
                    <span aria-hidden="true">
                        ×
                    </span>
                </button>
            </div>
            <div class="modal-body">
                <h3>
                    Reservar tu paquete vacacional con My Travel Benefits
                    <em>
                        by Optucorp
                    </em>
                    es facil!
                </h3>
                <p>
                    Cuentas con un año para poder elegir la fecha que desees viajar.
                </p>
                <h3>
                    Grand Oasis Cancun y Grand Oasis Palm:
                </h3>
                <ul class="unordered-list">
                    <li>
                        4 noches 5 días de estancia
                    </li>
                    <li>
                        Plan todo incluido
                    </li>
                    <li>
                        Por tan solo $54 dlls al mes por persona o $27 dlls diferidos en 24 pagos
                    </li>
                    <li>
                        Aplica mínimo 2 personas por habitación
                    </li>
                    <li>
                        Down payment $35 dlls (*Pago único)
                    </li>
                </ul>
                <h4 class="text-danger mt-4">
                    Importante: No aplica del 23 de Diciembre del 2022 al 03 de Enero del 2023
                </h4>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary btn-sm" data-dismiss="modal" type="button">
                    Cerrar
                </button>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
<script>
    $(document).ready(function() {
                
        // if ($('#num_pax0').val() <= 2 || $('#num_pax1').val() <= 2) {
        //     toastr['warning']('Ha llegado al mínimo de personas por habitación')
        //     $('.numRes').attr('disabled', true)
        // }
        
        $(document).on('click', '.numRes', function(event) {
            event.preventDefault();
            var id = $(this).data('id');
         
            $num = $('#num_pax'+id).val();
            $num--;
            $('#num_pax'+id).val($num);
            
            if ($num <= 2) {
                toastr['warning']('Ha llegado al mínimo de personas por habitación')
                $('#numRes'+id).attr('disabled', true)
            }
            else{
                $('#numSum'+id).attr('disabled', false)
            }
        });

        $(document).on('click', '.numSum', function(event) {
            event.preventDefault();
            var id = $(this).data('id');
            $num = $('#num_pax'+id).val();
            $num++;
            $('#num_pax'+id).val($num);
            
            if ($num >= 4) {
                toastr['warning']('Ha llegado al máximo de personas por habitación');
                $('#numSum'+id).attr('disabled', true)
            }
            else{
                // $('.numSum').attr('disabled', false)
                 $('#numRes'+id).attr('disabled', false)
            }
        });

        $('body').on('click', '#btnSiguiente', function(event) {
            event.preventDefault();
            $.ajax({
                url: $('#form_compra_eu').attr('action'),
                // url: baseuri + 'process-payment/create',
                type: 'GET',
                dataType: 'json',
                data: $('#form_compra_eu').serialize(),
                beforeSend: function() {
                    $("#overlay").css("display", "block");
                },
                success: function(res) {
                    if (res.success == false) {
                        pintar_errores(res.errors);
                    }
                    if (res.success == true) {
                        window.location.href = res.card;
                    }
                }
            })
            .always(function() {
                $("#overlay").css("display", "none");
            });
        });
    });
</script>
@stop
@include('pagina.usa.elementos.modal_preregistro')
{{-- @include('pagina.usa.exclusive.script_compra') --}}
