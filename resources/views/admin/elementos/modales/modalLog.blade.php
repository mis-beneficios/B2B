<!-- Modal -->
<div aria-hidden="true" aria-labelledby="modalLogLabel" class="modal fade" id="modalLog" role="dialog" tabindex="-1">
    <div class="modal-dialog modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalLogLabel">
                    Nueva entrada al log del usuario
                </h5>
                <button aria-label="Close" class="close" data-dismiss="modal" type="button">
                    <span aria-hidden="true">
                        ×
                    </span>
                </button>
            </div>
            <form action="" id="formLog">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <textarea class="form-control" cols="20" id="log" name="log" rows="5"></textarea>
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