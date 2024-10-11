@extends('layouts.admin.app')
@section('content')
<div class="row page-titles">
    <div class="col-md-5 col-8 align-self-center">
        <h3 class="text-themecolor">
            {{ __('Clientes') }}
        </h3>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('dashboard') }}">
                    Home
                </a>
            </li>
            <li class="breadcrumb-item active">
                Clientes
            </li>
        </ol>
    </div>
</div>
<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover dataTable" id="table_usuarios" role="grid" style="width:100%">
                        <thead>
                            <tr role="row">
                                <th>
                                    #
                                </th>
                                <th>
                                    Nombre
                                </th>
                                <th>
                                    Correo Electrónico
                                </th>
                                <th>
                                    Vendedor
                                </th>
                                <th>
                                    Contratos
                                </th>
                                <th>
                                    Registrado
                                </th>
                                <th>
                                    Opciones
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            {{--     @foreach ($users as $user)
                            <tr>
                                <td>
                                    {{$user->id}}
                                </td>
                                <td>
                                </td>
                                <td>
                                </td>
                                <td>
                                </td>
                                <td>
                                </td>
                                <td>
                                </td>
                            </tr>
                            @endforeach --}}
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
         var tabla = $('#table_usuarios').DataTable({
            processing: true,
            serverSide: true,
            bDestroy: true,
            order: [0, 'desc'],
            bInfo: true,
            ajax: baseadmin + "listar-clientes",
            columns: [
                {data: 'id', name: 'id'},
                {data: 'nombre', name: 'nombre'},
                {data: 'username', name: 'username'},
                {data: 'padre_id', name: 'padre_id'},
                {data: 'contratos', name: 'contratos'},
                // {data: 'activo', name: 'activo'},
                {data: 'created', name: 'created'},
    
                {data: 'actions', name: 'actions'},
            ],
            "drawCallback": function() {
                if (this.fnSettings().fnRecordsTotal() < 11) {
                    $('.dataTables_paginate').hide();
                }
            },
           
        });


        ///////////////////////
        // ELiminar users // //
        ///////////////////////
        $(document).on('click', '#btnEliminar', function(event) {
            event.preventDefault();
            var url = $(this).data('url');

            alertify.confirm('Confirmar', '¿Desea eliminar el usuario? <br> No podrá revertir esta acción, se eliminara todo lo relacionado a este usuario, ¿Esta seguro?.',
                function(){
                    $.ajax({
                        url: $(this).data('url'),
                        type: 'DELETE',
                        dataType: 'json',
                        beforeSend:function(){
                             $("#overlay").css("display", "block");
                        },
                        success:function(res){
                            if (res.success == true) {
                                toastr['success'](res.message);
                                tabla.ajax.reload();
                            }else{
                                toastr['error'](res.message);
                            }
                        }
                    })
                    .fail(function() {
                        console.log("error");
                    })
                    .always(function() {
                        $("#overlay").css("display", "none");
                    });

                }
                ,
                function(){

                }
            );
        });

    });
</script>
@endsection
