@extends('layouts.pagina.app')
@section('content')
<style type="text/css">
</style>
{{--
<section class="breadcrumb breadcrumb_bg" style="background-image: url(https://vallartalifestyles.com/wp-content/uploads/2020/12/muelle-l-1.jpg)">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="breadcrumb_iner">
                    <div class="breadcrumb_iner_item text-center">
                        <h2>
                            Bienvenido a
                            <strong>
                                Mis Beneficios Vacacionales
                            </strong>
                        </h2>
                        <p>
                            ¡Gracias por inscribirte a este gran beneficios que tenemos para ti!
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
--}}
<section class="hotel_list single_page_hotel_list mb-5">
    <div class="container">
        <div class="row justify-content-start">
            <div class="col-xl-12">
                <div class="section_tittle">
                    <h2 class="text-center">
                        Bienvenido
                        <strong class="text-capitalize">
                            {{ $contrato->cliente->fullName }}
                        </strong>
                    </h2>
                    <p class="text-center">
                        ¡Disfruta de este y otros beneficios que {{ env('APP_NAME') }} tiene para ti!
                    </p>
                    <div class="text-center mt-3">
                        <img src="{{ asset('images/icono02.png') }}" alt="" style="width: 20%;">
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="owl-item cloned mb-3" style="">
                    <div class="single_event_slider">
                        <div class="rowd">
                            <div class="col-lg-12 col-md-12">
                                <div class="event_slider_content">
                                    <h5 class="text-info">
                                        Detalles de contrato
                                    </h5>
                                    <p class="mb-2">
                                        Paquete:
                                        <strong>
                                            {{$contrato->paquete}}
                                        </strong>
                                    </p>
                                    <p class="mb-2">
                                        Folio:
                                        <strong>
                                            {{$contrato->id}}
                                        </strong>
                                    </p>
                                    <p class="mb-2">
                                        Vigencia:
                                        <strong>
                                            1 año y medio
                                        </strong>
                                    </p>
                                    <p class="mb-2">
                                        Precio de compra:
                                        <strong>
                                            ${{$contrato->precio_de_compra}} {{$contrato->estancia->divisa}}
                                        </strong>
                                    </p>
                                    {{--
                                    <p>
                                        Destinos:
                                        <span>
                                            {!!$contrato->estancia->descripcion!!}
                                        </span>
                                    </p>
                                    --}}
                                    <button class="btn btn-primary btn-sm" data-target="#exampleModalLong" data-toggle="modal" type="button">
                                        Ver detalles
                                    </button>
                                    <button class="btn btn-success btn-sm" id="btnContrato" type="button">
                                        Ver contrato
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="owl-item cloned mb-3" style="">
                    <div class="single_event_slider">
                        <div class="rowd">
                            <div class="col-lg-12 col-md-12">
                                <div class="event_slider_content">
                                    <h5 class="text-info">
                                        Detalles de usuario
                                    </h5>
                                    <p class="mb-2">
                                        Nombre:
                                        <strong>
                                            {{$contrato->cliente->fullName}}
                                        </strong>
                                    </p>
                                    <p class="mb-2">
                                        Correo electronico:
                                        <strong>
                                            {{$contrato->cliente->username}}
                                        </strong>
                                    </p>
                                    <p class="mb-2">
                                        Telefono:
                                        <strong>
                                            {{$contrato->cliente->telefono}}
                                        </strong>
                                    </p>
                                    <p class="mb-2">
                                        Direccion:
                                        <strong>
                                            {{$contrato->cliente->direccion}}
                                        </strong>
                                    </p>
                                </div>
                                <a class="btn btn-primary btn-sm" href="{{ route('dashboard') }}" type="button">
                                    Ir a mi panel
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Modal -->
<div aria-hidden="true" aria-labelledby="exampleModalLongTitle" class="modal fade" id="exampleModalLong" role="dialog" tabindex="-1">
    <div class="modal-dialog modal-dialog-scrollable|modal-dialog-centered modal-sm|modal-lg|modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">
                    Detalles
                </h5>
                <button aria-label="Close" class="close" data-dismiss="modal" type="button">
                    <span aria-hidden="true">
                        ×
                    </span>
                </button>
            </div>
            <div class="modal-body">
                <p>
                    Destinos:
                    <span>
                        {!!$contrato->estancia->descripcion!!}
                    </span>
                </p>
            </div>
            <div class="modal-footer">
                <button class="btn btn-light" data-dismiss="modal" type="button">
                    Cerrar
                </button>
            </div>
        </div>
    </div>
</div>
<div aria-hidden="true" aria-labelledby="exampleModalLongTitle" class="modal fade" id="modalContrato" role="dialog" tabindex="-1">
    <div class="modal-dialog modal-dialog-scrollable modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button aria-label="Close" class="close" data-dismiss="modal" type="button">
                    <span aria-hidden="true">
                        ×
                    </span>
                </button>
            </div>
            <div class="modal-body" id="bodyContrato">
            </div>
            <div class="modal-footer">
                <button class="btn btn-light" data-dismiss="modal" type="button">
                    Cerrar
                </button>
                <a class="btn btn-dark" id="downloadPdf" href="" target="_blank" type="button">
                    Descargar
                </a>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
    $(document).ready(function() {
        $('#btnContrato').on('click',function(event){
            event.preventDefault();
            $.ajax({
                url: baseuri + 'mostrar-contrato/' +{{$contrato->id}},
                type: 'GET',
                dataType: 'json',
                beforeSend:function(){
                    $("#overlay").css("display", "block");
                },
                success:function(res){
                    $("#overlay").css("display", "none");
                    $('#bodyContrato').html(res.formato);
                    $('#modalContrato #downloadPdf').attr('href', res.name);
                    $('#modalContrato').modal('show');
                }
            });
        });
    });
</script>
@endsection
