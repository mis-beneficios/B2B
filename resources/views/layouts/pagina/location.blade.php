<header class="main_menu">
    <div class="sub_menu" style="background-color: #008cc8bf;">
        <div class="container">
            @if (env('APP_ID') == 'mb')
            <div class="row">
                <div class="col-lg-6 col-sm-12 col-md-6">
                    <div class="sub_menu_right_content">
                        <b class="text-white">
                            Localización
                        </b>
                        <a class="text-primary" href="{{ env('APP_URL') }}">
                            <img alt="" src="{{ asset('images/flags/mx.svg') }}" width="5%">
                            </img>
                        </a>
                        <a href="https://optucorp.com/world/En_us">
                            <img alt="" src="{{ asset('images/flags/us.svg') }}" width="5%">
                            </img>
                        </a>
                        <a href="https://misbeneficiosvacacionales.com/">
                            <img alt="" src="{{ asset('images/flags/es.svg') }}" width="5%">
                            </img>
                        </a>
                        <a href="http://mytravelbenefits.in/">
                            <img alt="" src="{{ asset('images/flags/in.svg') }}" width="5%">
                            </img>
                        </a>
                    </div>
                </div>
                <div class="col-lg-6 col-sm-12 col-md-6">
                    <div class="sub_menu_social_icon">
                        <a href="#">
                            <strong>
                                <i class="flaticon-facebook text-white">
                                </i>
                            </strong>
                        </a>
                        <a href="#">
                            <strong>
                                <i class="flaticon-instagram text-white">
                                </i>
                            </strong>
                        </a>
                    </div>
                </div>
            </div>
            @else
            <div class="row">
                <div class="col-lg-6 col-sm-12 col-md-6">
                    <div class="sub_menu_right_content">
                        <b class="text-white">
                            Location
                        </b>
                        <a href="{{ url('/') }}">
                            <img alt="" src="{{ asset('images/flags/us.svg') }}" width="5%">
                            </img>
                        </a>
                        <a href="https://pacifictravels.mx/">
                            <img alt="" src="{{ asset('images/flags/mx.svg') }}" width="5%">
                            </img>
                        </a>
                        <a href="https://misbeneficiosvacacionales.com/">
                            <img alt="" src="{{ asset('images/flags/es.svg') }}" width="5%">
                            </img>
                        </a>
                        <a href="http://mytravelbenefits.in/">
                            <img alt="" src="{{ asset('images/flags/in.svg') }}" width="5%">
                            </img>
                        </a>
                    </div>
                </div>
                <div class="col-lg-6 col-sm-12 col-md-6">
                    <div class="sub_menu_social_icon">
                        <a href="#">
                            <strong>
                                <i class="flaticon-facebook text-white">
                                </i>
                            </strong>
                        </a>
                        <a href="#">
                            <strong>
                                <i class="flaticon-instagram text-white">
                                </i>
                            </strong>
                        </a>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</header>
