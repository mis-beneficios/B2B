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
    .select2-container{
        width: 87% !important;
    }
</style>
<div class="row mt-4">
    <div class="col-lg-4 col-xlg-3 col-md-5">
        <div class="card">
            <div class="card-body">
                <center class="m-t-30">
                    <h4 class="card-title m-t-10">
                        {{ $contrato->paquete }}
                    </h4>
                    <h6 class="card-subtitle">
                        Adquirido:
                        {{ $contrato->diffForhumans() }}
                    </h6>
                    <h4 class="mt-2">
                        Folio:
                        <strong>
                            {{ $contrato->id }}
                        </strong>
                    </h4>
                </center>
                <center class="m-t-30">
                    <h4 class="mt-2">
                        Estatus:
                        <span class="label" style="background-color: {{ $contrato->color_estatus() }}">
                            {{ $contrato->estatus }}
                        </span>
                    </h4>
                    <p>
                        Recuerda que los folios que pueden reservaserce son los que se encuentran con estatus "Comprado"
                    </p>
                </center>
            </div>
            <div>
                <hr>
                </hr>
            </div>
            <div class="card-body">
                <small class="text-muted">
                    {{ __('messages.cliente.username') }}
                </small>
                <h6>
                    {{ $contrato->cliente->username }}
                </h6>
                <small class="text-muted p-t-10 db">
                    {{ __('messages.cliente.telefono') }}
                </small>
                <h6>
                    {{ $contrato->cliente->telefono }}
                </h6>
                <small class="text-muted p-t-10 db">
                    {{ __('messages.cliente.direccion') }}
                </small>
                <h6>
                    {{ $contrato->cliente->direccionCompleta }}
                </h6>
                <small class="text-muted p-t-10 db">
                    {{ __('messages.cliente.convenio') }}
                </small>
                <h6>
                    {{ $contrato->convenio->empresa_nombre }}
                </h6>
                <small class="text-muted p-t-10 db">
                    {{ __('messages.cliente.registrado') }}
                </small>
                <h6>
                    {{ $contrato->creado()->format('l d, F Y') }}
                </h6>
            </div>
        </div>
    </div>
    <div class="col-lg-8 col-xlg-9 col-md-7">
        <div class="card">
            <ul class="nav nav-tabs profile-tab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" data-toggle="tab" href="#home" role="tab">
                        {{ __('messages.cliente.info_paquete') }}
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#profile" role="tab">
                        {{ __('messages.cliente.historial_pagos') }}
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#settings" role="tab">
                        {{ __('messages.cliente.reservacion') }}
                    </a>
                </li>
            </ul>
            <!-- Tab panes -->
            <div class="tab-content">
                <div class="tab-pane active" id="home" role="tabpanel">
                    <div class="card-body">
                        <div class="profiletimeline">
                            <div class="sl-item">
                                <div class="sl-right">
                                    <p class="lead">
                                        {{ $contrato->paquete }}
                                    </p>
                                    <p>
                                        <strong>
                                            {{ __('messages.cliente.metodo_de_pago') }}:
                                        </strong>
                                        {{ $contrato->metodoPago() }}
                                    </p>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <p>
                                                {{ __('messages.cliente.destinos_opcionales') }}:
                                            </p>
                                            {!! $contrato->estancia->descripcion !!}
                                        </div>
                                        <div class="col-md-12">
                                            <p class="link m-r-10">
                                                <strong>
                                                    {{ __('messages.cliente.precio_de_compra') }}:
                                                </strong>
                                                <span class="text-info">
                                                    ${{ $contrato->precio_de_compra .' '. $contrato->estancia->divisa}}
                                                </span>
                                                <hr/>
                                                <strong>
                                                    {{ __('messages.cliente.pagado') }}:
                                                </strong>
                                                <span class="text-info">
                                                    ${{ $pagado }}
                                                </span>
                                            </p>
                                        </div>
                                        {{--
                                        <div class="col-md-4">
                                            <div class="card-group">
                                                <div class="card">
                                                    <div class="card-body">
                                                        <div class="row">
                                                            <div class="col-12">
                                                                <h3>
                                                                    {{ ($pagado > 0 ) ? number_format((100/$contrato->precio_de_compra)* $pagado,2) .'%' : '0%'}}
                                                                </h3>
                                                                <h6 class="card-subtitle">
                                                                    Total pagado
                                                                </h6>
                                                            </div>
                                                            <div class="col-12">
                                                                <div class="progress">
                                                                    <div aria-valuemax="100" aria-valuemin="0" aria-valuenow="25" class="progress-bar bg-success" role="progressbar" style="width:  {{ ($pagado > 0 ) ? (100/$contrato->precio_de_compra)* $pagado  : '0'}}%; height: 6px;">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        --}}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--second tab-->
                <div class="tab-pane" id="profile" role="tabpanel">
                    <div class="card-body">
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
                <div class="tab-pane" id="settings" role="tabpanel">
                    <div class="card-body">
                        @if (isset($contrato->r_reservacion[0]) && !empty($contrato->r_reservacion[0]))
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">
                                    {{ __('messages.cliente.reservacion') }}
                                </h4>
                                {{-- {{ $contrato->r_reservacion[0]->id }} --}}
                                {{-- @foreach ($contrato->reservacion as $reservacion) - --}}
                                <div class="comment-widgets">
                                    <div class="d-flex flex-row comment-row active">
                                        <div class="comment-text active w-100">
                                            <h5>
                                                Folio: {{ $contrato->r_reservacion[0]->id }}
                                            </h5>
                                            <h5>
                                                {{ $contrato->r_reservacion[0]->title }}
                                            </h5>
                                            <h5>
                                                <strong>
                                                    Nombre:
                                                </strong>
                                                {{ $contrato->r_reservacion[0]->nombre_de_quien_sera_la_reservacion }}
                                            </h5>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <p class="m-b-5">
                                                        <strong>
                                                            Paquete:
                                                        </strong>
                                                        {{ $contrato->paquete }}
                                                    </p>
                                                </div>
                                                <div class="col-md-6">
                                                    <p class="m-b-5">
                                                        <strong>
                                                            Destino:
                                                        </strong>
                                                        {{ $contrato->r_reservacion[0]->destino }}
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <p class="m-b-5">
                                                        <strong>
                                                            Fecha de ingreso:
                                                        </strong>
                                                        {{ $contrato->r_reservacion[0]->fecha_de_ingreso }}
                                                    </p>
                                                </div>
                                                <div class="col-md-6">
                                                    <p class="m-b-5">
                                                        <strong>
                                                            Fecha de salida:
                                                        </strong>
                                                        {{ $contrato->r_reservacion[0]->fecha_de_salida }}
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <p class="m-b-5">
                                                        <strong>
                                                            Hotel (opcional):
                                                        </strong>
                                                        {{ $contrato->hotel }}
                                                    </p>
                                                </div>
                                                <div class="col-md-6">
                                                    <p class="m-b-5">
                                                        <strong>
                                                            Habitaciones:
                                                        </strong>
                                                        {{ count($contrato->r_reservacion[0]->r_habitaciones) }}
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <p>
                                                        <strong>
                                                            Folios:
                                                        </strong>
                                                        @if ($con_res != false)
                                                        <ul>
                                                            @foreach ($con_res as $con)
                                                            <li>
                                                                {{ $con }}
                                                            </li>
                                                            @endforeach
                                                        </ul>
                                                        @endif
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="comment-footer ">
                                                <span class="text-muted pull-right">
                                                    {{ $contrato->r_reservacion[0]->creado()->format('l d, F Y') }}
                                                </span>
                                                <span class="label label-success">
                                                    {{ $contrato->r_reservacion[0]->estatus }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                {{-- @endforeach --}}
                            </div>
                        </div>
                        @else
                   {{--
                        <div class="card">
                            <div class="card-body">
                                --}}
                                <h4 class="card-title">
                                    {{ __('messages.cliente.reservacion') }}
                                </h4>
                                <form action="{{ route('reservaciones.store') }}" class="form-material m-t-10" id="form_reservaciones" method="post">
                                    @csrf
                                    <input id="contrato_id" name="contrato_id" type="hidden" value="{{ $contrato->id }}"/>
                                    <input id="user_temporada_alta" name="user_temporada_alta" type="hidden" value="{{ $contrato->id }}"/>
                                    <div class="row">
                                        <div class="form-group col-md-12">
                                            <label>
                                                {{ __('messages.cliente.folios') }}:
                                            </label>
                                            <select class="js-example-basic-multiple form-control" id="folio" multiple="multiple" name="folio[]">
                                                @foreach ($allContrato as $item)
                                                <option value="{{ $item['id'] }}">
                                                    {{ $item['id'] }}
                                                </option>
                                                @endforeach
                                            </select>
                                            <span class="text-danger error-folio errors">
                                            </span>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-md-12">
                                            <label for="">
                                                {{ __('messages.cliente.adquisitor') }}:
                                            </label>
                                            <input class="form-control" id="nombre_adquisitor" name="nombre_adquisitor" type="text" value="{{ $contrato->cliente->fullName }}">
                                            </input>
                                            <span class="text-danger error-nombre_adquisitor errors">
                                            </span>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>
                                                    {{ __('messages.cliente.ciudad') }}:
                                                </label>
                                                <input class="form-control" id="ciudad" name="ciudad" type="text">
                                                </input>
                                                <span class="text-danger error-ciudad errors">
                                                </span>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>
                                                    {{ __('messages.cliente.empresa') }}:
                                                </label>
                                                <input class="form-control" id="empresa" name="empresa" type="text" value="{{ $contrato->cliente->convenio->empresa_nombre }}">
                                                </input>
                                                <input class="form-control" id="convenio_id" name="convenio_id" type="hidden" value="{{ $contrato->cliente->convenio->id }}">
                                                </input>
                                            </div>
                                        </div>
                                        <div class="form-group col-md-12">
                                            <label for="titular_reservacion">
                                                {{ __('messages.cliente.nombre_reserva') }}:
                                            </label>
                                            <input class="form-control" id="titular_reservacion" name="titular_reservacion" type="text" value="{{ $contrato->cliente->fullName }}">
                                            </input>
                                            <span class="text-danger error-titular_reservacion errors">
                                            </span>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="destino">
                                                {{ __('messages.cliente.destino') }}:
                                            </label>
                                            <input class="form-control" id="destino" name="destino" type="text" value="">
                                            </input>
                                            <span class="text-danger error-destino errors">
                                            </span>
                                        </div>
                                        <div class="form-group col-md-4 ">
                                            <label for="fecha_entrada">
                                                {{ __('messages.cliente.check_int_out') }}:
                                            </label>
                                            <input class="form-control input-limit-datepicker" id="fecha" name="fecha" type="text" value=""/>
                                            <span class="text-danger error-fecha errors">
                                            </span>
                                        </div>
                                        <div class="form-group col-md">
                                            <button class="btn btn-dark btn-xs mt-4" data-target="#modalTemporadas" data-toggle="modal" type="button">
                                                Ver temporadas
                                            </button>
                                        </div>
                                        <div class="form-group col-md">
                                            <label for="adultos">
                                                {{ __('messages.cliente.adultos') }}:
                                            </label>
                                            <input class="form-control" id="adultos" name="adultos" type="text" value="{{ $contrato->estancia->adultos }}">
                                            </input>
                                            <span class="text-danger error-adultos errors">
                                            </span>
                                            <span class="help-block text-muted">
                                                <small>
                                                    {{ __('messages.cliente.menores_12') }}
                                                </small>
                                            </span>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="ninos">
                                                {{ __('messages.cliente.ninos') }}:
                                            </label>
                                            <br/>
                                            <button class="btn btn-info btn-sm" id="btnAdd" type="button">
                                                <i class="fa fa-plus">
                                                </i>
                                                {{ __('messages.cliente.agregar') }}
                                            </button>
                                            <div class="row">
                                                <div class="col-md-8">
                                                    <table class="table" id="dynamic_field">
                                                        <tbody>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                            <span class="help-block text-muted">
                                                <small>
                                                    {{ __('messages.cliente.menores_12') }}
                                                </small>
                                            </span>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="junior">
                                                {{ __('messages.cliente.juniors') }}:
                                            </label>
                                            <br/>
                                            <button class="btn btn-info btn-sm" id="btnAddJ" type="button">
                                                <i class="fa fa-plus">
                                                </i>
                                                {{ __('messages.cliente.agregar') }}
                                            </button>
                                            <div class="row">
                                                <div class="col-md-8">
                                                    <table class="table" id="dynamic_field2">
                                                        <tbody>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label>
                                                {{ __('messages.cliente.precio') }}:
                                            </label>
                                            <input class="form-control form-control-line" id="precio_paquete" name="precio_paquete" readonly="" type="text" value="${{ number_format($contrato->precio_de_compra,2) }}">
                                            </input>
                                            <span class="text-danger error-precio_paquete errors">
                                            </span>
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label>
                                                {{ __('messages.cliente.plan') }}:
                                            </label>
                                            <input class="form-control form-control-line" id="plan" name="plan" type="text" value="{{ $contrato->tipo_plan() }}">
                                            </input>
                                            <span class="text-danger error-plan errors">
                                            </span>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            <label>
                                                {{ __('messages.cliente.telefono') }}:
                                            </label>
                                            <input class="form-control form-control-line" id="telefono" name="telefono" placeholder="1234567890" type="text" value="{{ $contrato->cliente->telefono }}">
                                            </input>
                                            <span class="text-danger error-telefono errors">
                                            </span>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label>
                                                {{ __('messages.cliente.username') }}:
                                            </label>
                                            <input class="form-control form-control-line" id="correo" name="correo" type="email" value="{{ $contrato->cliente->username }}">
                                            </input>
                                            <span class="text-danger error-correo errors">
                                            </span>
                                        </div>
                                        <div class="form-group col-md-12">
                                            <label>
                                                {{ __('messages.cliente.observaciones') }}:
                                            </label>
                                            <textarea class="form-control" id="comentario" name="comentario" rows="5">
                                            </textarea>
                                            <span class="text-danger error-comentarios errors">
                                            </span>
                                        </div>
                                        <div class="col-md-12">
                                            <button class="btn btn-info" disabled="" id="btnSubmit" type="submit">
                                                <i class="fa fa-paper-plane">
                                                </i>
                                                {{ __('messages.cliente.enviar') }}
                                            </button>
                                        </div>
                                    </div>
                                </form>
                                {{--
                            </div>
                        </div>
                        --}}
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Column -->
</div>
<!-- Modal -->
<div aria-hidden="true" aria-labelledby="modalTemporadasTitle" class="modal fade" id="modalTemporadas" role="dialog" tabindex="-1">
    <div class="modal-dialog modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">
                    Fechas de temporadas
                </h5>
                <button aria-label="Close" class="close" data-dismiss="modal" type="button">
                    <span aria-hidden="true">
                        ×
                    </span>
                </button>
            </div>
            <div class="modal-body table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>
                                Temporada
                            </th>
                            <th>
                                Fechas
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data_temp as $temp)
                        @php
                            $color = ($temp['temporada'] == 'ALTA') ? 'danger' : 'success';
                        @endphp
                        <tr class="table-{{ $color }}">
                            <td>
                                {{ $temp['temporada'] }}
                            </td>
                            <td>
                                {{ $temp['fecha'] }}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                {{-- {{ $data_temp }} --}}
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

@section('script')
<script>
    $(document).ready(function() {
        var ninos = 1;
        var juniors = 1;
        var endDays = 1;
        var contrato = @json($contrato);
        var noches = contrato['estancia']['noches'];
        var table;
        var num_folios = 1;
        var intentos = 0;
        const temp_baja = 30;
        const temp_alta = 60;
        var f1 = moment().format('DD/MM/YYYY');

        // var f2='30/07/2022';
        // console.log(f1,f2, restaFechas(f1, f2));

        $('#folio').select2();

        $('#fecha').daterangepicker({
            autoUpdateInput: true,
            locale: {
                format: 'YYYY-MM-DD',
                separator: ' al ',
                applyLabel: 'Aplicar',
                cancelLabel: 'Cancelar',
                fromLabel: 'Desde',
                toLabel: 'Hasta',
                customRangeLabel: 'Personalizado',
                weekLabel: 'W',
                daysOfWeek: ['Dom', 'Lun', 'Mar', 'Mié', 'Jue', 'Vie', 'Sáb'],
                monthNames: [
                    'Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'
                ],
                firstDay: 1
            }
        });

        $("#folio").change(function (e) {
            num_folios = $(this).val().length;
            e.preventDefault();
            $('#fecha').daterangepicker({
                startDate: starrDate(),
                minDate: starrDate(),
                endDate: starrDate().add(noches * num_folios, 'days'),
                dateLimit: {
                    days: noches * num_folios
                },
                autoUpdateInput: true,
                locale: {
                    format: 'YYYY-MM-DD',
                    separator: ' al ',
                    applyLabel: 'Aplicar',
                    cancelLabel: 'Cancelar',
                    fromLabel: 'Desde',
                    toLabel: 'Hasta',
                    customRangeLabel: 'Personalizado',
                    weekLabel: 'W',
                    daysOfWeek: ['Dom', 'Lun', 'Mar', 'Mié', 'Jue', 'Vie', 'Sáb'],
                    monthNames: [
                        'Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'
                    ],
                    firstDay: 1
                }

            });

        });


        var cont = 0;

        table =  $('#table_pagos').DataTable({
            order: ([0, 'asc']),
            lengthMenu: [[5, 10, 25, 50, -1], [5, 10, 25, 50, "Todo"]],
            pageLength: 10,
            searching: false,
            destroy: true,
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
                            return '<label class="label label-success">{{ __('messages.cliente.pagado') }}</label>';
                                break;
                            case 'Por Pagar':
                            return '<label class="label label-warning">{{ __('messages.cliente.pendiente') }}</label>';
                                break;
                            default:
                            return '<label class="label label-danger">{{ __('messages.user.show.rechazados') }}</label>';
                                break;
                        }
                    }
                },
            ],
            "ajax": {
                url: baseuri + "cliente/obtener-pagos/"+ {{ $contrato->id }},
                type: "get",
                dataType: "json",
                error: function(e) {
                  toastr['error'](e.responseText);
                }
            },
        });



        $('body').on('click', '#btnAdd', function(event) {
            event.preventDefault();
            cont++;
            if (ninos <= 5) {
                $('#dynamic_field').append('<tr id="row' + cont + '"><td><input class="form-control" id="edad_nino' + cont + '" min="1" name="edad_nino[]" pattern="^[0-9]+" type="text"  placeholder="Edad" style="width: 100%;" required/></td><td><button type="button" name="remove" id="' + cont + '" class="btn btn-danger btn_remove btn-sm"><span class="fa fa-trash"></span></button></td></tr>');
                 ninos++;
            }else {
                toastr['warning']('Cupo excedido para niños.');
            }
        });

         $(document).on('click', '.btn_remove', function() {
            var button_id = $(this).attr("id");
            ninos = ninos - 1;
            $('#dynamic_field #row' + button_id + '').remove();
        });


        $('body').on('click', '#btnAddJ', function(event) {
            event.preventDefault();
            cont++;
            if (juniors <= 5) {
                $('#dynamic_field2').append('<tr id="row' + cont + '"><td><input class="form-control" id="edad_junior' + cont + '" min="1" name="edad_junior[]" pattern="^[0-9]+" type="text"  placeholder="Edad" style="width: 100%;" required/></td><td><button type="button" name="remove" id="' + cont + '" class="btn btn-danger btn_remove2 btn-sm"><span class="fa fa-trash"></span></button></td></tr>');
                 juniors++;
            }else {
                toastr['warning']('Cupo excedido para junios.');
            }
        });

        $(document).on('click', '.btn_remove2', function() {
            var button_id = $(this).attr("id");
            juniors = juniors - 1;
            $('#dynamic_field2 #row' + button_id + '').remove();
        });


        $('#form_reservaciones').submit(function(event) {
            event.preventDefault();
            $.ajax({
                url: $(this).attr('action'),
                type: $(this).attr('method'),
                dataType: 'json',
                data: $(this).serialize(),
                beforeSend:function(){
                    $("#overlay").css("display", "block");
                    $('#btnSubmit').prop('disabled', true);
                },
                success:function(res){
                    if (res.success == false) {
                        pintar_errores(res.errors);
                        $('#btnSubmit').prop('disabled', false);
                    }
                    if (res.success == true) {
                        toastr['success']('Registro exitoso.');
                        $('#form_reservaciones').trigger('reset');
                        location.reload();
                    }else{
                        toastr['error']('Hubo un error al ingresar la reservacion.');
                        $('#btnSubmit').prop('disabled', false);
                    }
                }
            })
            .fail(function(){
                 $('#btnSubmit').prop('disabled', false);
            })
            .always(function() {
                $("#overlay").css("display", "none");
            });

        });




        $('#fecha').on('change', function(event) {
            event.preventDefault();
            $.ajax({
                url: "{{ route('get_temporadas') }}",
                type: 'GET',
                dataType: 'JSON',
                data: {
                    fecha: $('#fecha').val(),
                    contrato_id: contrato.id
                },
                success:function(res){
                    if (res.flag != true) {
                        $('#btnSubmit').prop('disabled', true);
                        if (intentos > $('#folio').val().length) {
                            if (res.temporada == 'ALTA' && res.dias_diferencia < res.dias_temp) {

                                alertify.alert('Alerta', 'Ha seleccionado fechas de temporada alta, para poder continuar le recordamos que para reservar en fechas de temporada alta debe realizarse con 60 días de anticipación <br/><button class="btn btn-dark btn-xs" data-target="#modalTemporadas" data-toggle="modal">Ver temporadas</button>', function(){});


                            }else if(res.temporada == 'ALTA' && res.dias_diferencia > res.dias_temp){

                                alertify.alert('Esta seleccionando fechas en temporada alta', '¿Desea continuar?, se realizara un ajuste por temporada', function(){
                                    $('#btnSubmit').prop('disabled', false);
                                });

                            }else{
                                $('#btnSubmit').prop('disabled', false);
                            }
                        }
                    }else{
                        $('#btnSubmit').prop('disabled', false);
                    }
                }
            })
            .always(function() {
            });
            console.log(intentos);

            intentos++;
            if (intentos == 5) {
                $('#modalTemporadas').modal('show');
                intentos = 0;
            }
        });
    });


    function starrDate () {
        switch ('{{ $contrato->tipo_temporada() }}') {
            case "ALTA":
            case "MEDIA":
                var startDate = moment().add(60, 'days');
                break;
            case "BAJA":
                var startDate = moment().add(30, 'days');
                break;
        }
        return startDate;
    };


    restaFechas = function(f1,f2)
    {
        var aFecha1 = f1.split('/');
        var aFecha2 = f2.split('/');
        var fFecha1 = Date.UTC(aFecha1[2],aFecha1[1]-1,aFecha1[0]);
        var fFecha2 = Date.UTC(aFecha2[2],aFecha2[1]-1,aFecha2[0]);
        var dif = fFecha2 - fFecha1;
        var dias = Math.floor(dif / (1000 * 60 * 60 * 24));
        return dias;
    }
</script>
@endsection
