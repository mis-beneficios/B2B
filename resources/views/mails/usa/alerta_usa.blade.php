<table class="table table-inverse">
    <tbody>
        <tr>
            <td>
                Nombre:
            </td>
            <td>
                {{ $alerta->nombre }}
            </td>
        </tr>
        <tr>
            <td>
                Apellidos:
            </td>
            <td>
                {{ $alerta->apellidos }}
            </td>
        </tr>
        <tr>
            <td>
                Teléfono:
            </td>
            <td>
                {{ $alerta->telefono }}
            </td>
        </tr>
        <tr>
            <td>
                Correo Electrónico:
            </td>
            <td>
                {{ $alerta->email }}
            </td>
        </tr>
        <tr>
            <td>
                Empresa:
            </td>
            <td>
                {{ $alerta->empresa }}
            </td>
        </tr>
        <tr>
            <td>
                Lugar al que quiere viajar:
            </td>
            <td>
                {{ $alerta->place }}
            </td>
        </tr>
        <tr>
            <td>
                Personas a viajar:
            </td>
            <td>
                {{ $alerta->people }}
            </td>
        </tr>
        <tr>
            <td>
                Fecha a viajar:
            </td>
            <td>
                {{ $alerta->date_travel }}
            </td>
        </tr>
        <tr>
            <td>
                Fecha de registro:
            </td>
            <td>
                {{ $alerta->created }}
            </td>
        </tr>
    </tbody>
</table>
