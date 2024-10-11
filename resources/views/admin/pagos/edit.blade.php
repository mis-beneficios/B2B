<div class="container">
    <div class="row">
        <div class="col-md-12">
            <form class="mt-3 mb-4" id="form_editar_segmento" action="{{ route('pagos.update', $pago->id) }}" method="PUT" data-pago_id="{{ $pago->id }}" data-pago_id="{{ $pago->estatus }}" data-contrato_id="{{ $pago->contrato->id }}">
                <div class="row">
                    <div class="col-md-12">
                        <dl class="row">
                            <dt class="col-sm-5">
                                No. Contrato:
                            </dt>
                            <dd class="col-sm-7">
                                <a href="{{ route('users.show', $pago->contrato->cliente->id) }}">
                                    {{ $pago->contrato->id }}
                                </a>
                            </dd>
                            {{--
                            <dt class="col-sm-5">
                                Cliente:
                            </dt>
                            <dd class="col-sm-7">
                                {{ $pago->contrato->cliente->fullName }}
                            </dd>
                            --}}

                            <dt class="col-sm-5 text-truncate">
                                ID Pago:
                            </dt>
                            <dd class="col-sm-7">
                                {{ $pago->id }}
                            </dd>
                            <dt class="col-sm-5 text-truncate">
                                Segmento:
                            </dt>
                            <dd class="col-sm-7">
                                # {{ $pago->segmento }}
                             {{--    <input class="form-control" name="segmento" type="text" value="{{ $pago->segmento }}"/>
                                <span class="text-danger error-segmento errors">
                                </span> --}}
                            </dd>
                            <dt class="col-sm-5 text-truncate">
                                Cantidad:
                            </dt>
                            <dd class="col-sm-7">
                                <input class="form-control" name="cantidad" type="text" value="{{ number_format($pago->cantidad, 2, '.','') }}"/>
                                <span class="text-danger error-cantidad errors">
                                </span>
                            </dd>
                            <dt class="col-sm-6 text-truncate">
                                Fecha de cobro:
                            </dt>
                            <dd class="col-sm-6">
                                {{-- data-provide="datepicker" data-date-format="yyyy-mm-dd" --}}
                                <input class="form-control datepicker" name="fecha_de_cobro" id="fecha_de_cobro_" type="text" value="{{ $pago->fecha_de_cobro }}"/>
                            </dd>
                            <dt class="col-sm-6 text-truncate">
                                Fecha de cobro efectivo:
                            </dt>
                            <dd class="col-sm-6">
                                <input class="form-control datepicker" name="fecha_de_pago" id="fecha_de_pago_" type="text" value="{{ date('Y-m-d') }}"/>
                            </dd>
                            <dt class="col-sm-5">
                                Estatus del cobro:
                            </dt>
                            <dd class="col-sm-7">
                                <select class="form-control" id="estatus_pago" name="estatus_pago">
                                    @foreach ($estatus_pagos as $estatus => $val)
                                    <option value="{{ $estatus }}" {{ ($pago->estatus == $estatus) ? 'selected' : '' }}>
                                        {{ $val }}
                                    </option>
                                    @endforeach
                                </select>
                            </dd>
                            <dt class="col-sm-5">
                                Concepto:
                            </dt>
                            <dd class="col-sm-7">
                                <input type="text" name="concepto" class="form-control" id="concepto" value="{{$pago->concepto}}">
                            </dd>
                        </dl>
                    </div>
                    <div class="col-md-12 pull-right">
                        <button class="btn btn-secondary btn-sm" id="btnCerrar" type="button">
                            Cerrar
                        </button>
                        <button class="btn btn-primary btn-sm" type="submit" >
                            Guardar
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<script>

    $('.datepicker').bootstrapMaterialDatePicker({
        weekStart: 0,
        time: false,
        lang: 'es',
    });


    // $('body #fecha_de_pago').datepicker({
    //     dateFormat: "yy-mm-dd",
    //     autoclose:true,
    //     language: 'es',
    //     orientation: 'bottom',
    // });
</script>
