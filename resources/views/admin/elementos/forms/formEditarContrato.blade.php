<form action="{{ route('contratos.update', $contrato->id) }}" id="form_editar_contrato" method="put">
    <input id="contrato_id" name="contrato_id" type="hidden" value="" />
    <div class="modal-body">
        <div class="row">
            <div class="col-md">
                <h4>
                    Folio: {{ $contrato->id }}
                </h4>
            </div>
            <div class="col-lg-12 col-md-12">
                <div class="form-row">
                    <div class="form-group col-lg-8 col-md-6">
                        <label for="metodo_pago">
                            Tarjeta
                        </label>
                        <select class="form-control" id="tarjeta_id" name="tarjeta_id">
                            <option value="">Selecciona una opción</option>
                            @foreach ($tarjetas as $tarjeta)
                                <option @if ($tarjeta->id == $contrato->tarjeta_id) selected="" @endif
                                    value="{{ $tarjeta->id }}">
                                    {{ $tarjeta->numeroTarjeta }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-lg-12 col-md-12">
                        <label for="paquete">
                            Nombre del paquete
                        </label>
                        <input class="form-control" id="paquete" name="paquete" type="text"
                            value="{{ $contrato->paquete }}" />
                    </div>
                    <div class="form-group col-lg-4 col-md-6">
                        <label for="sys_key">
                            Clave VIA Serfin*
                        </label>
                        <input class="form-control" id="sys_key" name="sys_key" readonly=""
                            value="{{ $contrato->sys_key }}" />
                    </div>
                    <div class="form-group precio_de_compra col-lg-4 col-md-6">
                        <label for="precio_de_compra">
                            Precio de compra
                        </label>
                        <input class="form-control" id="precio_de_compra" name="precio_de_compra"
                            value="{{ number_format($contrato->precio_de_compra, 2, '.', '') }}" />
                    </div>
                    <div class="form-group col-lg-4 col-md-6">
                        <label for="divisa">
                            Divisa
                        </label>
                        <select name="divisa" id="divisa" class="form-control">
                            @php
                                $divisas = [
                                    'MXN' => 'MXN',
                                    'USD' => 'USD',
                                ];
                            @endphp
                            @foreach ($divisas as $divisa => $key)
                                <option value="{{ $divisa }}" {{ $key == $contrato->divisa ? 'selected' : '' }}>
                                    {{ $key }}
                                </option>
                            @endforeach
                        </select>
                        {{-- <input class="form-control" id="divisa" name="divisa" value="{{ number_format($contrato->precio_de_compra,2,'.','') }}"/> --}}
                    </div>
                    <div class="form-group col-lg-3 col-md-6">
                        <label for="adultos">
                            Adultos
                        </label>
                        <input class="form-control" id="adultos" name="adultos" value="{{ $contrato->adultos }}" />
                    </div>
                    <div class="form-group col-lg-3 col-md-6">
                        <label for="ninos">
                            Niños
                        </label>
                        <input class="form-control" id="ninos" name="ninos" value="{{ $contrato->ninos }}" />
                    </div>
                    <div class="form-group col-lg-5 col-md-6">
                        <label for="edad_max_ninos">
                            Edad max. de niños
                        </label>
                        <input class="form-control" id="edad_max_ninos" name="edad_max_ninos"
                            value="{{ $contrato->edad_max_ninos }}" />
                    </div>
                    <div class="form-group col-lg-4 col-md-6 mt-4">
                        <div class="form-check">
                            <input class="form-check-input" id="pago_con_nomina" name="pago_nomina" type="checkbox"
                                value="1">
                            <label class="form-check-label" for="pago_con_nomina">
                                Pago por nomina
                            </label>
                            </input>
                        </div>
                    </div>
                    @if (Auth::user()->role == 'admin')
                        <div class="form-group col-lg-6 col-md-6 mt-4">
                            <label for="estatus">
                                Tipo de llamada
                            </label>
                            <select class="form-control" id="tipo_llamada" name="tipo_llamada" required="required"
                                value="{{ $contrato->tipo_llamada }}">
                                <option value="">
                                    Selecciona una opción
                                </option>
                                <option value="en">Entrada</option>
                                <option value="sa">Salida</option>
                                <option value="VD">Venta directa</option>
                                <option value="WB">Web</option>
                            </select>
                        </div>
                    @endif
                    <div class="form-group col-lg-12 col-md-6">
                        <label for="estatus">
                            Estatus
                        </label>
                        <select class="form-control" id="estatus" name="estatus" required="required"
                            value="{{ $contrato->estatus }}">
                            <option value="">
                                Selecciona una opción
                            </option>
                            <optgroup label="Activo">
                                <option value="comprado">
                                    Comprado
                                </option>
                                <option value="viajado">
                                    Viajado
                                </option>
                                <option value="pagado">
                                    Pagado
                                </option>
                            </optgroup>
                            <optgroup label="Inactivos">
                                <option value="por_cancelar">
                                    Por cancelar
                                </option>
                                <option value="suspendido">
                                    Suspendido
                                </option>
                                <option value="cancelado">
                                    Cancelado
                                </option>
                                <option value="Tarjeta con problemas">
                                    Tarjeta con problemas
                                </option>
                            </optgroup>
                            <optgroup label="No verificados">
                                <option value="nuevo">
                                    Nuevo (Sin aceptación de compra)
                                </option>
                                <option value="por_autorizar">
                                    Sin autorizar
                                </option>
                                <option value="sin_aprobar">
                                    Venta sin aprobar
                                </option>
                            </optgroup>
                        </select>
                    </div>
                    <div class="form-group col-12" id="div_motivo_suspencion" style="display: none;">
                        <label for="motivo_cancelacion" id="label_motivo_suspencion">
                            Motivo de cancelación
                        </label>
                        <select class="form-control" id="motivo_cancelacion" name="motivo_cancelacion">
                            <option value="">
                                Selecciona una opción
                            </option>
                            <option value="Penalización"
                                {{ $contrato->motivo_estatus == 'Penalización' ? 'selected' : '' }}>
                                Penalización
                            </option>
                            <option value="Cancelacion por parte del cliente"
                                {{ $contrato->motivo_estatus == 'Cancelacion por parte del cliente' ? 'selected' : '' }}>
                                Cancelacion por parte del cliente
                            </option>
                        </select>
                        {{--
                        <textarea class="form-control" id="motivo_cancelacion" name="motivo_cancelacion" placeholder="Motivo de cancelación" rows="8">
                        </textarea>
                        --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button class="btn btn-secondary btn-sm" data-dismiss="modal" type="button">
            {{ __('messages.cerrar') }}
        </button>
        <button class="btn btn-primary btn-sm" type="submit">
            {{ __('messages.guardar') }}
        </button>
    </div>
</form>
<script>
    var estatus = '{{ $contrato->estatus }}';

    $('#divisa').change(function(e) {
        e.preventDefault();
        toastr['warning']('¡Comprobar el precio de compra y segmentos generados!');
    });

    $("#estatus option").each(function() {
        if ($(this).val() == "{{ $contrato->estatus }}") {
            $(this).attr('selected', 'true');
        }
    });

    $("#tipo_llamada option").each(function() {
        if ($(this).val() == "{{ $contrato->tipo_llamada }}") {
            $(this).attr('selected', 'true');
        }
    });

    $("#motivo_cancelacion option").each(function() {
        if ($(this).val() == "{{ $contrato->motivo_estatus }}") {
            $(this).attr('selected', 'true');
        }
    });

    if (estatus == 'cancelado') {
        $("#div_motivo_suspencion").css("display", "block");

    } else {
        $("#div_motivo_suspencion").css("display", "none");
    }

    $('#estatus').change(function(event) {
        event.preventDefault();
        if ($(this).val() == 'cancelado' || estatus == 'cancelado') {
            $("#div_motivo_suspencion").css("display", "block");
        } else {
            $("#div_motivo_suspencion").css("display", "none");
        }
    });
</script>
