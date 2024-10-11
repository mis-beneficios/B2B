@extends('layouts.admin.app')
{{-- @livewireStyles
@livewireScripts --}}
<style>
    .sales .fas{
        padding-top: 15px;
    }
</style>
@section('content')
<div class="row page-titles">
    <div class="col-md-5 col-8 align-self-center">
        <h3 class="text-themecolor">
            Bienvenid@ {{ Auth::user()->fullName }}
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
<div class="row sales">
    <div class="col-lg-3 col-md-6">
        <div class="card">
            <div class="card-body">
                <div class="d-flex flex-row">
                    <div class="round round-lg align-self-center round-info">
                        <i class="fas fa-users">
                        </i>
                    </div>
                    <div class="m-l-10 align-self-center">
                        <h3 class="m-b-0 font-light">
                            {{ $users }}
                        </h3>
                        <h5 class="text-muted m-b-0">
                            Total Clientes
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
                    <div class="round round-lg align-self-center round-warning">
                        <i class="fas fa-file-pdf">
                        </i>
                    </div>
                    <div class="m-l-10 align-self-center">
                        <h3 class="m-b-0 font-lgiht">
                            {{ $contratos }}
                        </h3>
                        <h5 class="text-muted m-b-0">
                            Total Contratos
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
                        <i class="fas fa-money-bill-wave">
                        </i>
                    </div>
                    <div class="m-l-10 align-self-center">
                        <h3 class="m-b-0 font-lgiht">
                            {{ $comisiones }}
                        </h3>
                        <h5 class="text-muted m-b-0">
                            Total Comisiones
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


{{-- Comisiones --}}
{{-- @livewire('comisiones.enganches') --}}
{{-- Fin comisiones --}}


<div class="row">
    <div class="col-lg-6 col-md-12 col-sm-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">
                    Total de ventas
                </h4>
                <div class="chart-container">
                    <canvas id="myChart" style="height:40vh;">
                    </canvas>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">
                    Ventas de hoy por equipo
                </h4>
                <div class="chart-container">
                    <canvas id="ventas_por_equipo" style="height:80vh;">
                    </canvas>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
    $(document).ready(function() {

        var mis_ventas =  @json($mis_ventas);
        
        var fecha = [];
        var ventas = [];
        var colores = [];
        var back = [];
        $.each(mis_ventas, function(index, val) {
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
                responsive: true,
                tooltips: {
                    mode: 'point'
                }
            }
        });


        var ventas_equipo =  @json($ventas_equipo);
        var vendedor = [];
        var ventas_e = [];
        var colores_e = [];

        $.each(ventas_equipo, function(index, val) {
            ventas_e.push(val.ventas);
            vendedor.push(val.vendedor);
            var r = Math.round(Math.random()*255);
            var g = Math.round(Math.random()*255);
            var b = Math.round(Math.random()*255);
            var rgb="rgba("+r+", "+g+", "+b+", "+.8+")";
            colores_e.push(rgb);
        });


        var ventas_por_equipo = document.getElementById('ventas_por_equipo').getContext('2d');

        var myChart = new Chart(ventas_por_equipo, {
            type: 'pie',
            data: {
                labels: vendedor,
                datasets: [{
                    label: 'Ventas por equipo',
                    data: ventas_e,
                    backgroundColor: colores_e,
                    borderColor: colores_e,
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                tooltips: {
                    mode: 'point'
                }
            }
        });
    });
</script>
@stop
