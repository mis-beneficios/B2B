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
</style>
<div class="row page-titles">
    <div class="col-md-5 col-8 align-self-center">
        <h3 class="text-themecolor">
            Dashboard
        </h3>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('dashboard') }}">
                    Home
                </a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ route('convenios.index') }}">
                    Convenios
                </a>
            </li>
            <li class="breadcrumb-item active text-capitalize">
                {{ $convenio->empresa_nombre }}
            </li>
        </ol>
    </div>
</div>

{{-- {{  dd(Storage::disk('s3')->get($convenio->logo)) }} --}}
<div class="show-convenio">
    <div class="row" data-title="¡Nuevos cambios!" data-intro="Te dare un nuevo recorrido por los cambios realizados en esta vista 👋">
        <!-- Column -->
        <div class="col-lg-4 col-xlg-3 col-md-5">
            <div class="card">
                <div class="card-body">
                    <center class="m-t-30">
                        {{-- <img class="img-circle" src="{{ $convenio->logo != null ? asset('images/empresas/'.$convenio->logo) : asset('images/empresas/sin-imagen.png') }}" width="150"/> --}}
                        <img class="img-fluid" src="{{ ($convenio->logo != null) ? Storage::disk('s3')->url($convenio->logo) : asset('images/sin_imagen.jpg') }}" width="150"/ data-intro="Logotipo de la empresa">
                        <h4 class="card-title m-t-10 text-uppercase" data-intro="Nombre de la empresa">
                            {{ $convenio->empresa_nombre }}
                        </h4>
                        <h6 class="card-subtitle" data-intro="Llave de la pagina de compra">
                            <a href="{{ env('PRODUCT_URL') . $convenio->llave }}" target="_blank">
                                {{  $convenio->llave }}
                            </a>
                        </h6>
                        <div class="row text-center justify-content-md-center">
                            <div class="col-4">
                                <a class="link" href="javascript:void(0)">
                                    Contratos
                                    <font class="font-medium" data-intro="Numero de contratos generados">
                                        {{ count($convenio->contratos) }}
                                    </font>
                                </a>
                            </div>
                        </div>
                    </center>
                    @if (Auth::user()->can('update', $convenio))
                    <div class="text-center">
                        <a href="{{ route('convenios.edit', $convenio->id) }}" class="btn btn-primary btn-sm mt-4" data-intro="Editar convenio">
                            <i class="fas fa-pencil-square-o"></i>
                            Editar
                        </a>
                    </div>
                    @endif
                </div>
                <div>
                    <hr/>
                </div>
                <div class="card-body" data-intro="Informacion del convenio">
                    <small class="text-muted">
                        Conveniador
                    </small>
                    <h6>
                        {{ ($convenio->user) ?  $convenio->user->fullName : 'S/R' }}
                    </h6>
                    <small class="text-muted db">
                        Activo hasta
                    </small>
                    <h6>
                        {{ $convenio->activo_hasta }}
                    </h6>
                    <small class="text-muted db">
                        Estatus
                    </small>
                    <h6>
                        <label class="label {{ ($convenio->disponible == 1) ? 'label-info' : 'label-danger' }}">
                            {{ ($convenio->disponible == 1) ? 'Activo' : 'Inactivo' }}
                        </label>
                    </h6>
                    <small class="text-muted db">
                        Fecha de cierre
                    </small>
                    <h6>
                        {{ $convenio->fecha_cierre }}
                    </h6>
                    <small class="text-muted db">
                        Campaña
                    </small>
                    <h6>
                        {{ $convenio->campana_inicio ." al ". $convenio->campana_fin }}
                    </h6>
                    <small class="text-muted db">
                        Creado
                    </small>
                    <h6>
                        {{ $convenio->creado() }}
                    </h6>
                    <small class="text-muted db">
                        Modificado
                    </small>
                    <h6>
                        {{ $convenio->modificado()  }}
                    </h6>
                    <hr>
                    @if ($convenio->concal)
                    <small class="text-muted db">
                        Empresa
                    </small>
                    <h6>
                        {{ $convenio->concal->empresa  }}
                    </h6>
                    <small class="text-muted db">
                        Estado
                    </small>
                    <h6>
                        {{ $convenio->concal->estado  }}
                    </h6>
                    <small class="text-muted db">
                        Sucursales
                    </small>
                    <h6>
                        {{ ($convenio->concal->sucursales == 0) ? 'NO' : 'SI'  }}
                    </h6>
                    @if($convenio->concal->sucursales == 1)
                    <h6>
                        {{ $convenio->concal->sucursal_lugar  }}
                    </h6>
                    @endif
                    <small class="text-muted db">
                        Categoría
                    </small>
                    <h6>
                        {{ $convenio->concal->categoria  }}
                    </h6>
                    <small class="text-muted db">
                        No. de empleados
                    </small>
                    <h6>
                        {{ $convenio->concal->no_empleados  }}
                    </h6>
                    <small class="text-muted db">
                        Método de pago
                    </small>
                    <h6>
                        {{ $convenio->concal->metodo_pago  }}
                    </h6>
                    <small class="text-muted db">
                        Estrategia
                    </small>
                    <h6>
                        {{ $convenio->concal->estrategia  }}
                    </h6>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-lg-8 col-xlg-9 col-md-7">
            <div class="card">
                <ul class="nav nav-tabs profile-tab" role="tablist">
                    @if (Auth::user()->role != 'client' || Auth::user()->role != 'sales')
                    <li class="nav-item" data-intro="Listado de contratos generados">
                        <a aria-expanded="false" class="nav-link active" data-toggle="tab" href="#home" role="tab">
                            Contratos generados
                        </a>
                    </li>
                    @endif
                    <li class="nav-item" data-intro="Documento del convenio">
                        <a aria-expanded="false" class="nav-link" data-toggle="tab" href="#convenio" role="tab">
                            Convenio
                        </a>
                    </li>
                    <li class="nav-item" data-intro="Imagen de bienvenida, se muestra en la pagina web de la agencia">
                        <a aria-expanded="false" class="nav-link" data-toggle="tab" href="#bienvenida" role="tab">
                            Imagen de bienvenida
                        </a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div aria-expanded="false" class="tab-pane active" id="home" role="tabpanel">
                        <div class="card-body">
                            <div class="">
                                <div class="sl-item">
                                    <div class="table-responsive">
                                        <table class="table table-hover" id="table_contratos">
                                            <thead>
                                                <tr>
                                                    <th>
                                                        # Folio
                                                    </th>
                                                    <th>
                                                        Cliente
                                                    </th>
                                                    <th>
                                                        Estancia
                                                    </th>
                                                    <th>
                                                        Estatus
                                                    </th>
                                                    <th>
                                                        Creado
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
                    <div aria-expanded="false" class="tab-pane" id="convenio" role="tabpanel">
                        <div class="card-body">
                            @if ($convenio->convenio_file != null)
                            <div class="">
                                <iframe src="{{ Storage::disk('s3')->url($convenio->convenio_file) }}" frameborder="0" class="form-control" style="height: 550px;"></iframe>
                            </div>
                            @else
                                <p class="text-danger">No se ha encontrado el archivo correspondiente al convenio</p>
                            @endif
                        </div>
                    </div> 

                    <div aria-expanded="false" class="tab-pane" id="bienvenida" role="tabpanel">
                        <div class="card-body">
                            @if ($convenio->img_bienvenida != null)
                            <div class="">
                                <img src="{{ Storage::disk('s3')->url($convenio->img_bienvenida) }}" frameborder="0" class="img-fluid" />
                            </div>
                            @else
                                <p class="text-danger">No se ha encontrado el archivo</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Column -->
    </div>
</div>
@endsection
@section('script')
<script>
    

    $(document).ready(function() {
        var tabla = $('#table_contratos').DataTable({
            processing: true,
            serverSide: true,
            bDestroy: true,
            order: [0, 'desc'],
            ajax: baseadmin + "contrato-por-convenio/" + {{ $convenio->id  }},
            columns: [
                {data: 'id', name: 'id'},
                {data: 'cliente', name: 'cliente'},
                {data: 'estancia', name: 'estancia'},
                {data: 'estatus', name: 'estatus'},
                {data: 'creado', name: 'creado'},
            ],
        });
    });
</script>
@endsection
