<div class="table-responsive mt-3">
    <table class="table table-hover dataTable" id="tabla_ventas" role="grid" style="width:100%">
        <thead>
            <tr role="row">
                <th aria-sort="ascending" class="sorting_asc">
                    estatus
                </th>
                <th aria-controls="" aria-label="" class="sorting" colspan="1" rowspan="1" tabindex="0">
                    opt
                </th>
                <th aria-controls="" aria-label="" class="sorting" colspan="1" rowspan="1" tabindex="0">
                    cliente
                </th>
                <th aria-controls="" aria-label="" class="sorting" colspan="1" rowspan="1" tabindex="0">
                    tarjetahabiente
                </th>
                <th aria-controls="" aria-label="" class="sorting" colspan="1" rowspan="1" tabindex="0">
                    tarjeta
                </th>
                <th aria-controls="" aria-label="" class="sorting" colspan="1" rowspan="1" tabindex="0">
                    monto
                </th>
                <th aria-controls="" aria-label="" class="sorting" colspan="1" rowspan="1" tabindex="0">
                    banco
                </th>
                <th aria-controls="" aria-label="" class="sorting" colspan="1" rowspan="1" tabindex="0">
                    clave
                </th>
                <th aria-controls="" aria-label="" class="sorting" colspan="1" rowspan="1" tabindex="0">
                    ultima fecha de cobro
                </th>
                <th aria-controls="" aria-label="" class="sorting" colspan="1" rowspan="1" tabindex="0">
                    pago_id
                </th>
                <th aria-controls="" aria-label="" class="sorting" colspan="1" rowspan="1" tabindex="0">
                    tipo_cuenta
                </th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $d)
            <tr>
                <td>
                    {{ $d->estatus }}
                </td>
                <td>
                    {{ $d->sys_key }}
                </td>
                <td>
                    {{ str_replace(',', ' ', $d->nombre_completo) }}
                </td>
                <td>
                    {{ str_replace(',', ' ', $d->nombre_completo) }}
                </td>
                <td>
                    {{ strval($d->tarjeta) }}
                </td>
                <td>
                    {{ strval(number_format($d->monto, 2,'.','')) }}
                </td>
                <td>
                    {{ strval($d->title) }}
                </td>
                <td>
                    {{ strval($d->clave) }}
                </td>
                <td>
                    {{ strval($d->ult_fecha_de_pago) }}
                </td>
                <td>
                    {{ strval($d->pago_id) }}
                </td>
                <td>
                    {{ strval($d->tipo_cuenta) }}
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>