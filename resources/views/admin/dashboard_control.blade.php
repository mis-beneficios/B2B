@extends('layouts.admin.app')
@section('content')
<div class="row page-titles">
    <div class="col-md-5 col-8 align-self-center">
        <h3 class="text-themecolor text-capitalize">
            Bienvenid@: {{ Auth::user()->fullName }}
        </h3>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="javascript:void(0)">
                    Home
                </a>
            </li>
            <li class="breadcrumb-item active">
                Dashboard
            </li>
        </ol>
    </div>
</div>
<div class="row">
    <div class="col-lg-3 col-md-6">
        <a href="{{ route('contratos.listar_contratos') }}">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex flex-row">
                        <div class="round round-lg align-self-center round-info">
                            <i class="fas fa-file-pdf">
                            </i>
                        </div>
                        <div class="m-l-10 align-self-center">
                            <h3 class="m-b-0 font-light">
                                {{ $panel['por_autorizar'] }}
                            </h3>
                            <h5 class="text-muted m-b-0">
                                Contratos por autorizar
                            </h5>
                        </div>
                    </div>
                </div>
            </div>
        </a>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="card">
            <div class="card-body">
                <div class="d-flex flex-row">
                    <div class="round round-lg align-self-center round-warning">
                        <i class="fas fa-file-pdf">
                        </i>
                    </div>
                    <div class="m-l-10 align-self-center">
                        <h3 class="m-b-0 font-lgiht">
                            {{ $panel['contratos_hoy'] }}
                        </h3>
                        <h5 class="text-muted m-b-0">
                            Ventas de hoy
                        </h5>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="card">
            <div class="card-body">
                <div class="d-flex flex-row">
                    <div class="round round-lg align-self-center round-primary">
                        <i class="fas fa-users">
                        </i>
                    </div>
                    <div class="m-l-10 align-self-center">
                        <h3 class="m-b-0 font-lgiht">
                            {{ $panel['clientes'] }}
                        </h3>
                        <h5 class="text-muted m-b-0">
                            Clientes registrados hoy
                        </h5>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="card">
            <div class="card-body">
                <a href="{{ asset('files/manual_beneficios.pdf') }}" target="_blank">
                    <div class="d-flex flex-row">
                        <div class="round round-lg align-self-center round-success">
                            <i class="fas fa-file-pdf">
                            </i>
                        </div>
                        <div class="m-l-10 align-self-center">
                            <h5 class="text-muted m-b-0">
                                Manual de usuario
                            </h5>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <div class="chart-container">
                    <canvas id="myChart" style="height:250px; width:100%">
                    </canvas>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">
                    Ventas por autorizar
                </h4>
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

        var datos =  @json($grafica);
        var fecha = [];
        var ventas = [];
        var colores = [];
        var back = [];
        $.each(datos, function(index, val) {
            fecha.push(val.fecha);
            ventas.push(val.ventas);
            var r = Math.round(Math.random()*255);
            var g = Math.round(Math.random()*255);
            var b = Math.round(Math.random()*255);
            var rgb="rgba("+r+", "+g+", "+b+", "+.8+")";
            var rgb="rgba("+r+", "+g+", "+b+", "+.2+")";
            back.push(rgb);
        });


        var ctx = document.getElementById('myChart').getContext('2d');

        var myChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: fecha,
                datasets: [{
                    label: 'Ventas del mes ',
                    data: ventas,
                    backgroundColor: back,
                    borderColor: colores,
                    borderWidth: 1
                }]
            },
            options: {
                tooltips: {
                    mode: 'point'
                }
            }
        });

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
        }, 100)
    });
</script>
@stop
