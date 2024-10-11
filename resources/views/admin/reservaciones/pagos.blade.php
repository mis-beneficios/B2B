<div class="card-body">
    <form accept-charset="utf-8" action="{{ route('reservations.storePagos', $reservacion->id) }}" method="post" id="formPagosReservacion">
        <div class="row">
            <div class="col-lg-12 col-md-12">
                <h3>
                    Reservación #{{ $reservacion->id }}
                </h3>
            </div>
            <div class="col-lg-4 col-md-12">
                <div class="form-group">
                    <select class="form-control" id="estatus" name="estatus">
                        @foreach ($estatus_reservacion as $estatus => $val)
                            <option value="{{ $estatus }}"  @if ($estatus == $reservacion->estatus) selected @endif>
                                {{ $val }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-3 col-md-6">
                <div class="form-group">
                    <label for="ReservacionePagada">
                        Pagada
                    </label>
                    <select class="form-control" id="ReservacionePagada" name="pagada">
                        <option value="0" {{ ($reservacion->pagada == 0 ) ? 'selected' : '' }}>
                            NO
                        </option>
                        <option value="1" {{ ($reservacion->pagada == 1 ) ? 'selected' : '' }}>
                            SI
                        </option>
                    </select>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="form-group">
                    <label for="ReservacioneAdminFechaParaLiquidar">
                        Fecha limite
                    </label>
                    <input class="form-control datepicker" id="ReservacioneAdminFechaParaLiquidar" name="admin_fecha_para_liquidar" autocomplete="off" type="text" value="{{ ($reservacion->admin_fecha_para_liquidar) ? $reservacion->admin_fecha_para_liquidar : '' }}"/>

                    <span class="text-danger error-admin_fecha_para_liquidar errors">
                    </span>
                </div>
            </div>
            <div class="col-lg-5 col-md-12">
                <div class="form-group">
                    <label for="tipo_reserva">
                        Tipo de reservación:
                    </label>
                    <select class="form-control" id="tipo_reserva" name="tipo_reserva">
                        <option >Seleccione una opción</option>
                        @foreach ($tipo_reservacion as $tipo => $val)
                            <option value="{{ $tipo }}"  @if ($tipo == $reservacion->tipo) selected @endif>
                                {{ $val }}
                            </option>
                        @endforeach
                    </select>
                    <span class="text-danger error-tipo_reserva errors">
                    </span>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="form-group">
                    <label for="ReservacioneCantidadPago">
                        Monto
                    </label>
                    <input class="form-control" id="ReservacioneCantidadPago" min="0" name="cantidad_pago" type="text" value="{{ number_format($reservacion->cantidad_pago, 2, '.','') }}">
                        <span class="nota">
                            Pago real al hotel
                        </span>
                    </input>
                    <br>
                    <span class="text-danger error-cantidad_pago errors">
                    </span>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="form-group mt-4 pt-3">
                    <label>
                        Saldo:
                    </label>
                    <strong>
                        {!! ($reservacion['cantidad_pago']-$reservacion['cantidad_pago_1']-$reservacion['cantidad_pago_2']-$reservacion['cantidad_pago_3']) !!}
                    </strong>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-4 col-md-6">
                <div class="form-group">
                    <label for="ReservacioneCantidadPago1">
                        Pago 1
                    </label>
                    <input class="form-control" id="ReservacioneCantidadPago1" min="0" name="cantidad_pago_1" step="any" type="text"value="{{ number_format($reservacion['cantidad_pago_1'], 2, '.','') }}">
                        {{-- <span class="nota">
                            Pago real al hotel
                        </span> --}}
                    </input>
                    {{-- <br> --}}
                     <span class="text-danger error-cantidad_pago_1 errors">
                    </span>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="form-group">
                    <label for="ReservacioneFechaDePago1">
                        Fecha de pago 1
                    </label>
                    <input class="form-control datepicker" autocomplete="off" id="ReservacioneFechaDePago1" name="fecha_de_pago_1" type="text" value="{{ $reservacion['fecha_de_pago_1'] }}">
                        <small class="nota">
                            Cuando se pagó
                        </small>
                    </input>
                    <br>
                    <span class="text-danger error-fecha_de_pago_1 errors">
                    </span>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-4 col-md-6">
                <div class="form-group">
                    <label for="ReservacioneCantidadPago2">
                        Pago 2
                    </label>
                    <input class="form-control" id="ReservacioneCantidadPago2" min="0" name="cantidad_pago_2" step="any" type="text" value="{{ number_format($reservacion['cantidad_pago_2'], 2, '.','') }}">
                        {{-- <span class="nota">
                            Pago real al hotel
                        </span> --}}
                    </input>
                     <span class="text-danger error-cantidad_pago_2 errors">
                    </span>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="form-group">
                    <label for="ReservacioneFechaDePago2">
                        Fecha de pago 2
                    </label>
                    <input class="form-control datepicker" autocomplete="off" id="ReservacioneFechaDePago2" name="fecha_de_pago_2" type="text" value="{{ $reservacion['fecha_de_pago_2'] }}">
                        <small class="nota">
                            Cuando se pagó
                        </small>
                    </input>
                    <br>
                    <span class="text-danger error-fecha_de_pago_2 errors">
                    </span>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-4 col-md-6">
                <div class="form-group">
                    <label for="ReservacioneCantidadPago3">
                        Pago 3
                    </label>
                    <input class="form-control" id="ReservacioneCantidadPago3" min="0" name="cantidad_pago_3" step="any" type="text" value="{{ number_format($reservacion['cantidad_pago_3'], 2, '.','') }}">
                        {{-- <span class="nota">
                            Pago real al hotel
                        </span> --}}
                    </input>
                     <span class="text-danger error-cantidad_pago_3 errors">
                    </span>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="form-group">
                    <label for="ReservacioneFechaDePago3">
                        Fecha de pago 3
                    </label>
                    <input class="form-control datepicker" autocomplete="off" id="ReservacioneFechaDePago3" name="fecha_de_pago_3" type="text" value="{{ $reservacion['fecha_de_pago_3'] }}">
                        <small class="nota">
                            Cuando se pagó
                        </small>
                    </input>7
                    <br>
                    <span class="text-danger error-fecha_de_pago_3 errors">
                    </span>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-4 col-md-6">
                <div class="form-group">
                    <label for="ReservacioneGarantizada">
                        Garantizada
                    </label>
                     <select class="form-control" id="garantizada" name="garantizada">
                        @foreach ($garantia_reservacion as $tipo => $val)
                            <option value="{{ $tipo }}"  @if ($tipo == $reservacion->garantizada) selected @endif>
                                {{ $val }}
                            </option>
                        @endforeach
                    </select>

                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="form-group">
                    <label for="ReservacioneGarantia">
                        Garantía
                    </label>
                    <select class="form-control" id="garantia" name="garantia">
                        @foreach ($tipo_garantia as $tipo => $val)
                            <option value="{{ $tipo }}"  @if ($tipo == $reservacion->garantia) selected @endif>
                                {{ $val }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label for="ReservacioneNotas">
                        Notas
                    </label>
                    <textarea class="form-control" cols="30" id="ReservacioneNotas" name="comentario" rows="7"></textarea>
                </div>
            </div>
        </div>
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
<script>
    var reservacion = @json($reservacion);

    $('.datepicker').bootstrapMaterialDatePicker({
        weekStart: 0,
        time: false,
        lang: 'es',
    });

    // $('.datepicker').daterangepicker({
    //     singleDatePicker: true,
    //     autoUpdateInput: false,
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

    // $('.datepicker').daterangepicker({
    //     singleDatePicker: true,
    //     showDropdowns: true,
    //     locale: {
    //       format: 'YYYY-MM-DD'
    //     }
    // });
    // $("#estatus option").each(function(){
    //     if ($(this).val() == reservacion.estatus){
    //         $(this).attr('selected', 'true');
    //     }
    // });
    // $("#ReservacionePagada option").each(function(){
    //     if ($(this).val() == reservacion.pagada){
    //         $(this).attr('selected', 'true');
    //     }
    // });
    // $("#ReservacioneTipo option").each(function(){
    //     if ($(this).val() == reservacion.tipo){
    //         $(this).attr('selected', 'true');
    //     }
    // });
    // $("#ReservacioneGarantizada option").each(function(){
    //     if ($(this).val() == reservacion.garantizada){
    //         $(this).attr('selected', 'true');
    //     }
    // });
    // $("#ReservacioneGarantia option").each(function(){
    //     if ($(this).val() == reservacion.garantia){
    //         $(this).attr('selected', 'true');
    //     }
    // });
</script>
