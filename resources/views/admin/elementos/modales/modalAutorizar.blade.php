<div aria-hidden="true" aria-labelledby="modalAutorizar" class="modal fade" id="modalAutorizar" tabindex="-1">
    <div class="modal-dialog">
        <form action="" class="" id="form_autorizar">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalAutorizarLabel">
                    </h5>
                    <button aria-label="Close" class="close" data-dismiss="modal" type="button">
                        <span aria-hidden="true">
                            ×
                        </span>
                    </button>
                </div>
                <div class="modal-body" id="modal-body">
                    <input class="form-control" id="contrato_id" name="contrato_id" readonly="" type="text">
                    </input>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary btn-sm" data-dismiss="modal" type="button">
                        {{ __('messages.cerrar') }}
                    </button>
                    <button class="btn btn-info btn-sm" type="submit">
                        Autorizar
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>