<div>
    <div class="row">
        <div class="col-md">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title m-b-0">
                        Filtrar comisiones
                    </h4>
                </div>
                <div class="card-body">
                    <form wire:submit.prevent="getComisiones">
                        <div class="form-row">
                            <div class="form-group col-md-2">
                                <label for="rango_fechas">
                                    Rango de fechas
                                </label>
                                <input type="text" id="rango_fechas" autocomplete="off" wire:model.defer="rango_fechas"  class="form-control"/>
                            </div>
                        </div>
                        <div class="row">
                            {{-- @if (Auth::user()->can('create', App\Comision::class)) --}}
                            <div class="form-group col-md-12" wire:ignore>
                                <label for="inputPassword4">
                                    Ejecutivos
                                </label>
                                <select class="form-control custom-select select2 m-b-10 select2-multiple select2-hidden-accessible" multiple="" id="ejecutivos_select">
                                {{-- <select class="form-control custom-select select2 m-b-10 select2-multiple select2-hidden-accessible" multiple="" wire:model="ejecutivos_select" style="width: 100%; height: 200px;"> --}}
                                    @if (Auth::user()->role == 'conveniant' || Auth::user()->role == 'sales')
                                    <option selected="" value="{{ Auth::user()->username }}">
                                        {{ Auth::user()->fullName .' '. Auth::user()->username}}
                                    </option>
                                    @else
                                    @foreach ($ejecutivos as $ejecutivo)
                                    <option value="{{ $ejecutivo->username }}">
                                        {{ $ejecutivo->fullName .' '. $ejecutivo->username}}
                                    </option>
                                    @endforeach

                                    @endif
                                </select>
                            </div>
                            {{-- @endif --}}
                        </div>
                        <button class="btn btn-primary btn-sm" type="submit">
                            Filtrar
                        </button>
                        <button class="btn btn-dark btn-sm" id="btnDescargarComisiones" type="button">
                            <i class="fas fa-file-excel-o">
                            </i>
                            Descargar
                        </button>
                    </form>
                </div>
            </div>
        </div>
        {{-- @endif --}}
        <div class="col-lg-12 col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover dataTable" id="table_comisiones" style="width:100%">
                            <thead>
                                <tr role="row">
                                    <th>
                                        Folio
                                    </th>
                                    <th >
                                        Llamada
                                    </th>
                                    <th class="col-2">
                                        Fecha de venta
                                    </th>
                                    <th class="col-2">
                                        Primero pago
                                    </th>
                                    <th>
                                        Comisionista
                                    </th>
                                    <th>
                                        Equipo
                                    </th>
                                    <th>
                                        Empresa
                                    </th>
                                    <th>
                                        Cliente
                                    </th>
                                    <th>
                                        Estatus
                                    </th>
                                    <th>
                                        Modificación
                                    </th>
                                    <th>
                                        Cantidad
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <div wire:loading target="getComisiones">
                                    <div class="alert alert-info">Cargando datos...</div>
                                </div>
                                @if ($comisiones)
                                {{ $data_comisiones }}
                                @foreach ($comisiones as $comision)
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
                                            <span>{{ $comision->comisionista }}</span>
                                            <br>
                                            <small>{{ $comision->vendedor }}</small>
                                        </td>
                                        <td>
                                            {{ $comision->equipo }}
                                        </td>
                                        <td>
                                            {{ $comision->empresa_nombre }}
                                        </td>
                                        <td>
                                            {{ $comision->cliente_nombre }}
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
                                @endif
                            </tbody>
                        </table>
                    </div>
                    @if ($comisiones)
                    <div class="col-md">
                        <div class=" ml-3">
                            Mostrando {{ $comisiones->firstItem() }} a {{ $comisiones->lastItem() }} de {{ $comisiones->total() }} registros.
                        </div>
                    </div>  
                    <div class="col-md mr-4">
                        <div class="float-right">
                            
                            {{ $comisiones->links() }}
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@section('script')
<script>    

    window.addEventListener('alert', event => { 
        toastr[event.detail.type](event.detail.message, 
        event.detail.title ?? ''), toastr.options = {
            "closeButton": true,
            "progressBar": true,
        }
    });
    
    $(document).ready(function() {

        // flatpickr("#rango_fechas", {
        //     mode: "range",
        //     enableTime: false,
        //     dateFormat: "Y-m-d", 
        //     locale:"es",
        //     onChange: function (selectedDates, dateStr) {
        //         @this.set('rango_fechas', dateStr);
        //     }
        // });
        
        $('#rango_fechas').daterangepicker({
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
                days: 20
            },
        });
 
        $('#rango_fechas').on('change', function(event) {
            event.preventDefault();
            @this.set('rango_fechas', $(this).val());
        });

        $('#ejecutivos_select').select2();
        $('#ejecutivos_select').on('change', function (e) {
            var data = $('#ejecutivos_select').select2("val");
            @this.set('ejecutivos_select', data);
        });
        
        // Escuchar cambios en el Select2 y emitir el evento de Livewire
        // $('.custom-select').on('change', function (e) {
        //     @this.set('ejecutivos_select', e.target.value);
        // });
    });
</script>
@endsection