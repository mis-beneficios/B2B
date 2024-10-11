@extends('layouts.pagina.app')

@section('content')
<section class="breadcrumb breadcrumb_bg" style="background-image: url({{ asset('images/hotel.jpg') }});">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="breadcrumb_iner">
                    <div class="breadcrumb_iner_item text-center">
                        <h2>
                            Hoteles Amigos
                        </h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="blog_area single-post-area mt-3">
    <div class="container">
        <div class="row">
            <div class="col-lg-4">
                <div class="blog_right_sidebar">
                    {{--
                    <aside class="single_sidebar_widget search_widget">
                        <button class="button rounded-0 primary-bg text-white w-100 btn_1" type="button">
                            Cotizar en linea
                        </button>
                    </aside>
                    --}}
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
                    <aside class="single_sidebar_widget tag_cloud_widget">
                        <h4 class="widget_title">
                            Reservaciones
                        </h4>
                        <ul class="list">
                            <li>
                                <a class="d-flex" href="mailto:reservacionescorporativo@pacifictravels.mx">
                                    reservacionescorporativo@pacifictravels.mx
                                </a>
                            </li>
                            <li>
                                <a class="d-flex" href="tel:5541698290">
                                    (55) 4169 8290
                                </a>
                            </li>
                        </ul>
                    </aside>
                    <aside class="single_sidebar_widget tag_cloud_widget">
                        <h4 class="widget_title">
                            Atención al cliente
                        </h4>
                        <ul class="list">
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
                    <aside class="single_sidebar_widget newsletter_widget">
                        <h4 class="widget_title">
                            Lista de Hoteles
                        </h4>
                        <ul class="list">
                            <li>
                                <a href="">
                                    <img alt="" src="{{ asset('images/Hoteles-Optucorp-MX01.jpg') }}" width="80px">
                                    </img>
                                    Plan todo Incluido
                                </a>
                            </li>
                            <li>
                                <a href="">
                                    <img alt="" src="{{ asset('images/Hoteles-Optucorp-MX03.jpg') }}" width="80px">
                                    </img>
                                    Plan todo Incluido
                                </a>
                            </li>
                            <li>
                                <a href="">
                                    <img alt="" src="{{ asset('images/Hoteles-Optucorp-MX05.jpg') }}" width="80px">
                                    </img>
                                    Plan todo Incluido
                                </a>
                            </li>
                        </ul>
                    </aside>
                    <aside class="single_sidebar_widget newsletter_widget">
                        <h4 class="widget_title">
                            Calendario de temporadas
                        </h4>
                        <p>
                            <a href="">
                                <img alt="" src="{{ asset('images/CAL-OPTU1.jpg') }}">
                                </img>
                            </a>
                        </p>
                    </aside>
                    <aside class="single_sidebar_widget newsletter_widget">
                        <h4 class="widget_title">
                            Calendario Paquetes con Aéreos
                        </h4>
                        <p>
                            <a href="">
                                <img alt="" src="{{ asset('images/CAL-AEREO.jpg') }}">
                                </img>
                            </a>
                        </p>
                    </aside>
                    <aside class="single_sidebar_widget newsletter_widget">
                        <h4 class="widget_title">
                            Papeleta de Reservación
                        </h4>
                        <p class="text-center">
                            <a href="{{ asset('files/Papeleta.pdf') }}" target="_blank">
                                <img alt="" src="https://upload.wikimedia.org/wikipedia/commons/thumb/8/87/PDF_file_icon.svg/1200px-PDF_file_icon.svg.png" width="30%">
                                </img>
                            </a>
                        </p>
                    </aside>
                </div>
            </div>
            <div class="col-lg-8 posts-list">
                <section class="hotel_list ">
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-xl-12">
                                <div class="section_tittle text-center">
                                    <h2>
                                        Hoteles en plan todo incluido
                                    </h2>
                                    <img alt="" class="img-fluid" src="{{ asset('images/todo_incluido.png') }}">
                                    </img>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-4 col-sm-6">
                                <div class="single_ihotel_list">
                                    {{--
                                    <img alt="" src="img/ind/industries_1.png"/>
                                    --}}
                                    <div class="hotel_text_iner">
                                        <h3>
                                            <a href="javascript:;">
                                                Acapulco
                                            </a>
                                        </h3>
                                        <div class="">
                                            <ul class="unordered-list">
                                                <li>
                                                    PLAYA SUITES
                                                </li>
                                                <li>
                                                    RITZ
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-sm-6">
                                <div class="single_ihotel_list">
                                    {{--
                                    <img alt="" src="img/ind/industries_2.png"/>
                                    --}}
                                    <div class="hotel_text_iner">
                                        <h3>
                                            <a href="javascript:;">
                                                Puerto Vallarta
                                            </a>
                                        </h3>
                                        <div class="">
                                            <ul class="unordered-list">
                                                <li>
                                                    PLAZA PELICANOS CLUB (3 NOCHES MÍNIMO)
                                                </li>
                                                <li>
                                                    LAS PALMAS
                                                </li>
                                                <li>
                                                    VILLAS VALLARTA
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-sm-6">
                                <div class="single_ihotel_list">
                                    {{--
                                    <img alt="" src="img/ind/industries_3.png"/>
                                    --}}
                                    <div class="hotel_text_iner">
                                        <h3>
                                            <a href="javascript:;">
                                                Huatulco
                                            </a>
                                        </h3>
                                        <div>
                                            <ul class="unordered-list">
                                                <li>
                                                    CASTILLO HUATULCO
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-sm-6">
                                <div class="single_ihotel_list">
                                    {{--
                                    <img alt="" src="img/ind/industries_3.png"/>
                                    --}}
                                    <div class="hotel_text_iner">
                                        <h3>
                                            <a href="javascript:;">
                                                Cancún
                                            </a>
                                        </h3>
                                        <div>
                                            <ul class="unordered-list">
                                                <li>
                                                    HOLIDAY INN CANCUN ARENAS
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-sm-6">
                                <div class="single_ihotel_list">
                                    {{--
                                    <img alt="" src="img/ind/industries_3.png"/>
                                    --}}
                                    <div class="hotel_text_iner">
                                        <h3>
                                            <a href="javascript:;">
                                                Ixtapa
                                            </a>
                                        </h3>
                                        <div>
                                            <ul class="unordered-list">
                                                <li>
                                                    QUALTON
                                                </li>
                                                <li>
                                                    POSADA REAL
                                                </li>
                                                <li>
                                                    GAMMA DE FIESTA INN
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-sm-6">
                                <div class="single_ihotel_list">
                                    {{--
                                    <img alt="" src="img/ind/industries_3.png"/>
                                    --}}
                                    <div class="hotel_text_iner">
                                        <h3>
                                            <a href="javascript:;">
                                                Los Cabos
                                            </a>
                                        </h3>
                                        <div>
                                            <ul class="unordered-list">
                                                <li>
                                                    POSADA REAL
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-sm-6">
                                <div class="single_ihotel_list">
                                    {{--
                                    <img alt="" src="img/ind/industries_3.png"/>
                                    --}}
                                    <div class="hotel_text_iner">
                                        <h3>
                                            <a href="javascript:;">
                                                Puerto Escondido
                                            </a>
                                        </h3>
                                        <div>
                                            <ul class="unordered-list">
                                                <li>
                                                    POSADA REAL
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <section class="hotel_list ">
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-xl-12">
                                <div class="section_tittle text-center">
                                    <h2>
                                        Hoteles en plan europeo
                                    </h2>
                                    <img alt="" class="img-fluid" src="{{ asset('images/europeo.png') }}">
                                    </img>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-4 col-sm-6">
                                <div class="single_ihotel_list">
                                    {{--
                                    <img alt="" src="img/ind/industries_1.png"/>
                                    --}}
                                    <div class="hotel_text_iner">
                                        <h3>
                                            <a href="javascript:;">
                                                Acapulco
                                            </a>
                                        </h3>
                                        <div class="">
                                            <ul class="unordered-list">
                                                <li>
                                                    AMAREA
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-sm-6">
                                <div class="single_ihotel_list">
                                    {{--
                                    <img alt="" src="img/ind/industries_2.png"/>
                                    --}}
                                    <div class="hotel_text_iner">
                                        <h3>
                                            <a href="javascript:;">
                                                Puerto Vallarta
                                            </a>
                                        </h3>
                                        <div class="">
                                            <ul class="unordered-list">
                                                <li>
                                                    VILLAS VALLARTA
                                                </li>
                                                <li>
                                                    TROPICANA VALLARTA
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-sm-6">
                                <div class="single_ihotel_list">
                                    {{--
                                    <img alt="" src="img/ind/industries_3.png"/>
                                    --}}
                                    <div class="hotel_text_iner">
                                        <h3>
                                            <a href="javascript:;">
                                                Huatulco
                                            </a>
                                        </h3>
                                        <div>
                                            <ul class="unordered-list">
                                                <li>
                                                    CASTILLO HUATULCO
                                                </li>
                                                <li>
                                                    VILLA BLANCA
                                                </li>
                                                <li>
                                                    LA ISLA
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-sm-6">
                                <div class="single_ihotel_list">
                                    {{--
                                    <img alt="" src="img/ind/industries_3.png"/>
                                    --}}
                                    <div class="hotel_text_iner">
                                        <h3>
                                            <a href="javascript:;">
                                                Cancún
                                            </a>
                                        </h3>
                                        <div>
                                            <ul class="unordered-list">
                                                <li>
                                                    MARGARITAS
                                                </li>
                                                <li>
                                                    RAMADA
                                                </li>
                                                <li>
                                                    OASIS SMART
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-sm-6">
                                <div class="single_ihotel_list">
                                    {{--
                                    <img alt="" src="img/ind/industries_3.png"/>
                                    --}}
                                    <div class="hotel_text_iner">
                                        <h3>
                                            <a href="javascript:;">
                                                Playa del Carmen
                                            </a>
                                        </h3>
                                        <div>
                                            <ul class="unordered-list">
                                                <li>
                                                    WYNDHAM PLAYA DEL CARMEN (SIN DESAYUNO)
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-sm-6">
                                <div class="single_ihotel_list">
                                    {{--
                                    <img alt="" src="img/ind/industries_3.png"/>
                                    --}}
                                    <div class="hotel_text_iner">
                                        <h3>
                                            <a href="javascript:;">
                                                Ixtapa
                                            </a>
                                        </h3>
                                        <div>
                                            <ul class="unordered-list">
                                                <li>
                                                    POSADA REAL IXTAPA (SÓLO BEBIDAS)
                                                </li>
                                                <li>
                                                    GAMMA DE FIESTA INN (SÓLO HOSPEDAJE)
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-sm-6">
                                <div class="single_ihotel_list">
                                    {{--
                                    <img alt="" src="img/ind/industries_3.png"/>
                                    --}}
                                    <div class="hotel_text_iner">
                                        <h3>
                                            <a href="javascript:;">
                                                Los Cabos
                                            </a>
                                        </h3>
                                        <div>
                                            <ul class="unordered-list">
                                                <li>
                                                    POSADA REAL LOS CABOS (SÓLO BEBIDAS)
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-sm-6">
                                <div class="single_ihotel_list">
                                    {{--
                                    <img alt="" src="img/ind/industries_3.png"/>
                                    --}}
                                    <div class="hotel_text_iner">
                                        <h3>
                                            <a href="javascript:;">
                                                Puerto Escondido
                                            </a>
                                        </h3>
                                        <div>
                                            <ul class="unordered-list">
                                                <li>
                                                    ALDEA DEL BAZAR (SIN DESAYUNOS)
                                                </li>
                                                <li>
                                                    POSADA REAL PUERTO ESCONDIDO (SÓLO BEBIDAS)
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-sm-6">
                                <div class="single_ihotel_list">
                                    {{--
                                    <img alt="" src="img/ind/industries_3.png"/>
                                    --}}
                                    <div class="hotel_text_iner">
                                        <h3>
                                            <a href="javascript:;">
                                                Veracruz
                                            </a>
                                        </h3>
                                        <div>
                                            <ul class="unordered-list">
                                                <li>
                                                    HOWARD JOHNSON VERACRUZ
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-sm-6">
                                <div class="single_ihotel_list">
                                    {{--
                                    <img alt="" src="img/ind/industries_3.png"/>
                                    --}}
                                    <div class="hotel_text_iner">
                                        <h3>
                                            <a href="javascript:;">
                                                Guanajuato
                                            </a>
                                        </h3>
                                        <div>
                                            <ul class="unordered-list">
                                                <li>
                                                    VILLAS LAS RANAS
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-sm-6">
                                <div class="single_ihotel_list">
                                    {{--
                                    <img alt="" src="img/ind/industries_3.png"/>
                                    --}}
                                    <div class="hotel_text_iner">
                                        <h3>
                                            <a href="javascript:;">
                                                Tamaulipas
                                            </a>
                                        </h3>
                                        <div>
                                            <ul class="unordered-list">
                                                <li>
                                                    MISIÓN CIUDAD VICTORIA
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-sm-6">
                                <div class="single_ihotel_list">
                                    {{--
                                    <img alt="" src="img/ind/industries_3.png"/>
                                    --}}
                                    <div class="hotel_text_iner">
                                        <h3>
                                            <a href="javascript:;">
                                                Chiapas
                                            </a>
                                        </h3>
                                        <div>
                                            <ul class="unordered-list">
                                                <li>
                                                    MISIÓN PALENQUE
                                                </li>
                                                <li>
                                                    BEST WESTERN  PALMARECA.
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-sm-6">
                                <div class="single_ihotel_list">
                                    {{--
                                    <img alt="" src="img/ind/industries_3.png"/>
                                    --}}
                                    <div class="hotel_text_iner">
                                        <h3>
                                            <a href="javascript:;">
                                                Merida
                                            </a>
                                        </h3>
                                        <div>
                                            <ul class="unordered-list">
                                                <li>
                                                    MISIÓN MERIDA PANAMERICANA
                                                </li>
                                                <li>
                                                    MISIÓN EXPRESS MÉRIDA ALTABRISA
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-sm-6">
                                <div class="single_ihotel_list">
                                    {{--
                                    <img alt="" src="img/ind/industries_3.png"/>
                                    --}}
                                    <div class="hotel_text_iner">
                                        <h3>
                                            <a href="javascript:;">
                                                Colima
                                            </a>
                                        </h3>
                                        <div>
                                            <ul class="unordered-list">
                                                <li>
                                                    MISIÓN COLIMA
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-sm-6">
                                <div class="single_ihotel_list">
                                    {{--
                                    <img alt="" src="img/ind/industries_3.png"/>
                                    --}}
                                    <div class="hotel_text_iner">
                                        <h3>
                                            <a href="javascript:;">
                                                Queretaro
                                            </a>
                                        </h3>
                                        <div>
                                            <ul class="unordered-list">
                                                <li>
                                                    MISIÓN CONCÁ SIERRA GORDA QUERETANA
                                                </li>
                                                <li>
                                                    MISIÓN JALPAN SIERRA GORDA QUERETANA
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-sm-6">
                                <div class="single_ihotel_list">
                                    {{--
                                    <img alt="" src="img/ind/industries_3.png"/>
                                    --}}
                                    <div class="hotel_text_iner">
                                        <h3>
                                            <a href="javascript:;">
                                                Aguascalientes
                                            </a>
                                        </h3>
                                        <div>
                                            <ul class="unordered-list">
                                                <li>
                                                    MISIÓN EXPRESS AGUASCALIENTES NORTE
                                                </li>
                                                <li>
                                                    MISIÓN AGUASCALIENTES SUR
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-sm-6">
                                <div class="single_ihotel_list">
                                    {{--
                                    <img alt="" src="img/ind/industries_3.png"/>
                                    --}}
                                    <div class="hotel_text_iner">
                                        <h3>
                                            <a href="javascript:;">
                                                Guadalajara
                                            </a>
                                        </h3>
                                        <div>
                                            <ul class="unordered-list">
                                                <li>
                                                    HOWARD JOHNSON
                                                </li>
                                                <li>
                                                    MISIÓN CARLTON
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-sm-6">
                                <div class="single_ihotel_list">
                                    {{--
                                    <img alt="" src="img/ind/industries_3.png"/>
                                    --}}
                                    <div class="hotel_text_iner">
                                        <h3>
                                            <a href="javascript:;">
                                                Taxco
                                            </a>
                                        </h3>
                                        <div>
                                            <ul class="unordered-list">
                                                <li>
                                                    BEST WESTERN TAXCO
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-sm-6">
                                <div class="single_ihotel_list">
                                    {{--
                                    <img alt="" src="img/ind/industries_3.png"/>
                                    --}}
                                    <div class="hotel_text_iner">
                                        <h3>
                                            <a href="javascript:;">
                                                Puebla
                                            </a>
                                        </h3>
                                        <div>
                                            <ul class="unordered-list">
                                                <li>
                                                    MISION PUEBLA
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-sm-6">
                                <div class="single_ihotel_list">
                                    {{--
                                    <img alt="" src="img/ind/industries_3.png"/>
                                    --}}
                                    <div class="hotel_text_iner">
                                        <h3>
                                            <a href="javascript:;">
                                                Monterrey
                                            </a>
                                        </h3>
                                        <div>
                                            <ul class="unordered-list">
                                                <li>
                                                    MISIÓN MONTERREY
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-sm-6">
                                <div class="single_ihotel_list">
                                    {{--
                                    <img alt="" src="img/ind/industries_3.png"/>
                                    --}}
                                    <div class="hotel_text_iner">
                                        <h3>
                                            <a href="javascript:;">
                                                La Paz
                                            </a>
                                        </h3>
                                        <div>
                                            <ul class="unordered-list">
                                                <li>
                                                    LA CONCHA BEACH
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <section class="hotel_list ">
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-xl-12">
                                <div class="section_tittle text-center">
                                    <h2>
                                        Hoteles Previa Cotización
                                    </h2>
                                    <img alt="" class="img-fluid" src="{{ asset('images/cotizador.png') }}">
                                    </img>
                                    <p>
                                        ESTOS HOTELES NO PARTICIPAN EN NUESTRAS PROMOCIONES NORMALES, PERO USTED PUEDE PEDIR UNA COTIZACIÓN SI DESEA RESERVAR EN ELLOS. (CON UN PAGO ADICIONAL AL COSTO DE SU PAQUETE)
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-4 col-sm-6">
                                <div class="single_ihotel_list">
                                    {{--
                                    <img alt="" src="img/ind/industries_1.png"/>
                                    --}}
                                    <div class="hotel_text_iner">
                                        <h3>
                                            <a href="javascript:;">
                                                Acapulco
                                            </a>
                                        </h3>
                                        <div class="">
                                            <ul class="unordered-list">
                                                <li>
                                                    PLAYA SUITES(EN PLAN EUROPEO)
                                                </li>
                                                <li>
                                                    CALINDA (EN PLAN EUROPEO SIN DESAYUNOS)
                                                </li>
                                                <li>
                                                    PARK ROYAL (EN PLAN TODO INCLUIDO)
                                                </li>
                                                <li>
                                                    EMPORIO (EN PLAN EUROPEO)
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-sm-6">
                                <div class="single_ihotel_list">
                                    {{--
                                    <img alt="" src="img/ind/industries_2.png"/>
                                    --}}
                                    <div class="hotel_text_iner">
                                        <h3>
                                            <a href="javascript:;">
                                                Puerto Vallarta
                                            </a>
                                        </h3>
                                        <div class="">
                                            <ul class="unordered-list">
                                                <li>
                                                    CANTO DEL SOL (EN PLAN TODO INCLUIDO)
                                                </li>
                                                <li>
                                                    PLAZA PELICANOS GRAND (EN PLAN TODO INCLUIDO)
                                                </li>
                                                <li>
                                                    KRYSTAL (EN PLAN TODO INCLUIDO)
                                                </li>
                                                <li>
                                                    COSTA SUR (EN PLAN TODO INCLUIDO)
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-sm-6">
                                <div class="single_ihotel_list">
                                    {{--
                                    <img alt="" src="img/ind/industries_3.png"/>
                                    --}}
                                    <div class="hotel_text_iner">
                                        <h3>
                                            <a href="javascript:;">
                                                Huatulco
                                            </a>
                                        </h3>
                                        <div>
                                            <ul class="unordered-list">
                                                <li>
                                                    LA ISLA HUATULCO (EN PLAN TODO INCLUIDO)
                                                </li>
                                                <li>
                                                    PARK ROYAL HUATULCO (EN PLAN TODO INCLUIDO)
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-sm-6">
                                <div class="single_ihotel_list">
                                    {{--
                                    <img alt="" src="img/ind/industries_3.png"/>
                                    --}}
                                    <div class="hotel_text_iner">
                                        <h3>
                                            <a href="javascript:;">
                                                Riviera Maya
                                            </a>
                                        </h3>
                                        <div>
                                            <ul class="unordered-list">
                                                <li>
                                                    CATALONIA RIVIERA MAYA RESORT & SPA (EN PLAN TODO INCLUIDO)
                                                </li>
                                                <li>
                                                    CATALONIA ROYAL TULUM BEACH & SPA RESORT (EN PLAN TODO INCLUIDO)
                                                </li>
                                                <li>
                                                    RIU PALACE RIVIERA MAYA (EN PLAN TODO INCLUIDO)
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-sm-6">
                                <div class="single_ihotel_list">
                                    {{--
                                    <img alt="" src="img/ind/industries_3.png"/>
                                    --}}
                                    <div class="hotel_text_iner">
                                        <h3>
                                            <a href="javascript:;">
                                                Chiapas
                                            </a>
                                        </h3>
                                        <div>
                                            <ul class="unordered-list">
                                                <li>
                                                    MISION SAN CRISTOBAL (EN PLAN EUROPEO)
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-sm-6">
                                <div class="single_ihotel_list">
                                    {{--
                                    <img alt="" src="img/ind/industries_3.png"/>
                                    --}}
                                    <div class="hotel_text_iner">
                                        <h3>
                                            <a href="javascript:;">
                                                Nuevo Vallarta
                                            </a>
                                        </h3>
                                        <div>
                                            <ul class="unordered-list">
                                                <li>
                                                    CLUB HOTEL RIU JALISCO (EN PLAN TODO INCLUIDO)
                                                </li>
                                                <li>
                                                    RIU PALACE PACIFICO (EN PLAN TODO INCLUIDO)
                                                </li>
                                                <li>
                                                    RIU VALLARTA (EN PLAN TODO INCLUIDO)
                                                </li>
                                                <li>
                                                    VILLA VARADERO (EN PLAN TODO INCLUIDO)
                                                </li>
                                                <li>
                                                    SAMBA VALLARTA (MÍNIMO 3 NOCHES)
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-sm-6">
                                <div class="single_ihotel_list">
                                    {{--
                                    <img alt="" src="img/ind/industries_3.png"/>
                                    --}}
                                    <div class="hotel_text_iner">
                                        <h3>
                                            <a href="javascript:;">
                                                Playa del Carmen
                                            </a>
                                        </h3>
                                        <div>
                                            <ul class="unordered-list">
                                                <li>
                                                    CATALONIA PLAYA MAROMA (EN PLAN TODO INCLUIDO)
                                                </li>
                                                <li>
                                                    PANAMA JACK RESORT (EN PLAN TODO INCLUIDO)
                                                </li>
                                                <li>
                                                    RIU LUPITA (EN PLAN TODO INCLUIDO)
                                                </li>
                                                <li>
                                                    RIU PLAYA DEL CARMEN (EN PLAN TODO INCLUIDO)
                                                </li>
                                                <li>
                                                    TUKAN (PLAN EUROPEO)
                                                </li>
                                                <li>
                                                    CATALONIA YUCATAN BEACH RESORT & SPA (EN PLAN TODO INCLUIDO)
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-sm-6">
                                <div class="single_ihotel_list">
                                    {{--
                                    <img alt="" src="img/ind/industries_3.png"/>
                                    --}}
                                    <div class="hotel_text_iner">
                                        <h3>
                                            <a href="javascript:;">
                                                Ixtapa
                                            </a>
                                        </h3>
                                        <div>
                                            <ul class="unordered-list">
                                                <li>
                                                    TESORO IXTAPA (EN PLAN TODO INCLUIDO)
                                                </li>
                                                <li>
                                                    PARK ROYAL IXTAPA (EN PLAN TODO INCLUIDO)
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-sm-6">
                                <div class="single_ihotel_list">
                                    {{--
                                    <img alt="" src="img/ind/industries_3.png"/>
                                    --}}
                                    <div class="hotel_text_iner">
                                        <h3>
                                            <a href="javascript:;">
                                                Manzanillo
                                            </a>
                                        </h3>
                                        <div>
                                            <ul class="unordered-list">
                                                <li>
                                                    TESORO MANZANILLO (EN PLAN TODO INCLUIDO)
                                                </li>
                                                <li>
                                                    BRISAS DEL MAR (EN PLAN EUROPEO)
                                                </li>
                                                <li>
                                                    DOLPHIN COVER INN (EN PLAN EUROPEO)
                                                </li>
                                                <li>
                                                    HOLIDAY INN EXPRESS (EN PLAN EUROPEO)
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-sm-6">
                                <div class="single_ihotel_list">
                                    {{--
                                    <img alt="" src="img/ind/industries_3.png"/>
                                    --}}
                                    <div class="hotel_text_iner">
                                        <h3>
                                            <a href="javascript:;">
                                                Oaxaca
                                            </a>
                                        </h3>
                                        <div>
                                            <ul class="unordered-list">
                                                <li>
                                                    FORTIN PLAZA (EN PLAN EUROPEO)
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-sm-6">
                                <div class="single_ihotel_list">
                                    {{--
                                    <img alt="" src="img/ind/industries_3.png"/>
                                    --}}
                                    <div class="hotel_text_iner">
                                        <h3>
                                            <a href="javascript:;">
                                                Veracruz
                                            </a>
                                        </h3>
                                        <div>
                                            <ul class="unordered-list">
                                                <li>
                                                    CENTRO HISTÓRICO (EN PLAN EUROPEO)
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-sm-6">
                                <div class="single_ihotel_list">
                                    {{--
                                    <img alt="" src="img/ind/industries_3.png"/>
                                    --}}
                                    <div class="hotel_text_iner">
                                        <h3>
                                            <a href="javascript:;">
                                                Guanajuato
                                            </a>
                                        </h3>
                                        <div>
                                            <ul class="unordered-list">
                                                <li>
                                                    MISIÓN BOUTIQUE CASA COLORADA  (EN PLAN EUROPEO SIN ALIMENTOS)
                                                </li>
                                                <li>
                                                    MISIÓN COMANJILLA (EN PLAN EUROPEO)
                                                </li>
                                                <li>
                                                    MISIÓN EL MOLINO SAN MIGUEL DE ALLENDE (EUROPEO)
                                                </li>
                                                <li>
                                                    LA ABADIA (EN PLAN EUROPEO)
                                                </li>
                                                <li>
                                                    MISIÓN GUANAJUATO (EUROPEO)
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-sm-6">
                                <div class="single_ihotel_list">
                                    {{--
                                    <img alt="" src="img/ind/industries_3.png"/>
                                    --}}
                                    <div class="hotel_text_iner">
                                        <h3>
                                            <a href="javascript:;">
                                                Estado de México
                                            </a>
                                        </h3>
                                        <div>
                                            <ul class="unordered-list">
                                                <li>
                                                    MISIÓN REFUGIO DEL SALTO - EN VALLE DE BRAVO (EN PLAN EUROPEO SIN ALIMENTOS)
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-sm-6">
                                <div class="single_ihotel_list">
                                    {{--
                                    <img alt="" src="img/ind/industries_3.png"/>
                                    --}}
                                    <div class="hotel_text_iner">
                                        <h3>
                                            <a href="javascript:;">
                                                Ciudad de México
                                            </a>
                                        </h3>
                                        <div>
                                            <ul class="unordered-list">
                                                <li>
                                                    CASA INN MÉXICO
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-sm-6">
                                <div class="single_ihotel_list">
                                    {{--
                                    <img alt="" src="img/ind/industries_3.png"/>
                                    --}}
                                    <div class="hotel_text_iner">
                                        <h3>
                                            <a href="javascript:;">
                                                Mazatlán
                                            </a>
                                        </h3>
                                        <div>
                                            <ul class="unordered-list">
                                                <li>
                                                    OCEANO PALACE (EN PLAN EUROPEO)
                                                </li>
                                                <li>
                                                    RIU EMERALD BAY (EN PLAN TODO INCLUIDO)
                                                </li>
                                                <li>
                                                    CID GRANADA (EN PLAN TODO INCLUIDO)
                                                </li>
                                                <li>
                                                    CID CASTILLA (EN PLAN TODO INCLUIDO)
                                                </li>
                                                <li>
                                                    CID EL MORO (EN PLAN TODO INCLUIDO)
                                                </li>
                                                <li>
                                                    BEST WESTERN POSADA FREEMAN (EN PLAN EUROPEO)
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-sm-6">
                                <div class="single_ihotel_list">
                                    {{--
                                    <img alt="" src="img/ind/industries_3.png"/>
                                    --}}
                                    <div class="hotel_text_iner">
                                        <h3>
                                            <a href="javascript:;">
                                                San Carlos Plaza (Sonora)
                                            </a>
                                        </h3>
                                        <div>
                                            <ul class="unordered-list">
                                                <li>
                                                    MISIÓN MARINA TERRA (EN PLAN EUROPEO)
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-sm-6">
                                <div class="single_ihotel_list">
                                    {{--
                                    <img alt="" src="img/ind/industries_3.png"/>
                                    --}}
                                    <div class="hotel_text_iner">
                                        <h3>
                                            <a href="javascript:;">
                                                Los Cabos
                                            </a>
                                        </h3>
                                        <div>
                                            <ul class="unordered-list">
                                                <li>
                                                    WYNDHAM CABO SAN LUCAS (EN PLAN EUROPEO)
                                                </li>
                                                <li>
                                                    RIU SANTA FE (EN PLAN TODO INCLUIDO)
                                                </li>
                                                <li>
                                                    RIU PALACE CABO SAN LUCAS (EN PLAN TODO INCLUIDO)
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-sm-6">
                                <div class="single_ihotel_list">
                                    {{--
                                    <img alt="" src="img/ind/industries_3.png"/>
                                    --}}
                                    <div class="hotel_text_iner">
                                        <h3>
                                            <a href="javascript:;">
                                                Cancún
                                            </a>
                                        </h3>
                                        <div>
                                            <ul class="unordered-list">
                                                <li>
                                                    RIU CANCÚN (EN PLAN TODO INCLUIDO)
                                                </li>
                                                <li>
                                                    ADHARA (EN PLAN EUROPEO)
                                                </li>
                                                <li>
                                                    OASIS PALM BEACH (EN PLAN TODO INCLUIDO)
                                                </li>
                                                <li>
                                                    GRAND OASIS PALM (EN PLAN TODO INCLUIDO)
                                                </li>
                                                <li>
                                                    GRAND OASIS CANCUN (EN PLAN TODO INCLUIDO)
                                                </li>
                                                <li>
                                                    GRAND PARK ROYAL (EN PLAN TODO INCLUIDO)
                                                </li>
                                                <li>
                                                    RIU CARIBE (EN PLAN TODO INCLUIDO)
                                                </li>
                                                <li>
                                                    RIU DUNAMAR (EN PLAN TODO INCLUIDO)
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-sm-6">
                                <div class="single_ihotel_list">
                                    {{--
                                    <img alt="" src="img/ind/industries_3.png"/>
                                    --}}
                                    <div class="hotel_text_iner">
                                        <h3>
                                            <a href="javascript:;">
                                                Queretaro
                                            </a>
                                        </h3>
                                        <div>
                                            <ul class="unordered-list">
                                                <li>
                                                    MISIÓN JURIQUILLA
                                                </li>
                                                <li>
                                                    MISIÓN LA MURALLA AMEALCO
                                                </li>
                                                <li>
                                                    MISIÓN SAN GIL
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-sm-6">
                                <div class="single_ihotel_list">
                                    {{--
                                    <img alt="" src="img/ind/industries_3.png"/>
                                    --}}
                                    <div class="hotel_text_iner">
                                        <h3>
                                            <a href="javascript:;">
                                                Cuernavaca
                                            </a>
                                        </h3>
                                        <div>
                                            <ul class="unordered-list">
                                                <li>
                                                    MISIÓN CUERNAVACA (EN PLAN EUROPEO)
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
</section>
@endsection
