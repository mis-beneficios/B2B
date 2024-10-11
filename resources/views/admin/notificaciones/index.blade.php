@extends('layouts.admin.app')
@section('content')
<div class="row page-titles">
    <div class="col-md-5 col-8 align-self-center">
        <h3 class="text-themecolor">
            Notificaciones de sistema
        </h3>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('dashboard') }}">
                    Inicio
                </a>
            </li>
            <li class="breadcrumb-item active">
                Listado
            </li>
        </ol>
    </div>
</div>
<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="card">
            <div class="card-header">
                <div class="card-actions">
                    {{-- @if (Auth::user()->can('create', App\Contrato::class)) --}}
                 {{--    <button class="btn btn-info btn-xs"  data-toggle="modal" data-target="#modalNotificacion" id="btnAddContrato">
                        <span>
                            <i class="fas fa-plus">
                            </i>
                            {{ __('Nueva notificación') }}
                        </span>
                    </button> --}}
                    <a href="{{ route('notificaciones.create') }}" class="btn btn-info btn-sm text-white" >
                        <i class="fas fa-plus"></i>
                        {{ __('Nueva notificación') }}  
                    </a>
                </div>
                <h4 class="card-title m-b-0">
                    {{ __('Notificaciones') }}
                </h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover dataTable" id="table_notificaciones" role="grid" style="width:100%">
                        <thead>
                            <tr role="row">
                                <th aria-sort="ascending" class="sorting_asc">
                                    #
                                </th>
                                <th >
                                    Nombre
                                </th>
                                <th {{-- aria-controls="" aria-label="" class="sorting" colspan="1" rowspan="1" tabindex="0" --}}>
                                    Estatus
                                </th>
                                <th >
                                    Activo hasta
                                </th>
                                <th >
                                    Mostrar a
                                </th>
                                <th >
                                    Key cache
                                </th>
                                <th >
                                    Creado por
                                </th>
                                <th aria-controls="" aria-label="" class="sorting" colspan="1" rowspan="1" tabindex="0" width="150">
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
<div class="modal fade" id="modalNotificacion" tabindex="-1" role="dialog" aria-labelledby="modalNotificacion" aria-hidden="true">
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalNotificacion">
            Agregar nueva notificación
        </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      {{-- @include('admin.notificaciones.edit') --}}
      {{-- <form action="{{ route('notificaciones.store') }}" method="post" id="formNotificacion">
        @csrf
          <div class="modal-body">
            @include('admin.notificaciones.elementos.form')
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Cerrar</button>
            <button type="submit" class="btn btn-primary btn-sm">Guardar</button>
          </div>
      </form> --}}
    </div>
  </div>
</div>


<!-- Modal -->
<div class="modal fade" id="modalVerNotificacion" tabindex="-1" role="dialog" aria-labelledby="modalVerNotificacion" aria-hidden="true">
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="modalVerNotificacionTitle">
                Notificación
            </h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
        </div>
        <div class="modal-footer" id="footer">
            <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Cerrar</button>
            {{-- <button type="submit" class="btn btn-primary btn-sm">Guardar</button> --}}
        </div>
    </div>
  </div>
</div>
@endsection


@section('script')
<script>
    $(document).ready(function() {

// btnVerNotificacion
// btnEditarNotificacion
// btnEliminarNotificacion


        var tabla = $('#table_notificaciones').DataTable({
            'responsive': true,
            'searching': true,
            'lengthMenu': [[10, 50, -1], [10, 50, "Todo"]],
            'pageLength': 10,
            "aoColumns": [{
                "mData": "0"
                },/* {
                "mData": "1"
                },*/{
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
                "mData": "8"
                }
            ],
            "ajax": {
                url: "{{ route('notificaciones.get_notificaciones') }}",
                type: "get",
                dataType: "json",
                error: function(e) {
                  console.log(e.responseText);
                }
            },
        });


        $('#formNotificacion').submit(function(event) {
            event.preventDefault();
            $.ajax({
                url: $(this).attr('action'),
                type: $(this).attr('method'),
                dataType: 'JSON',
                data: $(this).serialize(),
                beforeSend:function(){
                    $('#overlay').css('display', 'block');
                }, 
                success:function(res){
                    $("#overlay").css("display", "none");
                    if (res.success==true) {
                        toastr['success']('¡Registro exitoso!');
                        tabla.ajax.reload();
                        $(this).trigger('reset');
                        $('#modalNotificacion').modal('hide');
                    }else{
                        toastr['error']('¡Intentar mas tarde!')
                    }
                }
            })
            .fail(function(jqXHR, textStatus, errorThrown) {
                $("#overlay").css("display", "none");
                toastr['error'](errorThrown);
            })
            .always(function() {
                $('#overlay').css('display', 'none');
            });  
        });


        $(document).on('click', '#btnVerNotificacion', function(event) {
            event.preventDefault();
            $.ajax({
                url: $(this).attr('href'),
                type: 'GET',
                dataType: 'JSON',
                beforeSend:function(){
                    $('#overlay').css('display', 'block');
                },
                success:function(res){
                    if (res.success == true) {
                        $('#modalVerNotificacion .modal-body').html(res.cuerpo);
                        $('#modalVerNotificacion').modal('show');
                    }   
                }
            })
            .fail(function(jqXHR, textStatus, errorThrown) {
                $("#overlay").css("display", "none");
                toastr['error'](errorThrown);
            })
            .always(function() {
                $('#overlay').css('display', 'none');
            });
            
        });


        $(document).on('click', '#btnEditarNotificacion', function(event) {
            event.preventDefault();
            $.ajax({
                url: $(this).attr('href'),
                type: 'GET',
                dataType: 'JSON',
                beforeSend:function(){
                    $('#overlay').css('display', 'block');
                },
                success:function(res){
                    if (res.success == true) {
                        $('#modalVerNotificacion #footer').remove();
                        $('#modalVerNotificacion .modal-body').html(res.view);
                        $('#modalVerNotificacion').modal('show');
                    }   
                }
            })
            .fail(function(jqXHR, textStatus, errorThrown) {
                $("#overlay").css("display", "none");
                toastr['error'](errorThrown);
            })
            .always(function() {
                $('#overlay').css('display', 'none');
            });
            
        });
    });
</script>
@endsection
