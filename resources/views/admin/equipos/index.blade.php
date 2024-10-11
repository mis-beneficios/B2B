@extends('layouts.admin.app')
@section('content')
<div class="row page-titles">
    <div class="col-md-5 col-8 align-self-center">
        <h3 class="text-themecolor">
            Equipos
        </h3>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('dashboard') }}">
                    Inicio
                </a>
            </li>
            <li class="breadcrumb-item active">
                Equipos de ventas
            </li>
        </ol>
    </div>
</div>



<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="card">
            <div class="card-header">
                <div class="card-actions">
                    <button class="btn btn-info btn-xs" id="btnAddEquipo" data-toggle="modal" data-target="#exampleModalLong">
                        <span>
                            <i class="fas fa-plus">
                            </i>
                            Nuevo equipo
                        </span>
                    </button>
                    <button class="btn btn-dark btn-sm"  id="btnReloadEquipos">
                        <i class="fa fa-spin fa-refresh">
                        </i>
                    </button>
                </div>
                <h4 class="card-title m-b-0">
                    Equipos de ventas
                </h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover dataTable" id="table_usuarios" role="grid" style="width:100%">
                        <thead>
                            <tr role="row">
                                <th >
                                    #
                                </th>
                                <th >
                                    Titulo
                                </th>
                                <th >
                                    Tarifa ventas
                                </th>
                                <th >
                                    Tarifa supervisor
                                </th>
                                <th >
                                    Personal
                                </th>
                                <th class="col-1">
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
<div aria-hidden="true" aria-labelledby="modalEjecutivos" class="modal fade" data-backdrop="static" id="modalEjecutivos" tabindex="-1">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalEjecutivosLabel">
                    Listado de ejecutivos
                </h5>
                <button aria-label="Close" class="close" data-dismiss="modal" type="button">
                    <span aria-hidden="true">
                        ×
                    </span>
                </button>
            </div>
            <div id="modal-body">
            </div>
        </div>
    </div>
</div>


<!-- Modal -->
<div class="modal fade" id="exampleModalLong" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Agregar / Editar equipo</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
        <form id="formEquipo">
            <div class="modal-body">
                <div class="form-row">
                    <div class="form-group col-md-12">
                      <label for="nombre">Nombre</label>
                      <input type="text" class="form-control" required id="nombre" name="title" placeholder="Nombre del equipo">
                    </div>
                    <div class="form-group col-md-12">
                      <label for="supervisor">Comision supervisor</label>
                      <input type="text" class="form-control" id="supervisor" value="15.00">
                    </div>
                    <div class="form-group col-md-12">
                        <label for="ejecutivo">Ejecutivo</label>
                        <input type="text" class="form-control" id="ejecutivo" name="ejecutivo" value="100.00">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-dark btn-sm" data-dismiss="modal">Cerrar</button>
                <button type="submit" class="btn btn-primary btn-sm">Guardar</button>
            </div>
        </form>
    </div>
  </div>
</div>
<!-- Modal -->
<div class="modal fade" id="modalAsociarEjecutivos" tabindex="-1" role="dialog" aria-labelledby="modalAsociarEjecutivosTitle" aria-hidden="true">
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="modalAsociarEjecutivosTitle">Asociar ejecutivos</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div id="body">
            
        </div>
    </div>
  </div>
</div>

{{-- <livewire:equipos.index> --}}
@endsection


@section('script')
<script>
    $(document).ready(function() {
        // $('#ejecutivo').select2();

        var tabla = $('#table_usuarios').DataTable({
            'responsive': true,
            'searching': true,
            'lengthMenu': [[10, 50, -1], [10, 50, "Todo"]],
            'pageLength': 10,
            "aoColumns": [{
                "mData": "0"
                }, {
                "mData": "1"
                },{
                "mData": "2"
                },{
                "mData": "3"
                },{
                "mData": "5"
                },{
                "mData": "4"
                },
            ],
            "ajax": {
                url: "{{ route('groups.listar') }}",
                type: "get",
                dataType: "json",
                error: function(e) {
                  // console.log(e.responseText);
                  toastr['error'](e.responseText);

                }
            },
        });

        $('#btnReloadEquipos').on('click', function(event) {
            event.preventDefault();
            toastr['info']('Recargando equipos...');
            tabla.ajax.reload();
        });

        $(document).on('click', '#btnUsersGrupo', function(event) {
            event.preventDefault();
            var grupo_id = $(this).data('grupo_id');
            $.ajax({
                url: baseadmin + 'listar-usuarios-grupo/' + grupo_id,
                type: 'GET',
                dataType: 'JSON',
                beforeSend:function(){
                    $("#overlay").css("display", "block");
                },
                success:function(res){

                    $('#modalEjecutivos #modal-body').html(res.view);
                    $('#modalEjecutivos').modal('show');
                    $('#tableEjecutivos').DataTable();
                }
            })
            .always(function() {
                $("#overlay").css("display", "none");
            });
        });


        $(document).on('click', '#btnEditarGrupo', function(event) {
            event.preventDefault();
            var id = $(this).attr('value');
            console.log(id);
        });

        $('#formEquipo').on('submit', function(event) {
            event.preventDefault();
            
        });

        $(document).on('click', '#btnAsociar', function(event) {
            event.preventDefault();
            var id = $(this).attr('value');
            $.ajax({
                url: baseadmin + 'asociar-ejecutivos/' + id,
                type: 'GET',
                dataType: 'JSON',
                beforeSend:function(){
                    $("#overlay").css("display", "block");
                },
                success:function(res){
                    $('#modalAsociarEjecutivos #body').html(res.view);
                    $('#modalAsociarEjecutivos').modal('show');
                }
            })
            .always(function() {
                $("#overlay").css("display", "none");
            });
        });
        7
        $(document).on('submit', '#formEquipo', function(event) {
            event.preventDefault();

            $.ajax({
                url: "{{ route('equipos.vincular_ejecutivos') }}",
                type: 'POST',
                dataType: 'JSON',
                data: $(this).serialize(),
                beforeSend:function(){
                    $("#overlay").css("display", "block");
                },
                success:function(res){
                    if (res.success==true) {
                        Toast.fire({
                            icon:'success',
                            title:' Se han vinculado '+ res.cont + ' usuarios.'
                        });
                        tabla.ajax.reload();
                        $('#modalAsociarEjecutivos').modal('hide');
                    }else{
                        Toast.fire({
                            icon:'error',
                            title:'No se pudieron vincular los usuarios seleccionados.'
                        });
                    }
                }
            })
            .always(function() {
                $("#overlay").css("display", "none");
            }); 
        });


        $(document).on('click', '.desvincularEjecutivo', function(event) {
            event.preventDefault();
            var url = $(this).data('url');

            Swal.fire({
              title: 'Desvincular',
              text: "¿Desea desvincular el ejecutivo seleccionado del equipo al que pertenece?",
              icon: 'question',
              showCancelButton: true,
              confirmButtonColor: '#3085d6',
              cancelButtonColor: '#d33',
              confirmButtonText: 'Desvincular',
              cancelmButtonText: 'Cancelar '
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                    url: url,
                    type: 'GET',
                    dataType: 'json',
                    beforeSend:function(){
                        $("#overlay").css("display", "block");
                    },
                    success:function(res){
                        
                        if (res.success == true) {
                            Toast.fire({
                                icon:'success',
                                title:' Se han desvinculado el usuarios correctamente.'
                            });
                            $('#modalEjecutivos').modal('hide');
                            tabla.ajax.reload();
                        }else{
                            Toast.fire({
                                icon:'error',
                                title:'No se pudo desvincular el usuario seleccionado.'
                            });
                        }
                    }
                })
                .always(function() {
                    $("#overlay").css("display", "none");
                });
              }
            })
           
            
        });

    });
</script>
@endsection
