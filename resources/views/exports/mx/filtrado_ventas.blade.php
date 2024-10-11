<div class="table-responsive mt-3">
    <table class="table table-hover dataTable" id="tabla_ventas" role="grid" style="width:100%">
        <thead>
            <tr role="row">
                <th aria-sort="ascending" class="sorting_asc">
                    ID
                </th>
                <th aria-controls="" aria-label="" class="sorting" colspan="1" rowspan="1" tabindex="0">
                    Cliente
                </th>
                <th aria-controls="" aria-label="" class="sorting" colspan="1" rowspan="1" tabindex="0">
                    Paquete
                </th>
                <th aria-controls="" aria-label="" class="sorting" colspan="1" rowspan="1" tabindex="0">
                    Estatus
                </th>
                <th aria-controls="" aria-label="" class="sorting" colspan="1" rowspan="1" tabindex="0">
                    Vendedor
                </th>
                <th aria-controls="" aria-label="" class="sorting" colspan="1" rowspan="1" tabindex="0">
                    Equipo
                </th>
                <th aria-controls="" aria-label="" class="sorting" colspan="1" rowspan="1" tabindex="0">
                    Segmentos
                </th>
                <th aria-controls="" aria-label="" class="sorting" colspan="1" rowspan="1" tabindex="0">
                    Pagos Realizados
                </th>
                <th aria-controls="" aria-label="" class="sorting" colspan="1" rowspan="1" tabindex="0">
                    Convenio
                </th>
                <th aria-controls="" aria-label="" class="sorting" colspan="1" rowspan="1" tabindex="0">
                    Como se entero
                </th>
                <th aria-controls="" aria-label="" class="sorting" colspan="1" rowspan="1" tabindex="0">
                    Tipo de llamada
                </th>
                <th aria-controls="" aria-label="" class="sorting" colspan="1" rowspan="1" tabindex="0">
                    Creado
                </th>
            </tr>
        </thead>
        <tbody>
            @foreach ($ventas as $venta)
            <tr>
                <td>
                    {{ $venta->id }}
                </td>
                <td>
                    {{ $venta->cliente->fullName }}
                </td>
                <td>
                    {{ $venta->paquete }}
                </td>
                <td>
                    {{ $venta->estatus }}
                </td>
                <td>
                    {{ $venta->padre->vendedor->fullName }}
                </td>
                <td>
                    {{ ($venta->padre->vendedor->equipo) ? $venta->padre->vendedor->equipo->title : 'Sin registro'}}
                </td>
                <td>
                    {{ $venta->cuotas_pagos }}
                </td>
                <td>
                    {{ $venta->pagos_realizados }}
                </td>
                <td>
                    {{ $venta->convenio->empresa_nombre }}
                </td>
                <td>
                    {{ $venta->ComoSeEntero }}
                </td>
                <td>
                    {{ $venta->tipo_llamada }}
                </td>
                <td>
                    {{ $venta->diffForhumans() }}
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>