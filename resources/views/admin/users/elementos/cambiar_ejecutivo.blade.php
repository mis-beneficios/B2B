<form action="{{ route('reservacions.update_ejecutivo', $reservacion->id) }}" id="formEjecutivo" method="PUT">
    @csrf
    <div class="row">
        <div class="form-group col-md-12">
            <label for="inputEmail4">
                Ejecutivo
            </label>
            <select class="form-control select2 m-b-10" id="user_id" name="user_id" style="width: 100%">>
                @foreach ($padres as $padre)
                @if (isset($padre->vendedor->fullName))
                <option value="{{ $padre->id }}" @if($padre->id == $reservacion->padre_id) selected  @endif>
                    {{ $padre->vendedor->fullName .' - '. $padre->title }}
                </option>
                @endif
                @endforeach

            </select>
        </div>
    </div>
    <div class="modal-footer">
        <button class="btn btn-secondary" data-dismiss="modal" type="button">
            Cerrar
        </button>
        <button class="btn btn-primary" type="submit">
            Guardar
        </button>
    </div>
</form>

