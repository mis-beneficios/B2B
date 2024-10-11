<div>
    <div class="card">
        <div class="card-body">
            <div class="card-head">
                <div class="d-flex flex-wrap">
                    <div>
                        <h4 class="card-title">
                            Seguimiento a {{ $concal->empresa }}
                        </h4>
                    </div>
                    @if (Auth::user()->can('update', $concal))
                    <div class="ml-auto">
                        <button class="btn btn-dark btn-sm" wire:click="habilitarEdit">
                            <i class="fas fa-edit"></i>
                            Habilitar edición
                        </button>
                    </div>
                    @endif
                </div>
            </div>
             <form id="formConcal"  wire:submit.prevent="update">
                <input id="create_convenio" name="create_convenio" type="hidden" value="0"/>
                <div class="modal-body" id="modal-body">
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="inputPassword4">
                                Empresa
                            </label>
                            <input class="form-control" id="empresa" wire:model="empresa" @if ($ban_editar == false) readonly @endif  placeholder="Nombre de la empresa" type="text" value="{{ $concal->empresa }}">
                            </input>
                            <span class="text-danger error-empresa errors">
                            </span>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="inputEmail4">
                                Pagina web
                            </label>
                            <input class="form-control" id="pagina_web" wire:model="pagina_web" @if ($ban_editar == false) readonly @endif placeholder="Sitio web" type="text" value="{{ $concal->pagina_web }}">
                            </input>
                            <span class="text-danger error-pagina_web errors">
                            </span>
                        </div>
                        <div class="form-group col-md-8">
                            <label for="inputEmail4">
                                Giro
                            </label>
                            <input type="text" wire:model="giro", id="giro" @if ($ban_editar == false) readonly @endif class="form-control" value="{{ $concal->giro }}">
                            <span class="text-danger error-giro errors">
                            </span>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="inputEmail4">
                                Categoría
                            </label>
                          <select wire:model="categoria" id="categoria" class="form-control" @if ($ban_editar == false) disabled @endif>
                              <option value="A" {{ ($concal->categoria == 'A' ) ? 'selected' : '' }}>A < 100 empleados</option>
                              <option value="AA" {{ ($concal->categoria == 'AA' )? 'selected' : '' }}>AA 100 - 1000 empleados</option>
                              <option value="AAA" {{ ($concal->categoria == 'AAA') ? 'selected' : '' }}>AAA > 1000 empleados</option>
                          </select>
                            <span class="text-danger error-categoria errors">
                            </span>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="inputEmail4">
                                No. de empleados
                            </label>
                            <input class="form-control" id="no_empleados" @if ($ban_editar == false) readonly @endif wire:model="no_empleados" placeholder="# Empleados" type="text" value="{{ $concal->no_empleados }}">
                            </input>
                            <span class="text-danger error-no_empleados errors">
                            </span>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="inputEmail4">
                                Estado (CEDE)
                            </label>
                            <input class="form-control" id="estado" @if ($ban_editar == false) readonly @endif wire:model="estado" placeholder="Estado" type="text" value="{{ $concal->estado }}">
                            </input>
                            <span class="text-danger error-estado errors">
                            </span>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="inputEmail4">
                                Pais
                            </label>
                            <select class="form-control" id="paise_id" wire:model="paise_id" @if ($ban_editar == false) disabled @endif>
                                @foreach ($paises as $pais)
                                <option value="{{ $pais->id }}" @if ($pais->id == $concal->paise_id)
                                    selected
                                @endif>
                                    {{ $pais->title }}
                                </option>
                                @endforeach
                            </select>
                            <span class="text-danger error-paise_id errors">
                            </span>
                        </div>
                         <div class="form-group col-md-3">
                            <label for="inputEmail4">
                                Sucursales
                            </label>
                            <select class="form-control" id="sucursales" wire:model="sucursales" @if ($ban_editar == false) disabled @endif>
                                <option value="0" {{ ($concal->sucursales == 0) ? 'selected' : '' }}>NO</option>
                                <option value="1" {{ ($concal->sucursales == 1) ? 'selected' : '' }}>SI</option>
                            </select>
                            <span class="text-danger error-sucursales errors">
                            </span>
                        </div> 
                        <div class="form-group col-md-12">
                            <textarea wire:model="sucursal_lugar" id="sucursal_lugar" @if ($ban_editar == false) readonly @endif  class="form-control" rows="5">{{ $concal->sucursal_lugar }}</textarea>
                            <span class="text-danger error-sucursal_lugar errors">
                            </span>
                        </div>
                        <div class="form-group col-md-3">
                            <label for="inputEmail4">
                                Corporativo
                            </label>
                            <select class="form-control" id="corporativo" wire:model="corporativo" @if ($ban_editar == false) disabled @endif>
                                <option value="0" {{ ($concal->corporativo == 0) ? 'selected' : '' }}>NO</option>
                                <option value="1" {{ ($concal->corporativo == 1) ? 'selected' : '' }}>SI</option>
                            </select>
                            <span class="text-danger error-corporativo errors">
                            </span>
                        </div>
                        <div class="form-group col-md-3">
                            <label for="inputEmail4">
                                Uso de logotipo
                            </label>
                            <select class="form-control" id="autoriza_logo" wire:model="autoriza_logo" @if ($ban_editar == false) disabled @endif>
                                <option value="0" {{ ($concal->autoriza_logo == 0) ? 'selected' : '' }}>NO</option>
                                <option value="1" {{ ($concal->autoriza_logo == 1) ? 'selected' : '' }}>SI</option>
                            </select>
                            <span class="text-danger error-autoriza_logo errors">
                            </span>
                        </div>
                        <div class="col-md-3">
                            <label for="">
                                Redes sociales
                            </label>
                            <select wire:model="redes" id="redes" class="form-control" @if ($ban_editar == false) disabled @endif>
                                <option value="1" {{ ($concal->redes == 1) ? 'selected' : '' }}>NO</option>
                                <option value="2" {{ ($concal->redes == 2) ? 'selected' : '' }}>SI</option>
                            </select>
                        </div>
                        <div class="form-group col-md-3">
                            <label for="inputEmail4">
                                Método de pago
                            </label>
                            <select class="form-control" id="metodo_pago" wire:model="metodo_pago" @if ($ban_editar == false) disabled @endif>
                                <option value="Banca" {{ ($concal->metodo_pago == 'Banca') ? 'selected' : '' }}>Banca</option>
                                <option value="Nomina" {{ ($concal->metodo_pago == 'Nomina') ? 'selected' : '' }}>Nomina</option>
                            </select>
                            <span class="text-danger error-metodo_pago errors">
                            </span>
                        </div>
                        <div class="form-group col-md-12">
                            <label for="inputEmail4">
                                Estrategia de venta
                            </label>
                            <input type="text" wire:model="estrategia" id="estrategia" @if ($ban_editar == false) readonly @endif class="form-control" value="{{ $concal->estrategia }}">
                            <span class="text-danger error-estrategia errors">
                            </span>
                        </div>
                    </div>
                    <hr/>
                    <div class="form-row">
                        <div class="form-group col-md-3">
                            <label for="inputPassword4">
                                Siguiente llamada
                            </label>
                            <input autocomplete="off" class="form-control" id="siguiente_llamada" @if ($ban_editar == false) readonly @endif wire:model="siguiente_llamada" type="text" value="{{ $concal->siguiente_llamada }}">
                            </input>
                            <span class="text-danger error-siguiente_llamada errors">
                            </span>
                        </div>
                        <div class="form-group col-md-3">
                            <label for="inputPassword4">
                                Estatus
                            </label>
                            <select class="form-control " id="estatus" wire:model="estatus" @if ($ban_editar == false) disabled @endif >
                                {{-- onchange="confirmChange(this)" --}}
                                @foreach ($estatus_concal as $estatus => $key)
                                <option value="{{ $estatus }}" @if ($concal->estatus == $estatus) selected @endif>
                                    {{ $key }}
                                </option>
                                @endforeach
                            </select>
                            <span class="text-danger error-estatus errors">
                            </span>
                        </div>
                        <div class="form-group col-md-2">
                            <label for="inputPassword4">
                                Calificación
                            </label>
                            <select class="js-example-responsive js-states form-control " @if ($ban_editar == false) disabled @endif id="calificacion" wire:model="calificacion">
                                @for ($i = 0; $i <=10 ; $i++)
                                <option value="{{ $i }}" @if ($concal->calificacion == $i) selected @endif>
                                    {{ $i }}
                                </option>
                                @endfor
                            </select>
                            <span class="text-danger error-calificacion errors">
                            </span>
                        </div>

                        <div class="form-group col-md-3">
                            <label for="inputPassword4">
                                Conmutador
                            </label>
                            <input class="form-control" id="conmutador" wire:model="conmutador" @if ($ban_editar == false) readonly @endif type="text" value="{{ $concal->conmutador }}">
                            </input>
                            <span class="text-danger error-conmutador errors">
                            </span>
                        </div>
                    </div>
                    <hr/>
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label for="inputPassword4">
                                Contacto
                            </label>
                            <input class="form-control" id="contacto" wire:model="contacto" @if ($ban_editar == false) readonly @endif placeholder="Nombre del contacto" type="text" value="{{ $concal->contacto }}">
                            </input>
                            <span class="text-danger error-contacto errors">
                            </span>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="inputPassword4">
                                Puesto
                            </label>
                            <input class="form-control" id="puesto_contacto" wire:model="puesto_contacto" @if ($ban_editar == false) readonly @endif placeholder="Puesto del contacto" type="text" value="{{ $concal->puesto_contacto }}">
                            </input>
                            <span class="text-danger error-puesto_contacto errors">
                            </span>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="inputEmail4">
                                Teléfonos
                            </label>
                            <input class="form-control" id="telefonos" wire:model="telefonos" @if ($ban_editar == false) readonly @endif placeholder="" type="text" value="{{ $concal->telefonos }}">
                            </input>
                            <span class="text-danger error-telefonos errors">
                            </span>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="inputEmail4">
                                Correo electrónico
                            </label>
                            <input class="form-control" id="email" wire:model="email" @if ($ban_editar == false) readonly @endif placeholder="Correo electronico" type="text" value="{{ $concal->email }}">
                            </input>
                            <span class="text-danger error-email errors">
                            </span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-4">
                            <label for="inputPassword4">
                                Asistente
                            </label>
                            <input class="form-control" id="asistente" wire:model="asistente" @if ($ban_editar == false) readonly @endif placeholder="Nombre email del asistente" type="text" value="{{ $concal->asistente }}">
                            </input>
                            <span class="text-danger error-asistente errors">
                            </span>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="inputEmail4">
                                Teléfono(s)
                            </label>
                            <input class="form-control" id="asistenten_telefono" @if ($ban_editar == false) readonly @endif wire:model="asistenten_telefono" type="text" value="{{ $concal->asistenten_telefono }}">
                            </input>
                            <span class="text-danger error-asistenten_telefono errors">
                            </span>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="inputEmail4">
                                Correo Electrónico
                            </label>
                            <input class="form-control" id="asistente_email" @if ($ban_editar == false) readonly @endif wire:model="asistente_email" placeholder="" type="email" value="{{ $concal->asistente_email }}">
                            </input>
                            <span class="text-danger error-asistente_email errors">
                            </span>
                        </div>
                    </div>
                </div>
                @if ($ban_editar == true)
                <div class="modal-footer">
                    <button class="btn btn-primary btn-sm" type="submit">
                        Guardar
                    </button>
                </div>
                @endif
            </form>
        </div>
    </div>
</div>
@section('script')
<script>
    $('#siguiente_llamada').bootstrapMaterialDatePicker({
        weekStart: 0,
        time: false,
        lang: 'es',
    });
    $('body').on('change', '#estatus', function(event) {
        event.preventDefault();
        
        if($(this).val() == 'cerrado'){
            Swal.fire({
                title: 'Convenio',
                text: "¿Desea crearlo como nuevo registro de convenio?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Si',
                cancelButtonText: 'No'
            })
            .then((result) => {
                if (result.isConfirmed) {
                    Livewire.emit('crearConvenio', $(this).val());
                    Swal.fire(
                        '',
                        'Se creara la liga de compra correspondiente a esta empresa',
                        'success'
                        );
                }
            })
        }
    });
</script>
@endsection
