<form action="{{ $url }}" id="formConcal" method="{{ $method }}">
    <input id="create_convenio" name="create_convenio" type="hidden" value="0"/>
    <div class="modal-body" id="modal-body">
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="inputPassword4">
                    Empresa
                </label>
                <input class="form-control" id="empresa" name="empresa" placeholder="Nombre de la empresa" type="text">
                </input>
                <span class="text-danger error-empresa errors">
                </span>
            </div>
            <div class="form-group col-md-6">
                <label for="inputEmail4">
                    Pagina web
                </label>
                <input class="form-control" id="pagina_web" name="pagina_web" placeholder="Sitio web" type="text">
                </input>
                <span class="text-danger error-pagina_web errors">
                </span>
            </div>
            <div class="form-group col-md-8">
                <label for="inputEmail4">
                    Giro
                </label>
                <input type="text" name="giro", id="giro" class="form-control">
                <span class="text-danger error-giro errors">
                </span>
            </div>
            <div class="form-group col-md-4">
                <label for="inputEmail4">
                    Categoría
                </label>
              <select name="categoria" id="categoria" class="form-control">
                  <option value="A">A < 100 empleados</option>
                  <option value="AA">AA 100 - 1000 empleados</option>
                  <option value="AAA">AAA > 1000 empleados</option>
              </select>
                <span class="text-danger error-categoria errors">
                </span>
            </div>
            <div class="form-group col-md-4">
                <label for="inputEmail4">
                    No. de empleados
                </label>
                <input class="form-control" id="no_empleados" name="no_empleados" placeholder="# Empleados" type="text">
                </input>
                <span class="text-danger error-no_empleados errors">
                </span>
            </div>
            <div class="form-group col-md-4">
                <label for="inputEmail4">
                    Estado (CEDE)
                </label>
                <input class="form-control" id="estado" name="estado" placeholder="Estado" type="text">
                </input>
                <span class="text-danger error-estado errors">
                </span>
            </div>
            <div class="form-group col-md-4">
                <label for="inputEmail4">
                    Pais
                </label>
                <select class="form-control" id="paise_id" name="paise_id">
                    @foreach ($paises as $pais)
                    <option value="{{ $pais->id }}">
                        {{ $pais->title }}
                    </option>
                    @endforeach
                </select>
                <span class="text-danger error-paise_id errors">
                </span>
            </div>
             <div class="form-group col-md-3">
                <label for="inputEmail4">
                    Sucursales
                </label>
                <select class="form-control" id="sucursales" name="sucursales">
                    <option value="0">NO</option>
                    <option value="1">SI</option>
                </select>
                <span class="text-danger error-sucursales errors">
                </span>
            </div> 
            <div class="form-group col-md-12">
                <textarea name="sucursal_lugar" id="sucursal_lugar"  class="form-control" rows="10" style="display:none"></textarea>
                <span class="text-danger error-sucursal_lugar errors">
                </span>
            </div>
            <div class="form-group col-md-3">
                <label for="inputEmail4">
                    Corporativo
                </label>
                <select class="form-control" id="corporativo" name="corporativo">
                    <option value="0">NO</option>
                    <option value="1">SI</option>
                </select>
                <span class="text-danger error-corporativo errors">
                </span>
            </div>
            <div class="form-group col-md-3">
                <label for="inputEmail4">
                    Uso de logotipo
                </label>
                <select class="form-control" id="autoriza_logo" name="autoriza_logo">
                    <option value="0">NO</option>
                    <option value="1">SI</option>
                </select>
                <span class="text-danger error-autoriza_logo errors">
                </span>
            </div>
            <div class="col-md-3">
                <label for="">
                    Redes sociales
                </label>
                <select name="redes" id="redes" class="form-control">
                    <option value="1">NO</option>
                    <option value="2">SI</option>
                </select>
            </div>
            <div class="form-group col-md-3">
                <label for="inputEmail4">
                    Método de pago
                </label>
                <select class="form-control" id="metodo_pago" name="metodo_pago">
                    <option value="Banca">Banca</option>
                    <option value="Nomina">Nomina</option>
                </select>
                <span class="text-danger error-metodo_pago errors">
                </span>
            </div>
            <div class="form-group col-md-12">
                <label for="inputEmail4">
                    Estrategia de venta
                </label>
                <input type="text" name="estrategia" id="estrategia" class="form-control">
                <span class="text-danger error-estrategia errors">
                </span>
            </div>
            {{--<div class="form-group col-md-8">
                <label for="inputEmail4">
                    Link de pagina de beneficios
                </label>
                <input type="text" name="link_beneficios" id="link_beneficios" class="form-control">
                <span class="text-danger error-link_beneficios errors">
                </span>
            </div> --}}
        </div>
        <hr/>
        <div class="form-row">
            <div class="form-group col-md-3">
                <label for="inputPassword4">
                    Siguiente llamada
                </label>
                <input autocomplete="off" class="form-control" id="siguiente_llamada" name="siguiente_llamada" type="text">
                </input>
                <span class="text-danger error-siguiente_llamada errors">
                </span>
            </div>
            <div class="form-group col-md-3">
                <label for="inputPassword4">
                    Estatus
                </label>
                <select class="form-control " id="estatus" name="estatus">
                    @foreach ($estatus_concal as $estatus => $key)
                    <option class="" value="{{ $estatus }}">
                        {{ $key }}
                    </option>
                    @endforeach
                </select>
                <span class="text-danger error-estatus errors">
                </span>
            </div>
            <div class="form-group col-md-2">
                <label for="inputPassword4">
                    Calificación
                </label>
                <select class="js-example-responsive js-states form-control " id="calificacion" name="calificacion">
                    @for ($i = 0; $i <=10 ; $i++)
                    <option value="{{ $i }}">
                        {{ $i }}
                    </option>
                    @endfor
                </select>
                <span class="text-danger error-calificacion errors">
                </span>
            </div>

            <div class="form-group col-md-3">
                <label for="inputPassword4">
                    Conmutador
                </label>
                <input class="form-control" id="conmutador" name="conmutador" type="text">
                </input>
                <span class="text-danger error-conmutador errors">
                </span>
            </div>
        </div>
        <hr/>
        <div class="form-row">
            <div class="form-group col-md-4">
                <label for="inputPassword4">
                    Contacto
                </label>
                <input class="form-control" id="contacto" name="contacto" placeholder="Nombre del contacto" type="text">
                </input>
                <span class="text-danger error-contacto errors">
                </span>
            </div>
            <div class="form-group col-md-4">
                <label for="inputPassword4">
                    Puesto
                </label>
                <input class="form-control" id="puesto_contacto" name="puesto_contacto" placeholder="Puesto del contacto" type="text">
                </input>
                <span class="text-danger error-puesto_contacto errors">
                </span>
            </div>
            <div class="form-group col-md-4">
                <label for="inputEmail4">
                    Teléfonos
                </label>
                <input class="form-control" id="telefonos" name="telefonos" placeholder="" type="text">
                </input>
                <span class="text-danger error-telefonos errors">
                </span>
            </div>
            <div class="form-group col-md-4">
                <label for="inputEmail4">
                    Correo electrónico
                </label>
                <input class="form-control" id="email" name="email" placeholder="Correo electronico" type="text">
                </input>
                <span class="text-danger error-email errors">
                </span>
            </div>
        </div>
        <div class="row">
            <div class="form-group col-md-4">
                <label for="inputPassword4">
                    Asistente
                </label>
                <input class="form-control" id="asistente" name="asistente" placeholder="Nombre del asistente" type="text">
                </input>
                <span class="text-danger error-asistente errors">
                </span>
            </div>
            <div class="form-group col-md-4">
                <label for="inputEmail4">
                    Teléfono(s)
                </label>
                <input class="form-control" id="asistenten_telefono" name="asistenten_telefono" type="text">
                </input>
                <span class="text-danger error-asistenten_telefono errors">
                </span>
            </div>
            <div class="form-group col-md-4">
                <label for="inputEmail4">
                    Correo Electrónico
                </label>
                <input class="form-control" id="asistente_email" name="asistente_email" placeholder="" type="email">
                </input>
                <span class="text-danger error-asistente_email errors">
                </span>
            </div>
{{--             <div class="form-group col-md-12">
                <label for="inputEmail4">
                    Observaciones
                </label>
                <textarea class="form-control" id="observaciones" name="observaciones" rows="8" style="width:100%;"></textarea>
                <span class="text-danger error-asistente_email errors">
                </span>
            </div> --}}
        </div>
    </div>
    <div class="modal-footer">
        <button class="btn btn-secondary btn-sm" data-dismiss="modal" type="button">
            Cerrar
        </button>
        @if ($method == 'POST' || Auth::id() == $concal->user_id || Auth::user()->role == 'admin')
        <button class="btn btn-primary btn-sm" type="submit">
            Guardar
        </button>
        @endif
    </div>
</form>
<script>

    $('#siguiente_llamada').bootstrapMaterialDatePicker({
        weekStart: 0, 
        time: false,
        lang: 'es',
    });
</script>
@isset ($concal)
<script>
    var concal = @json($concal);
    $.each(concal, function(index, val) {
        $('#'+index).val(val);
    });

    $("#redes option").each(function(){
        if ($(this).val() == concal.redes){
            $(this).attr('selected', 'true');
        }
    });

    $("#autoriza_logo option").each(function(){
        if ($(this).val() == concal.autoriza_logo){
            $(this).attr('selected', 'true');
        }
    });

    $("#metodo_pago option").each(function(){
        if ($(this).val() == concal.metodo_pago){
            $(this).attr('selected', 'true');
        }
    });

    $("#corporativo option").each(function(){
        if ($(this).val() == concal.corporativo){
            $(this).attr('selected', 'true');
        }
    });

    $("#estatus option").each(function(){
        if ($(this).val() == concal.estatus){
            $(this).attr('selected', 'true');
        }
    });

    $("#sucursales option").each(function(){
        if ($(this).val() == concal.sucursales){
            $(this).attr('selected', 'true');
        }
    });

    $("#paise_id option").each(function(){
        if ($(this).val() == concal.paise_id){
            $(this).attr('selected', 'true');
        }
    });
    $("#sucursal_lugar").html(concal.sucursal_lugar);

    if(concal.sucursal_lugar){
        $('#sucursal_lugar').css('display', 'block');
    }

</script>
@endisset
