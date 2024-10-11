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
                                        {{ number_format($estancia->precio / $estancia->cuotas,2 , '.',',') }}
                                    </span>
                                    {{ $estancia->divisa }}
                                </strong>
                                <br/>
                                <p>
                                    *Los cargos seran domicialiados al metodo de pago ingresado quincenalmente.
                                </p>
                                <p>
                                    *Se realizara un cargo inicial de ${{ env('ENGANCHE_MX') }}.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-md-12 mb-5">
                <form action="{{ route('tienda.store_stripe') }}" id="form_card_mx" method="post" data-stripe-publishable-key="{{ env('STRIPE_KEY') }}" >
                {{-- <form action="{{ route('tienda.token') }}" id="form_card_mx" method="post"> --}}
                    @csrf
                    <div class="cardt">
                        <div class="card-header text-center">
                            <h3>
                                Método de pago Stripe
                            </h3>
                        </div>
                        <div class="card-body" id="card_form">
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
                            <div class="col-md-12 alert alert-danger" id="errors" style="display:none"></div>
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
                              <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRp0ZT67VxcpRzImW9MRQ2eVFyOeJ6cYCs8oYjU9eDGrCibuNOxJeqmx6fngxigPy4gUtg&usqp=CAU" alt="">
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
<script type="text/javascript" src="https://js.stripe.com/v2/"></script>
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


        $('body').on('submit', '#form_card_mx', function(e) {
            e.preventDefault();

            var holder_name = $('#titular').val();
            var card_number = $('#numero_tarjeta').val();   
            var cvv2        = $('#cvv2').val();
            var expirationm = $('#mes').val();
            var expirationy = $('#anio').val();


            console.log(holder_name, card_number, cvv2,  expirationm, expirationy);


            Stripe.setPublishableKey($(this).data('stripe-publishable-key'));
            Stripe.createToken({
                number: card_number,
                cvc: cvv2,
                exp_month: expirationm,
                exp_year: expirationy
            }, stripeResponseHandler); 


            // $.ajax({
            //     type: $(this).attr('method'),
            //     url: $(this).attr('action'),
            //     data: $(this).serialize(),
            //     dataType: "json",
            //     beforeSend: function() {
            //         $("#overlay").css("display", "block");
            //     },
            //     success: function(res) {
            //         if (res.success == true) {
            //             $('#form_card_mx').trigger('reset');
            //             Swal.fire({
            //                 icon: 'success',
            //                 // title: '¡Pago procesado exitosamente!',
            //                 title: '¡Registro exitoso!',
            //                 showConfirmButton: true,
            //             });

            //             setTimeout(function() {
            //                 window.location.href = res.url;
            //             }, 1000);
            //         }else{
            //             Swal.fire({
            //                 icon: 'error',
            //                 // title: '¡Pago procesado exitosamente!',
            //                 title: '¡Intentelo nuevamente!',
            //                 showConfirmButton: true,
            //             });
            //         }
            //     }
            // })
            // .done(function() {

            // })
            // .fail(function() {
            //     $("#overlay").css("display", "none");
            // })
            // .always(function() {
            //     $("#overlay").css("display", "none");
            // });

        });



        function stripeResponseHandler(status, response) {
            $("#errors").css('display', 'none');
            if (response.error) {

                errorsCard(response.error)
                $("#errors").html(response.error.message);
                $("#errors").css('display', 'block');

            } else {
                var token = response['id'];
                $('#token_id').val(token)

                $.ajax({
                    type: $('#form_card_mx').attr('method'),
                    url: $('#form_card_mx').attr('action'),
                    data: $('#form_card_mx').serialize(),
                    dataType: "json",
                    beforeSend: function() {
                        $("#overlay").css("display", "block");
                    },
                    success: function(res) {
                        $("#errors").css('display', 'none');
                        $("#overlay").css("display", "none");
                        if (res.payment == false) {
                            $("#errors").html(res.error_stripe);
                            $("#errors").css('display', 'block');
                        } else if (res.success == true && res.payment != null) {
                            window.location.href = res.url;
                        } else {
                            toastr['error']('Try later...');
                        }
                    }
                })
                .always(function() {
                    $("#overlay").css("display", "none");
                });
            }
           
        }


        function clearErrors() {
            $(document.getElementById('errors')).css("display", "none");
            $(document.getElementById("errors")).html('');
            $(document.getElementsByClassName("form-control")).removeClass('is-invalid');
        }

        function errorsCard(param) {
            switch (param.code) {
                case 'invalid_cvc':
                case 'incorrect-cvc':
                    $(document.getElementsByClassName("form-errors-cvv")).addClass('is-invalid');
                    $(document.getElementsByClassName("error-cvv")).html(param.message + ' <br/>');
                    break;
                case 'invalid_expiry_month':
                case 'invalid_expiry_year':
                    $(document.getElementsByClassName("form-errors-expiration")).addClass('is-invalid');
                    $(document.getElementsByClassName("error-expiration")).html(param.message + ' <br/>');
                    break;
                case 'incorrect_number':
                    $(document.getElementsByClassName("form-errors-numberCard")).addClass('is-invalid');
                    $(document.getElementsByClassName("error-numberCard")).html(param.message + ' <br/>');
                    break;
                default:
                    Swal.fire(
                        'Oops...',
                        param.message,
                        'error'
                    );
                    break;
            }

        }


    });
</script>
@endsection
