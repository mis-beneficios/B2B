@extends('layouts.admin.app')

@section('content')
<style>
    .span_blocks{

    }
</style>
<div class="row page-titles">
    <div class="col-md-5 col-8 align-self-center">
        <h3 class="text-themecolor">
            Calendario de convenios
        </h3>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('dashboard') }}">
                    Home
                </a>
            </li>
            <li class="breadcrumb-item active">
                Listado
            </li>
        </ol>
    </div>
</div>
<div class="row">
    <div class="col-md-3">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table aria-describedby="" class="table table-hover dataTable" id="concals_table" role="grid" style="width:100%">
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-9 col-md-9">
        <div class="card">
            <div class="card-body">
                <div class="d-flex flex-wrap">
                    <div>
                        <h4 class="card-title">
                            Filtrado
                        </h4>
                    </div>
                    <div class="ml-auto">
                        <button class="btn btn-primary btn-sm btnEmpresa" data-type="nuevo" type="button">
                            Nueva empresa
                        </button>
                    </div>
                </div>
                <form action="{{ route('concals.index') }}" id="form_concals_v2" method="get">
                    @csrf
                    <input id="user_id" name="user_id" type="hidden" value="{{ Auth::id() }}"/>
                    <input id="role" name="role" type="hidden" value="{{ Auth::user()->role }}"/>
                    <div class="form-body">
                        <div class="row p-t-10">
                            <div class="col-lg-6 col-md-6 col-sm-6">
                                <div class="form-group">
                                    <label class="control-label">
                                        Busqueda
                                    </label>
                                    <input class="form-control" id="nombre" name="nombre" placeholder="Empresa" type="text">
                                    </input>
                                    <span class="text-danger error-nombre errors">
                                    </span>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-3 col-sm-6">
                                <div class="form-group ">
                                    <label class="control-label">
                                        Inicio de rango
                                    </label>
                                    <input class="form-control " id="inicio_rango" name="inicio_rango" type="date">
                                        <small class="form-control-feedback">
                                        </small>
                                    </input>
                                    <span class="text-danger error-inicio_rango errors">
                                    </span>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-3 col-sm-6">
                                <div class="form-group">
                                    <label class="control-label">
                                        Fin de rango
                                    </label>
                                    <input class="form-control " id="fin_rango" name="fin_rango" type="date">
                                        <small class="form-control-feedback">
                                        </small>
                                    </input>
                                    <span class="text-danger error-fin_rango errors">
                                    </span>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-4 col-sm-6">
                                <div class="form-group ">
                                    <label class="control-label">
                                        Desplegar
                                    </label>
                                    <div class="demo-radio-button">
                                        <input checked="" id="radio_1" name="mostrar" type="radio" value="todos"/>
                                        <label for="radio_1">
                                            Todos
                                        </label>
                                        <input id="radio_2" name="mostrar" type="radio" value="mios"/>
                                        <label for="radio_2">
                                            Mios
                                        </label>
                                    </div>
                                    <span class="text-danger error-mostrar errors">
                                    </span>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-3 col-sm-6">
                                <div class="form-group ">
                                    <label class="control-label">
                                        Estatus
                                    </label>
                                    <select class="form-control" id="estatus_concal" name="estatus_concal" style="width:100%">
                                        <option value="">
                                            Selecciona una opción
                                        </option>
                                        @foreach ($estatus_concal as $estatus => $key)
                                        <option value="{{ $estatus }}">
                                            {{ $key }}
                                        </option>
                                        @endforeach
                                    </select>
                                    <span class="text-danger error-telefono errors">
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-actions my-auto">
                        <button class="btn btn-success btn-sm" id="btnSubmit" type="submit">
                            <i class="fa fa-search">
                            </i>
                            Buscar
                        </button>
                    </div>
                </form>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <div class="d-flex flex-wrap">
                    <div>
                        <h4 class="card-title">
                            Calendarios de seguimientos
                        </h4>
                    </div>
                    {{--
                    <div class="ml-auto">
                        <button class="btn btn-primary btn-sm" type="button">
                            Nuevo convenio
                        </button>
                    </div>
                    --}}
                </div>
                <div class="table-responsive">
                    <table class="table table-hover dataTable" id="convenios_table" style="width:100%">
                        <thead>
                            <tr>
                                <th>
                                    Empresa
                                </th>
                                <th>
                                    Contacto
                                </th>
                                <th>
                                    LLamadas
                                </th>
                                <th>
                                    Conveniador
                                </th>
                                <th>
                                    Estatus
                                </th>
                                <th>
                                    Opciones
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($concals as $concal)
                            <tr>
                                <td>
                                    <strong>
                                        {{ $concal->empresa }}
                                        <br/>
                                        <span style="font-size:12px">
                                            <a href="javascript():;">
                                                {{ $concal->pagina_web }}
                                            </a>
                                        </span>
                                        <br/>
                                        <small class="text-info" style="font-size: 10px">
                                            <strong>
                                                {{ $concal->no_empleados }} Empleados
                                            </strong>
                                        </small>
                                    </strong>
                                </td>
                                <td>
                                    <strong>
                                        {{ $concal->contacto }}
                                        <br/>
                                        <span style="font-size:12px">
                                            {{ $concal->email }}
                                        </span>
                                        <br/>
                                        <small class="text-info" style="font-size: 10px">
                                            <strong>
                                                {{ $concal->telefonos }}
                                            </strong>
                                        </small>
                                    </strong>
                                </td>
                                <td>
                                    <strong>
                                        {{  $concal->siguiente_llamada }}
                                        <br/>
                                        <span style="font-size:12px">
                                            {{   $concal->ultima_llamada }}
                                        </span>
                                        <br/>
                                        <small class="text-info" style="font-size: 10px">
                                            <strong>
                                                {{ $concal->primer_llamada }}
                                            </strong>
                                        </small>
                                    </strong>
                                </td>
                                <td>
                                    <strong>
                                        {{  $concal->user->fullName }}
                                        <br/>
                                        <span style="font-size:12px">
                                            {{ $concal->estado }}
                                        </span>
                                    </strong>
                                </td>
                                <td>
                                    <strong class="label" style="background-color:{{ $concal->color_estatus()}};">
                                        {{ $concal->estatus }}
                                        <br/>
                                        <span style="font-size:12px">
                                        </span>
                                    </strong>
                                </td>
                                <td>
                                    @php
                                        $btn = '';
                $btn .= ($concal->log != null) ? '
                                    <button class="btn btn-dark btn-xs m-1 btnConcal btnLogConcal" data-id="' . $concal->id . '" data-type="info" id="" type="button">
                                        <i class="fas fa-info">
                                        </i>
                                    </button>
                                    ' : '';
                $btn .= '
                                    <button class="btn btn-info btn-xs m-1 btnConcal btnEmpresa" data-id="' . $concal->id . '" data-type="editar" id="" type="button">
                                        <i class="fas fa-edit">
                                        </i>
                                    </button>
                                    ';
                $btn .= (Auth::user()->can('reasignar', $concal)) ? '
                                    <button class="btn btn-warning btn-xs m-1 btnConcal" data-concal_id="' . $concal->id . '" data-type="reasignar" data-url="' . route('concals.form_reasignar', $concal->id) . '" id="btnAsignar" type="button">
                                        <i class="fas fa-user">
                                        </i>
                                    </button>
                                    ' : '';
                                    @endphp
                                    {!! $btn !!}
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr role="row">
                                <th>
                                    Empresa
                                </th>
                                <th>
                                    Contacto
                                </th>
                                <th class="text-nowrap">
                                    LLamadas
                                </th>
                                <th class="text-nowrap">
                                    Conveniador
                                </th>
                                <th class="text-nowrap">
                                    Estatus
                                </th>
                            </tr>
                        </tfoot>
                    </table>
                    {{ $concals->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="modalReasignar">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalReasignarLabel">
                    Re asignar seguimiento
                </h5>
                <button aria-label="Close" class="close" data-dismiss="modal" type="button">
                    <span aria-hidden="true">
                        ×
                    </span>
                </button>
            </div>
            <div class="modal-body" id="modal-body">
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
<script>
    $(document).ready(function() {
        var concals;
        var datosTable;

        // pintar_seguimientos();

        $(document).on('submit','#form_concals', function(event) {
            event.preventDefault();
            var fromData = $('#form_concals').serialize();
            console.log(fromData);
            pintar_seguimientos(fromData);
        });

        var tabla_historial = $('#concals_table').DataTable({
            'responsive': true,
            'searching': true,
            'lengthMenu': [[10, 50, -1], [10, 50, "Todo"]],
            'pageLength': 10,
            'order': [0,'DESC'],
            "aoColumns": [{
                "mData": "1"
                }
            ],
            "ajax": {
                url: baseadmin + "get-concals/",
                type: "get",
                dataType: "json",
                error: function(e) {
                  console.log(e.responseText);
                }
            },
        });


        // btnEditConcal
        // btnLogConcal 
        $(document).on('click', '.btnLogConcal', function(event) {
            event.preventDefault();
            var concal_id = $(this).data('id');
            console.log(concal_id);
            $.ajax({
                url: baseadmin + 'get-log/' + concal_id,
                type: 'GET',
                dataType: 'json',
                beforeSend:function(){
                    $("#overlay").css("display", "block");
                },
                success:function(res){
                    $('#modalHistorialEmpresa #modal-body').html(res.log);
                    $('#modalHistorialEmpresa').modal('show');
                }
            })
            .always(function() {
                $("#overlay").css("display", "none");
            });
        });


        $(document).on('click', '.btnEmpresa', function(event) {
            event.preventDefault();
            $('#formConcal').trigger('reset');
            var action = $(this).data('type');
            var concal_id = $(this).data('id');
            var url;
            url = baseadmin + 'modal-form/'+action;
            if (action == 'editar') {
                url = baseadmin + 'modal-form/'+action+'/'+concal_id;
            }

            $.ajax({
                url:  url,
                type: 'GET',
                dataType: 'json',
                beforeSend:function(){
                    $("#overlay").css("display", "block");
                },
                success:function(res){
                    $('#modalEmpresa').modal('show');
                    $('#modalEmpresa .modal_body').html(res.view);
                }
            })
            .always(function() {
                $("#overlay").css("display", "none");
            });
        });


        $(document).on('submit', '#formConcal', function(event) {
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
                        tabla_historial.ajax.reload();
                        pintar_seguimientos();
                        $('#modalEmpresa').modal('hide');
                        toastr['success']('¡Registro exitoso!');
                        
                        if (res.convenio != false) {
                            toastr['info']('Se ha creado una nueva liga <a href="'+res.convenio+'" class="btn btn-xs btn-dark"><i class="fas fa-eye"></i> Ver</a>');
                        }
                    }else
                    {
                        pintar_errores(res.errors);
                        // toastr['error']('¡Intentar mas tarde!');
                    }
                }
            })
            .always(function() {
                $("#overlay").css("display", "none");
            });
        });

        $(document).on('change', '#formConcal #estatus', function(event) {
            event.preventDefault();
            if ($(this).val() == 'cerrado') {
                alertify.confirm('Convenio','¿Desea crear la liga para esta empresa?',function(){
                    $('#formConcal #create_convenio').val(1); 
                    toastr['info']('Se creara un nuevo registro de un convenio asociado a esta empresa');
                }
                ,function(){
                    $('#formConcal #create_convenio').val(0);
                    toastr['warningn']('No se creara la liga correspondiente');
                });
            }
        });



        $('body').on('click', '#btnAsignar', function(event) {
            event.preventDefault();
            var url = $(this).data('url');
            $.ajax({
                url: url,
                type: 'GET',
                dataType: 'JSON',
                beforeSend:function(){
                    $("#overlay").css("display", "block");
                },
                success:function(res){
                    $('#modalReasignar #modal-body').html(res.view);
                    $('#modalReasignar').modal('show');
                }
            })
            .fail(function() {
                console.log("error");
            })
            .always(function() {
                $("#overlay").css("display", "none");
            });
        });

        $('body').on('submit', '#formReasignar', function(event) {
            event.preventDefault();
            var url = $(this).attr('action');
            var method = $(this).attr('method');
            $.ajax({
                url: url,
                type: method,
                dataType: 'json',
                data: $(this).serialize(),
                beforeSend:function(){
                    $("#overlay").css("display", "block");
                },
                success:function(res){
                    if (res.success == true) {
                        $("#overlay").css("display", "none");
                        $('#modalReasignar').modal('hide');
                        toastr['success']('!Seguimiento reasignado correctamente!');
                        pintar_seguimientos();
                    }else{
                        toastr['error']('¡Error, intenta mas tarde!');
                    }

                }
            })
            .fail(function() {
                toastr['error']('¡Error, intenta mas tarde!');
            })
            .always(function() {
                $("#overlay").css("display", "none");
            });
        });
    });

    function pintar_concals($data = null) {
        var datos;
        return $.ajax({
            url: baseadmin + 'get-calendar',
            type: 'GET',
            dataType: 'JSON',
            data: $data,
            beforeSend:function(){
                $("#overlay").css("display", "block");
            },
            success:function(res){
                var tabla = $('#convenios_table').dataTable({
                    'responsive': true,
                    'lengthMenu': [[12, 24, -1], [12, 24, "Todo"]],
                    'pageLength': 12,
                    "aoColumns": [{
                        "mData": "0"
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

    function pintar_seguimientos(fromData = null) {
        $.ajax({
            url: baseadmin + 'get-calendar',
            type: 'GET',
            dataType: 'JSON',
            data: fromData,
            beforeSend:function(){
                $("#overlay").css("display", "block");
            },
            success:function(res){
                $datable=$('#convenios_table').DataTable({
                    // processing: true,
                    // serverSide: true,
                    bDestroy: true,
                    // paging: true,
                    searching: true,
                    order: [0,'DESC'],
                    data: res.data,
                    columns: [
                        {data: 'empresa', render:function(data,type,row){
                            return "<strong>"+row.empresa+ "<br/><span style='font-size:12px'><a href='javascript():;'>"+row.pagina_web+"</a></span><br/><small class='text-info' style='font-size: 10px'><strong>"+row.no_empleados+" Empleados</strong></small></strong>";
                        }},
                        {data: 'contacto', render:function(data,type,row){
                            return "<strong>"+row.contacto+" <br/><span style='font-size:12px'>"+row.email+"</span><br/><small class='text-info' style='font-size: 10px'><strong>"+row.telefonos+"</strong></small></strong>";
                        }},               
                        {data: 'primer_llamada', render:function(data,type, row){
                            return "<strong>"+row.siguiente_llamada+" <br/><span style='font-size:12px'>"+row.ultima_llamada +"</span><br/><small class='text-info' style='font-size: 10px'><strong>"+row.primer_llamada+" </strong></small></strong>";
                        }},               
                        {data: 'conveniador', render:function(data, type, row){
                            return "<strong>"  + row.conveniador + "<br/><span style='font-size:12px'>"+row.estado+"</span></strong>";
                        }},
                        {data: 'estatus', render:function(data, type, row){
                            return "<strong class='label' style='background-color:"+row.color+";'>"+data+"<br/><span style='font-size:12px'></span></strong>";
                        }},
                        {data: 'action', name: 'action', orderable: true, searchable: true}
                    ]
                });
            }
        })
        .fail(function() {
             toasrt['error']('¡Error, intenta mas tarde!');
            $("#overlay").css("display", "none");
        })
        .always(function() {
            $("#overlay").css("display", "none");
        });
        


    }
</script>
@endsection
