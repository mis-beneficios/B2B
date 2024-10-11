<!-- Modal -->
<div aria-hidden="true" aria-labelledby="modelTitleId" class="modal fade" id="modalPagos" role="dialog" tabindex="-1">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    Pagos
                </h5>
                <button aria-label="Close" class="close" data-dismiss="modal" type="button">
                    <span aria-hidden="true">
                        ×
                    </span>
                </button>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <div class="table-resposive">
                        <table class="table" id="table_pagos">
                            <thead class="">
                                <tr>
                                    <th>
                                        #
                                    </th>
                                    <th>
                                        Segmento
                                    </th>
                                    <th>
                                        Fecha de Cobro
                                    </th>
                                    <th>
                                        Fecha de Pago
                                    </th>
                                    <th>
                                        Cantidad
                                    </th>
                                    <th>
                                        Estatus
                                    </th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" data-dismiss="modal" type="button">
                    Cerrar
                </button>
            </div>
        </div>
    </div>
</div>

<script>
     // $('#btnPagos').click(function (e) { 
        $('body').on('click', '#btnPagos', function (e) {
            e.preventDefault();
            var contrato_id = $(this).data('id');
            $('#modalPagos').modal('show');
            var table =  $('#table_pagos').DataTable({
                order: ([0, 'asc']),
                lengthMenu: [[5, 10, 25, 50, -1], [5, 10, 25, 50, "Todo"]],
                pageLength: 5,
                ajax: baseuri + "cliente/obtener-pagos/"+ contrato_id,
                success:function(){
                    $('modalPagos').modal('show');
                },
                columns: [
                    {data: 'id', name: 'id'},
                    {data: 'segmento', name: 'segmento'},
                    {data: 'fecha_de_cobro', name: 'fecha_de_cobro'},
                    {data: 'fecha_de_pago', name: 'fecha_de_pago'},
                    {data: 'cantidad', name: 'cantidad'},
                    {
                        data: 'estatus', render: function (estatus) {
                            if (estatus == 'Pagado') {
                                return '<label class="label label-success">Pagado</label>';
                            } else {
                                return '<label class="label label-warning">Pendiente</label>';
                            }
                        }
                    },
                ]
            });
        });
</script>
