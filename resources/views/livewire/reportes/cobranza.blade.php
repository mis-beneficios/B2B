<div>
    <form wire:submit.prevent="get_filter">
        <div class="form-body">
            <div class="row">
                <div class="col-md-2">
                    <div class="form-group">
                        <label class="control-label">Fecha de inicio</label>
                        <input type="text" id="fecha_inicio" autocomplete="off" wire:model="fecha_inicio"  class="form-control">
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label class="control-label">Fecha de fin</label>
                        <input type="text" id="fecha_fin" autocomplete="off" wire:model="fecha_fin"  class="form-control">
                    </div>
                </div>
               {{--  <div class="col-md-3">
                    <div class="form-group">
                        <label class="control-label">Estatus</label>
                        <select class="form-control custom-select"  wire:model="estatus" >
                            <option value="">Selecciona una opción</option>
                            <option value="act">
                                Activos
                            </option>
                            @foreach ($estatus_contratos as $es)
                                <option value="{{ $es->estatus }}">{{ $es->estatus }}</option>
                            @endforeach
                        </select>
                    </div>
                </div> --}}

            </div>
        </div>
        <div class="form-actions">
            <button type="submit" class="btn btn-success"> <i class="fa fa-check"></i> Filtrar</button>
        </div>
    </form>

   <div class="row">
        @if ($ver_activos == true)
        <div class="col-lg-3 col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex flex-row">
                        <div class="round round-lg align-self-center round-info align-content-between justify-content-between"><i class="fas fa-users"></i></div>
                        <div class="m-l-10 align-self-center">
                            <h3 class="m-b-0 font-light">{{ count($activos) }}</h3>
                            <h5 class="text-muted m-b-0">Usuarios activos</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif
        <!-- Column -->
        <!-- Column -->
        @if ($ver_viajados == true)
        <div class="col-lg-3 col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex flex-row">
                        <div class="round round-lg align-self-center round-warning"><i class="mdi mdi-cellphone-link"></i></div>
                        <div class="m-l-10 align-self-center">
                            <h3 class="m-b-0 font-lgiht">{{ count($viajados) }}</h3>
                            <h5 class="text-muted m-b-0">Folios viajados</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif
        <!-- Column -->
        <!-- Column -->
       {{--  <div class="col-lg-3 col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex flex-row">
                        <div class="round round-lg align-self-center round-primary"><i class="mdi mdi-cart-outline"></i></div>
                        <div class="m-l-10 align-self-center">
                            <h3 class="m-b-0 font-lgiht">$1795</h3>
                            <h5 class="text-muted m-b-0">Offline Revenue</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Column -->
        <!-- Column -->
        <div class="col-lg-3 col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex flex-row">
                        <div class="round round-lg align-self-center round-danger"><i class="mdi mdi-bullseye"></i></div>
                        <div class="m-l-10 align-self-center">
                            <h3 class="m-b-0 font-lgiht">$687</h3>
                            <h5 class="text-muted m-b-0">Ad. Expense</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div> --}}
        <!-- Column -->
    </div>
</div>


 <script>
    document.addEventListener('livewire:load', function () {
        flatpickr("#fecha_inicio", {
            enableTime: false,
            dateFormat: "Y-m-d", 
            locale:"es",
            onChange: function (selectedDates, dateStr) {
                @this.set('fecha_inicio', dateStr);
            }
        });

        flatpickr("#fecha_fin", {
            enableTime: false,
            dateFormat: "Y-m-d", 
            locale:"es",
            onChange: function (selectedDates, dateStr) {
                @this.set('fecha_fin', dateStr);
            }
        });
    });
</script>