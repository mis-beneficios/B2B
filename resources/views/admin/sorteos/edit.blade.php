<form action="{{ route('sorteos.update', $sorteo->id) }}" id="formUpdateSorteo" method="PUT">
    <div class="modal-body">
        <div class="form-row">
            <div class="form-group col-md-12">
                <label for="inputEmail4">
                    Convenio
                </label>
                {{--
                <input class="typeahead form-control" id="empresa_nombre" name="empresa_nombre" type="text">
                </input>
                --}}
             {{--
                <select class="form-control select2 select2-hidden-accessible " id="convenio_id" name="convenio_id" style="width:100%">
                    @foreach ($convenios as $convenio)
                    <option value="{{ $convenio->id }}">
                        {{ $convenio->empresa_nombre }}
                    </option>
                    @endforeach
                </select>
                --}}
                <select class="form-control select2 select2-hidden-accessible custom-select" id="convenio_id_update" name="convenio_id_update" style="width: 95%;">
                    <option value="">
                        Selecciona un convenio
                    </option>
                    @foreach ($convenios as $convenio)
                    <option value="{{$convenio->id}}" {{ $convenio->id == $sorteo->convenio_id ? 'selected' : '' }}>
                        {{$convenio->empresa_nombre}}
                    </option>
                    @endforeach
                </select>
                <br>
                    <span class="text-danger error-convenio_id errors">
                    </span>
                </br>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="fecha_inicio">
                    Fecha de inicio
                </label>
                <input autocomplete="off" class="form-control datepicker_material" id="fecha_inicio_update" name="fecha_inicio_update" value="{{ $sorteo->fecha_inicio }}" type="text">
                </input>
                <span class="text-danger error-fecha_inicio errors">
                </span>
            </div>
            <div class="form-group col-md-6">
                <label for="fecha_fin">
                    Fecha de fin
                </label>
                <input autocomplete="off" class="form-control datepicker_material" id="fecha_fin_update" name="fecha_fin_update" value="{{ $sorteo->fecha_fin }}" type="text">
                </input>
                <span class="text-danger error-fecha_fin errors">
                </span>
            </div>
        </div>
        <div class="form-group">
            <div class="form-check">
                <input class="form-check-input" id="sorteo_especial_update" name="sorteo_especial_update" type="checkbox" value="1" {{ $sorteo->especial == 1 ? 'checked' : '' }}>
                    <label class="form-check-label" for="sorteo_especial">
                        Sorteo especial
                    </label>
                </input>
            </div>
        </div>
        <div class="form-group">
            <div class="btn-group" data-toggle="buttons">
                <label class="btn btn-info btn-sm ">
                    <input name="nomina" type="checkbox" value="1" {{ $sorteo->flag == 1 ? 'checked' : '' }}>
                        {{ $sorteo->flag == 1 ? ' Finalizado' : 'Finalizar' }}
                    </input>
                </label>
            </div>
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

<script>
    $('.datepicker_material').bootstrapMaterialDatePicker({
        weekStart: 0,
        time: false,
        lang: 'es',
    });
</script>