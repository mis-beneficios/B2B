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
<section class="breadcrumb breadcrumb_bg" style="background-image: url({{ asset('images/eu/hawai/head.webp') }});">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="breadcrumb_iner">
                    <div class="breadcrumb_iner_item text-center text-capitalize">
                        @if (session()->get('llave') && session()->get('llave') != 'mytravel')
                        <h2 class="">
                            Welcome {{ $convenio->empresa_nombre }} to
                        </h2>
                        @endif
                        <h2>
                            {{ $estancia->hotel_name }}
                            <br/>
                            {{ ($estancia->destino) ? $estancia->destino->titulo : '' }}
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
                        Steps from azure blue waters and soft sands of Waikiki Beach, Hyatt Regency Waikiki is directly across from the world famous Duke Kahanamoku Statue, near Diamond Head Crater and centrally located in a dynamic city center. Enjoy personalized services with the spirit of Aloha, modern amenities, cultural activities, swimming pool overlooking the Pacific Ocean, locally sourced dining specialties and on-site boutiques. The resort provides the perfect place for those who want to make the most of their island experience and connect with the heart of Hawaii.
                    </p>
                </div>
            </div>
        </div>
        <div class="row align-items-center">
            <div class="col-lg-6">
                <img alt="" class="img-fluid" src="{{ asset('images/eu/hawai/6.webp') }}">
                </img>
            </div>
            <div class="col-lg-6">
                <div class="about_text">
                    <h2 class="text-center">
                        Hotel
                    </h2>
                    <p class="text-justify">
                        Located in the city centre, near Diamond Head Crater and across from the Dike Kahanamoku Statue, the Hyatt Regency Waikiki offers personalized services, modern amenities, a swimming pool overlooking the Pacific ocean, and cultural activities. This resort offers the perfect place for those who want to connects with the heart of Hawaii and make the most of their island experience
                    </p>
                </div>
            </div>
        </div>
        <div class="row align-items-center">
            <div class="col-lg-6">
                <h3>
                    Restaurants & Bars
                </h3>
                <p class="text-justify">
                    Dine on culinary specials with a local flare from our expert Chefs. We source only the finest and fresh ingredients from local sources and specialty markets. If you are looking to dine in privacy, check out the  Grab & Go menu and have your meal in your room while enjoying views of Waikiki Beach or the city and Ko’olau mountain range from your own private lanai.
                </p>
            </div>
            <div class="col-lg-6">
                <div class="carousel slide" data-ride="carousel" id="carouselExampleControls">
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            <img alt="" class="d-block w-100 rounded" src="{{ asset('images/eu/hawai/13.webp') }}">
                            </img>
                        </div>
                        <div class="carousel-item">
                            <img alt="" class="d-block w-100 rounded" src="{{ asset('images/eu/hawai/2.webp') }}">
                            </img>
                        </div>
                        <div class="carousel-item">
                            <img alt="" class="d-block w-100 rounded" src="{{ asset('images/eu/hawai/3.webp') }}">
                            </img>
                        </div>
                        <div class="carousel-item">
                            <img alt="" class="d-block w-100 rounded" src="{{ asset('images/eu/hawai/5.webp') }}">
                            </img>
                        </div>
                        <div class="carousel-item">
                            <img alt="" class="d-block w-100 rounded" src="{{ asset('images/eu/hawai/6.webp') }}">
                            </img>
                        </div>
                        <div class="carousel-item">
                            <img alt="" class="d-block w-100 rounded" src="{{ asset('images/eu/hawai/7.webp') }}">
                            </img>
                        </div>
                        <div class="carousel-item">
                            <img alt="" class="d-block w-100 rounded" src="{{ asset('images/eu/hawai/8.webp') }}">
                            </img>
                        </div>
                        <div class="carousel-item">
                            <img alt="" class="d-block w-100 rounded" src="{{ asset('images/eu/hawai/9.webp') }}">
                            </img>
                        </div>
                        <div class="carousel-item">
                            <img alt="" class="d-block w-100 rounded" src="{{ asset('images/eu/hawai/10.webp') }}">
                            </img>
                        </div>
                        <div class="carousel-item">
                            <img alt="" class="d-block w-100 rounded" src="{{ asset('images/eu/hawai/11.webp') }}">
                            </img>
                        </div>
                        <div class="carousel-item">
                            <img alt="" class="d-block w-100 rounded" src="{{ asset('images/eu/hawai/12.webp') }}">
                            </img>
                        </div>
                        <div class="carousel-item">
                            <img alt="" class="d-block w-100 rounded" src="{{ asset('images/eu/hawai/13.webp') }}">
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
                <hr/>
                <div class="row text-center mb-5">
                    <div class="col-md">
                        <p class="lead text-white">
                            <i class="fas fa-car">
                            </i>
                            <br/>
                            Parking available
                        </p>
                    </div>
                    <div class="col-md">
                        <p class="lead text-white">
                            <i class="fas fa-swimmer">
                            </i>
                            <br/>
                            Pool
                        </p>
                    </div>
                    <div class="col-md">
                        <p class="lead text-white">
                            <i class="fas fa-dog">
                            </i>
                            <br/>
                            Pet Friendly
                        </p>
                    </div>
                    <div class="col-md">
                        <p class="lead text-white">
                            <i class="fas fa-spa">
                            </i>
                            <br/>
                            Spa
                        </p>
                    </div>
                    <div class="col-md">
                        <p class="lead text-white">
                            <i class="fas fa-umbrella-beach">
                            </i>
                            <br/>
                            Resort Property
                        </p>
                    </div>
                    <div class="col-md">
                        <p class="lead text-white">
                            <i class="fas fa-wind">
                            </i>
                            <br/>
                            Air Conditioning
                        </p>
                    </div>
                    <div class="col-md">
                        <p class="lead text-white">
                            <i class="fas fa-wifi">
                            </i>
                            <br/>
                            Free Wifi
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
                            <button class="btn btn-warning waves-effect waves-light btn-xs" data-id="" data-target="#modalHawai" data-toggle="modal" type="button">
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
<div aria-hidden="true" aria-labelledby="modalHawai" class="modal fade mt-4 pt-4 mb-4 pb-4" id="modalHawai" tabindex="-1">
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
                    <img class="img-fluid" id="imagen_hotel" src="{{ asset('images/eu/hawai/3.webp') }}">
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
                <h3>
                    This beautiful hotel includes:
                </h3>
                <ul class="unordered-list">
                    <li>
                        The Hotel stay is for 2 adults
                    </li>
                    <li>
                        4 & 5- star hotel options
                    </li>
                    <li>
                        Breakfast included ( when available)
                    </li>
                    <li>
                        Your rate is locked in for an entire year
                    </li>
                    <li>
                        24 Bi-weekly payments of $89.00
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
