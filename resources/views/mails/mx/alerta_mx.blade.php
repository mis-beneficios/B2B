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
                Fecha de registro:
            </td>
            <td>
                {{ $alerta->created }}
            </td>
        </tr>
    </tbody>
</table>