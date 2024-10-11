<div class="table-responsive mt-3">
    <table class="table table-hover dataTable" id="tabla_ventas" role="grid" style="width:100%">
        <thead>
            <tr role="row">
                <th aria-controls="" aria-label="" class="sorting" colspan="1" rowspan="1" tabindex="0">
                    Cliente
                </th>
                <th aria-controls="" aria-label="" class="sorting" colspan="1" rowspan="1" tabindex="0">
                    Correo electronico
                </th>
                <th aria-controls="" aria-label="" class="sorting" colspan="1" rowspan="1" tabindex="0">
                    Telefono
                </th>
                <th aria-controls="" aria-label="" class="sorting" colspan="1" rowspan="1" tabindex="0">
                    Empresa
                </th>
                <th aria-controls="" aria-label="" class="sorting" colspan="1" rowspan="1" tabindex="0">
                    Enviado a
                </th>
                <th aria-controls="" aria-label="" class="sorting" colspan="1" rowspan="1" tabindex="0">
                    Creado
                </th>
            </tr>
        </thead>
        <tbody>
            @foreach ($alertas as $alerta)
            <tr>
                <td>
                    {{ $alerta->nombre . ' ' . $alerta->apellidos}}
                </td>
                <td>
                    {{ $alerta->email }}
                </td>
                <td>
                    {{ $alerta->telefono }}
                </td>
                <td>
                    {{ $alerta->empresa }}
                </td>
                <td>
                    {{ $alerta->alerta_compra_enviada_a }}
                </td>
                <td>
                    {{ $alerta->created }}
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>