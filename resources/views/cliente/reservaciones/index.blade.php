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
<div class="row page-titles">
    <div class="col-md-5 col-8 align-self-center">
        <h3 class="text-themecolor">
            Inicio
        </h3>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="javascript:void(0)">
                    Contratos
                </a>
            </li>
            <li class="breadcrumb-item active">
                Listar
            </li>
        </ol>
    </div>
</div>
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
                    {{ __('messages.cliente.mis_reservaciones') }}
                </h4>
                <div class="table-responsive m-t-20">
                    <table class="table stylish-table" id="table_paquetes" style="width: 100%;">
                        <thead>
                            <tr>
                                <th>
                                    #
                                </th>
                                <th>
                                    Titulo
                                </th>
                                <th>
                                    Reservado a:
                                </th>
                                <th>
                                    Destino
                                </th>
                                <th>
                                    Hotel
                                </th>
                                <th>
                                    Estatus
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
@endsection

@section('script')
<script>
    $(document).ready(function() {
           var table =  $('#table_paquetes').DataTable({
            order: ([0, 'DESC']),
            lengthMenu: [[5, 10, 25, 50, -1], [5, 10, 25, 50, "Todo"]],
            pageLength: 5,

            ajax: baseuri + "cliente/obtener-reservaciones",
            columns: [
                {data: 'id', name: 'id'},
                {data: 'title', name: 'title'},
                {data: 'nombre_de_quien_sera_la_reservacion', name: 'nombre_de_quien_sera_la_reservacion'},
                {data: 'destino', name: 'destino'},
                {data: 'hotel', name: 'hotel'},
                {
                    data: 'estatus', render: function (estatus) {
                        switch (estatus) {
                            case 'Cancelada':
                            return '<label class="label label-danger">'+estatus+'</label>';    
                                break;
                            case 'Cupon Enviado':
                            return '<label class="label label-warning">'+estatus+'</label>';    
                                break;
                            case 'Autorizada':
                            return '<label class="label label-success">'+estatus+'</label>';    
                                break;
                            case 'Penalizada':
                            return '<label class="label label-info">'+estatus+'</label>';    
                                break;
                            default: 
                                return '<label class="label label-primary">'+estatus+'</label>';
                            break;

                        }
                        
                    }
                },
                
                // {data: 'precio', name: 'precio'},
                // {data: 'action', name: 'action'},

            ]
        });


// btnPagos
// btnContrato
// btnReservar
// btnEliminar


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
                                return '<label class="label label-success">Pagado</label>';    
                                    break;
                                case 'Por Pagar':
                                return '<label class="label label-warning">Pendiente</label>';
                                    break;
                                default:
                                return '<label class="label label-danger">Rechazado</label>';
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
            $.ajax({
                url: baseuri + 'mostrar-contrato/' + contrato_id,
                type: 'GET',
                dataType: 'json',
                beforeSend:function(){
                    $("#overlay").css("display", "block");
                },
                success:function(res){
                    $("#overlay").css("display", "none");
                    $('#bodyContrato').html(res);
                    $('#btnDescargar').attr('href', baseuri + 'descargar-contrato/'+ contrato_id);
                    $('#modalContrato').modal('show');
                }
            });
        });
    });
</script>
@endsection
