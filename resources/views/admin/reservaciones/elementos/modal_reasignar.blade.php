<div aria-hidden="true" aria-labelledby="exampleModalLabel" class="modal fade" id="modalAsignarReservacion" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">
                    Asignar reservación
                </h5>
                <button aria-label="Close" class="close" data-dismiss="modal" type="button">
                    <span aria-hidden="true">
                        ×
                    </span>
                </button>
            </div>
            <form action="" id="formAsignarReservacion" method="post">
                <input id="reservacion_id" name="reservacion_id" type="hidden"/>
                <div class="modal-body">
                    <div class="form-group col-md-12">
                        <label for="inputEmail4">
                            Ejecutivo
                        </label>
                        <select class="form-control custom-select select2 select2-hidden-accessible" id="padre_id" name="padre_id" style="width:100%;">
                            @foreach ($ejecutivos as $ejecutivo)
                            @if ($ejecutivo->admin_padre)
                            <option value="{{ $ejecutivo->admin_padre->id }}">
                                {{ $ejecutivo->fullName }}
                            </option>
                            @endif
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary btn-sm" data-dismiss="modal" type="button">
                        Cerrar
                    </button>
                    <button class="btn btn-primary btn-sm" type="submit">
                        Asignar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>