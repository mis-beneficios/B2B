<div aria-hidden="true" aria-labelledby="exampleModalLabel" class="modal fade" id="modalUnlock" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">
                    Desbloquear tarjetas
                </h5>
                <button aria-label="Close" class="close" data-dismiss="modal" type="button">
                    <span aria-hidden="true">
                        ×
                    </span>
                </button>
            </div>
            <form action="{{ route('unlocked') }}" id="formUnlock" method="post">
                @csrf
                <div class="modal-body">
                    <small>
                        Para desbloquear las tarjetas ingrese la contraseña.
                    </small>
                    <input class="form-control" id="unlock" name="unlock" type="password">
                    </input>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary btn-sm" data-dismiss="modal" type="button">
                        Cerrar
                    </button>
                    <button class="btn btn-primary btn-sm" type="submit">
                        Desbloquear
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>