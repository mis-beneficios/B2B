@extends('layouts.admin.app')
@section('content')
@livewireStyles
@livewireScripts
<style>
    .span_blocks{

    }
</style>
<div class="row page-titles">
    <div class="col-md-5 col-8 align-self-center">
        <h3 class="text-themecolor">
            Calendario de seguimientos a empresas
        </h3>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('dashboard') }}">
                    Home
                </a>
            </li>
            <li class="breadcrumb-item active">
                Seguimientos
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
                            Calendarios de seguimientos a empresas
                        </h4>
                    </div>
                    <div class="ml-auto">
                        <button class="btn btn-dark btn-sm" id="btnReloadConcals"><i class="fas fa-refresh"></i></button>
                        <button class="btn btn-primary btn-sm btnEmpresa" data-type="nuevo" type="button">
                            <i class="fas fa-plus"></i>
                            Nueva seguimiento de empresa
                        </button>
                    </div>
                </div>
                <form action="" id="form_concals_v2" method="get">
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
                                    <input class="form-control datepicker" id="inicio_rango" name="inicio_rango" type="text">
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
                                    <input class="form-control datepicker" id="fin_rango" name="fin_rango" type="text">
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
                                    <select name="mostrar" id="mostrar" class="form-control">
                                        <option value="todos">Todos</option>
                                        <option value="mios">Mios</option>
                                    </select>
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
                                            Todos
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
            {{--             <button class="btn btn-dark btn-sm" id="btnTodo" type="button">
                            <i class="fas fa-eye">
                            </i>
                            Mostrar todo
                        </button> --}}
                    </div>
                </form>
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
                        </tbody>
                    </table>
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
        var datable;

        $('.datepicker').bootstrapMaterialDatePicker({
            weekStart: 0,
            time: false,
            lang: 'es',
        });

        if( $('#sucursal_lugar').val() == 1){
            $('#sucursal_lugar').css('display','block')
        }else{
            $('#sucursal_lugar').css('display','none')
        }
        
        $(document).on('change', '#sucursales', function(event) {
            event.preventDefault();
            if ($(this).val() == 1) {
                $('#sucursal_lugar').css('display','block')
            }else{
                $('#sucursal_lugar').css('display','none')
            }
        });
        // pintar_concals();
        pintar_seguimientos();
        
        $(document).on('click', '#btnReloadConcals', function(event) {
            event.preventDefault();
            toastr['info']('Recargando datos...')
            // datable.ajax.reload();
            pintar_seguimientos();
        });

        $(document).on('click', '#btnTodo', function(event) {
            event.preventDefault();
            toastr['info']('Recargando datos...')
            pintar_seguimientos();
        });


        $(document).on('submit', '#form_concals_v2', function(event) {
            event.preventDefault();
            pintar_seguimientos();
        });

        var tabla_historial = $('#concals_table').DataTable({
            'responsive': true,
            'searching': false,
            'ordering': false,
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
            .fail(function(jqXHR, textStatus, errorThrown) {
                toastr['error'](errorThrown);
                toastr['error'](jqXHR);
                $("#overlay").css("display", "none");
            })
            .always(function() {
                $("#overlay").css("display", "none");
            });
        });


       /** $(document).on('click', '#btnGuardarConcal', function(event) {
            event.preventDefault();
            $.ajax({
                url: $('#formConcal').attr('action'),
                type: $('#formConcal').attr('method'),
                dataType: 'json',
                data: $('#formConcal').serialize(),
                beforeSend:function(){
                    $("#overlay").css("display", "block");
                },
                success:function(res){
                    console.log(res);
                    if (res.success == true) {
                        tabla_historial.ajax.reload();
                        pintar_seguimientos();
                        $('#btnSubmit').click();
                        $('#modalEmpresa').modal('hide');
                        
                        Swal.fire({
                            icon: 'success',
                            title: '¡Registro exitoso!',
                            showConfirmButton: true,
                        })
                        
                        if (res.convenio != false) {
                            Swal.fire({
                              icon: 'info',
                              html: res.convenio,
                              showConfirmButton: true,
                            })
                        }
                    }else
                    {
                        pintar_errores(res.errors);
                    }
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
    **/
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
                        //pintar_seguimientos();
                        $('#nombre').val(res.concal.empresa);
                        $('#btnSubmit').click();
                        $('#modalEmpresa').modal('hide');
                        
                        Swal.fire({
                            icon: 'success',
                            title: '¡Registro exitoso!',
                            showConfirmButton: true,})
                        
                      if (res.convenio != false) {
                             Swal.fire({
                               icon: 'info',
                               html: res.convenio,
                               showConfirmButton: true,
                             })
                         }
                     }else
                     {
                         pintar_errores(res.errors);
                     }
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

        $(document).on('change', '#formConcal #estatus', function(event) {
            event.preventDefault();
            if ($(this).val() == 'cerrado') {
                Swal.fire({
                    title: 'Convenio',
                    text: "¿Desea crearlo como nuevo registro de convenio?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Si',
                    cancelButtonText: 'No'
                })
                .then((result) => {
                    if (result.isConfirmed) {
                        $('#formConcal #create_convenio').val(1); 
                        Swal.fire(
                          '',
                          'Se creara la liga de compra correspondiente a esta empresa',
                          'success'
                        )
                    }else if (result.isDenied) {
                       $('#formConcal #create_convenio').val(0);
                    }
                })
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
                        $('#btnSubmit').click();
                        // datable.ajax.reload();
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
                    'searching': false,
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

    function pintar_seguimientos() {   
        datable=$('#convenios_table').DataTable({
            processing: true,
            serverSide: true,
            bDestroy: true,
            order: [0, 'desc'],
            bInfo: true,
            searching: true,
            ajax: {
                url: baseadmin + 'get-calendar',
                data: function (d) {
                    d.nombre = $('input[name=nombre]').val();
                    d.user_id = $('input[name=user_id]').val();
                    d.role = $('input[name=role]').val();
                    d.inicio_rango = $('input[name=inicio_rango]').val();
                    d.fin_rango = $('input[name=fin_rango]').val();
                    d.mostrar = $('select[name=mostrar]').val();
                    d.estatus_concal = $('select[name=estatus_concal]').val();
                }
            },
            columns: [
                {data: 'empresa', name: 'empresa'},
                {data: 'contacto', name: 'contacto'},
                {data: 'primer_llamada', name: 'primer_llamada'},
                {data: 'conveniador', name: 'conveniador'},
                {data: 'estatus', name: 'estatus'}, 
                {data: 'action', name: 'action', orderable: true, searchable: true}
            ]
        });

        // $.ajax({
        //     url: baseadmin + 'get-calendar',
        //     type: 'GET',
        //     dataType: 'JSON',
        //     data: fromData,
        //     beforeSend:function(){
        //         $("#overlay").css("display", "block");
        //     },
        //     success:function(res){
        //         $datable=$('#convenios_table').DataTable({
        //             processing: true,
        //             serverSide: true,
        //             bDestroy: true,
        //             // paging: true,
        //             searching: true,
        //             order: [0,'DESC'],
        //             data: res.data,
        //             columns: [
        //                 // {data: 'empresa', render:function(data,type,row){
        //                 //     return "<strong>"+row.empresa+ "<br/><span style='font-size:12px'><a href='javascript():;'>"+row.pagina_web+"</a></span><br/><small class='text-info' style='font-size: 10px'><strong>"+row.no_empleados+" Empleados</strong></small></strong>";
        //                 // }},
        //                 // {data: 'contacto', render:function(data,type,row){
        //                 //     return "<strong>"+row.contacto+" <br/><span style='font-size:12px'>"+row.email+"</span><br/><small class='text-info' style='font-size: 10px'><strong>"+row.telefonos+"</strong></small></strong>";
        //                 // }},               
        //                 // {data: 'primer_llamada', render:function(data,type, row){
        //                 //     return "<strong>"+row.siguiente_llamada+" <br/><span style='font-size:12px'>"+row.ultima_llamada +"</span><br/><small class='text-info' style='font-size: 10px'><strong>"+row.primer_llamada+" </strong></small></strong>";
        //                 // }},               
        //                 // {data: 'conveniador', render:function(data, type, row){
        //                 //     return "<strong>"  + row.conveniador + "<br/><span style='font-size:12px'>"+row.estado+"</span></strong>";
        //                 // }},
        //                 // {data: 'estatus', render:function(data, type, row){
        //                 //     return "<strong class='label' style='background-color:"+row.color+";'>"+data+"<br/><span style='font-size:12px'></span></strong>";
        //                 // }},
        //                 {data: 'empresa', name: 'empresa'},
        //                 {data: 'contacto', name: 'contacto'},
        //                 {data: 'primer_llamada', name: 'primer_llamada'},
        //                 {data: 'conveniador', name: 'conveniador'},
        //                 {data: 'estatus', name: 'estatus'},
        //                 // {data: 'id', name: 'id'}, 
        //                 {data: 'action', name: 'action', orderable: true, searchable: true}
        //             ]
        //         });
        //     }
        // })
        // .fail(function(jqXHR, textStatus, errorThrown) {
        //     toastr['error'](errorThrown);
        //     toastr['error'](jqXHR.responseJSON.message);
        //     $("#overlay").css("display", "none");
        // })
        // .always(function() {
        //     $("#overlay").css("display", "none");
        // });
    }
</script>
@endsection

{{-- Yair

Paginas web

Beneficios Vacacionales
https://beneficiosvacacionales.mx/
https://beneficiosvacacionales.com/
https://misbeneficiosvacacionales.com/

Optucorp
https://optucorp.com/
https://travelingbenefits.com/
https://mytravel-benefits.com/

Amando a Mexico
https://amandoamexico.com.mx/

Home Travel
https://hometravel.com.mx/
https://hometravel.us/ (vacia)

Takos y Kekas
https://takosykekas.com/

World Adventures
https://world-adventures.us/
https://homevacation.world-adventures.us

Si nos dejan
https://sinosdejan.es/

Memorias Perdurables 
https://memoriasperdurables.com/ --}}
