<div class="table-responsive">
    <table class="table table-hover dataTable" id="table_registros" role="grid" style="width:100%">
        <thead>
            <tr role="row">
                <th aria-sort="ascending" class="sorting_asc">
                    Folio
                </th>
                <th aria-controls="" aria-label="" aria-sort="ascending" class="sorting_asc" colspan="1" rowspan="1" tabindex="0">
                    Nombre
                </th>
                <th aria-controls="" aria-label="" class="sorting" colspan="1" rowspan="1" tabindex="0">
                    Correo Electrónico
                </th>
                <th aria-controls="" aria-label="" class="sorting" colspan="1" rowspan="1" tabindex="0">
                    Teléfono
                </th>
                <th aria-controls="" aria-label="" class="sorting" colspan="1" rowspan="1" tabindex="0">
                    Teléfono oficina o casa
                </th>
                <th aria-controls="" aria-label="" class="sorting" colspan="1" rowspan="1" tabindex="0">
                    No. Empleado
                </th>
                <th>
                    Empresa
                </th>
                <th>
                    Sucursal
                </th>
                <th aria-controls="" aria-label="" class="sorting" colspan="1" rowspan="1" tabindex="0" width="80">
                    Creado
                </th>
            </tr>
        </thead>
        <tbody>
            @foreach ($registros as $registro)
            <tr>
                <td>
                    {{ $registro->id }}
                </td>
                <td>
                    {{ $registro->nombre_completo . ' ' . $registro->apellidos }}
                </td>
                <td>
                    {{ $registro->email }}
                </td>
                <td>
                    {{ (string)$registro->telefono_casa }}
                </td>
                <td>
                    {{ (string)$registro->telefono_celular }}
                </td>
                <td>
                    {{ (string)$registro->numero_empleado }}
                </td>
                <td>
                    {{ $registro->nom_empresa }}
                </td>
                <td>
                    {{ $registro->sucursal }}
                </td>
                <td>
                    {{ $registro->created }}
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>