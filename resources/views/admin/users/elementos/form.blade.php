<div class="form-body">
    <div class="row p-t-10">
        <div class="col-lg-3 col-md-4 col-sm-6">
            <div class="form-group">
                <label class="control-label">
                    {{ __('messages.user.show.nombre') }}
                </label>
                <input class="form-control" id="nombre" name="nombre" type="text">
                </input>
                <span class="text-danger error-nombre errors">
                </span>
            </div>
        </div>
        <div class="col-lg-3 col-md-4 col-sm-6">
            <div class="form-group ">
                <label class="control-label">
                    {{ __('messages.user.show.apellidos') }}
                </label>
                <input class="form-control form-control" id="apellidos" name="apellidos" type="text">
                    <small class="form-control-feedback">
                    </small>
                </input>
                <span class="text-danger error-apellidos errors">
                </span>
            </div>
        </div>
        <div class="col-lg-3 col-md-4 col-sm-6">
            <div class="form-group">
                <label class="control-label">
                    {{ __('messages.user.show.username') }}
                </label>
                <input class="form-control" id="username" name="username" placeholder="ejemplo@mail.com" type="mail">
                    <small class="form-control-feedback">
                    </small>
                </input>
                <span class="text-danger error-username errors">
                </span>
            </div>
        </div>
        <div class="col-lg-3 col-md-4 col-sm-6">
            <div class="form-group ">
                <label class="control-label">
                    {{ __('messages.login.contrasena') }}
                </label>
                <input class="form-control form-control" id="password" name="password" type="password">
                    <small class="form-control-feedback">
                    </small>
                </input>
                <span class="text-danger error-password errors">
                </span>
            </div>
        </div>
        @if (Auth::user()->role == 'admin')
        <div class="col-lg-3 col-md-4 col-sm-6">
            <div class="form-group ">
                <label class="control-label">
                    {{ __('messages.user.show.rol') }}
                </label>
                <select class="form-control select2 select2-hidden-accessible custom-select" id="role" name="role" style="width: 95%;">
                    <option value="">
                        {{ __('messages.selecciona_opcion') }}
                    </option>
                    <option value="admin">
                        Administrador
                    </option>
                    <option value="client">
                        Cliente
                    </option>
                    <option value="recepcionist">
                        Recepsionista
                    </option>
                    <option value="supervisor">
                        Supervisor de Ventas
                    </option>
                    <option value="sales">
                        Ejecutivo de Ventas
                    </option>
                    <option value="collector">
                        Ejecutivo de Cobranza
                    </option>
                    <option value="reserver">
                        Ejectutivo de Reservaciones
                    </option>
                    <option value="conveniant">
                        Generador de Convenios
                    </option>
                    <option value="quality">
                        Control de Calidad
                    </option>
                    <option value="control">
                        Control de Ventas
                    </option>
                </select>
                <span class="text-danger error-role errors">
                </span>
            </div>
        </div>
        @endif
        <div class="col-lg-3 col-md-3 col-sm-6">
            <div class="form-group ">
                <label class="control-label">
                    {{ __('messages.user.show.telefono') }}
                </label>
                <input class="form-control form-control" id="telefono" name="telefono" placeholder="01234567890" type="text">
                    <small class="form-control-feedback">
                    </small>
                </input>
                <span class="text-danger error-telefono errors">
                </span>
            </div>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-6">
            <div class="form-group ">
                <label class="control-label">
                    {{ __('messages.user.show.telefono_casa') }}
                </label>
                <input class="form-control form-control" id="telefono_casa" name="telefono_casa" placeholder="01234567890" type="text">
                    <small class="form-control-feedback">
                    </small>
                </input>
                <span class="text-danger error-telefono_casa errors">
                </span>
            </div>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-6">
            <div class="form-group ">
                <label class="control-label">
                    {{ __('messages.user.show.telefono_oficina') }}
                </label>
                <input class="form-control form-control" id="telefono_oficina" name="telefono_oficina" placeholder="01234567890" type="text">
                    <small class="form-control-feedback">
                    </small>
                </input>
                <span class="text-danger error-telefono_oficina errors">
                </span>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-3 col-md-4 col-sm-6">
            <div class="form-group has-success">
                <label class="control-label">
                    {{ __('messages.user.show.convenio') }}
                </label>
                <select class="form-control select2 select2-hidden-accessible custom-select" id="convenio_id" name="convenio_id" style="width: 95%;">
                    <option value="">
                        Selecciona un convenio
                    </option>
                    @foreach ($convenios as $convenio)
                    <option value="{{$convenio->id}}">
                        {{$convenio->empresa_nombre}}
                    </option>
                    @endforeach
                </select>
                <br/>
                <span class="text-danger error-convenio_id errors">
                </span>
            </div>
        </div>
        <!--/span-->
        <div class="col-lg-3 col-md-4 col-sm-6">
            <div class="form-group">
                <label class="control-label">
                    {{ __('messages.user.show.fecha_nacimiento') }}
                </label>
                <input class="form-control" id="cumpleanos" name="cumpleanos" placeholder="dd/mm/yyyy" type="date">
                </input>
                <span class="text-danger error-cumpleanos errors">
                </span>
            </div>
        </div>
        <div class="col-lg-2 col-md-4 col-sm-6">
            <div class="form-group">
                <label class="control-label">
                    {{ __('messages.user.show.rfc') }}
                </label>
                <input class="form-control" id="rfc" name="rfc" placeholder="" type="text">
                    <small class="form-control-feedback">
                    </small>
                </input>
                <span class="text-danger error-rfc errors">
                </span>
            </div>
        </div>
        <div class="col-lg-2 col-md-3 col-sm-6">
            <div class="form-group ">
                <label class="control-label">
                    {{ __('messages.user.show.no_empleado') }}
                </label>
                <input class="form-control form-control" id="no_empleado" name="no_empleado" type="text">
                    <small class="form-control-feedback">
                    </small>
                </input>
                <span class="text-danger error-no_empleado errors">
                </span>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-2 col-md-4 col-sm-6 form-group">
            <label for="cp">
                {{ __('messages.user.show.cp') }}
            </label>
            <input aria-describedby="codigo_postal" class="form-control" id="cp" name="cp" onkeyup="buscar_cp()" placeholder="12345" type="text" value="">
            </input>
            <span class="text-danger error-cp errors">
            </span>
        </div>
        <div class="form-group col-md-4">
            <label for="cp">
                {{ __('messages.user.show.estado') }}
            </label>
            <input class="form-control" id="estado" name="estado" placeholder="Estado" type="text" value=""/>
            <span class="text-danger error-estado errors">
            </span>
        </div>
        <div class="form-group col-md-4">
            <label for="cp">
                {{ __('messages.user.show.estado') }}
            </label>
            <input class="form-control" id="delegacion" name="delegacion" placeholder="Delegación" type="text" value=""/>
            <span class="text-danger error-delegacion errors">
            </span>
        </div>
        <div class="form-group col-md-4">
            <label for="cp">
                Colonia
            </label>
            <select class="form-control" id="colonia" name="colonia" required="">
                <option value="0">
                    SELECCIONA TU COLONIA
                </option>
            </select>
            <span class="text-danger error-colonia errors">
            </span>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label>
                    Pais
                </label>
                <input class="form-control" id="pais" name="pais" type="text" value="{{ (env('APP_PAIS_ID') == 1) ? 'México' : 'United States' }}">
                </input>
                <span class="text-danger error-pais errors">
                </span>
            </div>
        </div>
        <!--/span-->
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label>
                    Dirección
                </label>
                <textarea class="form-control" cols="20" id="direccion" name="direccion" rows="4">
                </textarea>
                <span class="text-danger error-direccion errors">
                </span>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label>
                    Información extra
                </label>
                <textarea class="form-control" cols="20" id="direccion2" name="direccion2" rows="4">
                </textarea>
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label>
                    ¿Como se entero?
                </label>
                <select class="form-control select2 select2-hidden-accessible custom-select" id="como_se_entero" name="como_se_entero" style="width: 95%;">
                    <option value="">
                        Como se entero
                    </option>
                    <option value="3">
                        Búsqueda WEb
                    </option>
                    <option value="4">
                        Flyer promocional
                    </option>
                    <option value="5">
                        Recomendación
                    </option>
                    <option value="6">
                        Otros
                    </option>
                    <option value="7">
                        Llamada telemarketing
                    </option>
                    <option value="8">
                        Venta directa
                    </option>
                    <option value="10">
                        Gopacific
                    </option>
                    <option value="11">
                        Transporte publico
                    </option>
                    <option value="12">
                        IMSS-CLM
                    </option>
                    <option value="13">
                        Redes Sociales
                    </option>
                </select>
                <br/>
                <span class="text-danger error-como_se_entero errors">
                </span>
            </div>
        </div>
    </div>
</div>