@extends('layouts.pagina.app')
@section('content')
<style>
    .img_back{
        background-image: url("https://familyvacationist.com/wp-content/uploads/2021/02/Father-and-daughter-at-the-beach-Photo-Shutterstock.jpg");
        height: 574px;
        width: 100%;
        background-repeat: no-repeat;
        background-position-y: -120px;
    }
     .breadcrumb .overlay_h {
        opacity: .01; 
    }
    .breadcrumb_bg {
         background-image: url("https://www.garzablancaresort.com/blog/wp-content/uploads/2021/03/Portada-Family-Vacations-in-Mexico-the-Top-5-Destinations.jpg");
        background-position: center;
        background-repeat: no-repeat;
        background-size: cover;
        background-position-y: -220px;
    }
    .text_info{
        font-size: 40px;
    }

    @media only screen and (max-width: 600px) {
        .breadcrumb_iner_item .text_info{
            font-size: 19px;
        }
        .breadcrumb_bg {
            background-position-y: 0px;
        }
    }
</style>
<section class="breadcrumb breadcrumb_bg">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="breadcrumb_iner">
                    <div class="breadcrumb_iner_item text-center">
                        <h3 class="text-white text_info">
                            ¡UN INIGUALABLE   BENEFICIO DE VIAJES EN PAGOS QUINCENALES  CON ESTE PROGRAMA SU PERSONAL PODRA CUMPLIR EL VIAJE  DE SUS SUEÑOS!
                        </h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="about_us mt-3 mb-5">
    <div class="container">
        <div class="row align-items-center">
            <h2 class="m-2 text-center mt-1 mb-5">
                LA MEJOR OPCIÓN EN VIAJES CON PAGOS QUINCENALES A LOS  DESTINOS TOPS DE MEXICO  Y EN HOTELES  DE ENSUEÑO SIN COSTO PARA SU EMPRESA.
            </h2>
            <div class="col-lg-6">
                <div class="about_img">
                    <img alt="#" src="https://www.parents.com/thmb/DpwHutiX0NME_1IeXGuUnwASBzk=/1000x667/filters:fill(auto,1)/shutterstock_159281780-cec36518d8b64167b5da056c0af4f023.jpg">
                    </img>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="about_text text-justify">
                    <h3>
                        REQUISITOS PARA OBTENER ESTE AL PROGRAMA PARA SUS PERSONAL
                    </h3>
                    <p class="lead">
                        <i class="fas fa-check">
                        </i>
                        Contar con una plantilla mínimo de 100 colaboradores.
                    </p>
                    <p class="lead">
                        <i class="fas fa-check">
                        </i>
                        Tener mínimo 6 meses de operación en México.
                    </p>
                    <p class="lead">
                        <i class="fas fa-check">
                        </i>
                        Contar con plataforma  o estructura interna de beneficios que permita  ofrecer una excelente difusión del beneficio entre sus colaboradores
                    </p>
                    <p>
                        <b>
                            No es obligatorio firmar convenio.
                        </b>
                    </p>
                </div>
            </div>
        </div>
        <div class="row align-items-center mt-3">
            <div class="col-lg-6">
                <div class="about_text text-justify">
                    <h3>
                        ¿PORQUE OFRECER ESTE GRAN BENEFICIO A SU PERSONAL?:
                    </h3>
                    <p class="lead">
                        <i class="fas fa-check">
                        </i>
                        Cuando la empresa otorga beneficios reales al colaborador está comprobado que el rendimiento laboral aumenta.
                    </p>
                    <p class="lead">
                        <i class="fas fa-check">
                        </i>
                        Porque con este  beneficio  cumplimos el sueño de muchos mexicanos al poner a su alcance los destinos y hoteles de sus sueños.
                    </p>
                    <p class="lead">
                        <i class="fas fa-check">
                        </i>
                        Ayudamos  al ahorro de sus colaboradores con precios muy por debajo del mercado actual  y en  36 pagos quincenales.
                    </p>
                    <p class="lead">
                        <i class="fas fa-check">
                        </i>
                        Generamos cultura, educación, integración familiar cuando las personas  viven la gran experiencia de viajar.
                    </p>
                    <p class="lead">
                        <i class="fas fa-check">
                        </i>
                        Su empresa promoverá un programa nacionalista patriótico que reforzará nuestras raíces, cultura y tradiciones que hacen falta.
                    </p>
                    <p class="lead">
                        <i class="fas fa-check">
                        </i>
                        Ayudemos a nuestra gran nación, promoviendo sólo turismo  nacional.
                    </p>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="about_img">
                    <img alt="#" src="{{ asset('images/como-motivar-a-los-empleados.jpg') }}">
                    </img>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
@section('script')
@endsection
