<div class="card-body">
    <div class="row">
         <div class="col-lg-12 col-md-12">
                <h3>
                    Reservación #{{ $reservacion->id }}
                </h3>
            </div>
        <div class="col-md-12">
            <form action="{{ route('reservations.storeAjustes', $reservacion->id) }}" class=" m-t-10" id="form_reservaciones_ajustes" method="PUT">
                @csrf
                <input id="reservacion_id" name="reservacion_id" type="hidden" value="{{ $reservacion->id }}"/>
                <div class="row">
                     <div class="form-group col-md-4">
                        <label>
                            {{ __('messages.cliente.estatus') }}:
                        </label>
                        <select class="form-control" id="estatus" name="estatus">
                            @foreach ($estatus_reservacion as $estatus => $val)
                                <option value="{{ $estatus }}"  @if ($estatus == $reservacion->estatus) selected @endif>
                                    {{ $val }}
                                </option>
                            @endforeach
                        </select>
                        <span class="text-danger error-folio errors">
                        </span>
                    </div>
                </div>
                <div class="row">
                     <div class="col-lg-5 col-md-12">
                        <div class="form-group">
                            <label>
                                Hotel:
                            </label>
                            <input class="form-control" id="hotel" name="hotel" type="text" value="{{ $reservacion->hotel }}">
                            </input>
                            <span class="text-danger error-hotel errors">
                            </span>
                        </div>
                    </div>
                    <div class="col-lg-5 col-md-12">
                        <div class="form-group">
                            <label>
                                Contacto:
                            </label>
                            <input class="form-control" id="contacto" name="contacto" type="text" value="{{ $reservacion->contacto }}">
                            </input>
                            <span class="text-danger error-contacto errors">
                            </span>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-12">
                        <div class="form-group">
                            <label>
                                Tarifa:
                            </label>
                            <input class="form-control" id="tarifa" name="tarifa" type="text" value="{{ $reservacion->tarifa }}">
                            </input>
                            <span class="text-danger error-tarifa errors">
                            </span>
                        </div>
                    </div>
                    <div class="form-group col-lg-3 col-md-6">
                        <label for="admin_fecha_para_liquidar">
                            Fecha limite:
                        </label>
                        <input class="form-control datepicker" autocomplete="off" id="admin_fecha_para_liquidar" name="admin_fecha_para_liquidar" type="text" value="{{ $reservacion->admin_fecha_para_liquidar }}">
                        </input>
                          <span class="text-danger error-admin_fecha_para_liquidar errors">
                            </span>
                    </div>

                    <div class="form-group col-lg-9 col-md-6">
                        <label for="direccion">
                            Dirección del hotel:
                        </label>
                        <input class="form-control" id="direccion" name="direccion" type="text" value="{{ $reservacion->direccion }}">
                        </input>
                          <span class="text-danger error-direccion errors">
                            </span>
                    </div>

                    <div class="form-group col-lg-3 col-md-6">
                        <label for="entrada">
                            Check-In:
                        </label>
                        <input class="form-control timepicker" autocomplete="off" id="entrada" name="entrada" type="text" value="{{ $reservacion->entrada }}">
                        </input>
                          <span class="text-danger error-entrada errors">
                            </span>
                    </div>

                    <div class="form-group col-lg-3 col-md-6">
                        <label for="salida">
                            Check-Out:
                        </label>
                       <input class="form-control timepicker" autocomplete="off" id="salida" name="salida" type="text" value="{{ $reservacion->salida }}">
                        </input>
                        <span class="text-danger error-salida errors"></span>
                    </div>


                    <div class="col-lg-6 col-md-12">
                        <div class="form-group">
                            <label>
                                Clave de cupón:
                            </label>
                            <input class="form-control" id="clave" name="clave" type="text" value="{{ $reservacion->clave }}">
                            </input>
                            <span class="text-danger error-clave errors">
                            </span>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-12">
                        <div class="form-group">
                            <label>
                                Cargo GRV:
                            </label>
                            <input class="form-control" id="cantidad" name="cantidad" type="text" value="{{ $reservacion->cantidad }}">
                            </input>
                            <span class="text-danger error-cantidad errors">
                            </span>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-12">
                        <div class="form-group">
                            <label>
                                Fecha limite:
                            </label>
                            <input class="form-control datepicker" autocomplete="off" id="fecha_limite_de_pago" name="fecha_limite_de_pago" type="text" value="{{ $reservacion->fecha_limite_de_pago }}">
                            </input>
                            <span class="text-danger error-fecha_limite_de_pago errors">
                            </span>
                        </div>
                    </div>
                    <div class="col-lg-´12 col-md-12">
                        <div class="form-group">
                            <label>
                                Cargos del copón de cobro:
                            </label>
                            <textarea name="detalle" id="detalle" class="form-control" rows="7">{{ $reservacion->detalle }}</textarea>
                            {{-- <input class="form-control" id="detalle" name="detalle" type="text" value="">
                            </input> --}}
                            <span class="text-danger error-detalle errors">
                            </span>
                        </div>
                    </div>

                    <div class="form-group col-md-12">
                        <label>
                            {{ __('messages.cliente.observaciones') }}:
                        </label>
                        <textarea class="form-control" id="comentario" name="comentario" rows="7"></textarea>
                        <span class="text-danger error-comentario errors">
                        </span>
                    </div>
                </div>
                {{-- <div class="row">
                    <div class="col-md-12">
                        <button class="btn btn-info btn-sm" type="submit">
                            {{ __('messages.guardar') }}
                        </button>
                    </div>
                </div>
 --}}
                <div class="modal-footer">
                    <button class="btn btn-secondary btn-sm" data-dismiss="modal" type="button">
                        Cerrar
                    </button>
                    <button class="btn btn-info btn-sm" type="submit">
                        Guardar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    // $('body #admin_fecha_para_liquidar').datepicker({
    //     dateFormat: "yy-mm-dd",
    //     autoclose:true,
    // });

    // MAterial Date picker    
    $('.datepicker').bootstrapMaterialDatePicker({
        weekStart: 0,
        time: false,
        lang: 'es',
    });
    
    $('#detalle').summernote({
            height: 300,
    });


    // $('.datepicker').datepicker({
    //     dateFormat: "yy-mm-dd",
    //     autoclose:true,
    //     language: 'es'
    // });
    
    // $('.datepicker').daterangepicker({
    //     singleDatePicker: true,
    //     autoUpdateInput: true,
    //     locale: {
    //         format: 'YYYY-MM-DD',
    //         separator: ' al ',
    //         applyLabel: 'Aplicar',
    //         cancelLabel: 'Cancelar',
    //         fromLabel: 'Desde',
    //         toLabel: 'Hasta',
    //         customRangeLabel: 'Personalizado',
    //         weekLabel: 'W',
    //         daysOfWeek: ['Dom', 'Lun', 'Mar', 'Mié', 'Jue', 'Vie', 'Sáb'],
    //         monthNames: [
    //             'Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'
    //         ],
    //         firstDay: 1
    //     }
    // });


    // $('input.timepicker').timepicker({});
    $('.timepicker').bootstrapMaterialDatePicker({
        format: 'HH:mm',
        time: true,
        date: false
    });

    $('.clockpicker').clockpicker();
</script>
