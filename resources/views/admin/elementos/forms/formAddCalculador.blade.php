<form action="" id="add_pagos_contrato">
    @csrf
    <input id="contrato_id" name="contrato_id" type="hidden" value="{{ isset($con) ? $con->id : '' }}" />
    <input id="modified_pay" name="modified_pay" type="hidden" value="nuevo" />
    <div class="modal-body">
        <div class="row">
            <div class="col-lg-12 col-md-12">
                <div class="form-row">
                    <div class="form-group col-lg-4 col-md-12">
                        <label for="metodo_pago">
                            Metodo de pago
                        </label>
                        <select class="form-control" id="metodo_pago" name="metodo_pago">
                            <option value="">
                                Selecciona una opción
                            </option>
                            @php
                                $tipo_pago = [
                                    'semanal' => 'SEMANAL: Un día por semana',
                                    'catorcenal' => 'CATORCENAL: Un día por semana intercalada',
                                    'quincenal_preciso' => 'QUINCENAL PRECISO',
                                    'quincenal_clasico' => ' QUINCENAL CLÁSICO: Cada siguiente dia 15 o último del mes',
                                    'mensual' => '   MENSUAL: Cada cierto día del mes',
                                ];
                            @endphp
                            @foreach ($tipo_pago as $tipo => $key)
                                <option value="{{ $tipo }}" @if ($con->tipo_pago == $tipo) selected @endif>
                                    {{ $key }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group col-lg-3 col-md-6">
                        <label for="fecha_primer_descuento_">
                            Fecha del siguiente cobro
                        </label>
                        <input autocomplete="off" class="form-control fecha_primer_descuento datepicker"
                            name="fecha_primer_descuento" type="text" value="{{ $data_pagos['fecha_inicial'] }}" />
                    </div>


                    <div class="form-group col-lg-3 col-md-6">
                        <label for="inputPassword4">
                            Segmentos
                            <span id="rangeval">
                                {{ $data_pagos['total_segmentos'] != 0 ? $data_pagos['num_segmentos_pendientes'] : $con->estancia->cuotas }}
                                {{-- {{ ($data_pagos['total_pendientes'] != 0) ?  $con->estancia->cuotas : $data_pagos['num_segmentos_pendientes'] }} --}}
                                {{-- {{ isset($num_segmentos_pendientes) ? $pagos_pendientes :  $con->estancia->cuotas }} --}}
                            </span>
                        </label>
                        {{-- <input class="form-control-range mt-2" id="num_segmentos" max="100" min="1" name="num_segmentos" oninput="$('#rangeval').html($(this).val())" type="range" value="{{ isset($pagos_pendientes) ? $pagos_pendientes :  $con->estancia->cuotas }}"/> --}}
                        <input class="form-control-range mt-2" id="num_segmentos" max="100" min="1"
                            name="num_segmentos" oninput="$('#rangeval').html($(this).val())" type="range"
                            value="{{ $data_pagos['total_segmentos'] != 0 ? $data_pagos['num_segmentos_pendientes'] : $con->estancia->cuotas }}" />


                        {{-- 
                        Bueno
                        <input class="form-control-range mt-2" id="num_segmentos" max="100" min="1" name="num_segmentos" oninput="$('#rangeval').html($(this).val())" type="range" value="{{ ($data_pagos['total_pendientes'] != 0) ?  $data_pagos['num_segmentos_pendientes'] : $data_pagos['num_segmentos_pendientes'] }}"/> --}}

                        <input type="hidden" value="{{ $data_pagos['num_segmentos_rechazados'] }}" name="rechazados">
                        <input type="hidden" value="{{ $data_pagos['total_pendientes'] }}" name="pendientes">
                        <input type="hidden" value="{{ $data_pagos['num_segmentos_pagados'] }}" name="pagados">
                        <input type="hidden" value="{{ $data_pagos['num_segmentos_pendientes'] }}"
                            name="pagos_pendientes">

                    </div>
                    <div class="form-group col-lg-2 col-md-6 justify-content-center align-content-between">
                        <div class="btn-group" data-toggle="buttons">
                            <label class="btn btn-info btn-sm mt-4 @if ($con->aplica_descuento == 1) active @endif">
                                <input type="checkbox" id="descuento" value="{{ $con->estancia->descuento }}"
                                    data-descuento="{{ $con->estancia->descuento }}" name="descuento"
                                    @if ($con->aplica_descuento == 1) checked @endif>
                                Aplicar descuento
                                </input>
                            </label>
                        </div>

                    </div>
                    <div class="col-md-12" id="fechas_xy" style="display: none">
                        <div class="row">
                            <div class="form-group col-lg-4 col-md-4">
                                <label for="inputPassword4">
                                    Dia x del mes
                                </label>

                                <select class="form-control" id="dia_x" name="dia_x">
                                    @for ($i = 1; $i <= 31; $i++)
                                        <option value="{{ $i }}">
                                            {{ $i }}
                                        </option>
                                    @endfor
                                </select>
                                <span class="text-danger error-numero_tarjeta errors">
                                </span>
                            </div>
                            <div class="form-group col-lg-4 col-md-4">
                                <label for="inputPassword4">
                                    Dia y del mes
                                </label>
                                <select class="form-control" id="dia_y" name="dia_y">
                                    @for ($i = 1; $i <= 31; $i++)
                                        <option value="{{ $i }}">
                                            {{ $i }}
                                        </option>
                                    @endfor
                                </select>
                                <span class="text-danger error-numero_tarjeta errors">
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 mr-0">
                        <div class="row">
                            <div class="col-md-3">
                                <button class="btn btn-info btn-sm" id="btnCalcularPagos" type="button">
                                    <i class="fas fa-calculator">
                                    </i>
                                    Calcular
                                </button>
                            </div>
                            <div class="col-md-3">
                                Precio: <strong id="precio_compra" class="text-danger">
                                    ${{ number_format($con->precio_de_compra, 2, '.', '') }}</strong>
                            </div>
                            <div class="col-md-3">
                                Pagado: <strong id="pagado"
                                    class="text-danger">${{ number_format($data_pagos['cantidad_pagada'], 2, '.', '') }}</strong>
                            </div>
                            <div class="col-md-3">
                                Pendiente: <strong id="prendiente_pago"
                                    class="text-danger">${{ number_format($data_pagos['cantidad_pendiente'], 2, '.', '') }}</strong>
                            </div>
                        </div>

                    </div>
                    <div class="col-md-12 table-responsive mt-3" id="listarPagos" style="height: 300px;">
                        <table class="table table-hover" id="tablePagos">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Segmento</th>
                                    <th>Fecha</th>
                                    <th>Cantidad</th>
                                </tr>
                            </thead>
                            <tbody id="tableBody">
                            </tbody>
                            {{-- <tfoot>
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td>
                                        Total: <strong id="total" class="text-danger"></strong>
                                    </td>
                                </tr>
                            </tfoot> --}}
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button class="btn btn-secondary btn-sm" data-dismiss="modal" type="button">
            Cerrar
        </button>
        <button class="btn btn-primary btn-sm" type="submit">
            Generar
        </button>
    </div>
</form>

<script>
    $('.datepicker').bootstrapMaterialDatePicker({
        weekStart: 0,
        time: false,
        lang: 'es',
        maxDate: moment().add(65, 'days')
    });

    var est = @json($con->estancia);
    var data = @json($data);
    $('#metodo_pago').change(function(event) {
        event.preventDefault();
        $val = $(this).val();
        if ($val == 'semanal') {
            $('#num_segmentos').val(est['cuotas']);
        } else if ($val == 'mensual') {
            $('#num_segmentos').val(12);
        } else if (est['est_especial'] || est['estancia_especial'] == 1) {
            $('#num_segmentos').val(est['cuotas']);

        } else {
            $('#num_segmentos').val(est['cuotas']);
        }

    })

    // $('#fecha_primer_descuento').datepicker({
    //     dateFormat: "yy-mm-dd",
    //     startDate: '-1d',
    //     endDate: '+2m',
    //     autoclose:true,
    //     language: 'es'
    // });

    // function pintar_pagos_data(aaData) {
    // if (data != false) {       
    $.each(data, function(i, v) {
        i++;
        if (v[6] != 'Pagado') {
            $('body #add_pagos_contrato #tablePagos #tableBody').append('<tr><td>' + i + '</td><td>' + v[1] +
                '<input type="hidden" name="segmento[]" value="' + v[1] +
                '"/><input type="hidden" name="pago_id[]" value="' + v[8] + '"/></td><td>' + v[4] +
                '<br/>' + moment(v[4]).format('LL') +
                '<input type="hidden" name="fecha_de_cobro[]" value="' + v[4] + '"/></td><td>$ ' + v[3] +
                '<input type="hidden" name="cantidad[]" value="' + v[3] +
                '"/> <input type="hidden" name="concepto[]" value="' + v.concepto + '"/></td></tr>');
        }

    });
    // }
    // }
</script>
{{-- 
@section('script')
<script>
    
    $('#fecha_primer_descuento').datepicker({
        dateFormat: "yy-mm-dd",
        startDate: '-1d',
        endDate: '+2m',
        autoclose:true,
        language: 'es'
    });
</script>
@endsection
 --}}
