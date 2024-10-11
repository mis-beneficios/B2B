@extends('layouts.admin.app')
@section('content')
<div class="row page-titles">
    <div class="col-md-7 col-8 align-self-center">
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
    <div class="col-md-5 col-4 align-self-center">
        <div class="d-flex m-t-10 justify-content-end">
            <div class="d-flex m-r-20 m-l-10 hidden-md-down">
                <div class="chart-text m-r-10">
                    <h4 class="m-t-0 alert alert-rounded {{ $panel['actualizacion'] != null ? 'alert-info' : 'alert-warning' }}">
                        @if ($panel['actualizacion'] != null)
                            Sistema actualizado
                        @else
                            Sistema no actualizado
                        @endif
                    </h4>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-xl-4 col-lg-4 col-md-4">
        @include('admin.elementos.views.actualizar_serfin', ['act' => $panel['actualizacion']])
     </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <div class="card-actions">  
                    <ul class="list-inline">
                        <li>
                            <input type="text" name="rango" id="rango" class="form-control" value="{{ date('Y-m') }}-01 al {{ date('Y-m-d') }}">
                        </li>
                    </ul>
                </div>
                <h4 class="card-title m-b-0">
                    Ingresos
                </h4>
            </div>
            <div class="card-body">
                <div class="chart-container">
                    <canvas id="chartIngresos" height="80">
                    </canvas>
                </div>
                <div class="row text-center">
                    <div class="col-lg-4 col-md-4 m-t-20">
                        <h1 class="m-b-0 font-light" id="total"></h1>
                        <small>Total ingresos</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-6">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">
                    Ventas
                </h4>
                <div class="chart-container">
                    <canvas id="myChart">
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

        var datos =  @json($grafica);
        var fecha = [];
        var ventas = [];
        var colores = [];
        var back = [];
        // var back = [];
      
        $.each(datos, function(index, val) {
            fecha.push(val.fecha);
            ventas.push(val.ventas);
            var r = Math.round(Math.random()*255);
            var g = Math.round(Math.random()*255);
            var b = Math.round(Math.random()*255);
            var rgb1="rgba("+r+", "+g+", "+b+", "+.9+")";
            var rgb ="rgba("+r+", "+g+", "+b+", "+.8+")";
            back.push(rgb1);
            colores.push(rgb);
        });

       
        var ctx = document.getElementById('myChart').getContext('2d');

        var myChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: fecha,
                datasets: [{
                    label: 'Ventas del mes ',
                    data: ventas,
                    backgroundColor: colores,
                    borderColor: back,
                    borderWidth: 1
                }]
            },
            options: {
                tooltips: {
                    mode: 'point'
                }
            }
        });


        var ventas_data =  @json($ventas_equipo);
        var equipos = [];
        var ventas_e = [];
        var colores_e = [];

        $.each(ventas_data, function(index, val) {
            ventas_e.push(val.ventas);
            equipos.push(val.equipo);
            var r = Math.round(Math.random()*255);
            var g = Math.round(Math.random()*255);
            var b = Math.round(Math.random()*255);
            var rgb="rgba("+r+", "+g+", "+b+", "+.8+")";
            var rgb="rgba("+r+", "+g+", "+b+", "+.8+")";
            colores_e.push(rgb);
        });


        var ventas_por_equipo = document.getElementById('ventas_por_equipo').getContext('2d');

        var myChart = new Chart(ventas_por_equipo, {
            type: 'pie',
            data: {
                labels: equipos,
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


        var rango =  $('#rango').val();
        
        pintar_ingresos(rango);


        $('#rango').on('change', function(event) {
            event.preventDefault();
            pintar_ingresos($(this).val());
            
        });
    });

      function pintar_ingresos(rango) {
        var datos =  @json($grafica);
        var fecha = [];
        var ventas = [];
        var colores = [];
        var back = [];
        var total = 0;
        $('#chartIngresos').html('');
        $.ajax({
            url: baseadmin + 'ingresos/' + rango,
            type: 'GET',
            dataType: 'JSON',
            beforeSend:function(){
                // $('#overlay').css('display', 'block');
            },
            success:function(res){
                $.each(res.ingresos, function(index, val) {
                    total += val.cantidad;
                    fecha.push(val.fecha);
                    ventas.push(val.cantidad.toFixed(2));
                    var r = Math.round(Math.random()*255);
                    var g = Math.round(Math.random()*255);
                    var b = Math.round(Math.random()*255);
                    var rgb1="rgba("+r+", "+g+", "+b+", "+.9+")";           
                    var rgb ="rgba("+r+", "+g+", "+b+", "+.8+")";
                    back.push(rgb1);
                    colores.push(rgb);
                });

                $('#total').html('$'+total.toFixed(2));

                var ctx = document.getElementById('chartIngresos').getContext('2d');

                var myChart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: fecha,
                        datasets: [{
                            label: 'Ingresos',
                            data: ventas,
                            backgroundColor: colores,
                            borderColor: back,
                            borderWidth: 1 
                        }]
                    },
                    options: {
                        tooltips: {
                            mode: 'point'
                        }
                    }
                });
            }
        })
        .always(function() {
            $('#overlay').css('display', 'none');
        });
        
    }
</script>
@stop
