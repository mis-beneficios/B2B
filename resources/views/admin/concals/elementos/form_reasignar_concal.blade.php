<form action="{{ route('concals.asignar_concals', $concal->id) }}" method="PUT" id="formReasignar">
    @csrf
    <div class="row">
        <div class="form-group col-md-12">
            <label for="inputEmail4">
                Conveniador
            </label>

            <select class="form-control selecte2" id="user_id" name="user_id"  style="width: 100%;">
                @foreach ($conveniadores as $con)
                <option value="{{ $con->id }}" @if($con->id == $concal->user_id) selected @endif>
                    {{ $con->fullName }}
                </option>
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
<script>
    $('body #user_id').select2();
</script>
