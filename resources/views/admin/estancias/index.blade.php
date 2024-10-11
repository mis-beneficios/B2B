@extends('layouts.admin.app')
@section('content')
<div class="row page-titles">
    <div class="col-md-5 col-8 align-self-center">
        <h3 class="text-themecolor">
            Estancias
        </h3>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('dashboard') }}">
                    Inicio
                </a>
            </li>
            <li class="breadcrumb-item active">
                Listar estancias
            </li>
        </ol>
    </div>
</div>
<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="card">
            <div class="card-header">
                <div class="card-actions">                    
                    <a class="btn btn-info btn-xs text-white"  href="{{ route('estancias.create') }}">
                        <span>
                            <i class="fas fa-plus">
                            </i>
                            {{ __('Agregar estancia') }}
                        </span>
                    </a>
                </div>
                <h4 class="card-title m-b-0">
                    {{ __('Estancias') }}
                </h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover dataTable" id="table_estancias" role="grid" style="width:100%">
                        <thead>
                            <tr role="row">
                                <th aria-controls="" aria-label="" aria-sort="ascending" class="sorting_asc" colspan="1" rowspan="1" tabindex="0">
                                    #
                                </th>
                                <th>
                                    Nombre
                                </th>
                                <th>
                                    Precio
                                </th>
                                <th>
                                    Estatus
                                </th>
                                <th>
                                    Caducidad
                                </th>
                                <th>
                                    Cuotas
                                </th>
                                <th>
                                    Noches
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

        var tabla = $('#table_estancias').DataTable({
            processing: true,
            serverSide: true,
            bDestroy: true,
            order: [0, 'desc'],
            // bInfo: false,
            ajax: "{{ route('estancias.listar') }}",
            columns: [
                {data: 'id', name: 'id'},
                {data: 'title', name: 'title'},
                {data: 'precio', name: 'precio'},
                {data: 'estatus', name: 'estatus'},
                {data: 'caducidad', name: 'caducidad'},
                {data: 'cuotas', name: 'cuotas'},
                {data: 'noches', name: 'noches'},
                {data: 'actions', name: 'actions'},
            ],
            "drawCallback": function() {
                if (this.fnSettings().fnRecordsTotal() < 11) {
                    $('.dataTables_paginate').hide();
                }
            },
        });

        $('body').on('click', '.btnHabilitada', function(event) {
            event.preventDefault();
            var estatus = $(this).data('estatus');
            $.ajax({
                url: $(this).data('url'),
                type: 'PUT',
                dataType: 'json',
                data: {estatus: estatus },
                beforeSend:function(){
                      $("#overlay").css("display", "block");
                },
                success:function(res){
                    if (res.success==true) {
                        tabla.ajax.reload();
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
</script>
@endsection
