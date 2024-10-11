@extends('layouts.admin.app')
@section('content')
<div class="row page-titles">
    <div class="col-md-5 col-8 align-self-center">
        <h3 class="text-themecolor">
            Bienvenid@ {{ Auth::user()->fullName }}
        </h3>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="javascript:void(0)">
                    Home
                </a>
            </li>
            <li class="breadcrumb-item active">
                Dashboard
            </li>
        </ol>
    </div>
</div>
<div class="row">
    <div class="col-lg">
        <div class="card">
            <div class="card-body">
                <a href="{{ route('concals.index') }}">
                    <div class="d-flex flex-row">
                        <div class="round round-lg align-self-center round-success">
                            <i class="fas fa-check">
                            </i>
                        </div>
                        <div class="m-l-10 align-self-center">
                            <h3 class="m-b-0 font-lgiht">
                                {{ $panel['seguimientos'] }}
                            </h3>
                            <h5 class="text-muted m-b-0">
                                Mis seguimientos
                            </h5>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>
    <div class="col-lg">
        <div class="card">
            <div class="card-body">
                <a href="{{ route('convenios.index') }}">
                    <div class="d-flex flex-row">
                        <div class="round round-lg align-self-center round-info">
                            <i class="fas fa-list-alt">
                            </i>
                        </div>
                        <div class="m-l-10 align-self-center">
                            <h3 class="m-b-0 font-light">
                                {{ $panel['num_convenios'] }}
                            </h3>
                            <h5 class="text-muted m-b-0">
                                Convenios
                            </h5>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>
    <div class="col-lg">
        <div class="card">
            <div class="card-body">
                <div class="d-flex flex-row">
                    <div class="round round-lg align-self-center round-warning">
                        <i class="fas fa-file-pdf">
                        </i>
                    </div>
                    <div class="m-l-10 align-self-center">
                        <h3 class="m-b-0 font-lgiht">
                            {{ $panel['ventas_total'] }}
                        </h3>
                        <h5 class="text-muted m-b-0">
                            Ventas totales
                        </h5>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg">
        <div class="card">
            <div class="card-body">
                <a href="{{ route('actividades.index') }}">
                    <div class="d-flex flex-row">
                        <div class="round round-lg align-self-center round-primary">
                            <i class="fas fa-book">
                            </i>
                        </div>
                        <div class="m-l-10 align-self-center">
                            <h3 class="m-b-0 font-lgiht">
                                {{ $panel['actividades'] }}
                            </h3>
                            <h5 class="text-muted m-b-0">
                                Mis actividades
                            </h5>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>
    <div class="col-lg">
        <div class="card">
            <div class="card-body">
                <a href="{{ asset('files/manual_convenios.pdf') }}" target="_blank">
                    <div class="d-flex flex-row">
                        <div class="round round-lg align-self-center round-success">
                            <i class="fas fa-file-pdf">
                            </i>
                        </div>
                        <div class="m-l-10 align-self-center">
                            <h5 class="text-muted m-b-0">
                                Manual de Convenios
                            </h5>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>
</div>
{{-- <listar-convenios>
</listar-convenios> --}}
<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="card">
            <div class="card-body">
                <div class="d-flex flex-wrap">
                    <div>
                        <h4 class="card-title">
                            Mis convenios
                        </h4>
                    </div>
{{--                     <div class="ml-auto">
                        <a class="btn btn-primary btn-sm" href="{{ route('concals.index') }}" type="button">
                            Nuevo convenio
                        </a>
                        <button class="btn btn-dark btn-sm" id="btnReload" type="button">
                            <i class="fa fa-refresh">
                            </i>
                        </button>
                    </div> --}}
                    <div class="ml-auto">
                        <ul class="list-inline">
                            <li>
                                <input id="user_id" name="user_id" type="hidden" value="{{ Auth::id() }}"/>
                                <input id="role" name="role" type="hidden" value="{{ Auth::user()->role }}"/>
                                <select name="mostrar" id="mostrar" class="form-control">
                                    <option value="todos">Todos</option>
                                    <option value="mios" selected>Mios</option>
                                </select>
                            </li>  
                            <li>
                                <button class="btn btn-sm btn-dark" id="btnReload">
                                   <i class="fa fa-spin fa-refresh"></i>
                                </button> 
                            </li>
                            <li>
                                <a class="btn btn-primary btn-sm" href="{{ route('concals.index') }}" type="button">
                                    Nuevo convenio
                                </a>
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
                                <th>
                                    Llave
                                </th>
                                <th>
                                    Empresa
                                </th>
                                <th>
                                    Liga
                                </th>
                                <th>
                                    # Contratos
                                </th>
                                <th>
                                    Conveniador
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
        var user = @json(Auth::user());
        var table;
        //////
        // Funciona correctamete //
        //////
        var convenios_table;
        pintar_convenios();


        $(document).on('change', '#mostrar', function(event) {
            event.preventDefault();
            pintar_convenios();
        });
        
        
        $('#btnReload').click(function(event){
            event.preventDefault();
            pintar_convenios();
            toastr['info']('Recargando datos...')
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
                // {data: 'pais', name: 'pais'},
                {data: 'llave', name: 'llave'},
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
