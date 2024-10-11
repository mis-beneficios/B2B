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
                    estatus_tarjeta
                </th>
                <th>
                    fecha
                </th>
                <th>
                    inportado
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
                    {{ $d->es }}
                </td>
                <td>
                    {{ $d->referencia_local }}
                </td>
                <td>
                    {{ strtoupper(str_replace(',', ' ', $d->usuario)) }}
                </td>
                <td>
                    {{ strtoupper($d->name) }}
                </td>
                <td>
                    {{ $d->tarjeta }}
                </td>
                <td>
                    {{ number_format($d->cantidad, 2,'.','') }}
                </td>
                <td>
                    {{ $d->title }}
                </td>
                <td>
                    {{ $d->clave }}
                </td>
                <td>
                    {{ $d->estatus }}
                </td>
                <td>
                    {{ $d->fecha_de_cobro }}
                </td>
                <td>
                    {{ $d->importado }}
                </td>
                <td>
                    {{ $d->id }}
                </td>
                <td>
                    {{ $d->tipo_cuenta }}
                </td>
                
            </tr>
            @endforeach
        </tbody>
    </table>
</div>