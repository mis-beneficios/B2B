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
<section class="breadcrumb breadcrumb_bg" style="background-image: url({{ asset('images/eu/vegas/head.jpeg') }});">
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
                            Las Vegas Nevada
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
                        Being a huge complex this hotel has a huge casino. The hotel is located at the southern end of The Las Vegas Strip, with cozy rooms decorated in an elegant and contemporary style. You can also enjoy the gastronomic variety as it has different specialty restaurants. This hotel houses the famous MGM Garden Arena concert and sports hall. You can also enjoy its 5 swimming pools, an artificial river, spa (additional charge applies), gym (with additional charge), nightclubs and much much more!
                    </p>
                </div>
            </div>
        </div>
        <div class="row align-items-center">
            <div class="col-lg-6">
                <img alt="" class="img-fluid" src="{{ asset('images/eu/vegas/1.jpeg') }}"/>
            </div>
            <div class="col-lg-6">
                <div class="about_text">
                    <h2 class="text-center">
                        Casino
                    </h2>
                    <p class="text-justify">
                        Known as the $1-$2 No Limit Capital of Las Vegas, the MGM Grand Poker Room is the Strip’s #1 hotspot for Texas Hold'em. Open 24 hours, our non-smoking Poker Room is the perfect location for players looking for fun and excitement.
                        In the early morning hours, the Poker Room takes on a low-key vibe with its quiet atmosphere and tableside massage offerings. But as the day progresses, the energy of the room increases into an electrifying fusion of Vegas nightlife and high-stakes poker.
                    </p>
                </div>
            </div>
        </div>
        <div class="row align-items-center mt-3">
            <div class="col-lg-6">
                <div class="about_text">
                    <h2 class="text-center">
                        Hotel
                    </h2>
                    <p class="text-justify">
                        With 4996 modern and well equipped rooms and suites, this hotel offers accommodation for any occasion. This vibrant complex has a modern conference room, a casino, the Grand Spa, the Christope Salon and a pool complex of 6.5 acres. Listen to famous DJs in the Wet Republic Ultra pool and enjoy the party environment MGM Las Vegas has to offer.
                    </p>
                </div>
            </div>
            <div class="col-lg-6">
                <img alt="" class="img-fluid" src="{{ asset('images/eu/vegas/2.jpeg') }}"/>
            </div>
        </div>
        <div class="row align-items-center">
            <div class="col-lg-6">
                <img alt="" class="img-fluid" src="{{ asset('images/eu/vegas/3.jpeg') }}"/>
            </div>
            <div class="col-lg-6">
                <div class="about_text">
                    <h2 class="text-center">
                        Rooms
                    </h2>
                    <p class="text-justify">
                        The hotel rooms at MGM Grand come with city or Strip views, with King or double Queen beds, and as smoking or guaranteed non-smoking. No matter which room you choose, you'll be close to all the best in entertainment and dining found in Las Vegas.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>
<hr/>
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
                                <label>
                                    <input checked="" class="paquete" id="" name="estancia_id" type="radio" value="{{ $estancia->id }}">
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
                            <button class="btn btn-warning waves-effect waves-light btn-xs" data-id="" data-target="#modalVegas" data-toggle="modal" type="button">
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
<div aria-hidden="true" aria-labelledby="modalVegas" class="modal fade mt-4 pt-4 mb-4 pb-4" id="modalVegas" tabindex="-1">
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
                    <img class="img-fluid" id="imagen_hotel" src="{{ asset('images/eu/vegas/2.jpeg') }}">
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
