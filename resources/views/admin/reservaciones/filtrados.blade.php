@extends('layouts.admin.app')
@section('content')
<div class="row page-titles">
    <div class="col-md-5 col-8 align-self-center">
        <h3 class="text-themecolor text-capitalize">
            Filtrados
        </h3>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('dashboard') }}">
                    Home
                </a>
            </li>
            <li class="breadcrumb-item active">
                Filtrados
            </li>
        </ol>
    </div>
</div>
<div class="col-md">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">
                {{ $region->title }}
            </h4>
            <form action="{{ route('reservations.get_filtrado') }}" id="formReservaciones" method="GET">
                <input name="region_id" type="hidden" value="{{ $region->id }}"/>
                <div class="row">
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group ">
                                    <label class="control-label">
                                        Estatus
                                    </label>
                                    <select class="form-control custom-select select2 m-b-10 select2-multiple select2-hidden-accessible" id="estatus" multiple="" name="estatus[]" style="width:100%">
                                        @foreach ($estatus_reservacion as $estatus => $res)
                                        <option value="{{ $estatus }}">
                                            {{ $res }}
                                        </option>
                                        @endforeach
                                    </select>
                                    <span class="text-danger error-estatus errors">
                                    </span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group ">
                                    <label class="control-label">
                                        Estatus de pago
                                    </label>
                                    <select class="form-control custom-select select2 m-b-10 select2-multiple select2-hidden-accessible" id="estatus_pago" multiple="" name="estatus_pago[]" style="width:100%">
                                        @foreach ($estatus_pago as $estatus => $res)
                                        <option value="{{ $estatus }}">
                                            {{ $res }}
                                        </option>
                                        @endforeach
                                    </select>
                                    <span class="text-danger error-estatus_pago errors">
                                    </span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group ">
                                    <label class="control-label">
                                        Garantia
                                    </label>
                                    <select class="form-control custom-select select2 m-b-10 select2-multiple select2-hidden-accessible" id="garantia" multiple="" name="garantia[]" style="width:100%">
                                        @foreach ($garantia_reservacion as $result => $r)
                                        <option value="{{ $result }}">
                                            {{ $r }}
                                        </option>
                                        @endforeach
                                    </select>
                                    <span class="text-danger error-garantia errors">
                                    </span>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group ">
                                    <label class="control-label">
                                        Tipo de reservación
                                    </label>
                                    <select class="form-control custom-select select2 m-b-10 select2-multiple select2-hidden-accessible" id="tipo_reserva" multiple="" name="tipo_reserva[]" style="width:100%">
                                        @foreach ($tipo_reservacion as $val => $v)
                                        <option value="{{ $val }}">
                                            {{ $v }}
                                        </option>
                                        @endforeach
                                    </select>
                                    <span class="text-danger error-garantia errors">
                                    </span>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-12">
                                <div class="form-group ">
                                    <label class="control-label">
                                        Destino
                                    </label>
                                    <input class="form-control" name="destino" type="text"/>
                                    <span class="text-danger error-destino errors">
                                    </span>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-12">
                                <div class="form-group ">
                                    <label class="control-label">
                                        Hotel
                                    </label>
                                    <input class="form-control" name="hotel" type="text"/>
                                    <span class="text-danger error-hotel errors">
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-md-12 form-group ">
                                {{--
                                <div class="form-group ">
                                    <label class="control-label">
                                        Tipo
                                    </label>
                                    <select class="form-control custom-select select2 m-b-10 select2-multiple select2-hidden-accessible" id="tipo_filtro" multiple="" name="tipo_filtro[]" style="width:100%">
                                        @foreach ($filtros_fecha as $estatus_f => $res_f)
                                        <option value="{{ $estatus_f }}">
                                            {{ $res_f }}
                                        </option>
                                        @endforeach
                                    </select>
                                    <span class="text-danger error-tipo_filtro errors">
                                    </span>
                                </div>
                                --}}
                                <label class="control-label">
                                    Tipo de filtrado
                                </label>
                                <br/>
                                <div class="btn-group" data-toggle="buttons">
                                    <label class="btn btn-info btn-sm ">
                                        <input name="ingreso" type="checkbox">
                                            INGRESO
                                        </input>
                                    </label>
                                    <label class="btn btn-info btn-sm ">
                                        <input name="alta" type="checkbox">
                                            ALTA
                                        </input>
                                    </label>
                                    <label class="btn btn-info btn-sm ">
                                        <input name="pago_hotel" type="checkbox">
                                            PAGO HOTEL
                                        </input>
                                    </label>
                                    <label class="btn btn-info btn-sm ">
                                        <input name="pago_cliente" type="checkbox">
                                            PAGO CLIENTE
                                        </input>
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group ">
                                    <label class="control-label">
                                        Inicio
                                    </label>
                                    <input class="form-control datepicker" name="fecha_inicio" type="text" value="{{ date('Y-m-d') }}">
                                        <span class="text-danger error-fecha_inicio errors">
                                        </span>
                                    </input>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group ">
                                    <label class="control-label">
                                        Fin
                                    </label>
                                    <input class="form-control datepicker" name="fecha_fin" type="text" value="{{ date('Y-m-d') }}">
                                        <span class="text-danger error-fecha_fin errors">
                                        </span>
                                    </input>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group ">
                                    <label class="control-label">
                                        Ejecutivos
                                    </label>
                                    <select class="form-control custom-select select2 m-b-10 select2-multiple select2-hidden-accessible" id="ejecutivos" multiple="" name="ejecutivos[]" style="width:100%">
                                        @foreach ($ejecutivos as $res)
                                        @if ($res->admin_padre)
                                        <option value="{{ $res->admin_padre->id }}">
                                            {{ $res->fullName }}
                                        </option>
                                        @endif
                                        @endforeach
                                    </select>
                                    <span class="text-danger error-tipo_filtro errors">
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div>
                    <button class="btn btn-primary btn-sm" type="submit">
                        <i class="fa fa-filter">
                        </i>
                        Filtrar
                    </button>
                    @if (Auth::user()->vetarifah == 1 || Auth::user()->role == 'admin')
                    <button class="btn btn-success btn-sm" id="btnDownloadReservaciones" type="button">
                        <i class="fa fa-file-excel-o">
                        </i>
                        Exportar
                    </button>
                    @endif
                </div>
            </form>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">
                Resultado
            </h4>
            <div class="table-responsive">
                <table class="table table-hover table-striped table-responsive-xl" id="table_filtrado_reservaciones" style="width:100%">
                    <thead>
                        <tr>
                            <th>
                                Folio
                            </th>
                            <th>
                                Cliente
                            </th>
                            <th>
                                Destino
                            </th>
                            <th>
                                Paquete
                            </th>
                            <th>
                                Estatus
                            </th>
                            <th>
                                Fechas
                            </th>
                            <th>
                                CargosGRV
                            </th>
                            <th>
                                Hotel / Tarifa
                            </th>
                            <th>
                                Pagada
                            </th>
                            <th>
                                Opciones
                            </th>
                        </tr>
                    </thead>
                </table>
            </div>
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


        
        $('#formReservaciones').submit(function(event){
            event.preventDefault();
            $.ajax({
                url: "{{ route('reservations.get_filtrado') }}",
                type: "GET",
                dataType: 'json',
                contentType: 'application/json; charset=utf-8',
                data: $(this).serialize(),
                beforeSend:function(){
                      $("#overlay").css("display", "block");
                },
                success:function(res){
                    $("#overlay").css("display", "none");
                    var tabla = $('#table_filtrado_reservaciones').dataTable({
                    'responsive': true,
                    'lengthMenu': [[10, 20,50, -1], [10, 20, 50, "Todo"]],
                    "aoColumns": [{
                        "mData": "folio"
                    }, {
                        "mData": "cliente"
                    }, {
                        "mData": "destino"
                    }, {
                        "mData": "paquete"
                    }, {
                        "mData": "estatus"
                    }, {
                        "mData": "fechas"
                    }, {
                        "mData": "pago_info"
                    }, {
                        "mData": "tarifa_info"
                    }, {
                        "mData": "pago_final"
                    }, {
                        "mData": "actions"
                    }],
                    data: res.data,
                    "bDestroy": true,
                    }).DataTable();
                }
            })
            .done(function(res) {
                if (res.error) {
                    alert(res.error)
                }
            }) 
            .fail(function(jqXHR, textStatus, errorThrown) {
                toastr['error'](errorThrown);
                toastr['error'](jqXHR);
                $("#overlay").css("display", "none");
            })
            .always(function() {
                  $("#overlay").css("display", "none");
            });
        });

        $('#btnDownloadReservaciones').on('click', function(event) {
            event.preventDefault();
            $.ajax({
                url: baseadmin + 'create-filtrado-reservaciones',
                type: 'GET',
                dataType: 'JSON',
                data: $('#formReservaciones').serialize(),
                beforeSend:function(){
                    $("#overlay").css("display", "block");
                },
                success:function(res){
                    if (res.success == true) {
                        alertify.alert('Descargando...','Descargando filtrado, no actualice ni cierre esta pestaña hasta que se descargue el archivo.');
                        window.location.href = res.url;
                    }else{
                        toastr['error']('Intentar mas tarde...')
                    }
                }
            })
            .fail(function(jqXHR, textStatus, errorThrown) {
                toastr['error'](errorThrown);
                toastr['error'](jqXHR);
                $("#overlay").css("display", "none");
            })
            .always(function() {
                console.log("complete");
                $("#overlay").css("display", "none");
            });
            
        });
    });
</script>
@stop
