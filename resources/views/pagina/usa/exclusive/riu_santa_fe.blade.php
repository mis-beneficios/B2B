@extends('layouts.pagina.app')
<style>
    .errors {
        font-size: 12px;
    }
</style>
@section('content')
<section class="breadcrumb breadcrumb_bg" style="background-image: url({{ asset('images/eu/riu_santa_fe/head.jpeg') }});">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="breadcrumb_iner">
                    <div class="breadcrumb_iner_item text-center">
                        @if (session()->get('llave') && session()->get('llave') != 'mytravel')
                        <h2 class="">
                            Welcome {{ $convenio->empresa_nombre }} to
                        </h2>
                        @endif
                        <h2>
                            {{ $estancia->hotel_name }}
                            <br/>
                            {{ $estancia->destino->titulo }}
                        </h2>
                        <p class="lead" style="font-size: 28px;">
                            Book with only ${{ env('ENGANCHE') }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<div class="text-center mt-3 mb-3 pb-3">
    <div id="typed-strings">
        <h1 class="text-warning" id="typed">
            BOOK NOW PAY LATER WITH PAYMENTS FROM ${{ $estancia->precio/24 }} BI-WEEKLY
        </h1>
        <a class="btn-warning btn btn- waves-effect waves-light" href="#form_compra_eu" style="color: white;">
            BOOK NOW
        </a>
    </div>
</div>
<section class="about_us m-4">
    <div class="container">
        <div class="row m-4">
            <div class="col-md-12">
                <div class="about_text">
                    <h2 class="text-center">
                        {{ $estancia->title }}
                    </h2>
                    <p class="text-justify">
                        The Hotel Riu Santa Fe, located on the southern tip of the Baja California peninsula, on El Médano beach, offers impressive facilities to make your stay unforgettable. This 24h all-inclusive hotel in Los Cabos gives you free WiFi, a varied gastronomic offer, fun entertainment programmes and the exclusive service the brand is known for. And, you'll find plenty of fun thanks to the RIU POOL PARTY events, a series of lively parties by the pool with music and live shows, for adults-only.
                    </p>
                </div>
            </div>
        </div>
        <div class="row align-items-center">
            <div class="col-lg-6">
                <img alt="" class="img-fluid" src="{{ asset('images/eu/riu_santa_fe/1.jpeg') }}">
                </img>
            </div>
            <div class="col-lg-6">
                <div class="about_text">
                    <h2 class="text-center">
                        Hotel
                    </h2>
                    <p class="text-justify">
                        This hotel on El Médano beach with 24h all-inclusive service has a varied gastronomic offer for enjoying amazing culinary experiences. No doubt you'll be impressed by the breakfast buffets with show cooking, the Asian, Mexican and Italian restaurants, and the wide variety of dishes in the main restaurant. And if that weren't enough, in the ten bars located in different areas of the hotel, you can savour the best snacks and appetisers.
                    </p>
                </div>
            </div>
        </div>
        <div class="row align-items-center">
            <div class="col-lg-6">
                <div class="about_text">
                    <h2 class="text-center">
                        Room
                    </h2>
                    <p class="text-justify">
                        NEW! The 34-m2 Large Double rooms are perfect for people who want to experience a holiday with the best entertainment, as they are located around the Riu Pool Party and Splash Water World zone. These accommodations at the Hotel Riu Santa Fe boast modern design and provide two small double beds (125x200 cm), a sofa bed, satellite TV, air conditioning, a minibar and beverage dispenser, and a balcony or terrace.
                    </p>
                </div>
            </div>
            <div class="col-lg-6">
                <img alt="" class="img-fluid" src="{{ asset('images/eu/riu_santa_fe/3.jpeg') }}">
                </img>
            </div>
        </div>
        <div class="row align-items-center">
            <div class="col-lg-6">
                <img alt="" class="img-fluid" src="{{ asset('images/eu/riu_santa_fe/8.jpeg') }}">
                </img>
            </div>
            <div class="col-lg-6">
                <div class="about_text">
                    <h2 class="text-center">
                        Restaurants & Bars
                    </h2>
                    <div>
                        <div class="row">
                            <div class="col-md-6">
                                <address>
                                    <strong>
                                        ALL INCLUSIVE 24 HOURS
                                    </strong>
                                </address>
                                <address>
                                    <strong>
                                        ALL MEALS AND SNACKS
                                    </strong>
                                </address>
                                <address>
                                    <strong>
                                        BREAKFAST:
                                    </strong>
                                    <br/>
                                    Full American breakfast buffet and live cooking stations
                                    <br/>
                                    Continental breakfast / snacks
                                </address>
                                <address>
                                    <strong>
                                        LUNCH:
                                    </strong>
                                    <br/>
                                    Hot and cold buffet and live cooking stations
                                    <br/>
                                    Pizzas, pasta, salads and assorted desserts
                                    <br/>
                                    Grill in the pool area
                                </address>
                            </div>
                            <div class="col-md-6">
                                <address>
                                    <strong>
                                        DINNER:
                                    </strong>
                                    <br/>
                                    Buffets and dishes prepared live
                                    <br/>
                                    Special evenings: themed buffet (three times a week)
                                </address>
                                <address>
                                    <strong>
                                        OPTIONAL DINING:
                                    </strong>
                                    <br/>
                                    Steakhouse (à la carte)
                                    <br/>
                                    Mexican restaurant (à la carte)
                                    <br/>
                                    Italian restaurant (à la carte; buffet starters and dessert)
                                    <br/>
                                    Asian restaurant (à la carte; buffet starters and dessert)
                                </address>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="client_review mb-5">
    <div class="container">
        <div class="row ">
            <div class="col-xl-12 text-center">
                <div class="section_tittle mt-5" style="margin-bottom: 10px;">
                    <h2 class="text-uppercase">
                        {{ $estancia->hotel_name }}
                    </h2>
                </div>
                <div class="row text-center mb-5">
                    <div class="col-md-4">
                        <p class="lead text-white">
                            {{--
                            <i class="fas fa-users">
                            </i>
                            <br/>
                            --}}
                            RIULAND
                        </p>
                    </div>
                    <div class="col-md-4">
                        <p class="lead text-white">
                            {{--
                            <i class="fas fa-users">
                            </i>
                            <br/>
                            --}}
                            ALL INCLUSIVE 24
                        </p>
                    </div>
                    <div class="col-md-4">
                        <p class="lead text-white">
                            {{--
                            <i class="fas fa-wifi">
                            </i>
                            <br/>
                            --}}
                            FREE WIFI
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="hotel_list single_page_hotel_list mt-5">
    <div class="text-center">
        <h1>
            Book Now Pay Later!
        </h1>
    </div>
    <form action="{{ route('process-payment.create') }}" id="form_compra_eu" method="post">
        @csrf
        <div class="container">
            <div class="row justify-content-start">
                <div class="col-xl-12" style="margin-bottom: -20px;">
                    <div class="section_tittle" id="titulo">
                        <h2 class="text-center">
                            Step 1
                        </h2>
                        <p class="text-center">
                            Choose how many nights you would like to book.
                        </p>
                    </div>
                </div>
                <div class="col-md-10 offset-md-2">
                    <div class="row">
                        <div class="col-md-8 col-xs-8">
                            <div class="radio " style="font-size: 20px; color: #000">
                                <label class="text-capitalize">
                                    <input checked="" class="paquete" id="" name="estancia_id" type="radio" value="{{ $estancia->id }}">
                                        {{ $estancia->noches }} nights in {{ $estancia->title }}
                                        <br/>
                                        <strong>
                                            ${{ $estancia->precio/24 }} Bi-Weekly
                                        </strong>
                                    </input>
                                </label>
                            </div>
                        </div>
                        <div class="col-md-4 col-xs-4">
                            <button class="btn btn-warning waves-effect waves-light btn-xs" data-id="" data-target="#modalCabos" data-toggle="modal" type="button">
                                View Details
                            </button>
                        </div>
                        <span class="text-danger error-paquete errors">
                        </span>
                    </div>
                </div>
                @guest
                @include('pagina.usa.elementos.form_sales')
                @endguest
                <div class="col-md-10 offset-md-1">
                    <div class="row">
                        <div class="col-md-12">
                            <button class="btn btn-primary" data-id="user_data" id="btnSiguiente" type="button">
                                Next step
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
<div class="container">
    <div class="row p-5">
        <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12" style="background-color: rgba(23 162 184) !important;">
            <p class="vc_custom_heading" style="color: #ffffff;text-align: center; padding: 10px;font-weight: 400; ">
                My Travel Benefits
                <em>
                    by Optucorp
                </em>
                partners with your employer to offer the most affordable travel programs
                <br>
                    available.
                    <br>
                    </br>
                </br>
            </p>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-6 col-xs-6" style="background-color: rgba(32,155,225,.65) !important;">
            <p class="vc_custom_heading" style="color: #ffffff;text-align: center; padding: 25px 10px;font-weight: 400;">
                <!-- NO Deposit
                            <br/> -->
                NO Blackout Dates
                <br>
                    NO Stress
                    <br>
                        Book Now, Pay Later
                    </br>
                </br>
            </p>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-6 col-xs-6" style="background-color: rgba(255 193 7) !important;">
            <p class="vc_custom_heading" style="color: #000000;text-align: center; padding: 25px 10px;font-weight: 400;">
                Bi-Weekly payment
                <br>
                    options makes travel
                    <br>
                        a breeze.
                    </br>
                </br>
            </p>
        </div>
    </div>
</div>
<div aria-hidden="true" aria-labelledby="modalCabos" class="modal fade mt-4 pt-4 mb-4 pb-4" id="modalCabos" tabindex="-1">
    <div class="modal-dialog ">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="" style="color: black">
                    Stay Details
                </h5>
                <button aria-label="Close" class="close" data-dismiss="modal" type="button">
                    <span aria-hidden="true">
                        ×
                    </span>
                </button>
            </div>
            <div class="modal-body">
                <center>
                    <img class="img-fluid" id="imagen_hotel" src="{{ asset('images/eu/riu_santa_fe/6.jpeg') }}">
                    </img>
                </center>
                <div class="">
                    <h3>
                        Booking your vacation package with My Travel Benefits
                        <em>
                            by Optucorp
                        </em>
                        is easy!
                    </h3>
                    <ol class="ml-4">
                        <li>
                            Choose which package you would like to book!
                        </li>
                        <li>
                            Provide traveler’s information
                        </li>
                        <li>
                            Enter the credit or debit card you would like to put on file
                        </li>
                    </ol>
                </div>
                <p>
                    You then have a full year to decide the exact date and destination of your travel.
                    We require no deposit and there are no black-out dates. My Travel Benefits locks in your discounted travel rate now. It as easy as 1,2,3!
                </p>
                <h3>
                    Benefit Details
                </h3>
                <ul class="unordered-list">
                    <li>
                        The Hotel stay is for 2 adults and 2 kids
                    </li>
                    <li>
                        3 & 4-star hotel options
                    </li>
                    <li>
                        Breakfast only ( If available)
                    </li>
                    <li>
                        Breakfast for two people (where available)
                    </li>
                    <li>
                        Your rate is locked in for an entire year
                    </li>
                    <li>
                        24 payments Bi-weekly
                    </li>
                    <li>
                        Traveler can book stay once 80% of the payments are complete
                    </li>
                    <li>
                        Travelers must book 2 months in advance of desired vacation dates
                    </li>
                </ul>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary btn-sm" data-dismiss="modal" type="button">
                    Close
                </button>
            </div>
        </div>
    </div>
</div>
@endsection
@include('pagina.usa.elementos.modal_preregistro')
@include('pagina.usa.exclusive.script_compra')
