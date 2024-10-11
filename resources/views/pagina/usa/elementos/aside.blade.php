<div class="blog_right_sidebar">
    {{--
    <aside class="single_sidebar_widget search_widget">
        <button class="button rounded-0 primary-bg text-white w-100 btn_1" type="button">
            Cotizar en linea
        </button>
    </aside>
    --}}
    <aside class="single_sidebar_widget newsletter_widget">
        <h4 class="widget_title text-center">
            {!!  trans('messages.login.titulo') !!}
        </h4>
        @guest
        <form action="{{ route('login_pt') }}" class="form-horizontal form-material" id="loginform" method="post">
            @csrf
            <div class="form-group">
                <input class="form-control" id="username" name="username" onblur="this.placeholder = 'Correo electrónico'" onfocus="this.placeholder = ''" placeholder="{!! trans('messages.login.correo')!!}" required="" type="email">
                </input>
            </div>
            <div class="form-group">
                <input class="form-control" id="pass_hash" name="pass_hash" onblur="this.placeholder = 'Contraseña'" onfocus="this.placeholder = ''" placeholder="{!! trans('messages.login.contrasena')!!}" required="" type="password">
                </input>
            </div>
            <button class="btn btn-primary rounded-0 genric-btn info btn-block" type="submit">
                {!!  trans('messages.login.submit') !!}
            </button>
        </form>
        @else
        <div class="row">
            <div class="col-md-6">
                <a class="button rounded-0 primary-bg text-white btn_1" href="{{ route('dashboard') }}" type="submit">
                    {{ __('messages.inicio') }}
                </a>
            </div>
            <div class="col-md-6">
                <a class="button rounded-0 danger-bg text-white btn_1" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                    {{ __('Logout') }}
                </a>
                <form action="{{ route('logout') }}" class="d-none" id="logout-form" method="POST">
                    @csrf
                </form>
            </div>
        </div>
        @endguest
                        
                        {{-- @endif --}}
    </aside>
    <aside class="single_sidebar_widget tag_cloud_widget">
        <h4 class="widget_title">
            Call us to sign up for the benefit if your company has an agreement with
            <b>
                {{ env('APP_NAME_EU') }}
            </b>
        </h4>
        <h4>
            <b>
                Sales and Reservation
            </b>
        </h4>
        <ul class="list">
            <li>
                <a class="d-flex" href="tel:3054472764" style="font-size: 18px;">
                    (305) 447-2764
                </a>
            </li>
        </ul>
    </aside>
    {{--
    <aside class="single_sidebar_widget post_category_widget">
        <h4 class="widget_title">
            Reservaciones
        </h4>
        <ul class="list cat-list">
            <li>
                <a class="d-flex" href="mailto:reservacionescorporativo@pacifictravels.mx">
                    reservacionescorporativo@pacifictravels.mx
                </a>
            </li>
        </ul>
    </aside>
    --}}
    {{--
    <aside class="single_sidebar_widget post_category_widget">
        <h4 class="widget_title">
            Atención al cliente
        </h4>
        <ul class="list cat-list">
            <li>
                <a class="d-flex" href="mailto:atencionalcliente@pacifictravels.mx">
                    atencionalcliente@pacifictravels.mx
                </a>
            </li>
            <li>
                <a class="d-flex" href="mailto:claudia.munoz@pacifictravels.mx">
                    claudia.munoz@pacifictravels.mx
                </a>
            </li>
        </ul>
    </aside>
    --}}
    <aside class="single_sidebar_widget popular_post_widget">
        <h3 class="widget_title">
            Anywhere in United States from
            <b>
                Monday - Friday:
            </b>
            10:00 AM to 7:00 PM EST
            <br/>
            <br/>
            <b>
                Saturday:
            </b>
            10:00 AM to 1:00 PM EST
        </h3>
        {{--
        <div class="media post_item">
            <i class="fab fa-whatsapp" style="font-size: 2em">
            </i>
            <div class="media-body">
                <a class="lead" href="single-blog.html">
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
                    Sales
                </p>
                <a class="lead">
                    322-237-3902
                </a>
            </div>
        </div>
        <div class="media post_item">
            <i class="fab fa-whatsapp" style="font-size: 2em">
            </i>
            <div class="media-body">
                <p class="lead text-muted">
                    Reservations
                </p>
                <a class="lead">
                    322-2453-643
                </a>
            </div>
        </div>
    </aside>
    <aside class="single_sidebar_widget newsletter_widget">
        <h4 class="widget_title">
            Subscribe to receive the latest news that
            <b>
                {{ env('APP_NAME_EU') }}
            </b>
            has for you
        </h4>
        <form action="#">
            <div class="form-group">
                <input class="form-control" onblur="this.placeholder = 'Email'" onfocus="this.placeholder = ''" placeholder="Email" required="" type="email">
                </input>
            </div>
            <button class="button rounded-0 primary-bg text-white w-100 btn_1" type="submit">
                Enter
            </button>
        </form>
    </aside>
</div>