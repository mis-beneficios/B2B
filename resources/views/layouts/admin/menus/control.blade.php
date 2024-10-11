<nav class="sidebar-nav">
    <ul id="sidebarnav">
        <li class="nav-small-cap">
            PERSONAL
        </li>
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
            <a aria-expanded="false" class="has-arrow" href="#">
                <i class="fa fa-user">
                </i>
                <span class="hide-menu">
                    <strong class="text-capitalize">
                        {{ Auth::user()->perfil }}
                    </strong>
                    : {{ Auth::user()->fullName }}
                </span>
            </a>
            <ul aria-expanded="false" class="collapse">
                <li>
                    <a href="{{ route('users.index') }}">
                        Mis usuarios registrados
                    </a>
                </li>
                <li>
                    <a href="{{ route('contratos.index') }}">
                        Mis contratos generados
                    </a>
                </li>
                <li>
                    <a href="{{ route('comisiones.index') }}">
                        Comisiones
                    </a>
                </li>
    {{--             <li>
                    <a href="{{ route('respaldo_calidad') }}">
                        Respaldo de calidad
                    </a>
                </li> --}}
            </ul>
        </li>
        <li>
            <a aria-expanded="false" class="has-arrow" href="#">
                <i class="fas fa-file-pdf">
                </i>
                <span class="hide-menu">
                    Contratos
                </span>
            </a>
            <ul aria-expanded="false" class="collapse">
                <li>
                    <a href="{{ route('contratos.listar_contratos') }}">
                        Por autorizar
                    </a>
                </li>
            </ul>
        </li>
        <li>
            <a class="has-arrow" href="{{ route('users.create') }}">
                <i class="fas fa-user">
                </i>
                <span class="hide-menu">
                    Registrar Usuario
                </span>
            </a>
        </li>
        @include('layouts.admin.menus.btnZoom')
        <li>
            <a class="has-arrow" data-target="#modalBuscarCliente" data-toggle="modal" style="cursor: pointer;">
                <span class="hide-menu">
                    <i class="fa fa-search">
                    </i>
                    Buscar
                </span>
            </a>
        </li>
    </ul>
</nav>
