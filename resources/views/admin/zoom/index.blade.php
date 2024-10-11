@extends('layouts.admin.app')
@section('content')
<div class="row page-titles">
    <div class="col-md-5 col-8 align-self-center">
        <h3 class="text-themecolor">
            <a href="{{ route('dashboard') }}">
                Zoom
            </a>
        </h3>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('dashboard') }}">
                    Inicio
                </a>
            </li>
            <li class="breadcrumb-item active">
                Reuniones
            </li>
        </ol>
    </div>
</div>
<div class="card">
    <div class="card-header">
        <div class="card-actions">
            <div class="pull-right">
                <button class="btn btn-sm btn-primary" data-target="#meeting" data-toggle="modal">
                    <i class="fa fa-plus">
                    </i>
                    Nuevo
                </button>
            </div>
        </div>
        <h4 class="card-title m-b-0">
            Reuniones
        </h4>
    </div>
    <div class="table-responsive">
        <div class="card-body collapse show">
            <div class="table-responsive">
                <table class="table table-hover" id="table-meetings" style="width: 100%;">
                    <thead class="">
                        <tr>
                            <th>
                                #
                            </th>
                            <th>
                                Anfitrión
                            </th>
                            <th>
                                ID de reunion
                            </th>
                            <th>
                                Meeting
                            </th>
                            <th>
                                Estatus
                            </th>
                            <th>
                                Fecha
                            </th>
                            <th>
                                Tema
                            </th>
                            <th>
                                Creado
                            </th>
                            <th width="150">
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



<!-- Modal create meeting -->
<div class="modal fade" id="meeting" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Nueva Reunión</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
            <form action="{{ route('zoom.store') }}" class="form-horizontal" id="formMeeting" method="post">
                {{ csrf_field() }}
                <div class="modal-body">
                    @include('admin.zoom.form')
                </div>
            </form>
      </div>
    </div>
  </div>
</div>


<!-- Modal show info -->
<div class="modal fade" id="show_info" tabindex="-1" role="dialog" aria-labelledby="show_infoTitle" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Información de la reunión</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
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
    $(document).ready(function () {
        $user_id = '{{Auth::user()->id}}';
        $profile_id = '{{ Auth::user()->profile_id }}'
        
        meeting_list();

        $('#start_time').timepicker({
            timeFormat: 'h:mm',
            use24hours: true,
            maxHours: '24',
        });

   
        $(document).on('click', '#btnInfoMeeting', function(event) {
            event.preventDefault();
            var meeting_id = $(this).data('meeting_id');
            $.ajax({
                url: $(this).data('url'),
                type: 'GET',
                dataType: 'JSON',
                beforeSend:function(){
                     $("#overlay").css("display", "block");
                },
                success:function(res){
                    console.log(res);
                    $("#overlay").css("display", "none");
                    if (res.success == true) {
                        $('#show_info #modal-body').html(res.view);
                        $('#show_info').modal('show');
                    }

                    if (res.success == false){
                        toastr['error'](res.data['message']);
                    }
                }
            })
            .fail(function(jqXHR, textStatus, errorThrown) {
                console.log('entra aqui');
                console.log(jqXHR, textStatus, errorThrown);
                $("#overlay").css("display", "none");
                toastr['error'](errorThrown);
                toastr['error'](jqXHR.responseJSON);
            })
            .always(function() {
                $("#overlay").css("display", "none");
            });
            
        });

        $(document).on('submit', '#formMeeting', function(event) {
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
                    $("#overlay").css("display", "none");
                    if (res.success == true) {
                        $('#table-meetings').DataTable().ajax.reload();
                        toastr['success']('¡Reunión creada exitosamente!');
                        $('#meeting').modal('hide');
                        $('#formMeeting').trigger("reset");
                    }else{
                        if (res.errors) {
                            toastr['error']('Revisa los campos ingresados o faltantes...')
                            pintar_errores(res.errors);
                        }else{
                            toastr['error'](res.message);
                        }
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


        $(document).on('click', '#copyZoom', function(event) {
            event.preventDefault();
            var divContent = $("#text_info_meeting").text();

            $('#text_info_meeting').append('<textarea class="form-control" id="txtCopy"></textarea>').css({
                    'background-color': '#f0f0f0',
                    'color': '#333',
                    'padding': '2px',
                    'border': 'none',
                    'font-family': 'inherit',
                    'font-size': 'inherit',
                    'resize': 'none'
                });

            $('#txtCopy').val(divContent).select();

            // Establecer el valor del input con el contenido del div

            // Copiar el contenido al portapapeles
            document.execCommand("copy");
             $('#txtCopy').remove();
            // 
            toastr['info']('La invitación se ha copiado al portapapeles')
        });


        // $('#btnEliminarMeeting').on('click', function (event) {
        //     event.preventDefault();
        //     $id = $(this).data('id');
        //     alertify.confirm('Eliminar Meeting', '¿Seguro que desea eliminar el Meeting seleccionado?',
        //         function () {
        //             $.ajax({
        //                 type: "GET",
        //                 url: baseuri + "delete-meeting/" + $id,
        //                 dataType: "json",
        //                 beforeSend: function () {
        //                     $("#loading").css('display', 'flex');
        //                 },
        //                 success: function (response) {
        //                     console.log(response);
        //                     $("#loading").css('display', 'none');
        //                     if (response.estatus == true) {
        //                         alertify.set('notifier', 'position', 'top-right');
        //                         alertify.success('El Meeting se elimino correctamente.');
        //                         window.location.href = "{{ route('zoom.index') }}";
        //                     } else {
        //                         alertify.set('notifier', 'position', 'top-right');
        //                         alertify.error('No se pudo eliminar el Meeting seleccionado');
        //                     }
        //                 }
        //             });
        //         },
        //         function () {
        //         })
        // })
    });
    function meeting_list() {
        $('#table-meetings').DataTable({
            processing: true,
            serverSide: true,
            bDestroy: true,
            order: [0, 'desc'],
            bInfo: true,
            ajax: {
                url:  "{{ route('zoom.get_meetings') }}",
                // data: function (d) {
                //     d.mostrar = $('select[name=mostrar]').val();
                //     d.equipo = $('select[name=equipo]').val();
                // }
            },
            columns: [
                {data: 'id', name: 'id'},
                {data: 'user_id', name: 'user_id'},
                {data: 'meeting_id', name: 'meeting_id'},
                {data: 'url', name: 'url'},
                {data: 'estatus', name: 'estatus'},
                {data: 'fecha', name: 'fecha'},
                {data: 'topic', name: 'topic'},
                {data: 'created_at', name: 'created_at'},
                {data: 'actions', name: 'actions'},
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