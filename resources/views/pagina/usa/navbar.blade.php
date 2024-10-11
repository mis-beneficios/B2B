<div class="main_menu_iner">
    <div class="container">
        <div class="row align-items-center ">
            <div class="col-lg-12">
                <nav class="navbar navbar-expand-lg navbar-light justify-content-between">
                    @if (env('APP_ID') == 'usoptucorp')
                        @php
                            $url = 'https://optucorp.com/world/En_us'
                        @endphp
                    @elseif(env('APP_ID') == 'mytravel')
                    @php
                     
                     // $url = 'https://mytravel-benefits.com/'
                     $url = 'https://optucorp.com/world/En_us'
                     @endphp 
                    @else
                    @php
                         $url = 'https://beneficiosvacacionales.mx/'
                    @endphp
                    @endif
                    <a class="navbar-brand" href="{{ $url }}">
                        @if (env('APP_ID') == 'usoptucorp')
                        <img alt="" class="img-fluid" src="{{ asset('images/eu/op.png') }}" style="width: 8em">
                        </img>
                        @else
                        <img alt="" class="img-fluid" src="{{ asset('images/eu/my_travel.png') }}" style="width: 6em">
                        </img>
                        @endif
                        {{--
                        <img alt="logo" src="{{ asset('images/eu/my_travel.png') }}" style="width: 6em"/>
                        --}}
                    </a>
                    <button aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation" class="navbar-toggler" data-target="#navbarSupportedContent" data-toggle="collapse" type="button">
                        <span class="navbar-toggler-icon">
                        </span>
                    </button>
                    <div class="collapse navbar-collapse main-menu-item justify-content-end" id="navbarSupportedContent">
                        <ul class="navbar-nav">
                            <li class="nav-item dropdown">
                                <a aria-expanded="false" aria-haspopup="true" class="nav-link dropdown-toggle" data-toggle="dropdown" href="{{ route('eu.nosotros') }}" id="navbarDropdown" role="button">
                                    About us
                                </a>
                                <div aria-labelledby="navbarDropdown" class="dropdown-menu justify-content-center">
                                    <a class="dropdown-item" href="{{ route('eu.nosotros') }}">
                                        About us
                                    </a>
                                    {{--
                                    <a class="dropdown-item" href="{{ route('eu.fraude') }}">
                                        Testimonials
                                    </a>
                                    --}}
                                    {{--
                                    <a class="dropdown-item" href="{{ route('bolsa_trabajo') }}">
                                        Bolsa de trabajo
                                    </a>
                                    --}}
                                </div>
                            </li>
                            {{--
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('eu.empresas_afiliadas') }}">
                                    Affiliated Companies
                                </a>
                            </li>
                            --}}
                                    {{--
                            <li class="nav-item dropdown">
                                <a aria-expanded="false" aria-haspopup="true" class="nav-link dropdown-toggle" data-toggle="dropdown" href="{{ route('mision') }}" id="navbarDropdown_1" role="button">
                                    Benefits
                                </a>
                                <div aria-labelledby="navbarDropdown_1" class="dropdown-menu justify-content-center">
                                    <a class="dropdown-item" href="#">
                                        Collaborators
                                    </a>
                                    <a class="dropdown-item" href="{{ route('eu.beneficios_empresa') }}">
                                        Companys
                                    </a>
                                    <a class="dropdown-item" href="{{ route('eu.beneficios_trabajadores') }}">
                                        Employees
                                    </a>
                                    <a class="dropdown-item" href="{{ route('eu.beneficios_trabajadores') }}">
                                        News
                                    </a>
                                </div>
                            </li>
                            --}}
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('eu.preguntas') }}">
                                    FAQ
                                </a>
                            </li>
                            {{--
                            <li class="nav-item dropdown">
                                <a aria-expanded="false" aria-haspopup="true" class="nav-link dropdown-toggle" data-toggle="dropdown" href="{{ route('eu.productos') }}" id="navbarDropdown" role="button">
                                    Products
                                </a>
                                <div aria-labelledby="navbarDropdown" class="dropdown-menu justify-content-center">
                                    <a class="dropdown-item" href="{{ route('eu.top_productos','eu') }}">
                                        Top in US
                                    </a>
                                    <a class="dropdown-item" href="{{ route('eu.top_productos','europa') }}">
                                        Top in Europa
                                    </a>
                                    <a class="dropdown-item" href="{{ route('eu.top_productos','caribe') }}">
                                        Top in Caribbean &
                                        <br/>
                                        South America
                                    </a>
                                    <a class="dropdown-item" href="{{ route('eu.exclusivos') }}">
                                        Exclusive destinations
                                    </a>
                                </div>
                            </li>
                            --}}
                            @auth()
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('dashboard') }}">
                                    Home
                                </a>
                            </li>
                            @else
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">
                                    Sign in
                                </a>
                            </li>
                            @endauth
                    
                                                {{--
                            <li class="nav-item dropdown">
                                <a aria-expanded="false" aria-haspopup="true" class="nav-link dropdown-toggle" data-toggle="dropdown" href="blog.html" id="navbarDropdown_2" role="button">
                                    Products
                                </a>
                                <div aria-labelledby="navbarDropdown_2" class="dropdown-menu justify-content-center">
                                    <a class="dropdown-item" href="{{ route('hoteles') }}">
                                        Hoteles amigos
                                    </a>
                                    <a class="dropdown-item" href="tour_details.html">
                                        Destinos en promoción
                                    </a>
                                </div>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('productos') }}">
                                    Nuestros productos
                                </a>
                            </li>
                            --}}
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
