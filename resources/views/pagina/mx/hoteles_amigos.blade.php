@extends('layouts.pagina.app')

@section('content')
<section class="breadcrumb breadcrumb_bg" style="background-image: url('https://external-content.duckduckgo.com/iu/?u=http%3A%2F%2Fwww.fullviajes.net%2Fwp-content%2Fuploads%2F2017%2F05%2Fiberostar-cancun-con-full-viajes.jpg&f=1&nofb=1');">
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
                            {{--
                            <li>
                                <a class="d-flex" href="tel:5575898463">
                                    5575898463
                                </a>
                            </li>
                            --}}
                            <li>
                                <a class="d-flex" href="tel:5541708423">
                                    5541708423
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
                                <a class="d-flex" href="mailto:reservacionescorporativo@beneficiosvacacionales.mx">
                                    <small>
                                        reservacionescorporativo@beneficiosvacacionales.mx
                                    </small>
                                </a>
                            </li>
                            <li>
                                <a class="d-flex" href="tel:5541698290">
                                    <i class="fas fa-phone-square m-1" style="font-size:13px">
                                    </i>
                                    (55) 4169 8290
                                </a>
                            </li>
                            <li>
                                <a class="d-flex" href="https://wa.link/l7heeq" target="_blank">
                                    <i class="fab fa-whatsapp m-1" style="font-size:13px">
                                    </i>
                                    322 111 5496
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
                                <a class="d-flex" href="mailto:atencionalcliente@beneficiosvacacionales.mx">
                                    atencionalcliente@beneficiosvacacionales.mx
                                </a>
                            </li>
                            <li>
                                <a class="d-flex" href="mailto:claudia.munoz@beneficiosvacacionales.mx">
                                    claudia.munoz@beneficiosvacacionales.mx
                                </a>
                            </li>
                            <li>
                                <a class="d-flex" href="tel:5586626070">
                                    5586626070
                                </a>
                            </li>
                        </ul>
                    </aside>
                    {{--
                    <aside class="single_sidebar_widget newsletter_widget">
                        <h4 class="widget_title">
                            Lista de Hoteles
                        </h4>
                        <ul class="list">
                            <li>
                                <a class="modal_hoteles" data-hotel="images/todo_incluido.png" data-titulo="Hoteles todo incluido" href="">
                                    <img alt="" src="{{ asset('images/todo_incluido.png') }}" width="80px">
                                    </img>
                                    Plan todo Incluido
                                </a>
                            </li>
                            <li>
                                <a class="modal_hoteles" data-hotel="images/plan_europeo.png" data-titulo="Hoteles con desayuno" href="">
                                    <img alt="" src="{{ asset('images/plan_europeo.png') }}" width="80px">
                                    </img>
                                    Plan con desayuno
                                </a>
                            </li>
                            <li>
                                <a class="modal_hoteles" data-hotel="images/cotizacion.png" data-titulo="Hoteles con previa cotización" href="">
                                    <img alt="" src="{{ asset('images/cotizacion.png') }}" width="80px">
                                    </img>
                                    Previa cotización
                                </a>
                            </li>
                        </ul>
                    </aside>
                    --}}
                    <aside class="single_sidebar_widget newsletter_widget">
                        <h4 class="widget_title">
                            Calendario de temporadas
                        </h4>
                        <p>
                            <a class="modal_hoteles" data-hotel="https://admin.beneficiosvacacionales.mx/{{ $cal_temp }}" data-titulo="Calendario" href="#">
                                <img alt="" src="https://admin.beneficiosvacacionales.mx/{{ $cal_temp }}">
                                </img>
                            </a>
                        </p>
                    </aside>
                    {{--
                    <aside class="single_sidebar_widget newsletter_widget">
                        <h4 class="widget_title">
                            Calendario Paquetes con Aéreos
                        </h4>
                        <p>
                            <a class="modal_hoteles" data-hotel="images/CAL-AEREO.jpg" href="">
                                <img alt="" src="{{ asset('images/CAL-AEREO.jpg') }}">
                                </img>
                            </a>
                        </p>
                    </aside>
                    --}}
                    <aside class="single_sidebar_widget newsletter_widget">
                        <h4 class="widget_title">
                            Recuerda que ahora es mas facil realizar tu reservacion...
                            <a href="{{ route('tuto_reserva') }}">
                                Ver tutorial
                            </a>
                        </h4>
                        {{--
                        <p class="text-center">
                            <a href="{{ asset('files/Papeleta.pdf') }}" target="_blank">
                                <img alt="" src="https://upload.wikimedia.org/wikipedia/commons/thumb/8/87/PDF_file_icon.svg/1200px-PDF_file_icon.svg.png" width="30%">
                                </img>
                            </a>
                        </p>
                        --}}
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
                                    <h2 class="text-danger">
                                        Destinos aplicables a el paquete promocional Buen fin 2023
                                    </h2>
                                    {{--
                                    <img alt="" class="img-fluid" src="{{ asset('images/cotizador.jpg') }}">
                                    </img>
                                    --}}
                                </div>
                            </div>
                        </div>
                         <div class="row">
                            <div class="col-md-4">
                                <ul class="unordered-list">
                                    <li>Huatulco</li>
                                    <li>Veracruz</li>
                                    <li>Cancun</li>
                                    <li>Puebla</li>
                                </ul>    
                            </div>
                            <div class="col-md-4">
                                <ul class="unordered-list">
                                    <li>Queretaro</li>
                                    <li>Guanajuato</li>
                                    <li>Pachuca</li>
                                    <li>Oaxaca</li>
                                </ul>
                            </div>
                            <div class="col-md-4">
                                <ul class="unordered-list">
                                    <li>Guadalajara</li>
                                    <li>Aguascalientes</li>
                                    <li>Villahermosa</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <p>
                        *Para mas información contacta a tu asesor de ventas
                    </p>
                    <p class="text-danger lead">
                        <b>    
                        ***espera los nuevos destinos que se agregaran próximamente***
                        </b>
                    </p>
                </section>
                <br>
                @include('pagina.mx.elementos.hoteles_todo_incluido')
                @include('pagina.mx.elementos.hoteles_europeo')
                @include('pagina.mx.elementos.hoteles_cotizacion')
            </div>
        </div>
    </div>
</section>
<!-- Modal -->
<div aria-hidden="true" aria-labelledby="staticBackdropLabel" class="modal fade mt-5 pt-4 mb-5 pb-5" id="modalHoteles" tabindex="-1">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-info" id="titulo">
                </h5>
                <button aria-label="Close" class="close" data-dismiss="modal" type="button">
                    <span aria-hidden="true">
                        ×
                    </span>
                </button>
            </div>
            <div class="modal-body text-center">
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" data-dismiss="modal" type="button">
                    Cerrar
                </button>
            </div>
        </div>
    </div>
</div>
<!-- Modal -->
<div aria-hidden="true" aria-labelledby="staticBackdropLabel" class="modal fade mt-5 pt-4 mb-5 pb-5" id="modalReservacion" tabindex="-1">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">
            {{--
            <div class="modal-header">
                <h5 class="modal-title text-info" id="titulo">
                </h5>
                <button aria-label="Close" class="close" data-dismiss="modal" type="button">
                    <span aria-hidden="true">
                        ×
                    </span>
                </button>
            </div>
            --}}
            <div class="modal-body text-justify">
                @include('pagina.mx.elementos.reservaciones_tuto')
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" data-dismiss="modal" type="button">
                    Cerrar
                </button>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
<script>
    $(document).ready(function() {
        var time  =  Math.floor(Math.random()*8200)+4090;

        console.log(time);
        setTimeout(function(){
            $('#modalReservacion').modal('show');
        }, time);
    });
</script>
@endsection
