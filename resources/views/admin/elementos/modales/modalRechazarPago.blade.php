<div aria-hidden="true" aria-labelledby="exampleModalLabel" class="modal fade" data-backdrop="static" id="modalRechazarPago" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">
                    Indique el motivo del rechazo
                </h5>
                <button aria-label="Close" class="close" data-dismiss="modal" type="button">
                    <span aria-hidden="true">
                        ×
                    </span>
                </button>
            </div>
            <form action="" id="formRechazarPago" method="post">
                @csrf
                <input id="pago_id" name="pago_id" type="hidden" value=""/>
                <input id="tarjeta_id" name="tarjeta_id" type="hidden" value=""/>
                <input id="estatus" name="estatus" type="hidden" value=""/>
                <div class="modal-body">
                    <select class="form-control" id="motivo_del_rechazo" name="motivo_del_rechazo">
                        @foreach ($estatus_tarjetas as $x => $val)
                        <option value="{{ $x }}">
                            {{ $val }}
                        </option>
                        @endforeach
                    </select>
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