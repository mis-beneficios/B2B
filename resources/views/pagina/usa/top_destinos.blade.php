@extends('layouts.pagina.app')
<style type="text/css">
    .breadcrumb .overlay_h {
        opacity: .3;
    }
</style>
@section('content')
<section class="breadcrumb breadcrumb_bg" style="background-image:url({{ asset($img_header) }})">
    <div class="overlay_h">
    </div>
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="breadcrumb_iner">
                    <div class="breadcrumb_iner_item text-center">
                        <p class="lead" style="font-size: 28px;">
                            Visit the Top 10 Destinations within the {{ $title_header }}
                            <br/>
                            With payments starting from $20 Biweekly.
                        </p>
                        <h2>
                            ¡Book Now, Pay Later!
                        </h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="top_place section_padding">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-12">
                <div class="section_tittle text-center">
                    <h2>
                        Top 10 Destinations in the {{ $title_header }}
                    </h2>
                </div>
            </div>
        </div>
        <div class="row justify-content-center">
            @foreach ($destinos as $destino)
            @if($destino->id != 33)
            <div class="col-lg-4 col-md-6">
                <div class="single_place" data-url="{{ route('eu.detalle_estancia', $destino->slug) }}">
                    <img alt="" src="{{ env('STORAGE_EU'). $destino->imagen }}">
                        <div class="hover_Text d-flex align-items-end justify-content-between">
                            <div class="hover_text_iner">
                                <a class="place_btn" href="{{ route('eu.detalle_estancia', $destino->slug) }}">
                                    travel
                                </a>
                                <h3>
                                    {{ $destino->titulo }}
                                </h3>
                            </div>
                            <div class="details_icon text-right">
                                <a href="{{ route('eu.detalle_estancia', $destino->slug) }}">
                                    <i class="fa fa-cart-plus">
                                    </i>
                                </a>
                            </div>
                        </div>
                    </img>
                </div>
            </div>
            @endif
            @endforeach
        </div>
    </div>
</section>
<div aria-hidden="true" aria-labelledby="exampleModalLabel" class="modal fade" id="modalDetalles" style="margin-top: 80px;" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="estancia_titulo">
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
@include('pagina.usa.elementos.modal_preregistro')
@endsection

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
    $(document).on('click', '.single_place', function(event){
        event.preventDefault();
        window.location.href = $(this).data('url');
    });
</script>
@endsection
