@extends('layouts.admin.app')
@section('content')
    <style>
        button>.infoPago {
            display: none;
        }

        #btnPago:hover {
            /*background-color: #F75F1C;*/
        }

        #btnPago:hover>.infoPago {
            display: block;
        }

        .mytooltip:hover {
            position: relative;
        }

        .tooltip-text {
            font-size: 14px;
            line-height: 24px;
            display: block;
            padding: 1.31em 1.21em 1.21em 3em;
            color: #ffffff;
        }

        .btn {
            margin: 3px;
        }

        .btnsmall {
            padding: 0.15rem 0.2rem;
            font-size: 10px;
        }
    </style>
    <div class="row page-titles">
        <div class="col-md-5 col-8 align-self-center">
            <h3 class="text-themecolor text-capitalize">
                Terminal
            </h3>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('dashboard') }}">
                        Home
                    </a>
                </li>
                <li class="breadcrumb-item active">
                    Cobranza
                </li>
            </ol>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="card-actions">
                        @if (Auth::user()->can('show_cards', App\Tarjeta::class))
                            @if (!session('unlock_cards'))
                                <button class="btn btn-dark btn-sm" data-target="#modalDesCard" data-toggle="modal"
                                    style="color: white;">
                                    <i class="fas fa-unlock-alt">
                                    </i>
                                    Desbloquear tarjetas
                                </button>
                            @endif
                        @endif
                    </div>
                    <h4 class="card-title m-b-0">
                        Filtrado Terminal V2.1
                    </h4>
                </div>
                <div class="card-body">
                    <form action="" id="formTerminal" method="post">
                        @csrf
                        <div class="row">
                            <div class="col-md-4">
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label for="inputEmail4">
                                            Inicio del rango
                                        </label>
                                        <input autocomplete="off" class="form-control datepicker" id="fecha_inicio"
                                            name="fecha_inicio" type="text" value="{{ date('Y-m-d') }}">
                                        <span class="text-danger error-titular errors">
                                        </span>
                                        </input>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="inputPassword4">
                                            Fin del rango
                                        </label>
                                        <input autocomplete="off" class="form-control datepicker" id="fecha_fin"
                                            name="fecha_fin" type="text" value="{{ date('Y-m-d') }}">
                                        <span class="text-danger error-numero_tarjeta errors">
                                        </span>
                                        </input>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <h5 class="card-title mb-2 mt-2">
                                    Método de compra:
                                </h5>
                                <div class="btn-group" data-toggle="buttons">
                                    <label class="btn btn-inverse btn-sm ">
                                        <input name="nomina" id="nomina" type="checkbox">
                                        Nomina
                                        </input>
                                    </label>
                                    <label class="btn btn-inverse btn-sm">
                                        <input name="terminal" id="terminal" type="checkbox">
                                        Terminal
                                        </input>
                                    </label>
                                    <label class="btn btn-inverse btn-sm ">
                                        <input name="viaserfin" id="viaserfin" type="checkbox">
                                        Via Serfin
                                        </input>
                                    </label>
                                    <label class="btn btn-inverse btn-sm ">
                                        <input name="cobro_int" id="cobro_int" type="checkbox">
                                        Cobro Int
                                        </input>
                                    </label>
                                </div>
                                <h5 class="card-title mb-2 mt-2">
                                    Estatus de pago:
                                </h5>
                                <div class="btn-group" data-toggle="buttons">
                                    <label class="btn btn-inverse btn-sm active ">
                                        <input checked="" name="pagosRechazados" id="pagosRechazados" type="checkbox">
                                        Rechazados
                                        </input>
                                    </label>
                                    <label class="btn btn-inverse btn-sm active">
                                        <input checked="" name="pagosPagados" id="pagosPagados" type="checkbox">
                                        Pagados
                                        </input>
                                    </label>
                                    <label class="btn btn-inverse btn-sm active ">
                                        <input checked="" name="pagosPendientes" id="pagosPendientes" type="checkbox">
                                        Pendientes
                                        </input>
                                    </label>
                                    <label class="btn btn-inverse btn-sm active ">
                                        <input checked="" name="pagosAnomalías" id="pagosAnomalías" type="checkbox">
                                        Anomalías
                                        </input>
                                    </label>
                                </div>
                                <h5 class="card-title mb-2 mt-2">
                                    Tipo de tarjeta:
                                </h5>
                                <select name="tipo_tarjeta" id="tipo_tarjeta"
                                    class="form-control select2 select2-hidden-accessible m-b-10" style="width: 100%">
                                    <option value="">Sin segmentar</option>
                                    <option value="Credito">Credito</option>
                                    <option value="Debito">Debito</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <h5 class="card-title mb-2 mt-2">
                                    Pais
                                </h5>
                                <select name="paise_id" id="paise_id"
                                    class="form-control select2 select2-hidden-accessible m-b-10" style="width: 100%">
                                    <option value="">Sin fintro</option>
                                    @foreach ($paises as $pais)
                                        <option value="{{ $pais->id }}" {{ $pais->id == 1 ? 'selected' : '' }}>
                                            {{ $pais->title }}</option>
                                    @endforeach
                                </select>
                                <h5 class="card-title mb-2 mt-2">
                                    Convenio
                                </h5>
                                <select name="convenio_id[]" multiple="multiple" id="convenio_id"
                                    class="form-control select2 select2-hidden-accessible" style="width: 98%;">
                                    <option value="">Sin fintro</option>
                                    @foreach ($convenios as $convenio)
                                        <option value="{{ $convenio->id }}"> {{ $convenio->empresa_nombre }}</option>
                                    @endforeach
                                </select>

                            </div>
                        </div>
                        <div class="row ml-auto">
                            <div class="float-right">
                                <button class="btn btn-dark btn-sm" type="submit" id="btnFiltrar">
                                    Filtrar
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    Resultados
                </div>
                <div class="card-body table-responsive">
                    <table class="table table-hover dataTable no-footer" id="tableTerminal"
                        style="width: 100%; display: table; table-layout: auto;">
                        <thead>
                            <tr>
                                {{-- aria-controls="" aria-label="" class="sorting" colspan="1" rowspan="1" tabindex="0" --}}
                                <th>
                                    Segmento
                                    <br />
                                    <small>
                                        # Pago
                                    </small>
                                </th>
                                <th>
                                    # Contrato
                                    <br />
                                    <small>
                                        Clave Serfin
                                    </small>
                                </th>
                                <th class="col-5">
                                    Cliente
                                    <br />
                                    <small>
                                        Convenio
                                    </small>
                                </th>
                                <th>
                                    Cantidad
                                    <br />
                                    <small>
                                        Cantidad total
                                    </small>
                                </th>
                                <th>
                                    Estatus
                                    <br />
                                    <small>
                                        Motivo del rechazo
                                    </small>
                                </th>
                                <th class="col-2">
                                    Tarjeta
                                    <br />
                                    <small>
                                        Banco
                                    </small>
                                </th>
                                <th>
                                    F. programada
                                    <br />
                                    <small>
                                        Fecha cobro exitoso
                                    </small>
                                </th>
                                <th>
                                    Acciones
                                    <br />
                                    <small>
                                        Avance de pagos
                                    </small>
                                </th>
                                {{-- <th>
                                Segmentos
                            </th> --}}
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div aria-hidden="true" aria-labelledby="exampleModalLabel" class="modal fade" id="modalDesCard" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">
                        Desbloquear tarjetas
                    </h5>
                    <button aria-label="Close" class="close" data-dismiss="modal" type="button">
                        <span aria-hidden="true">
                            ×
                        </span>
                    </button>
                </div>
                <form action="{{ route('unlocked') }}" id="formUnlock" method="post">
                    @csrf
                    <div class="modal-body">
                        <small>
                            Para desbloquear las tarjetas ingrese la contraseña.
                        </small>
                        <input class="form-control" id="unlock" name="unlock" type="password">
                        </input>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary btn-sm" data-dismiss="modal" type="button">
                            Cerrar
                        </button>
                        <button class="btn btn-primary btn-sm" type="submit">
                            Desbloquear
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection


@section('script')
    <script>
        $(document).ready(function() {
            $('.custom-select').select2();
            var tabla_pagos;

            $(document).on('submit', '#formTerminal', function(event) {
                event.preventDefault();
                pintar_segmentos($(this).serialize());
            });

            $('.datepicker').bootstrapMaterialDatePicker({
                weekStart: 0,
                time: false,
                lang: 'es',
            });

            $('#cobro_int').on('change', function(event) {
                event.preventDefault();
                if ($(this).is(':checked')) {

                    Toast.fire({
                        icon: 'info',
                        title: 'Solo se filtraran folios cobrados con divisa USD, no se podra realizar filtrado mediante los metodos de compra',
                    });
                    $('#nomina').attr('disabled', true);
                    $('#terminal').attr('disabled', true);
                    $('#viaserfin').attr('disabled', true);
                } else {
                    Toast.fire({
                        icon: 'info',
                        title: 'Ahora puede filtrar por metodo de compra',
                    });
                    $('#nomina').removeAttr('disabled');
                    $('#terminal').removeAttr('disabled');
                    $('#viaserfin').removeAttr('disabled');

                }
            });

            // $('body #fecha_de_cobro').datepicker({
            //     dateFormat: "yy-mm-dd",
            //     autoclose:true,
            //     language: 'es',
            //     orientation: 'bottom',
            // });
            // $('body #fecha_de_pago').datepicker({
            //     dateFormat: "yy-mm-dd",
            //     autoclose:true,
            //     language: 'es',
            //     orientation: 'bottom',
            // });

            $('body').on('submit', '#formUnlock', function(event) {
                event.preventDefault();
                $.ajax({
                        url: $(this).attr('action'),
                        type: $(this).attr('method'),
                        dataType: 'json',
                        data: $(this).serialize(),
                        beforeSend: function() {
                            $("#overlay").css("display", "block");
                        },
                        success: function(res) {
                            if (res.success == true) {
                                toastr['info'](
                                    'Tarjetas desbloqueadas, los datos se mostraran hasta que se finalice la sesion'
                                    );
                                window.location.reload();
                            } else {
                                toastr['error']('Contraseña incorrecta');
                            }
                        }
                    })
                    .always(function() {
                        $("#overlay").css("display", "none");
                    });
            });

            $('body').on('click', '#btnPago', function(event) {
                event.preventDefault();
                $.ajax({
                        url: "{{ route('cobranza.validar_pago') }}",
                        type: 'GET',
                        dataType: 'json',
                        data: {
                            pago_id: $(this).data('pago_id'),
                            contrato_id: $(this).data('contrato_id'),
                            user_id: $(this).data('user_id')
                        },
                        beforeSend: function() {
                            $("#overlay").css("display", "block");
                        },
                        success: function(res) {
                            $('#modalGeneral #modalGeneralLabel').html('Pago');
                            $('#modalGeneral #modal-body').html(res.view);
                            $('#modalGeneral').modal('show');
                        }
                    })
                    .always(function() {
                        $("#overlay").css("display", "none");
                    });
            });


            $('body').on('submit', '#form_validar_pago', function(event) {
                event.preventDefault();

            });


            $('body').on('click', '.btnCambiarEstatus', function(event) {
                event.preventDefault();
                var action = $(this).data('action');
                var pago_id = $(this).data('pago_id');
                var estatus = $(this).data('estatus');
                var tarjeta_id = $(this).data('tarjeta_id');

                if (action == 'autorizar') {
                    if (estatus != 'Pagado') {
                        alertify.confirm('Autorizar pago', '¿Desea autorizar el pago: ' + pago_id,
                            function() {
                                autorizar_pago(pago_id, tabla_pagos);
                            },
                            function() {
                                toastr['warning']('Sin acción.')
                            });
                    } else {
                        toastr['info']('El pago seleccionado ya se encuentra autorizado');
                    }
                } else {
                    $('#modalGeneral').modal('hide');
                    $('#modalRechazarPago #pago_id').val(pago_id);
                    $('#modalRechazarPago #estatus').val(estatus);
                    $('#modalRechazarPago #tarjeta_id').val(tarjeta_id);

                    $('#modalRechazarPago').modal('show');
                }
            });


            $('#formRechazarPago').submit(function(event) {
                var pago_id = $('#pago_id').val();
                event.preventDefault();
                $.ajax({
                        url: baseadmin + 'rechazar-pago/' + $('#pago_id').val(),
                        type: 'PUT',
                        dataType: 'json',
                        data: $(this).serialize(),
                        beforeSend: function() {
                            $("#overlay").css("display", "block");
                        },
                        success: function(res) {
                            if (res.success != true) {
                                toastr['error']('¡Intentarlo mas tarde!');
                                toastr['warning'](
                                    'Ponerse en contacto con el administrador del sistema.');
                            }
                            $('#tableTerminal #estatusPago' + pago_id).html('Rechazado');
                            $('#tableTerminal #estatusPago' + pago_id).removeClass(
                                'btn-inverse btn-danger btn-success');
                            $('#tableTerminal #estatusPago' + pago_id).addClass('btn-danger');
                            $('#tableTerminal #statusPago' + pago_id).addClass('btn-danger');
                            // tabla_pagos.ajax.reload();
                            // $('#tableTerminal').DataTable().ajax.reload();
                            toastr['success']('¡Registro exitoso!')
                            $('#modalRechazarPago').modal('hide');
                        }
                    })
                    .always(function() {
                        $("#overlay").css("display", "none");
                    });
            });



            $('body').on('click', '#btnEditar', function(event) {
                event.preventDefault();
                var pago_id = $(this).data('pago_id');
                var tarjeta_id = $(this).data('tarjeta_id');
                var contrato_id = $(this).data('contrato_id');
                $.ajax({
                        url: '',
                        type: 'GET',
                        dataType: 'JSON',
                        success: function(res) {
                            $('#modalGeneral #modalGeneralLabel').html('Pago');
                            $('#modalGeneral #modal-body').html(res.view);
                            $('#modalGeneral').modal('show');
                        }
                    })
                    .done(function() {
                        console.log("success");
                    })
                    .fail(function() {
                        console.log("error");
                    })
                    .always(function() {
                        console.log("complete");
                    });
            });

            /*================================================
            =            Cambio de metodo de pago            =
            ================================================*/
            $('body').on('click', '#btnMetodoPago', function(event) {
                event.preventDefault();
                var contrato_id = $(this).attr('value');
                $('#modalGeneral .modal-dialog').removeClass('modal-xl');
                $.ajax({
                        url: $(this).data('route'),
                        type: 'GET',
                        dataType: 'json',
                        beforeSend: function() {
                            $("#overlay").css("display", "block");
                        },
                        success: function(res) {
                            if (res.success) {
                                $('#modalGeneral #modalGeneralLabel').html(res.titulo);
                                $('#modalGeneral #modal-body').html(res.view);
                                $('#modalGeneral').modal('show');
                            }
                        }
                    })
                    .always(function() {
                        $("#overlay").css("display", "none");
                    });
            });

            $('body').on('submit', '#form_editar_metodo_pago', function(event) {
                event.preventDefault();
                $.ajax({
                        url: $(this).attr('action'),
                        type: $(this).attr('method'),
                        dataType: 'json',
                        data: $(this).serialize(),
                        beforeSend: function() {
                            $("#overlay").css("display", "block");
                        },
                        success: function(res) {
                            if (res.success == true) {
                                $('#modalGeneral').modal('hide');
                                tabla_contratos.ajax.reload();
                                // window.location.reload();
                                toastr['success']('{{ __('messages.alerta.success') }}');
                            } else {
                                toastr['error'](
                                    'No se pudieron aplicar los cambios, intentelo mas tarde');
                            }
                        }
                    })
                    .always(function() {
                        $("#overlay").css("display", "none");
                        $('#modalGeneral').modal('hide');
                    });
            });

            /*==============================================
            =            Opciones de los pagos (segmentos)            =
            ==============================================*/
            $('body').on('click', '#btnEditarPago', function(event) {
                event.preventDefault();
                var pago_id = $(this).data('pago_id');
                var tarjeta_id = $(this).data('tarjeta_id');
                var contrato_id = $(this).data('contrato_id');
                $.ajax({
                        url: baseadmin + 'pagos/' + pago_id + '/edit',
                        type: 'GET',
                        dataType: 'JSON',
                        beforeSend: function() {
                            $("#overlay").css("display", "block");
                        },
                        success: function(res) {
                            $('#modalShowPagos').modal('hide');
                            $('#modalGeneral #modalGeneralLabel').html('Pago');
                            $('#modalGeneral #modal-body').html(res.view);
                            $('#modalGeneral').modal('show');
                        }
                    })
                    .always(function() {
                        $("#overlay").css("display", "none");
                    });
            });


            $('body').on('click', '#btnCerrar', function(event) {
                event.preventDefault();
                $('#modalGeneral').modal('hide');
                // $('#modalShowPagos').modal('show');
            });



            $(document).on('submit', '#form_editar_segmento', function(event) {
                event.preventDefault();
                let contrato_id = $(this).data('contrato_id');
                let pago_id = $(this).data('pago_id');
                let estatus = $(this).data('estatus');

                $.ajax({
                        url: $(this).attr('action'),
                        type: $(this).attr('method'),
                        dataType: 'JSON',
                        data: $(this).serialize(),
                        beforeSend: function() {
                            $("#overlay").css("display", "block");
                        },
                        success: function(res) {
                            console.log(res);
                            if (res.success == false) {
                                pintar_errores(res.errors)
                            } else {
                                $('#tableTerminal #estatusPago' + pago_id).removeClass(
                                    'btn-inverse btn-danger btn-success');
                                $('#tableTerminal #statusPago' + pago_id).removeClass(
                                    'btn-inverse btn-danger btn-success');
                                if (res.pago.estatus == 'Por Pagar') {
                                    $('#tableTerminal #estatusPago' + pago_id).addClass(
                                        'btn-inverse');
                                    $('#tableTerminal #statusPago' + pago_id).addClass(
                                        'btn-inverse');
                                } else if (res.pago.estatus == 'Pagado') {
                                    $('#tableTerminal #estatusPago' + pago_id).addClass(
                                        'btn-success');
                                    $('#tableTerminal #statusPago' + pago_id).addClass(
                                        'btn-success');
                                } else if (res.pago.estatus == 'Rechazado') {
                                    $('#tableTerminal #estatusPago' + pago_id).addClass(
                                        'btn-danger');
                                    $('#tableTerminal #statusPago' + pago_id).addClass(
                                    'btn-danger');
                                } else {
                                    $('#tableTerminal #estatusPago' + pago_id).addClass(
                                        'btn-inverse');
                                    $('#tableTerminal #statusPago' + pago_id).addClass(
                                        'btn-inverse');
                                }
                                $('#tableTerminal #estatusPago' + pago_id).html(res.pago.estatus);

                                // $('#tableTerminal #cantidadPago'+pago_id).html('');
                                $('#tableTerminal #cantidadPago' + pago_id).html('MXN' + res.pago
                                    .cantidad);

                                $('#tableTerminal #fechaCobro' + pago_id).html(res.pago
                                    .fecha_de_cobro);

                                if (res.pago.estatus == 'Pagado' || res.pago.estatus ==
                                    'Rechazado') {
                                    $('#tableTerminal #fechaPago' + pago_id).html(res.pago
                                        .fecha_de_pago);
                                }

                                $('#modalGeneral').modal('hide');
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Segmento editado correctamente',
                                    showConfirmButton: false,
                                    timer: 1900
                                })
                            }
                        }
                    })
                    .always(function() {
                        $("#overlay").css("display", "none");
                    });
            });


            $('body').on('click', '#btnDeletePago', function(event) {
                event.preventDefault();
                let pago_id = $(this).data('pago_id');
                let contrato_id = $(this).data('contrato_id');
                let segmento = $(this).data('segmento');
                let estatus = $(this).data('estatus');
                let url = $(this).data('url');

                console.log(url);
                if (estatus != 'Por Pagar') {
                    toastr['warning']('No se puede eliminar el segmento seleccionado');
                } else {
                    alertify.confirm('Confirmar', '¿Desea eliminar el segmento ' + segmento + '?',
                        function() {
                            $.ajax({
                                    url: url,
                                    type: 'DELETE',
                                    dataType: 'json',
                                    beforeSend: function() {

                                    },
                                    success: function(res) {
                                        if (res.success != true) {
                                            toastr['error']('¡Intentarlo más tarde!');
                                        }

                                        toastr['success']('¡Registro exitoso!');
                                        // tabla_pagos.ajax.reload();
                                        $('#tableTerminal').DataTable().ajax.reload();
                                        // listar_pagos(tabla_pagos, contrato_id, 'all');
                                    }
                                })
                                .always(function() {
                                    console.log("complete");
                                });

                        },
                        function() {

                        });
                }
            });

            $('body').on('click', '.btnMostratPagos', function(event) {
                event.preventDefault();
                var contrato_id = $(this).val();
                var tipo = $(this).data('id');

                listar_pagos(tabla_pagos, contrato_id, tipo);
            });



        });

        function listar_pagos(tabla_pagos, contrato_id, tipo) {
            $.ajax({
                    url: baseuri + 'admin/listar-pagos-contrato/' + contrato_id + '/' + tipo,
                    type: 'get',
                    dataType: 'json',
                    beforeSend: function() {
                        $("#overlay").css("display", "block");
                    },
                    success: function(res) {
                        $('#modalShowPagos').modal('show');
                        $('#modalShowPagos #folioContrato').html(+contrato_id);
                        tabla_pagos = $('#table_pagos').dataTable({
                            'responsive': true,
                            'searching': false,
                            "rowGroup": {
                                "dataSrc": 8
                            },
                            "aoColumns": [{
                                "mData": "9"
                            }, {
                                "mData": "1"
                            }, {
                                "mData": "2"
                            }, {
                                "mData": "3"
                            }, {
                                "mData": "4"
                            }, {
                                "mData": "5"
                            }, {
                                "mData": "7"
                            }],
                            data: res.aaData,
                            "bDestroy": true
                        }).DataTable();
                    }
                })
                .always(function() {
                    $("#overlay").css("display", "none");
                });
        }


        function autorizar_pago(pago_id, tabla_pagos) {
            $.ajax({
                    url: baseadmin + 'autorizar-pago/' + pago_id,
                    type: 'GET',
                    dataType: 'json',
                    beforeSend: function() {
                        $("#overlay").css("display", "block");
                    },
                    success: function(res) {
                        if (res.success == true) {
                            toastr['success']('¡Pago autorizado!');
                            $('#modalGeneral').modal('hide');
                            $('#tableTerminal #estatusPago' + pago_id).html('Pagado');
                            $('#tableTerminal #estatusPago' + pago_id).removeClass(
                                'btn-inverse btn-danger btn-success');
                            $('#tableTerminal #estatusPago' + pago_id).addClass('btn-success');
                            $('#tableTerminal #statusPago' + pago_id).addClass('btn-success');
                            // tabla_pagos.ajax.reload();
                            // $('#tableTerminal').DataTable().ajax.reload();
                        } else {
                            toastr['error']('¡Inténtalo mas tarde!')
                        }
                    }
                })
                .always(function() {
                    $("#overlay").css("display", "none");
                });
        }

        function pintar_segmentos(data) {
            $.ajax({
                    url: baseadmin + 'cobranza-get-data',
                    type: 'get',
                    dataType: 'json',
                    data: data,
                    beforeSend: function() {
                        $("#overlay").css("display", "block");
                    },
                    success: function(res) {
                        tabla_terminal = $('#tableTerminal').dataTable({
                            'responsive': true,
                            'searching': true,
                            "aoColumns": [{
                                    "mData": "1"
                                }, {
                                    "mData": "7"
                                }, {
                                    "mData": "2"
                                }, {
                                    "mData": "3"
                                }, {
                                    "mData": "4"
                                }, {
                                    "mData": "8",
                                    "rowGroup": true
                                }, {
                                    "mData": "5"
                                }, {
                                    "mData": "6"
                                }

                            ],
                            data: res.aaData,
                            // rowGroup: {
                            //     dataSrc: "8"
                            // },
                            // "order": [["8", "asc"]],
                            "bDestroy": true
                        }).DataTable();
                    }
                })
                .fail(function(jqXHR, textStatus, errorThrown) {
                    $("#overlay").css("display", "none");
                    toastr['error'](jqXHR.responseJSON);
                    toastr['error']('Intenta mas tarde...');
                })
                .always(function() {
                    $("#overlay").css("display", "none");
                });
        }
    </script>

@stop
