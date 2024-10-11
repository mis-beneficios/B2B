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
                    {{ Auth::user()->role }}: {{ Auth::user()->nombre }}
                </span>
            </a>
            <ul aria-expanded="false" class="collapse">
                <li>
                    <a aria-expanded="false" class="has-arrow " href="#">
                        Configuracion del sistema
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
                        <li>
                            <a href="{{ route('settings.index') }}">
                                General
                            </a>
                        </li>
      {{--                   <li>
                            <a href="{{ route('settings.almacenamiento') }}">
                                Almacenamiento
                            </a>
                        </li> --}}
                    </ul>
                </li>
                <li>
                    <a href="{{ route('actividades.index') }}">
                        Bitacora de actividades
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
                <li>
                    <a href="{{ route('contratos.bases') }}">
                        Bases
                    </a>
                </li>

                <li>
                    <a href="{{ route('incidencias.index') }}">
                        Inicios de sesión
                    </a>
                </li>
{{--                 <li>
                    <a href="{{ route('reportes') }}">
                        Reportes
                    </a>
                </li> --}}
            </ul>
        </li>
        <li>
            <a aria-expanded="false" class="has-arrow " href="{{ route('reservations.filtrados', 1) }}">
                <i class="fa fa-id-card">
                </i>
                <span class="hide-menu">
                    Reservaciones
                </span>
            </a>
            <ul aria-expanded="false" class="collapse">
                <li>
                    <a href="{{ route('reservations.index') }}">
                        Listado
                    </a>
                </li>
                <li>
                    <a href="{{ route('reservations.filtrados', 1) }}">
                        Filtrar reservaciones
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
                <li>
                    <a href="{{ route('cobranza.index') }}">
                        Terminal V3
                    </a>
                </li> 
                <li>
                    <a aria-expanded="false" class="has-arrow " href="#">
                        Buzon Serfin
                    </a>
                    <ul aria-expanded="false" class="collapse">
                        <li>
                            <a href="{{ route('cobranza.showActualizarSerfin') }}">
                                Buzon
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
                        Filtrados
                    </a>
                </li>
                <li>
                    <a href="{{ route('cobranza.exportar') }}">
                        Exportar contratos
                    </a>
                </li>
                <li>
                    <a href="{{ route('cards.index') }}">
                        Tarjetas
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
            <a aria-expanded="false" class="has-arrow " href="#">
                <i class="mdi mdi-file">
                </i>
                <span class="hide-menu">
                    Convenios
                </span>
            </a>
            <ul aria-expanded="false" class="collapse">
                <li>
                    <a href="{{ route('convenios.index') }}">
                        Listar convenios
                    </a>
                </li>
                <li>
                    <a href="{{ route('convenios.create') }}">
                        Nuevo convenio
                    </a>
                </li>
                <li>
                    <a href="{{ route('concals.index') }}">
                        Seguimientos (Empresas)
                    </a>
                </li>
                <li>
                    <a href="{{ route('sorteos.index') }}">
                        Sorteos
                    </a>
                </li>
                <li>
                    <a href="{{ route('campanas.index') }}">
                        Campañas
                    </a>
                </li>
            </ul>
        </li>
        {{--
        <li>
            <a aria-expanded="false" class="has-arrow " href="#">
                <i class="mdi mdi-file">
                </i>
                <span class="hide-menu">
                    Convenios
                </span>
            </a>
            <ul aria-expanded="false" class="collapse">
                <li>
                    <a href="app-calendar.html">
                        Drive
                    </a>
                </li>
                <li>
                    <a href="app-calendar.html">
                        Nuevo convenio
                    </a>
                </li>
                <li>
                    <a aria-expanded="false" class="has-arrow" href="#">
                        Estancias
                    </a>
                    <ul aria-expanded="false" class="collapse">
                        <li>
                            <a href="app-email.html">
                                Nueva estancia
                            </a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="app-chat.html">
                        Contratos
                    </a>
                </li>
                <li>
                    <a href="app-ticket.html">
                        Ventas
                    </a>
                </li>
                <li>
                    <a href="app-contact.html">
                        Llamadas
                    </a>
                </li>
                <li>
                    <a href="app-contact2.html">
                        Ventas RS
                    </a>
                </li>
            </ul>
        </li>
        --}}
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
                <li>
                    <a href="{{ route('users.show_admin') }}">
                        Administrativos
                    </a>
                </li>
                <li>
                    <a href="{{ route('users.show_clientes') }}">
                        Clientes
                    </a>
                </li>
                <li>
                    <a href="{{ route('equipos.index') }}">
                        Equipos de ventas
                    </a>
                </li>
            </ul>
        </li>
{{--         <li>
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
        </li>
 --}}        <li>
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
        </li>
   {{--      <li>
            <a aria-expanded="false" class="has-arrow " href="{{ route('raspaldo_calidad') }}">
                <i class="mdi mdi-gauge">
                </i>
                <span class="hide-menu">
                    Calidades
                </span>
            </a>
        </li> --}}
        @include('layouts.admin.menus.btnZoom')
        <li>
            <a class="has-arrow" data-target="#modalBuscarCliente"  id="modalBClient" data-toggle="modal" style="cursor: pointer;">
                <span class="hide-menu">
                    <i class="fa fa-search">
                    </i>
                    Buscar
                </span>
            </a>
        </li>
    </ul>
</nav>
