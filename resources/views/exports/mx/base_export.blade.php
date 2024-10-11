<div class="table-responsive">
    <table class="display nowrap table table-hover dataTable" id="table_comisiones" role="grid" style="width:100%">
        <thead>
            <tr role="row">
                <th>
                    Folio
                </th>
                <th>
                    Cliente
                </th>
                <th>
                    Empresa
                </th>
                <th>
                    Paquete
                </th>
                <th>
                    Estatus
                </th>
                <th>
                    Correo Electrónico
                </th>
                <th>
                    Teléfono
                </th>
                <th>
                    Teléfono
                </th>
                <th>
                    Teléfono
                </th>
                <th>
                    Creado
                </th>
            </tr>
        </thead>
        <tbody>
            @foreach ($registros as $dato)
            <tr>
                <td>
                    {{ $dato->id }}
                </td>
                <td>
                    {{ $dato->cliente->fullName }}
                </td>
                <td>
                    {{ $dato->convenio->empresa_nombre }}
                </td>
                <td>
                    {{ $dato->paquete }}
                </td>
                <td>
                    {{ $dato->estatus }}
                </td>
                <td>
                    {{ $dato->cliente->username }}
                </td>
                <td>
                    {{ $dato->cliente->telefono }}
                </td>
                <td>
                    {{ $dato->cliente->telefono_oficina }}
                </td>
                <td>
                    {{ $dato->cliente->telefono_casa }}
                </td>
                <td>
                    {{ $dato->created }}
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

