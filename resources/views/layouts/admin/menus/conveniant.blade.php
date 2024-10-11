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
                    <a href="{{ route('concals.index') }}">
                        Seguimientos (Empresas)
                    </a>
                </li>
                <li>
                    <a href="{{ route('ventas') }}">
                        Consultar ventas
                    </a>
                </li>
                <li>
                    <a href="{{ route('alertas') }}">
                        Alertas
                    </a>
                </li>
                <li>
                    <a href="{{ route('comisiones.index') }}">
                        Comisiones
                    </a>
                </li>
            </ul>
        </li>
        <li>
            <a aria-expanded="false" class="has-arrow" href="{{ route('convenios.index') }}">
                <i class="fas fa-file-pdf">
                </i>
                <span class="hide-menu">
                    Convenios
                </span>
            </a>
        </li>
        <li>
            <a class="has-arrow" href="{{ route('actividades.index') }}">
                <i class="fas fa-pencil-square-o">
                </i>
                <span class="hide-menu">
                    Actividades
                </span>
            </a>
        </li>
        <li>
            <a class="has-arrow" href="{{ route('sorteos.index') }}">
                <i class="fas fa-trophy">
                </i>
                <span class="hide-menu">
                    Sorteos
                </span>
            </a>
        </li>
        <li>
            <a class="has-arrow" href="{{ route('campanas.index') }}">
                <i class="fas fa-bell">
                </i>
                <span class="hide-menu">
                    Campañas
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
