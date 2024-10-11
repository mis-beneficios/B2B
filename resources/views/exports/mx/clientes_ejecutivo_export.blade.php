<table class="table table-hover" id="editable-datatable" style="cursor: pointer; width: 100%;" role="grid" aria-describedby="editable-datatable_info">
    <thead>
        <tr role="row">
            <th >
                Cliente
            </th>
            <th >
                Correo electrónico
            </th>
            <th >
                Convenio
            </th>
            <th >
                Registrado
            </th>
            <th >
                Estatus
            </th>
        </tr>
    </thead>
    <tbody>
        @foreach ($contratos as $contrato)
            <tr>
                <td>
                    {{ $contrato->cliente->fullName }}
                </td>
                <td>
                    {{ $contrato->cliente->username }}
                </td>
                <td>
                    {{ $contrato->convenio->empresa_nombre }}
                </td>
                <td>
                    {{ $contrato->diffForhumans() }}
                    <br>
                    {{ $contrato->created }}
                </td>
                <td>
                    {{ $contrato->estatus }}
                </td>
            </tr>
        @endforeach
    </tbody>
</table>