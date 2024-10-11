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
                                    @if ($estancia->temporada == 'house')
                                    <p>
                                        <i class="fas fa-home"></i> Habitaciones: <b>8</b>
                                    </p>
                                    <p>
                                        <i class="fa fa-shower"></i> Baños: <b>5</b>
                                    </p>
                                    <p>
                                        <i class="fas fa-user"></i> Maximo de personas: <b>16</b>
                                    </p>
                                    <p>
                                        <img src="https://img.freepik.com/iconos-gratis/cama_318-731363.jpg" alt="" style="width: 18px;">
                                        Cama King: <b>1</b>
                                    </p>
                                    <p>
                                        <img src="https://img.freepik.com/iconos-gratis/cama_318-731363.jpg" alt="" style="width: 18px;">
                                        Cama Queen: <b>4</b>
                                    </p>
                                    <p>
                                        <img src="https://cdn.icon-icons.com/icons2/1391/PNG/512/moon_96308.png" alt="" style="width: 18px;">
                                        Noches: <b>{{ $datos['noches'] }}</b>
                                    </p>
                                        
                                    </p>
                                    @else
                                    {!! $estancia->descripcion !!}
                                    @endif
                                </div>
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
                                <p>
                                    *Los cargos seran domicialiados al metodo de pago ingresado quincenalmente.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-md-12 mb-5">
                <form action="{{ route('tienda.store_offline') }}" id="form_card_mx" method="post">
                {{-- <form action="{{ route('tienda.token') }}" id="form_card_mx" method="post"> --}}
                    @csrf
                    <div class="cardt">
                        <div class="card-header text-center">
                            <h3>
                                Método de pago Offline
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
                                    <input aria-describedby="titular" required autocomplete="off" data-openpay-card="holder_name" class="form-control" id="titular" name="titular" placeholder="Titular" type="text">
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
                                    <input aria-describedby="numero_tarjeta"  required autocomplete="off" data-openpay-card="card_number" class="form-control" data-placement="right" data-toggle="tooltip" id="numero_tarjeta" name="numero_tarjeta" placeholder="1111222233334444" title="Tus datos estan cifrados de lado a lado" type="text">
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
                                            <input class="form-control" required  id="mes" name="mes"  data-openpay-card="expiration_month" placeholder="Mes" type="text">
                                            </input>
                                            <span class="text-danger error-mes errors">
                                            </span>
                                        </div>
                                        <div class="col-lg-5 col-md-6">
                                            <input class="form-control" required id="anio" name="anio" data-openpay-card="expiration_year"  placeholder="Año" type="text">
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
                                    <input autocomplete="off" required class="form-control" data-openpay-card="cvv2" id="cvv2" maxlength="4" name="cvv2" placeholder="CVV" type="password"/>
                                    <span class="text-danger error-cvv2 errors">
                                    </span>
                                </div>
                                <div class="col-md-4 form-group">
                                    <label for="password">
                                        Tipo de Tarjeta
                                    </label>
                                    <select class="form-control" required id="tipo" name="tipo">
                                        <option value="Debito">
                                            Debido
                                        </option>
                                        <option value="Credito">
                                            Crédito
                                        </option>
                                    </select>
                                    <span class="text-danger error-tipo errors">
                                    </span>
                                </div>
                                <div class="col-md-6 form-group">
                                    <label for="email">
                                        Banco
                                    </label>
                                    <select class="js-example-responsive js-states form-control select2" required id="banco" name="banco">
                                        @foreach ($bancos as $banco)
                                        <option value="{{ $banco->id }}">
                                            {{ $banco->title }}
                                        </option>
                                        @endforeach
                                    </select>
                                    <span class="text-danger error-banco errors">
                                    </span>
                                </div>
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
                                    <label class="form-check-label" for="terminos">
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
                                {{-- <ul class="list-unstyled">
                                    <li> --}}
                                        <img src="{{ asset('images/openpay.png') }}" alt="" class="img-fluid">
                                    {{-- </li>
                                    <li> --}}
                                        <img src="{{ asset('images/ssl.png') }}" alt="" style="width:60%">
                                    {{--< /li>
                                </ul> --}}
                            </div>
                            <div class="col-md-4 text-center">
                                {{-- {!! NoCaptcha::displaySubmit('Enviar', ['class' => 'btn btn-primary btn-block'])!!} --}}
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


        // OpenPay.setId('modxyexhb47fzvs6bgsp');
        // OpenPay.setApiKey('pk_ff1039300ae74e84af8ace9eef0de0ba');
        // OpenPay.setSandboxMode(true);

        // // //Se genera el id de dispositivo
        // var deviceSessionId = OpenPay.deviceData.setup("form_card_mx", "device_session_id");


        // $('#btnAddCard').click(function(event) {
        //     event.preventDefault();
        //     $('#card_form').css('display', 'block');
        // });

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
                    }else{
                        Swal.fire({
                            icon: 'error',
                            // title: '¡Pago procesado exitosamente!',
                            title: '¡Intentelo nuevamente!',
                            showConfirmButton: true,
                        });
                    }



                    // if (res.success == false) {
                    //     $("#overlay").css("display", "none");
                    //     pintar_errores(res.errors);
                    // }


                    // if(res.token_create == true){
                    //     OpenPay.token.extractFormAndCreate(
                    //         'form_card_mx',
                    //          function(response){
                    //             var token_id = response.data.id;
                    //             $('#token_id').val(token_id);
                    //             $.ajax({
                    //                 url: '{{ route('tienda.create_order_checkout') }}',
                    //                 type: 'POST',
                    //                 dataType: 'json',
                    //                 data: $('#form_card_mx').serialize(),
                    //                 success:function(res){
                    //                     if (res.success==false) {
                    //                         $("#overlay").css("display", "none");
                    //                         if (res.error_message) {
                    //                             Swal.fire({
                    //                                 icon: 'error',
                    //                                 title: res.error_message,
                    //                                 showConfirmButton: true,
                    //                             });

                    //                         }else{
                    //                             Swal.fire({
                    //                                 icon: 'error',
                    //                                 title: 'Comprueba tu metodo de pago',
                    //                                 showConfirmButton: true,
                    //                             });
                    //                         }
                    //                     }
                    //                     if (res.success == true) {
                    //                         $('#form_card_mx').trigger('reset');
                    //                         Swal.fire({
                    //                             icon: 'success',
                    //                             // title: '¡Pago procesado exitosamente!',
                    //                             title: '¡Registro exitoso!',
                    //                             showConfirmButton: true,
                    //                         });

                    //                         setTimeout(function() {
                    //                             window.location.href = res.url;
                    //                         }, 1000);
                    //                     }
                    //                 },
                    //             })
                    //             .fail(function(jqXHR, textStatus, errorThrown) {
                    //                 $("#overlay").css("display", "none");
                    //                 toastr['error'](errorThrown);
                    //             })
                    //             .always(function() {
                    //                  $("#overlay").css("display", "none");
                    //             });
                    //         },
                    //         function(response) {
                    //             $("#overlay").css("display", "none");
                    //             // var desc = response.data.description != undefined ? response.data.description : response.message;
                    //         }
                    //     );
                    // }
                }
            })
            .done(function() {

            })
            .fail(function() {
                $("#overlay").css("display", "none");
            })
            .always(function() {
                $("#overlay").css("display", "none");
            });


        });
    });


</script>
@endsection
