<nav class="sidebar-nav">
    <ul id="sidebarnav">
        <li>
            <a aria-expanded="false" class="has-arrow" href="{{ route('dashboard') }}">
                <i class="fas fa-tachometer-alt">
                </i>
                <span class="hide-menu">
                    {{ __('messages.cliente.inicio') }}
                </span>
            </a>
        </li>
        <li>
            <a aria-expanded="false" class="has-arrow" href="{{ route('paquetes.index') }}">
                <i class="fa fa-hotel">
                </i>
                <span class="hide-menu">
                    {{ __('messages.cliente.mis_paquetes') }}
                </span>
            </a>
        </li>
        <li>
            <a aria-expanded="false" class="has-arrow" href="{{ route('tarjetas.index') }}">
                <i class="fas fa-credit-card">
                </i>
                <span class="hide-menu">
                    {{ __('messages.cliente.tarjetas') }}
                </span>
            </a>
        </li>
        <li>
            <a aria-expanded="false" class="has-arrow" href="{{ route('reservaciones.index') }}">
                <i class="fa fa-calendar">
                </i>
                <span class="hide-menu">
                    {{ __('messages.cliente.reservaciones') }}
                </span>
            </a>
        </li>
    </ul>
</nav>