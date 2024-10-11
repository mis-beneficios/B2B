@extends('layouts.pagina.app')
<style>
    ol{
        font-size: 16px;
        font-style: italic;
        padding: 10px;
    }
    ol > li{
        padding-left: 10px;
    }
</style>
@section('content')
<section class="breadcrumb breadcrumb_bg" style="background-image: url(https://assets.entrepreneur.com/content/3x2/2000/20181022170837-gobierno-corporativo.jpeg);">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="breadcrumb_iner">
                    <div class="breadcrumb_iner_item text-center">
                        <h2>
                            ¿About us?
                        </h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="top_place mt-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-12">
                <div class="row">
                    <div class="col-md-6">
                        <div class="section_tittle text-center">
                            <h2>
                                About us
                            </h2>
                            <p class="text-justify">
                                {{ env('APP_NAME_EU') }} has been participating in the tourism world for over a decade, with avant-garde proposals that have defined our unique concept and have benefited thousands of people who work for the best companies.
                            </p>
                            <p class="text-justify">
                                Our mission is to offer the best vacation plans domestic or abroad, excellent hotels with the best rates in the market and all of this under a very well designed deferred payment method.  This benefit allows us to meet people’s needs for leisure, quality family time, relaxation and even a business trip with an open travel concept at a very low cost.
                            </p>
                        </div>
                    </div>
                    <div class="col-md-6 ">
                        <img alt="" class="img-fluid" src="{{ asset('images/eu/my_travel.png') }}">
                        </img>
                    </div>
                    <div class="col-md-12">
                        <p>
                            From the beginning, Optucorp’s philosophy is based on respect for people and their essence to individuality.  Our principles and goals are:
                        </p>
                        <ol class="ordered-list">
                            <li>
                                <span>
                                    To offer families our highest quality benefits, insured by a guarantee of excellence.
                                </span>
                            </li>
                            <li>
                                <span>
                                    To provide a friendly and courteous service to our customers, to satisfy their needs and exceed their expectations.
                                </span>
                            </li>
                            <li>
                                <span>
                                    To recognize the individual and collective contribution of our staff to our company.
                                </span>
                            </li>
                            <li>
                                <span>
                                    For everyone involved with the Optucorp Family to grow and succed.
                                </span>
                            </li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="top_place mt-3">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-12">
                <div class="row">
                    <div class="col-md-6">
                        <img alt="" class="img-fluid" src="{{ asset('images/eu/valores.png') }}">
                        </img>
                    </div>
                    <div class="col-md-6">
                        <div class="section_tittle">
                            <ol class="ordered-list">
                                <li class="">
                                    <span>
                                        Honesty.
                                    </span>
                                </li>
                                <li class="">
                                    <span>
                                        Respect.
                                    </span>
                                </li>
                                <li class="">
                                    <span>
                                        Confidence.
                                    </span>
                                </li>
                                <li class="">
                                    <span>
                                        Team work spirit.
                                    </span>
                                </li>
                                <li class="">
                                    <span>
                                        Efficient administration.
                                    </span>
                                </li>
                                <li class="">
                                    <span>
                                        Constant training and development of our staff.
                                    </span>
                                </li>
                                <li class="">
                                    <span>
                                        Leadership of executives achieved through direct contact with their staff.
                                    </span>
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
@section('script')
@endsection
