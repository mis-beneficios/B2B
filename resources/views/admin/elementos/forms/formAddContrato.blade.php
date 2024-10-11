<style>
    option .estancia_22{
        color: red;
    }
</style>
<form action="" id="add_contrato_user">
    <input id="user_id" name="user_id" type="hidden" value="{{ $user_id }}"/>
    <div class="modal-body">
        <div class="row modal-dialog-scrollable">
            <div class="col-lg-6 col-md-12">
                <div class="accordion" id="accordionExample">
                    @foreach ($estancias_global as $estancia)
                    <div class="card">
                        <div class="card-header btn-estancia {{ $estancia->est_especial == 1 ? 'btn-warning text-white' : '' }}" data-id="{{ $estancia->id }}" id="heading{{ $loop->iteration }}">
                            <h2 class="mb-0">
                                <button aria-controls="collapse{{ $loop->iteration }}" aria-expanded="true" class="btn btn-link btn-sm text-wrap" data-target="#collapse{{ $loop->iteration }}" data-toggle="collapse" type="button">
                                    {{ $estancia->title }}
                                </button>
                            </h2>
                        </div>
                        <div aria-labelledby="heading{{ $loop->iteration }}" class="collapse" data-parent="#accordionExample" id="collapse{{ $loop->iteration }}" style="font-size: 13px;">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-5">
                                        <label class="text-muted" for="">
                                            Precio:
                                        </label>
                                        <span>
                                            ${{ number_format($estancia->precio,2) . $estancia->divisa}}
                                        </span>
                                        <br/>
                                        <span>
                                            <strong class="text-muted">
                                                {{ $estancia->cuotas }} pagos de:
                                            </strong>
                                            ${{ number_format(($estancia->precio/$estancia->cuotas),2) . $estancia->divisa}}
                                        </span>
                                    </div>
                                    <div class="col-md-2">
                                        <label class="text-muted" for="">
                                            Noches:
                                        </label>
                                        <span>
                                            {{ $estancia->noches }}
                                        </span>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="text-muted" for="">
                                            Personas:
                                        </label>
                                        <span>
                                            {{ $estancia->adultos }} Adultos
                                            <br/>
                                            {{ $estancia->ninos }} Niños
                                        </span>
                                    </div>
                                </div>
                                <div class="mt-2">
                                    {!! $estancia->descripcion !!}
                                </div>
                                <div class="mt-2">
                                    <label class="text-muted" for="">
                                        Segmentos:
                                    </label>
                                    {{ $estancia->cuotas }}
                                </div>
                                <div>
                                    <button class="btn btn-xs btn-info" data-estancia_id="{{ $estancia->id }}" data-estancia_nombre="{{ $estancia->title }}" id="btnSelect">
                                        Seleccionar
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            <div class="col-lg-6 col-md-12">
                <div class="form-row">
                    <div class="form-group col-md-12">
                        <label for="inputEmail4">
                            Tarjeta de cobro
                        </label>
                        <select class="form-control" id="" name="tarjeta_id">
                            <option value="">
                                Selecciona una tarjeta
                            </option>
                            @foreach ($tarjetas as $tarjeta)
                            <option value="{{ $tarjeta->id }}">
                                {{ $tarjeta->numeroTarjeta }}
                            </option>
                            @endforeach
                        </select>
                        <span class="text-danger error-tarjeta_id errors">
                        </span>
                    </div>
                    <div class="form-group col-md-12">
                        <label for="inputPassword4">
                            Estancias
                        </label>
                        <select class="form-control" id="estancia_id" name="estancia_id" style="width: 100%;">
                            <option value="">
                                Selecciona una estancia
                            </option>
                            @foreach ($estancias_global as $estancia)
                            <option value="{{ $estancia->id }}">
                                <span class="{{ substr($estancia->title, -2) == '22' ? 'estancia_22' : '' }}">
                                    {{ $estancia->title }}
                                </span>
                            </option>
                            @endforeach
                        </select>
                        <span class="text-danger error-numero_tarjeta errors">
                        </span>
                    </div>
                    <div class="form-group col-md-12" id="div_num_pax">
                    </div>
                    <div class="form-group col-md-12">
                        <label for="inputPassword4">
                            Tipo de llamada
                        </label>
                        <select class="form-control" id="tipo_llamada" name="tipo_llamada">
                            <option selected="selected" value="na">
                                No aplica
                            </option>
                            <option value="en">
                                Entrada
                            </option>
                            <option value="sa">
                                Salida
                            </option>
                        </select>
                        <span class="text-danger error-numero_tarjeta errors">
                        </span>
                    </div>
                    <div class="form-group col-md-6">
                        <div class="form-check">
                            <input class="form-check-input filled-in chk-col-red" id="defaultCheck1" name="pago_nomina" type="checkbox" value="1">
                                <label class="form-check-label md_checkbox_22" for="defaultCheck1">
                                    Pago por nomina
                                </label>
                            </input>
                        </div>
                    </div>
                    <div class="form-group col-md-6">
                        <div class="form-check">
                            <input class="form-check-input filled-in chk-col-red" id="venta_contado" name="venta_contado" type="checkbox" value="1">
                                <label class="form-check-label md_checkbox_21" for="venta_contado">
                                    Venta de contado
                                </label>
                            </input>
                        </div>
                    </div>
                    <div class="form-group col-md-12">
                        <button class="btn btn-primary btn-sm" type="submit">
                            Generar y configurar
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button class="btn btn-secondary btn-sm" data-dismiss="modal" type="button">
            Cerrar
        </button>
    </div>
</form>
<script>
    // $('#estancia_id').select2({
    //     theme:"bootstrap4"
    // });
</script>
