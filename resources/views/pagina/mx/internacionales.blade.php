@extends('layouts.pagina.app')
<style>
    .errors {
        font-size: 12px;
    }

    .breadcrumb_int{
        background-image: url({{ asset('images/internacionales.jpg') }});
        /*background-image: url(https://images2.alphacoders.com/526/526619.jpg);*/
        /*background-attachment: fixed;*/
        background-size: cover;
        background-repeat: no-repeat;
        background-position: center 90%;
    }

    .breadcrumb .overlay_h {
        opacity: .3; 
    }
    .desc {
    color: #a2a2a2;
    font-family: "Open Sans", sans-serif;
    line-height: 17px;
    font-size: 16px;
    margin-bottom: 0px;
    font-weight: 400;
}
</style>
@section('content')
<section class="breadcrumb breadcrumb_int">
    <div class="overlay_h">
    </div>
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="breadcrumb_iner">
                    <div class="breadcrumb_iner_item text-center">
                        <h2>
                            Conoce nuestros estancias para destinos internacionales
                        </h2>
                        <p class="lead">
                            @if ($convenio != null)
                                {{ $convenio->welcome }}
                            @else
                                {{ session()->get('convenio_id') != '1208' ? (session()->get('welcome') != null ? session()->get('convenio_nombre') : session()->get('welcome')) : '' }}
                            @endif
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="top_place mt-5">
    <div class="container">
        <ul class="nav nav-pills flex-column flex-sm-row" id="myTab" role="tablist">
            <li class="nav-item " role="presentation">
                <a aria-controls="home" aria-selected="true" class="flex-sm-fill text-sm-center nav-link active" data-toggle="tab" href="#home" id="home-tab" role="tab">
                    Top USA
                </a>
            </li>
            <li class="nav-item" role="presentation">
                <a aria-controls="profile" aria-selected="false" class="flex-sm-fill text-sm-center nav-link" data-toggle="tab" href="#profile" id="profile-tab" role="tab">
                    Top Europa
                </a>
            </li>
            {{--
            <li class="nav-item" role="presentation">
                <a aria-controls="contact" aria-selected="false" class="nav-link" data-toggle="tab" href="#contact" id="contact-tab" role="tab">
                    Top Caribe
                </a>
            </li>
            --}}
        </ul>
        <div class="tab-content" id="myTabContent">
            <div aria-labelledby="home-tab" class="tab-pane fade show active" id="home" role="tabpanel">
                <div class="row">
                    <div class="col-xl-12">
                        <div class="section_tittle">
                            <h2 class="">
                                Destinos Internacionales en USA
                            </h2>
                            <p>
                                <ul>
                                    <li>
                                        • 24 cómodos pagos quincenales para 2 personas y 2 menores.
                                    </li>
                                    <li>
                                        • Los paquetes son totalmente transferibles.
                                    </li>
                                    <li>
                                        • Precios muy por debajo de las tarifas que ofrecen los hoteles que manejamos.
                                    </li>
                                    <li>
                                        • No es necesario decidir fecha o destino del viaje al momento de la inscripción.
                                    </li>
                                </ul>
                            </p>
                        </div>
                    </div>
                </div>
                <div class="row">
                    @foreach ($destinos_usa as $destino)
                    <div class="col-lg-4 col-md-6">
                        <div class="single_place">
                            <img alt="" src="{{ env('STORAGE_EU'). $destino->imagen }}">
                                <div class="hover_Text d-flex align-items-end justify-content-between">
                                    <div class="hover_text_iner">
                                        <a class="place_btn info" href="{{ route('detalle_estancia_int', $destino->slug) }}">
                                            Inscribirse
                                        </a>
                                        <h4 style="color: white;">
                                            <a class="text-white" href="{{ route('detalle_estancia_int', $destino->slug) }}">
                                                {{ $destino->titulo }}
                                            </a>
                                        </h4>
                                        {{--
                                        <p>
                                            <button class="genric-btn info small" data-id="{{ $destino->id }}" data-titulo="{{ $destino->title }}" id="btnDetalles" value="{{ $destino->id }}">
                                                Detalles
                                            </button>
                                        </p>
                                        --}}
                                    </div>
                                </div>
                            </img>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            <div aria-labelledby="profile-tab" class="tab-pane fade" id="profile" role="tabpanel">
                <div class="row">
                    <div class="col-xl-12">
                        <div class="section_tittle">
                            <h2 class="">
                                Destinos Internacionales en Europa
                            </h2>
                            <p>
                                <ul>
                                    <li>
                                        • 24 cómodos pagos quincenales para 2 personas y 2 menores.
                                    </li>
                                    <li>
                                        • Los paquetes son totalmente transferibles.
                                    </li>
                                    <li>
                                        • Precios muy por debajo de las tarifas que ofrecen los hoteles que manejamos.
                                    </li>
                                    <li>
                                        • No es necesario decidir fecha o destino del viaje al momento de la inscripción.
                                    </li>
                                </ul>
                            </p>
                        </div>
                    </div>
                </div>
                <div class="row">
                    @foreach ($destinos_europa as $destino)
                    <div class="col-lg-4 col-md-6">
                        <div class="single_place">
                            <img alt="" src="{{ env('STORAGE_EU'). $destino->imagen }}">
                                <div class="hover_Text d-flex align-items-end justify-content-between">
                                    <div class="hover_text_iner">
                                        <a class="place_btn info" href="{{ route('detalle_estancia_int', $destino->slug) }}">
                                            Inscribirse
                                        </a>
                                        <h4 style="color: white;">
                                            <a class="text-white" href="{{ route('detalle_estancia_int', $destino->slug) }}">
                                                {{ $destino->titulo }}
                                            </a>
                                        </h4>
                                        {{--
                                        <p>
                                            <button class="genric-btn info small" data-id="{{ $destino->id }}" data-titulo="{{ $destino->title }}" id="btnDetalles" value="{{ $destino->id }}">
                                                Detalles
                                            </button>
                                        </p>
                                        --}}
                                    </div>
                                </div>
                            </img>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            <div aria-labelledby="contact-tab" class="tab-pane fade" id="contact" role="tabpanel">
                <div class="row">
                    <div class="col-xl-12">
                        <div class="section_tittle">
                            <h2 class="">
                                Destinos Internacionales en Europa
                            </h2>
                            <p>
                                <ul>
                                    <li>
                                        • 24 cómodos pagos quincenales para 2 personas y 2 menores.
                                    </li>
                                    <li>
                                        • Los paquetes son totalmente transferibles.
                                    </li>
                                    <li>
                                        • Precios muy por debajo de las tarifas que ofrecen los hoteles que manejamos.
                                    </li>
                                    <li>
                                        • No es necesario decidir fecha o destino del viaje al momento de la inscripción.
                                    </li>
                                </ul>
                            </p>
                        </div>
                    </div>
                </div>
                <div class="row">
                    @foreach ($destinos_caribe as $destino)
                    <div class="col-lg-4 col-md-6">
                        <div class="single_place">
                            <img alt="" src="{{ env('STORAGE_EU'). $destino->imagen }}">
                                <div class="hover_Text d-flex align-items-end justify-content-between">
                                    <div class="hover_text_iner">
                                        <a class="place_btn info" href="{{ route('detalle_estancia_int', $destino->slug) }}">
                                            Inscribirse
                                        </a>
                                        <h4 style="color: white;">
                                            <a class="text-white" href="{{ route('detalle_estancia_int', $destino->slug) }}">
                                                {{ $destino->titulo }}
                                            </a>
                                        </h4>
                                        {{--
                                        <p>
                                            <button class="genric-btn info small" data-id="{{ $destino->id }}" data-titulo="{{ $destino->title }}" id="btnDetalles" value="{{ $destino->id }}">
                                                Detalles
                                            </button>
                                        </p>
                                        --}}
                                    </div>
                                </div>
                            </img>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>
<div aria-hidden="true" aria-labelledby="exampleModalLabel" class="modal fade" id="modalDetalles" style="margin-top: 80px;" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="estancia_titulo" style="color: black;">
                </h5>
                <button aria-label="Close" class="close" data-dismiss="modal" type="button">
                    <span aria-hidden="true">
                        ×
                    </span>
                </button>
            </div>
            <div class="modal-body" id="modal_content">
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary btn-sm" data-dismiss="modal" type="button">
                    Cerrar
                </button>
                <a class="btn btn-primary btn-sm" id="bntInscribir" type="button">
                    Inscribirse
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
@include('pagina.mx.elementos.modal_preregistro')
@section('script')
<script>
    $('body').on('click', '#btnDetalles', function(event) {
            event.preventDefault();
            var id_estancia = $(this).attr('value');
            var titulo = $(this).data('titulo');
            $.ajax({
                url: baseuri + 'estancia-detalles/' + id_estancia,
                type: 'GET',
                dataType: 'json',
                beforeSend: function() {
                    $("#overlay").css("display", "block");
                },
                success: function(res) {
                    $("#overlay").css("display", "none");
                    if (res.success == true) {
                        $('#modalDetalles #estancia_titulo').html('Detalles: ' + titulo);
                        $('#modalDetalles #modal_content').html(res.estancia.descripcion);
                        $('#bntInscribir').attr('href', baseuri + 'detalle-estancia/' + res.estancia
                            .id);
                        $('#modalDetalles').modal('show');
                    }
                },
            });
        });
</script>
@endsection
