@extends('layouts.pagina.app')
@section('content')
<style>
    .owl-alto{
        height: 60px;
    }
    .carousel-inner  img{
        max-height: 60px;
        max-width: 70%;
        /*height: auto;*/
    }
</style>
<div class="container">
    <div class="section_tittle">
        <h2 class="text-center">
            Empresas Afiliadas
        </h2>
        <p class="text-justify">
            Nos enorgullece contar con más de 1,000 proyectos empresariales con las empresas más importantes y destacadas del país a nivel local, regional, nacional e internacional en el haber de nuestra empresa.
        </p>
        <div class="row">
            <div class="col-md-12">
                <p>
                    Estos antecedentes hablan de nuestro nivel de compromiso con la clase empresarial en beneficio de los trabajadores y de sus familias, nos motivan a seguir laborando a la par de nuestras empresas afiliadas para generar más empleo y riquezas para los mexicanos, contribuyendo a dinamizar nuestra economía y hacer de nuestro querido México un país más competitivo.
                </p>
                <p>
                    Día con día colaboramos junto con las mejores empresas y corporativos del país para llevar todos nuestros beneficios a su fuerza de trabajo.
                </p>
            </div>
            <div class="col-md-12">
                <p>
                    Si tu empresa todavía aún no cuenta con nuestros beneficios, envíanos un correo a
                    <a href="mailto:guadalupea@beneficiosvacacionales.mx">
                        Guadalupe Arevalo
                    </a>
                </p>
            </div>
            <div class="row mt-5">
                {{--
                <div class="col-lg-12">
                    <div class="carousel slide" data-ride="carousel" id="carousel-id">
                        <ol class="carousel-indicators">
                            <li class="active" data-slide-to="0" data-target="#carousel-id">
                            </li>
                            <li class="" data-slide-to="1" data-target="#carousel-id">
                            </li>
                            <li class="" data-slide-to="2" data-target="#carousel-id">
                            </li>
                        </ol>
                        <div class="carousel-inner">
                            <div class="item active">
                                <img alt="Algunas Empresas Afiliadas" src="{{ asset('images/empresas/ucad.png') }}"/>
                                <img alt="Algunas Empresas Afiliadas" src="{{ asset('images/empresas/e36.png') }}"/>
                                <img alt="Algunas Empresas Afiliadas" src="{{ asset('images/empresas/banxico.png') }}"/>
                                <img alt="Algunas Empresas Afiliadas" src="{{ asset('images/empresas/FAMSA.png') }}"/>
                                <img alt="Algunas Empresas Afiliadas" src="{{ asset('images/empresas/e0.png') }}"/>
                                <img alt="Algunas Empresas Afiliadas" src="{{ asset('images/empresas/e1.png') }}"/>
                                <img alt="Algunas Empresas Afiliadas" src="{{ asset('images/empresas/e2.png') }}"/>
                                <img alt="Algunas Empresas Afiliadas" src="{{ asset('images/empresas/e3.png') }}"/>
                                <img alt="Algunas Empresas Afiliadas" src="{{ asset('images/empresas/e4.png') }}"/>
                                <img alt="Algunas Empresas Afiliadas" src="{{ asset('images/empresas/e5.png') }}"/>
                                <img alt="Algunas Empresas Afiliadas" src="{{ asset('images/empresas/e6.png') }}"/>
                                <img alt="Algunas Empresas Afiliadas" src="{{ asset('images/empresas/e8.png') }}"/>
                            </div>
                            <div class="item">
                                <img alt="Algunas Empresas Afiliadas" src="{{ asset('images/empresas/e9.png') }}"/>
                                <img alt="Algunas Empresas Afiliadas" src="{{ asset('images/empresas/e11.png') }}"/>
                                <img alt="Algunas Empresas Afiliadas" src="{{ asset('images/empresas/e13.png') }}"/>
                                <img alt="Algunas Empresas Afiliadas" src="{{ asset('images/empresas/e15.png') }}"/>
                                <img alt="Algunas Empresas Afiliadas" src="{{ asset('images/empresas/e37.png') }}"/>
                                <img alt="Algunas Empresas Afiliadas" src="{{ asset('images/empresas/e16.png') }}"/>
                                <img alt="Algunas Empresas Afiliadas" src="{{ asset('images/empresas/e18.png') }}"/>
                                <img alt="Algunas Empresas Afiliadas" src="{{ asset('images/empresas/e19.png') }}"/>
                                <img alt="Algunas Empresas Afiliadas" src="{{ asset('images/empresas/e20.png') }}"/>
                                <img alt="Algunas Empresas Afiliadas" src="{{ asset('images/empresas/e21.png') }}"/>
                                <img alt="Algunas Empresas Afiliadas" src="{{ asset('images/empresas/e22.png') }}"/>
                            </div>
                            <div class="item ">
                                <img alt="Algunas Empresas Afiliadas" src="{{ asset('images/empresas/e23.png') }}"/>
                                <img alt="Algunas Empresas Afiliadas" src="{{ asset('images/empresas/e24.png') }}"/>
                                <img alt="Algunas Empresas Afiliadas" src="{{ asset('images/empresas/e25.png') }}"/>
                                <img alt="Algunas Empresas Afiliadas" src="{{ asset('images/empresas/e26.png') }}"/>
                                <img alt="Algunas Empresas Afiliadas" src="{{ asset('images/empresas/e27.png') }}"/>
                                <img alt="Algunas Empresas Afiliadas" src="{{ asset('images/empresas/e29.png') }}"/>
                                <img alt="Algunas Empresas Afiliadas" src="{{ asset('images/empresas/e30.png') }}"/>
                                <img alt="Algunas Empresas Afiliadas" src="{{ asset('images/empresas/e31.png') }}"/>
                                <img alt="Algunas Empresas Afiliadas" src="{{ asset('images/empresas/e32.png') }}"/>
                                <img alt="Algunas Empresas Afiliadas" src="{{ asset('images/empresas/e33.png') }}"/>
                            </div>
                        </div>
                        <a class="left carousel-control" data-slide="prev" href="#carousel-id">
                            <span class="glyphicon glyphicon-chevron-left" style="color: black;">
                            </span>
                        </a>
                        <a class="right carousel-control" data-slide="next" href="#carousel-id">
                            <span class="glyphicon glyphicon-chevron-right" style="color: black;">
                            </span>
                        </a>
                    </div>
                </div>
                --}}
                <div class="carousel slide" data-ride="carousel" id="carousel-example-generic">
                    <div class="carousel-inner text-center" role="listbox">
                        <div class="carousel-item active">
                            <div class="row">
                                @for ($i = 1; $i <=30 ; $i++)
                                <div class="col-md-3">
                                    <img alt="" class="img-fluid m-1" src="{{ asset('images/empresas/'. $i.'.png') }}">
                                    </img>
                                </div>
                                @endfor
                            </div>
                        </div>
                        <div class="carousel-item">
                            <div class="row">
                                @for ($i = 31; $i <=60 ; $i++)
                                <div class="col-md-3">
                                    <img alt="" class="img-fluid m-1" src="{{ asset('images/empresas/'. $i.'.png') }}">
                                    </img>
                                </div>
                                @endfor
                            </div>
                        </div>
                        <div class="carousel-item">
                            <div class="row">
                                @for ($i = 61; $i <=90 ; $i++)
                                <div class="col-md-3">
                                    <img alt="" class="img-fluid m-1" src="{{ asset('images/empresas/'. $i.'.png') }}">
                                    </img>
                                </div>
                                @endfor
                            </div>
                        </div>
                        <div class="carousel-item">
                            <div class="row">
                                @for ($i = 91; $i <=111 ; $i++)
                                <div class="col-md-3">
                                    <img alt="" class="img-fluid m-1" src="{{ asset('images/empresas/'. $i.'.png') }}">
                                    </img>
                                </div>
                                @endfor
                            </div>
                        </div>
                    </div>
                    <a class="left carousel-control" data-slide="prev" href="#carousel-example-generic" role="button">
                        <span aria-hidden="true" class="icon-prev">
                        </span>
                        <span class="sr-only">
                            Previous
                        </span>
                    </a>
                    <a class="right carousel-control" data-slide="next" href="#carousel-example-generic" role="button">
                        <span aria-hidden="true" class="icon-next">
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
@endsection
@section('script')
<script>
</script>
@endsection
