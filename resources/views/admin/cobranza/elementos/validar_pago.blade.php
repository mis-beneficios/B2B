<div class="container">
    <div class="row">
        <div class="col-md-12">
            <form class="mt-3 mb-4" id="form_validar_pago">
                <div class="row">
                    <div class="col-md-12">
                        <dl class="row">
                            <dt class="col-sm-4">
                                No. Contrato:
                            </dt>
                            <dd class="col-sm-8">
                                <a href="{{ route('users.show', $contrato->cliente->id) }}">
                                    {{ $contrato->id }}
                                </a>
                            </dd>
                            <dt class="col-sm-4">
                                Cliente:
                            </dt>
                            <dd class="col-sm-8">
                                {{ $contrato->cliente->fullName }}
                            </dd>
                            <dt class="col-sm-4">
                                Estatus del cobro:
                            </dt>
                            <dd class="col-sm-8">
                                {{ $pago->estatus }}
                            </dd>
                            <dt class="col-sm-4 text-truncate">
                                Cantidad:
                            </dt>
                            <dd class="col-sm-8">
                                $ {{ number_format($pago->cantidad) }}
                            </dd>
                            <dt class="col-sm-4 text-truncate">
                                ID Pago:
                            </dt>
                            <dd class="col-sm-8">
                                {{ $pago->id }}
                            </dd>
                            <dt class="col-sm-4 text-truncate">
                                Segmento:
                            </dt>
                            <dd class="col-sm-8">
                                # {{ $pago->segmento }}
                            </dd>
                        </dl>
                    </div>
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-6">
                                <button class="btn btn-danger btn-sm btn-block btnCambiarEstatus" data-action="rechazo" data-estatus="{{ $pago->estatus }}" data-pago_id="{{ $pago->id }}" data-tarjeta_id="{{ $pago->contrato->tarjeta_id }}" id="btnRechazado">
                                    Pago rechazado
                                </button>
                            </div>
                            <div class="col-md-6">
                                <button class="btn btn-info btn-sm btn-block btnCambiarEstatus" data-action="autorizar" data-estatus="{{ $pago->estatus }}" data-pago_id="{{ $pago->id }}" data-tarjeta_id="{{ $pago->contrato->tarjeta_id }}" id="btnAutorizar">
                                    Pago autorizado
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>