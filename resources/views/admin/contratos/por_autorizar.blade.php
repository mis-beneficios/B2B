@extends('layouts.admin.app')
@section('content')
<div class="row page-titles">
    <div class="col-md-5 col-8 align-self-center">
        <h3 class="text-themecolor">
            Dashboard
        </h3>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="javascript:void(0)">
                    Home
                </a>
            </li>
            <li class="breadcrumb-item active">
                Contratos registrados
            </li>
        </ol>
    </div>
</div>
<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover dataTable" id="table_contratos" role="grid" style="width:100%">
                        <thead>
                            <tr role="row">
                                <th aria-sort="ascending" class="sorting_asc">
                                    Folio
                                </th>
                                <th aria-controls="" aria-label="" aria-sort="ascending" class="sorting_asc" colspan="1" rowspan="1" tabindex="0">
                                    Cliente
                                </th>
                                <th aria-controls="" aria-label="" class="sorting" colspan="1" rowspan="1" tabindex="0">
                                    Convenio
                                </th>
                                <th aria-controls="" aria-label="" class="sorting" colspan="1" rowspan="1" tabindex="0">
                                    Vendedor
                                </th>
                                <th>
                                    # Paquetes
                                </th>
                                <th aria-controls="" aria-label="" class="sorting" colspan="1" rowspan="1" tabindex="0">
                                    Registrado
                                </th>
                                <th aria-controls="" aria-label="" class="sorting" colspan="1" rowspan="1" tabindex="0" width="80">
                                    Opciones
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


@section('script')
<script>
    $(document).ready(function() {
        moment.locale('es');  
        var estatus = 'por_autorizar';
        var tabla;

        setTimeout(function(){
            tabla =  $('#table_contratos').DataTable({
                'responsive': true,
                'searching': true,
                "order": [[ 0, "desc" ]],
                'lengthMenu': [[10, 50, -1], [10, 50, "Todo"]],
                'pageLength': 10,
                "aoColumns": [{
                    "mData": "1"
                    }, {
                    "mData": "2"
                    },{
                    "mData": "3"
                    }, {
                    "mData": "4"
                    }, {
                    "mData": "6"
                    }, {
                    "mData": "5"
                    },{
                    "mData": "7"
                    }
                ],
                "ajax": {
                    url: baseuri + "admin/obtener-contratos/"+estatus,
                    type: "get",
                    dataType: "json",
                    error: function(e) {
                        toastr['error'](e.responseText);
                    }
                },
            });
        }, 500)
        
    });
</script>
@endsection
