@extends('layouts.admin.app')
@section('content')
<style>
    .table_pagos thead{
        font-size: 12px;
    }
    .table_pagos tbody tr{
        font-size: .8em;
    }
    .dataTables_paginate{
        font-size: 12px;
    }
</style>
<div class="row mt-4">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                {{--
                <select class="custom-select pull-right">
                    <option selected="">
                        January
                    </option>
                    <option value="1">
                        February
                    </option>
                    <option value="2">
                        March
                    </option>
                    <option value="3">
                        April
                    </option>
                </select>
                --}}
                <h4 class="card-title">
                    {{ __('messages.cliente.mis_paquetes') }}
                </h4>
                <div class="table-responsive m-t-20">
                    <table class="table stylish-table" id="table_paquetes" style="width: 100%;">
                        <thead>
                            <tr>
                                <th>
                                    {{ __('messages.user.show.folio') }}
                                </th>
                                <th>
                                    {{ __('messages.user.show.estancia') }}
                                </th>
                                <th>
                                    ${{ __('messages.user.show.pagado') }}
                                </th>
                                <th>
                                    ${{ __('messages.user.show.pendientes') }}
                                </th>
                                <th>
                                    {{ __('messages.user.show.estatus') }}
                                </th>
                                <th>
                                    Creado
                                </th>
                                <th>
                                    {{ __('messages.user.show.opciones') }}
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal -->
<div aria-hidden="true" aria-labelledby="modelTitleId" class="modal fade" id="modalPagos" role="dialog" tabindex="-1">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    {{ __('messages.cliente.historial_pagos') }}
                </h5>
                <button aria-label="Close" class="close" data-dismiss="modal" type="button">
                    <span aria-hidden="true">
                        ×
                    </span>
                </button>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <div class="table-responsive">
                        <table class="table stylish-table table_pagos" id="table_pagos" style="width: 100%;">
                            <thead class="">
                                <tr>
                                    <th>
                                        #
                                    </th>
                                    <th>
                                        {{ __('messages.cliente.segmento') }}
                                    </th>
                                    <th>
                                        {{ __('messages.cliente.fecha_de_cobro') }}
                                    </th>
                                    <th>
                                        {{ __('messages.cliente.fecha_de_pago') }}
                                    </th>
                                    <th>
                                        {{ __('messages.cliente.cantidad') }}
                                    </th>
                                    <th>
                                        {{ __('messages.cliente.estatus') }}
                                    </th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" data-dismiss="modal" type="button">
                    {{ __('messages.cerrar') }}
                </button>
            </div>
        </div>
    </div>
</div>
{{-- Modal Contrato --}}
<div aria-hidden="true" aria-labelledby="modelTitleId" class="modal fade" id="modalContrato" role="dialog" tabindex="-1">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5>
                    {{ __('messages.cliente.contratos') }}
                </h5>
                <button aria-label="Close" class="close" data-dismiss="modal" type="button">
                    <span aria-hidden="true">
                        ×
                    </span>
                </button>
            </div>
            <div class="modal-body m-3" id="bodyContrato">
            </div>
            <div class="modal-footer">
                <button class="btn btn-light" data-dismiss="modal" type="button">
                    {{ __('messages.cerrar') }}
                </button>
                <a class="btn btn-dark" id="btnDescargar" target="_blank" type="button">
                    {{ __('messages.descargar') }}
                </a>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
    $(document).ready(function() {
        var table;
        setTimeout(function(){
            table =  $('#table_paquetes').DataTable({
                order: ([0, 'DESC']),
                lengthMenu: [[5, 10, 25, 50, -1], [5, 10, 25, 50, "Todo"]],
                pageLength: 10,
                ajax: baseuri + "cliente/obtener-contratos",
                columns: [
                    {data: 'id', name: 'id'},
                    {data: 'estancia', name: 'estancia'},
                    {data: 'monto_pagado', name: 'monto_pagado'},
                    {data: 'monto_pendiente', name: 'monto_pendiente'},
                    {
                        data: 'estatus', render: function (estatus) {
                            switch (estatus) {
                                case 'comprado':
                                case 'por_autorizar':
                                return '<label class="label label-success"> {{ __("messages.user.show.comprado") }} </label>';    
                                    break;
                                case 'nuevo':
                                return '<label class="label label-primary">{{ __("messages.user.show.nuevo") }}</label>';    
                                    break;
                                case 'suspendido':
                                return '<label class="label" style="background-color:#7d7d7d">{{ __("messages.user.show.suspendido") }}</label>';    
                                    break;
                                case 'cancelado':
                                return '<label class="label label-danger">{{ __("messages.user.show.cancelado") }}</label>';    
                                    break;
                                case 'pagado':
                                return '<label class="label label-info">{{ __("messages.user.show.pagado") }}</label>';    
                                    break;
                                case 'viajado':
                                return '<label class="label" style="background-color:#000000">{{ __("messages.user.show.viajado") }}</label>';    
                                    break;
                                default:
                                return '<label class="label" style="background-color:#edf101">{{ __("messages.user.show.sin_aprobar") }}</label>';    
                                    break;
                            }
                        }
                    },
                    {data: 'created', name: 'created'},
                    {data: 'action', name: 'action'},
                ]
            });
        }, 1500)


        // $('#btnPagos').click(function (e) { 
        $('body').on('click', '#btnPagos', function (e) {
            e.preventDefault();
            var contrato_id = $(this).data('id');
            $('#modalPagos').modal('show');
            var table =  $('#table_pagos').DataTable({
                order: ([0, 'asc']),
                lengthMenu: [[5, 10, 25, 50, -1], [5, 10, 25, 50, "Todo"]],
                pageLength: 5,
                searching: false,
                destroy: true,
                ajax: baseuri + "cliente/obtener-pagos/"+ contrato_id,
                success:function(){
                    $('modalPagos').modal('show');
                },
                columns: [
                    {data: 'id', name: 'id'},
                    {data: 'segmento', name: 'segmento'},
                    {data: 'fecha_de_cobro', name: 'fecha_de_cobro'},
                    {data: 'fecha_de_pago', name: 'fecha_de_pago'},
                    {data: 'cantidad', name: 'cantidad'},
                    {
                        data: 'estatus', render: function (estatus) {
                            switch (estatus) {
                                case 'Pagado':
                                return '<label class="label label-success">{{ __("messages.user.show.pagado") }}</label>';    
                                    break;
                                case 'Por Pagar':
                                return '<label class="label label-warning">{{ __("messages.user.show.pendientes") }}</label>';
                                    break;
                                default:
                                return '<label class="label label-danger">{{ __("messages.user.show.rechazados") }}</label>';
                                    break;
                            }
                        }
                    },
                ]
            });
        });

        $('body').on('click', '#btnContrato', function (e) {
            event.preventDefault();
            var contrato_id = $(this).data('id');
            var pais_id = $(this).data('pais_id');

            if (pais_id == 1) {
                $url = baseuri + 'mostrar-contrato/' + contrato_id; 
                $download = baseuri + 'descargar-contrato/' + contrato_id; 
            }else{
                $url = baseuri + 'show-contract/' + contrato_id; 
                $download = baseuri + 'download-contract/' + contrato_id; 
            }

            $.ajax({
                url: $url,
                type: 'GET',
                dataType: 'json',
                beforeSend:function(){
                    $("#overlay").css("display", "block");
                },
                success:function(res){
                    console.log(res);
                    $("#overlay").css("display", "none");
                    $('#bodyContrato').html(res.formato);
                    $('#btnDescargar').attr('href', $download);
                    $('#modalContrato').modal('show');
                }
            })
            .always(function(){
                $("#overlay").css("display", "none");
            });
        });


        // $('body').on('click', '#btnVerContrato', function(event){
        //     event.preventDefault();
        //     var contrato_id = $(this).attr('value');
        //     $.ajax({
        //         url: baseadmin + 'mostrar-contrato/'+ contrato_id,
        //         type: 'GET',
        //         dataType: 'json',
        //         beforeSend:function(){
        //             $("#overlay").css("display", "block");
        //         },
        //         success:function(res){
        //             $('#modalVerContrato .modal-body').html(res.formato);
        //             $('#modalVerContrato #downloadPdf').attr('href', res.name);
        //             $('#modalVerContrato').modal('show');
        //         }
        //     })
        //     .always(function() {
        //         $("#overlay").css("display", "none");
        //     });
        // });
    });
</script>
@endsection
