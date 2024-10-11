@extends('layouts.admin.app')
@section('content')
<div class="row page-titles">
    <div class="col-md-5 col-8 align-self-center">
        <h3 class="text-themecolor">
            <a href="{{ route('dashboard') }}">
                Tarjetas
            </a>
        </h3>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('dashboard') }}">
                    Home
                </a>
            </li>
            <li class="breadcrumb-item active">
                Tarjetas
            </li>
        </ol>
    </div>
</div>
<div class="row">
    <div class="col-md">
        <div class="card">
            <div class="card-body">
                <form action="" id="formFiltrado" method="get">
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label for="">
                                Banco
                            </label>
                            <select class="form-control custom-select select2 m-b-10 select2-multiple select2-hidden-accessible" id="banco_id" multiple="" name="banco_id[]" style="width: 100%;">
                                @foreach ($bancos_mx as $banco)
                                <option value="{{ $banco->id }}">
                                    {{ $banco->title }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label for="inputState">
                                Estatus
                            </label>
                            <select class="form-control custom-select select2 m-b-10 select2-multiple select2-hidden-accessible" id="estatus" multiple="" name="estatus[]" style="width:100%">
                                <option value="">
                                    Seleccione una opción
                                </option>
                                <option value="">
                                    Sin verificar
                                </option>
                                <option value="Comprado">
                                    Sin banca
                                </option>
                                <option value="suspendido">
                                    Vigentes
                                </option>
                                <option value="viajado">
                                    Canceladas
                                </option>
                                <option value="nuevo">
                                    No aprobadas
                                </option>
                            </select>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="inputState">
                                Tipo
                            </label>
                            <select class="form-control custom-select select2 m-b-10 select2-multiple select2-hidden-accessible" id="tipo" multiple="" name="tipo[]" style="width:100%">
                                <option value="">
                                    Seleccione una opción
                                </option>
                                <option value="Credito">
                                    Crédito
                                </option>
                                <option value="Debito">
                                    Débito
                                </option>
                            </select>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="inputState">
                                Banca
                            </label>
                            <select class="form-control custom-select select2 m-b-10 select2-multiple select2-hidden-accessible" id="banca" multiple="" name="banca[]" style="width:100%">
                                <option value="">
                                    Seleccione una opción
                                </option>
                                <option value="Credito">
                                    Master Card
                                </option>
                                <option value="Debito">
                                    Visa
                                </option>
                            </select>
                        </div>
                    </div>
                    <button class="btn btn-primary btn-sm" type="submit">
                        Filtrar
                    </button>
                </form>
            </div>
        </div>
    </div>
    <div class="col-lg-12 col-md-12">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover dataTable" id="table_tarjetas" role="grid" style="width:100%">
                        <thead>
                            <tr role="row">
                                <th {{-- aria-controls="" aria-label="" aria-sort="ascending" class="sorting_asc" colspan="1" rowspan="1" tabindex="0" --}}>
                                    Usuario
                                </th>
                                <th {{-- aria-controls="" aria-label="" class="sorting" colspan="1" rowspan="1" tabindex="0" --}}>
                                    Titular de la tarjeta
                                </th>
                                <th {{-- aria-controls="" aria-label="" class="sorting" colspan="1" rowspan="1" tabindex="0" --}}>
                                    Banca
                                </th>
                                <th {{-- aria-controls="" aria-label="" class="sorting" colspan="1" rowspan="1" tabindex="0" --}}>
                                    Entidad Bancaria
                                </th>
                                <th {{-- aria-controls="" aria-label="" class="sorting" colspan="1" rowspan="1" tabindex="0" --}}>
                                    Estatus
                                </th>
                                <th {{-- aria-controls="" aria-label="" class="sorting" colspan="1" rowspan="1" tabindex="0" --}}>
                                    Tipo
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
@endsection


@section('script')
<script>
    $(document).ready(function() {
        var tabla;
        tarjetasData();
        $(document).on('click', '#formFiltrado', function(event) {
            event.preventDefault();
            tarjetasData();
        });

        function tarjetasData(){
            $('#table_tarjetas').DataTable({
                processing: true,
                serverSide: true,
                bDestroy: true,
                // order: [0, 'desc'],
                bInfo: true,
                ajax: {
                    url: baseadmin + "get-tarjetas",
                    data: function (d) {
                        d.banco_id = $('#country_id').val();
                        d.estatus = $('#estatus').val();
                        d.tipo = $('#tipo').val();
                        d.banca = $('#banca').val();
                    },
                    error: function (xhr, error, code) {
                        console.log(xhr, error, code);
                            // toastr['error'](xhr, code);
                      toastr['error'](code);
                      toastr['error'](xhr.responseJSON.message);
                      // tabla.ajax.reload();
                    }
                },
                columns: [
                    {data: 'user', name: 'user'},
                    {data: 'titular', name: 'titular'},
                    {data: 'banca', name: 'banca'},
                    {data: 'entidad', name: 'entidad'},
                    {data: 'estatus', name: 'estatus'},
                    // {data: 'activo', name: 'activo'},
                    {data: 'tipo', name: 'tipo'},
        
                    {data: 'actions', name: 'actions'},
                ],
                "drawCallback": function() {
                    if (this.fnSettings().fnRecordsTotal() < 11) {
                        $('.dataTables_paginate').hide();
                    }
                },
               
            });
        }
       
    });

</script>
@endsection
