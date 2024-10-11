<table class="table table-hover">
    <thead>
        <tr>
            <th>
                contrato_id
            </th>
            <th>
                pago_id
            </th>
            <th>
                segmento_archivo
            </th>
            <th>
                cliente
            </th>
            <th>
                importe_cobrado_santander
            </th>
            <th>
                clave_archivo_santander
            </th>
            <th>
                cobrado_en_archivo
            </th>
            <th>
                resultado
            </th>
        </tr>
    </thead>
    <tbody>
        @if (count($datos) != 0)
            @foreach ($datos as $d)
        <tr>
            <td>
                {{ $d->contrato_id }}
            </td>
            <td>
                {{ $d->pago_id }}
            </td>
            <td>
                {{ $d->segmento_archivo }}
            </td>
            <td>
                {{ $d->cliente }}
            </td>
            <th>
                {{ $d->importe_cobrado_santander }}
            </th>
            <th>
                {{ $d->clave_archivo_santander }}
            </th>
            <th>
                {{ $d->cobrado_en_archivo }}
            </th>
            <th>
                {{ $d->resultado }}
            </th>
        </tr>
        @endforeach
        @else
        <p>
            Sin registros
        </p>
        @endif
    </tbody>
</table>
