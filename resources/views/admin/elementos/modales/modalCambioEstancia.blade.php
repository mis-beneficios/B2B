<div aria-hidden="true" aria-labelledby="modalCambioEstancia" class="modal fade" data-backdrop="static" id="modalCambioEstancia" tabindex="-1">
    <div class="modal-dialog">
        <form action="" class="" id="cambio_estancia" method="post">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalCambioEstanciaLabel">
                        {{ __('messages.cambio_estancia') }}
                    </h5>
                    <button aria-label="Close" class="close" data-dismiss="modal" type="button">
                        <span aria-hidden="true">
                            ×
                        </span>
                    </button>
                </div>
                <div class="modal-body" id="modal-body">
                    <input id="contrato_id" name="contrato_id" type="hidden"/>
                    <select class="form-control select2 select2-hidden-accessible m-b-10" id="estancia_id" name="estancia_id" style="width: 100%;">
                    </select>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary btn-sm" data-dismiss="modal" type="button">
                        {{ __('messages.cerrar') }}
                    </button>
                    <button class="btn btn-info btn-sm" type="submit">
                        {{ __('messages.guardar') }}
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>