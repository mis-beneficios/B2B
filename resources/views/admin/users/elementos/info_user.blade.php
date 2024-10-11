<div class="card ">
    <div class="card-body">
        <div class="align-content-center">
            @if (Auth::user()->can('update', $user))
            <a class="btn btn-success btn-xs mr-1" data-user_id="{{ $user->id }}" href="{{ route('users.edit', $user->id) }}" id="btnEditarUser" type="button">
                {{  __('messages.user.show.editar') }}
            </a>
            @endif
            <button class="btn btn-dark btn-xs mr-1" data-user_id="{{ $user->id }}" id="btnLog" type="button">
                {{ __('messages.user.show.e_log') }}
            </button>
            @if (Auth::user()->can('delete', $user))
            <button class="btn btn-danger btn-xs" data-url="{{ route('users.destroy', $user->id) }}" data-user_id="{{ $user->id }}" id="btnEliminar" type="button">
                {{ __('messages.user.show.eliminar') }}
            </button>
            @endif

            @if (Auth::user()->can('historial', $user))
            <button class="btn btn-info btn-xs my-auto" data-user_id="{{ $user->id }}" id="btnHistorial" type="button">
                Cambios
            </button>
            @endif
        </div>
        <div class="historico m-t-10">
            <small class="text-muted">
                {{ __('messages.user.show.historico') }}:
            </small>
            <div id="showHistorial">
                {!! $historial !!}
            </div>
        </div>
    </div>
    <div>
        <hr>
        </hr>
    </div>
    <div class="card-body">
        <small class="text-muted">
            {{ __('messages.user.show.nombre') }}:
        </small>
        <h6>
            {{ $user->nombre }}
        </h6>
        <small class="text-muted">
            {{ __('messages.user.show.apellidos') }}:
        </small>
        <h6>
            {{ $user->apellidos }}
        </h6>
        <small class="text-muted">
            {{ __('messages.user.show.username') }}:
        </small>
        <h6>
            {{ $user->username }}
        </h6>
        @if (Auth::user()->role != 'sales')
        <small class="text-muted">
            {{ __('messages.user.show.empresa') }}:
        </small>
        <h6>
            {{ ($user->convenio) ? $user->convenio->empresa_nombre : 'N/A' }}
        </h6>
        <small class="text-muted">
            {{ __('messages.user.show.convenio') }}:
        </small>
        <h6>
            {{ ($user->convenio) ? $user->convenio->empresa_nombre : 'N/A' }}
        </h6>
        <small class="text-muted">
            {{ __('messages.user.show.registrado_por') }}:
        </small>
        <h6>
            {{ ($user->padre) ? $user->padre->title : 'S/R' }}
        </h6>
        <small class="text-muted">
            {{ __('messages.user.show.rol') }}:
        </small>
        <h6>
            {{ $user->role }}
        </h6>
        <small class="text-muted">
            {{ __('messages.user.show.created_at') }}:
        </small>
        <h6>
            {{ $user->created }}
        </h6>
        <small class="text-muted">
            {{ __('messages.user.show.updated_at') }}:
        </small>
        <h6>
            {{ $user->modified }}
        </h6>
        <small class="text-muted">
            {{ __('messages.user.show.direccion') }}:
        </small>
        <h6>
            {{ $user->direccion }}
        </h6>
        <small class="text-muted">
            {{ __('messages.user.show.direccion_alt') }}:
        </small>
        <h6>
            {{ $user->direccion2 }}
        </h6>
        <small class="text-muted">
            {{ __('messages.user.show.cp') }}:
        </small>
        <h6>
            {{ $user->codigo_postal }}
        </h6>
        <small class="text-muted">
            {{ __('messages.user.show.ciudad') }}:
        </small>
        <h6>
            {{ $user->ciudad }}
        </h6>
        <small class="text-muted">
            {{ __('messages.user.show.pais') }}:
        </small>
        <h6>
            {{ $user->pais }}
        </h6>
        <small class="text-muted">
            {{ __('messages.user.show.telefono') }}:
        </small>
        <h6>
            {{ $user->telefono }}
        </h6>
        <small class="text-muted">
            {{ __('messages.user.show.telefono_casa') }}:
        </small>
        <h6>
            {{ $user->telefono_casa }}
        </h6>
        <small class="text-muted">
            {{ __('messages.user.show.telefono_oficina') }}:
        </small>
        <h6>
            {{ $user->telefono_oficina }}
        </h6>
        <small class="text-muted">
            {{ __('messages.user.show.fecha_nacimiento') }}:
        </small>
        <h6>
            {{ $user->cumpleanos }}
        </h6>
        @endif
    </div>
</div>