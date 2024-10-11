@extends('layouts.admin.app')
@section('content')
@livewireStyles
@livewireScripts
<div class="row page-titles">
    <div class="col-md-5 col-8 align-self-center">
        <h3 class="text-themecolor">
            Comisiones
        </h3>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('dashboard') }}">
                    Inicio
                </a>
            </li>
            <li class="breadcrumb-item active">
                Comisiones
            </li>
        </ol>
    </div>
</div>
{{-- Se comentan para realizar pruebas de servidor
@if (Auth::user()->role == 'admin')
    @livewire('comisiones.actualizar')
@endif
--}}
<div class="row mb-5">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title m-b-0">
                    Filtrar comisiones
                </h4>
            </div>
            <div class="card-body">
                <form id="formComisiones" action="{{ route('comisiones.listar-comisiones') }}" method="get" target="_blank">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="inputPassword4">
                                    Fechas
                                </label>
                                <input class="form-control input-limit-datepicker" required id="fechas" name="fechas" value="" type="text" autocomplete="off">
                                </input>
                                <span class="text-danger error-fechas errors">
                                </span>
                            </div>
                        </div>
                        <div class="form-group col-md-12">
                            <label for="inputPassword4">
                                Ejecutivos
                            </label>
                            <select class="form-control custom-select select2 m-b-10 select2-multiple select2-hidden-accessible" multiple="" id="ejecutivos" name="ejecutivos[]" style="width: 100%; height: 200px;">
                                @if (Auth::user()->role == 'conveniant' || Auth::user()->role == 'sales')
                                <option selected="" value="'{{ Auth::user()->username }}'">
                                    {{ Auth::user()->fullName .' '. Auth::user()->username}}
                                </option>
                                @else
                                @foreach ($ejecutivos as $ejecutivo)
                                <option value="'{{ $ejecutivo->username }}'">
                                    {{ $ejecutivo->fullName .' '. $ejecutivo->username}}
                                </option>
                                @endforeach

                                @endif
                            </select>

                            <span class="text-danger error-ejecutivos errors">
                            </span>
                        </div>
                    </div>
{{--                     <button class="btn btn-primary btn-sm" type="submit">
                        Filtrar
                    </button> --}}
                    <button class="btn btn-dark btn-sm" id="btnDescargarComisiones" type="button">
                        <i class="fas fa-file-excel-o">
                        </i>
                        Descargar
                    </button>
                </form>
            </div>
        </div>
    </div>
    {{-- Se comentan para realizar pruebas de servidor
    <div class="col-md-12">
        @livewire('comisiones.show-files',['tipo' => 'comisiones'])
    </div>
    --}}
   {{--  <div class="col-lg-12 col-md-12">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover dataTable" id="table_comisiones" style="width:100%">
                        <thead>
                            <tr role="row">
                                <th>
                                    Folio
                                </th>
                                <th >
                                    Llamada
                                </th>
                                <th class="col-2">
                                    Fecha de venta
                                </th>
                                <th class="col-2">
                                    Primero pago
                                </th>
                                <th>
                                    Comisionista
                                </th>
                                <th>
                                    Equipo
                                </th>
                                <th class="col-2">
                                    Cliente
                                </th>
                                <th>
                                    Estatus
                                </th>
                                <th>
                                    Actualización
                                </th>
                                <th>
                                    Cantidad
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div> --}}
</div>
@endsection


@section('script')
<script>
    $(document).ready(function() {

        // setInterval(function(){
        //     Livewire.emit('recargarData')
        // },(5000));

        $('.select2').select2({
            maximumSelectionLength: 15,
            formatSelectionTooBig: function (limit) {
                return 'Solo puedes seleccionar ' + limit + ' elementos.';
            }
        });


         $('#fechas').daterangepicker({
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
                firstDay: 1,
            },
            maxSpan: {
                days: 31
            },
        });
 

        // $('#formComisiones').submit(function(event) {
        //     event.preventDefault();
        //     mostrar_comisiones();
        // });

        $('#btnDescargarComisiones').on('click', function(event) {
            var notificacion_id;
            event.preventDefault();

            Swal.fire({
                title: "Te notificaremos en cuanto el archivo este listo",
                html: 'Ingresa tu numero de teléfono a 10 dígitos',
                input: "text",
                inputAttributes: {
                    autocapitalize: "off",
                    required: true,
                },
                showCancelButton: false,
                confirmButtonText: "Generar",
                cancelButtonText: "No",
                showLoaderOnConfirm: true,
                preConfirm: async (telefono) => {
                    return new Promise((resolve, reject) => {
                        $.ajax({
                            url: "{{ route('jobs.store') }}",
                            type: 'POST',
                            dataType: 'json',
                            data: {
                                telefono: telefono,
                                job_name: 'Filtrado de comisiones',
                                fechas: $('#fechas').val()
                            },
                        })
                        .done(function(res) {
                            if (res.success == true && res.notificacion) {
                                toastr['info']('Se te enviara un SMS al numero: ' + res.notificacion['numero'] +' cuando el archivo este listo.')
                                resolve(res.notificacion['id']);
                            } else {
                                toastr['warning']('¡Error al intentar notificar!')
                                reject();
                            }
                        })
                        .fail(function(jqXHR, textStatus, errorThrown) {
                            toastr['warning'](jqXHR.responseJSON.message);
                            toastr['error'](textStatus);
                            reject();
                        })
                        .always(function() {
                        });
                    });
                },
                allowOutsideClick: () => !Swal.isLoading()
            }).then((notificacion_id) => {
                if (notificacion_id.isConfirmed) {
                    exportComisiones(notificacion_id.value);
                }
            });
        });
    });

    function exportComisiones(notificacion_id) {
        $.ajax({
            url: baseadmin + "comisiones-export/" + notificacion_id,
            type: 'GET',
            dataType: 'json',
            data: $('#formComisiones').serialize(),
            beforeSend:function(){
                $("#overlay").css("display", "block");
            },
            success:function(res){
                if (res.success == true) {
                    alertify.alert('¡Alerta!',res.message);
                    // window.location.href = res.url;
                }else{
                    toastr['error'](res.exceptions);
                    toastr['warning']('Intenta con menos ejecutivos')
                }
            }
        })
        .always(function() {
            $("#overlay").css("display", "none");
        });
    }

    function pintarDatos__(request) {
        $.ajax({
            url: baseuri + "admin/listar-comisiones",
            type: 'GET',
            dataType: 'json',
            data: request,
            beforeSend:function(){
                $("#overlay").css("display", "block");
            },
            success:function(res){
                if (res.success == false) {
                     pintar_errores(res.errors);
                }else{
                    var tabla = $('#table_comisiones').DataTable({
                        'responsive': true,
                        'searching': true,
                        "processing": true,
                        'lengthMenu': [[10, 50, -1], [10, 50, "Todo"]],
                        'pageLength': 10,
                        "order": [[ 0, "desc" ]],
                        "aoColumns": [{
                            "mData": "0"
                            }, {
                            "mData": "1"
                            },{
                            "mData": "2"
                            }, {
                            "mData": "3"
                            }, {
                            "mData": "4"
                            }, {
                            "mData": "5"
                            }, {
                            "mData": "7"
                            }, {
                            "mData": "8"
                            }, {
                            "mData": "9"
                            },{
                            "mData": "10"
                            } 
                            // {
                            // "mData": "11"
                            // }, {
                            // "mData": "12"
                            // }
                            // , {
                            // "mData": "13"
                            // }
                        ],
                        "data": res.aaData,
                        "bDestroy": true
                    });
                }
            }
        })
        .fail(function(jqXHR, textStatus, errorThrown) {
            console.log(jqXHR, textStatus, errorThrown);
            toastr['error'](errorThrown);
            toastr['error'](jqXHR);
        })
        .always(function() {
            $("#overlay").css("display", "none");
        });

    }
 
    function mostrar_comisiones() {
        $('#table_comisiones').DataTable({
            processing: true,
            serverSide: true,
            bDestroy: true,
            order: [0, 'desc'],
            bInfo: true,
            ajax: {
                url:  baseadmin + "listar-comisiones",
                data: function (d) {
                    console.log(d);
                    d.fechas = $('#fechas').val();
                    d.ejecutivos = $('#ejecutivos').val();
                },
                error: function (xhr, error, thrown) {
                    toastr['warning']("Error en la solicitud Ajax:", xhr, error, thrown);
                    toastr['error']('Intenta con menos ejecutivos')
                }
            },
            columns: [
                {data: 'id', name: 'id'},
                {data: 'tipo_llamada', name: 'tipo_llamada'},
                {data: 'fecha_de_venta', name: 'fecha_de_venta'},
                {data: 'primer_pago', name: 'primer_pago'},
                {data: 'comisionista', name: 'comisionista'},
                {data: 'equipo', name: 'equipo'},
                {data: 'cliente_nombre', name: 'cliente_nombre'},
                {data: 'estatus', name: 'estatus'},
                {data: 'modified', name: 'modified'},
                {data: 'cantidad', name: 'cantidad'},
            ],
            "drawCallback": function() {
                if (this.fnSettings().fnRecordsTotal() < 11) {
                    $('.dataTables_paginate').hide();
                }
            },
        });
    }
</script>
@endsection
