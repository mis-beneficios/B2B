@extends('layouts.admin.app')
<style type="text/css">
    .dropdown-toggle{
        padding: 5px 1rem;
    }
</style>
@section('content')
<div class="row page-titles">
    <div class="col-md-5 col-8 align-self-center">
        <h3 class="text-themecolor">
            Dashboard
        </h3>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="javascript:void(0)">
                    Home
                </a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ route('users.index') }}">
                    Users
                </a>
            </li>
            <li class="breadcrumb-item active">
                {{ $user->fullName }}
            </li>
        </ol>
    </div>
</div>
<div class="">
    <div class="row">
        <div class="col-xl-3 col-lg-4 col-md">
            @include('admin.users.elementos.info_user')
            @include('admin.users.elementos.info_access_user')
        </div>
        <div class="col-xl-9 col-lg-8 col-md">
            <div class="card">
                <div class="card-header">
                    <div class="card-actions">

                        @if (Auth::user()->can('create', App\Tarjeta::class))
                        
                        <button class="btn btn-info btn-xs" data-toggle="modal" data-user_id="{{ $user->id }}" id="btnAddTarjeta">
                            <span>
                                <i class="fas fa-plus">
                                </i>
                                {{ __('messages.user.show.agregar_tarjeta') }}
                            </span>
                        </button>
                        
                        @endif
                        <button class="btn btn-dark btn-sm" data-user_id="{{ $user->id }}" id="btnReloadT">
                            <i class="fa fa-spin fa-refresh">
                            </i>
                        </button>
                        <a class="" data-action="collapse">
                            <i class="ti-minus">
                            </i>
                        </a>
                        <a class="btn-close" data-action="close">
                            <i class="ti-close">
                            </i>
                        </a>
                    </div>
                    <h4 class="card-title m-b-0">
                        {{ __('messages.user.show.tarjetas') }}
                    </h4>
                </div>
                <div class="card-body collapse show">
                    <div class="table-responsive">
                        <table class="table product-overview" id="table_tarjetas" style="width: 100%">
                            <thead>
                                <tr>
                                    <th>
                                        
                                    </th>
                                    <th>
                                        {{ __('messages.user.show.titular_numero') }}
                                    </th>
                                    <th>
                                        {{ __('messages.user.show.banco') }}
                                    </th>
                                    <th>
                                        {{ __('messages.user.show.estatus') }}
                                    </th>
                                    <th>
                                        {{ __('messages.user.show.tipo') }}
                                    </th>
                                    <th>
                                        Creado / Modificado
                                    </th>
                                    <th>
                                        {{ __('messages.user.show.opciones') }}
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <div class="card-actions">
                        {{-- @if (Auth::user()->can('create', App\Contrato::class)) --}}
                        <button class="btn btn-info btn-xs" data-user_id="{{ $user->id }}" id="btnAddContrato">
                            <span>
                                <i class="fas fa-plus">
                                </i>
                                {{ __('messages.user.show.agregar_contrato') }}
                            </span>
                        </button>
                        <button class="btn btn-dark btn-sm" data-user_id="{{ $user->id }}" id="btnReloadC">
                            <i class="fa fa-spin fa-refresh">
                            </i>
                        </button>
                        <a class="" data-action="collapse">
                            <i class="ti-minus">
                            </i>
                        </a>
                        <a class="btn-close" data-action="close">
                            <i class="ti-close">
                            </i>
                        </a>
                        {{-- @endif --}}
                    </div>
                    <h4 class="card-title m-b-0">
                        {{ __('messages.user.show.contratos') }}
                    </h4>
                </div>
                <div class="table-responsive">
                    <div class="card-body collapse show">
                        <table class="table table-stripe" id="table_contratos" style="width: 100%;  min-height: 220px;">
                            <thead>
                                <tr>
                                    <th class="sorting" colspan="1" rowspan="1" tabindex="0">
                                    </th>
                                    <th class="sorting" colspan="1" rowspan="1" tabindex="0">
                                        {{ __('messages.user.show.folio') }}
                                    </th>
                                    <th class="sorting" colspan="1" rowspan="1" tabindex="0">
                                        {{ __('messages.user.show.estancia') }}
                                    </th>
                                    <th class="sorting" colspan="1" rowspan="1" tabindex="0">
                                        {{ __('messages.user.show.estatus') }}
                                    </th>
                                    <th class="sorting" colspan="1" rowspan="1" tabindex="0">
                                        {{-- {{ __('messages.user.show.metodo_de_compra') }} --}}
                                        {{ __('messages.user.show.precio') }} / Pendiente
                                    </th>
                                    <th class="sorting" colspan="1" rowspan="1" tabindex="0">
                                        {{ __('messages.user.show.pagos') }}
                                    </th>
                                    <th class="sorting" colspan="1" rowspan="1" tabindex="0">
                                        {{ __('messages.user.show.opciones') }}
                                    </th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
            @if (Auth::user()->can('viewAny', App\Reservacion::class))
            <div class="card">
                <div class="card-header">
                    <div class="card-actions">
                        @if (Auth::user()->role == 'reserver' || Auth::user()->role == 'admin')
                            <button class="btn btn-info btn-xs" data-user_id="{{ $user->id }}" id="btnAddReservacion">
                                <span>
                                    <i class="fas fa-plus">
                                    </i>
                                    Agregar reservación
                                </span>
                            </button>
                        @endif
                    
                        {{--
                        <a class="btn btn-info btn-xs" href="{{ route('reservations.create', $user->id) }}">
                            <span>
                                <i class="fas fa-plus">
                                </i>
                                Agregar reservación
                            </span>
                        </a>
                        --}}
                        <button class="btn btn-dark btn-sm" data-user_id="{{ $user->id }}" id="btnReloadR">
                            <i class="fa fa-spin fa-refresh">
                            </i>
                        </button>
                        <a class="" data-action="collapse">
                            <i class="ti-minus">
                            </i>
                        </a>
                        <a class="btn-close" data-action="close">
                            <i class="ti-close">
                            </i>
                        </a>
                    </div>
                    <h4 class="card-title m-b-0">
                        {{ __('messages.reservaciones') }}
                    </h4>
                </div>
                <div class="card-body collapse show">
                    <div class="table-responsive">
                        <table class="table table-hover" id="table_reservaciones" style="width: 100%; min-height: 220px;">
                            <thead>
                                <tr>
                                    <th class="sorting" colspan="1" rowspan="1" tabindex="0">
                                    </th>
                                    <th class="sorting" colspan="1" rowspan="1" tabindex="0">
                                    </th>
                                    <th class="sorting" colspan="1" rowspan="1" tabindex="0">
                                        {{ __('messages.estatus') }}
                                    </th>
                                    <th class="sorting" colspan="1" rowspan="1" tabindex="0">
                                        {{ __('messages.fecha_de_reservacion') }}
                                    </th>
                                    <th class="sorting" colspan="1" rowspan="1" tabindex="0">
                                        {{ __('messages.destino') }}
                                    </th>
                                    <th class="sorting" colspan="1" rowspan="1" tabindex="0">
                                        {{ __('messages.user.show.opciones') }}
                                    </th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
<div class="modal fade" id="modalVendedor">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalVendedorLabel">
                    Cambiar ejecutivo
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

<div class="modal fade" id="modalEjecutivo">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalEjecutivoLabel">
                    Cambiar ejecutivo
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
<div aria-hidden="true" aria-labelledby="modalAddCalidad" class="modal fade" id="modalAddCalidad" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalAddTarjetaLabel">
                    Agregar calidad
                </h5>
                <button aria-label="Close" class="close" data-dismiss="modal" type="button">
                    <span aria-hidden="true">
                        ×
                    </span>
                </button>
            </div>
            <form action="" method="POST" id="imageUploadForm" enctype="multipart/form-data">
                <input type="hidden" value="" id="contrato_id" name="contrato_id">
                <div class="modal-body" id="modal-body">
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label for="inputEmail4">
                                Cargar imagen
                                <br/>
                                <small class="text-danger">Puede seleccionar mas de una imagen a cargar</small>
                            </label>
                            <div class="input-group mb-3">
                                <input class="form-control" type="file" name="images[]" multiple>
                                </input>
                            </div>
                            <span class="text-danger error-images errors">
                            </span>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary btn-sm" data-dismiss="modal" type="button">
                        Cerrar
                    </button>
                    <button class="btn btn-primary btn-sm" type="submit">
                        Guardar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<div aria-hidden="true" aria-labelledby="modalVerCalidad" class="modal fade" id="modalVerCalidad" tabindex="-1">
    <div class="modal-dialog modal-xl">
        <div class="modal-content ">
            <div class="modal-header">
                <h5 class="modal-title" id="titleCalidad">
                    
                </h5>
                <button aria-label="Close" class="close" data-dismiss="modal" type="button">
                    <span aria-hidden="true">
                        ×
                    </span>
                </button>
            </div>
            <div class="modal-body" id="modal-body">
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary btn-sm" data-dismiss="modal" type="button">
                    Cerrar
                </button>
                <button class="btn btn-primary btn-sm" type="submit">
                    Guardar
                </button>
            </div>
        </div>
    </div>
</div>
@include('admin.reservaciones.elementos.modal_reasignar')
@endsection

@section('script')

@include('admin.users.script')
@include('admin.users.reservaciones_script')

<script>
    var cliente = @json($user);
    $('body').on('click', '#addName', function(event) {
        event.preventDefault();
        $('#nombre_adquisitor').val(cliente.nombre + ' ' + cliente.apellidos);
    });
    

    $('body').on('click', '#addEmail', function(event) {
        event.preventDefault();
        $('#email').val(cliente.username);
    });


    $('body').on('click', '#addTelefono', function(event) {
        event.preventDefault();
        $('#telefono').val(cliente.telefono);
    });
</script>
@endsection
