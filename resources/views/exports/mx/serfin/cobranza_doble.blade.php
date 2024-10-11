<table class="table table-hover">
    {{--
    <thead>
        <tr>
            <th>
                estatus
            </th>
            <th>
                referencia
            </th>
            <th>
                usuario
            </th>
            <th>
                usuario
            </th>
            <th>
                tarjeta
            </th>
            <th>
                monto_total
            </th>
            <th>
                title
            </th>
            <th>
                clave
            </th>
            <th>
                fecha_de_cobro
            </th>
            <th>
                id
            </th>
            <th>
                tipo_de_cuenta
            </th>
        </tr>
    </thead>
    --}}
    <tbody>
        @if (count($data) != 0)
            @foreach ($data as $d)
        <tr>
            <td>
                {{ $d->estatus }}
            </td>
            <td>
                {{ $d->referencia }}
            </td>
            <td>
                {{ substr($d->usuario, 0,40) }}
            </td>
            <td>
                {{ substr($d->usuario2, 0,40) }}
                {{-- {{ $d->usuario2 }} --}}
            </td>
            <th>
                {{ $d->tarjeta }}
            </th>
            <th>
                {{ number_format($d->monto_total, 2, '.', '') }}
            </th>
            <th>
                {{ $d->title }}
            </th>
            <th>
                {{ $d->clave }}
            </th>
            <th>
                {{ $d->fecha_de_cobro }}
            </th>
            <th>
                {{ $d->id }}
            </th>
            <th>
                {{ $d->tipo_de_cuenta }}
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
