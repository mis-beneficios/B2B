<div>
    <div class="row">
        <div class="col-lg-3 col-md-5">
            <div class="card">
                <div class="card-body">
                    <input type="text" wire:model="fecha"  id="fecha" class="form-control datepicker"> 
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>
                                        Ejecutivo
                                    </th>
                                    <th>
                                        Empresas
                                    </th>
                                    <th>
                                        Actividades
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach ($ejecutivos as $ejecutivo)
                                <tr>
                                    <td>
                                        {{ $ejecutivo->nombre }}
                                    </td>
                                    <td>
                                        <button class="btn btn-sm btn-info" wire:click="listarEmpresas({{ $ejecutivo->id }}, '0')" data-id="{{ $ejecutivo->id }}">
                                            {{ $ejecutivo->empresas }}
                                        </button>
                                    </td>
                                    <td>
                                        <button class="btn btn-sm btn-primary" wire:click="listarActividades({{ $ejecutivo->id }}, '0')" data-id="{{ $ejecutivo->id }}">
                                            {{ $ejecutivo->actividades }}
                                        </button>
                                    </td>
                                </tr>
                            @endforeach    
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="{{ $div_empresas }}"  wire:ingnore>
            <div class="row">
                @if ($ver_empresas == true)
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">
                                Empresa registradas el día {{ $fecha }}: 
                            </h4>
                            @foreach ($seguimientos as $empresa)
                                <div class="col-lg-12 {{ $empresa->id == $concal_id ? "badge-info p-2" :"" }}">
                                    <h4 class="card-title text-dark">{{ $empresa->empresa }}</h4>
                                    <address>
                                        {{-- <strong>Twitter, Inc.</strong> --}}
                                        <br> Creado: <b>{{ $empresa->created }}</b>
                                        <br> Contacto: <b>{{ $empresa->contacto }}</b>
                                        <br> Teléfono: <b>{{ $empresa->telefonos }}</b>
                                        <br> Email: <b>{{ $empresa->email }}</b>
                                        <br> Web: <b>{{ $empresa->pagina_web }}</b>
                                        <br> Estado: <b>{{ $empresa->estado }}</b>
                                        <br> Categoria: <b>{{ $empresa->categoria }}</b>
                                        <br>
                                        <button class="btn btn-sm btn-info"  wire:click="actividadesEmpresa({{ $empresa->id }})" data-id="{{ $ejecutivo->id }}">
                                            <i class="fas fa-eye"></i>
                                            Ver actividades
                                        </button>   
                                    </address>
                                </div>
                                <hr>
                            @endforeach
                        </div>
                    </div>
                </div>
                @endif


                @if ($ver_actividades == true)
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">
                                Historial de actividades del día {{ $fecha }}
                            </h4>
                            <div class="list-group">
                            @foreach ($actividades as $actividad)
                                <li class="list-group-item list-group-item-action">
                                  <div class="d-flex w-100 justify-content-between">
                                    <h5 class="mb-1">{{ $actividad->user->nombre .' '. $actividad->user->apellidos }}</h5>
                                    <small class="text-white badge badge-info">{{ $actividad->created_at }}</small>
                                  </div>
                                    <small class="badge badge-secondary">{{ $actividad->concal->empresa }}</small>
                                  <p class="mb-2 mt-1">
                                    {!! $actividad->notas !!}
                                  </p>
                                </li>
                            @endforeach       
                            </div>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
        @if ($ver_actividades_empresa == true)
        <div class="col-md" wire:ingnore>
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">
                        Historial de actividades del día {{ $fecha }}
                    </h4>
                    <div class="list-group">
                    @foreach ($actividadesEmpresaList as $actividad)
                        <li class="list-group-item list-group-item-action">
                          <div class="d-flex w-100 justify-content-between">
                            <h5 class="mb-1">{{ $actividad->user->nombre .' '. $actividad->user->apellidos }}</h5>
                            <small class="text-white badge badge-info">{{ $actividad->created_at }}</small>
                          </div>
                           <small class="badge badge-secondary">{{ $actividad->concal->empresa }}</small>
                          <p class="mb-2 mt-1">
                            {!! $actividad->notas !!}
                          </p>
                        </li>
                    @endforeach       
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>

@section('script')
<script>
    $('#fecha').on('change', function(event) {
        event.preventDefault();
        @this.set('fecha', $(this).val());
    });
</script>
@endsection