<div class="form-body">
    <div class="row p-t-10">
        <div class="col-lg-4 col-md-4">
            <div class="form-group">
                <label class="control-label">
                    Nombre
                </label>
                <input class="form-control" id="nombre" name="nombre" type="text" value="">
                </input>
                <span class="text-danger error-nombre errors">
                </span>
            </div>
        </div>
        <div class="col-lg-2 col-md-2">
            <div class="form-group">
                <label class="control-label">
                    Llave cache
                </label>
                <input class="form-control" id="key_cache" name="key_cache" type="text" value="">
                </input>
                <span class="text-danger error-key_cache errors">
                </span>
            </div>
        </div>
        <div class="col-lg-2 col-md-2">
            <div class="form-group has-success">
                <label class="control-label">
                    Estatus
                </label>
                <select class="form-control select2 select2-hidden-accessible custom-select" id="estatus" name="estatus" style="width: 95%;">
                    <option value="">
                        Selecciona el estatus
                    </option>
                    <option value="0">Activo</option>
                    <option value="1">Inactivo</option>
                </select>
                <br/>
                <span class="text-danger error-estatus errors">
                </span>
            </div>
        </div>
        <div class="col-lg-2 col-md-2">
            <div class="form-group">
                <label class="control-label">
                    Activo hasta
                </label>
                <input class="form-control datepicker" id="activo_hasta" name="activo_hasta" type="text" value="">
                </input>
                <span class="text-danger error-activo_hasta errors">
                </span>
            </div>
        </div>
        <div class="col-lg-12 col-md-12">
            <div class="form-group has-success">
                <label class="control-label">
                    Mostrar a
                </label>
                 <select class="form-control custom-select select2 m-b-10 select2-multiple select2-hidden-accessible" id="show_role" multiple="" name="show_role[]" style="width: 95%;">
                {{-- <select class="form-control select2 select2-hidden-accessible custom-select" id="show_role" name="show_role" style="width: 95%;"> --}}
                    <option value="all" selected>Todos</option>
                    @foreach ($roles as $rol => $val)
                    <option value="{{ $rol }}">{{ $val }}</option>
                    @endforeach
                </select>
                <br/>
                <span class="text-danger error-show_role errors">
                </span>
            </div>
        </div>
        <div class="col-md-12">
            <div class="col-lg col-md">
                <div class="form-group ">
                    <label class="control-label">
                        Cuerpo de notificación
                    </label>
                    <textarea autocomplete="off" class="form-control" id="cuerpo" name="cuerpo" rows="40"></textarea>
                    <span class="text-danger error-cuerpo errors">
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>