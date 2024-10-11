@extends('layouts.pagina.app')

@section('content')
<section class="breadcrumb breadcrumb_bg">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="breadcrumb_iner">
                    <div class="breadcrumb_iner_item text-center">
                        <h2>
                            Orlando
                        </h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="hotel_list section_padding single_page_hotel_list">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xl-6">
                    <div class="section_tittle text-center">
                        <h2>Conoce nuestras casas en Orlando</h2>
                        {{-- <p>Waters make fish every without firmament saw had. Morning air subdue. Our. Air very one. Whales grass is fish whales winged.</p> --}}
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-4 col-sm-6">
                    <div class="single_ihotel_list">
                        <img src="{{ asset('images/house/1/19.jpg') }}" alt="">
                        <div class="hotel_text_iner">
                            <h3> 
                                <a href="#">{{ $estancias[0]->title }}</a>
                            </h3>
                            <div class="place_review">
                                <a href="#"><i class="fas fa-star"></i></a>
                                <a href="#"><i class="fas fa-star"></i></a>
                                <a href="#"><i class="fas fa-star"></i></a>
                                <a href="#"><i class="fas fa-star"></i></a>
                                <a href="#"><i class="fas fa-star"></i></a>
                                  <span>({{ rand(300, 400) }} Vistas)</span>
                            </div>
                            <p>Habitaciones: 8</p>
                            <p>Baños: 5</p>
                            <p>Max. de personas: 16</p>
                            {{-- <p></p> --}}
                            <h5>Desde <span>$500 {{ $estancias[0]->divisa }}</span> por noche</h5>
                        </div>
                        <a href="{{ route('detalle_orlando', $estancias[0]->id) }}" class="btn_1 d-none d-lg-block text-center">Reservar</a>
                    </div>
                </div>
                <div class="col-lg-4 col-sm-6">
                    <div class="single_ihotel_list">
                        <img src="{{ asset('images/house/1/4e.jpg') }}" alt="">

                        <div class="hotel_text_iner">
                            <h3> <a href="#"> {{ $estancias[1]->title }}</a></h3>
                            <div class="place_review">
                                <a href="#"><i class="fas fa-star"></i></a>
                                <a href="#"><i class="fas fa-star"></i></a>
                                <a href="#"><i class="fas fa-star"></i></a>
                                <a href="#"><i class="fas fa-star"></i></a>
                                <a href="#"><i class="fas fa-star"></i></a>
                                <span>({{ rand(300, 400) }} Vistas)</span>
                            </div>
                            <p>Habitaciones: 8</p>
                            <p>Baños: 5</p>
                            <p>Max. de personas: 16</p>
                            {{-- <p></p> --}}
                             <h5>Desde <span>$500 {{ $estancias[0]->divisa }}</span> por noche</h5>
                        </div>
                        <a href="{{ route('detalle_orlando', $estancias[1]->id) }}" class="btn_1 d-none d-lg-block text-center">Reservar</a>
                    </div>
                </div>
                <div class="col-lg-4 col-sm-6">
                    <div class="single_ihotel_list">
                        <img src="{{ asset('images/house/1/18.jpg') }}" alt="">
                        <div class="hotel_text_iner">
                            <h3> <a href="#"> {{ $estancias[2]->title }}</a></h3>
                            <div class="place_review">
                                <a href="#"><i class="fas fa-star"></i></a>
                                <a href="#"><i class="fas fa-star"></i></a>
                                <a href="#"><i class="fas fa-star"></i></a>
                                <a href="#"><i class="fas fa-star"></i></a>
                                <a href="#"><i class="fas fa-star"></i></a>
                             <span>({{ rand(300, 400) }} Vistas)</span>
                            </div>
                            <p>Habitaciones: 8</p>
                            <p>Baños: 5</p>
                            <p>Max. de personas: 16</p>
                            {{-- <p></p> --}}
                            <h5>Desde <span>$500 {{ $estancias[0]->divisa }}</span> por noche</h5>
                        </div>
                        <a href="{{ route('detalle_orlando', $estancias[2]->id) }}" class="btn_1 d-none d-lg-block text-center">Reservar</a>
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
@include('pagina.mx.elementos.modal_preregistro')
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
</script>
@endsection
