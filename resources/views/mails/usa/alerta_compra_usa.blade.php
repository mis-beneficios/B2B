<table class="table table-inverse">
    <tbody>
        <tr>
            <td>
                Nombre:
            </td>
            <td>
                {{ $contrato->cliente->fullName }}
            </td>
        </tr>
        <tr>
            <td>
                Folio:
            </td>
            <td>
                {{ $contrato->id }}
            </td>
        </tr>
        <tr>
            <td>
                Correo Electrónico:
            </td>
            <td>
                {{ $contrato->cliente->username }}
            </td>
        </tr>
        <tr>
            <td>
                Paquete:
            </td>
            <td>
                {{ $contrato->paquete }}
            </td>
        </tr>
        <tr>
            <td>
                Registrado:
            </td>
            <td>
                {{ $contrato->created }}
            </td>
        </tr>
    </tbody>
</table>
