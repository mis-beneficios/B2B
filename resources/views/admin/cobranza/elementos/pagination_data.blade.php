 <table class="table table-hover" id="tableTerminal">
    <thead>
        <tr>
            <th scope="col">
                Segmento
                <br/>
                <small>
                    # Pago
                </small>
            </th>
            <th scope="col">
                # Contrato
                <br/>
                <small>
                    Clave Serfin
                </small>
            </th>
            <th scope="col">
                Cliente
                <br/>
                <small>
                    Convenio
                </small>
            </th>
            <th scope="col">
                Cantidad
                <br/>
                <small>
                    Cantidad total
                </small>
            </th>
            <th scope="col">
                Tarjeta asignada
                <br/>
                <small>
                    Entidad bancaria
                </small>
            </th>
            <th scope="col">
                Estatus
                <br/>
                <small>
                    Motivo del rechazo
                </small>
            </th>
            <th scope="col">
                F. programada
                <br/>
                <small>
                    Fecha cobro exitoso
                </small>
            </th>
            <th scope="col" width="140px">
                Acciones
                <br/>
                <small>
                    Avance de pagos
                </small>
            </th>
        </tr>
    </thead>
    <tbody>
    @foreach ($pagos as $pago)
        <tr>
            <td>
                <span class="text-capitalize"><button type="button" id="btnPago" data-pago_id="{{ $pago->id }}"  data-user_id="{{ $pago->contrato->cliente->id }}"  data-contrato_id="{{ $pago->contrato->id }}" class="btn btn-dark btn-xs"><snall>Segmento:</snall>{{ $pago->segmento }}</button> </span><br/><small>{{ $pago->id }}</small>
            </td>
            <td>
                <span class=""> <a href="{{ route('users.show', $pago->contrato->cliente->id)  }}"> #  {{ $pago->contrato->id }} </a></span><br/><small>{{ $pago->contrato->sys_key }}</small>
            </td>
            <td>
                <span><a href="{{ route("users.show", $pago->contrato->cliente->id) }}" class="btn btn-sm btn-dark">{{ $pago->contrato->cliente->fullName }}</a><small>{{ (!empty($pago->contrato->convenio)) ? $pago->contrato->convenio->empresa_nombre : "S/A" }} </small></span>
            </td>
            <td>
                <span class="">{{  $pago->contrato->divisa . ' ' . number_format($pago->cantidad) }}</span><br/><small>{{ $pago->contrato->divisa .' '. number_format($pago->contrato->precio_de_compra) }}</small>
            </td>
            <td>ad</td>
            <td>ad</td>
            <td>ad</td>
            <td>ad</td>
        </tr>
    @endforeach
    </tbody>
</table>
    <div class="pagination">
    {!! $pagos->links() !!}
    </div>

<script>
$(document).ready(function(){

 $(document).on('click', '.pagination a', function(event){
  event.preventDefault(); 
  var page = $(this).attr('href').split('page=')[1];
  fetch_data(page);
 });

 function fetch_data(page)
 {
  $.ajax({
   url:"admin/cobranza-get-data?page="+page,
   success:function(res)
   {
    $('#tableTerminal').html(res.view);
   }
  });
 }
 
});
</script>