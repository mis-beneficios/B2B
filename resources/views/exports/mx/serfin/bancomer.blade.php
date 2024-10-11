<div class="table-responsive mt-3">
    <table class="table table-hover dataTable" id="tabla_ventas" role="grid" style="width:100%">
        
         <thead>
            <tr role="row">
                <th aria-sort="ascending" class="sorting_asc">
                    importe
                </th>
                <th aria-controls="" aria-label="" class="sorting" colspan="1" rowspan="1" tabindex="0">
                    fecha
                </th>
                <th aria-controls="" aria-label="" class="sorting" colspan="1" rowspan="1" tabindex="0">
                    operacion
                </th>
                <th aria-controls="" aria-label="" class="sorting" colspan="1" rowspan="1" tabindex="0">
                    fecha2
                </th>
                <th aria-controls="" aria-label="" class="sorting" colspan="1" rowspan="1" tabindex="0">
                    banco
                </th>
                <th aria-controls="" aria-label="" class="sorting" colspan="1" rowspan="1" tabindex="0">
                    tipo
                </th>
                <th aria-controls="" aria-label="" class="sorting" colspan="1" rowspan="1" tabindex="0">
                    tarjeta
                </th>
                <th aria-controls="" aria-label="" class="sorting" colspan="1" rowspan="1" tabindex="0">
                    nombre
                </th>
                <th aria-controls="" aria-label="" class="sorting" colspan="1" rowspan="1" tabindex="0">
                    referencia
                </th>
                <th>
                    usuario
                </th>
                <th>
                    iva
                </th>
                <th aria-controls="" aria-label="" class="sorting" colspan="1" rowspan="1" tabindex="0">
                    id
                </th>
                <th aria-controls="" aria-label="" class="sorting" colspan="1" rowspan="1" tabindex="0">
                    referencia2
                </th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $d)
            <tr>
                <td>
                    {{-- {{ $d->importe }} --}}
                    {{-- {{ str_replace('.','',number_format($d->importe,2)) }} --}}

                    @php
                        $parteDecimal = $d->importe - floor($d->importe); // Obtener la parte decimal
                        if ($parteDecimal > 0.5) {
                            $res =  ceil($d->importe);
                        } elseif ($parteDecimal < 0.5) {
                            $res =  floor($d->importe);
                        } else {
                            $res =  $d->importe;
                        }
                    @endphp

                    {{ str_replace('.','',number_format($res,2)) }}
                </td>
                <td>
                    {{ $d->fecha }}
                </td>
                <td>
                    Domiciliación de recibos
                </td>
                <td>
                    {{ $d->fecha2 }}
                </td>
                <td>
                    BBVA BANCOMER
                </td>
                <td>
                    {{ $d->tipo }}
                </td>
                <td>
                    {{ $d->tarjeta }}
                </td>
                <td>
                    {{ $d->nombre }}
                </td>
                <td>
                    {{ $d->referencia }}
                </td>
                <td>
                    {{ $d->usuario }}
                </td>
                <td>
                    000
                </td>
                <td>
                    {{ $d->pago_id }}
                </td>
                <td>
                    {{ $d->referencia2 }}
                </td>                
            </tr>
            @endforeach
        </tbody>
    </table>
</div>