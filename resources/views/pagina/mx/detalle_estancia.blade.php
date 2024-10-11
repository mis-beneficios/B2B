@extends('layouts.pagina.app')
<style>
    .errors {
        font-size: 12px;
    }
</style>
@section('content')
<section class="event_part">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="single_event_slider">
                    <div class="row justify-content-end">
                        <div class="col-lg-4 col-md-4">
                            <div class="event_slider_content">
                                <img alt="" class="img-fluid img-thumbnail" src="{{ asset($estancia->imagen_de_reemplazo) }}">
                                </img>
                            </div>
                        </div>
                        <div class="col-lg-7 col-md-6">
                            <div class="event_slider_content">
                                <h2>
                                    {{ $estancia->title }}
                                </h2>
                                <p>Destinos a elegir:</p>
                                <p>
                                    {!! $estancia->descripcion !!}
                                </p>
                                <p>
                                    {{ $estancia->cuotas }} pagos diferidos de: ${{ round($estancia->precio / $estancia->cuotas) }} {{ $estancia->divisa }}
                                </p>
                                <div class="rating">
                                    <span>
                                        Puntuación:
                                    </span>
                                    <div class="place_review text-warning">
                                        <i class="fas fa-star">
                                        </i>
                                        <i class="fas fa-star">
                                        </i>
                                        <i class="fas fa-star">
                                        </i>
                                        <i class="fas fa-star">
                                        </i>
                                        <i class="fas fa-star">
                                        </i>
                                    </div>
                                </div>
                                {{--
                                <a class="btn_1" href="#">
                                    Plan Details
                                </a>
                                --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="hotel_list single_page_hotel_list mb-5">
    <div class="container">
        <div class="row justify-content-start">
            @guest()
            <div class="col-xl-12" style="margin-bottom: -20px;">
                <div class="section_tittle" id="titulo">
                    <h2 class="text-center">
                        Paso 1
                    </h2>
                    <p class="text-center">
                        Datos personales
                    </p>
                </div>
            </div>
            @endguest
            <div class="col-lg-7 col-md-12">
                <form id="form_compra">
                    @csrf
                    <input name="estancia_id" type="hidden" value="{{ $estancia->id }}"/>
                    @guest()
                    <div class="row" id="form_data">
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
                        <div class="col-lg-3 col-md-4 col-sm-6 form-group">
                            <label for="cp">
                                {{ __('messages.user.show.cp') }}
                            </label>
                            <input aria-describedby="codigo_postal" class="form-control" id="cp" name="cp" onkeyup="buscar_cp()" placeholder="12345" type="text" value="">
                            </input>
                            <span class="text-danger error-cp errors">
                            </span>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="cp">
                                {{ __('messages.user.show.ciudad') }}
                            </label>
                            <input class="form-control" id="estado" name="estado" placeholder="Estado" type="text" value=""/>
                            <span class="text-danger error-estado errors">
                            </span>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="cp">
                                {{ __('messages.user.show.estado') }}
                            </label>
                            <input class="form-control" id="delegacion" name="delegacion" placeholder="Delegación" type="text" value=""/>
                            <span class="text-danger error-delegacion errors">
                            </span>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="cp">
                                Colonia
                            </label>
                            <select class="form-control" id="colonia" name="colonia">
                                <option value="0">
                                    SELECCIONA TU COLONIA
                                </option>
                            </select>
                            <span class="text-danger error-colonia errors">
                            </span>
                        </div>
                    </div>
                    <div class="row">
                         <div class="col-md-12">
                            <div class="form-group">
                                <label>
                                    Dirección
                                </label>
                                <textarea class="form-control" cols="20" id="direccion" name="direccion" placeholder="Dirección" rows="2"></textarea>
                                <span class="text-danger error-direccion errors">
                                </span>
                            </div>
                        </div>
                    </div>
                    @endguest
                    <div class="row">
                        <div class="col-md-12 text-center">
                            <button class="btn btn-primary mr-2" data-id="user_data" id="btnSiguiente" type="button">
                                Siguiente
                                <i class="fas fa-arrow-right">
                                </i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
            @guest()
            <div class="col-lg-5 col-md-12">
                <div class="row justify-content-center">
                    <div class="col-md-12 heading-section text-center ftco-animate">
                        <h4 class="mb-4_ text-uppercase text-info">
                            {{ env('APP_NAME') }}
                        </h4>
                        <p class="text-justify" id="text_card">
                            {{ env('APP_NAME') }} tiene presencia en Estados Unidos, México, España e India.
                                Estamos comprometidos con la fuerza de trabajo promoviendo el turismo nacional. Durante los
                                últimos 15 años nos hemos asociado con empresas líderes mundiales para ofrecer a sus
                                empleados un plan único de beneficios, la maravillosa oportunidad de viajar.
                        </p>
                    </div>
                    <img alt="" class="img-fluid" src="{{ asset('images/icono01.png') }}">
                    </img>
                </div>
            </div>
            @endguest
        </div>
    </div>
</section>
<div class="container-fluid">
    <hr/>
</div>
<section class="top_place section_padding">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-xl-8">
                <div class="section_tittle text-center">
                    <h2>¡No dejes pasar esta gran oportunidad y disfruta de este gran beneficio!</h2>
                </div>
            </div>
        </div>
        <div class="row">
           @foreach ($estancias as $est)
            <div class="col-lg-3 col-md-3">
                <div class="single_place">
                    <img src="{{ asset($est->imagen_de_reemplazo) }}" alt="">
                    <div class="hover_Text d-flex align-items-end justify-content-between">
                        <div class="hover_text_iner">
                            <a href="{{ route('detalle_estancia', $est->id) }}" class="place_btn">Seleccionar</a>
                            <h3>{{ $est->title }}</h3>
                            {{-- <p>Technaf, Bangladesh</p> --}}
                            <div class="place_review">
                                <a href="#"><i class="fas fa-star"></i></a>
                                <a href="#"><i class="fas fa-star"></i></a>
                                <a href="#"><i class="fas fa-star"></i></a>
                                <a href="#"><i class="fas fa-star"></i></a>
                                <a href="#"><i class="fas fa-star"></i></a>
                                {{-- <span>(210 review)</span> --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
           @endforeach
        </div>
    </div>
</section>

<!-- Modal -->
<div class="modal fade" id="modalLogin" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
  <div class="modal-dialog  modal-dialog-centered" role="document">
    <div class="modal-content container p-3">
     {{--  <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body"> --}}
            <div class="text-center">
                <img src="{{ asset('images/icono02.png') }}" class="w-50" alt="">
            </div>
            <form action="{{ route('login_custom') }}" class="form-horizontal form-material" id="loginformEst" method="post">
                @csrf
                <h3 class="box-title m-b-20 text-center">
                    {{ __('messages.login.titulo') }}
                </h3>
                @if (session('info'))
                <div class="alert alert-danger">
                    {{ session('info') }}
                </div>
                @endif
                <div class="form-group ">
                    <div class="col-xs-12">
                        <input class="form-control" id="username" name="username" onblur="this.placeholder = 'Correo electrónico'" onfocus="this.placeholder = ''" placeholder="{!! trans('messages.login.correo')!!}" required="" style="color: black;" type="email" value="{{ old('username') }}">
                        </input>
                    </div>
                    @error('username')
                    <span class="invalid-feedback" role="alert">
                        <strong>
                            {{ $message }}
                        </strong>
                    </span>
                    @enderror
                </div>
                <div class="form-group">
                    <div class="col-xs-12">
                        <input class="form-control" id="pass_hash" name="pass_hash" onblur="this.placeholder = 'Contraseña'" onfocus="this.placeholder = ''" placeholder="{!! trans('messages.login.contrasena')!!}" required="" type="password">
                        </input>
                    </div>
                    @error('pass_hash')
                    <span class="invalid-feedback" role="alert">
                        <strong>
                            {{ $message }}
                        </strong>
                    </span>
                    @enderror
                </div>
                <div class="form-group">
                    <div class="col-md-12">
                        {{--
                        <a class="text-dark pull-right" href="{{ route('password.request') }}" id="to-recover">
                            <i class="fa fa-lock m-r-5">
                            </i>
                            {{ __('messages.login.forgot_pass') }}
                        </a>
                        --}}
                        <a class="text-dark pull-right" href="{{ route('password.request') }}" id="to-recover">
                            <i class="fa fa-lock m-r-5">
                            </i>
                            {{ __('messages.login.forgot_pass') }}
                        </a>
                    </div>
                </div>
                <div class="form-group text-center m-t-20">
                    <div class="col-xs-12">
                        <button class="btn btn-info btn-sm btn-block text-uppercase waves-effect waves-light" id="btnLogin" type="submit">
                            {{ __('messages.login.submit') }}
                        </button>
                    </div>
                </div>
            </form>
      {{-- </div> --}}
    </div>
  </div>
</div>
@endsection

@section('script')
<script>
    $(document).ready(function() {
        $('body').on('click', '.btnDetalles', function(event) {
            event.preventDefault();
            var id_estancia = $('#btnDetalles').attr('value');
            $('#modalDetalles').modal('show');
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
                    console.log(res);
                    if (res.success == false) {
                        $("#overlay").css("display", "none");
                        if (res.exceptions) {
                            toastr['error'](res.exceptions);
                            toastr['error']('Intentar nuevamente mas tarde.');
                        }else{
                            pintar_errores(res.errors);
                            
                            if (res.username == true) {
                                setTimeout(function(){
                                    $('#modalLogin').modal('show');
                                    $('#loginformEst #username').val($('#username').val());
                                },800)  
                            }
                        }
                    }
                    if (res.success == true) {
                        window.location.href = res.card;
                    }
                }
            })
            .fail(function(jqXHR, textStatus, errorThrown) {
                $("#overlay").css("display", "none");
                toastr['error'](errorThrown);
                toastr['error'](jqXHR.responseJSON.message);
            })
            .always(function(){
                $("#overlay").css("display", "none");
            });
        });

        $('#loginformEst').submit(function(e) {
            e.preventDefault();
            $.ajax({
                type: $(this).attr('method'),
                url: $(this).attr('action'),
                data: $(this).serialize(),
                dataType: "json",
                beforeSend: function() {
                    $('#overlay').css('display', 'block');
                    $('#btnLogin').html('Espere...');
                },
                success: function(res) {
                    console.log(res);
                    if (res.success == false && res.user == false) {
                        toastr['error'](res.error);
                    } else if (res.success == true) {
                        location.reload();
                    }
                }
            }).always(function() {
                $('#btnLogin').html('Entrar');
                $('#overlay').css('display', 'none');
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
            beforeSend:function(){
            },
            success: function(res) {
                console.log(res);
                $('#colonia').html('');
                $("#estado").val(res.info[0].id_estado);
                $("#delegacion").val(res.info[0].id_municipio);
                if (res.colonia.length > 0) {
                    for (var i = 0; i < res.colonia.length; i++) {
                        $('#colonia').append('<option value=' + res.colonia[i].id + '>' + res.colonia[i]
                            .colonia + '</option>');
                    }
                }
            }
        })
        .always(function() {
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
