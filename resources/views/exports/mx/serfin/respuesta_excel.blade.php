<table class="table table-hover">
    <tbody>
        @foreach ($datos as $d)
        <tr>
            <td>
                {{ number_format($d['importe'], 2) }}
            </td>
            <td>
                {{ $d['fecha'] }}
            </td>
            <th>
                {{ $d['fecha2'] }}
            </th>
            <td>
                {{ $d['banco'] }}
            </td>
            <td>
                {{ $d['clave'] }}
            </td>
            <th>
                {{ $d['tarjeta'] }}
            </th>
            <td>
                {{ $d['cliente'] }}
            </td>
            <td>
                {{ $d['referencia'] }}
            </td>
            <th>
                {{ $d['cliente2'] }}
            </th>
            <td>
                {{ $d['ceros'] }}
            </td>
            <td>
                {{ $d['code'] }}
            </td>
            <th>
                {{ $d['agencia'] }}
            </th>
            <th>
                {{ $d['clave2'] }}
            </th>
        </tr>
        @endforeach
    </tbody>
</table>
