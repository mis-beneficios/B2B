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
                    {{-- <button class="btn btn-info btn-xs" data-target="#modalUnlock" data-toggle="modal" style="color: white;">
                        <i class="fas fa-unlock-alt">
                        </i>
                        Desbloquear
                    </button> --}}
                    @if (Auth::user()->can('show_cards', App\Tarjeta::class))
                    @if (!session('unlock_cards'))
                        <button class="btn btn-dark btn-sm" data-target="#modalDesCard" data-toggle="modal" style="color: white;">
                            <i class="fas fa-unlock-alt">
                            </i>
                            Desbloquear tarjetas
                        </button>
                    @endif
                    @endif
                </div>
                <h4 class="card-title m-b-0">
                    Filtrado Terminal V3
                </h4>
            </div>
            <div class="card-body">
                <form action="{{ route('cobranza.index') }}" id="formTerminal" method="GET">
                    @csrf
                    <div class="row">
                        <div class="col-md-4">
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="inputEmail4">
                                        Inicio del rango
                                    </label>
                                    <input autocomplete="off" class="form-control datepicker" id="fecha_inicio" name="fecha_inicio" type="text" value="{{ (request('fecha_inicio') == null) ? date('Y-m-d') : request('fecha_inicio') }}">
                                        <span class="text-danger error-titular errors">
                                        </span>
                                    </input>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="inputPassword4">
                                        Fin del rango
                                    </label>
                                    <input autocomplete="off" class="form-control datepicker" id="fecha_fin" name="fecha_fin" type="text" value="{{ (request('fecha_fin') == null) ? date('Y-m-d') : request('fecha_fin') }}">
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
                                <label class="btn btn-inverse btn-sm {{ isset(request()->nomina)  ? 'active' : ''}}">
                                    <input name="nomina" id="nomina" type="checkbox" {{ isset(request()->nomina)  ? 'checked' : ''}}>
                                        Nomina
                                    </input>
                                </label>
                                <label class="btn btn-inverse btn-sm{{ isset(request()->terminal) ? 'active' : '' }}">
                                    <input name="terminal" id="terminal" type="checkbox" {{ isset(request()->terminal) ? 'checked' : '' }}>
                                        Terminal
                                    </input>
                                </label>
                                <label class="btn btn-inverse btn-sm {{ isset(request()->viaserfin) ? 'active' : '' }}">
                                    <input name="viaserfin" id="viaserfin" type="checkbox" {{ isset(request()->viaserfin) ? 'checked' : '' }}>
                                        Via Serfin
                                    </input>
                                </label>
                                <label class="btn btn-inverse btn-sm {{ isset(request()->cobro_int) ? 'active' : '' }}">
                                    <input name="cobro_int" id="cobro_int" type="checkbox" {{ isset(request()->cobro_int) ? 'checked' : '' }}>
                                        Cobro Int
                                    </input>
                                </label>
                            </div>
                            <h5 class="card-title mb-2 mt-2">
                                Estatus de pago:
                            </h5>
                            <div class="btn-group" data-toggle="buttons">
                                <label class="btn btn-inverse btn-sm {{ isset(request()->pagosRechazados) ? 'active' : '' }}">
                                    <input  name="pagosRechazados" id="pagosRechazados" type="checkbox" {{ isset(request()->pagosRechazados) ? 'checked' : '' }}>
                                        Rechazados
                                    </input>
                                </label>
                                <label class="btn btn-inverse btn-sm {{ isset(request()->pagosPagados) ? 'active' : '' }}">
                                    <input  name="pagosPagados" id="pagosPagados" type="checkbox" {{ isset(request()->pagosPagados) ? 'checked' : '' }}>
                                        Pagados
                                    </input>
                                </label>
                                <label class="btn btn-inverse btn-sm {{ isset(request()->pagosPendientes) ? 'active' : '' }}">
                                    <input name="pagosPendientes" id="pagosPendientes" type="checkbox" {{ isset(request()->pagosPendientes) ? 'checked' : '' }}>
                                        Pendientes
                                    </input>
                                </label>
                                <label class="btn btn-inverse btn-sm {{ isset(request()->pagosAnomalías) ? 'active' : '' }}">
                                    <input  name="pagosAnomalías" id="pagosAnomalías" type="checkbox" {{ isset(request()->pagosAnomalías) ? 'checked' : '' }}>
                                        Anomalías
                                    </input>
                                </label>
                            </div>
                            <h5 class="card-title mb-2 mt-2">
                                Tipo de tarjeta:
                            </h5>
                            <select name="tipo_tarjeta" id="tipo_tarjeta" class="form-control select2 select2-hidden-accessible m-b-10" style="width: 100%">
                                <option value="">Sin segmentar</option>
                                <option value="Credito" {{ request()->tipo_tarjeta == 'Credito' ? 'selected' : '' }}>Credito</option>
                                <option value="Debito" {{ request()->tipo_tarjeta == 'Debito' ? 'selected' : '' }}>Debito</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <h5 class="card-title mb-2 mt-2">
                                Pais
                            </h5>
                            <select name="paise_id" id="paise_id" class="form-control select2 select2-hidden-accessible m-b-10" style="width: 100%">
                                <option value="">Sin fintro</option>
                                @foreach ($paises as $pais)
                                    <option value="{{ $pais->id }}" {{ ($pais->id == request()->paise_id || $pais->id == 1) ? 'selected' : '' }} > {{ $pais->title }}</option>
                                @endforeach
                            </select>
                            <h5 class="card-title mb-2 mt-2">
                                Convenio
                            </h5>
                            <select name="convenio_id[]" multiple="multiple" id="convenio_id" class="form-control select2 select2-hidden-accessible" style="width: 98%;">
                                <option value="">Sin fintro</option>
                                @foreach ($convenios as $convenio)
                                    @if (request()->convenio_id)
                                        @foreach (request()->convenio_id as $con)
                                            <option value="{{ $convenio->id }}" {{ $convenio->id == $con ? 'selected' : '' }}> {{ $convenio->empresa_nombre }}</option>
                                        @endforeach
                                    @else
                                        <option value="{{ $convenio->id }}"> {{ $convenio->empresa_nombre }}</option>

                                    @endif
                                   
                                @endforeach
                            </select>
                    
                        </div>
                    </div>
                    <div class="row ml-auto">
                        <div class="float-right">
                            <button class="btn btn-dark btn-sm" type="submit">
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
                <table class="table table-hover" id="tableTerminal">
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
                    <tbody>
                        @foreach ($datos as $pago)
                            <tr>
                                <td>
                                    <span class="text-capitalize"><button type="button" id="btnPago" data-pago_id="{{$pago->id}}"  data-index="' . $index . '" data-user_id="{{$pago->user_id}}"  data-contrato_id="{{$pago->contrato_id}}" class="btn btn-dark btn-xs">Segmento: {{$pago->segmento}}</button> </span><br/><small>{{$pago->id}}</small>
                                </td>
                                <td>
                                    <span><a class="" href="{{route('users.show', $pago->contrato->user_id)}}" target="_blank"> # {{$pago->contrato->id}}</a><br/>{{$pago->contrato->sys_key}}</span>
                                </td>
                                <td>
                                    <span>
                                        <a class="" href="{{route('users.show', $pago->contrato->user_id)}}" target="_blank">{{($pago->contrato->cliente) ? $pago->contrato->cliente->fullName : 'S/R'}}</a> <br>{{$pago->contrato->convenio->empresa_nombre}}
                                    </span>
                                </td>
                                <td>
                                    <span id="cantidadPago{{$pago->id}}">{{$pago->contrato->divisa . number_format($pago->cantidad, 2)}}</span><br/><small>De:  {{$pago->contrato->divisa . number_format($pago->contrato->precio_de_compra, 2)}} </small>
                                </td>
                                <td>
                                    <button class="btn btn-xs btn-{{$pago->color_estatus()}}  btnMostratPagos estatusPago{{$pago->id}}"  data-id="all"  id="estatusPago{{$pago->id}}" value="{{$pago->contrato_id}}">{{$pago->estatus}}
                                    </button>
                                    <br/>
                                    <small>{!!$pago->motivo_rechazo()!!}</small>
                                </td>
                                <td>
                                    @if ($pago->contrato->tarjeta)
                                        <span>{{ $pago->contrato->tarjeta->numeroTarjeta }}</span><br><small>{{ $pago->contrato->tarjeta->vence }} |  {{ $pago->contrato->tarjeta->verCvv }}</small><br><small>{{ $pago->contrato->tarjeta->tipo }} | {{ $pago->contrato->tarjeta->r_banco->title }}</small>
                                    @else
                                        S/R
                                    @endif
                                </td>
                                <td>
                                    <span id="fechaCobro{{$pago->id}}">{{$pago->fecha_de_cobro}}</span><br/><small id="fechaPago{{$pago->id}}">{{$pago->fecha_de_pago}}</small>
                                </td>
                                <td>
                                    <button class="btn btn-success btn-xs mr-1" value="{{$pago->id}}" data-pago_id="{{$pago->id}}" data-contrato_id="{{$pago->contrato->contrato_id}}" id="btnEditarPago" type="button"><i class="fas fa-edit"></i></button>

                                    <button class="btn btn-info btn-xs mr-1" data-pago_id="{{$pago->id}}"  data-contrato_id="{{$pago->contrato->contrato_id}}" id="btnMetodoPago" data-route="{{route('contrato.show_metodo_pago', $pago->contrato->id)}}" type="button"><i class="fas fa-arrows-alt-h"></i></button>

                                    {{-- <button class="btn btn-dark btn-xs" data-pago_id="{{$pago->id}}"  data-contrato_id="{{$pago->contrato->id}}" id="btnUpdate" type="button"><i class="fas fa-cog"></i></button> --}}
                                </td>
                            </tr>
                            <tr>
                                <td colspan="7">
                                    <div id="paginator3" class="datepaginator-sm">
                                        <ul class="list-unstyled list-inline">
                                            @foreach ($pago->contrato->pagos_contrato as $cp)      
                                                <li class="mytooltip  btn btn-{{$cp->color_estatus()}} {{ ($cp->id == $pago->id) ? ' active' : '' }}">
                                                    <a href="#" class="text-white"  title="{{$cp->segmento .' | '. $cp->fecha_de_cobro .' | '. number_format($cp->cantidad,2,'.','')}}" style="width: 35px;">{{$cp->segmento}}
                                                    </a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </td> 
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ $datos->links() }}
                <p>Mostrando {{ $datos->firstItem() }} a {{ $datos->lastItem() }} de {{ $datos->total() }} registros</p>
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


        document.getElementById('overlay').style.display = 'none';

        document.getElementById('formTerminal').addEventListener('submit', function() {
            document.getElementById('overlay').style.display = 'block';
        });

        $('#cobro_int').on('change', function(event) {
            event.preventDefault();
            if ($(this).is(':checked')) {
               
                Toast.fire({
                    icon:'info',
                    title:'Solo se filtraran folios cobrados con divisa USD, no se podra realizar filtrado mediante los metodos de compra',
                });
                $('#nomina').attr('disabled', true);
                $('#terminal').attr('disabled', true);
                $('#viaserfin').attr('disabled', true);
            }else{
                Toast.fire({
                    icon:'info',
                    title:'Ahora puede filtrar por metodo de compra',
                });
                $('#nomina').removeAttr('disabled');
                $('#terminal').removeAttr('disabled');
                $('#viaserfin').removeAttr('disabled');

            }
        });

        $('.custom-select').select2();
        var tabla_pagos;


        $('.datepicker').bootstrapMaterialDatePicker({
            weekStart: 0,
            time: false,
            lang: 'es',
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
        


        $('body #fecha_de_cobro').datepicker({
            dateFormat: "yy-mm-dd",
            autoclose:true,
            language: 'es',
            orientation: 'bottom',
        });
        $('body #fecha_de_pago').datepicker({
            dateFormat: "yy-mm-dd",
            autoclose:true,
            language: 'es',
            orientation: 'bottom',
        });

        $('body').on('submit', '#formUnlock', function(event) {
            event.preventDefault();
            $.ajax({
                url: $(this).attr('action'),
                type: $(this).attr('method'),
                dataType: 'json',
                data: $(this).serialize(),
                beforeSend:function(){
                    $("#overlay").css("display", "block");
                },
                success:function(res){
                    if (res.success == true) {
                        Toast.fire({
                            icon:'info',
                            title:'Tarjetas desbloqueadas, los datos se mostraran hasta que se finalice la sesion'
                        });
                        window.location.reload();
                    }else{
                        Toast.fire({
                            icon:'error',
                            title:'Contraseña incorrecta'
                        });
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
                    alertify.confirm('Autorizar pago', '¿Desea autorizar el pago: ' + pago_id, 
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
            var pago_id = $('#pago_id').val();
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
                    $('#tableTerminal #estatusPago'+pago_id).html('Rechazado');
                    $('#tableTerminal #estatusPago'+pago_id).removeClass('btn-inverse btn-danger btn-success');
                    $('#tableTerminal #estatusPago'+pago_id).addClass('btn-danger');
                    $('#tableTerminal #statusPago'+pago_id).addClass('btn-danger');
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
                beforeSend:function(){
                    $("#overlay").css("display", "block");
                },
                success:function(res){
                    if(res.success){
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

        $('body').on('submit', '#form_editar_metodo_pago', function (event) {
            event.preventDefault();
            $.ajax({
                url: $(this).attr('action'),
                type: $(this).attr('method'),
                dataType: 'json',
                data: $(this).serialize(),
                beforeSend:function(){
                    $("#overlay").css("display", "block");
                },
                success:function(res){
                    if (res.success == true) {
                        $('#modalGeneral').modal('hide');
                        tabla_contratos.ajax.reload();
                        // window.location.reload();
                        toastr['success']('{{ __('messages.alerta.success') }}');
                    }else{
                        toastr['error']('No se pudieron aplicar los cambios, intentelo mas tarde');
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
                url: baseadmin + 'pagos/'+pago_id +'/edit',
                type: 'GET',
                dataType: 'JSON',
                beforeSend:function(){
                    $("#overlay").css("display", "block");
                },
                success:function(res){
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
                beforeSend:function(){
                    $("#overlay").css("display", "block");
                },
                success:function(res){
                    console.log(res);
                    if (res.success == false) {
                        pintar_errores(res.errors)
                    }else{
                        $('#tableTerminal #estatusPago'+pago_id).removeClass('btn-inverse btn-danger btn-success');
                        $('#tableTerminal #statusPago'+pago_id).removeClass('btn-inverse btn-danger btn-success');
                        if (res.pago.estatus == 'Por Pagar') {
                            $('#tableTerminal #estatusPago'+pago_id).addClass('btn-inverse');
                            $('#tableTerminal #statusPago'+pago_id).addClass('btn-inverse');
                        }else if(res.pago.estatus == 'Pagado'){
                            $('#tableTerminal #estatusPago'+pago_id).addClass('btn-success');
                            $('#tableTerminal #statusPago'+pago_id).addClass('btn-success');
                        }else if(res.pago.estatus == 'Rechazado'){
                            $('#tableTerminal #estatusPago'+pago_id).addClass('btn-danger');
                            $('#tableTerminal #statusPago'+pago_id).addClass('btn-danger');
                        }else{
                            $('#tableTerminal #estatusPago'+pago_id).addClass('btn-inverse');
                            $('#tableTerminal #statusPago'+pago_id).addClass('btn-inverse');
                        }
                        $('#tableTerminal #estatusPago'+pago_id).html(res.pago.estatus);

                        // $('#tableTerminal #cantidadPago'+pago_id).html('');
                        $('#tableTerminal #cantidadPago'+pago_id).html('MXN' + res.pago.cantidad);
                        
                        $('#tableTerminal #fechaCobro'+pago_id).html(res.pago.fecha_de_cobro);
                        
                        if (res.pago.estatus == 'Pagado' || res.pago.estatus == 'Rechazado') {
                            $('#tableTerminal #fechaPago'+pago_id).html(res.pago.fecha_de_pago);
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
                            // tabla_pagos.ajax.reload();
                            $('#tableTerminal').DataTable().ajax.reload();
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

        $('body').on('click', '.btnMostratPagos', function(event) {
            event.preventDefault();
            var contrato_id = $(this).val();
            var tipo = $(this).data('id');

            listar_pagos(tabla_pagos, contrato_id, tipo);
        });


    
    });

    function listar_pagos(tabla_pagos, contrato_id, tipo){
        $.ajax({
            url: baseuri + 'admin/listar-pagos-contrato/'+contrato_id + '/'+ tipo,
            type: 'get',
            dataType: 'json',
            beforeSend:function(){
                $("#overlay").css("display", "block");
            },
            success:function(res){
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
                    },{
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
            beforeSend:function(){
                 $("#overlay").css("display", "block");
            },
            success:function(res){
                if(res.success == true){
                    // toastr['success']('¡Pago autorizado!');
                    Toast.fire({
                        icon:'success',
                        title: '¡Pago autorizado!'
                    });
                    $('#modalGeneral').modal('hide');
                    $('#tableTerminal #estatusPago'+pago_id).html('Pagado');
                    $('#tableTerminal #estatusPago'+pago_id).removeClass('btn-inverse btn-danger btn-success');
                    $('#tableTerminal #estatusPago'+pago_id).addClass('btn-success');
                    $('#tableTerminal #statusPago'+pago_id).addClass('btn-success');
                    // tabla_pagos.ajax.reload();
                    // $('#tableTerminal').DataTable().ajax.reload();
                }else{
                    // toastr['error']('¡Inténtalo mas tarde!')
                    Toast.fire({
                        icon:'error',
                        title: 'No se pudo autoriazar el pago '+ pago_id +'!'
                    });
                }
            }
        })
        .always(function() {
             $("#overlay").css("display", "none");
        });
    }

  
</script>

@stop
