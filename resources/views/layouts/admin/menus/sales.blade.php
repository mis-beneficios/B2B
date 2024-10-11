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
                        Mis comisiones
                    </a>
                </li>
            </ul>
        </li>
        <li>
            <a aria-expanded="false" class="has-arrow" href="{{ route('convenios.index') }}">
                <i class="fa fa-file-pdf-o">
                </i>
                <span class="hide-menu">
                    Convenios
                </span>
            </a>
        </li>
        <li>
            <a class="has-arrow" href="{{ route('users.create') }}">
                <i class="fas fa-user-plus">
                </i>
                <span class="hide-menu">
                    Registrar Usuario
                </span>
            </a>
        </li>
        {{--
        <li>
            <a class="has-arrow" href="#">
                <i class="fas fa-receipt">
                </i>
                <span class="hide-menu">
                    Concurso
                </span>
            </a>
        </li>
        --}}
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