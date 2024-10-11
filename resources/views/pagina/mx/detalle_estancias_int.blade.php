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
                        <p class="lead text-uppercase" style="font-size: 28px;">
                            ¡Compra ahora, Paga despues!
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="hotel_list single_page_hotel_list mt-3">
    <form action="" id="form_compra" method="post">
        @csrf
        <div class="container">
            <div class="row justify-content-start">
                <div class="col-xl-12" style="margin-bottom: -20px;">
                    <div class="section_tittle" id="titulo">
                        <h2 class="text-center">
                            Paso 1
                        </h2>
                        <p class="text-center">
                            Selecciona tu estancia
                        </p>
                    </div>
                </div>
                <div class="col-md-10 offset-md-2">
                    <div class="row">
                        @foreach ($estancias as $estancia)
                        @if ($estancia->est_especial != 1)
                        <div class="col-md-8">
                            <div class="radio " style="font-size: 20px; color: #000">
                                <label>
                                    <input checked="" class="paquete" id="" name="estancia_id" type="radio" value="{{ $estancia->id }}">
                                        {{ $estancia->title }}
                                        <br/>
                                        <strong>
                                            ${{ number_format($estancia->precio / 24,2) .' '. $estancia->divisa}}   Quincenales
                                        </strong>
                                    </input>
                                </label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <button class="btn btn-warning waves-effect waves-light btn-xs btnDetalles" data-id="{{ $estancia->id }}" id="" type="button">
                                Ver Detalles
                            </button>
                        </div>
                        @endif
                        @endforeach
                        <span class="text-danger error-paquete errors">
                        </span>
                    </div>
                </div>
                @guest()
                <div class="col-xl-12 mt-5" style="margin-bottom: -20px;">
                    <div class="section_tittle" id="titulo">
                        <h2 class="text-center">
                            Paso 2
                        </h2>
                        <p class="text-center">
                            Datos personales
                        </p>
                    </div>
                </div>
                <div class="col-lg-8 col-md-10 offset-md-1 offset-lg-2">
                    <div class="row mt-1" id="form_data">
                        <div class="col-lg-4 col-md-6 form-group">
                            <label for="nombre">
                                Nombre
                            </label>
                            <input aria-describedby="Nombre" class="form-control error" id="nombre" name="nombre" placeholder="Nombre (s)" type="text" value="">
                                <span class="text-danger error-nombre errors">
                                </span>
                            </input>
                        </div>
                        <div class="col-lg-4 col-md-6 form-group">
                            <label for="apellidos">
                                Apellidos
                            </label>
                            <input aria-describedby="apellidos" class="form-control" id="apellidos" name="apellidos" placeholder="Apellido (s)" type="text" value="">
                                <span class="text-danger error-apellidos errors">
                                </span>
                            </input>
                        </div>
                        <div class="col-lg-4 col-md-6 form-group">
                            <label for="telefono">
                                Teléfono
                            </label>
                            <input aria-describedby="telefono" class="form-control" id="telefono" name="telefono" placeholder="1234567890" type="text" value="">
                                <span class="text-danger error-telefono errors">
                                </span>
                            </input>
                        </div>
                        <div class="col-lg-6 col-md-6 form-group">
                            <label for="username">
                                Correo Electrónico
                            </label>
                            <input aria-describedby="username" class="form-control" id="username" name="username" placeholder="ejemplo@dominio.com" type="email" value="">
                                <span class="text-danger error-username errors">
                                </span>
                            </input>
                        </div>
                        <div class="col-lg-6 col-md-6 form-group">
                            <label for="password">
                                Contraseña
                            </label>
                            <input aria-describedby="password" class="form-control" id="password" name="password" type="password">
                                <span class="text-danger error-password errors">
                                </span>
                            </input>
                        </div>
                        <div class="col-lg-6 col-md-6 form-group">
                            <label for="confirmar_password">
                                Confirmar Contraseña
                            </label>
                            <input class="form-control" id="password_confirmation" name="password_confirmation" type="password">
                            </input>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-3 col-md-3 form-group">
                            <label for="cp">
                                Código Postal
                            </label>
                            <input aria-describedby="cp" class="form-control" id="cp" name="cp" onkeyup="buscar_cp()" placeholder="12345" type="text" value="">
                                <span class="text-danger error-cp errors">
                                </span>
                            </input>
                        </div>
                        <div class="form-group col-md-4 ">
                            <label for="cp">
                                Estado
                            </label>
                            <input class="form-control" id="edo" name="estado" placeholder="Estado" readonly="true" type="text" value=""/>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="cp">
                                Delegación
                            </label>
                            <input class="form-control" id="deleg" name="delegacion" placeholder="Delegación" readonly="" type="text" value=""/>
                        </div>
                        <div class="form-group col-lg-6 col-md-6">
                            <label for="cp">
                                Colonia
                            </label>
                            <select class="form-control" id="col" name="colonia" required="">
                                <option value="0">
                                    SELECCIONA TU COLONIA
                                </option>
                            </select>
                            <span class="text-danger error-colonia errors">
                            </span>
                        </div>
                        <div class="col-md-12 form-group">
                            <label for="direccion">
                                Dirección
                            </label>
                            <textarea aria-describedby="direccion" class="form-control" id="direccion" name="direccion" placeholder="Dirección">
                            </textarea>
                            <span class="text-danger error-direccion errors">
                            </span>
                        </div>
                    </div>
                </div>
                @endguest
                <div class="col-md-8 offset-lg-2 offset-md-2 offset-sm-0 mb-5">
                    <button class="btn btn-primary" data-id="user_data" id="btnSiguiente" type="button">
                        Siguiente
                        <i class="fas fa-arrow-right">
                        </i>
                    </button>
                </div>
            </div>
        </div>
    </form>
</section>
<div aria-hidden="true" aria-labelledby="modalDetalles" class="modal fade mt-4 pt-4 mb-4 pb-4" id="modalDetalles" tabindex="-1">
    <div class="modal-dialog ">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="estancia_titulo" style="color: black">
                    Detalles de la estancia
                </h5>
                <button aria-label="Close" class="close" data-dismiss="modal" type="button">
                    <span aria-hidden="true">
                        ×
                    </span>
                </button>
            </div>
            <div class="modal-body" id="modal_content">
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary btn-sm" data-dismiss="modal" type="button">
                    Cerrar
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
@include('pagina.mx.elementos.modal_preregistro')
@section('script')
<script>
    $(document).ready(function() {
        $('body').on('click', '.btnDetalles', function(event) {
            event.preventDefault();
            var id_estancia = $(this).data('id');
            $.ajax({
                url: baseuri + 'estancia-detalles/' + id_estancia,
                type: 'GET',
                dataType: 'json',
                beforeSend: function() {
                    $("#overlay").css("display", "block");
                },
                success: function(res) {
                    if (res.success == true) {
                        $('#modalDetalles #estancia_titulo').html('Detalles: ' + res.estancia.title);
                        $('#modalDetalles #modal_content').html(res.estancia.descripcion);
                        $('#modalDetalles').modal('show');
                    }else {
                        toastr['error']('Intentar nuevamente mas tarde.');
                    }
                },
            }).always(function(){
                $("#overlay").css("display", "none");
            });
        });

        $('body').on('click', '#btnSiguiente', function(event) {
            event.preventDefault();
            $.ajax({
                url: baseuri + 'tienda/create',
                type: 'GET',
                dataType: 'json',
                data: $('#form_compra').serialize(),
                beforeSend: function() {
                    $("#overlay").css("display", "block");
                },
                success: function(res) {
                    if (res.success == false) {
                        if (res.catch == true) {
                            toastr['error']('Intentar nuevamente mas tarde.');
                        }else{
                            pintar_errores(res.errors);
                        }
                    }
                    if (res.success == true) {
                        window.location.href = res.card;
                    }
                }
            })
            .always(function(){
                $("#overlay").css("display", "none");
            });
        });


        $(document).on('click', '#btnRegistrar', function(event) {
            event.preventDefault();
            $.ajax({
                url: baseuri + 'tienda',
                type: 'POST',
                dataType: 'json',
                data: $('#form_compra').serialize(),
                success: function(res) {
                    if (res.success == false) {
                        pintar_errores(res.errors);
                    }
                }
            });
        });
    });


    function buscar_cp(cp) {
        var cp = $("#cp").val();
        if (cp.length < 5) return 0;
        $.ajax({
            url: baseuri + 'cp/' + cp,
            type: 'GET',
            dataType: 'json',
            success: function(res) {
                $('#col').html('');
                $("#edo").val(res.info[0].id_estado);
                $("#deleg").val(res.info[0].id_municipio);
                if (res.colonia.length > 0) {
                    for (var i = 0; i < res.colonia.length; i++) {
                        $('#col').append('<option value=' + res.colonia[i].id + '>' + res.colonia[i]
                            .colonia + '</option>');
                    }
                }
            }
        });
    }

    function pintar_errores(errores = null) {
        $(".errors").html('');
        $(".errors").parent().removeClass('has-error');
        $.each(errores, function(k, v) {
            $(".error-" + k).html(v + ' <br/>');
            $(".error-" + k).parent().addClass('has-error');
        });
    }
</script>
@endsection
