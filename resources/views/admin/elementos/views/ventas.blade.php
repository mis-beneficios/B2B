@extends('layouts.admin.app')
@section('content')
<div class="row page-titles">
    <div class="col-md-5 col-8 align-self-center">
        <h3 class="text-themecolor">
            <a href="#">
                Ventas
            </a>
        </h3>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('dashboard') }}">
                    Home
                </a>
            </li>
            <li class="breadcrumb-item active">
                Filtrado de ventas
            </li>
        </ol>
    </div>
</div>
<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="card">
            <div class="card-header">
                {{--
                <div class="card-actions">
                    <button class="btn btn-info btn-xs" data-target="#modalCampana" data-toggle="modal" id="btnAddCampana">
                        <span>
                            <i class="fas fa-plus">
                            </i>
                            Agregar campaña
                        </span>
                    </button>
                </div>
                --}}
                <h4 class="card-title m-b-0">
                    Filtrado de ventas
                </h4>
            </div>
            <div class="card-body">
                <div>
                    <form action="{{ route('ventas.show') }}" id="formFiltrado" method="get">
                        <div class="form-row">
                            <div class="form-group col-md-8">
                                <label for="">
                                    Convenios
                                </label>
                                <div class="input-group mb-3">
                                    <select class="form-control custom-select select2 m-b-10 select2-multiple select2-hidden-accessible" id="convenios_id" multiple="" name="convenio_id[]" style="width: 95%;">
                                        @foreach ($convenios as $convenio)
                                        <option value="{{ $convenio->id }}">
                                            {{ $convenio->empresa_nombre }}
                                        </option> 
                                        @endforeach
                                    </select>
                                  <div class="input-group-append">
                                    <button class="btn btn-sm btn-dark btnReloadConv" id="btnReloadConv" data-toggle="tooltip" data-placement="top" title="Recargar datos de convenios">
                                        <i class="fas fa-refresh"></i>
                                    </button>
                                  </div>
                                </div>
                            </div>
                            <div class="form-group col-md-2">
                                <label for="inputAddress">
                                    Fecha de inicio
                                </label>
                                <input autocomplete="false" class="form-control" id="fecha_inicio" name="fecha_inicio" type="text" value="{{ date('Y-m-d') }}"/>
                            </div>
                            <div class="form-group col-md-2">
                                <label for="inputAddress2">
                                    Fecha de fin
                                </label>
                                <input autocomplete="false" class="form-control" id="fecha_fin" name="fecha_fin" type="text" value="{{ date('Y-m-d') }}"/>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-3">
                                <label for="inputState">
                                    Estatus
                                </label>
                                <select class="form-control custom-select select2 m-b-10 select2-multiple select2-hidden-accessible" id="estatus" multiple="" name="estatus[]" style="width:100%">
                                    <option value="">
                                        Todos
                                    </option>
                                    <option value="Comprado">
                                        Comprado
                                    </option>
                                    <option value="suspendido">
                                        Suspendido
                                    </option>
                                    <option value="viajado">
                                        viajado
                                    </option>
                                    <option value="nuevo">
                                        nuevo
                                    </option>
                                    <option value="cancelado">
                                        cancelado
                                    </option>
                                    <option value="pagado">
                                        pagado
                                    </option>
                                    <option value="sin_aprobar">
                                        sin_aprobar
                                    </option>
                                    <option value="Tarjeta con problemas">
                                        Tarjeta con problemas
                                    </option>
                                    <option value="por_autorizar">
                                        por_autorizar


                                    </option>
                                    <option value="por_cancelar">
                                        por_cancelar
                                    </option>
                                </select>
                            </div>
                            <div class="form-group col-md-3">
                                <label for="inputState">
                                    Tipo de llamada
                                </label>
                                <select class="form-control custom-select select2 m-b-10 select2-multiple select2-hidden-accessible" id="tipo_llamada" multiple="" name="tipo_llamada[]" style="width:100%">
                                    <option value="VD">
                                        Venta Directa
                                    </option>
                                    <option value="en">
                                        Entrada
                                    </option>
                                    <option value="sa">
                                        Salida
                                    </option>
                                    <option value="na">
                                        N/A
                                    </option>
                                    <option value="WB">
                                        Entrada por web
                                    </option>
                                </select>
                            </div>
                            <div class="form-group col-md-3">
                                <label for="inputState">
                                    Como se entero
                                </label>
                                <select class="form-control custom-select select2 m-b-10 select2-multiple select2-hidden-accessible" id="como_se_entero" multiple="" name="como_se_entero[]" style="width:100%">
                                    @foreach ($como_se_entero as $res => $key)
                                    <option value="{{ $res }}">
                                        {{ $key }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-3">
                                <label for="inputState">
                                    Equipo
                                </label>
                                <select class="form-control custom-select select2 m-b-10 select2-multiple select2-hidden-accessible" id="equipo" multiple="" name="equipo[]" style="width:100%">
                                    @foreach ($equipos as $equipo)
                                    <option value="{{ $equipo['id'] }}">
                                        {{ $equipo['title'] }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                            {{--
                            <div class="form-group col-md-3">
                                <label for="inputState">
                                    Pais
                                </label>
                                <select class="form-control custom-select select2 m-b-10 select2-multiple select2-hidden-accessible" id="pais_id" multiple="" name="pais_id[]" style="width:100%">
                                    @foreach ($paises as $pais)
                                    <option value="{{ $pais->id }}">
                                        {{ $pais->title }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                            --}}
                        </div>
                        <button class="btn btn-primary btn-sm" type="submit">
                            Filtrar
                        </button>
                        <button class="btn btn-success btn-sm" id="export">
                            <i class="fas fa-file-excel-o">
                            </i>
                            Exportar
                        </button>
                    </form>
                </div>
                <hr/>
                <div class="table-responsive mt-3">
                    <table class="table table-hover dataTable" id="tabla_ventas" role="grid" style="width:100%">
                        <thead>
                            <tr role="row">
                                <th>
                                    ID
                                </th>
                                <th>
                                    Cliente
                                </th>
                                <th>
                                    Paquete
                                </th>
                                <th>
                                    Estatus
                                </th>
                                <th>
                                    Vendedor
                                </th>
                                <th>
                                    Equipo
                                </th>
                                <th>
                                    Segmentos
                                </th>
                                <th>
                                    Pagos Realizados
                                </th>
                                <th>
                                    Convenio
                                </th>
                                <th>
                                    Como se entero
                                </th>
                                <th>
                                    Tipo de llamada
                                </th>
                                <th>
                                    Creado
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
        var tabla_ventas;
        $('#convenio_id').select2({
            // Funcionamiento correcto dentro de modales 
            dropdownParent: $('#modalSorteo'),
            allowClear: true,
            placeholder: 'Selecciona algun convenio',
            width: 'resolve',
            heigh:'resolve',

        });

        // $#(document).on('click', '.selector', function(event) {
        //     event.preventDefault();
        //     /* Act on the event */
        // });

        $('.btnReloadConv').on('click', function(event) {
            event.preventDefault();
   
            toastr['info']('Recargando listado de convenios...');

            $.ajax({
                url: baseadmin + 'list-convenios-ajax',
                type: 'GET',
                dataType: 'json',
                success:function(res){
                    $.each(res.convenios, function(index, val) {
                        $('#convenios_id').append('<option value="'+val.id+'">'+val.empresa_nombre+'</option>');
                    });
                }   
            });
        });


        // $('#fecha_inicio, #fecha_fin').datepicker({
        //     dateFormat: "yy-mm-dd",
        //     // minDate: '-3M',
        //     autoclose:true,
        //     endDate: new Date(),
        // });



        $('#fecha_inicio, #fecha_fin').bootstrapMaterialDatePicker({
            weekStart: 0,
            time: false,
            lang: 'es',
        });


        pintar_ventas($('#formFiltrado').serialize(), $('#formFiltrado').attr('action'));

        $('#formFiltrado').on('submit', function(event) {
            event.preventDefault();
            pintar_ventas($('#formFiltrado').serialize(), $('#formFiltrado').attr('action'));
        });


        $('#export').on('click', function(event) {
            event.preventDefault();
            $.ajax({
                url: "{{ route('ventas.export') }}",
                type: 'GET',
                dataType: 'json',
                data: $('#formFiltrado').serialize(),
                beforeSend:function(){
                    $("#overlay").css("display", "block");
                },
                success:function(res){
                    if (res.success == true) {
                        alertify.alert('Descargando...','Descargando filtrado, no actualice ni cierre esta pestaña hasta que se descargue el archivo.');
                        window.location.href = res.url;
                    }
                }
            })
            .always(function() {
                $("#overlay").css("display", "none");
            });
        });
    });

    function pintar_ventas(form, url) {
        $.ajax({
            url: url,
            type: 'GET',
            dataType: 'json',
            data: form,
            beforeSend:function(){
                $("#overlay").css("display", "block");
            },
            success:function(res){
               tabla_ventas = $('#tabla_ventas').dataTable({
                    'responsive': true,
                    'searching': true,
                    // 'serverSide': true,
                    buttons: [
                        'copy', 'excel', 'pdf'
                    ],
                    fixedColumns: true,
                    "aoColumns": [{
                        "mData": "0"
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
                        "mData": "6"
                    }, {
                        "mData": "7"
                    }, {
                        "mData": "9"
                    }, {
                        "mData": "11"
                    }, {
                        "mData": "10"
                    }, {
                        "mData": "8"
                    }],
                    data: res.aaData,
                    destroy: true,
                }).DataTable();
            }
        })
        .always(function() {
            $("#overlay").css("display", "none");
        });
        
        // $('#tabla_ventas').DataTable({
        //     processing: true,
        //     serverSide: true,
        //     bDestroy: true,
        //     order: [0, 'desc'],
        //     ajax: {
        //         url: url,
        //         type: 'get',
        //         data: form,
        //     },
        //     columns: [
        //         {data: 'id', name: 'id'},
        //         {data: 'cliente', name: 'cliente'},
        //         {data: 'paquete', name: 'paquete'},
        //         {data: 'estatus', name: 'estatus'},
        //         {data: 'vendedor_name', name: 'vendedor_name'},
        //         {data: 'equipo_ventas', name: 'equipo_ventas'},
        //         {data: 'coutas_pagos', name: 'coutas_pagos'},
        //         {data: 'pagos_realizados', name: 'pagos_realizados'},
        //         {data: 'convenio_id', name: 'convenio_id'},
        //         {data: 'como_se_entero', name: 'como_se_entero'},
        //         {data: 'tipo_llamada', name: 'tipo_llamada'},
        //         {data: 'creado', name: 'creado'},
        //     ],
        //     "drawCallback": function() {
        //         if (this.fnSettings().fnRecordsTotal() < 11) {
        //             $('.dataTables_paginate').hide();
        //         }
        //     },
        // });
    }

    // function pintar_ventas(data, url) {
    //     $.ajax({
    //         url: url,
    //         type: 'GET',
    //         dataType: 'json',
    //         data: data,
    //         beforeSend:function(){
    //             $("#overlay").css("display", "block");
    //         },
    //         success:function(res){
    //             tabla_ventas = $('#tabla_ventas').dataTable({
    //                 'responsive': true,
    //                 'searching': true,
    //                 // 'serverSide': true,
    //                 buttons: [
    //                     'copy', 'excel', 'pdf'
    //                 ],
    //                 fixedColumns: true,
    //                 "aoColumns": [{
    //                     "mData": "0"
    //                 },{
    //                     "mData": "1"
    //                 }, {
    //                     "mData": "2"
    //                 }, {
    //                     "mData": "3"
    //                 }, {
    //                     "mData": "4"
    //                 }, {
    //                     "mData": "5"
    //                 }, {
    //                     "mData": "6"
    //                 }, {
    //                     "mData": "7"
    //                 }, {
    //                     "mData": "9"
    //                 }, {
    //                     "mData": "10"
    //                 }, {
    //                     "mData": "11"
    //                 }, {
    //                     "mData": "8"
    //                 }],
    //                 data: res.aaData,
    //                 destroy: true,
    //             }).DataTable();
    //         }
    //     })
    //     .always(function() {
    //         $("#overlay").css("display", "none");
    //     });
    // }
</script>
@endsection
