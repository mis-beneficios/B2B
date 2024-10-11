<footer class="footer-area">
    <div class="container">
        {{-- @if (config('app.empresa') == 'mb') --}}
        <div class="row justify-content-between">
            <div class="col-sm-4 col-md-4">
                <img alt="" class="img-fluid" src="{{ asset('images/mis_beneficios.png') }}">
                </img>
                <div class="single-footer-widget footer_icon mt-3">
                    {{--
                    <h4>
                        {{ env('APP_NAME') }}
                    </h4>
                    --}}
                    <p>
                        Heriberto Frías #408, Interior 3, Colonia Narvarte Poniente CDMX. CP: 03020
                    </p>
                    @if (request()->getRequestUri() == '/empresas-afiliadas' || request()->getRequestUri() == '/beneficios-empresa'|| request()->getRequestUri() == '/beneficios-trabajadores'|| request()->getRequestUri() == '/conoce-nuestros-beneficios'|| request()->getRequestUri() == '/documentos-legales'|| request()->getRequestUri() == '/demo-flyer/modulo_3'|| request()->getRequestUri() == '/demo-flyer/modulo_7')
                    <span>
                        Teléfono:
                        <br/>
                        <a href="tel:3222938146">
                            Guadalupe Arevalo: 322 293 8146
                        </a>
                        <br/>
                        <a href="tel:5586626071">
                            Susana Lopez: 55 866 260 71
                        </a>
                    </span>
                    @else
                    <span>
                        Teléfono sin costo desde el interior:
                        <br/>
                        <a href="tel:5589263266">
                            5589263266
                        </a>
                        <br/>
                        <a href="tel:5541708423">
                            5541708423
                        </a>
                    </span>
                    <br>
                    <br>
                    <span>
                        Atención al cliente
                        <a href="mailto:atencionalcliente@beneficiosvacacionales.mx">atencionalcliente@beneficiosvacacionales.mx</a>
                    </span>
                    @endif
                    <div class="social-icons">
                        <a href="https://www.facebook.com/Misbeneficiosvacacionales" target="_blank">
                            <i class="ti-facebook">
                            </i>
                        </a>
                        <a href="https://www.instagram.com/misbeneficios_vacacionalesmx/" target="_blank">
                            <i class="ti-instagram">
                            </i>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-md-4">
             <iframe src="https://www.facebook.com/plugins/page.php?href=https%3A%2F%2Fwww.facebook.com%2FMisbeneficiosvacacionales&tabs=timeline&width=0&height=0&small_header=false&adapt_container_width=true&hide_cover=false&show_facepile=true&appId=1197805144426153" width="0" height="0" style="border:none;overflow:hidden" scrolling="no" frameborder="0" allowfullscreen="true" allow="autoplay; clipboard-write; encrypted-media; picture-in-picture; web-share"></iframe>
            </div>
            <div class="col-sm-6 col-md-4">
                @if (request()->getRequestUri() == '/empresas-afiliadas' || request()->getRequestUri() == '/beneficios-empresa'|| request()->getRequestUri() == '/beneficios-trabajadores'|| request()->getRequestUri() == '/conoce-nuestros-beneficios'|| request()->getRequestUri() == '/documentos-legales'|| request()->getRequestUri() == '/demo-flyer/modulo_3'|| request()->getRequestUri() == '/demo-flyer/modulo_7')
                @else
                <div class="single-footer-widget">
                    <h4>
                        Mapa del sitio
                    </h4>
                    <ul>
                        <li>
                            <a href="{{ route('nosotros') }}">
                                Nosotros
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('fraude') }}">
                                Alerta de fraude
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('mision') }}">
                                Misión  y Visión
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('privacidad') }}">
                                Aviso de privacidad
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('terminos_y_condiciones') }}">
                               Términos y condiciones
                            </a>
                        </li>
                        <li>
                            <a href="https://bolsa.beneficiosvacacionales.mx/">
                                Bolsa de trabajo
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('empresas_afiliadas') }}">
                                Empresas afiliadas
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('beneficios_empresa') }}">
                                Beneficios
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('hoteles') }}">
                                Hoteles amigo
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('preguntas') }}">
                                Preguntas Frecuentes
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('productos') }}">
                                Nuestros productos
                            </a>
                        </li>
                    </ul>
                </div>
                @endif
            </div>
        </div>
        {{-- @else --}}
        {{-- <div class="row justify-content-between container-fluid">
            <div class="col-sm-3 col-md-3">
                @if (env('APP_ID') == 'usoptucorp')
                <img alt="" class="img-fluid" src="{{ asset('images/eu/op.png') }}">
                </img>
                @else
                <img alt="" class="img-fluid" src="{{ asset('images/eu/my_travel.png') }}">
                </img>
                @endif
            </div>
            <div class="col-sm-6 col-md-3">
                <div class="single-footer-widget footer_icon">
                    <h4>
                        @if (env('APP_ID') == 'usoptucorp')
                        <b>
                            {{ env('APP_NAME_OPT') }}
                        </b>
                        @else
                        <b>
                            {{ env('APP_NAME_USA') }}
                        </b>
                        @endif
                    </h4>
                    <p>
                        12039 SW 132nd Ct. Ste. 34-2 Miami, Fl 33186
                    </p>
                    <span>
                        Toll-free
                        <br/>
                        <a href="tel:3054472764">
                            (305) 447-2764
                        </a>
                        <br/>
                    </span>
                    <p>
                        <a href="" style="color:white;">
                            Privacy Policy,  Terms and Conditions and Refund Policy
                        </a>
                    </p>
                    <div class="social-icons">
                        <a href="#">
                            <i class="ti-facebook">
                            </i>
                        </a>
                        <a href="#">
                            <i class="ti-twitter-alt">
                            </i>
                        </a>
                        <a href="#">
                            <i class="ti-pinterest">
                            </i>
                        </a>
                        <a href="#">
                            <i class="ti-instagram">
                            </i>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <iframe allow="autoplay; clipboard-write; encrypted-media; picture-in-picture; web-share" allowfullscreen="true" frameborder="0" height="500" scrolling="no" src="https://www.facebook.com/plugins/page.php?href=https%3A%2F%2Fwww.facebook.com%2FOptucorpUS%2F&tabs=timeline&width=340&height=500&small_header=false&adapt_container_width=true&hide_cover=false&show_facepile=true&appId=1246907115476551" style="border:none;overflow:hidden" width="340">
                </iframe>
            </div>
            <div class="col-sm-6 col-md-2">
                <div class="single-footer-widget">
                    <h4>
                        Site Map
                    </h4>
                    <ul>
                        <li>
                            <a href="{{ url('/') }}">
                                Home
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                About us
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                Testimonials
                            </a>
                        </li>
                        {{--
                        <li>
                            <a href="#">
                                Affiliated Companies
                            </a>
                        </li>
                        --}}
                       {{-- <li>
                            <a href="#">
                                Benefits
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                FAQ
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('eu.productos') }}">
                                Products
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        @endif --}}
    </div>
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-lg-12">
                <div class="copyright_part_text text-center">
                    <p class="footer-text m-0">
                        Copyright ©
                        <script>
                            document.write(new Date().getFullYear());
                        </script>
                                :: Todos los Derechos Reservados
                        <b>
                            {{ env('APP_NAME') }}
                        </b>
                    </p>
                </div>
            </div>
        </div>
    </div>
</footer>
