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
<section class="breadcrumb breadcrumb_bg" style="background-image: url(https://external-content.duckduckgo.com/iu/?u=http%3A%2F%2Fwww.orlandotomiamishuttle.com%2Fwp-content%2Fuploads%2F2014%2F11%2F3-13-14-Miami-Skyline.jpg&f=1&nofb=1);">
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
                            {{ ($estancias[0]->destino) ?$estancias[0]->destino->titulo : '' }}
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
                        When you're in Miami you are in the tropics. This destination is blessed with year round warm weather, beautiful beaches, culture, art, food and a world-renowned nightlife! Whether it's an art gallery that calls your attention, cocktails on the beach, celebrity infused nightclubs, Florida's ecosystems - such as The Everglades or The Florida Keys, or simply a day of shopping at the Bal Harbour Shops or Sawgrass Mall - this hotel has close proximity to it all!
                    </p>
                </div>
            </div>
        </div>
        <div class="row align-items-center">
            <div class="col-lg-6">
                <div class="carousel slide" data-ride="carousel" id="home">
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            <img alt="" class="d-block w-100 rounded" src="{{ asset('images/eu/miami/1.jpeg') }}">
                            </img>
                        </div>
                        <div class="carousel-item ">
                            <img alt="" class="d-block w-100 rounded" src="{{ asset('images/eu/miami/2.jpeg') }}">
                            </img>
                        </div>
                        <div class="carousel-item">
                            <img alt="" class="d-block w-100 rounded" src="{{ asset('images/eu/miami/3.jpeg') }}">
                            </img>
                        </div>
                    </div>
                    <a class="carousel-control-prev" data-slide="prev" href="#home" role="button">
                        <span aria-hidden="true" class="carousel-control-prev-icon">
                        </span>
                        <span class="sr-only">
                            Previous
                        </span>
                    </a>
                    <a class="carousel-control-next" data-slide="next" href="#home" role="button">
                        <span aria-hidden="true" class="carousel-control-next-icon">
                        </span>
                        <span class="sr-only">
                            Next
                        </span>
                    </a>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="about_text">
                    <h2 class="text-center">
                        An Oceanfront Oasis
                    </h2>
                    <p class="text-justify">
                        The Grand Beach Hotel Miami Beach in South Beach, Florida is in an amazing location, overlooking more than 200 feet of beautiful white sandy tropical beaches on the Atlantic Ocean. Built in 2009 and completely renovated in 2018, this modern Miami hotel offers the highest levels of luxury and comfort. The leisure facilities include two hot tubs, a state of the art gym with unbeatable panoramic sunset views, as well as three different swimming pools, including 2 beach level family pools and our top floor tranquility pool (adults only) offering something for every guest.
                    </p>
                </div>
            </div>
        </div>
        <div class="row align-items-center mt-3">
            <div class="col-lg-6">
                <div class="about_text">
                    <h2 class="text-center">
                        Breathtaking Suites
                    </h2>
                    <p class="text-justify">
                        The Grand Beach Hotel offers guests luxurious accommodations on a quiet stretch of Miami Beach. Their oversized accommodations in Miami Beach provide the perfect choice for families visiting Miami. Standard rooms start at more than 400 square feet (40 square meters) and most are equipped with a balcony, separate lounge and sleeping areas, 2 TVs and 2 full bathrooms. One-Bedroom and Two-Bedroom Suites offer even more space to enjoy your visit.
                    </p>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="carousel slide" data-ride="carousel" id="suites">
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            <img alt="" class="d-block w-100 rounded" src="{{ asset('images/eu/miami/5.jpeg') }}">
                            </img>
                        </div>
                        <div class="carousel-item">
                            <img alt="" class="d-block w-100 rounded" src="{{ asset('images/eu/miami/6.png') }}">
                            </img>
                        </div>
                        <div class="carousel-item">
                            <img alt="" class="d-block w-100 rounded" src="{{ asset('images/eu/miami/7.png') }}">
                            </img>
                        </div>
                    </div>
                    <a class="carousel-control-prev" data-slide="prev" href="#suites" role="button">
                        <span aria-hidden="true" class="carousel-control-prev-icon">
                        </span>
                        <span class="sr-only">
                            Previous
                        </span>
                    </a>
                    <a class="carousel-control-next" data-slide="next" href="#suites" role="button">
                        <span aria-hidden="true" class="carousel-control-next-icon">
                        </span>
                        <span class="sr-only">
                            Next
                        </span>
                    </a>
                </div>
            </div>
        </div>
        <div class="row align-items-center">
            <div class="col-lg-6">
                <div class="carousel slide" data-ride="carousel" id="food">
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            <img alt="" class="d-block w-100 rounded" src="{{ asset('images/eu/miami/8.jpeg') }}">
                            </img>
                        </div>
                        <div class="carousel-item ">
                            <img alt="" class="d-block w-100 rounded" src="{{ asset('images/eu/miami/9.jpeg') }}">
                            </img>
                        </div>
                        <div class="carousel-item">
                            <img alt="" class="d-block w-100 rounded" src="{{ asset('images/eu/miami/10.jpeg') }}">
                            </img>
                        </div>
                    </div>
                    <a class="carousel-control-prev" data-slide="prev" href="#food" role="button">
                        <span aria-hidden="true" class="carousel-control-prev-icon">
                        </span>
                        <span class="sr-only">
                            Previous
                        </span>
                    </a>
                    <a class="carousel-control-next" data-slide="next" href="#food" role="button">
                        <span aria-hidden="true" class="carousel-control-next-icon">
                        </span>
                        <span class="sr-only">
                            Next
                        </span>
                    </a>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="about_text">
                    <h2 class="text-center">
                        Amenities
                    </h2>
                    <p class="text-justify">
                        Enjoy extensive world-class amenities included in the resort fee. Lounge next to a private beach or enjoy panoramic views of Miami Beach from the tranquility pool (adults only) and hot tubs. Dine at the Chez Gaston Restaurant where you and your family can indulge in a sumptuous breakfast buffet, grab a quick coffee or ice-cream at the Espresso Bar or relax at one of the two pool bars with a tropical drink.
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
                            <button class="btn btn-warning waves-effect waves-light btn-xs" data-id="" data-target="#modalMiami" data-toggle="modal" type="button">
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
<div aria-hidden="true" aria-labelledby="modalMiami" class="modal fade mt-4 pt-4 mb-4 pb-4" id="modalMiami" tabindex="-1">
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
                    <img class="img-fluid" id="imagen_hotel" src="{{ asset('images/eu/miami/12.jpeg') }}">
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
