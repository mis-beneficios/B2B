<style>
    .demo-checkbox label, .demo-radio-button label {
        min-width: 0px;
        margin-bottom: 0px;
    }
</style>
<div aria-hidden="true" aria-labelledby="modalShowPagos" class="modal fade" data-backdrop="static" id="modalShowPagos" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalShowPagosLabel">
                    <h4 class="card-title m-b-0">
                        {{ __('messages.cliente.historial_pagos') }}
                        <span id="folioContrato">
                        </span>
                    </h4>
                </h5>
                <button aria-label="Close" class="close" data-dismiss="modal" id="btnCerrar1" type="button">
                    <span aria-hidden="true">
                        ×
                    </span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <form action="{{ route('pagos.delete_multiple') }}" id="form_delete" method="get">
                            <input type="hidden" name="contrato_id_value" id="contrato_id_value">
                            <div class="table-responsive">
                                <table class="table table-hover data_pagos" id="table_pagos" style="width: 100%">
                                    <thead>
                                        <tr>
                                            <th class="col-1">
                                            </th>
                                            <th width="60px">
                                                {{ __('messages.cliente.segmento') }}
                                            </th>
                                            <th>
                                                {{ __('messages.cliente.estatus') }}
                                            </th>
                                            <th>
                                                {{ __('messages.cliente.cantidad') }}
                                            </th>
                                            <th class="text-nowrap" width="90px">
                                                {{ __('messages.cliente.fecha_de_cobro') }}
                                            </th>
                                            <th class="text-nowrap" width="90px">
                                                {{ __('messages.cliente.fecha_de_pago') }}
                                            </th>
                                            <th class="text-nowrap">
                                                Opciones
                                            </th>
                                        </tr>
                                    </thead>
                                </table>
                                <tbody>
                                </tbody>
                            </div>
                            @if (Auth::user()->role == 'admin' || Auth::user()->role == 'collector')
                                <button class="btn btn-danger btn-sm" type="submit" id="deleteSeleccion">
                                    Eliminar selección
                                </button>
                            @endif
                            @if (Auth::user()->role == 'admin' || Auth::user()->role == 'collector')
                                <button class="btn btn-warning btn-sm deleteRestantes" type="button" id="deleteRestantes">
                                    Eliminar segmentos restantes
                                </button>
                            @endif
                        </form>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                
                <button class="btn btn-secondary" data-dismiss="modal" id="btnCerrar" type="button">
                    Cerrar
                </button>
            </div>
        </div>
    </div>
</div>
