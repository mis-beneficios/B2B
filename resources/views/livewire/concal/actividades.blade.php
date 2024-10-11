<div>
    <div class="row mb-2">
        @if (Auth::user()->can('view', $seguimiento))
        <div class="col-md">
            <button class="btn btn-info btn-sm"  wire:click="showForm()"><i class="fas fa-plus"></i> Agregar actividad</button>
            <button class="btn btn-success btn-sm"  wire:click="showActividad()"><i class="fas fa-eye"></i> Ver actividades</button>
        </div>
        @endif
        @if ($show_form == true)
        <div class="col-md-12">
            <div class="card mt-2">
                <div class="card-body">
                    <h4 class="card-title">
                        Registrar nueva actividad
                    </h4>
                    <form  wire:submit.prevent="save" role="form" id="formActividad">
                        <div class="form-group">
                            {{-- <label for="">Actividad</label> --}}
                            <textarea wire:model="actividad_text" class="form-control summernote" id="actividad_text" rows="7"></textarea>
                        </div>
                        <button class="btn btn-primary btn-sm">Guardar</button>
                    </form>
                </div>
            </div>
        </div>
        @endif
        @if ($show_actividades == true)
        <div class="col-md-12">
            <div class="card mt-2">
                <div class="card-body">
                <div class="card-head">
                    <h4 class="card-title">
                        Historial de actividades
                    </h4>
                </div>
                    <div class="list-group">
                    @foreach ($seguimiento->actividades as $actividad)
                        <li class="list-group-item list-group-item-action">
                          <div class="d-flex w-100 justify-content-between">
                            <h5 class="mb-1">{{ $actividad->user->nombre .' '. $actividad->user->apellidos }}</h5>
                            <small class="text-white badge badge-info">{{ $actividad->created_at }}</small>
                          </div>
                          <p class="mb-2 mt-1">
                            {!! $actividad->notas !!}
                          </p>
                          {{-- <small class="text-muted">Donec id elit non mi porta.</small> --}}
                        </li>
                    @endforeach 
                        <li class="list-group-item list-group-item-action">
                            <div class="d-flex w-100 justify-content-between">
                            <h5 class="mb-1">{{ $seguimiento->user->fullName }}</h5>
                                <small class="text-white badge badge-info">{{ $seguimiento->modified }}</small>
                            </div>
                            <p class="mb-1">
                                {!! $seguimiento->observaciones !!}  
                            </p>
                            {{-- <small class="text-muted">Donec id elit non mi porta.</small> --}}
                        </li>              
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>

@push('script')
<script>

    $('#actividad_text').summernote();
    document.addEventListener('livewire:load', function () {
        Livewire.on('showForm', () => {
            $('#actividad_text').summernote();
        });
    });
</script>
@endpush

