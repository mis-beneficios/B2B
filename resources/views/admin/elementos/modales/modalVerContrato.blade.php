<div aria-hidden="true" aria-labelledby="modalVerContrato" class="modal fade" id="modalVerContrato" tabindex="-1">
    <div class="modal-dialog modal-dialog-scrollable modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalVerContratoLabel">
                    <h4 class="card-title m-b-0">
                        {{ __('messages.user.show.contratos') }}
                    </h4>
                </h5>
                <button aria-label="Close" class="close" data-dismiss="modal" type="button">
                    <span aria-hidden="true">
                        ×
                    </span>
                </button>
            </div>
            <div class="modal-body">
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary btn-sm" data-dismiss="modal" type="button">
                    {{ __('messages.cerrar') }}
                </button>
                <a class="btn btn-info btn-sm" id="downloadPdf" style="color:white" target="_blank" type="button">
                    {{ __('messages.descargar') }}
                </a>
            </div>
        </div>
    </div>
</div>
