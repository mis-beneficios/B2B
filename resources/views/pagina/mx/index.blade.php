@extends('layouts.pagina.app')
@section('content')
<style>
    .owl-alto{
        height: 60px;
    }
    .owl-alto img{
        max-height: 60px;
        max-width: 70%;
    }
</style>
<div class="container text-center">
    <div class="row mt-2">
        <div class="col-lg-12">
            <p class="lead text-muted mb-2">
                A continuación te mostramos algunas de las empresas que actualmente están tomando sus vacaciones con nuestros paquetes, para que no esperes más y disfrutes con tu familia y amigos de esta magnifica oportunidad.
            </p>
            <div class="owl-carousel owl-theme owl-alto" id="carouselExampleSlidesOnly">
                @if ($data_convenios != null)
                    @foreach ($data_convenios as $bienvenida)
                    @if ($bienvenida->logo != null)
                    {{-- || file_exists(Storage::disk('s3')->get($bienvenida->logo)) --}}
                        <img alt="{{ $bienvenida->empresa_nombre }}" class="img-fluid m-1" src="{{ Storage::disk('s3')->url($bienvenida->logo) }}"/> 
                    @endif
                    @endforeach
                @endif
                @php
                    $logos = Storage::disk('path_public')->files('/images/empresas')
                @endphp
                @foreach ($logos as $logo)
                    <img alt="Algunas Empresas Afiliadas" class="img-fluid m-1" src="{{ asset($logo) }}"/>
                @endforeach
            </div>
        </div>
    </div>
</div>

{{-- {{ $bienvenidas }} --}}
<section class="blog_area single-post-area mt-3">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 posts-list">
                <div class="single-post">
                    <div class="feature-img">
                        <div class="carousel slide" data-ride="carousel" id="carouselExampleControls">
                            <div class="carousel-inner">
                                <div class="carousel-item active">
                                    <a href="/productos/mxnativaglobal" title="Nativa Global">
                                        <img alt="Nativa Global" border="0" src="{{ asset('images/bienvenidas/nativa_global.jpg') }}"/>
                                    </a>
                                </div>

                                @if ($data_convenios != null)
                                    @foreach ($data_convenios as $bienvenida)
                                    @if ($bienvenida->img_bienvenida != null || file_exists(Storage::disk('s3')->url($bienvenida->img_bienvenida)))
                                        <div class="carousel-item">
                                            <a href="/productos/{{ $bienvenida->llave }}" title="{{ $bienvenida->empresa_nombre }}">
                                                <img alt="{{ $bienvenida->empresa_nombre }}" border="0" src="{{ Storage::disk('s3')->url($bienvenida->img_bienvenida) }}"/>
                                            </a>
                                        </div>        
                                    @endif
                                    @endforeach
                                @endif
                                <div class="carousel-item">
                                    <a href="/productos/mxlecumberri" title="mxlecumberri">
                                        <img alt="GRUPO LECUMBERRI" border="0" src="{{ asset('images/bienvenidas/grupo_lec.jpg') }}"/>
                                    </a>
                                </div>
                                <div class="carousel-item">
                                    <a href="/productos/mxgrupoherdez" title="mxgrupoherdez">
                                        <img alt="GRUPO HERDEZ" border="0" src="{{ asset('images/bienvenidas/herdez.png') }}"/>
                                    </a>
                                </div>
                                <div class="carousel-item ">
                                    <a href="/productos/mxsurma" title="mxsurma">
                                        <img alt="GRUPO SURMAN" border="0" src="{{ asset('images/bienvenidas/SURMAN.png') }}"/>
                                    </a>
                                </div>
                                <div class="carousel-item ">
                                    <a href="/productos/mxpremier" title="mxpremier">
                                        <img alt="PREMIER AUTOMOTRIZ" border="0" src="{{ asset('images/bienvenidas/premier_automotriz.png') }}"/>
                                    </a>
                                </div>
                                <div class="carousel-item">
                                    <a href="/productos/mxtdconsentido" title="mxtdconsentido">
                                        <img alt="UNI" border="0" src="{{ asset('images/bienvenidas/uni.png') }}"/>
                                    </a>
                                </div>
                                <div class="carousel-item">
                                    <a href="/productos/mxhogaresunion" title="mxhogaresunion">
                                        <img alt="Hogares Union" border="0" src="{{ asset('images/bienvenidas/GIM-min.png') }}"/>
                                    </a>
                                </div>
                                <div class="carousel-item">
                                    <a href="/productos/mxpromotional" title="mxpromotional">
                                        <img alt="FOR PROMOTIONAL SA DE CV" border="0" src="{{ asset('images/bienvenidas/4for-min.png') }}"/>
                                    </a>
                                </div>
                                <div class="carousel-item">
                                    <a href="/productos/mxvitalmex" title="mxvitalmex">
                                        <img alt="Vitalmex" border="0" src="{{ asset('images/bienvenidas/vitalmex-min.png') }}"/>
                                    </a>
                                </div>
                                <div class="carousel-item">
                                    <a href="/productos/mxtkmsolutions" title="">
                                        <img alt="TKM solutions y GIN" border="0" src="{{ asset('images/bienvenidas/tkm.png') }}"/>
                                    </a>
                                </div>
                                <div class="carousel-item">
                                    <a href="/productos/mxcia" title="">
                                        <img alt="CIA CONSULTORES" border="0" src="{{ asset('images/bienvenidas/cia.png') }}"/>
                                    </a>
                                </div>
                                <div class="carousel-item">
                                    <a href="/productos/mxsinalict" title="mxsinalict">
                                        <img alt="SINDICATO REVOLUCIONARIO NACIONAL DE LOS TRABAJADORES DE LA SECRETARÍA DE INFRAESTRUCTURA, COMUNICACIONES Y TRANSPORTES" border="0" src="{{ asset('images/bienvenidas/bien01.jpg') }}"/>
                                    </a>
                                </div>
                                <div class="carousel-item">
                                    <a href="/productos/mxsuthcg" title="mxsuthcg">
                                        <img alt="Sindicato Unico de Trabajadores del Hospital Civil de Guadalajara" border="0" src="{{ asset('images/bienvenidas/bien02.jpg') }}"/>
                                    </a>
                                </div>
                                <div class="carousel-item">
                                    <a href="/productos/mxudlap" title="mxudlap">
                                        <img alt="TDC" border="0" src="{{ asset('images/bienvenidas/tdc.png') }}"/>
                                    </a>
                                </div>
                                <div class="carousel-item">
                                    <a href="/productos/mxefseg" title="EAGLE FRONT SEGURIDAD PRIVADA">
                                        <img alt="EAGLE FRONT SEGURIDAD PRIVADA" border="0" src="{{ asset('images/bienvenidas/front.png') }}"/>
                                    </a>
                                </div>
                                <div class="carousel-item">
                                    <a href="/productos/mxohla" title="OHLA/Premol">
                                        <img alt="OHLA/Premol" border="0" src="{{ asset('images/bienvenidas/ohla.png') }}"/>
                                    </a>
                                </div>
                                <div class="carousel-item">
                                    <a href="/productos/mxgobmex" title="Carvajal">
                                        <img alt="Carvajal" border="0" src="{{ env('STORAGE') }}/shared/home_pictures/es/Mesa_de_trabajo_1-min.png"/>
                                    </a>
                                </div>
                                <div class="carousel-item">
                                    <a href="/productos/mxorbia" title="Ciosa">
                                        <img alt="Ciosa" border="0" src="{{ env('STORAGE') }}/shared/home_pictures/es/Mesa_de_trabajo_2-min.png"/>
                                    </a>
                                </div>
                                {{--
                                <div class="carousel-item">
                                    <a href="/productos/clgointegro" title="Diagnostico Aries">
                                        <img alt="Diagnostico Aries" border="0" src="{{ env('STORAGE') }}/shared/home_pictures/es/Mesa_de_trabajo_3-min.png"/>
                                    </a>
                                </div>
                                --}}
                                <div class="carousel-item">
                                    <a href="/productos/mxcuartodekilo" title="Ensables Humano">
                                        <img alt="Ensables Humano" border="0" src="{{ env('STORAGE') }}/shared/home_pictures/es/Mesa_de_trabajo_4-min.png"/>
                                    </a>
                                </div>
                                <div class="carousel-item">
                                    <a href="/productos/mxbwigo" title="ahorra seguro">
                                        <img alt="ahorra seguro" border="0" src="{{ env('STORAGE') }}/shared/home_pictures/es/Mesa_de_trabajo_5-min.png"/>
                                    </a>
                                </div>
                                <div class="carousel-item">
                                    <a href="/productos/mxmvs" title="Secretaria de Educacion Publica">
                                        <img alt="Secretaria de Educacion Publica" border="0" src="{{ env('STORAGE') }}/shared/home_pictures/es/Mesa_de_trabajo_6-min.png"/>
                                    </a>
                                </div>
                                <div class="carousel-item">
                                    <a href="/productos/mxtetrapak" title="SICREDIT">
                                        <img alt="SICREDIT" border="0" src="{{ env('STORAGE') }}/shared/home_pictures/es/Mesa_de_trabajo_7-min.png"/>
                                    </a>
                                </div>
                                <div class="carousel-item">
                                    <a href="/productos/mxcarvajal" title="Compartamos Banco">
                                        <img alt="Compartamos Banco" border="0" src="{{ env('STORAGE') }}/shared/home_pictures/es/Mesa_de_trabajo_8-min.png"/>
                                    </a>
                                </div>
                                <div class="carousel-item">
                                    <a href="/productos/mxsingh" title="FESolidaridad ">
                                        <img alt="FESolidaridad" border="0" src="{{ env('STORAGE') }}/shared/home_pictures/es/Mesa_de_trabajo_26-min.png"/>
                                    </a>
                                </div>
                             {{--    <div class="carousel-item">
                                    <a href="/productos/mxcarso">
                                        <img src="{{ env('STORAGE') }}/shared/home_pictures/es/Mesa_de_trabajo_10-min.png"/>
                                    </a>
                                </div> --}}
                                {{-- <div class="carousel-item">
                                    <a href="/productos/mxevenplan">
                                        <img src="{{ env('STORAGE') }}/shared/home_pictures/es/Mesa_de_trabajo_11-min.png"/>
                                    </a>
                                </div> --}}
                                <div class="carousel-item">
                                    <a href="/productos/mxcinepolis">
                                        <img src="{{ env('STORAGE') }}/shared/home_pictures/es/Mesa_de_trabajo_12-min2.png"/>
                                    </a>
                                </div>
                              {{--   <div class="carousel-item">
                                    <a href="/productos/mxgsalinas">
                                        <img src="{{ env('STORAGE') }}/shared/home_pictures/es/Mesa_de_trabajo_13-min.png"/>
                                    </a>
                                </div> --}}
                                <div class="carousel-item">
                                    <a href="/productos/mxgifseguridad">
                                        <img src="{{ env('STORAGE') }}/shared/home_pictures/es/Mesa_de_trabajo_14-min.png"/>
                                    </a>
                                </div>
                              {{--   <div class="carousel-item">
                                    <a href="/productos/mxaarco">
                                        <img src="{{ env('STORAGE') }}/shared/home_pictures/es/Mesa_de_trabajo_15-min.png"/>
                                    </a>
                                </div> --}}
                                <div class="carousel-item">
                                    <a href="/productos/mxhogaresunion">
                                        <img src="{{ env('STORAGE') }}/shared/home_pictures/es/Mesa_de_trabajo_16-min.png"/>
                                    </a>
                                </div>
                                <div class="carousel-item">
                                    <a href="/productos/mxaliato">
                                        <img src="{{ env('STORAGE') }}/shared/home_pictures/es/Mesa_de_trabajo_17-min.png"/>
                                    </a>
                                </div>
                                <div class="carousel-item">
                                    <a href="/productos/mxissfam">
                                        <img src="{{ env('STORAGE') }}/shared/home_pictures/es/Mesa_de_trabajo_18-min.png"/>
                                    </a>
                                </div>
                                <div class="carousel-item">
                                    <a href="/productos/mxisse">
                                        <img src="{{ env('STORAGE') }}/shared/home_pictures/es/Mesa_de_trabajo_20-min.png"/>
                                    </a>
                                </div>
                                <div class="carousel-item">
                                    <a href="/productos/mxunam" title="ahorra seguro">
                                        <img alt="ahorra seguro" border="0" src="{{ env('STORAGE') }}/shared/home_pictures/es/Mesa_de_trabajo_21-min.png"/>
                                    </a>
                                </div>
                                <div class="carousel-item">
                                    <a href="/productos/mxcomparbanco" title="Fraiche">
                                        <img alt="Fraiche" border="0" src="{{ env('STORAGE') }}/shared/home_pictures/es/Mesa_de_trabajo_22-min.png"/>
                                    </a>
                                </div>
                                <div class="carousel-item">
                                    <a href="/productos/mxcfe" title="Gif Seguridad">
                                        <img alt="Gif seguridad" border="0" src="{{ env('STORAGE') }}/shared/home_pictures/es/Mesa_de_trabajo_23-min.png"/>
                                    </a>
                                </div>
                                <div class="carousel-item">
                                    <a href="/productos/mxbanorte" title="Ales">
                                        <img alt="Ales" border="0" src="{{ env('STORAGE') }}/shared/home_pictures/es/Mesa_de_trabajo_24-min.png"/>
                                    </a>
                                </div>
                                <div class="carousel-item">
                                    <a href="/productos/mxpemex" title="Alsuper">
                                        <img alt="alsuper" border="0" src="{{ env('STORAGE') }}/shared/home_pictures/es/Mesa_de_trabajo_25-min.png"/>
                                    </a>
                                </div>
                                <div class="carousel-item">
                                    <a href="/productos/mxkelloggs" title="Esteelauder">
                                        <img alt="Esteelauder" border="0" src="{{ env('STORAGE') }}/shared/home_pictures/es/Mesa_de_trabajo_27-min.png"/>
                                    </a>
                                </div>
                                <div class="carousel-item">
                                    <a href="/productos/mxsindicatobanamex" title="Famsa">
                                        <img alt="famsa" border="0" src="{{ env('STORAGE') }}/shared/home_pictures/es/Mesa_de_trabajo_28-min2.png"/>
                                    </a>
                                </div>
                                <div class="carousel-item">
                                    <a href="/productos/mxivoy" title="HM">
                                        <img alt="HM" border="0" src="{{ env('STORAGE') }}/shared/home_pictures/es/Mesa_de_trabajo_29-min.png"/>
                                    </a>
                                </div>
                                {{-- <div class="carousel-item">
                                    <a href="/productos/mxbancomer" title="Provident">
                                        <img alt="Provident" border="0" src="{{ env('STORAGE') }}/shared/home_pictures/es/Mesa_de_trabajo_30-min.png"/>
                                    </a>
                                </div> --}}
                                <div class="carousel-item">
                                    <a href="/productos/mxgrupohl" title="MDR">
                                        <img alt="MDR" border="0" src="{{ env('STORAGE') }}/shared/home_pictures/es/Mesa_de_trabajo_31-min.png"/>
                                    </a>
                                </div>
                                <div class="carousel-item">
                                    <a href="/productos/mxciosa" title="iVoy">
                                        <img alt="iVoy" border="0" src="{{ env('STORAGE') }}/shared/home_pictures/es/Mesa_de_trabajo_32-min.png"/>
                                    </a>
                                </div>
                                <div class="carousel-item">
                                    <a href="/productos/mxpepsico" title="frisa">
                                        <img alt="Grupo Frisa" border="0" src="{{ env('STORAGE') }}/shared/home_pictures/es/Mesa_de_trabajo_33-min.png"/>
                                    </a>
                                </div>
                                <div class="carousel-item">
                                    <a href="/productos/mxschnellecke" title="ECI">
                                        <img alt="ECI" border="0" src="{{ env('STORAGE') }}/shared/home_pictures/es/Mesa_de_trabajo_34-min.png"/>
                                    </a>
                                </div>
                                <div class="carousel-item">
                                    <a href="/productos/mxsegob" title="LMS">
                                        <img alt="LMS" border="0" src="{{ env('STORAGE') }}/shared/home_pictures/es/Mesa_de_trabajo_35-min.png"/>
                                    </a>
                                </div>
                                <div class="carousel-item">
                                    <a href="/productos/mxgayosso" title="Gayosso">
                                        <img alt="Gayosso" border="0" src="{{ env('STORAGE') }}/shared/home_pictures/es/bienvenidas/gayosso-min.jpg"/>
                                    </a>
                                </div>
                                <div class="carousel-item">
                                    <a href="/productos/mxtum" title="TUM">
                                        <img alt="TUM (Transportistas Unidos Mexicanos División Norte S. A. de C. V.)" border="0" src="{{ env('STORAGE') }}/shared/home_pictures/es/bienvenidas/tum-min.jpg"/>
                                    </a>
                                </div>
                                <div class="carousel-item">
                                    <a href="/productos/mxsykes" title="SYKES">
                                        <img alt="SYKES" border="0" src="{{ env('STORAGE') }}/shared/home_pictures/es/bienvenidas/sykes-min.jpg"/>
                                    </a>
                                </div>
                                <div class="carousel-item">
                                    <a href="/productos/mxliverpool" title="mxliverpool">
                                        <img alt="mxliverpool" border="0" src="{{ asset('images/bienvenidas/liverpool.jpg') }}"/>
                                    </a>
                                </div>
                                <div class="carousel-item">
                                    <a href="/productos/mxfamsa" title="Empleado Famsa">
                                        <img alt="Empleado Famsa" border="0" src="{{ env('STORAGE') }}/shared/home_pictures/es/bienvenidas/famsa-min.jpg"/>
                                    </a>
                                </div>
                            {{--     <div class="carousel-item">
                                    <a href="/productos/mxcomer" title="Comercial Mexicana">
                                        <img alt="Comercial Mexicana" border="0" src="{{ env('STORAGE') }}/shared/home_pictures/es/bienvenidas/lacomer-min.jpg"/>
                                    </a>
                                </div> --}}
                                <div class="carousel-item">
                                    <a href="/productos/mxoprimax" title="mxoprimax">
                                        <img alt="mxoprimax" border="0" src="{{ env('STORAGE') }}/shared/home_pictures/es/bienvenidas/grupo_primax-min.jpg"/>
                                    </a>
                                </div>
                             {{--    <div class="carousel-item">
                                    <a href="/productos/mxvcip" title="mxvcip">
                                        <img alt="mxvcip" border="0" src="{{ env('STORAGE') }}/shared/home_pictures/es/bienvenidas/vcip-min.jpg"/>
                                    </a>
                                </div> --}}
                            {{--     <div class="carousel-item">
                                    <a href="/productos/mxsanpablo" title="mxsanpablo">
                                        <img alt="mxsanpablo" border="0" src="{{ env('STORAGE') }}/shared/home_pictures/es/bienvenidas/san_pablo-min.jpg"/>
                                    </a>
                                </div> --}}
                                <div class="carousel-item">
                                    <a href="/productos/mxensamblehumano" title="mxensamblehumano">
                                        <img alt="mxensamblehumano" border="0" src="{{ env('STORAGE') }}/shared/home_pictures/es/bienvenidas/ensamble_humano-min.jpg"/>
                                    </a>
                                </div>
                                <div class="carousel-item">
                                    <a href="/productos/mxsears" title="mxsears">
                                        <img alt="mxsears" border="0" src="{{ env('STORAGE') }}/shared/home_pictures/es/bienvenidas/sears-min.jpg"/>
                                    </a>
                                </div>
                                <div class="carousel-item">
                                    <a href="/productos/mxtelmex" title="mxtelmex">
                                        <img alt="mxtelmex" border="0" src="{{ env('STORAGE') }}/shared/home_pictures/es/bienvenidas/telmex-min.jpg"/>
                                    </a>
                                </div>
                                <div class="carousel-item">
                                    <a href="/productos/mxgpojulio" title="mxgpojulio">
                                        <img alt="mxgpojulio" border="0" src="{{ env('STORAGE') }}/shared/home_pictures/es/bienvenidas/julio-min.jpg"/>
                                    </a>
                                </div>
                                <div class="carousel-item">
                                    <a href="/productos/mxtelcel" title="mxtelcel">
                                        <img alt="mxtelcel" border="0" src="{{ env('STORAGE') }}/shared/home_pictures/es/bienvenidas/telcel-min.jpg"/>
                                    </a>
                                </div>
                                <div class="carousel-item">
                                    <a href="/productos/mxnovamex" title="mxnovamex">
                                        <img alt="mxnovamex" border="0" src="{{ env('STORAGE') }}/shared/home_pictures/es/bienvenidas/novamex-min.jpg"/>
                                    </a>
                                </div>
                                <div class="carousel-item">
                                    <a href="/productos/mxhumanaccesssmb" title="mxhumanaccesssmb">
                                        <img alt="mxhumanaccesssmb" border="0" src="{{ env('STORAGE') }}/shared/home_pictures/es/bienvenidas/smb-min.jpg"/>
                                    </a>
                                </div>
                                <div class="carousel-item">
                                    <a href="/productos/mxheb" title="mxheb">
                                        <img alt="mxheb" border="0" src="{{ env('STORAGE') }}/shared/home_pictures/es/bienvenidas/heb-min.jpg"/>
                                    </a>
                                </div>
                                <div class="carousel-item">
                                    <a href="/productos/mxinbursa" title="mxinbursa">
                                        <img alt="mxinbursa" border="0" src="{{ env('STORAGE') }}/shared/home_pictures/es/bienvenidas/inbursa-min.jpg"/>
                                    </a>
                                </div>
                                <div class="carousel-item">
                                    <a href="/productos/mxgrupogigante" title="mxgrupogigante">
                                        <img alt="mxgrupogigante" border="0" src="{{ env('STORAGE') }}/shared/home_pictures/es/bienvenidas/dg-min.jpg"/>
                                    </a>
                                </div>
                                <div class="carousel-item">
                                    <a href="/productos/mxmikels" title="mxmikels">
                                        <img alt="mxmikels" border="0" src="{{ env('STORAGE') }}/shared/home_pictures/es/bienvenidas/mikels-min.jpg"/>
                                    </a>
                                </div>
                                <div class="carousel-item">
                                    <a href="/productos/mxteleton" title="mxteleton">
                                        <img alt="mxteleton" border="0" src="{{ env('STORAGE') }}/shared/home_pictures/es/bienvenidas/teleton-min.jpg"/>
                                    </a>
                                </div>
                                <div class="carousel-item">
                                    <a href="/productos/mxlatam" title="mxlatam">
                                        <img alt="mxlatam" border="0" src="{{ env('STORAGE') }}/shared/home_pictures/es/bienvenidas/latam.jpg"/>
                                    </a>
                                </div>
                                <div class="carousel-item">
                                    <a href="/productos/mxlactalis" title="mxlactalis">
                                        <img alt="mxlactalis" border="0" src="{{ env('STORAGE') }}/shared/home_pictures/es/bienvenidas/Lactalis-min.jpg"/>
                                    </a>
                                </div>
                                <div class="carousel-item">
                                    <a href="/productos/mxsct" title="mxsct">
                                        <img alt="mxsct" border="0" src="{{ env('STORAGE') }}/shared/home_pictures/es/bienvenidas/SCT-min.jpg"/>
                                    </a>
                                </div>
                                <div class="carousel-item">
                                    <a href="/productos/mxparisina" title="mxparisina">
                                        <img alt="mxlatam" border="0" src="{{ env('STORAGE') }}/shared/home_pictures/es/bienvenidas/parisina.png"/>
                                    </a>
                                </div>
                                <div class="carousel-item">
                                    <a href="/productos/mxeconomia" title="mxeconomia">
                                        <img alt="mxlatam" border="0" src="{{ env('STORAGE') }}/shared/home_pictures/es/bienvenidas/se.png"/>
                                    </a>
                                </div>
                                <div class="carousel-item">
                                    <a href="/productos/mxapymsa" title="mxapymsa">
                                        <img alt="mxapymsa" border="0" src="{{ env('STORAGE') }}/shared/home_pictures/es/bienvenidas/APYMSA.png"/>
                                    </a>
                                </div>
                                <div class="carousel-item">
                                    <a href="/productos/mxsemarnat" title="mxsemarnat">
                                        <img alt="mxsemarnat" border="0" src="{{ env('STORAGE') }}/shared/home_pictures/es/bienvenidas/SEMARNAT.png"/>
                                    </a>
                                </div>
                                <div class="carousel-item">
                                    <a href="/productos/mxampi" title="mxampi">
                                        <img alt="mxampi" border="0" src="{{ env('STORAGE') }}/shared/home_pictures/es/bienvenidas/AMPY.jpg"/>
                                    </a>
                                </div>
                            </div>
                            <a class="carousel-control-prev" data-slide="prev" href="#carouselExampleControls" role="button">
                                <span aria-hidden="true" class="carousel-control-prev-icon">
                                </span>
                                <span class="sr-only">
                                    Previous
                                </span>
                            </a>
                            <a class="carousel-control-next" data-slide="next" href="#carouselExampleControls" role="button">
                                <span aria-hidden="true" class="carousel-control-next-icon">
                                </span>
                                <span class="sr-only">
                                    Next
                                </span>
                            </a>
                        </div>
                    </div>
                    <div class="section_tittle text-center">
                        <h2 class="mt-5">
                            Ganadores del sorteo mensual
                        </h2>
                        <div class="">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="carousel slide" data-ride="carousel" id="carouselExampleIndicators">
                                        <ol class="carousel-indicators">
                                            <li class="active" data-slide-to="0" data-target="#carouselExampleIndicators">
                                            </li>
                                            <li data-slide-to="1" data-target="#carouselExampleIndicators">
                                            </li>
                                            <li data-slide-to="2" data-target="#carouselExampleIndicators">
                                            </li>
                                            <li data-slide-to="3" data-target="#carouselExampleIndicators">
                                            </li>
                                            <li data-slide-to="4" data-target="#carouselExampleIndicators">
                                            </li>
                                            <li data-slide-to="5" data-target="#carouselExampleIndicators">
                                            </li>
                                            <li data-slide-to="6" data-target="#carouselExampleIndicators">
                                            </li>
                                        </ol>
                                        <div class="carousel-inner">
                                            <div class="carousel-item active">
                                                <img alt="sorteo1" border="0" class="img-fluid" src="{{ asset('images/sorteos/apymsa.jpg') }}"/>
                                            </div>
                                            <div class="carousel-item">
                                                <img alt="sorteo1" border="0" class="img-fluid" src="{{ asset('images/sorteos/sorteo-gim.jpg') }}"/>
                                            </div>
                                            <div class="carousel-item">
                                                <img alt="sorteo1" border="0" class="img-fluid" src="{{ asset('images/sorteos/sorte_mvs.png') }}"/>
                                            </div>
                                            <div class="carousel-item ">
                                                <img alt="sorteo1" border="0" class="img-fluid" src="{{ env('STORAGE') }}shared/home_pictures/sorteo/GANADORA_TE_CREEMOS.jpg"/>
                                            </div>
                                            <div class="carousel-item">
                                                <img alt="sorteo1" border="0" class="img-fluid" src="{{ env('STORAGE') }}shared/home_pictures/sorteo/FAMSA_GANADORA.jpg"/>
                                            </div>
                                            <div class="carousel-item">
                                                <img alt="sorteo1" border="0" class="img-fluid" src="{{ env('STORAGE') }}shared/home_pictures/sorteo/ALES_GANADOR.jpg"/>
                                            </div>
                                            <div class="carousel-item">
                                                <img alt="sorteo2" border="0" class="img-fluid" src="{{ env('STORAGE') }}shared/home_pictures/sorteo/Ganadora-dalton.jpg"/>
                                            </div>
                                        </div>
                                        <a class="carousel-control-prev" data-slide="prev" href="#carouselExampleIndicators" role="button">
                                            <span aria-hidden="true" class="carousel-control-prev-icon">
                                            </span>
                                            <span class="sr-only">
                                                Previous
                                            </span>
                                        </a>
                                        <a class="carousel-control-next" data-slide="next" href="#carouselExampleIndicators" role="button">
                                            <span aria-hidden="true" class="carousel-control-next-icon">
                                            </span>
                                            <span class="sr-only">
                                                Next
                                            </span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="section_tittle text-center">
                        <h2 class="mt-5">
                            Testimonios de nuestros clientes
                        </h2>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="carousel slide" data-ride="carousel" id="carouselTestimonios">
                                    <ol class="carousel-indicators">
                                        <li class="active" data-slide-to="0" data-target="#carouselTestimonios">
                                        </li>
                                        @for ($i = 0; $i <= 10 ; $i++)
                                        <li data-slide-to="{{ $i }}" data-target="#carouselTestimonios">
                                        </li>
                                        @endfor
                                    </ol>
                                    <div class="carousel-inner">
                                        <div class="carousel-item active">
                                            <h3>
                                                Gilnardo Fernandez Rojas
                                            </h3>
                                            <p>
                                                Fue maravilloso, una experiencia que volveremos a repetir este año por que con {{ env('APP_NAME') }} si se puede
                                            </p>
                                        </div>
                                        <div class="carousel-item">
                                            <h3>
                                                Enrique Bautista
                                            </h3>
                                            <p>
                                                Todo salio a la perfección, el hotel muy como y todos muy atentos
                                            </p>
                                        </div>
                                        <div class="carousel-item">
                                            <h3>
                                                Arturo Ferrer Casas
                                            </h3>
                                            <p>
                                                Los paquetes están bien, pero me gustaría que hubiera paquetes solo para adultos, ya no tengo hijos pequeños... todo estuvo muy bien y comprare otro paquete, gracias!
                                            </p>
                                        </div>
                                        <div class="carousel-item">
                                            <h3>
                                                Luisa Nallely Sordo Lopez
                                            </h3>
                                            <p>
                                                Toda la familia se divirtió mucho, la atención del personal de {{ env('APP_NAME') }} muy buena, asi como la del personal del hotel al cual llegamos a vacacionar.
                                            </p>
                                        </div>
                                        <div class="carousel-item">
                                            <h3>
                                                Monica Elid Rojas Melgar
                                            </h3>
                                            <p>
                                                Una maravillosa experiencia y la atención por {{ env('APP_NAME') }} excelente en todo momento
                                            </p>
                                        </div>
                                        <div class="carousel-item">
                                            <h3>
                                                Mario Alberto Rayocely
                                            </h3>
                                            <p>
                                                Mis vacaciones gracias a su ayuda fue excelente, la estadía en el hotel
                                                <em>
                                                    Ramanda Cancun
                                                </em>
                                            </p>
                                        </div>
                                        <div class="carousel-item">
                                            <h3>
                                                Saul Acuña Hernández
                                            </h3>
                                            <p>
                                                Muy buena atención por parte de ustedes, como coordinadores de viajes el cual nos pudieron apoyar para vivir y disfrutas una de las mejores vacaciones que hemos tenido.
                                            </p>
                                        </div>
                                        <div class="carousel-item">
                                            <h3>
                                                Beatriz Quintanilla
                                            </h3>
                                            <p>
                                                Quedamos muy satisfechos con la atención por parte de  {{ env('APP_NAME') }} asi como la atención por parte del hotel Misión Grand Casa GTO.
                                            </p>
                                            <p>
                                                Definitivamente los recomendamos, desde la atención de Fernando para realizar la inscripción y adquirir un paquete hasta para concretar los pagos y la reservación con Luvy Reynaga
                                            </p>
                                        </div>
                                        <div class="carousel-item">
                                            <h3>
                                                Irving A.
                                            </h3>
                                            <p>
                                                Por el momento muy bien, muy atentos y muy buen servicio, estoy pagando mi tercer paquete.
                                            </p>
                                        </div>
                                    </div>
                                    <a class="carousel-control-prev" data-slide="prev" href="#carouselTestimonios" role="button">
                                        <span aria-hidden="true" class="carousel-control-prev-icon">
                                        </span>
                                        <span class="sr-only">
                                            Previous
                                        </span>
                                    </a>
                                    <a class="carousel-control-next" data-slide="next" href="#carouselTestimonios" role="button">
                                        <span aria-hidden="true" class="carousel-control-next-icon">
                                        </span>
                                        <span class="sr-only">
                                            Next
                                        </span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{--
                    <div class="section_tittle text-center">
                        <h2 class="mt-5">
                            Convenios de la semana
                        </h2>
                        <div class="row">
                            <div class="col-lg-12">
                                <img alt="" border="0" class="img-fluid" height="720" src="{{ env('STORAGE') }}shared/home_pictures/es/slide3col.jpg" usemap="#Map">
                                    <map id="Map" name="Map">
                                        <area coords="1,1,230,300" href="http://www.optucorp.com/NASA" shape="rect">
                                            <area coords="232,1,464,300" href="http://www.optucorp.com/military" shape="rect">
                                                <area coords="466,1,699,300" href="https://www.pacifictravels.mx/productos/mxpresidenciarep" shape="rect">
                                                </area>
                                            </area>
                                        </area>
                                    </map>
                                </img>
                            </div>
                        </div>
                    </div>
                    --}}
                    <div class="blog-details">
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                @include('pagina.mx.elementos.aside')
            </div>
        </div>
    </div>
</section>
{{--
<section class="best_services section_padding">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-6">
                <div class="section_tittle text-center">
                    <h2>
                        We offered best services
                    </h2>
                    <p>
                        Waters make fish every without firmament saw had. Morning air subdue. Our. Air very one. Whales grass is fish whales winged.
                    </p>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-3 col-sm-6">
                <div class="single_ihotel_list">
                    <img alt="" src="{{ asset('assets/img/services_1.png') }}">
                        <h3>
                            <a href="#">
                                Transportation
                            </a>
                        </h3>
                        <p>
                            All transportation cost we bear
                        </p>
                    </img>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6">
                <div class="single_ihotel_list">
                    <img alt="" src="{{ asset('assets/img/services_2.png') }}">
                        <h3>
                            <a href="#">
                                Guidence
                            </a>
                        </h3>
                        <p>
                            We offer the best guidence for you
                        </p>
                    </img>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6">
                <div class="single_ihotel_list">
                    <img alt="" src="{{ asset('assets/img/services_3.png') }}">
                        <h3>
                            <a href="#">
                                Accomodation
                            </a>
                        </h3>
                        <p>
                            Luxarious and comfortable
                        </p>
                    </img>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6">
                <div class="single_ihotel_list">
                    <img alt="" src="{{ asset('assets/img/services_4.png') }}">
                        <h3>
                            <a href="#">
                                Discover world
                            </a>
                        </h3>
                        <p>
                            Best tour plan for your next tour
                        </p>
                    </img>
                </div>
            </div>
        </div>
    </div>
</section>
--}}

@endsection
@section('script')
<script>
    $(document).ready(function() {
        $('#carouselExampleSlidesOnly').owlCarousel({
            loop:true,
            center: true,
            responsiveClass:true,
            touchDrag:true,
            mouseDrag:true,
            // nav:true,
            autoplay:true,
            smartSpeed:1000,
            autoplayTimeout:2000,
            responsive:{
                0:{
                    items:4
                },
                600:{
                    items:8
                },
                1000:{
                    items:12
                }
            }
        });   
    });
</script>
@endsection
