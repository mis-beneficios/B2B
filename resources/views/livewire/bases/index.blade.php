<div>
    <div class="row">
        <div class="col-md">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title m-b-0">
                        Filtrar bases
                    </h4>
                </div>
                <div class="card-body">
                    <form wire:submit.prevent="getFiltrado">
                        <div class="form-row">
                            <div class="form-group col-lg-2 col-md-3">
                                <label for="fecha_inicio">
                                    Fecha inicio
                                </label>
                                <input type="text" id="fecha_inicio" autocomplete="off" wire:model.defer="fecha_inicio"  class="form-control datepicker"/> 
                                @error('fecha_inicio') <small class="error text-danger">{{ $message }}</small> @enderror
                            </div>
                            <div class="form-group col-lg-2 col-md-3">
                                <label for="fecha_fin">
                                    Fecha fin
                                </label>
                                <input type="text" id="fecha_fin" autocomplete="off" wire:model.defer="fecha_fin"  class="form-control datepicker"/>
                                 @error('fecha_fin') <small class="error text-danger">{{ $message }}</small> @enderror
                            </div>

                            <div class="form-group col-lg-8 col-md-6" wire:ignore>
                                <label for="inputPassword4">
                                    Estatus
                                </label>
                                <select class="form-control custom-select select2 m-b-10 select2-multiple select2-hidden-accessible" multiple="" id="estatus_contratos" style="width: 100%;">
                                    <option value="all">Todos</option>
                                    @foreach ($estatus_contratos as $contrato)
                                    <option value="{{ $contrato->estatus }}">
                                        {{ $contrato->estatus }}
                                    </option>
                                    @endforeach
                                </select>
                                 @error('estatus') <span class="error text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-12" wire:ignore>
                                <label for="inputPassword4">
                                    Ejecutivos
                                </label>
                                <select class="form-control custom-select select2 m-b-10 select2-multiple select2-hidden-accessible" multiple="" id="ejecutivos_select" style="width: 100%;">
                                    <option value="all">Todos</option>
                                    @foreach ($ejecutivos as $ejecutivo)
                                    <option value="{{ $ejecutivo->username }}">
                                        {{ $ejecutivo->fullName .' '. $ejecutivo->username}}
                                    </option>
                                    @endforeach
                                </select>
                                 @error('ejecutivos_select') <span class="error text-danger">{{ $message }}</span> @enderror
                            </div>
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
    </div>
</div>
@section('script')
<script>    
    $(document).ready(function() {
        $('#fecha_inicio').on('change', function(event) {
            event.preventDefault();
            @this.set('fecha_inicio', $(this).val());
        });

        $('#fecha_fin').on('change', function(event) {
            event.preventDefault();
            @this.set('fecha_fin', $(this).val());
        });

        $('#ejecutivos_select').select2();
        $('#ejecutivos_select').on('change', function (e) {
            var data = $('#ejecutivos_select').select2("val");
            @this.set('ejecutivos_select', data);
        });
        $('#estatus_contratos').select2();
        $('#estatus_contratos').on('change', function (e) {
            var data = $('#estatus_contratos').select2("val");
            @this.set('estatus', data);
        });
        
    });
</script>
@endsection