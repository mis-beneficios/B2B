@extends('layouts.pagina.app')
<style>
    .ftco-animate .overlay_h {
        opacity: .7; 
    }
</style>
@section('content')
<section class="breadcrumb breadcrumb_bg" style="background-image: url({{ asset('images/eu/especiales.jpg') }});">
    <div class="container">
        <div class="breadcrumb_iner">
            <div class="breadcrumb_iner_item text-center">
                <h2>
                    Exclusive Destinations
                </h2>
            </div>
        </div>
    </div>
</section>
<section class="hotel_list single_page_hotel_list mt-5">
    <div class="">
        <section class="mb-4">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-12 heading-section text-center ftco-animate">
                        <h2 class="mb-4_ text-uppercase text-info">
                            SELECT YOUR DESTINATION
                        </h2>
                    </div>
                </div>
                <div class="row justify-content-center">
                    {{-- @foreach ($destinos_exclusivos as $destino) --}}
                    <div class="col-lg-3 col-md-4 col-sm-8 ftco-animate mb-3">
                        <div class="overlay_h">
                        </div>
                        <div class="project-destination">
                            <a class="img" href="{{ route('eu.riu_palace_jamaica') }}" style="background-image: url({{ asset('images/eu/riu_jamaica/header.jpeg') }});">
                                <div class="text">
                                    <h3>
                                        Hotel Riu Palace Jamaica - Montego Bay
                                    </h3>
                                    <span class="text-uppercase">
                                        buy now
                                    </span>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-4 col-sm-8 ftco-animate mb-3">
                        <div class="project-destination">
                            <a class="img" href="{{ route('eu.riu_santa_fe') }}" style="background-image: url({{ asset('images/eu/riu_santa_fe/header.jpeg') }});">
                                <div class="text">
                                    <h3>
                                        Hotel Riu Santa Fe - Los Cabos, BCS
                                    </h3>
                                    <span class="text-uppercase">
                                        buy now
                                    </span>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-4 col-sm-8 ftco-animate mb-3">
                        <div class="project-destination">
                            <a class="img" href="{{ route('eu.riu_cancun') }}" style="background-image: url({{ asset('images/eu/riu_cancun/header.jpeg') }});">
                                <div class="text">
                                    <h3>
                                        Hotel Riu Cancún
                                    </h3>
                                    <span class="text-uppercase">
                                        buy now
                                    </span>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-4 col-sm-8 ftco-animate mb-3">
                        <div class="project-destination">
                            <a class="img" href="{{ route('eu.riu_palace_riviera') }}" style="background-image: url({{ asset('images/eu/riu_riviera/header.jpeg') }});">
                                <div class="text">
                                    <h3>
                                        Hotel Riu Palace - Riviera Maya
                                    </h3>
                                    <span class="text-uppercase">
                                        buy now
                                    </span>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-4 col-sm-8 ftco-animate mb-3">
                        <div class="project-destination">
                            <a class="img" href="{{ route('eu.puntacana') }}" style="background-image: url({{ asset('images/eu/puntacana/header.jpeg') }});">
                                <div class="text">
                                    <h3>
                                        Grand Palladium Bavaro Resort & SPA
                                    </h3>
                                    <span class="text-uppercase">
                                        buy now
                                    </span>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-4 col-sm-8 ftco-animate mb-3">
                        <div class="project-destination">
                            <a class="img" href="{{ route('eu.bahamas') }}" style="background-image: url({{ asset('images/eu/bahamas/header.jpeg') }});">
                                <div class="text">
                                    <h3>
                                        Riu Palace Paradise Island Bahamas
                                    </h3>
                                    <span class="text-uppercase">
                                        buy now
                                    </span>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-4 col-sm-8 ftco-animate mb-3">
                        <div class="project-destination">
                            <a class="img" href="{{ route('eu.hawai') }}" style="background-image: url({{ asset('images/eu/hawai/header.jpeg') }});">
                                <div class="text">
                                    <h3>
                                        Hyatt Regency Waikiki Beach Resort & SPA Hawaii
                                    </h3>
                                    <span class="text-uppercase">
                                        buy now
                                    </span>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-4 col-sm-8 ftco-animate mb-3">
                        <div class="project-destination">
                            <a class="img" href="{{ route('eu.disney_world') }}" style="background-image: url({{ asset('images/eu/disney/header.jpeg') }});">
                                <div class="text">
                                    <h3>
                                        Disney World Orlando
                                    </h3>
                                    <span class="text-uppercase">
                                        buy now
                                    </span>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-4 col-sm-8 ftco-animate mb-3">
                        <div class="project-destination">
                            <a class="img" href="{{ route('eu.miami') }}" style="background-image: url({{ asset('images/eu/miami/head_v1.jpeg') }})">
                                <div class="text">
                                    <h3>
                                        Miami, Florida
                                    </h3>
                                    <span class="text-uppercase">
                                        buy now
                                    </span>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-4 col-sm-8 ftco-animate mb-3">
                        <div class="project-destination">
                            <a class="img" href="{{ route('eu.vegasnv') }}" style="background-image: url({{ asset('images/eu/vegas/head_w1.jpeg') }});">
                                <div class="text">
                                    <h3>
                                        Las Vegas
                                    </h3>
                                    <span class="text-uppercase">
                                        buy now
                                    </span>
                                </div>
                            </a>
                        </div>
                    </div>
                    {{-- @endforeach --}}
                </div>
            </div>
        </section>
    </div>
</section>
@include('pagina.usa.elementos.modal_preregistro')
@endsection
