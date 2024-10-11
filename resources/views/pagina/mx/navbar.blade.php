<div class="main_menu_iner">
    <div class="container">
        <div class="row align-items-center ">
            <div class="col-lg-12">
                <nav class="navbar navbar-expand-lg navbar-light justify-content-between">
                    <a class="navbar-brand" href="{{ url('/') }}">
                        <img alt="logo" src="{{ asset('images/mis_beneficios.png') }}" style="width: 8em"/>
                    </a>
                    <button aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation" class="navbar-toggler" data-target="#navbarSupportedContent" data-toggle="collapse" type="button">
                        <span class="navbar-toggler-icon">
                        </span>
                    </button>
                    <div class="collapse navbar-collapse main-menu-item justify-content-end" id="navbarSupportedContent">
                        <ul class="navbar-nav">
                            <li class="nav-item dropdown">
                                <a aria-expanded="false" aria-haspopup="true" class="nav-link dropdown-toggle" data-toggle="dropdown" href="{{ route('nosotros') }}" id="navbarDropdown" role="button">
                                    {{--
                                    <strong>
                                        --}}
                                        Nosotros
                                    {{--
                                    </strong>
                                    --}}
                                </a>
                                <div aria-labelledby="navbarDropdown" class="dropdown-menu justify-content-center">
                                    <a class="dropdown-item" href="{{ route('nosotros') }}">
                                        ¿Quienes somos?
                                    </a>
                                    <a class="dropdown-item" href="{{ route('fraude') }}">
                                        Alerta de fraude
                                    </a>
                                    {{--
                                    <a class="dropdown-item" href="{{ route('mision') }}">
                                        Mision y Valores
                                    </a>
                                    --}}
                                    <a class="dropdown-item" href="{{ route('preguntas') }}">
                                        Preguntas frecuentes
                                    </a>
                                    <a class="dropdown-item" href="https://bolsa.misbeneficiosvacacionales.com/" target="_blank">
                                        Bolsa de trabajo
                                    </a>
                                </div>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('empresas_afiliadas') }}">
                                    Empresas afiliadas
                                </a>
                            </li>
                            <li class="nav-item dropdown">
                                <a aria-expanded="false" aria-haspopup="true" class="nav-link dropdown-toggle" data-toggle="dropdown" href="{{ route('mision') }}" id="navbarDropdown_1" role="button">
                                    Beneficios
                                </a>
                                <div aria-labelledby="navbarDropdown_1" class="dropdown-menu justify-content-center">
                                    <a class="dropdown-item" href="{{ route('login') }}">
                                        Familia
                                        <b>
                                            MBV
                                        </b>
                                    </a>
                                    <a class="dropdown-item" href="{{ route('beneficios_empresa') }}">
                                        Empresas
                                    </a>
                                    <a class="dropdown-item" href="{{ route('beneficios_trabajadores') }}">
                                        Trabajadores
                                    </a>
                                </div>
                            </li>
                            {{--
                            <li class="nav-item">
                                <a class="nav-link" href="https://pacifictravels.mx/cotizaciones.html" target="_blank">
                                    Cotizador
                                </a>
                            </li>
                            --}}
                            <li class="nav-item dropdown">
                                <a aria-expanded="false" aria-haspopup="true" class="nav-link dropdown-toggle" data-toggle="dropdown" href="{{ route('hoteles') }}" id="navbarDropdown_2" role="button">
                                    Hoteles
                                </a>
                                <div aria-labelledby="navbarDropdown_2" class="dropdown-menu justify-content-center">
                                    <a class="dropdown-item" href="{{ route('hoteles') }}">
                                        Hoteles amigos
                                    </a>
                                    {{--
                                    <a class="dropdown-item" href="#">
                                        Destinos en promoción
                                    </a>
                                    --}}
                                </div>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('productos') }}">
                                    Nuestros productos
                                </a>
                            </li>
                            @auth()
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('dashboard') }}">
                                    Inicio
                                </a>
                            </li>
                            @else
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">
                                    Iniciar Sesion
                                </a>
                            </li>
                            @endauth
                        </ul>
                    </div>
                    {{--
                    <a class="btn_1 d-none d-lg-block" href="#">
                        book now
                    </a>
                    --}}
                </nav>
            </div>
        </div>
    </div>
</div>
