<nav class="sidebar-nav">
    <ul id="sidebarnav">
        <li>
            <a aria-expanded="false" class="has-arrow " href="{{ route('dashboard') }}">
                <i class="mdi mdi-gauge">
                </i>
                <span class="hide-menu">
                    Inicio
                </span>
            </a>
        </li>
        <li>
            <a class="has-arrow" href="{{ route('reservations.filtrados', 1) }}">
                <i class="fa fa-user">
                </i>
                <span class="hide-menu">
                    <strong class="text-capitalize">
                        {{ Auth::user()->perfil }}
                    </strong>
                    : {{ Auth::user()->fullName }}
                </span>
            </a>
        </li>
        {{--
        <li>
            <a aria-expanded="false" class="has-arrow" href="{{ route('destinos.index') }}">
                <i class="fa fa-plane">
                </i>
                <span class="hide-menu">
                    Destinos
                </span>
            </a>
        </li>
        --}}
        <li>
            <a class="has-arrow" href="{{ route('regiones.index') }}">
                <i class="fas fa-globe">
                </i>
                Regiones
            </a>
        </li>
        <li>
            <a class="has-arrow" href="{{ route('users.clientes') }}">
                <i class="fas fa-user">
                </i>
                <span class="hide-menu">
                    Cientes
                </span>
            </a>
        </li>
        {{--
        <li>
            <a class="has-arrow" href="#">
                <i class="fas fa-check-circle">
                </i>
                <span class="hide-menu">
                    Concurso
                </span>
            </a>
        </li>
        --}}
        @include('layouts.admin.menus.btnZoom')
        <li>
            <a class="has-arrow" data-target="#modalBuscarCliente" data-toggle="modal" type="button">
                <i class="fa fa-search">
                </i>
                <span class="hide-menu">
                    Buscar
                </span>
            </a>
        </li>
    </ul>
</nav>