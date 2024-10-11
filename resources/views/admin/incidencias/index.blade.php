@extends('layouts.admin.app')
@section('content')
<div class="row page-titles">
    <div class="col-md-5 col-8 align-self-center">
        <h3 class="text-themecolor">
            Inicidencias
        </h3>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('dashboard') }}">
                    Home
                </a>
            </li>
            <li class="breadcrumb-item active">
                Inicios de sesión
            </li>
        </ol>
    </div>
</div>
<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="card">
            <div class="card-body">
                <div class="from-group row">
                    <div class="col-md-3">
                        <input class="form-control datepicker" type="text" id="daterange" name="daterange" value="{{ date('Y-m-d') }}">
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover dataTable" id="table_incidencias" role="grid" style="width:100%">
                        <thead>
                            <tr>
                                <th>
                                    #
                                </th>
                                <th class="col-md-2">
                                    Caso
                                </th>
                                <th class="col-md-7">
                                    Descripcion
                                </th>
                                <th class="col-md-1">
                                    Creado
                                </th>
                                <th class="col-md-2">
                                    Usuario
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

        $('.datepicker').bootstrapMaterialDatePicker({
            weekStart: 0,
            time: false,
            lang: 'es',
        });
        var tabla;

        pintar_incidencias($('#daterange').val());

        $('#daterange').on('change', function(event) {
            event.preventDefault();
            pintar_incidencias($(this).val());
        });

    });

    function pintar_incidencias(fecha) {
        $('#table_incidencias').DataTable({
            processing: true,
            serverSide: true,
            bDestroy: true,
            order: [0, 'desc'],
            bInfo: true,
            ajax: baseadmin + "listar-incidencias/" + fecha,
            columns: [
                {data: 'id', name: 'id'},
                {data: 'caso', name: 'caso'},
                {data: 'descripcion', name: 'descripcion'},
                {data: 'created', name: 'created'},
                {data: 'user_id', name: 'user_id'},
            ],
            search: {
                "regex": true
            },
            "drawCallback": function() {
                if (this.fnSettings().fnRecordsTotal() < 11) {
                    $('.dataTables_paginate').hide();
                }
            },
           
        });
    }
</script>
@endsection
