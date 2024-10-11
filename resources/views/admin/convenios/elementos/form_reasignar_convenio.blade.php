<form action="{{ route('convenios.asignar_convenio', $convenio->id) }}" method="PUT" id="formReasignar">
    @csrf
    <div class="row">
        <div class="form-group col-md-12">
            <label for="inputEmail4">
                Conveniador
            </label>
<!--             <input id="convenio_id" name="convenio_id" type="hidden" value="{{ $convenio->id }}">
            </input> -->
            <select class="form-control selecte2" id="user_id" name="user_id"  style="width: 100%;">
                @foreach ($conveniadores as $con)
                <option value="{{ $con->id }}" @if($con->id == $convenio->user_id) selected @endif>
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
