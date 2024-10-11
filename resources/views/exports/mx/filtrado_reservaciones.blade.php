<div class="table-responsive">
    <table class="table table-hover table-striped table-responsive-xl" id="table_filtrado_reservaciones" style="width:100%">
        <thead>
            <tr>
                <th>
                    Folio
                </th>
                <th>
                    Tipo
                </th>
                <th>
                    Cliente
                </th>
                <th>
                    Nombre
                </th>
                <th>
                    Telefono
                </th>
                <th>
                    Correo
                </th>
                <th>
                    Destino
                </th>
                <th>
                    Hotel
                </th>
                <th>
                    Clave
                </th>
                <th>
                    Paquete
                </th>
                <th>
                    Adultos
                </th>
                <th>
                    Menores
                </th>
                <th>
                    Noches
                </th>
                <th>
                    Estatus
                </th>
                <th>
                    Entrada
                </th>
                <th>
                    Salida
                </th>
                <th>
                    Cargos
                </th>
                <th>
                    Limite
                </th>
                <th>
                    Tarifa
                </th>
                <th>
                    Limite
                </th>
                <th>
                    Monto
                </th>
                <th>
                    Pago 1
                </th>
                <th>
                    Fecha 1
                </th>
                <th>
                    Pago 2
                </th>
                <th>
                    Fecha 2
                </th>
                <th>
                    Pago 3
                </th>
                <th>
                    Fecha 3
                </th>
                <th>
                    Total
                </th>
                <th>
                    Saldo
                </th>
            </tr>
        </thead>
        <tbody>
            <?php 
                $adultos = 0; 
                $menores = 0; 
                $noches = 0;
                $cargosTotal = 0;
                $tarifasTotal = 0;
                $pagadaTotal = 0;
                $pagosTotal = 0;
             ?>
            @foreach ($reservaciones as $reservacion)
            @php
                $cargosTotal += $reservacion->cantidad;
                $tarifasTotal += $reservacion->tarifa;
                $pagadaTotal += $reservacion->cantidad_pago;
                $pagosTotal += $reservacion->cantidad_pago_1 + $reservacion->cantidad_pago_2 + $reservacion->cantidad_pago_3;
            @endphp
            @foreach ($reservacion->r_habitaciones as $habitacion)
            @php
               $adultos += $habitacion['adultos']
            @endphp
            @php
               $menores += $habitacion['menores'] 
            @endphp
            @php
               $noches += $habitacion['noches']
            @endphp
            @endforeach
            <tr>
                <td>
                    {{ $reservacion->id }}
                </td>
                <td>
                    {{ $reservacion->tipo }}
                </td>
                <td>
                    {{ ($reservacion->cliente) ? $reservacion->cliente->fullName : 'S/R' }}
                </td>
                <td>
                    {{ $reservacion->nombre_de_quien_sera_la_reservacion }}
                </td>
                <td>
                    {{ (isset($reservacion->telefono)) ? $reservacion->telefono : $reservacion->cliente->telefono }}
                </td>
                <td>
                    {{ ($reservacion->email) ? $reservacion->email : $reservacion->cliente->username }}
                </td>
                <td>
                    {{ $reservacion->destino }}
                </td>
                <td>
                    {{ $reservacion->hotel }}
                </td>
                <td>
                    {{-- {{ parse_str($reservacion->clave) }} --}}
                    {{ $reservacion->clave }}
                </td>
                <td>
                    {{ ($reservacion->estancia) ? $reservacion->estancia->title : 'N/A' }}
                </td>
                <td>
                    {{ $adultos  }}
                </td>
                <td>
                    {{ $menores }}
                </td>
                <td>
                    {{ $noches }}
                </td>
                <td>
                    {{ $reservacion->estatus }}
                </td>
                <td>
                    {{ $reservacion->fecha_de_ingreso }}
                </td>
                <td>
                    {{ $reservacion->fecha_de_salida }}
                </td>
                <td>
                    {{ number_format($reservacion->cantidad,2, '.', '') }}
                </td>
                <td>
                    {{  $reservacion->fecha_limite_de_pago }}
                </td>
                <td>
                    {{ number_format( $reservacion->tarifa,2, '.', '') }}
                </td>
                <td>
                    {{ $reservacion->admin_fecha_para_liquidar }}
                </td>
                <td>
                    {{ number_format($reservacion->cantidad_pago,2, '.', '') }}
                </td>
                <td>
                    {{ number_format($reservacion->cantidad_pago_1,2, '.', '') }}
                </td>
                <td>
                    {{ $reservacion->fecha_de_pago_1 }}
                </td>
                <td>
                    {{ number_format($reservacion->cantidad_pago_2,2, '.', '') }}
                </td>
                <td>
                    {{ $reservacion->fecha_de_pago_2 }}
                </td>
                <td>
                    {{ number_format($reservacion->cantidad_pago_3,2, '.', '') }}
                </td>
                <td>
                    {{ $reservacion->fecha_de_pago_3 }}
                </td>
                <td>
                    {{ number_format($reservacion->cantidad_pago_1 + $reservacion->cantidad_pago_2 + $reservacion->cantidad_pago_3, 2, '.', '') }}
                </td>
                <td>
                    {{ number_format($reservacion->cantidad_pago - $reservacion->cantidad_pago_1 - $reservacion->cantidad_pago_2 - $reservacion->cantidad_pago_3, 2, '.', '') }}
                </td>
            </tr>
            @php
               $adultos = 0
            @endphp
            @php
               $menores = 0 
            @endphp
            @php
               $noches = 0
            @endphp
            @endforeach
            <tr>
                <td>
                </td>
                <td>
                </td>
                <td>
                </td>
                <td>
                </td>
                <td>
                </td>
                <td>
                </td>
                <td>
                </td>
                <td>
                </td>
                <td>
                </td>
                <td>
                </td>
                <td>
                </td>
                <td>
                </td>
                <td>
                </td>
                <td>
                </td>
                <td>
                </td>
                <td>
                </td>
                <td>
                    {{  number_format($cargosTotal,2, '.', '') }}
                </td>
                <td>
                </td>
                <td>
                    {{ number_format( $tarifasTotal,2, '.', '') }}
                </td>
                <td>
                </td>
                <td>
                    {{ number_format($pagadaTotal,2, '.', '') }}
                </td>
                <td>
                </td>
                <td>
                </td>
                <td>
                </td>
                <td>
                </td>
                <td>
                </td>
                <td>
                </td>
                <td>
                    {{ number_format($pagosTotal, 2, '.', '') }}
                </td>
                <td>
                    {{ number_format($pagadaTotal-$pagosTotal, 2, '.', '') }}
                </td>
            </tr>
        </tbody>
    </table>
</div>