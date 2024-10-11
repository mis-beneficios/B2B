@extends('layouts.admin.app')
@section('content')
@livewireStyles
@livewireScripts
<div class="row page-titles">
    <div class="col-md-5 col-8 align-self-center">
        <h3 class="text-themecolor">
            Comisiones
        </h3>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('dashboard') }}">
                    Inicio
                </a>
            </li>
            <li class="breadcrumb-item active">
                Listado de comisiones
            </li>
        </ol>
    </div>
</div>
<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="card">
            <div class="card-body">
                <div class="">
                    <table class="table table-hover" id="table_comisiones" style="width:100%">
                        <thead>
                            <tr role="row">
                                <th>
                                    Folio
                                </th>
                                <th >
                                    Llamada
                                </th>
                                <th >
                                    Fecha de venta
                                </th>
                                <th >
                                    Primero pago
                                </th>
                                <th>
                                    Comisionista
                                </th>
                                <th>
                                    Cliente
                                </th>
                                <th>
                                    Estatus
                                </th>
                                <th>
                                    Actualización
                                </th>
                                <th>
                                    Cantidad
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data_comisiones as $comision)
                            <tr>
                                <td>
                                    <a href="{{ route('users.show', $comision->user_id) }}" target="_blank">  {{ $comision->id }}  </a>
                                </td>
                                <td>
                                    {{ $comision->tipo_llamada }}
                                </td>
                                <td>
                                    {{ $comision->fecha_de_venta }}
                                </td>
                                <td>
                                    {{ $comision->primer_pago }}
                                </td>
                                <td>
                                    <span>Comisionista: {{ $comision->comisionista }}</span>
                                    <br>
                                    <small>Vendedor: {{ $comision->vendedor }}</small>
                                    <br>
                                    <small>
                                        Equipo: {{ $comision->equipo }}
                                    </small>
                                </td>
                                <td>
                                    <span>{{ $comision->cliente_nombre }}<span> <br> <small class='badge badge-info'>{{ $comision->empresa_nombre }}</small>
                                </td>
                                <td>
                                    @php
                                        switch ($comision->estatus) {
                                            case 'Pagable':
                                            case 'Pagado':
                                                $estatus = '<span class="badge badge-success">Pagable</span><br><small>'.$comision->motivo_rechazo.'</small>';
                                                break;

                                            case 'Pagada':
                                                 $estatus = '<span class="badge badge-info">Pagada</span><br><small>'.$comision->motivo_rechazo.'</small>';
                                                break;
                                            
                                            case 'Finiquitadas':
                                            case 'Finiquitada':
                                                 $estatus = '<span class="badge badge-primary">Finiquitada</span><br><small>'.$comision->motivo_rechazo.'</small>';
                                                break;
                                            
                                            case 'Rechazada':
                                            case 'Rechazado':
                                                 $estatus = '<span class="badge badge-danger">Rechazada</span><br><small>'.$comision->motivo_rechazo.'</small>';
                                                break;
                                            
                                            default:
                                                 $estatus = '<span class="badge badge-warning">Pendiente</span><br><small>'.$comision->motivo_rechazo.'</small>';
                                                break;
                                        }
                                    @endphp

                                    {!! $estatus !!}     
                                </td>
                                <td>
                                    {{ $comision->modified }}
                                </td>
                                <td>
                                    {{ '$ ' . $comision->cantidad }}
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                     @if ($data_comisiones)
                    <div class="col-md">
                        <div class=" ml-3">
                            Mostrando {{ $data_comisiones->firstItem() }} a {{ $data_comisiones->lastItem() }} de {{ $data_comisiones->total() }} registros.
                        </div>
                    </div>  
                    <div class="col-md mr-4">
                        <div class="float-right">
                            {{ $data_comisiones->appends(request()->query())->links() }}
                            {{-- {{ $data_comisiones->links() }} --}}
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


@section('script')
<script>
    $(document).ready(function() {
        $('.select2').select2({
            maximumSelectionLength: 5,
            formatSelectionTooBig: function (limit) {
                return 'Solo puedes seleccionar ' + limit + ' elementos.';
            }
        });


         $('#fechas').daterangepicker({
            autoUpdateInput: true,
            locale: {
                format: 'YYYY-MM-DD',
                separator: ' al ',
                applyLabel: 'Aplicar',
                cancelLabel: 'Cancelar',
                fromLabel: 'Desde',
                toLabel: 'Hasta',
                customRangeLabel: 'Personalizado',
                weekLabel: 'W',
                daysOfWeek: ['Dom', 'Lun', 'Mar', 'Mié', 'Jue', 'Vie', 'Sáb'],
                monthNames: [
                    'Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'
                ],
                firstDay: 1,
            },
            maxSpan: {
                days: 16
            },
        });
 

        // $('#formComisiones').submit(function(event) {
        //     event.preventDefault();
        //     var request = $(this).serialize();
        //     pintarDatos(request);
        // });

        $('#btnDescargarComisiones').on('click', function(event) {
            event.preventDefault();
            var request = $(this).serialize();
            $.ajax({
                url: "{{ route('comisiones.export') }}",
                type: 'GET',
                dataType: 'json',
                data: $('#formComisiones').serialize(),
                beforeSend:function(){
                    $("#overlay").css("display", "block");
                },
                success:function(res){
                    if (res.success == true) {
                        alertify.alert('Descargando...','Descargando filtrado, no actualice ni cierre esta pestaña hasta que se descargue el archivo.');
                        window.location.href = res.url;
                    }
                }
            })
            .always(function() {
                $("#overlay").css("display", "none");
            });
        });

    });
</script>
@endsection
