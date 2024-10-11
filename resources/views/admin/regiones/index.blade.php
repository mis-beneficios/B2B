@extends('layouts.admin.app')
@section('content')
<div class="row page-titles">
    <div class="col-md-5 col-8 align-self-center">
        <h3 class="text-themecolor">
            <a href="{{ route('dashboard') }}">
                Dashboard
            </a>
        </h3>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('dashboard') }}">
                    Home
                </a>
            </li>
            <li class="breadcrumb-item active">
                Regiones
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
                    <button class="btn btn-info btn-xs" id="btnAddRegion">
                        <span>
                            <i class="fas fa-plus">
                            </i>
                            Agregar region
                        </span>
                    </button>
                    {{-- @endif --}}
                </div>
                <h4 class="card-title m-b-0">
                    Regiones
                </h4>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover dataTable" id="table_regiones" role="grid" style="width:100%">
                                <thead>
                                    <tr role="row">
                                        <th>
                                            #
                                        </th>
                                        <th aria-sort="ascending" class="sorting_asc">
                                            Pais
                                        </th>
                                        <th aria-controls="" aria-label="" aria-sort="ascending" class="sorting_asc" colspan="1" rowspan="1" tabindex="0">
                                            Titulo
                                        </th>
                                        <th aria-controls="" aria-label="" class="sorting" colspan="1" rowspan="1" tabindex="0">
                                            Creado
                                        </th>
                                        <th aria-controls="" aria-label="" class="sorting" colspan="1" rowspan="1" tabindex="0">
                                            Temporadas
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
    </div>
</div>
<!-- Modal -->
<div aria-hidden="true" aria-labelledby="exampleModalLongTitle" class="modal fade" id="modalRegion" role="dialog" tabindex="-1">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">
                    Agregar región
                </h5>
                <button aria-label="Close" class="close" data-dismiss="modal" type="button">
                    <span aria-hidden="true">
                        ×
                    </span>
                </button>
            </div>
            <form action="{{ route('regiones.store') }}" id="formRegion" method="post">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <label for="">
                                Pais
                            </label>
                            <select class="form-control" id="paise_id" name="paise_id">
                                @foreach ($paises as $pais)
                                <option value="{{ $pais->id }}">
                                    {{ $pais->title }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-12 mt-3">
                            <label for="">
                                Titulo de la región
                            </label>
                            <input class="form-control" id="title" name="title" type="text">
                            </input>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" data-dismiss="modal" type="button">
                        Cerrar
                    </button>
                    <button class="btn btn-primary" type="submit">
                        Guardar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Modal Listar Temporadas -->
<div aria-hidden="true" aria-labelledby="exampleModalLongTitle" class="modal fade" id="modalTemporadas" role="dialog" tabindex="-1">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">
                    Temporadas
                </h5>
                <button aria-label="Close" class="close" data-dismiss="modal" type="button">
                    <span aria-hidden="true">
                        ×
                    </span>
                </button>
            </div>
            <div class="modal-body table-responsive">
                <table class="table table-hover dataTable" id="table_temporadas" style="width:100%">
                    <thead>
                        <tr role="row">
                            <th>#</th>
                            <th>
                                Titulo
                            </th>
                            <th>
                                Fecha de inicio
                            </th>
                            <th>
                                Fecha de fin
                            </th>
                            <th>
                                Opciones
                            </th>
                        </tr>
                    </thead>
                </table>
            </div>
            <div class="modal-footer">
                <button class="btn secondary btn-sm" data-dismiss="modal" type="button">
                    Cerrar
                </button>
            </div>
        </div>
    </div>
</div>
<!-- Modal -->
<div aria-hidden="true" aria-labelledby="modalAddTemporada" class="modal fade" id="modalAddTemporada" role="dialog" tabindex="-1">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalAddTemporada">
                    Agregar temporada
                </h5>
                <button aria-label="Close" class="close" data-dismiss="modal" type="button">
                    <span aria-hidden="true">
                        ×
                    </span>
                </button>
            </div>
            <div class="modal-body d-flex justify-content-end">
                <button class="btn btn-info btn-sm" id="btnAdd" type="button">
                    <i class="fa fa-plus">
                    </i>
                    {{ __('messages.cliente.agregar') }}
                </button>
            </div>
            <form action="{{ route('temporadas.store') }}" autocomplete="off" id="formTemporadas" method="post">
                <input id="region_id" name="region_id" type="hidden" value=""/>
                @csrf
                <div class="modal-body">
                    <table class="table" id="dynamic_field">
                        <tbody>
                        </tbody>
                    </table>
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
<div aria-hidden="true" aria-labelledby="modalEditTemporada" class="modal fade" id="modalEditTemporada" role="dialog" tabindex="-1">
    <div class="modal-dialog" role="document">
        <div class="modal-content modal-dialog-scrollable">
            <div class="modal-header">
                <h5 class="modal-title" id="modalEditTemporadaTitle">
                    Editar temporada
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
        var cont = 0;
        var table_temporadas;

        $('#convenio_id').select2({
            // Funcionamiento correcto dentro de modales 
            dropdownParent: $('#modalSorteo'),
            allowClear: true
        });

        $('body').on('click', '#btnAdd', function(event) {
            event.preventDefault();
            cont++;
            
            $('#dynamic_field').append('<tr id="row' + cont + '"><td><select class="form-control" id="temporada" name="temporada[]"><option value="ALTA">ALTA</option><option value="MEDIA ALTA">MEDIA ALTA</option><option value="BAJA">BAJA</option></select></td><td><input class="form-control datepicker" data-date-format="yyyy-mm-dd" data-provide="datepicker" name="fecha_inicio[]" type="text"/></td><td><input class="form-control datepicker" data-date-format="yyyy-mm-dd" data-provide="datepicker" name="fecha_fin[]" type="text"/></td><td><button class="btn btn-danger btn_remove btn-sm" id="' + cont + '" name="remove" type="button"><span class="fa fa-trash"></span></button></td></tr>');
      
        });

        $(document).on('click', '.btn_remove', function() {
            var button_id = $(this).attr("id");
            $('#dynamic_field #row' + button_id + '').remove();
        });


        $('#dynamic_field input').datepicker({});

        $('.datepicker').datepicker({
            dateFormat: "yy-mm-dd",
            startDate: '-1d',
            endDate: '+2m',
            autoclose:true,
            language: 'es'
        });

        var tabla = $('#table_regiones').DataTable({
            'responsive': true,
            'searching': true,
            'lengthMenu': [[10, 50, -1], [10, 50, "Todo"]],
            'pageLength': 10,
            // "order": [[ 0, "ASC" ]],
            "aoColumns": [{
                "mData": "5"
                },{
                "mData": "0"
                }, {
                "mData": "1"
                },{
                "mData": "2"
                }, {
                "mData": "3"
                }, {
                "mData": "4"
                }
            ],
            "ajax": {
                url: baseadmin + "get-regiones",
                type: "get",
                dataType: "json",
                // beforeSend:function(){
                //     console.log('esperando');
                // },
                // success:function(){
                //     console.log('finalizo');
                // },
                error: function(e) {
                    toastr['error'](e.responseText);
                }
            },
        });


        /**
         * Crear y Editar las regiones registradas
         */
        $('#btnAddRegion').on('click', function(event) {
            event.preventDefault();
            $('#formRegion').attr({
                'action': '{{ route('regiones.store') }}',
                'method': 'POST'
            });

            $('#modalRegion').modal('show');
        });

        $('#formRegion').on('submit', function(event) {
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
                        tabla.ajax.reload();
                        $('#modalRegion').modal('hide');
                        $('#formRegion').trigger('reset');
                        toastr['success']('¡Registro exitoso!.')
                    }else{
                        toastr['success']('Intentalo mas tarde...')
                    }
                
                }
            })
            .fail(function(jqXHR, textStatus, errorThrown) {
                $("#overlay").css("display", "none");
                toastr['error'](errorThrown);
                toastr['error'](jqXHR.responseJSON.message);
            })
            .always(function() {
                $("#overlay").css("display", "none");
            });
            
        });

        $('body').on('click', '#btnEdit', function(event) {
            event.preventDefault();
            var banco_id = $(this).data('id');
            
            var route = $(this).data('route');
            var route_update = $(this).data('route-update');
            
            $.ajax({
                url: route,
                type: 'GET',
                dataType: 'JSON',
                beforeSend:function(){
                     $("#overlay").css("display", "block");
                },
                success:function(res){
                    if (res.success == true) {
                        $('#formRegion').attr({
                            'action': route_update,
                            'method': 'PUT'
                        });
                        $('#title').val(res.region.title);
                        // $('#ignorar_en_via_serfin').val(res.region.ignorar_en_via_serfin);
                        $('#paise_id').val(res.region.paise_id);
                        $('#modalRegion').modal('show');
                    }
                }
            })
            .fail(function() {
                toastr['error']('Ha ocurrido un error, inténtalo más tarde.');
            })
            .always(function() {
                 $("#overlay").css("display", "none");
            });
            
        });


        $('body').on('click','#btnListarRegiones', function(event) {
            event.preventDefault();
            var region_id = $(this).data('id');
            $.ajax({
                url: $(this).data('route'),
                type: 'GET',
                dataType: 'JSON',
                success:function(res){
                    console.log(res);
                      
                        table_temporadas = $('#table_temporadas').dataTable({
                            'responsive': true,
                            'searching': false,
                            "order": [[ 2, "DESC" ]],
                            "aoColumns": [{
                                "mData": "5"
                            },{
                                "mData": "0"
                            }, {
                                "mData": "1"
                            }, {
                                "mData": "2"
                            }, {
                                "mData": "3"
                            }],
                            data: res.aaData,
                            "bDestroy": true
                        }).DataTable();

                        $('#modalTemporadas').modal('show');
                
                }
            })
            .always(function() {
                console.log("complete");
            });
            
        });

        $('body').on('click', '#btnAddTemporada', function(event) {
            event.preventDefault();
            $('#region_id').val($(this).data('id'));
            $('#modalAddTemporada').modal('show');
        });

        $('#formTemporadas').on('submit', function(event) {
            event.preventDefault(); 
            $.ajax({
                url: $(this).attr('action'),
                type: $(this).attr('method'),
                dataType: 'json',
                data: $(this).serialize(),
                beforeSend:function(){
                    $('#overlay').css('display','block');
                },
                success:function(res){
                    if (res.success != true) {
                        toastr['error'](res.errors);
                    }
                    $('#dynamic_field').html('');
                    tabla.ajax.reload();
                    toastr['success']('¡Registro exitoso!');
                    $(this).trigger('reset');
                    $('#modalAddTemporada').modal('hide');
                }
            })
            .always(function() {
                $('#overlay').css('display','none');
            });
            
        });


        $('body').on('click', '#btnEliminar', function(event) {
            event.preventDefault();
            toastr['info']('Accion no permitida');
        });


        $('body').on('click', '#btnEliminarTemporada', function(event) {
            event.preventDefault();
            $.ajax({
                url: $(this).data('route'),
                type: 'DELETE',
                dataType: 'JSON',
                beforeSend:function(){
                    $('#overlay').css('display','block');
                },
                success:function(res){
                    if (res.success != true) {
                        toastr['error']('¡Inténtalo mas tarde!');
                    }
                    // table_temporadas.ajax.reload();
                    $('#table_regiones').DataTable().ajax.reload();
                    $('#modalTemporadas').modal('hide');
                    toastr['success']('¡Registro eliminado exitosamente!');
                }

            })
            .always(function() {
                $('#overlay').css('display','none');
            });
            
        });

        $('body').on('click', '#btnEditTemporada', function(event) {
            event.preventDefault();
            var region_id = $(this).data('region_id');
            var route = $(this).data('route');
            
            $.ajax({
                url: route,
                type: 'GET',
                dataType: 'JSON',
                beforeSend:function(){
                     $("#overlay").css("display", "block");
                },
                success:function(res){
                    if (res.success == true) {
                        $('#modalTemporadas').modal('hide');
                        $('#modalEditTemporada .modal-body').html(res.view);
                        $('#modalEditTemporada').modal('show');
                    }
                }
            })
            .fail(function() {
                toastr['error']('Ha ocurrido un error, inténtalo más tarde.');
            })
            .always(function() {
                 $("#overlay").css("display", "none");
            }); 
        });

        $(document).on('submit', '#formUpdateTemporada', function(event) {
            event.preventDefault();
            $.ajax({
                url: $(this).attr('action'),
                type: 'PUT',
                dataType: 'JSON',
                data: $(this).serialize(),
                beforeSend:function(){
                    $("#overlay").css("display", "block");
                },
                success:function(res){
                    if (res.success == true) {
                        toastr['success']('{{ __('messages.alerta.success') }}');
                        pintar_temporadas(res.temporada.regione_id)
                        $('#modalEditTemporada').modal('hide');
                    }else{
                        toastr['error']('{{ __('messages.alerta.error') }}');
                    }
                }
            })      
            .fail(function(jqXHR, textStatus, errorThrown) {
                toastr['error'](errorThrown);
                toastr['error'](jqXHR.responseJSON.message);
            })
            .always(function() {
                $("#overlay").css("display", "none");
            });
        });

        $(document).on('click', '.close', function(event) {
            event.preventDefault();
            $('#modalTemporadas').modal('show');
        });
    });

function pintar_temporadas(region_id) {
    $.ajax({
        url: baseadmin +'temporadas/'+ region_id,
        type: 'GET',
        dataType: 'JSON',
        success:function(res){             
            table_temporadas = $('#table_temporadas').dataTable({
                'responsive': true,
                'searching': false,
                "order": [[ 2, "DESC" ]],
                "aoColumns": [{
                    "mData": "5"
                },{
                    "mData": "0"
                }, {
                    "mData": "1"
                }, {
                    "mData": "2"
                }, {
                    "mData": "3"
                }],
                data: res.aaData,
                "bDestroy": true
            }).DataTable();
            $('#modalTemporadas').modal('show');
        }
    })
    .always(function() {
        console.log("complete");
    });
}
</script>
@endsection
