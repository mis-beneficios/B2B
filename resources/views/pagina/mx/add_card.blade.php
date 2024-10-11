@extends('layouts.pagina.app')
<style>
    .breadcrumb_bg_1 {
        background-image: url("https://www.mexicodesconocido.com.mx/wp-content/uploads/2019/03/1Q.jpg");
        background-position: center;
        background-repeat: no-repeat;
        background-size: cover;
    }

    .errors {
        font-size: 12px;
    }
</style>
@section('content')
<section class="breadcrumb breadcrumb_bg_1">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="breadcrumb_iner">
                    <div class="breadcrumb_iner_item text-center">
                        <h2>
                            ¡Estamos a un solo paso de activar tu beneficio!
                        </h2>
                        {{--
                        <p class="lead">
                            Compra ahora, paga despues
                        </p>
                        --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="hotel_list mt-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 col-md-12 mb-5">
                <div class="cardt">
                    <div class="card-header">
                        <div class="d-flex pull-right">
                            <h3>
                                Información de compra
                            </h3>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="single_ihotel_list">
                            <div class="hotel_text_iner">
                                <h3 class="text-primary">
                                    {{ $estancia->title }}
                                </h3>
                                <div>
                                    {!! $estancia->descripcion !!}
                                </div>
                                {{-- <strong class="lead">
                                    Precio:
                                    <span class="text-danger">
                                        ${{ $estancia->precio }}.00
                                    </span>
                                    {{ $estancia->divisa }}
                                </strong>
                                <br/>
                                <strong class="lead">
                                    {{ $estancia->cuotas }} pagos quincenal:
                                    <span class="text-danger">
                                        ${{ $estancia->precio / $estancia->cuotas }}.00
                                    </span>
                                    {{ $estancia->divisa }}
                                </strong> --}}
                                 <strong class="lead">
                                    Precio:
                                    @if ($datos['house'] == true)
                                        {{ $datos['precio_house'] }}
                                    @else
                                    <span class="text-danger">
                                        ${{ $estancia->precio }}.00
                                    </span>
                                    @endif
                                    {{ $estancia->divisa }}
                                </strong>
                                <br/>
                                <strong class="lead">
                                    {{ $estancia->cuotas }} pagos quincenal:
                                    <span class="text-danger">
                                        @if ($datos['house'] == true)
                                            {{ number_format($datos['precio_house'] / $estancia->cuotas, 2, '.', ',') }}
                                        @else
                                            {{ number_format($estancia->precio / $estancia->cuotas,2 , '.',',') }}
                                        @endif
                                    </span>
                                    {{ $estancia->divisa }}
                                </strong>
                                <br/>
                                @if ($estancia->enganche_especial)
                                    <p>
                                        *Se realizar un gardo inicial de ${{ number_format($estancia->enganche_especial, 2) .' '.$estancia->divisa }}
                                    </p>
                                @endif
                                <p>
                                    *Los cargos seran domicialiados al metodo de pago ingresado quincenalmente.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-md-12 mb-5">
                <form action="{{ route('tienda.store') }}" id="form_card_mx" method="post">
                {{-- <form action="{{ route('tienda.token') }}" id="form_card_mx" method="post"> --}}
                    @csrf
                    <div class="cardt">
                        <div class="card-header text-center">
                            <h3>
                                Método de pago
                            </h3>
                        </div>
                        <div class="card-body" id="card_form"{{--  style="display:  {{ (count($tarjetas)>=1) ? 'none' : 'block' }}" --}}>
                            <div class="row">
                                <div class="col-md-4">
                                    <h6 class="card-title">
                                        Tarjetas de Crédito
                                    </h6>
                                    <img alt="" class="img-fluid" src="{{ asset('images/cards1.png') }}">
                                    </img>
                                </div>
                                <div class="col-md-8" style="border-left: 1px solid #ccc;">
                                    <h6 class="card-title">
                                        Tarjetas de Débito
                                    </h6>
                                    <img alt="" class="img-fluid" src="{{ asset('images/cards2.png') }}" width="">
                                    </img>
                                </div>
                            </div>
                            <hr/>
                            <input id="token_id" name="token_id" type="hidden"/>
                            <input id="device_session_id" name="device_session_id" type="hidden"/>
                            <div class="row">
                                <div class="form-group col-md-6 col-sm-12 col-xs-12">
                                    <label for="formGroupExampleInput">
                                        Titular
                                    </label>
                                    <input aria-describedby="titular" autocomplete="off" data-openpay-card="holder_name" class="form-control" id="titular" name="titular" placeholder="Titular" type="text">
                                        <small class="form-text text-muted">
                                        </small>
                                    </input>
                                    <span class="text-danger error-titular errors">
                                    </span>
                                </div>
                                <div class="form-group col-md-6 col-sm-12 col-xs-12">
                                    <label for="numero_tarjeta">
                                        Numero de tarjeta
                                    </label>
                                    <input aria-describedby="numero_tarjeta"   autocomplete="off" data-openpay-card="card_number" class="form-control" data-placement="right" data-toggle="tooltip" id="numero_tarjeta" name="numero_tarjeta" placeholder="1111222233334444" title="Tus datos estan cifrados de lado a lado" type="text">
                                        <small class="form-text text-muted">
                                        </small>
                                    </input>
                                    <span class="text-danger error-numero_tarjeta errors">
                                    </span>
                                </div>
                                <div class="col-md-6 form-group">
                                    <label for="">
                                        Fecha de vencimiento
                                    </label>
                                    <div class="row">
                                        <div class="col-lg-5 col-md-6">
                                            <input class="form-control" id="mes" name="mes"  data-openpay-card="expiration_month" placeholder="Mes" type="text">
                                            </input>
                                            <span class="text-danger error-mes errors">
                                            </span>
                                        </div>
                                        <div class="col-lg-5 col-md-6">
                                            <input class="form-control" id="anio" name="anio" data-openpay-card="expiration_year"  placeholder="Año" type="text">
                                            </input>
                                            <span class="text-danger error-anio errors">
                                            </span>
                                        </div>
                                    </div>

                                </div>
                                <div class="form-group col-md-3">
                                    <label for="formGroupExampleInput2">
                                        CVV
                                    </label>
                                    <input autocomplete="off" class="form-control" data-openpay-card="cvv2" id="cvv2" maxlength="4" name="cvv2" placeholder="CVV" type="password"/>
                                    <span class="text-danger error-cvv2 errors">
                                    </span>
                                </div>
                               {{--  <div class="col-md-4 form-group">
                                    <label for="password">
                                        Tipo de Tarjeta
                                    </label>
                                    <select class="form-control" id="tipo" name="tipo">
                                        <option value="Debito">
                                            Debido
                                        </option>
                                        <option value="Credito">
                                            Crédito
                                        </option>
                                    </select>
                                    <span class="text-danger error-tipo errors">
                                    </span>
                                </div> --}}
                            {{--     <div class="col-md-4 form-group">
                                    <label for="password">
                                        Tipo de Tarjeta
                                    </label>
                                    <select class="form-control" id="red_bancaria" name="red_bancaria">
                                        <option value="VISA">
                                            Visa
                                        </option>
                                        <option value="Master Card">
                                            Master Card
                                        </option>
                                    </select>
                                    <span class="text-danger error-tipo errors">
                                    </span>
                                </div> --}}
                               {{--  <div class="col-md-6 form-group">
                                    <label for="email">
                                        Banco
                                    </label>
                                    <select class="js-example-responsive js-states form-control" id="banco" name="banco">
                                        @foreach ($bancos as $banco)
                                        <option value="{{ $banco->id }}">
                                            {{ $banco->title }}
                                        </option>
                                        @endforeach
                                    </select>
                                    <span class="text-danger error-banco errors">
                                    </span>
                                </div> --}}
                            </div>
                        </div>
                        <div class="row ml-2">
                            <div class="col-md-6 form-group">
                                <label for="confirmar_password">
                                    Fecha de primer descuento
                                </label>
                                <input class="form-control datepicker" id="primer_descuento" autocomplete="off" name="primer_descuento" placeholder="" type="text" value="{{ date('Y-m-d') }}">
                                </input>
                                <span class="text-danger error-primer_descuento errors">
                                </span>
                            </div>
                            <div class="col-md-12 form-group form-check" style="margin-left: 12px">
                                <input class="form-check-input" id="terminos" name="terminos" type="checkbox">
                                    <label class="form-check-label" for="terminos" data-toggle="modal" data-target="#terminos_y_condiciones">
                                        Acepto términos y condiciones
                                    </label>
                                </input>
                                <br/>
                                <span class="text-danger error-terminos errors">
                                </span>
                            </div>
                            <div class="col-md-12 form-group form-check" style="margin-left: 12px">
                                <input checked="" class="form-check-input" id="ofertas" name="ofertas" type="checkbox">
                                    <label class="form-check-label" for="ofertas">
                                        Recibir ofertas de
                                        <b>
                                            Mis Beneficios Vacacionales
                                        </b>
                                    </label>
                                </input>
                            </div>
                            <div class="form-group col-md-6 mt-2 mr-1">
                                {!! NoCaptcha::renderJs() !!}
                                {!! NoCaptcha::display() !!}
                                <span class="text-danger error-g-recaptcha-response errors">
                                </span>
                            </div>
                            <div class="col-md-5 ml-4">
                                <img src="{{ asset('images/openpay.jpg') }}" alt="" class="img-fluid">
                            </div>
                            <div class="col-md-4 text-center">
                                <button class="btn btn-primary btn-block" type="submit">
                                    <i class="fa fa-credit-card">
                                    </i>
                                    Enviar
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

<div class="modal fade" id="terminos_y_condiciones" tabindex="-1" role="dialog" aria-labelledby="terminos_y_condiciones" aria-hidden="true">
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Términos y condiciones</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
         @include('pagina.mx.elementos.terminos_condiciones')
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-dark" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>
@endsection

@section('script')
<script>
    $(document).ready(function() {
        $('#primer_descuento').datepicker({
            format: "yyyy-mm-dd",
            autoUpdateInput: true,
            startDate: '-1d',
            endDate: '+2m',
            autoclose:true,
            language: 'es'
        });
        var element = document.getElementById('numero_tarjeta');
        var maskOptions = {
            mask: '0000000000000000'
        };
        var mask = IMask(element, maskOptions);
        var element2 = document.getElementById('cvv2');
        var maskOptions2 = {
            mask: '0000'
        };
        var mask = IMask(element2, maskOptions2);
        var element3 = document.getElementById('mes');
        var maskOptions3 = {
            mask: '00'
        };
        var mask = IMask(element3, maskOptions3);
        var element3 = document.getElementById('anio');
        var maskOptions3 = {
            mask: '00'
        };
        var mask = IMask(element3, maskOptions3);

        
        // OpenPay.setId('mtpcxlchkizbmwm6y1gt');
        // OpenPay.setApiKey('pk_c0b314276429433f8b8665a6eb6fa976');
        // OpenPay.setSandboxMode(false);


        OpenPay.setId('{{ env('OPENPAY_ID') }}');
        OpenPay.setApiKey('{{ env('OPENPAY_PK') }}');
        OpenPay.setSandboxMode('{{ (env('OPENPAY_PRODUCTION_MODE') == false) ? true : false }}');
        
        // //Se genera el id de dispositivo
        var deviceSessionId = OpenPay.deviceData.setup("form_card_mx", "device_session_id");


        $('#btnAddCard').click(function(event) {
            event.preventDefault();
            $('#card_form').css('display', 'block');
        });
        
        $('body').on('submit', '#form_card_mx', function(e) {
            e.preventDefault();
            $.ajax({
                type: $(this).attr('method'),
                url: $(this).attr('action'),
                data: $(this).serialize(),
                dataType: "json",
                beforeSend: function() {
                    $("#overlay").css("display", "block");
                },
                success: function(res) {
                    if (res.success == false) {
                        $("#overlay").css("display", "none");
                        pintar_errores(res.errors);  

                        grecaptcha.reset();
                    }
                    
                    if(res.token_create == true){
                        OpenPay.token.extractFormAndCreate(
                            'form_card_mx',
                             function(response){
                                var token_id = response.data.id;
                                $('#token_id').val(token_id);
                                $.ajax({
                                    url: '{{ route('tienda.create_order_checkout') }}',
                                    type: 'POST',
                                    dataType: 'json',
                                    data: $('#form_card_mx').serialize(),
                                    success:function(res){
                                        if (res.success==false) {
                                            $("#overlay").css("display", "none");
                                            if (res.error_message) {
                                                Swal.fire({
                                                    icon: 'error',
                                                    title: res.error_message,
                                                    showConfirmButton: true,
                                                });
                                                // grecaptcha.reset();
                                            }else{                                            
                                                Swal.fire({
                                                    icon: 'error',
                                                    title: 'Comprueba tu metodo de pago',
                                                    showConfirmButton: true,
                                                });
                                                // grecaptcha.reset();
                                            }
                                        }
                                        if (res.success == true) {
                                            $('#form_card_mx').trigger('reset');
                                            Swal.fire({
                                                icon: 'success',
                                                // title: '¡Pago procesado exitosamente!',
                                                title: '¡Registro exitoso!',
                                                showConfirmButton: true,
                                            });

                                            setTimeout(function() {
                                                window.location.href = res.url;
                                            }, 1000);
                                        }
                                    },
                                })
                                .fail(function(jqXHR, textStatus, errorThrown) {
                                    $("#overlay").css("display", "none");
                                    toastr['error'](errorThrown);
                                    grecaptcha.reset();
                                })
                                .always(function() {
                                     $("#overlay").css("display", "none");
                                });        
                            },
                            function(response) {
                                $("#overlay").css("display", "none");
                                // var desc = response.data.description != undefined ? response.data.description : response.message;
                                errores_openpay(response.data.error_code);
                                grecaptcha.reset();
                            }
                        );    
                    }
                }
            })
            .done(function() {
         
            })
            .fail(function() {
                $("#overlay").css("display", "none");
            })
            .always(function() {
                // $("#overlay").css("display", "none");
            });
            
            
        });

        function errores_openpay(error_code) {
            var error_message;
            switch(error_code) {
                case 1000:
                    error_message = 'Ocurrió un error interno en el servidor de Openpay';
                    break;
                // case 1001:
                //     error_message = 'El formato de la petición no es JSON, los campos no tienen el formato correcto, o la petición no tiene campos que son requeridos.';
                //     break;
                case 1002:
                    error_message = 'La llamada no esta autenticada o la autenticación es incorrecta.';
                    break;
                case 1003:
                    error_message = 'La operación no se pudo completar por que el valor de uno o más de los parámetros no es correcto.';
                    break;
                case 1004:
                    error_message = 'Un servicio necesario para el procesamiento de la transacción no se encuentra disponible.';
                    break;
                case 1005:
                    error_message = 'Uno de los recursos requeridos no existe.';
                    break;
                case 1006:
                    error_message = 'Ya existe una transacción con el mismo ID de orden.';
                    break;
                case 1007:
                    error_message = 'La transferencia de fondos entre una cuenta de banco o tarjeta y la cuenta de Openpay no fue aceptada.';
                    break;
                case 1008:
                    error_message = 'Una de las cuentas requeridas en la petición se encuentra desactivada.';
                    break;
                case 1009:
                    error_message = 'El cuerpo de la petición es demasiado grande.';
                    break;
                case 1010:
                    error_message = 'Se esta utilizando la llave pública para hacer una llamada que requiere la llave privada, o bien, se esta usando la llave privada desde JavaScript.';
                    break;
                case 1011:
                    error_message = 'Se solicita un recurso que esta marcado como eliminado.';
                    break;
                case 1012:
                    error_message = 'El monto transacción esta fuera de los limites permitidos.';
                    break;
                case 1013:
                    error_message = 'La operación no esta permitida para el recurso.';
                    break;
                case 1014:
                    error_message = 'La cuenta esta inactiva.';
                    break;
                case 1015:
                    error_message = 'No se ha obtenido respuesta de la solicitud realizada al servicio.';
                    break;
                case 1016:
                    error_message = 'El mail del comercio ya ha sido procesada.';
                    break;
                case 1017:
                    error_message = 'El gateway no se encuentra disponible en ese momento.';
                    break;
                case 1018:
                    error_message = 'El número de intentos de cargo es mayor al permitido.';
                    break;
                case 1020:
                    error_message = 'El número de dígitos decimales es inválido para esta moneda.';
                    break;
                case 1023:
                    error_message = 'Se han terminado las transacciones incluidas en tu paquete. Para contratar otro paquete contacta a soporte@openpay.mx.';
                    break;
                case 1024:
                    error_message = 'El monto de la transacción excede su límite de transacciones permitido por TPV';
                    break;
                case 1025:
                    error_message = 'Se han bloqueado las transacciones CoDi contratadas en tu plan';
                    break;
                case 2001:
                    error_message = 'La cuenta de banco con esta CLABE ya se encuentra registrada en el cliente.';
                    break;
                case 2003:
                    error_message = 'El cliente con este identificador externo (External ID) ya existe.';
                    break;
                case 2004:
                    error_message = 'El número de tarjeta es invalido.';
                    break;
                case 2005:
                    error_message = 'La fecha de expiración de la tarjeta es anterior a la fecha actual.';
                    break;
                case 2006:
                    error_message = 'El código de seguridad de la tarjeta (CVV2) no fue proporcionado.';
                    break;
                case 2007:
                    error_message = 'El número de tarjeta es de prueba, solamente puede usarse en Sandbox.';
                    break;
                case 2008:
                    error_message = 'La tarjeta no es valida para pago con puntos.';
                    break;
                case 2009:
                    error_message = 'El código de seguridad de la tarjeta (CVV2) es inválido';
                    break;
                case 2010:
                    error_message = 'Autenticación 3D Secure fallida.';
                    break;
                case 2011:
                    error_message = 'Tipo de tarjeta no soportada.';
                    break;
                case 3001:
                    error_message = 'La tarjeta fue declinada por el banco.';
                    break;
                case 3002:
                    error_message = 'La tarjeta ha expirado.';
                    break;
                case 3003:
                    error_message = 'La tarjeta no tiene fondos suficientes.';
                    break;
                // Cambiar
                case 3004:
                    error_message = 'Comprobar metodo de pago';
                    break;
                // cambiar
                case 3005:
                case 1001:
                    error_message = 'Comprobar metodo de pago';
                    // error_message = 'La tarjeta ha sido rechazada por el sistema antifraude.';
                    break;
                case 3006:
                    error_message = 'La operación no esta permitida para este cliente o esta transacción.';
                    break;
                case 3009:
                    error_message = 'La tarjeta fue reportada como perdida.';
                    break;
                case 3010:
                    error_message = 'El banco ha restringido la tarjeta.';
                    break;
                case 3011:
                    error_message = 'El banco ha solicitado que la tarjeta sea retenida. Contacte al banco.';
                    break;
                case 3012:
                    error_message = 'Se requiere solicitar al banco autorización para realizar este pago.';
                    break;
                case 3201:
                    error_message = 'Comercio no autorizado para procesar pago a meses sin intereses.';
                    break;
                case 3203:
                    error_message = 'Promoción no valida para este tipo de tarjetas.';
                    break;
                case 3204:
                    error_message = 'El monto de la transacción es menor al mínimo permitido para la promoción.';
                    break;
                case 3205:
                    error_message = 'Promoción no permitida.';
                    break;
                default :
                    error_message = 'Comprobar metodo de pago';
                    
                    break;
            }

            Swal.fire({
                icon: 'error',
                title: error_message,
                showConfirmButton: true,
            });
        }
    });


</script>
@endsection
