<style>
    a .success{
        color: white;
    }

    a .danger{
        color: white
    }
</style>
<div class="blog_right_sidebar">
    <aside class="single_sidebar_widget search_widget">
        <a class="button rounded-0 primary-bg text-white w-100 btn_1" href="{{ route('preguntas') }}" type="button">
            <b class="text-white">
                Preguntas Frecuentes
            </b>
        </a>
    </aside>
    <aside class="single_sidebar_widget newsletter_widget">
        <h4 class="widget_title text-center">
            {!!  trans('messages.login.titulo') !!}
        </h4>
        @guest
        <form action="{{ route('login_custom') }}" class="form-horizontal form-material" id="loginform" method="post">
            @csrf
            <div class="form-group">
                <input class="form-control" id="username" name="username" onblur="this.placeholder = 'Correo electrónico'" onfocus="this.placeholder = ''" placeholder="Correo electrónico" required="" type="email">
                </input>
            </div>
            <div class="form-group">
                <input class="form-control" id="pass_hash" name="pass_hash" onblur="this.placeholder = 'Contraseña'" onfocus="this.placeholder = ''" placeholder="Contraseña" required="" type="password">
                </input>
            </div>
            <div class="form-group">
                <div class="col-md-12">
                    <a class="text-dark pull-right" href="{{ route('password.request') }}" id="to-recover">
                        <i class="fa fa-lock m-r-5">
                        </i>
                        {{ __('messages.login.forgot_pass') }}
                    </a>
                </div>
            </div>
            <button class="btn btn-primary rounded-0 genric-btn info btn-block" type="submit">
                {{ __('messages.login.submit') }}
            </button>
        </form>
        @else
        <div class="row">
            <div class="col-md-6">
                @if (Auth::user()->role != 'client')
                <a class="genric-btn success circle btn-block" href="{{ route('dashboard') }}" id="btnLogin" style="color: white" type="submit">
                    Entrar
                </a>
                @else
                <a class="genric-btn success circle btn-block" href="{{ route('inicio') }}" id="btnLogin" style="color: white" type="submit">
                    Entrar
                </a>
                @endif
            </div>
            <div class="col-md-6">
                <a class="genric-btn danger circle btn-block" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();" style="color: white">
                    {{ __('Salir') }}
                </a>
                <form action="{{ route('logout') }}" class="d-none" id="logout-form" method="POST">
                    @csrf
                </form>
            </div>
        </div>
        @endguest
    </aside>
    <aside class="single_sidebar_widget tag_cloud_widget">
        <h4 class="widget_title">
            Llámanos para inscribirte al beneficio si tu empresa tiene convenio con
            <b>
                Mis Beneficios Vacacionales
            </b>
        </h4>
        <ul class="list">
            <li>
                <a class="d-flex" href="tel:5541708423">
                    5541708423
                </a>
            </li>
        </ul>
    </aside>
    <aside class="single_sidebar_widget post_category_widget">
        <h4 class="widget_title">
            Reservaciones
        </h4>
        <ul class="list cat-list">
            <li>
                <a class="d-flex" href="mailto:reservacionescorporativo@beneficiosvacacionales.mx">
                    <small>
                        reservacionescorporativo@beneficiosvacacionales.mx
                    </small>
                </a>
            </li>
        </ul>
    </aside>
    <aside class="single_sidebar_widget post_category_widget">
        <h4 class="widget_title">
            Atención al cliente
        </h4>
        <ul class="list cat-list">
            <li>
                <a class="d-flex" href="mailto:atencionalcliente@beneficiosvacacionales.mx">
                    atencionalcliente@beneficiosvacacionales.mx
                </a>
            </li>
            <li>
                <a class="d-flex" href="mailto:claudia.munoz@beneficiosvacacionales.mx">
                    claudia.munoz@beneficiosvacacionales.mx
                </a>
            </li>
        </ul>
    </aside>
    @switch(rand(1,6))
        @case(1)
            @php
                $link =  'https://wa.link/u3izbi';
                $cel = '332 2030 889';
            @endphp
            @break
        @case(2)
            @php
                $link =  'https://wa.link/vlj2z9';
                $cel = '322 237 3902';
            @endphp
            @break
        @case(3)
            @php
                $link =  'https://wa.link/l9wf6t';
                $cel = '322 107 4511';
            @endphp
            @break
        @case(4)
            @php
                $link =  'https://wa.link/weqlg1';
                $cel = '322 348 7853';
            @endphp
            @break
        @case(5)
            @php
                $link =  'https://wa.link/fcdh8a';
                $cel = '322 378 9082';
            @endphp
            @break
        @case(6)
            @php
                $link =  'https://wa.link/qjskt3';
                $cel = '56 3006 2146';
            @endphp
            @break
    @endswitch
    <aside class="single_sidebar_widget popular_post_widget">
        <h3 class="widget_title">
            Envíanos texto desde tu WhatsApp las 24 hrs a los siguientes números
        </h3>
        {{--
        <div class="media post_item">
            <i class="fab fa-whatsapp" style="font-size: 2em">
            </i>
            <div class="media-body">
                <a class="lead" href="wa.link/u3izbi" target="_blank">
                    332-2030-889
                </a>
            </div>
        </div>
        --}}
        <div class="media post_item">
            <i class="fab fa-whatsapp" style="font-size: 2em">
            </i>
            <div class="media-body">
                <p class="lead text-muted">
                    Ventas
                </p>
                <a class="lead" href="{{ $link }}" target="_blank">
                    {{ $cel }}
                </a>
            </div>
        </div>
        <div class="media post_item">
            <i class="fab fa-whatsapp" style="font-size: 2em">
            </i>
            <div class="media-body">
                <p class="lead text-muted">
                    Reservaciones
                </p>
                <a class="lead" href="wa.link/vzvi1m" target="_blank">
                    322 111 5496
                </a>
            </div>
        </div>
    </aside>
    <aside class="single_sidebar_widget newsletter_widget">
        <h4 class="widget_title">
            Suscribete para recibir las ultimas noticias que
            <b>
                Mis Beneficios Vacacionales
            </b>
            tiene para ti
        </h4>
        <form action="#">
            <div class="form-group">
                <input class="form-control" onblur="this.placeholder = 'Correo electrónico'" onfocus="this.placeholder = ''" placeholder="Correo electrónico" required="" type="email">
                </input>
            </div>
            <button class="button rounded-0 primary-bg text-white w-100 btn_1" type="submit">
                Subscribete
            </button>
        </form>
    </aside>
</div>