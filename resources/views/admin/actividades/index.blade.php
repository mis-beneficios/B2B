@extends('layouts.admin.app')
@section('content')
@livewireStyles
@livewireScripts
<style>
    .span_blocks{

    }
    #table_ejecutivos{

    }
</style>
<div class="row page-titles">
    <div class="col-md-5 col-8 align-self-center">
        <h3 class="text-themecolor">
            Bitácora de actividades
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
{{-- <div class="row"> --}}
    {{-- <div class="col-lg-3 col-md-5"> --}}
        @livewire('actividad.listar-ejecutivos')
    {{-- </div> --}}
    {{-- <div class="col-lg-9 col-md-7">
        @livewire('actividad.listar-actividades')
    </div> --}}
{{-- </div> --}}

{{-- <div class="row">
    <div class="col-md-3">
        <div class="card">
            <div class="card-header">
                <div class="card-actions">
                    <button class="btn btn-info btn-xs" data-toggle="modal" id="btnAddSorteo">
                        <span>
                            <i class="fas fa-plus">
                            </i>
                            Nueva actividad
                        </span>
                    </button>
                </div>
                <h4 class="card-title m-b-0">
                    Ejecutivos
                </h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table aria-describedby="" class="table table-hover dataTable" id="table_ejecutivos" role="grid" style="width:100%">
                        <thead>
                            <th>
                                Nombre
                            </th>
                            <th>
                                Act
                            </th>
                            <th>
                                Driv
                            </th>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
                <form>
                    <div class="row">
                        <div class="col">
                            <label for="">
                                Desde
                            </label>
                            <input autocomplete="off" class="form-control datepicker" id="desde" name="desde" type="text" value="{{ date('Y-m-d') }}">
                            </input>
                        </div>
                        <div class="col">
                            <label for="">
                                Hasta
                            </label>
                            <input autocomplete="off" class="form-control datepicker" id="hasta" name="hasta" type="text" value="{{ date('Y-m-d') }}">
                            </input>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="col-lg-9 col-md-9">
        <div class="card" id="drive">
            <div class="card-body">
                <div class="d-flex flex-wrap">
                    <div>
                        <h4 class="card-title">
                            Drive
                        </h4>
                    </div>
                </div>
                <div class="">
                </div>
            </div>
        </div>
    </div>
</div> --}}
@endsection
@section('script')
<script>
    $(document).ready(function() {
        var concals;
        // $('.datepicker').datepicker({
        //     dateFormat: 'yy-mm-dd',
        //     // startDate: '-1d',
        //     endDate: '+2m',
        //     autoclose:true,
        //     language: 'es'
        // });

        
        $('.datepicker').bootstrapMaterialDatePicker({
            weekStart: 0,
            time: false,
            lang: 'es',
        });


        pintar_ejecutivos();

        // $('#form_concals').on('submit', function(event) {
        //     event.preventDefault();
        //     pintar_concals($(this).serialize());
        // });

        $('#hasta').on('change', function(event) {
            event.preventDefault();
            if ($('#desde').val() == '') {
                toastr['warning']('Selecciona una  fecha de inicio');
            }

            let data = {'desde':$('#desde').val(),'hasta':$('#hasta').val()};

            console.log(data);

            pintar_ejecutivos(data);
        });
        var tabla_historial 

 
        $(document).on('click', '#btnDrive', function(event) {
            event.preventDefault();
            var user_id = $(this).data('id');
            var desde = $(this).data('desde');
            var hasta = $(this).data('hasta');

            $.ajax({
                url: baseadmin + 'get-drive/',
                type: 'GET',
                dataType: 'json',
                data:{
                    user_id: user_id,
                    desde:desde,
                    hasta:hasta,
                },
                beforeSend:function(){
                    $("#overlay").css("display", "block");
                },
                success:function(res){
                    $('#drive').html(res.view);
                }
            })
            .always(function() {
                $("#overlay").css("display", "none");
            });
        });


        $(document).on('click', '#logConcal', function(event) {
            event.preventDefault();
            var concal_id = $(this).data('id');
            var url = baseadmin + 'get-log/'+concal_id;
            $.ajax({
                url:  url,
                type: 'GET',
                dataType: 'json',
                beforeSend:function(){
                    $("#overlay").css("display", "block");
                },
                success:function(res){
                    $('#modalEmpresa #modalEmpresaLabel').html('Concal Log');
                    $('#modalEmpresa').modal('show');
                    $('#modalEmpresa .modal_body').html(res.log);
                }
            })
            .always(function() {
                $("#overlay").css("display", "none");
            });
        });


        // $(document).on('submit', '#formConcal', function(event) {
        //     event.preventDefault();
        //     $.ajax({
        //         url: $(this).attr('action'),
        //         type: $(this).attr('method'),
        //         dataType: 'json',
        //         data: $(this).serialize(),
        //         beforeSend:function(){
        //             $("#overlay").css("display", "block");
        //         },
        //         success:function(res){
        //             if (res.success = true) {
        //                 tabla_historial.ajax.reload();
        //                 pintar_concals();
        //                 $('#modalEmpresa').modal('hide');
        //                 toastr['success']('¡Registro exitoso!');
        //                 if (res.convenio != false) {
        //                     toastr['info']('Se ha creado una nueva liga <a href="'+res.convenio+'" class="btn btn-xs btn-dark">Ver</a>');
        //                 }
        //             }else
        //             {
        //                 toastr['error']('¡Intentar mas tarde!');
        //             }
        //         }
        //     })
        //     .always(function() {
        //         $("#overlay").css("display", "none");
        //     });
        // });

        // $(document).on('change', '#formConcal #estatus', function(event) {
        //     event.preventDefault();
        //     if ($(this).val() == 'cerrado') {
        //         alertify.confirm('¿Desea crear la liga para esta empresa?',function(){
        //             $('#formConcal #create_convenio').val(1); 
        //             toastr['info']('Se creara un nuevo registro de un convenio asociado a esta empresa');
        //         }
        //         ,function(){
        //             $('#formConcal #create_convenio').val(0);
        //             toastr['warningn']('No se creara la liga correspondiente');
        //         });
        //     }
        // });
    });

    function pintar_ejecutivos(data = null) {
        
        $('#table_ejecutivos').DataTable({
            'responsive': true,
            'searching': false,
            "paging": false,
            "destroy": true,
            "ordering":  false,
            "aoColumns": [{
                "mData": "1"
                },{
                "mData": "2"
                },{
                "mData": "3"
                }
            ],
            "ajax": {
                url: baseadmin + "listar-ejecutivos",
                type: "get",
                dataType: "json",
                data: data,
                error: function(e) {
                  console.log(e.responseText);
                }
            },
        });
    }
</script>
@endsection
