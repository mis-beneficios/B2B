@extends('layouts.admin.app')
@section('content')
<div class="row page-titles">
    <div class="col-md-5 col-8 align-self-center">
        <h3 class="text-themecolor">
            {{ __('Administrativos') }}
        </h3>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('dashboard') }}">
                    Home
                </a>
            </li>
            <li class="breadcrumb-item active">
                Usuarios administrativos
            </li>
        </ol>
    </div>
</div>

<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="card">
            <div class="card-body">
                <div class="d-flex flex-wrap">
                    <div>
                        <h3 class="card-title">Usuarios administrativos</h3> 
                    </div>
                    <div class="ml-auto">
                        <ul class="list-inline">
                            <li>
                                <select name="mostrar" id="mostrar" class="form-control">
                                    <option value="todos">Selecciona un rol</option>
                                    <option value="admin">Administrador</option>
                                    <option value="recepcionist">Recepcionista</option>
                                    <option value="supervisor">Supervisor de ventas</option>
                                    <option value="sales">Ejecutivo de ventas</option>
                                    <option value="collector">Cobranza</option>
                                    <option value="reserver">Reservaciones</option>
                                    <option value="conveniant">Convenios</option>
                                    <option value="quality">Calidad</option>
                                    <option value="control">Control</option>
                                </select>
                            </li>
                            <li>
                                <select name="equipo" id="equipo" class="form-control">
                                    <option value="todos">Selecciona un equipo</option>
                                    @foreach ($sales_group as $sg)
                                        <option value="{{$sg->id}}">{{$sg->title}}</option>
                                    @endforeach
                                </select>
                            </li>         
                            <li>
                                <button class="btn btn-sm btn-dark" id="btnReloadAdmin">
                                   <i class="fa fa-spin fa-refresh"></i>
                                </button> 
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover dataTable" id="table_usuarios" role="grid" style="width:100%">
                        <thead>
                            <tr role="row">
                                <th>
                                    #
                                </th>
                                <th class="col-3">
                                    Nombre
                                </th>
                                <th class="col-3">
                                    Correo Electrónico
                                </th>
                                <th class="col-2">
                                    Equipo
                                </th>
                                <th>
                                    Role
                                </th>
                                <th>
                                    Estatus
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
        var tabla;

        mostrar_admins();

        $(document).on('change', '#mostrar', function(event) {
            event.preventDefault();
            mostrar_admins();
        });
        
        $(document).on('change', '#equipo', function(event) {
            event.preventDefault();
            mostrar_admins();
        });


        $(document).on('click', '#btnReloadAdmin', function(event) {
            event.preventDefault();
            mostrar_admins();
        });

        




        $('body').on('click', '#activo', function(event) {
            event.preventDefault();
            var estatus = $(this).data('activo');
            var user_id = $(this).data('user_id');
            var url = $(this).data('url');

            $.ajax({
                url: url,
                type: 'PUT',
                dataType: 'json',
                data: {estatus: estatus},
                beforeSend:function(){
                    $("#overlay").css("display", "block");
                },
                success:function(res){
                    if (res.success==true) {
                        // tabla.ajax.reload();
                        mostrar_admins();
                        toastr["success"]("¡Registro exitoso!");
                    }else{
                        toastr["error"]("¡Intentar mas tarde!");
                    }
                }
            })
            .always(function() {
                $("#overlay").css("display", "none");
            });
            
        });
    });

    function mostrar_admins() {
        $('#table_usuarios').DataTable({
            processing: true,
            serverSide: true,
            bDestroy: true,
            order: [0, 'desc'],
            bInfo: true,
            ajax: {
                url:  baseadmin + "listar-administrativos",
                data: function (d) {
                    d.mostrar = $('select[name=mostrar]').val();
                    d.equipo = $('select[name=equipo]').val();
                },
                error: function(e) {
                    toastr['error'](e.responseText);
                }
            },
            columns: [
                {data: 'id', name: 'id'},
                {data: 'nombre', name: 'nombre'},
                {data: 'username', name: 'username'},
                {data: 'equipo', name: 'equipo'},
                {data: 'role', name: 'role'},
                {data: 'activo', name: 'activo'},
                {data: 'created', name: 'activo'},
    
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
