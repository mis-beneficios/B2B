<form action="{{ route('temporadas.update', $temporada->id) }}" id="formUpdateTemporada" method="´put">
    <div class="row">
        <div class="col-lg-4 col-md-6">
            <label class="m-t-20">
                Temporada:
            </label>
            <div class="input-group">
                <select class="form-control" id="temporada" name="temporada">
                    <option value="ALTA">
                        ALTA
                    </option>
                    <option value="MEDIA ALTA">
                        MEDIA ALTA
                    </option>
                    <option value="BAJA">
                        BAJA
                    </option>
                </select>
                <span class="text-danger error-temporada errors">
                </span>
            </div>
        </div>
        <div class="col-lg-4 col-md-6">
            <div class="from-group">
                <label class="m-t-20">
                    Inicio:
                </label>
                <input class="form-control datepicker" data-date-format="yyyy-mm-dd" data-provide="datepicker" name="fecha_inicio" type="text" value="{{ $temporada->fecha_de_inicio }}"/>
            </div>
        </div>
        <div class="col-lg-4 col-md-6">
            <div class="from-group">
                <label class="m-t-20">
                    Fin:
                </label>
                <input class="form-control datepicker" data-date-format="yyyy-mm-dd" data-provide="datepicker" name="fecha_fin" type="text" value="{{ $temporada->fecha_de_termino }}"/>
            </div>
        </div>
    </div>
    <div class="row mt-2">
        <div class="col-md-4">
            <button class="btn btn-primary btn-sm" type="submit">
                Guardar
            </button>
        </div>
    </div>
</form>
<script>
    var temporada = @json($temporada);
    console.log(temporada);
    $('.datepicker').datepicker({
        dateFormat: "yy-mm-dd",
        autoclose:true,
    });
    $("#temporada option").each(function(){
        if ($(this).val() == temporada.title || $(this).val() == temporada.title.toLowerCase()){
            $(this).attr('selected', 'true');
        }
    });
</script>