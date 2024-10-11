@extends('layouts.admin.app')
@section('content')
<style>
    #convenios_table_processing{
        color: red;
        font-size: 1.5em;
        align-items: center;
        align-content: center;
        left: 50%;
    }
    .alertify-notifier{
        color:white;
    }
</style>
<div class="row page-titles">
    <div class="col-md-5 col-8 align-self-center">
        <h3 class="text-themecolor">
            Convenio
        </h3>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('dashboard') }}">
                    Home
                </a>
            </li>
            <li class="breadcrumb-item active">
                Convenios
            </li>
        </ol>
    </div>
</div>
<div class="row">
    <div class="col-lg-12 col-md-12" data-title="¡Hola!" data-intro="Te dare un recorrido por los nuevos cambios realizados a esta vista! ✅">
        <div class="card">
            <div class="card-body">
                <div class="d-flex flex-wrap">
                    <div>
                        <h3 class="card-title">Convenios</h3> 
                    </div>
                    <div class="ml-auto">
                        <ul class="list-inline">
                            <li data-intro="Podras seleccionar filtrar los convenios, por usuario, todos o esclusivamente los registrados en tu usuario">
                                <input id="user_id" name="user_id" type="hidden" value="{{ Auth::id() }}"/>
                                <input id="role" name="role" type="hidden" value="{{ Auth::user()->role }}"/>
                                <select name="mostrar" id="mostrar" class="form-control select2" >
                                    <option value="todos" @if (Auth::user()->role != 'conveniant')
                                        selected 
                                    @endif>Todos</option>
                                    <option value="mios" @if (Auth::user()->role == 'conveniant')
                                        selected 
                                    @endif>Mios</option>
                                    @if (Auth::user()->role == 'admin' || Auth::user()->role == 'conveniant')
                                        @foreach ($conveniadores as $u)
                                            <option value="{{ $u->id }}">{{ $u->fullName }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </li>       
                            <li>
                                <button class="btn btn-sm btn-dark" id="btnReloadConvenios">
                                   <i class="fa fa-spin fa-refresh"></i>
                                </button> 
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="table-responsive">
                    <table aria-describedby="example2_info" class="table table-hover dataTable" id="convenios_table" role="grid" style="width:100%">
                        <thead>
                            <tr role="row">
                                <th>
                                    ID
                                </th>
                                <th data-intro="Se mostrara el estatus en el que se encuentra cada convenio">
                                    Estatus
                                </th>
                               {{--  <th>
                                    Llave
                                </th> --}}
                                <th data-intro="Empresa con convenio">
                                    Empresa
                                </th>
                                <th data-intro="Liga de la pagina de compra del convenio seleccionado">
                                    Liga
                                </th>
                                <th data-intro="Numero de contratos generados">
                                    # Contratos
                                </th>
                                <th data-intro="Usuario propietario del convenio">
                                    Conveniador
                                </th>
                                <th data-intro="Opciones (ver, editar, reasignar)">
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
                    Re asignar convenio
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
<script type="text/javascript">

    // introJs().setOption({
    //      "showProgress": true,
    // }).start();
    
    // introJs().setOption("dontShowAgain", false).start();
    $(document).ready(function() { 

        var convenios_table;
        pintar_convenios();

        $(document).on('change', '#mostrar', function(event) {
            event.preventDefault();
            pintar_convenios();
        });
        


        $(document).on('click', '#btnReloadConvenios', function(event) {
            event.preventDefault();
            pintar_convenios();
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

        $('body').on('click', '#estatusConvenio', function(event) {
            event.preventDefault();
            let mensaje = '';
            var estatus = $(this).data('estatus');
            var url = $(this).data('url');
            console.log(url);
            if (estatus == 1) {
                mensaje = '¿Desea deshabilitar el convenio seleccionado?';
            }else{
                mensaje = '¿Desea habilitar el convenio seleccionado?';
            }

            alertify.confirm('Confirmar', mensaje, 
                function(){
                    $.ajax({
                         url: url,
                         type: 'GET',
                         dataType: 'json',
                         beforeSend:function(){
                              $("#overlay").css("display", "block");
                         },
                         success:function(res){
                            if (res.success == true) {
                                $('#convenios_table').DataTable().ajax.reload();
                                toastr['success']('¡Registro exitoso!');
                            }else{
                                toastr['error']('¡Intentar mas tarde...!');
                            }
                         }
                     })
                     .always(function() {
                        $("#overlay").css("display", "none");
                     });
                      
                },function(){}
            );


            console.log(mensaje);
            // $.ajax({
            //     url: url,
            //     type: 'GET',
            //     dataType: 'JSON',
            //     beforeSend:function(){
            //         $("#overlay").css("display", "block");
            //     },
            //     success:function(res){
            //         $('#modalReasignar #modal-body').html(res.view);
            //         $('#modalReasignar').modal('show');
            //     }
            // })
            // .fail(function() {
            //     console.log("error");
            // })
            // .always(function() {
            //     $("#overlay").css("display", "none");
            // });
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
                success:function(res){
                    if (res.success == true) {
                        $('#modalReasignar').modal('hide');
                        $('#convenios_table').DataTable().ajax.reload();
                        toastr['success']('¡Convenio reasignado correctamente!');
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

    function pintar_convenios() {
        convenios_table = $('#convenios_table').DataTable({
            processing: true,
            serverSide: true,
            bDestroy: true,
            order: [0, 'desc'],
            bInfo: true,
            ajax: {
                url:  baseadmin + "convenios-listar",
                data: function (d) {
                    d.user_id = $('input[name=user_id]').val();
                    d.role = $('input[name=role]').val();
                    d.mostrar = $('select[name=mostrar]').val();
                }
            },
            columns: [
                {data: 'id', name: 'id'},
                {data: 'estatus', name: 'estatus'},
                // {data: 'llave', name: 'llave'},
                {data: 'empresa_nombre', name: 'empresa_nombre'},
                {data: 'liga', name: 'liga'},
                {data: 'contratos_vendidos', name: 'contratos_vendidos'},
                {data: 'conveniador', name: 'conveniador'},
    
                {data: 'actions', name: 'actions'},
            ],
        });
    }
</script>
@endsection
