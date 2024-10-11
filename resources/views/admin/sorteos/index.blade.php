@extends('layouts.admin.app')
@section('content')
<div class="row page-titles">
    <div class="col-md-5 col-8 align-self-center">
        <h3 class="text-themecolor">
            <a href="{{ route('sorteos.index') }}">
                Sorteos
            </a>
        </h3>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('dashboard') }}">
                    Home
                </a>
            </li>
            <li class="breadcrumb-item active">
                Sorteos
            </li>
        </ol>
    </div>
</div>
<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="card">
            <div class="card-header">
                <div class="card-actions">
                    {{-- @if (Auth::user()->can('create', App\Tarjeta::class)) --}}
                    <button class="btn btn-info btn-xs" data-toggle="modal" id="btnAddSorteo">
                        <span>
                            <i class="fas fa-plus">
                            </i>
                            Nuevo sorteo
                        </span>
                    </button>
                    {{-- @endif --}}
                </div>
                <h4 class="card-title m-b-0">
                    Sorteos registrados
                </h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover dataTable" id="table_sorteos" role="grid" style="width:100%">
                        <thead>
                            <tr role="row">
                                <th aria-sort="ascending" class="sorting_asc">
                                    Folio
                                </th>
                                <th aria-controls="" aria-label="" aria-sort="ascending" class="sorting_asc" colspan="1" rowspan="1" tabindex="0">
                                    Convenio
                                </th>
                                <th aria-controls="" aria-label="" class="sorting" colspan="1" rowspan="1" tabindex="0">
                                    Llave
                                </th>
                                <th aria-controls="" aria-label="" class="sorting" colspan="1" rowspan="1" tabindex="0">
                                    Fecha de inicio
                                </th>
                                <th aria-controls="" aria-label="" class="sorting" colspan="1" rowspan="1" tabindex="0">
                                    Fecha de fin
                                </th>
                                <th aria-controls="" aria-label="" class="sorting" colspan="1" rowspan="1" tabindex="0">
                                    Estatus
                                </th>
                                <th aria-controls="" aria-label="" class="sorting" colspan="1" rowspan="1" tabindex="0">
                                    Registros
                                </th>
                                <th aria-controls="" aria-label="" class="sorting" colspan="1" rowspan="1" tabindex="0" width="80">
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
<!-- Modal -->
<div aria-hidden="true" aria-labelledby="sorteoModalTitle" class="modal fade" id="modalSorteo" role="dialog" tabindex="-1">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="sorteoModalTitle">
                    Crear nuevo sorteo
                </h5>
                <button aria-label="Close" class="close" data-dismiss="modal" type="button">
                    <span aria-hidden="true">
                        ×
                    </span>
                </button>
            </div>
            <form action="{{ route('sorteos.store') }}" id="formSorteo" method="post">
                <div class="modal-body">
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label for="tipo_sorteo">
                                Tipo de sorteo
                            </label>
                            <select class="form-control" id="tipo_sorteo" name="tipo_sorteo" style="width: 95%;">
                                <option value="general">General</option>
                                <option value="especial">Especial</option>
                                <option value="multimedia">Multimedia</option>
                            </select>
                        </div>
                        <div class="form-group col-md-12" id="div_convenio">
                            <label for="inputEmail4">
                                Convenio
                            </label>
                            <select class="form-control select2 select2-hidden-accessible custom-select" id="convenio_id" name="convenio_id" style="width: 95%;">
                                <option value="">
                                    Selecciona un convenio
                                </option>
                                @foreach ($convenios as $convenio)
                                <option value="{{$convenio->id}}">
                                    {{$convenio->empresa_nombre}}
                                </option>
                                @endforeach
                            </select>
                            <br>
                                <span class="text-danger error-convenio_id errors">
                                </span>
                            </br>
                        </div>
                         <div class="form-group col-md-12" id="div_nombre">
                            <label for="nombre">
                                Nombre
                            </label>   
                            <input type="text" class="form-control" id="nombre" name="nombre">
                            <br>
                                <span class="text-danger error-nombre errors">
                                </span>
                            </br>
                        </div>
                         <div class="form-group col-md-12" id="div_llave">
                            <label for="llave">
                                Llave de acceso
                            </label>   
                            <input type="text" class="form-control" id="llave" name="llave">
                            <br>
                                <span class="text-danger error-llave errors">
                                </span>
                            </br>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="fecha_inicio">
                                Fecha de inicio
                            </label>
                            <input autocomplete="off" class="form-control datepicker" id="fecha_inicio" name="fecha_inicio" type="text">
                            </input>
                            <span class="text-danger error-fecha_inicio errors">
                            </span>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="fecha_fin">
                                Fecha de fin
                            </label>
                            <input autocomplete="off" class="form-control datepicker" id="fecha_fin" name="fecha_fin" type="text">
                            </input>
                            <span class="text-danger error-fecha_fin errors">
                            </span>
                        </div>
                    </div>
{{--                     <div class="form-group">
                        <div class="form-check">
                            <input class="form-check-input" id="sorteo_especial" name="sorteo_especial" type="checkbox" value="1">
                                <label class="form-check-label" for="sorteo_especial">
                                    Sorteo especial
                                </label>
                            </input>
                        </div>
                    </div> --}}
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary btn-sm" data-dismiss="modal" type="button">
                        Cerrar
                    </button>
                    <button class="btn btn-primary btn-sm" type="submit">
                        Guardar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Modal Editar -->
<div aria-hidden="true" aria-labelledby="sorteoTitle" class="modal fade" id="modalUpdateSorteo" role="dialog" tabindex="-1">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="sorteoTitle">
                    Editar sorteo
                </h5>
                <button aria-label="Close" class="close" data-dismiss="modal" type="button">
                    <span aria-hidden="true">
                        ×
                    </span>
                </button>
            </div>
            <div class="modal-body">
                
            </div>
        </div>
    </div>
</div>
@endsection


@section('script')
<script>
    $(document).ready(function() {
        var user_id = "{{ Auth::user()->id }}";
        $('#div_llave').hide();
        $('#div_nombre').hide();
        $('#sorteo_especial').on('change', function(event) {
            event.preventDefault();
            if ($(this).is(':checked')) {
                toastr['info']('Se generaran tres campos adicionales al registro del sorteo (# de empleado, empresa y sucursal)');
            }else{
                toastr['info']('Registro tradicional del sorteo');
            }
        });

        $('#convenio_id').select2({
            // Funcionamiento correcto dentro de modales 
            dropdownParent: $('#modalSorteo')
        });


        $('#tipo_sorteo').change(function(event) {
            event.preventDefault();
            var tipo =  $(this).val();

            if (tipo == 'general') {
                toastr['info']('Registro tradicional del sorteo');
                $('#div_convenio').show();
                $('#div_llave').hide();
                $('#div_nombre').hide();
            }else if(tipo == 'especial'){
                toastr['info']('Se generaran tres campos adicionales al registro del sorteo (# de empleado, empresa y sucursal)');
                $('#div_convenio').show();
                $('#div_llave').hide();
                $('#div_nombre').hide();
            }else if(tipo == 'multimedia'){
                toastr['info']('Se generaran 4 campos adicionales para la carga de 3 archivos multimedia y 1 testimonio (caso exclusivo para sorteos a clientes en general)');
                $('#div_convenio').hide();
                $('#div_llave').show();
                $('#div_nombre').show();
            }
        });

        // $('.datepicker').datepicker({
        //     dateFormat: "yy-mm-dd",
        //     startDate: '-1d',
        //     endDate: '+2m',
        //     autoclose:true,
        //     language: 'es'
        // });


        $('.datepicker').bootstrapMaterialDatePicker({
            weekStart: 0,
            time: false,
            lang: 'es',
        });


        $('#formUpdateSorteo #datepicker_material').bootstrapMaterialDatePicker({
            weekStart: 0,
            time: false,
            lang: 'es',
        });
        

        /**
         * Autor: Isw. Diego Enrique Sanchez
         * Creado: 2022-05-30
         * Listar  sorteos registrados en DB
         */
        var tabla = $('#table_sorteos').DataTable({
            'responsive': true,
            'searching': true,
            'lengthMenu': [[10, 50, -1], [10, 50, "Todo"]],
            'pageLength': 10,
            "order": [ 0, 'DESC' ],
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
                "mData": "6"
                }
            ],
            "ajax": {
                url: baseadmin + "sorteos-listar/" + user_id,
                type: "get",
                dataType: "json",
                error: function(e) {
                  console.log(e.responseText);
                }
            },
        });


        $('#btnAddSorteo').on('click', function(event) {
            event.preventDefault();
            $('#modalSorteo').modal('show');
        });

        $('#formSorteo').on('submit', function(event) {
            event.preventDefault();
            $.ajax({
                url: $(this).attr('action'),
                type: $(this).attr('method'),
                dataType: 'JSON',
                data: $(this).serialize(),
                beforeSend:function(){
                    $("#overlay").css("display", "block");
                },
                success:function(res){
                    if (res.success == false) {
                        pintar_errores(res.errors);
                    }else{                    
                        $('#formSorteo').trigger('reset');
                        $('#modalSorteo').modal('hide');
                        toastr["success"]('¡Se ha registrado un nuevo sorteo exitosamente!');
                        tabla.ajax.reload();
                    }
                }
            })
            .always(function() {
                $("#overlay").css("display", "none");
            });
            
        });


        $(document).on('click', '#btnEditar', function(event) {
            event.preventDefault();
            /* Act on the event */
            var url =  $(this).attr('href');

            $.ajax({
                url: url,
                type: 'GET',
                dataType: 'JSON',
                beforeSend:function(){
                    $("#overlay").css("display", "block");
                },
                success:function(res){
                    $('#modalUpdateSorteo .modal-body').html(res.view);
                    $('#modalUpdateSorteo').modal('show');
                    $('#convenio_id_update').select2({
                        dropdownParent: $('#modalUpdateSorteo')
                    });
                    
                }

            })
            .always(function() {
                 $("#overlay").css("display", "none");
            });
        });


        $(document).on('submit','#formUpdateSorteo', function (event) {
            event.preventDefault();
            $.ajax({
                url: $(this).attr('action'),
                type: $(this).attr('method'),
                dataType: 'JSON',
                data: $(this).serialize(),
                beforeSend:function(){
                    $("#overlay").css("display", "block");
                },
                success: function (res) {
                    if (res.success === true) {
                        $('#modalUpdateSorteo').modal('hide');
                        toastr["success"]('El sorteo se ha modificado correctamente!');
                        tabla.ajax.reload();
                    }               
                    
                }
                
            }).always(function() {
                $("#overlay").css("display", "none");
            });
        });
        
        $(document).on('change','#statusSorteo', function(event){
            // Obtener el valor actual del checkbox
            let valorActual = $(this).prop('checked');

            // Cambiar el valor del checkbox
            $('#statusSorteo').prop('checked', !valorActual);

            // Cambiar el texto del label basado en el nuevo estado del checkbox
            let texto = valorActual ? 'Finalizar' : 'Finalizado';
            $(this).closest('label').find('.texto-checkbox').text(texto);
        })
    });
</script>
@endsection
