@extends('layouts.pagina.app')
@section('content')
<section class="breadcrumb breadcrumb_bg" style="background-image: url(https://assets.entrepreneur.com/content/3x2/2000/20181022170837-gobierno-corporativo.jpeg);">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="breadcrumb_iner">
                    <div class="breadcrumb_iner_item text-center">
                        <h2>
                            ¿Quienes somos?
                        </h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="top_place mt-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-12">
                <div class="row">
                    <div class="col-md-6">
                        <div class="section_tittle text-center">
                            <h2>
                                Nosotros
                            </h2>
                            <p class="text-justify">
                                {{ env('APP_NAME') }} tiene mas de 15 años en el mercado del turismo manejando propuestas vanguardistas que han beneficiado a miles de personas que laboran en las mejores empresas del país.
                            </p>
                            <p class="text-justify">
                                {{ env('APP_NAME') }} es la única empresa mexicana con más de 15 años de trayectoria brindando siempre los mejores paquetes vacacionales, exclusivamente a empresas como un magnífico beneficio para el personal que labora en ellas, somos la única operadora en el país que brinda este servicio a nivel nacional. Somos los únicos capaces de garantizar los mismos precios en temporada alta y baja, con destinos abiertos a cualquier parte de la República, con tarifas espectaculares y con vigencia de un año a partir de la contratación de nuestros servicios, todo esto avalado por un contrato individual para los empleados que tienen el gran privilegio de laborar en las mejores empresas de éste país, quienes han realizado el más exitoso convenio en cuanto a beneficios al personal se refiere.
                            </p>
                        </div>
                    </div>
                    <div class="col-md-6 d-flex align-items-center">
                        <img alt="" class="img-fluid" src="{{ asset('images/icono02.png') }}">
                        </img>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="top_place">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-12">
                <div class="row">
                    <div class="col-md-6">
                        <div class="section_tittle text-center">
                            <h2>
                                {{--  Mision --}}
                                <img alt="" class="img-fluid" src="{{ asset('images/mision.png') }}">
                                </img>
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
                        <div class="section_tittle">
                            <h2>
                                {{-- Valores --}}
                                <img alt="" class="img-fluid" src="{{ asset('images/valores.png') }}">
                                </img>
                            </h2>
                            <p class="text-justify">
                                <h6 class="text-info">
                                    <strong>
                                        Liderazgo
                                    </strong>
                                </h6>
                                <p>
                                    Ofrecer a las familias mexicanas servicios de la más alta calidad,amparados por una garantía de calidad.
                                </p>
                            </p>
                            <p class="text-justify">
                                <h6 class="text-info">
                                    <strong>
                                        Proximidad
                                    </strong>
                                </h6>
                                <p>
                                    Brindar un trato amable y cortés para nuestros clientes para la buena satisfacción de sus necesidades.
                                </p>
                            </p>
                            <p class="text-justify">
                                <h6 class="text-info">
                                    <strong>
                                        Compromiso
                                    </strong>
                                </h6>
                                <p>
                                    Reconocer la contribución individual y colectiva de todas las personas que constituyen la empresa. Compartir con los otros los beneficios del crecimiento y del éxito.
                                </p>
                            </p>
                            <p class="text-justify">
                                <h6 class="text-info">
                                    <strong>
                                        Modernidad
                                    </strong>
                                </h6>
                                <p>
                                    Para ofrecer siempre una imagen fresca, limpia y actual adecuada para una empresa del sector turístico.
                                </p>
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
