<div class="table-responsive">
    <table class="display nowrap table table-hover dataTable" id="table_comisiones" role="grid" style="width:100%">
        <thead>
            <tr role="row">
                <th>
                    Folio
                </th>
                <th>
                    Llamada
                </th>
                <th>
                    Fecha de venta
                </th>
                <th>
                    Primero pago
                </th>
                <th>
                    Comisionista
                </th>
                <th>
                    Equipo
                </th>
                <th>
                    Empresa
                </th>
                <th>
                    Vendedor
                </th>
                <th>
                    Cliente
                </th>
                <th>
                    Estatus
                </th>
                <th>
                    Motivo
                </th>
                <th>
                    Modificación
                </th>
                <th>
                    Cantidad
                </th>
            </tr>
        </thead>
        <tbody>
            @foreach ($comisiones as $comision)
            @switch($comision->estatus)
                @case('Pagable')
                    @php
                        $color = '#26c6da';
                    @endphp
                @break
                @case('Rechazada')
                @case('Rechazado')
                    @php
                        $color = '#fc4b6c';
                    @endphp
                @break
                @case('Finiquitada')
                @case('Finiquitado')
                    @php
                        $color = '#009efb';
                    @endphp
                @break
                @default
                    @php
                        $color = '#FFD277';
                    @endphp
            @endswitch
            
            <tr>
                <td style="background-color: {{ $color }}">
                    {{ $comision->id }}
                </td>
                <td style="background-color: {{ $color }}">
                    {{ $comision->tipo_llamada }}
                </td>
                <td style="background-color: {{ $color }}">
                    {{ $comision->fecha_de_venta }}
                </td>
                <td style="background-color: {{ $color }}">
                    {{ $comision->primer_pago }}
                </td>
                <td style="background-color: {{ $color }}">
                    {{ $comision->comisionista }}
                </td>
                <td style="background-color: {{ $color }}">
                    {{ $comision->equipo }}
                </td>
                <td style="background-color: {{ $color }}">
                    {{ $comision->empresa_nombre }}
                </td>
                <td style="background-color: {{ $color }}">
                    {{ $comision->vendedor }}
                </td>
                <td style="background-color: {{ $color }}">
                    {{ $comision->cliente_nombre }}
                </td>
                <td style="background-color: {{ $color }}">
                    {{ $comision->estatus }}
                </td>
                <td style="background-color: {{ $color }}">
                    {{ $comision->motivo_rechazo }}
                </td>
                <td style="background-color: {{ $color }}">
                    {{ $comision->modified }}
                </td>
                <td style="background-color: {{ $color }}">
                    {{ $comision->cantidad }}
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

