<div class="blog_right_sidebar">
    <aside class="single_sidebar_widget search_widget">
        <button class="button rounded-0 primary-bg text-white w-100 btn_1" type="button">
            Cotizar en linea
        </button>
    </aside>
    <aside class="single_sidebar_widget newsletter_widget">
        <h4 class="widget_title text-center">
            Portal cliente
        </h4>
        @if (session()->get('activo')==1)
        <div class="row">
            <div class="col-md-6">
                <a class="genric-btn info hover_black" href="{{ route('paquetes.index') }}" style="color:white">
                    <span style="color: white">
                        Mi cuenta
                    </span>
                </a>
            </div>
            <div class="col-md-6">
                <a class="genric-btn danger hover_black" href="{{ route('logout') }}">
                    <span style="color: white">
                        Salir
                    </span>
                </a>
            </div>
        </div>
        @else
        <form action="" id="form_login" method="post">
            <div class="form-group">
                <input class="form-control" id="email" name="email" onblur="this.placeholder = 'Correo electrónico'" onfocus="this.placeholder = ''" placeholder="Correo electrónico" required="" type="email">
                </input>
            </div>
            <div class="form-group">
                <input class="form-control" id="password" name="password" onblur="this.placeholder = 'Contraseña'" onfocus="this.placeholder = ''" placeholder="Contraseña" required="" type="password">
                </input>
            </div>
            <button class="btn btn-primary rounded-0 genric-btn info btn-block" type="submit">
                Entrar
            </button>
        </form>
        @endif
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
                <a class="d-flex" href="tel:018008361010">
                    01 (800) 836 1010
                </a>
            </li>
            <li>
                <a class="d-flex" href="tel:5558304820">
                    (55) 5830 4820
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
                <a class="d-flex" href="mailto:reservacionescorporativo@pacifictravels.mx">
                    reservacionescorporativo@pacifictravels.mx
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
    <aside class="single_sidebar_widget popular_post_widget">
        <h3 class="widget_title">
            Envíanos texto desde tu WhatsApp las 24 hrs a los siguientes números
        </h3>
        <div class="media post_item">
            <i class="fab fa-whatsapp" style="font-size: 2em">
            </i>
            <div class="media-body">
                <a class="lead" href="single-blog.html">
                    332-2030-889
                </a>
            </div>
        </div>
        <div class="media post_item">
            <i class="fab fa-whatsapp" style="font-size: 2em">
            </i>
            <div class="media-body">
                <p class="lead text-muted">
                    Ventas
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
                    Reservaciones
                </p>
                <a class="lead">
                    322-2453-643
                </a>
            </div>
        </div>
    </aside>
    <aside class="single_sidebar_widget newsletter_widget">
        <h4 class="widget_title">
            Subscribete para recibir las ultimas noticias que
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
