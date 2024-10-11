<table class="table table-hover">
    <tbody>
        @if (count($data) != 0)
            @foreach ($data as $d)
        <tr>
            <td>
                {{ $d->id }}
            </td>
            <td>
                {{ $d->usuario }}
            </td>
            <th>
                {{ $d->correo }}
            </th>
            {{--
            <th>
                {{ $d->num_segmentos }}
            </th>
            --}}
        </tr>
        @endforeach
        @else
        <p>
            Sin registros
        </p>
        @endif
    </tbody>
</table>
