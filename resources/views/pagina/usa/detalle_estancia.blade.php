@extends('layouts.pagina.app')
<style>
    .errors {
        font-size: 12px;
    }

    .breadcrumb_destino{
        background-image: url({{ asset($destino->imagen_head) }});
        /*background-image: url(https://images2.alphacoders.com/526/526619.jpg);*/
        /*background-attachment: fixed;*/
        background-size: cover;
        background-repeat: no-repeat;
        background-position: center 60%;
    }

    .breadcrumb .overlay_h {
        opacity: .3;
    }
    .desc {
    color: #a2a2a2;
    font-family: "Open Sans", sans-serif;
    line-height: 17px;
    font-size: 16px;
    margin-bottom: 0px;
    font-weight: 400;
}
</style>
@section('content')
<section class="breadcrumb breadcrumb_destino">
    <div class="overlay_h">
    </div>
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="breadcrumb_iner">
                    <div class="breadcrumb_iner_item text-center">
                        <h2>
                            {{ $destino->titulo }}
                        </h2>
                        <p class="lead" style="font-size: 28px;">
                            ¡Book Now, Pay Later!
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="hotel_list section_padding" style="padding: 50px 0px;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-12">
                <div class="section_tittle text-center">
                    <h2>
                        ¡Take a look at some of our affiliated hotels at this destination!
                    </h2>
                </div>
            </div>
        </div>
        <div class="row">
            @foreach ($hoteles as $hotel)
            <div class="col-lg-4 col-sm-6">
                <div class="single_ihotel_list">
                    <img alt="" src="{{ env('STORAGE_EU').$hotel->url_img }}">
                        <div class="hotel_text_iner">
                            <h3>
                                {{ $hotel->nombre }}
                            </h3>
                            <div class="place_review">
                                <a href="#">
                                    <i class="fas fa-star">
                                    </i>
                                </a>
                                <a href="#">
                                    <i class="fas fa-star">
                                    </i>
                                </a>
                                <a href="#">
                                    <i class="fas fa-star">
                                    </i>
                                </a>
                                <a href="#">
                                    <i class="fas fa-star">
                                    </i>
                                </a>
                                <a href="#">
                                    <i class="fas fa-star">
                                    </i>
                                </a>
                            </div>
                            <p>
                                {{ $hotel->destino->titulo }}
                            </p>
                        </div>
                    </img>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
<section class="hotel_list single_page_hotel_list">
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
                        {{-- @if ($estancia->est_especial != 1) --}}
                        <div class="col-md-8">
                            <div class="radio " style="font-size: 20px; color: #000">
                                <label>
                                    <input checked="" class="paquete" id="" name="estancia_id" type="radio" value="{{ $estancia->id }}">
                                        {{ $estancia->title }}
                                        <br/>
                                        <strong>
                                            ${{ round($estancia->precio / 24) }}  Bi-Weekly
                                        </strong>
                                    </input>
                                </label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <button class="btn btn-warning waves-effect waves-light btn-xs btnDetalles" data-id="{{ $estancia->id }}" id="btnDetallesEstancia" type="button">
                                View Details
                            </button>
                        </div>
                        {{-- @endif --}}
                        @endforeach
                        <span class="text-danger error-paquete errors">
                        </span>
                    </div>
                </div>
                <div class="col-md-12 mt-2 pt-2 mb-5 pt-5">
                    <div class="text-center">
                        <button class="btn btn-primary" data-target="#modalCalendarioUsa" data-toggle="modal" id="calendarUsa" type="button">
                            Review our High & Low Season Calendar
                        </button>
                    </div>
                </div>
                @guest
                <div class="col-xl-12" style="margin-bottom: -20px;">
                    <div class="section_tittle" id="titulo">
                        <h2 class="text-center">
                            Step 2
                        </h2>
                        <p class="text-center">
                            Provide your contact information.
                        </p>
                    </div>
                </div>
                <div class="col-md-10 offset-md-1">
                    <div class="row" id="form_data">
                        <div class="col-lg-4 col-md-6 col-sm-12 form-group">
                            <label for="nombre">
                                First Name
                            </label>
                            <input aria-describedby="Nombre" class="form-control error" id="nombre" name="nombre" placeholder="First Name" type="text" value="{{ request()->session()->get('nombre') }}">
                                <span class="text-danger error-nombre errors">
                                </span>
                            </input>
                        </div>
                        <div class="col-lg-4 col-md-6 col-sm-12 form-group">
                            <label for="apellidos">
                                Last Name
                            </label>
                            <input aria-describedby="apellidos" class="form-control" id="apellidos" name="apellidos" placeholder="Last Name" type="text" value="{{ request()->session()->get('apellidos') }}">
                                <span class="text-danger error-apellidos errors">
                                </span>
                            </input>
                        </div>
                        <div class="col-md-4 form-group">
                            <label for="telefono">
                                Phone
                            </label>
                            <input aria-describedby="telefono" class="form-control" id="telefono" name="telefono" placeholder="1234567890" type="text" value="{{ request()->session()->get('telefono') }}">
                                <span class="text-danger error-telefono errors">
                                </span>
                            </input>
                        </div>
                        <div class="col-lg-4 col-md-8 form-group">
                            <label for="username">
                                Email
                            </label>
                            <input aria-describedby="username" class="form-control" id="username" name="username" placeholder="ejemplo@dominio.com" type="email" value="{{ request()->session()->get('username') }}">
                                <span class="text-danger error-username errors">
                                </span>
                            </input>
                        </div>
                        <div class="col-lg-4 col-md-6 form-group">
                            <label for="password">
                                Password
                            </label>
                            <input aria-describedby="password" class="form-control" id="password" name="password" type="password">
                                <span class="text-danger error-password errors">
                                </span>
                            </input>
                        </div>
                        <div class="col-lg-4 col-md-6 form-group">
                            <label for="confirmar_password">
                                Password Confirma
                            </label>
                            <input class="form-control" id="password_confirmation" name="password_confirmation" type="password">
                            </input>
                        </div>
                        <div class="col-md-3 form-group">
                            <label for="cp">
                                Zipcode
                            </label>
                            <input aria-describedby="cp" class="form-control" id="cp" name="cp" placeholder="12345" type="text" value="{{ request()->session()->get('cp') }}">
                                <span class="text-danger error-cp errors">
                                </span>
                            </input>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="cp">
                                City
                            </label>
                            <input class="form-control" id="ciudad" name="ciudad" placeholder="City" type="text" value=""/>
                            <span class="text-danger error-ciudad errors">
                            </span>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="cp">
                                State
                            </label>
                            <input class="form-control" id="estado" name="estado" placeholder="State" type="text" value=""/>
                            <span class="text-danger error-estado errors">
                            </span>
                        </div>
                        <div class="col-md-12 form-group">
                            <label for="direccion">
                                Adress
                            </label>
                            <input aria-describedby="direccion" class="form-control" id="direccion" name="direccion" placeholder="Adress" type="text" value="{{ request()->session()->get('direccion') }}">
                                <span class="text-danger error-direccion errors">
                                </span>
                            </input>
                        </div>
                    </div>
                </div>
                @endguest
            </div>
            <div class="row d-block justify-content-center">
                <div class="col-md-10 offset-md-1 ">
                    <button class="btn btn-primary" data-id="user_data" id="btnSiguiente" type="button">
                        Next step
                        <i class="fas fa-arrow-right">
                        </i>
                    </button>
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
<div aria-hidden="true" aria-labelledby="modalDisney" class="modal fade mt-4 pt-4 mb-4 pb-4" id="modalDetalles" tabindex="-1">
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
                <p class="desc" style="font-size:12px;">
                    You then have a full year to decide the exact date and destination of your travel.
                    We require no deposit and there are no black-out dates. My Travel Benefits locks in your discounted travel rate now. It as easy as 1,2,3!
                </p>
                <div id="bodyDesc">
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary btn-sm" data-dismiss="modal" type="button">
                    Close
                </button>
            </div>
        </div>
    </div>
</div>
<!-- Modal -->
<div aria-hidden="true" aria-labelledby="exampleModalLabel" class="modal fade mt-4 pt-4 mb-4 pb-4" id="modalCalendarioUsa" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel" style="color:black">
                    Seasons Calendar
                </h5>
                <button aria-label="Close" class="close" data-dismiss="modal" type="button">
                    <span aria-hidden="true">
                        ×
                    </span>
                </button>
            </div>
            <div class="modal-body">
                <a href="{{ asset('images/eu/calendar_eu.jpeg') }}" target="_blank">
                    <img alt="Seasons Calendar" class="img-fluid" src="{{ asset('images/eu/calendar_eu.jpeg') }}">
                    </img>
                </a>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" data-dismiss="modal" type="button">
                    Close
                </button>
            </div>
        </div>
    </div>
</div>
@endsection
@include('pagina.usa.elementos.modal_preregistro')
@section('script')
<script>
    $(document).ready(function() {
            $('body').on('click', '.btnDetalles', function(event) {
                event.preventDefault();
                var id_estancia = $(this).data('id');
                $.ajax({
                    url: baseuri + 'get-info/'+ id_estancia,
                    type: 'get',
                    dataType: 'json',
                    beforeSend:function(){
                        $("#overlay").css("display", "block");
                    },
                    success:function(res){
                        $("#overlay").css("display", "none");
                        $('#bodyDesc').html(res)
                        $('#modalDetalles').modal('show');
                    }
                })
                .always(function() {
                    $("#overlay").css("display", "none");
                });
            });


            $('body').on('click', '#btnSiguiente', function(event) {
                event.preventDefault();
                $.ajax({
                    url: baseuri + 'process-payment/create',
                    type: 'GET',
                    dataType: 'json',
                    data: $('#form_compra_eu').serialize(),
                    beforeSend: function() {
                        $("#overlay").css("display", "block");
                    },
                    success: function(res) {
                        if (res.success == false) {
                            pintar_errores(res.errors);
                        }
                        if (res.success == true) {
                            window.location.href = res.card;
                        }
                    }
                })
                .always(function() {
                    $("#overlay").css("display", "none");
                });
            });

        });
</script>
@endsection
