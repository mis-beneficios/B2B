@extends('layouts.admin.app')
@section('content')
<style>
    button > .infoPago{
        display: none;
    }

    #btnPago:hover{
        /*background-color: red;*/
    }

    #btnPago:hover  > .infoPago{
        display: block;
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
                    <button class="btn btn-info btn-xs" data-target="#modalUnlock" data-toggle="modal" style="color: white;">
                        <i class="fas fa-unlock-alt">
                        </i>
                        Desbloquear
                    </button>
                </div>
                <h4 class="card-title m-b-0">
                    Filtrado Terminal
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
                                    <input autocomplete="off" class="form-control datepicker" id="fecha_inicio" name="fecha_inicio" type="text" value="{{ date('Y-m-d') }}">
                                        <span class="text-danger error-titular errors">
                                        </span>
                                    </input>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="inputPassword4">
                                        Fin del rango
                                    </label>
                                    <input autocomplete="off" class="form-control datepicker" id="fecha_fin" name="fecha_fin" type="text" value="{{ date('Y-m-d') }}">
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
                                <label class="btn btn-info btn-sm ">
                                    <input name="nomina" type="checkbox">
                                        Nomina
                                    </input>
                                </label>
                                <label class="btn btn-info btn-sm">
                                    <input name="terminal" type="checkbox">
                                        Terminal
                                    </input>
                                </label>
                                <label class="btn btn-info btn-sm ">
                                    <input name="viaserfin" type="checkbox">
                                        Via Serfin
                                    </input>
                                </label>
                            </div>
                            <h5 class="card-title mb-2 mt-2">
                                Estatus de pago:
                            </h5>
                            <div class="btn-group" data-toggle="buttons">
                                <label class="btn btn-info btn-sm active ">
                                    <input checked="" name="pagosRechazados" type="checkbox">
                                        Rechazados
                                    </input>
                                </label>
                                <label class="btn btn-info btn-sm active">
                                    <input checked="" name="pagosPagados" type="checkbox">
                                        Pagados
                                    </input>
                                </label>
                                <label class="btn btn-info btn-sm active ">
                                    <input checked="" name="pagosPendientes" type="checkbox">
                                        Pendientes
                                    </input>
                                </label>
                                <label class="btn btn-info btn-sm active ">
                                    <input checked="" name="pagosAnomalías" type="checkbox">
                                        Anomalías
                                    </input>
                                </label>
                            </div>
                            <h5 class="card-title mb-2 mt-2">
                                Tipo de tarjeta:
                            </h5>
                            <div class="btn-group" data-toggle="buttons">
                                <label class="btn btn-info btn-sm ">
                                    <input name="tipoTarjeta" type="radio" value="Credito">
                                        Crédito
                                    </input>
                                </label>
                                <label class="btn btn-info btn-sm">
                                    <input name="tipoTarjeta" type="radio" value="Debito">
                                        Débito
                                    </input>
                                </label>
                                <label class="btn btn-info btn-sm active">
                                    <input checked="" name="tipoTarjeta" type="radio" value="0">
                                        Sin segmentar
                                    </input>
                                </label>
                            </div>
                            <h5 class="card-title mb-2 mt-2">
                                Red bancaria:
                            </h5>
                            <div class="btn-group" data-toggle="buttons">
                                <label class="btn btn-info btn-sm ">
                                    <input name="red_bancaria" type="radio" value="MasterCard">
                                        MasterCard
                                    </input>
                                </label>
                                <label class="btn btn-info btn-sm">
                                    <input name="red_bancaria" type="radio" value="VISA">
                                        VISA
                                    </input>
                                </label>
                                <label class="btn btn-info btn-sm active">
                                    <input checked="" name="red_bancaria" type="radio" value="0">
                                        Sin segmentar
                                    </input>
                                </label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <h5 class="card-title mb-2 mt-2">
                                Filtrado extra:
                            </h5>
                            <div class="btn-group" data-toggle="buttons">
                                <label class="btn btn-info btn-sm active">
                                    <input checked="" id="btnNinguno" type="radio" value="ninguno">
                                        Ninguno
                                    </input>
                                </label>
                                <label class="btn btn-info btn-sm">
                                    <input id="btnPais" type="radio" value="pais">
                                        País
                                    </input>
                                </label>
                                <label class="btn btn-info btn-sm ">
                                    <input id="btnConvenio" type="radio" value="convenio">
                                        Convenio
                                    </input>
                                </label>
                            </div>
                            <div id="contenedor_filtro" style="display:none">
                                <h5 class="card-title mb-2 mt-2">
                                    Filtrado extra:
                                </h5>
                                <div class="btn-group" data-toggle="buttons">
                                    <label class="btn btn-info btn-sm active">
                                        <input checked="" id="btnNinguno" type="radio" value="ninguno">
                                            Ninguno
                                        </input>
                                    </label>
                                    <label class="btn btn-info btn-sm">
                                        <input id="btnPais" type="radio" value="pais">
                                            País
                                        </input>
                                    </label>
                                    <label class="btn btn-info btn-sm ">
                                        <input id="btnConvenio" type="radio" value="convenio">
                                            Convenio
                                        </input>
                                    </label>
                                </div>
                            </div>
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
                <table class="table table-hover dataTable no-footer" id="tableTerminal">
                    <thead>
                        <tr>
                            <th scope="col">
                                Segmento
                                <br/>
                                <small>
                                    # Pago
                                </small>
                            </th>
                            <th scope="col">
                                # Contrato
                                <br/>
                                <small>
                                    Clave Serfin
                                </small>
                            </th>
                            <th scope="col">
                                Cliente
                                <br/>
                                <small>
                                    Convenio
                                </small>
                            </th>
                            <th scope="col">
                                Cantidad
                                <br/>
                                <small>
                                    Cantidad total
                                </small>
                            </th>
                            <th scope="col">
                                Tarjeta asignada
                                <br/>
                                <small>
                                    Entidad bancaria
                                </small>
                            </th>
                            <th scope="col">
                                Estatus
                                <br/>
                                <small>
                                    Motivo del rechazo
                                </small>
                            </th>
                            <th scope="col">
                                F. programada
                                <br/>
                                <small>
                                    Fecha cobro exitoso
                                </small>
                            </th>
                            <th scope="col" width="140px">
                                Acciones
                                <br/>
                                <small>
                                    Avance de pagos
                                </small>
                            </th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>
{{-- <div id="main">
    <terminal/>    
</div>
 --}}

<div aria-hidden="true" aria-labelledby="exampleModalLabel" class="modal fade" id="modalUnlock" tabindex="-1">
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

        $('.datepicker').bootstrapMaterialDatePicker({
            weekStart: 0,
            time: false,
            lang: 'es',
        });



        var tabla_pagos;

        // $(document).on('submit', '#formTerminal', function(event) {
        //     event.preventDefault();
        //     tabla_pagos = $('#tableTerminal').dataTable({
        //         processing: true,
        //         serverSide: true,
        //         bDestroy: true,
        //         bInfo: false,
        //         ajax: {
        //             url:  baseadmin + 'cobranza-get-data',
        //             data: function (d) {
        //                 // d.country_id = $('select[name=country_id]').val();
        //                 d.fecha_inicio = $('input[name="fecha_inicio"]').val();
        //                 d.fecha_fin = $('input[name="fecha_fin"]').val();
        //                 d.nomina = $('input[name="nomina"]').val();
        //                 d.terminal = $('input[name="terminal"]').val();
        //                 d.viaserfin = $('input[name="viaserfin"]').val();
        //                 d.pagosRechazados = $('input[name="pagosRechazados"]').val();
        //                 d.pagosPagados = $('input[name="pagosPagados"]').val();
        //                 d.pagosPendientes = $('input[name="pagosPendientes"]').val();
        //                 d.pagosAnomalías = $('input[name="pagosAnomalías"]').val();
        //                 d.tipoTarjeta = $('input[name="tipoTarjeta"]').val();
        //                 // d.tipoTarjeta = $('#tipoTarjeta').val();
        //                 // d.tipoTarjeta = $('#tipoTarjeta').val();
        //                 // d.red_bancaria = $('#red_bancaria').val();
        //                 // d.red_bancaria = $('#red_bancaria').val();
        //                 d.red_bancaria = $('#red_bancaria').val();
        //             }
        //         },
        //         columns: [
        //             {data: 'segmento_data', name: 'segmento_data'},
        //             {data: 'contrato_data', name: 'contrato_data'},
        //             {data: 'cliente_data', name: 'cliente_data'},
        //             {data: 'cantidad_data', name: 'cantidad_data'},
        //             {data: 'tarjeta_data', name: 'tarjeta_data'},
        //             {data: 'estatus_data', name: 'estatus_data'},
        //             {data: 'fechas_data', name: 'fechas_data'},
        //             {data: 'actions', name: 'actions'},
        //         ],
        //         "drawCallback": function() {
        //             if (this.fnSettings().fnRecordsTotal() < 11) {
        //                 $('.dataTables_paginate').hide();
        //             }
        //         },
        //         // data: res.original.data,
        //         "bDestroy": true
        //     }).DataTable();
        // });
  

        // $('#btnFiltrar').click();

        $(document).on('submit', '#formTerminal', function(event) {
            event.preventDefault();
            $.ajax({
                url: baseadmin + 'cobranza-get-data',
                type: 'GET',
                dataType: 'JSON',
                data: $(this).serialize(),
                beforeSend:function(){
                    $("#overlay").css("display", "block");
                },
                success:function(res){
                    // console.log(res.original);
                    tabla_pagos = $('#tableTerminal').dataTable({
                        'responsive': true,
                        'lengthMenu': [[12, 24, -1], [12, 24, "Todo"]],
                        'pageLength': 12,
                        // order: [1, 'ASC'],
                        columns: [
                            {data: 'segmento_data', name: 'segmento_data'},
                            {data: 'contrato_data', name: 'contrato_data'},
                            {data: 'cliente_data', name: 'cliente_data'},
                            {data: 'cantidad_data', name: 'cantidad_data'},
                            {data: 'tarjeta_data', name: 'tarjeta_data'},
                            {data: 'estatus_data', name: 'estatus_data'},
                            {data: 'fechas_data', name: 'fechas_data'},
                            {data: 'actions', name: 'actions'},
                        ],
                        "drawCallback": function() {
                            if (this.fnSettings().fnRecordsTotal() < 11) {
                                $('.dataTables_paginate').hide();
                            }
                        },
                        data: res.original.data,
                        "bDestroy": true
                    }).DataTable();
                }
            })
            .done(function() {
                console.log("success");
            })
            .fail(function() {
                console.log("error");
            })
            .always(function() {
                $("#overlay").css("display", "none");
            });            
        });

        // $('#fecha_inicio').datepicker({
        //    dateFormat: "yy-mm-dd",
        //     startDate: '-3d',
        //     autoclose:true,
        //     language: 'es',
        //     orientation: 'bottom',
        // });
        // $('#fecha_fin').datepicker({
        //     dateFormat: "yy-mm-dd",
        //     startDate: '-3d',
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
                beforeSend:function(){

                },
                success:function(res){
                    if (res.success == true) {
                        toastr['info']('Tarjetas desbloqueadas');
                        window.location.reload();
                    }else{
                        toastr['error']('Contraseña incorrecta');
                    }
                }
            })
            .always(function() {
                console.log("complete");
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
                beforeSend:function(){
                     $("#overlay").css("display", "block");
                },
                success:function(res){
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
                    alertify.confirm('Autorizar pago', '¿Desea autorizar el pago: ' +pago_id, 
                        function(){ 
                           autorizar_pago(pago_id, tabla_pagos);
                        }
                        ,function(){ 
                            toastr['warning']('Sin acción.')
                        });
                }else{
                    toastr['info']('El pago seleccionado ya se encuentra autorizado');
                }
            }else{
                $('#modalGeneral').modal('hide');
                $('#modalRechazarPago #pago_id').val(pago_id);
                $('#modalRechazarPago #estatus').val(estatus);
                $('#modalRechazarPago #tarjeta_id').val(tarjeta_id);

                $('#modalRechazarPago').modal('show');
            } 
        });


        $('#formRechazarPago').submit(function(event) {
            // console.log($(this).serialize());
            event.preventDefault();
            $.ajax({
                url: baseadmin + 'rechazar-pago/' + $('#pago_id').val(),
                type: 'PUT',
                dataType: 'json',
                data: $(this).serialize(),
                beforeSend:function(){
                    $("#overlay").css("display", "block");
                },
                success:function(res){
                    if (res.success != true) {
                        toastr['error']('¡Intentarlo mas tarde!');
                        toastr['warning']('Ponerse en contacto con el administrador del sistema.');
                    }

                    tabla_pagos.ajax.reload();
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
                success:function(res){
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


        /*==============================================
        =            Opciones de los pagos (segmentos)            =
        ==============================================*/
        $('body').on('click', '#btnEditarPago', function(event) {
            event.preventDefault();
            var pago_id = $(this).data('pago_id');
            var tarjeta_id = $(this).data('tarjeta_id');
            var contrato_id = $(this).data('contrato_id');
            $.ajax({
                url: baseadmin + 'pagos/'+pago_id +'/edit',
                type: 'GET',
                dataType: 'JSON',
                success:function(res){
                    $('#modalShowPagos').modal('hide');
                    $('#modalGeneral #modalGeneralLabel').html('Pago');
                    $('#modalGeneral #modal-body').html(res.view);
                    $('#modalGeneral').modal('show');
                }
            })
            .always(function() {
                console.log("complete");
            });
        });


        $('body').on('click', '#btnCerrar', function(event) {
            event.preventDefault();
            $('#modalGeneral').modal('hide');
            $('#modalShowPagos').modal('show');
        });



        $(document).on('submit', '#form_editar_segmento', function(event) {
            event.preventDefault();
            let contrato_id = $(this).data('contrato_id');

            console.log(contrato_id);
             $.ajax({
                url: $(this).attr('action'),
                type: $(this).attr('method'),
                dataType: 'JSON',
                data: $(this).serialize(),
                beforeSend:function(){
                    $("#overlay").css("display", "block");
                },
                success:function(res){
                    if (res.success != true) {
                        toastr['error']('¡Intentarlo más tarde!');
                    }
                    // listar_pagos(tabla_pagos, contrato_id, 'all');
                    toastr['success']('¡Registro exitoso!');
                    $('#modalGeneral').modal('hide');
                    // $('#modalShowPagos').modal('show');
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
            }else{
                alertify.confirm('Confirmar', '¿Desea eliminar el segmento '+ segmento +'?', 
                function(){ 
                    $.ajax({
                        url: url,
                        type: 'DELETE',
                        dataType: 'json',
                        beforeSend:function(){

                        },
                        success:function(res){
                            if (res.success != true) {
                                toastr['error']('¡Intentarlo más tarde!');
                            }

                            toastr['success']('¡Registro exitoso!');
                            tabla_pagos.ajax.reload();
                            // listar_pagos(tabla_pagos, contrato_id, 'all');
                        }
                    })
                    .always(function() {
                        console.log("complete");
                    });
                                                              
                }
                ,function(){ 
                    
                });
            }
        });
    
    });


    function autorizar_pago(pago_id, tabla_pagos) {
        $.ajax({
            url: baseadmin + 'autorizar-pago/' + pago_id,
            type: 'GET',
            dataType: 'json',
            beforeSend:function(){
                 $("#overlay").css("display", "block");
            },
            success:function(res){
                if(res.success == true){
                    toastr['success']('¡Pago autorizado!');
                    $('#modalGeneral').modal('hide');
                    tabla_pagos.ajax.reload();
                }else{
                    toastr['error']('¡Inténtalo mas tarde!')
                }
            }
        })
        .always(function() {
             $("#overlay").css("display", "none");
        });
    }
</script>
@stop
