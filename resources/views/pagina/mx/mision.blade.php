@extends('layouts.pagina.app')
@section('content')
<section class="top_place">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-12">
                <div class="row">
                    <div class="col-md-6">
                        <div class="section_tittle text-center">
                            <h2>
                                Mision
                            </h2>
                            <p class="text-justify">
                                Nuestra misión es ofrecer los mejores planes vacacionales al personal para cualquier destino dentro de la República Mexicana  hospedándose en hoteles de excelente categoría y con las mejores tarifas del mercado, todo esto bajo un esquema perfecto de pagos diferidos.
                            </p>
                            <p class="text-justify">
                                Este gran BENEFICIO nos permitirá brindar opciones que  satisfagan las necesidades de descanso, de negocios, de esparcimiento familiar y de convivencia a un bajo costo, además de promover el patrimonio turístico nacional beneficiando así a la industria hotelera y servicios del turismo en México.
                            </p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <img alt="" class="img-fluid" src="{{ asset('images/mision.png') }}">
                        </img>
                    </div>
                    <div class="col-md-6">
                        <img alt="" class="img-fluid" src="{{ asset('images/valores.png') }}">
                        </img>
                    </div>
                    <div class="col-md-6">
                        <div class="section_tittle text-center">
                            <h2>
                                Valores
                            </h2>
                            <p class="text-justify">
                                <h6 class="text-info">
                                    <strong>
                                        Liderazgo
                                    </strong>
                                </h6>
                                Ofrecer a las familias mexicanas servicios de la más alta calidad,amparados por una garantía de calidad.
                            </p>
                            <p class="text-justify">
                                <h6 class="text-info">
                                    <strong>
                                        Proximidad
                                    </strong>
                                </h6>
                                Brindar un trato amable y cortés para nuestros clientes para la buena satisfacción de sus necesidades.
                            </p>
                            <p class="text-justify">
                                <h6 class="text-info">
                                    <strong>
                                        Compromiso
                                    </strong>
                                </h6>
                                Reconocer la contribución individual y colectiva de todas las personas que constituyen la empresa. Compartir con los otros los beneficios del crecimiento y del éxito.
                            </p>
                            <p class="text-justify">
                                <h6 class="text-info">
                                    <strong>
                                        Modernidad
                                    </strong>
                                </h6>
                                Para ofrecer siempre una imagen fresca, limpia y actual adecuada para una empresa del sector turístico.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
@section('script')
@endsection
