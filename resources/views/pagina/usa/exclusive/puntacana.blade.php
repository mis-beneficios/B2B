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
<section class="breadcrumb breadcrumb_bg" style="background-image: url(https://wallpapercave.com/wp/wp3081002.jpg);">
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
                            {{ $estancias[0]->hotel_name }}
                            <br/>
                            {{ ($estancias[0]->destino) ? $estancias[0]->destino->titulo : '' }}
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
            BOOK NOW PAY LATER WITH PAYMENTS FROM ${{ $estancias[0]->precio/24 }} BI-WEEKLY
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
                        {{ $estancias[0]->hotel_name }}
                    </h2>
                    <p class="text-justify">
                        A large oceanfront resort with "all inclusive" service, which has rooms located overlooking the Bavaro beach. All rooms equipped with air conditioning, satellite tv, and amenities. Complementing the service with 5 buffet restaurants, 8 a la carte restaurants and more than 25 bars. For fun and relaxation the hotel offers 6 swimming pools with bars, a sauna, a gym, recreational activities such as snorkeling, tennis, windsurfing and evening shows, led by the entertainment staff. The hotel is 20 kilometers from the Punta Cana Airport.
                    </p>
                </div>
            </div>
        </div>
        <div class="row align-items-center">
            <div class="col-lg-6">
                <img alt="" class="img-fluid" src="{{ asset('images/eu/puntacana/1.jpeg') }}">
                </img>
            </div>
            <div class="col-lg-6">
                <div class="about_text">
                    <h2 class="text-center">
                        Hotel
                    </h2>
                    <p class="text-justify">
                        This world-class all-inclusive hotel offers premium services for friends, couples, and families looking for a fun-filled Caribbean holiday. Conveniently located near a variety of different on-site activities such as the Black & White Junior Club, Sunset Boulevard Disco and the Sunset Theater. Guests can dine on a variety of delectable gastronomic options including à la carte restaurants and show cooking restaurants with delicious cuisine suited to the most diverse palettes. Why Choose Grand Palladium Bávaro Suites Resort & Spa? Named after one of the most famous beaches on the east coast of Quisqueya, Grand Palladium Bávaro Suites Resort & Spa boasts beautiful scenic tropical landscapes, lush vegetation and a stunning white sand beach, combining beachside bliss with 5-star glamour. The fully-equipped, spacious rooms with detailed finishings, swanky cocktail bars, immaculate grounds, sports-orientated activities and live entertainment makes the hotel a first-class holiday destination.
                    </p>
                </div>
            </div>
        </div>
        <div class="row align-items-center mt-3">
            <div class="col-lg-6">
                <div class="about_text">
                    <h2 class="text-center">
                        Rooms
                    </h2>
                    <p class="text-justify">
                        The rooms and suites of the Grand Palladium Bavaro Resort & Spa include air conditioning, free satellite TV and a desk. Some rooms and suites have separate seating areas and hot tubs. Guests can also enjoy a private patio or balcony overlooking the ocean or the pool and the hotel's garden.
                    </p>
                </div>
            </div>
            <div class="col-lg-6">
                <img alt="" class="img-fluid" src="{{ asset('images/eu/puntacana/6.jpeg') }}">
                </img>
            </div>
        </div>
        <div class="row align-items-center">
            <div class="col-lg-6">
                <img alt="" class="img-fluid" src="{{ asset('images/eu/puntacana/4.jpeg') }}">
                </img>
            </div>
            <div class="col-lg-6">
                <div class="about_text">
                    <h2 class="text-center">
                        Services and Treatments
                    </h2>
                    <div>
                        <ul class="unordered-list">
                            <li>
                                Gym with changing rooms, lockers and air conditioning
                            </li>
                            <li>
                                Jacuzzi
                            </li>
                            <li>
                                Turkish bath
                            </li>
                            <li>
                                Swimming pool
                            </li>
                            <li>
                                Sauna
                            </li>
                            <li>
                                Steam shower
                            </li>
                            <li>
                                Beauty salon*
                            </li>
                            <li>
                                Hair removal*
                            </li>
                            <li>
                                Facial and body treatments and scrubs *
                            </li>
                            <li>
                                Massages (Swedish, sports, reflexology, Vichy, etc.) *
                            </li>
                            <li>
                                Manicure and pedicure
                            </li>
                            <li>
                                Wide range of therapies*
                            </li>
                            <li>
                                Open every day - Air conditioning - Area for adults only
                            </li>
                            <li>
                                Information subject to change.
                            </li>
                            <li>
                                *Additional charge.
                            </li>
                        </ul>
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
                        {{ $estancias[0]->hotel_name }}
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
                        @foreach ($estancias as $estancia)
                        <div class="col-md-8 col-xs-8">
                            <div class="radio " style="font-size: 20px; color: #000">
                                <label class="text-uppercase">
                                    <input checked="" class="paquete" id="" name="estancia_id" type="radio" value="{{ $estancia->id }}">
                                        {{-- {{ $estancia->noches }} nights in {{ $estancia->hotel_name }} --}}
                                        {{ $estancia->title }}
                                        <br/>
                                        <strong>
                                            ${{ $estancia->precio/24 }} Bi-Weekly
                                        </strong>
                                    </input>
                                </label>
                            </div>
                        </div>
                        <div class="col-md-4 col-xs-4">
                            <button class="btn btn-warning waves-effect waves-light btn-xs" data-id="" data-target="#modalPuntacana" data-toggle="modal" type="button">
                                View Details
                            </button>
                        </div>
                        @endforeach
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
<div aria-hidden="true" aria-labelledby="modalPuntacana" class="modal fade mt-4 pt-4 mb-4 pb-4" id="modalPuntacana" tabindex="-1">
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
                    <img class="img-fluid" id="imagen_hotel" src="{{ asset('images/eu/puntacana/2.jpeg') }}">
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
                <p>
                    You then have a full year to decide the exact date and destination of your travel.
                    We require no deposit and there are no black-out dates. My Travel Benefits locks in your discounted travel rate now. It as easy as 1,2,3!
                </p>
                <h3>
                    This beautiful hotel includes:
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
