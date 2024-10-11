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
        <li class="">
            <a aria-expanded="false" class="has-arrow " href="#">
                <i class="fas fa-user">
                </i>
                <span class="hide-menu text-capitalize">
                    {{ Auth::user()->perfil }}: {{ Auth::user()->nombre }}
                </span>
            </a>
            <ul aria-expanded="false" class="collapse">
                <li>
                    <a aria-expanded="false" class="has-arrow " href="#">
                        Configuración del sistema
                    </a>
                    <ul aria-expanded="false" class="collapse">
                        <li>
                            <a href="{{ route('bancos.index') }}">
                                Lista de bancos
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('regiones.index') }}">
                                Regiones
                            </a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="{{ route('ventas') }}">
                        Consultar ventas
                    </a>
                </li>
            </ul>
        </li>
        <li>
            <a aria-expanded="false" class="has-arrow " href="{{ route('cobranza.index') }}">
                <i class="fas fa-money-bill-wave-alt">
                </i>
                Cobranza
            </a>
            <ul aria-expanded="false" class="collapse">
                <li>
                    <a href="{{ route('cobranza.terminal') }}">
                        Terminal
                    </a>
                </li>
                @if (Auth::user()->username != 'cobranza@optucorp.com')
                <li>
                    <a href="{{ route('cobranza.index') }}">
                        Terminal V3
                    </a>
                </li>
                @endif
              {{--   <li>
                    <a aria-expanded="false" class="has-arrow " href="#">
                        Buzon Serfin
                    </a>
                    <ul aria-expanded="false" class="collapse">
                        <li>
                            <a href="{{ route('cobranza.showActualizarSerfin') }}">
                                Actualizar sistema
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('cobranza.cargar_archivo') }}">
                                Cargar archivo
                            </a>
                        </li>
                    </ul>
                </li> --}}
                {{-- <li>
                    <a href="{{ route('cobranza.filtrado_cobranza') }}">
                        Filtrados
                    </a>
                </li> --}}
                <li>
                    <a href="{{ route('cobranza.exportar') }}">
                        Exportar contratos
                    </a>
                </li>
 {{--                <li>
                <li>
                    <a href="#">
                        Generar cobros
                    </a>
                </li>
                    <a href="{{ route('cards.index') }}">
                        Tarjetas
                    </a>
                </li>
                <li>
                    <a aria-expanded="false" class="has-arrow " href="#">
                        Comisiones
                    </a>
                    <ul aria-expanded="false" class="collapse">
                        <li>
                            <a href="icon-material.html">
                                Actualizar comisiones
                            </a>
                        </li>
                        <li>
                            <a href="icon-fontawesome.html">
                                Pagar comisinoes
                            </a>
                        </li>
                    </ul>
                </li> --}}
            </ul>
        </li>
        <li>
            <a aria-expanded="false" class="has-arrow " href="{{ route('cobranza.buzon') }}">
                <i class="fas  fa-inbox"></i>
                Buzón Serfin
            </a>
            <ul aria-expanded="false" class="collapse">
                <li>
                    <a href="{{ route('cobranza.showActualizarSerfin') }}">
                        Buzón
                    </a>
                </li>
                <li>
                    <a href="{{ route('cobranza.cargar_archivo') }}">
                        Cargar archivo
                    </a>
                </li>
                <li>
                    <a href="{{ route('cobranza.historico') }}">
                        Historico
                    </a>
                </li>
            </ul>
        </li>
        <li>
            <a href="{{ route('cobranza.filtrado_cobranza') }}">
                <i class="fas fa-filter">
                </i>
                <span class="hide-menu">
                    Filtrados
                </span>
            </a>
        </li>
        <li>
            <a  class="has-arrow " href="{{ route('convenios.index') }}">
                <i class="mdi mdi-file">
                </i>
                <span class="hide-menu">
                    Convenios
                </span>
            </a>
        </li>
        <li>
            <a aria-expanded="false" class="has-arrow" href="#">
                <i class="fa fa-users">
                </i>
                <span class="hide-menu">
                    Usuarios
                </span>
            </a>
            <ul aria-expanded="false" class="collapse">
                <li>
                    <a class="" href="{{ route('users.create') }}">
                        Registrar nuevo usuario
                    </a>
                </li>
            </ul>
        </li>
        {{-- <li>
            <a aria-expanded="false" class="has-arrow" href="#">
                <i class="fa fa-plane">
                </i>
                <span class="hide-menu">
                    Destinos
                </span>
            </a>
            <ul aria-expanded="false" class="collapse">
                <li>
                    <a class="" href="{{ route('destinos.index') }}">
                        Listar
                    </a>
                </li>
                <li>
                    <a href="{{ route('destinos.create') }}">
                        Crear
                    </a>
                </li>
            </ul>
        </li> --}}
       {{--  <li>
            <a aria-expanded="false" class="has-arrow" href="#">
                <i class="fa fa-hotel">
                </i>
                <span class="hide-menu">
                    Estancias
                </span>
            </a>
            <ul aria-expanded="false" class="collapse">
                <li>
                    <a class="" href="{{ route('estancias.index') }}">
                        Listar
                    </a>
                </li>
                <li>
                    <a href="{{ route('estancias.create') }}">
                        Crear
                    </a>
                </li>
            </ul>
        </li> --}}
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
