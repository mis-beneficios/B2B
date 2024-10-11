@extends('layouts.pagina.app')
@section('content')
<section class="breadcrumb breadcrumb_bg" style="background-image: url({{ asset('images/sorteo_head.jpg') }})">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="breadcrumb_iner">
                    <div class="breadcrumb_iner_item text-center">
                        @if (date('Y-m-d') >= $sorteo->fecha_inicio && date('Y-m-d') <= $sorteo->fecha_fin && $sorteo->flag == 0)
                        <h2 style="font-family: 'Koulen';">
                            Sorteo exclusivo para colaboradores de
                            <strong>
                                {{ $convenio->empresa_nombre }}
                            </strong>
                        </h2>
                        @else
                        <h2>
                            Este sorteo no se encuentra disponible.
                        </h2>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
{{-- @if (($sorteo->fecha_inicio >= date('Y-m-d') )|| ($sorteo->fecha_fin <= date('Y-m-d'))) --}}
@if (date('Y-m-d') >= $sorteo->fecha_inicio && date('Y-m-d') <= $sorteo->fecha_fin && $sorteo->flag == 0)
<section class="hotel_list single_page_hotel_list mt-5">
    <div class="container">
        <div class="row justify-content-start">
            <div class="col-xl-12">
                <div class="section_tittle">
                    <h2 class="text-center">
                        @if (!empty($sorteo->cuerpo_correo))
                            {{ $sorteo->cuerpo_correo }}
                        @else
                        ¡¡Participa y Gana!!
                        @endif
                    </h2>
                </div>
            </div>
        </div>
        <div class="row mb-4" id="show_form" style="">
            <div class="col-md-6">
                <form action="{{ route('sorteo-convenio.store') }}" id="form_sorteo" method="post">
                    @csrf
                    <input name="empresa_nombre" type="hidden" value="{{ $convenio->empresa_nombre }}"/>
                    <input type="hidden" value="{{ $sorteo->especial ?? '0' }}" name="sorteo_especial">
                    <input type="hidden" value="{{ $sorteo->id }}" name="sorteo_id">
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="nombre">
                                Nombre
                            </label>
                            <input class="form-control" id="nombre" name="nombre" placeholder="Nombre (s)" type="text">
                            </input>
                            <span class="text-danger error-nombre errors">
                            </span>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="apellidos">
                                Apellido (s)
                            </label>
                            <input class="form-control" id="apellidos" name="apellidos" placeholder="Apellido (s)" type="text">
                            </input>
                            <span class="text-danger error-apellidos errors">
                            </span>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="inputAddress">
                                Correo electrónico
                            </label>
                            <input class="form-control" id="email" name="email" placeholder="ejemplo@mail.com" type="mail">
                            </input>
                            <span class="text-danger error-email errors">
                            </span>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="telefono_celular">
                                Teléfono
                            </label>
                            <input class="form-control" id="telefono_celular" name="telefono_celular" placeholder="" type="text">
                            </input>
                            <span class="text-danger error-telefono_celular errors">
                            </span>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="telefono_casa">
                                Teléfono de oficina o casa
                            </label>
                            <input class="form-control" id="telefono_casa" name="telefono_casa" type="text">
                                <span class="text-danger error-telefono_casa errors">
                                </span>
                            </input>
                        </div>
                        {{--
                        <div class="form-group col-md-4">
                            <label for="telefono_casa">
                                Numero de empleado
                            </label>
                            <input class="form-control" id="numero_empleado" name="numero_empleado" type="text">
                            </input>
                            <span class="text-danger error-numero_empleado errors">
                            </span>
                        </div>
                        --}}
                    </div>
                    @if ($sorteo->especial == 1)
                    <hr/>
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="nom_empresa">
                                Empresa
                            </label>
                            <input class="form-control" id="nom_empresa" name="nom_empresa" type="text">
                            </input>
                            <span class="text-danger error-nom_empresa errors">
                            </span>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="sucursal">
                                Sucursal
                            </label>
                            <input class="form-control" id="sucursal" name="sucursal" placeholder="" type="text">
                            </input>
                            <span class="text-danger error-sucursal errors">
                            </span>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="num_empleado">
                                Numero de empleado
                            </label>
                            <input class="form-control" id="numero_empleado" name="numero_empleado" type="text">
                                <span class="text-danger error-numero_empleado errors">
                                </span>
                            </input>
                        </div>
                    </div>
                   @endif
                    <div class="form-group">
                        <div class="form-check">
                            <input class="form-check-input" id="terminos_y_condiciones" name="terminos_y_condiciones" type="checkbox" value="1">
                                <label class="form-check-label" for="terminos_y_condiciones">
                                    Acepto términos y condiciones
                                </label>
                            </input>
                        </div>
                        <span class="text-danger error-terminos_y_condiciones errors">
                        </span>
                    </div>
                    <div class="form-group form-check">
                        <input checked="" class="form-check-input" id="publicidad_item" name="publicidad" type="checkbox" value="1">
                            <label class="form-check-label" for="publicidad_item">
                                Recibir ofertas y noticias de
                                <a href="http://beneficiosvacacionales.mx/" target="_blank">
                                    Beneficios Vacacionales
                                </a>
                            </label>
                        </input>
                        <span class="text-danger error-publicidad errors">
                        </span>
                    </div>
                    <div class="form-group col-md-12 mt-2">
                        {!! NoCaptcha::renderJs() !!}
                        {!! NoCaptcha::display() !!}
                        <span class="text-danger error-g-recaptcha-response errors">
                        </span>
                    </div>
                    <button class="btn btn-primary" type="submit">
                        Enviar
                    </button>
                </form>
            </div>
            <div class="col-md-6">
                <img alt="" class="img-fluid" src="{{ (!empty($sorteo->img_final)) ? asset($sorteo->img_final) : asset('images/sorteo_1.jpeg') }}">
                </img>
            </div>
        </div>
        <div id="show_finish" style="display:none">
            <div class="text-center">
                <h1 class="text-center" style=" font-size: 48px;">
                    Beneficios Vacacionales agradece tu participación en nuestro sorteo
                </h1>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <h2 class="lead mt-1 pt-1">
                    </h2>
                    <h3 style=" text-align: center; color: #00add8; margin-top: 40px;">
                        <strong>
                            Recuerda conservar tu número de participante.
                        </strong>
                    </h3>
                    {{--
                    <h3 style=" text-align: center; color: #00add8; margin-top: 5px;">
                        <strong>
                            de participante al sorteo de los viajes:
                        </strong>
                    </h3>
                    --}}
                    <p class="text-center" style="margin-top: 50px; font-size: 65px; color: #000; font-family: Righteous;">
                        N°
                        <strong id="num_folio">
                        </strong>
                    </p>
                </div>
                <div class="col-md-6 text-center">
                    <img alt="" src="{{ asset('images/trofeo.png') }}" style="height: 22em;">
                    </img>
                    <p class="mt-4">
                        <strong>
                            El GANADOR se anunciará a través de la pagina
                            <a href="https://www.beneficiosvacacionales.mx" style="color: #00add8;" target="_blank">
                                <strong>
                                    www.beneficiosvacacionales.mx
                                </strong>
                            </a>
                        </strong>
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>
@endif
@endsection

@section('script')
<script>
    $(document).ready(function() {

       $('#form_sorteo').submit(function(event){
            event.preventDefault();

            $.ajax({
                url: $(this).attr('action'),
                type: $(this).attr('method'),
                dataType: 'JSON',
                data: $(this).serialize(),
                beforeSend:function(){
                    $('#overlay').css('display', 'block');
                },
                success:function(res){
                    if (res.success != true) {
                        pintar_errores(res.errors);
                        grecaptcha.reset();
                    }else{
                        // console.log(res.sorteo);
                        
                        Swal.fire(
                          'Registro exitoso',
                          '¡Suerte!',
                          'success'
                        )
                        setTimeout(function(){
                            $('#show_form').css('display', 'none');
                            $('#show_finish').css('display', 'block');
                            $('#num_folio').html(res.sorteo.id);
                        }, 2000);
                    }

                }
            })
            .always(function() {
                $('#overlay').css('display', 'none');
            });
            
       });
   });
</script>
@endsection
