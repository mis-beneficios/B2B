@extends('layouts.pagina.app')
<style>
    .breadcrumb_faq {
        background-image: url("{{ asset('images/eu/faq.jpg') }}");
        background-position: center;
        background-repeat: no-repeat;
        background-size: cover;
    }
</style>
@section('content')
<section class="breadcrumb breadcrumb_bg" style="background-image: url(https://external-content.duckduckgo.com/iu/?u=https%3A%2F%2Fwww.outletdeviajes.mx%2Fwp-content%2Fuploads%2F2019%2F10%2FLOS-CABOS-1.jpg&f=1&nofb=1);">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="breadcrumb_iner">
                    <div class="breadcrumb_iner_item text-center">
                        <h2>
                            Preguntas Frecuentes
                        </h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<div class="container">
    <div class="row mt-5">
        <div class="col-md-12 mt-1 mb-3 btn-block wow bounceInRight text-justify" style="visibility: visible; animation-name: bounceInRight;">
            <p class="alert alert-primary" style="background-color:#008dc7;">
                <a aria-controls="collapseExample1" aria-expanded="true" c="" data-toggle="collapse" href="#collapseExample1" lass="" role="button" style="color:white">
                    1.- ¿Cómo se generan mis descuentos?
                </a>
            </p>
            <div class="collapse show" id="collapseExample1" style="">
                <div class="card card-body">
                    <p class="text-justify">
                        Según el contrato firmado, banca electrónica o nómina de la siguiente manera: Banca electrónica, por medio de su tarjeta de débito o crédito, el descuento es semanal, quincenal o mensual, convenio con su banco preferido (aceptamos todas las tarjetas excepto american express).
                        <br/>
                        O bien, a través de su pago de nómina, descuento automático según el acuerdo con su empresa, comúnmente es quincenal.
                    </p>
                </div>
            </div>
        </div>
        <div class="col-md-12 mt-1 mb-3 btn-block wow bounceInRight text-justify" style="visibility: visible; animation-name: bounceInRight;">
            <p class="alert alert-primary" style="background-color:#008dc7;">
                <a aria-controls="collapseExample2" aria-expanded="false" class="" data-toggle="collapse" href="#collapseExample2" role="button" style="color:white">
                    2.- ¿Puedo viajar de inmediato?
                </a>
            </p>
            <div class="collapse show" id="collapseExample2">
                <div class="card card-body">
                    <p class="text-justify">
                        Si su contrato fue a través de banca electrónica, puede viajar al momento de haber cubierto el 100% del costo de su paquete y si es por vía nomina, puede programar sus vacaciones a partir del primer descuento.
                    </p>
                </div>
            </div>
        </div>
        <div class="col-md-12 mt-1 mb-3 btn-block wow bounceInRight text-justify" style="visibility: visible; animation-name: bounceInRight;">
            <p class="alert alert-primary" style="background-color:#008dc7;">
                <a aria-controls="collapseExample3" aria-expanded="false" class="" data-toggle="collapse" href="#collapseExample3" role="button" style="color:white">
                    3.- ¿Cómo puedo obtener el beneficio de los planes vacaciones?
                </a>
            </p>
            <div class="collapse show" id="collapseExample3">
                <div class="card card-body">
                    <p class="text-justify">
                        Es a través de una inscripción, se toman sus datos y un correo electrónico para enviarle el contrato, la inscripción no tiene costo ¡es totalmente gratis!
                    </p>
                </div>
            </div>
        </div>
        <div class="col-md-12 mt-1 mb-3 btn-block wow bounceInRight text-justify" style="visibility: visible; animation-name: bounceInRight;">
            <p class="alert alert-primary" style="background-color:#008dc7;">
                <a aria-controls="collapseExample4" aria-expanded="false" class="" data-toggle="collapse" href="#collapseExample4" role="button" style="color:white">
                    4.- ¿Por qué no incluye transporte?
                </a>
            </p>
            <div class="collapse show" id="collapseExample4">
                <div class="card card-body">
                    <p class="text-justify">
                        Porque tendría que definir fecha y destino al momento de inscribirse a alguno de nuestros paquetes, y la finalidad de nuestro servicio es que tengan ustedes como clientes, esa tranquilidad de planear sus vacaciones con toda libertad durante un año.
                    </p>
                </div>
            </div>
        </div>
        <div class="col-md-12 mt-1 mb-3 btn-block wow bounceInRight text-justify" style="visibility: visible; animation-name: bounceInRight;">
            <p class="alert alert-primary" style="background-color:#008dc7;">
                <a aria-controls="collapseExample5" aria-expanded="false" class="" data-toggle="collapse" href="#collapseExample5" role="button" style="color:white">
                    5.- ¿Cuál es la vigencia de mi contrato?
                </a>
            </p>
            <div class="collapse show" id="collapseExample5">
                <div class="card card-body">
                    <p class="text-justify">
                        La vigencia de su contrato es de un año e inicia a partir de su primer descuento.
                    </p>
                </div>
            </div>
        </div>
        <div class="col-md-12 mt-1 mb-3 btn-block wow bounceInRight text-justify" style="visibility: visible; animation-name: bounceInRight;">
            <p class="mb-2 alert alert-primary" style="background-color:#008dc7;">
                <a aria-controls="collapseExample6" aria-expanded="false" class="" data-toggle="collapse" href="#collapseExample6" role="button" style="color:white">
                    6.- ¿Qué pasa si se caduca mi paquete?
                </a>
            </p>
            <div class="collapse show" id="collapseExample6">
                <div class="card card-body text-justify">
                    <p class="text-justify">
                        Una vez que caduca un paquete no lo pierde pero solo podrá viajar en temporada baja y pagando un reajuste de tarifa.
                    </p>
                </div>
            </div>
        </div>
        <div class="col-md-12 mt-1 mb-3 btn-block wow bounceInRight text-justify" style="visibility: visible; animation-name: bounceInRight;">
            <p class="mb-2 alert alert-primary" style="background-color:#008dc7;">
                <a aria-controls="collapseExample7" aria-expanded="false" class=" " data-toggle="collapse" href="#collapseExample7" role="button" style="color:white">
                    7.-¿Cómo se calcula el reajuste de tarifa?
                </a>
            </p>
            <div class="collapse show " id="collapseExample7">
                <div class="card card-body">
                    <p class="text-justify">
                        El reajuste de tarifa es muy variable y se calcula hasta tener su reservación registrada en sistema, los factores a considerar son: tiempo del vencimiento del contrato, destino a viajar, hotel asignado así como tipo y costo del paquete.
                    </p>
                </div>
            </div>
        </div>
        <div class="col-md-12 mt-1 mb-3 btn-block wow bounceInRight text-justify" style="visibility: visible; animation-name: bounceInRight;">
            <p class="mb-2 alert alert-primary" style="background-color:#008dc7;">
                <a aria-controls="collapseExample8" aria-expanded="false" class=" " data-toggle="collapse" href="#collapseExample8" role="button" style="color:white">
                    8.- ¿Cuál es el proceso para reservar?
                </a>
            </p>
            <div class="collapse show " id="collapseExample8">
                <div class="card card-body">
                    <p class="text-justify">
                        <ul>
                            <li>
                                Llenar la papeleta de reservación, enviar al correo:
                                <a href="mailto:reservacionescorporativo@beneficiosvacacionales.mx">
                                    reservacionescorporativo@beneficiosvacacionales.mx
                                </a>
                                30 días como mínimo en temporada baja 60 en temporada media y alta.
                            </li>
                            <li>
                                Llama para confirmar la recepción al:
                                <a href="tel:5541698290">
                                    (55) 4169 8290
                                </a>
                                para asignarte al ejecutivo que se encargara del trámite.
                            </li>
                            <li>
                                Toda la información del proceso de tu reservación se te enviara por correo electrónico.
                            </li>
                        </ul>
                    </p>
                </div>
            </div>
        </div>
        <div class="col-md-12 mt-1 mb-3 btn-block wow bounceInRight text-justify" style="visibility: visible; animation-name: bounceInRight;">
            <p class="mb-2 alert alert-primary" style="background-color:#008dc7;">
                <a aria-controls="collapseExample9" aria-expanded="false" class=" " data-toggle="collapse" href="#collapseExample9" role="button" style="color:white">
                    9.- ¿A partir de qué edad se considera un adulto en el hotel?
                </a>
            </p>
            <div class="collapse show " id="collapseExample9">
                <div class="card card-body">
                    <p class="text-justify">
                        Depende de cada cadena hotelera, regularmente a partir de los 13 años
                    </p>
                </div>
            </div>
        </div>
        <div class="col-md-12 mt-1 mb-3 btn-block wow bounceInRight text-justify" style="visibility: visible; animation-name: bounceInRight;">
            <p class="mb-2 alert alert-primary" style="background-color:#008dc7;">
                <a aria-controls="collapseExample10" aria-expanded="false" clas="" data-toggle="collapse" href="#collapseExample10" role="button" s=" " style="color:white">
                    10.-                    ¿Puedo cambiar a los menores por un adulto extra?
                </a>
            </p>
            <div class="collapse show " id="collapseExample10">
                <div class="card card-body">
                    <p class="text-justify">
                        No, los menores son gratis y no es posible cambiarlos por alguno beneficio adicional hasta los 11 años en el plan europeo y en todo incluido hasta los 4 años.
                    </p>
                </div>
            </div>
        </div>
        <div class="col-md-12 mt-1 mb-3 btn-block wow bounceInRight text-justify" style="visibility: visible; animation-name: bounceInRight;">
            <p class="mb-2 alert alert-primary" style="background-color:#008dc7;">
                <a aria-controls="collapseExample11" aria-expanded="false" clas="" data-toggle="collapse" href="#collapseExample11" role="button" s=" " style="color:white">
                    11.- ¿Cuáles son los horarios de entrada y salida de los hoteles?
                </a>
            </p>
            <div class="collapse show " id="collapseExample11">
                <div class="card card-body">
                    <p class="text-justify">
                        Los horarios son muy variables y dependen de las características en servicio de cada hotel, sin embargo manejan un horario estandarizado de entrada y salida.
                        <br/>
                        Entrada: 3.00 p.m.
                        <br/>
                        Salida: 12:00 p.m.
                    </p>
                </div>
            </div>
        </div>
        <div class="col-md-12 mt-1 mb-3 btn-block wow bounceInRight text-justify" style="visibility: visible; animation-name: bounceInRight;">
            <p class="mb-2 alert alert-primary" style="background-color:#008dc7;">
                <a aria-controls="collapseExample12" aria-expanded="false" clas="" data-toggle="collapse" href="#collapseExample12" role="button" s=" " style="color:white">
                    12.- ¿Qué pasa si llego más temprano al hotel?
                </a>
            </p>
            <div class="collapse show " id="collapseExample12">
                <div class="card card-body">
                    <p class="text-justify">
                        La asignación de la habitación depende de la disponibilidad del hotel, le pueden guardar su equipaje mientras llega su horario de entrada.
                    </p>
                </div>
            </div>
        </div>
        <div class="col-md-12 mt-1 mb-3 btn-block wow bounceInRight text-justify" style="visibility: visible; animation-name: bounceInRight;">
            <p class="mb-2 alert alert-primary" style="background-color:#008dc7;">
                <a aria-controls="collapseExample13" aria-expanded="false" clas="" data-toggle="collapse" href="#collapseExample13" role="button" s=" " style="color:white">
                    13.- ¿Cómo me confirman que mi reservación esta lista?
                </a>
            </p>
            <div class="collapse show " id="collapseExample13">
                <div class="card card-body">
                    <p class="text-justify">
                        La reservación se confirma con el envió de un cupón por correo electrónico. Es necesario imprimirlo para presentarlo en el hotel con una identificación. En el cupón de confirmación vienen sus datos así como tipo de paquete, nombre del hotel , dirección y una clave de reservación que puede ser un nombre o número.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
@endsection
