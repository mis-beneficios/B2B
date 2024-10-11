@extends('layouts.pagina.app')
<style>
    .breadcrumb_bg_1 {
        /*background-image: url("https://external-content.duckduckgo.com/iu/?u=https%3A%2F%2Fmediafiles.urlaubsguru.de%2Fwp-content%2Fuploads%2F2019%2F08%2FMiami-Beach-aerial-view-iStock_90298825_XLARGE-2.jpg&f=1&nofb=1");*/
        background-image: url("{{ asset('images/eu/header_convenio.png') }}");
        background-position: center;
        background-repeat: no-repeat;
        background-size: cover;
    }

    .breadcrumb .overlay_h {
        opacity: .3; 
    }
</style>
@section('content')
<section class="breadcrumb breadcrumb_bg_1">
    <div class="overlay_h">
    </div>
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="breadcrumb_iner">
                    <div class="breadcrumb_iner_item text-center">
                        <h2>
                            Welcome to {{ ($convenio->empresa_nombre != null) ? $convenio->empresa_nombre  :env('APP_NAME_USA') }}
                        </h2>
                        <p class="">
                            <img alt="" src="{{($convenio->img != null) ? env('STORAGE').'/img/convenios/logos/'.$convenio->img : asset('images/eu/logo.png')}}" style="height: 6em">
                            </img>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="hotel_list single_page_hotel_list mt-5">
    <div class="container">
        <section class="mb-4">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-12 heading-section text-center ftco-animate">
                        <h2 class="mb-4_ text-uppercase text-info">
                            SELECT YOUR DESTINATION
                        </h2>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-3 col-md-4 col-sm-6 ftco-animate mb-3">
                        <div class="project-destination">
                            <a class="img" href="{{ route('eu.top_productos','eu') }}" style="background-image: url({{ asset('images/eu/eu.jpg') }});">
                                <div class="text">
                                    <h3>
                                        Top in U.S.
                                    </h3>
                                    <span>
                                        Destination in U.S
                                    </span>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-4 col-sm-6 ftco-animate mb-3">
                        <div class="project-destination">
                            <a class="img" href="{{ route('eu.top_productos','europa') }}" style="background-image: url({{ asset('images/eu/europe.jpg') }});">
                                <div class="text">
                                    <h3>
                                        Top in Europe
                                    </h3>
                                    <span>
                                        Destinations in Europe
                                    </span>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-4 col-sm-6 ftco-animate mb-3">
                        <div class="project-destination">
                            <a class="img" href="{{ route('eu.top_productos','caribe') }}" style="background-image: url({{ asset('images/eu/caribe.jpg') }});">
                                <div class="text">
                                    <h3>
                                        Top in Caribbear
                                    </h3>
                                    <span>
                                        Destinations in Caribbean
                                    </span>
                                </div>
                            </a>
                        </div>
                    </div>
                    {{--
                    <div class="col-lg-3 col-md-4 col-sm-6 ftco-animate mb-3">
                        <div class="project-destination">
                            <a class="img" href="" style="background-image: url({{ asset('images/eu/crucero.jpg') }});">
                                <div class="text">
                                    <h3>
                                        Cruises
                                    </h3>
                                    <span>
                                        Cruises
                                    </span>
                                </div>
                            </a>
                        </div>
                    </div>
                    --}}
                    <div class="col-lg-3 col-md-4 col-sm-6 ftco-animate mb-3">
                        <div class="project-destination">
                            <a class="img" href="{{ route('eu.exclusivos') }}" style="background-image: url({{ asset('images/eu/riu_jamaica/header.jpeg') }});">
                                <div class="text">
                                    <h3>
                                        Top Exclusive
                                    </h3>
                                    <span>
                                        Exclusive Hotels
                                    </span>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</section>
@include('pagina.usa.elementos.modal_preregistro')
@endsection
