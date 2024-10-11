@extends('layouts.admin.app')
@section('content')
<style>
    .span_blocks{

    }
    #table_ejecutivos{

    }
</style>
<div class="row page-titles">
    <div class="col-md-5 col-10 align-self-center">
        <h3 class="text-themecolor">
            Creacion de reservacion para el usuario:
            <b>
                <em class="text-uppercase">
                    {{ $user->fullName }}
                </em>
            </b>
        </h3>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('dashboard') }}">
                    Home
                </a>
            </li>
            <li class="breadcrumb-item active">
                Reservación
            </li>
        </ol>
    </div>
</div>
<form action="{{ route('reservations.store') }}" id="formAddReservacion" method="post">
    @csrf
    <div class="card">
        <div class="card-header">
            <div class="card-actions">
                <button class="btn btn-primary" type="submit">
                    Guardar
                </button>
            </div>
            <h4 class="card-title m-b-0">
                Nueva reservación
            </h4>
        </div>
        <div class="row">
            <div class="col-md-4">
                <input id="user_id" name="user_id" type="hidden" value="{{ $user->id }}"/>
                <div class="modal-body" id="modal-body">
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label for="inputEmail4">
                                Nombre a quien sera la reservación
                            </label>
                            <div class="input-group mb-3">
                                <input class="form-control" id="titular" name="titular" placeholder="Titular" type="text">
                                    <button class="btn btn-outline-secondary btn-xs" id="btnAddName" type="button">
                                        importar nombre
                                    </button>
                                </input>
                            </div>
                            <span class="text-danger error-titular errors">
                            </span>
                        </div>
                         <div class="form-group col-md-8">
                            <label for="inputEmail4">
                               Correo electrónico
                            </label>
                            <div class="input-group mb-3">
                                <input class="form-control" id="email" name="email" placeholder="Correo electronico" type="text">
                                    <button class="btn btn-outline-secondary btn-xs" id="btnAddEmail" type="button">
                                        importar correo
                                    </button>
                                </input>
                            </div>
                            <span class="text-danger error-email errors">
                            </span>
                        </div>
                         <div class="form-group col-md-4">
                            <label for="inputEmail4">
                                Teléfono
                            </label>
                            <div class="input-group mb-3">
                                <input class="form-control" id="telefono" name="telefono" placeholder="Telefono" type="text">
                                    <button class="btn btn-outline-secondary btn-xs" id="btnAddTelefono" type="button">
                                        importar teléfono
                                    </button>
                                </input>
                            </div>
                            <span class="text-danger error-telefono errors">
                            </span>
                        </div>
                        <div class="form-group col-md-7">
                            <label for="inputPassword4">
                                Destino
                            </label>
                            <input class="form-control" id="destino" name="destino" type="text">
                            </input>
                            <span class="text-danger error-destino errors">
                            </span>
                        </div>
                        <div class="form-group col-md-5">
                            <label for="inputPassword4">
                                Fechas
                            </label>
                            <input class="form-control input-limit-datepicker" id="fechas" name="fechas" type="text">
                            </input>
                            <span class="text-danger error-fechas errors">
                            </span>
                        </div>
                        <div class="form-group col-md-12">
                            <label for="inputEmail4">
                                Estancia
                            </label>
                            <select class="js-example-responsive js-states form-control select2" id="estancia_id" name="estancia_id">
                                @foreach ($estancias as $estancia)
                                <option value="{{ $estancia->id }}">
                                    {{ $estancia->title }}
                                </option>
                                @endforeach
                            </select>
                            <span class="text-danger error-estancia errors">
                            </span>
                        </div>
                    </div>
                    <div class="form-row">
                        {{--
                        <div class="form-group col-md-4">
                            <label for="inputPassword4">
                                Habitaciones
                            </label>
                            <input class="form-control" id="habitaciones" name="habitaciones" placeholder="" type="text">
                            </input>
                            <span class="text-danger error-habitaciones errors">
                            </span>
                        </div>
                        --}}
                        <div class="form-group col-md-6">
                            <label for="inputPassword4">
                                Región
                            </label>
                            <select class="js-example-responsive js-states form-control " id="regione_id" name="regione_id">
                                <option value="1">
                                    México General
                                </option>
                                <option value="7">
                                    Estados Unidos General
                                </option>
                            </select>
                            <span class="text-danger error-regione_id errors">
                            </span>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="inputPassword4">
                                Tarjeta
                            </label>
                            <select class="js-example-responsive js-states form-control " id="tarjeta_id" name="tarjeta_id">
                                @foreach ($tarjetas as $tarjeta)
                                <option value="{{ $tarjeta->id }}">
                                    {{ $tarjeta->numeroTarjeta }}
                                </option>
                                @endforeach
                            </select>
                            <span class="text-danger error-tarjeta_id errors">
                            </span>
                        </div>
                        <div class="form-group col-lg-6 col-md-6">
                            <label for="tipo_reserva">
                                Tipo de reservación:
                            </label>
                            <select class="form-control" id="tipo_reserva" name="tipo_reserva">
                                <option>
                                    Seleccione una opción
                                </option>
                                @foreach ($tipo_reservacion as $tipo => $val)
                                <option value="{{ $tipo }}">
                                    {{ $val }}
                                </option>
                                @endforeach
                            </select>
                            <span class="text-danger error-tipo_reserva errors">
                            </span>
                        </div>
                        <div class="form-group col-lg-6 col-md-6 ">
                            <label for="region">
                                Región:
                            </label>
                            <select class="form-control" name="regione_id">
                                <option>
                                    Selecciona una opción
                                </option>
                                @foreach ($regiones as $region => $val)
                                <option value="{{ $val }}">
                                    {{ $region }}
                                </option>
                                @endforeach
                            </select>
                            <span class="text-danger error-region errors">
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <label class="mt-3" for="">
                    Folios
                </label>
                <table class="table">
                    @foreach ($contratos as $contrato)
                                @php
                                    $contratoVinculado = 0;
                                    $montoPagado = 0;
                                @endphp
                                 {{-- {{ $contrato->sum_pagos_concretados() }} --}}
                    <tr>
                        <td>
                            {{ $contrato->id }}
                            <br/>
                            <small>
                                {{ $contrato->paquete }}
                            </small>
                        </td>
                        <td>
                            {{ $contrato->noches }} N
                                    {{ $contrato->adultos }} A
                                    {{ $contrato->ninos }} K
                                    {{ $contrato->juniors }} K
                        </td>
                        <td>
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <input name="contrato_id[]" type="checkbox" value="{{ $contrato->id }}">
                                    </input>
                                </span>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="3">
                            <span class="text-uppercase">
                                {{ $contrato->metodo_de_pago() }}
                            </span>
                            (Pend. ${{ number_format($contrato->precio_de_compra - $contrato->sum_pagos_concretados(),2) }} de ${{ number_format($contrato->precio_de_compra,2) }} :  {{ round(($contrato->sum_pagos_concretados() / $contrato->precio_de_compra) * 100, 2) }}%)
                        </td>
                    </tr>
                    @endforeach
                </table>
            </div>
            <div class="col-md-4">
                <button class="btn btn-info btn-sm mt-4 mb-4" id="addHabitacion" type="button">
                    <i class="fas fa-plus">
                    </i>
                    Agregar Habitacion
                </button>
                <div class="row">
                    <div class="col-md-6">
                        <div id="contenidoH">
                            <div class="row">
                                <div class="col-md-12">
                                    <p>
                                        Habitacion 1
                                    </p>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="adultos">
                                        Adultos
                                    </label>
                                    <input class="form-control" id="adultos" name="adultos" type="text" value="">
                                    </input>
                                    <span class="text-danger error-adultos errors">
                                    </span>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="noches">
                                        Noches
                                    </label>
                                    <input class="form-control" id="noches" name="noches" type="text" value="">
                                    </input>
                                    <span class="text-danger error-noches errors">
                                    </span>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="ninos">
                                        Niños:
                                    </label>
                                    <br/>
                                    <button class="btn btn-info btn-sm btnAdd" data-cantidad-row="" data-field="dynamic_field_" id="btnAdd" type="button">
                                        <i class="fa fa-plus">
                                        </i>
                                        Agregar
                                    </button>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <table class="table" id="dynamic_field_">
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
                                    <button class="btn btn-info btn-sm" data-field="dynamic_field_j" id="btnAddJ" type="button">
                                        <i class="fa fa-plus">
                                        </i>
                                        {{ __('messages.cliente.agregar') }}
                                    </button>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <table class="table" id="dynamic_field_j">
                                                <tbody>
                                                    {{-- @for ($i = 1; $i <= $habitacion->juniors ; $i++)
                                                @php
                                                    $junior = "edad_junior_$i";
                                                @endphp
                                                    <tr id="row{{ $i }}">
                                                        <td>
                                                            <input class="form-control" id="edad_junior{{ $i }}" min="1" name="edad_junior{{ $cont }}[]" pattern="^[0-9]+" placeholder="Edad" required="" style="width: 100%;" type="text" value="{{ $habitacion[$junior] }}"/>
                                                        </td>
                                                        <td>
                                                            <button class="btn btn-danger btn_remove2 btn-sm" data-field="dynamic_field_j{{ $cont }}" id="{{ $i }}" name="remove" type="button">
                                                                <span class="fa fa-trash">
                                                                </span>
                                                            </button>
                                                        </td>
                                                    </tr>
                                                    @endfor --}}
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{--
        <div class="row">
            <div class="col-md-4">
                <div class="modal-footer">
                    <button class="btn btn-secondary btn-sm" data-dismiss="modal" type="button">
                        Cerrar
                    </button>
                    <button class="btn btn-primary btn-sm" type="submit">
                        Guardar
                    </button>
                </div>
            </div>
        </div>
        --}}
    </div>
</form>
@endsection
@section('script')
<script>
    $(document).ready(function() {
        var ninos = 1;
        var juniors = 1;
        var endDays = 1;
        var cont_n = 1;
        var cont_j = 1;
        var cont_fild = 1;
        var flag = true;


        $('#fechas').daterangepicker({
            dateFormat: "yy-mm-dd",
            autoUpdateInput: true,
        // buttonClasses: ['btn', 'btn-sm'],
        // applyClass: 'btn-success',
        // cancelClass: 'btn-inverse',
        });

        $('body').on('click', '#formAddReservacion #btnAddName', function(event) {
            event.preventDefault();
            $('#formAddReservacion #titular').val("{{ $user->fullName }}");
        });

        $('body').on('click', '#addHabitacion', function(event) {
            event.preventDefault();
            $('#contenidoH').clone();
            $( "#contenidoH" ).last().clone().appendTo( "#contenidoH" );
        });

        $('body').on('click', '.btnAdd', function(event) {
            event.preventDefault();
            var contenedor = $(this).data('field');
            var row_inicial = $(this).data('cantidad-row');
            var row = $(this).attr('id');
            
            if (cont_n <= (5 + row_inicial)) {
                $('#'+contenedor).append('<tr id="row' + cont_n + '"><td><input class="form-control" id="edad_nino' + cont_n + '" min="1" name="edad_nino[]" pattern="^[0-9]+" type="text"  placeholder="Edad" style="width: 100%;" required/></td><td><button type="button" name="remove" id="' + cont_n + '" class="btn btn-danger btn_remove btn-sm" data-field="'+contenedor+'"><span class="fa fa-trash"></span></button></td></tr>');
                 cont_n++;
            }else {
                toastr['warning']('Cupo excedido para niños.');
            }
           
        });

        $(document).on('click', '.btn_remove', function() {
            var button_id = $(this).attr("id");
            var contenedor_r = $(this).data('field');
            cont_n = cont_n - 1;
            console.log(cont_n);
            $('#'+contenedor_r+' #row' + button_id + '').remove();
        });

   });
</script>
@endsection
