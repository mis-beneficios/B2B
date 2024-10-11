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
<section class="breadcrumb breadcrumb_bg" style="background-image: url(https://wallpapercave.com/wp/wp1887741.jpg);">
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
                        Hotel Riu Palace Paradise Island for adults only is located on an impressive white-sand beach on Paradise Island, in the Bahamas. This All-Inclusive 24-hour hotel has the best facilities for you to enjoy an unforgettable stay, such as free WiFi throughout the hotel, an extensive range of cuisine and the exclusive service of RIU Hotels & Resorts.

                        The 350-plus rooms in this Adults Only hotel on Paradise Island are equipped with a whole host of amenities, such as minibars, beverage dispensers, air conditioning and coffee machines. If you fancy cooling off during your stay, the facilities include two swimming pools, one with a swim-up bar, and a lounger and parasol area with beverage service. You can also enjoy direct access to the reserved beach area and relax in the hammocks under the warm Bahamian sun.
                    </p>
                </div>
            </div>
        </div>
        <div class="row align-items-center">
            <div class="col-lg-6">
                <img alt="" class="img-fluid" src="{{ asset('images/eu/bahamas/2.jpeg') }}">
                </img>
            </div>
            <div class="col-lg-6">
                <div class="about_text">
                    <h2 class="text-center">
                        Hotel
                    </h2>
                    <p class="text-justify">
                        The Paradise Island, formerly known as Hog Island, is located just off the shore of the city of Nassau in the northern edge New Providence. The Riu Palace Paradise Island has been reopened as an ADULTS ONLY hotel next to Atlantis, the biggest casino in the Caribbean and directly located in a sandy, white beach
                    </p>
                </div>
            </div>
        </div>
        <div class="row align-items-center">
            <div class="col-lg-6">
                <h3>
                    Highlights
                </h3>
                <ul class="unordered-list">
                    <li>
                        ADULTS ONLY hotel, exclusive to adults over 18 years old
                    </li>
                    <li>
                        All Inclusive 24 hours
                    </li>
                    <li>
                        Free WiFi throughout hotel
                    </li>
                    <li>
                        On beachfront, free sun loungers on beach
                    </li>
                    <li>
                        Awarded GOLD certification for the Travelife Sustainability System
                    </li>
                </ul>
                <ul class="unordered-list">
                    <li>
                        2.7 km / 1.7 miles from Montego Bay airport
                    </li>
                    <li>
                        Main and theme restaurants
                    </li>
                    <li>
                        3 infinity swimming pools, sun terrace
                    </li>
                    <li>
                        Free gym
                    </li>
                </ul>
            </div>
            <div class="col-lg-6">
                <div class="carousel slide" data-ride="carousel" id="carouselExampleControls">
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            <img alt="" class="d-block w-100 rounded" src="{{ asset('images/eu/bahamas/1.jpeg') }}">
                            </img>
                        </div>
                        <div class="carousel-item">
                            <img alt="" class="d-block w-100 rounded" src="{{ asset('images/eu/bahamas/4.jpeg') }}">
                            </img>
                        </div>
                        <div class="carousel-item">
                            <img alt="" class="d-block w-100 rounded" src="{{ asset('images/eu/bahamas/5.jpeg') }}">
                            </img>
                        </div>
                        <div class="carousel-item">
                            <img alt="" class="d-block w-100 rounded" src="{{ asset('images/eu/bahamas/6.jpeg') }}">
                            </img>
                        </div>
                        <div class="carousel-item">
                            <img alt="" class="d-block w-100 rounded" src="{{ asset('images/eu/bahamas/7.jpeg') }}">
                            </img>
                        </div>
                        <div class="carousel-item">
                            <img alt="" class="d-block w-100 rounded" src="{{ asset('images/eu/bahamas/8.jpeg') }}">
                            </img>
                        </div>
                    </div>
                    <a class="carousel-control-prev" data-slide="prev" href="#carouselExampleControls" role="button">
                        <span aria-hidden="true" class="carousel-control-prev-icon">
                        </span>
                        <span class="sr-only">
                            Previous
                        </span>
                    </a>
                    <a class="carousel-control-next" data-slide="next" href="#carouselExampleControls" role="button">
                        <span aria-hidden="true" class="carousel-control-next-icon">
                        </span>
                        <span class="sr-only">
                            Next
                        </span>
                    </a>
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
                    <div class="col-md-3">
                        <p class="lead text-white">
                            BEACHFRONT
                        </p>
                    </div>
                    <div class="col-md-3">
                        <p class="lead text-white">
                            ADULTS ONLY
                        </p>
                    </div>
                    <div class="col-md-3">
                        <p class="lead text-white">
                            ALL INCLUSIVE 24
                        </p>
                    </div>
                    <div class="col-md-3">
                        <p class="lead text-white">
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
                                        {{$estancia->noches .' nights in '. $estancia->title }}
                                        <br/>
                                        <strong>
                                            ${{ $estancia->precio/24 }} Bi-Weekly
                                        </strong>
                                    </input>
                                </label>
                            </div>
                        </div>
                        <div class="col-md-4 col-xs-4">
                            <button class="btn btn-warning waves-effect waves-light btn-xs" data-id="" data-target="#modalBahamas" data-toggle="modal" type="button">
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
<div aria-hidden="true" aria-labelledby="modalBahamas" class="modal fade mt-4 pt-4 mb-4 pb-4" id="modalBahamas" tabindex="-1">
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
                    <img class="img-fluid" id="imagen_hotel" src="{{ asset('images/eu/bahamas/8.jpeg') }}">
                    </img>
                </center>
                <h3>
                    Booking your vacation package with My Travel Benefits
                    <em>
                        by Optucorp
                    </em>
                    is easy!
                </h3>
                <div class="row ml-4">
                    <div class="col-md-8">
                        <ol>
                            <li>
                                Choose your destination!
                            </li>
                            <li>
                                Provide traveler’s information
                            </li>
                            <li>
                                Enter the credit or debit card you would like to put on file
                            </li>
                        </ol>
                    </div>
                </div>
                <ul class="unordered-list">
                    <li>
                        The Hotel stay is for 2 adults
                    </li>
                    <li>
                        Your rate is locked in for an entire year
                    </li>
                    <li>
                        24 Bi-weekly payments of $55.00
                    </li>
                    <li>
                        Travelers must book 2 months in advance of desired vacation dates
                    </li>
                </ul>
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
                        Beside the beach and 1 outdoor pool
                    </li>
                    <li>
                        24 hours room service
                    </li>
                    <li>
                        16 km away from Lynden Pindling  International Airport
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
