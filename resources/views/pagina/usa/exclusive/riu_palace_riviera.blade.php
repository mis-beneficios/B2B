@extends('layouts.pagina.app')
<style>
    .errors {
        font-size: 12px;
    }
    .client_review{
        background-color: #008cc5;
    }

    .breadcrumb_riviera{
        /*background-image: url({{ asset('images/eu/disney/header1.jpeg') }});*/
        background-image: url(https://wallpapercave.com/wp/wp4203136.jpg);
        /*background-attachment: fixed;*/
        background-size: cover;
        background-repeat: no-repeat;
        background-position: center 50%;
    }
</style>
@section('content')
<section class="breadcrumb breadcrumb_riviera" style="background-image: url(https://wallpapercave.com/wp/wp4203136.jpg);">
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
                        <h2 class="text-capitalize">
                            {{ $estancia->hotel_name }}
                            <br/>
                            Quintana Roo, México
                            {{-- {{ $estancia->destino->titulo }} --}}
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
                        The Hotel Riu Palace Riviera Maya is located on a lovely white-sand beach in Playa del Carmen and offers you the best 24-hour All Inclusive service. And, at this hotel in Playacar you have free WiFi, a varied gastronomic offer and fun entertainment programmes for all ages.

                        Maximum comfort awaits you in its rooms: air conditioning, a minibar with beverage dispensers, a coffee maker and countless other amenities that will make your stay a unique experience. And you can cool off and enjoy the warm Mexican climate in the hotel pools, one of which has a swim-up bar. But if you prefer the beach, we offer you a zone with lounge chairs reserved for guests of the hotel.
                    </p>
                </div>
            </div>
        </div>
        <div class="row align-items-center">
            <div class="col-lg-6">
                <img alt="" class="img-fluid" src="{{ asset('images/eu/riu_riviera/2.jpeg') }}">
                </img>
            </div>
            <div class="col-lg-6">
                <div class="about_text">
                    <h2 class="text-center">
                        Hotel
                    </h2>
                    <p class="text-justify">
                        Located directly on the beach of the Playacar residential estate along with Riu Tequila hotels, Riu Palace Mexico and Riu Yucatan, the Riu Palace Riviera Maya offers spacious and elegant junior suites surrounded by extensive gardens and a delightful arquitectural style. This hotel has 460 rooms equipped with everything you need for wonderful experience.
                    </p>
                </div>
            </div>
        </div>
        <div class="row align-items-center">
            <div class="col-lg-6">
                <div class="about_text">
                    <h2 class="text-center">
                        Restaurants & Bars
                    </h2>
                    <p class="text-justify">
                        The varied gastronomy you’ll find at the Hotel Riu Palace Riviera Maya will let you enjoy incredible flavours. The buffet breakfasts with live cooking stations in the main restaurant will surprise you, and you’ll be able to try the best Italian and Mexican recipes, among many others, at the theme restaurants. The five bars at this hotel in Playacar also offer numerous snacks and appetizers.
                    </p>
                </div>
            </div>
            <div class="col-lg-6">
                <img alt="" class="img-fluid" src="{{ asset('images/eu/riu_riviera/6.jpeg') }}">
                </img>
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
                    <div class="col-md-3">
                        <p class="lead text-white">
                            {{--
                            <i class="fas fa-users">
                            </i>
                            <br/>
                            --}}
                            BEACHFRONT
                        </p>
                    </div>
                    <div class="col-md-3">
                        <p class="lead text-white">
                            {{--
                            <i class="fas fa-users">
                            </i>
                            <br/>
                            --}}
                            SPA
                        </p>
                    </div>
                    <div class="col-md-3">
                        <p class="lead text-white">
                            {{--
                            <i class="fas fa-users">
                            </i>
                            <br/>
                            --}}
                            ALL INCLUSIVE 24
                        </p>
                    </div>
                    <div class="col-md-3">
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
                                <label class="text-uppercase">
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
                            <button class="btn btn-warning waves-effect waves-light btn-xs" data-id="" data-target="#modalRiviera" data-toggle="modal" type="button">
                                View Details
                            </button>
                        </div>
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
<div aria-hidden="true" aria-labelledby="modalRiviera" class="modal fade mt-4 pt-4 mb-4 pb-4" id="modalRiviera" tabindex="-1">
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
                    <img class="img-fluid" id="imagen_hotel" src="{{ asset('images/eu/riu_riviera/5.jpeg') }}">
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
                    <ul class="unordered-list">
                        <li>
                            The Hotel stay is for 2 adults
                        </li>
                        <li>
                            Your rate is locked in for an entire year
                        </li>
                        <li>
                            24 Bi-weekly payments of $51.00
                        </li>
                        <li>
                            Travelers must book 2 months in advance of desired vacation dates
                        </li>
                    </ul>
                </div>
                <h3>
                    This beautiful hotel includes:
                </h3>
                <ul class="unordered-list">
                    <li>
                        All inclusive 24 hours
                    </li>
                    <li>
                        Free WiFi
                    </li>
                    <li>
                        Beside the beach and 3 pools
                    </li>
                    <li>
                        24 hours room service
                    </li>
                    <li>
                        55 km away from the airport
                    </li>
                    <li>
                        Kids club
                    </li>
                    <li>
                        Spa
                    </li>
                    <li>
                        Gym and sauna
                    </li>
                    <li>
                        Snacks and Cocktail service 24h
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
