@extends('layouts.pagina.app')
@section('content')
<section class="top_place">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-12">
                <div class="section_tittle text-center">
                    <h2>
                        Alerta de prevención de fraude
                    </h2>
                    <p class="text-justify">
                        La marca
                        <b>
                            “Mis Beneficios Vacacionales”
                        </b>
                        es líder reconocida por su experiencia en comercialización de paquetes de viajes nacionales e internacionales. Mis Beneficios Vacacionales garantiza la protección de sus clientes y sus datos confidenciales. Coherentemente con esto, le invitamos a estar alerta ante el potencial comportamiento fraudulento de terceros que con mala intención utilizan la marca
                        <b>
                            “Mis Beneficios Vacacionales”
                        </b>
                        . Asi como sus imágenes, colores y productos a fin de realizar comercio por confusión, pretendiendo crear descontrol haciendo creer que son extensión, sucursal o división de Mis Beneficios Vacacionales, siendo esto inexistente.
                    </p>
                </div>
                <div class="mb-5" id="accordion">
                    <div class="card">
                        <div class="card-header" id="headingOne">
                            <h5 class="mb-0">
                                <button aria-controls="collapseOne" aria-expanded="true" class="btn btn-link" data-target="#collapseOne" data-toggle="collapse">
                                    Uso de la marca
                                </button>
                            </h5>
                        </div>
                        <div aria-labelledby="headingOne" class="collapse show" data-parent="#accordion" id="collapseOne">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-8">
                                        <p class="text-justify">
                                            Uso fraudulento de la marca Mis Beneficios Vacacionales Se han producido tentativas de fraude a varios compradores en Internet y de forma telefónica al hacer uso de gráficos y productos similares a los que usa Mis Beneficios Vacacionales para su difusión y promociones, sin autorización expresa de la marca Mis Beneficios Vacacionales, por medio de mensajes enviados por correo electrónico y otros medios que por su aspecto exterior parecen provenir de Mis Beneficios Vacacionales.
                                        </p>
                                    </div>
                                    <div class="col-md-4">
                                        <img alt="Logo pacifictravels" class="img-fluid" src="{{ asset('images/contrato.png') }}">
                                        </img>
                                    </div>
                                    <div class="col-md-12">
                                        <p class="text-justify">
                                            En la mayoría de los casos, los mensajes se refieren a la venta de productos similares a los que ofrece Mis Beneficios Vacacionales a través de Internet, donde se solicita el pago por transferencia de efectivo antes de efectuar la entrega de los productos, o con las modalidades de pago que usa Mis Beneficios Vacacionales. Por favor, recuerde que Mis Beneficios Vacacionales nunca solicita el pago de esta forma. Mis Beneficios Vacacionales solamente cobra el dinero relacionado a las compras relacionadas con los productos y servicios que maneja. Además de que cada compra deberá estar avalada por el contrato correspondiente, y las medidas de seguridad con las que cuentan los clientes de Mis Beneficios Vacacionales. Este aviso de seguridad no afecta la obligación del comprador a pagar las tarifas acordadas y respaldadas por el contrato entregado de forma física o electrónica, las tarifas extras en los casos que oportunamente son revisados con el comprador, el IVA o cargas similares, cuando corresponda que éstos se paguen en el momento de la reservación. Mis Beneficios Vacacionales no asume ninguna responsabilidad por costos, cargas o pagos indebidamente incurridos como resultado de actividades fraudulentas.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header" id="headingTwo">
                            <h5 class="mb-0">
                                <button aria-controls="collapseTwo" aria-expanded="false" class="btn btn-link collapsed" data-target="#collapseTwo" data-toggle="collapse">
                                    Alerta sobre SPAM
                                </button>
                            </h5>
                        </div>
                        <div aria-labelledby="headingTwo" class="collapse" data-parent="#accordion" id="collapseTwo">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-8">
                                        <p class="text-justify">
                                            Si usted recibe un correo electronico, de una empresa distinta de Mis Beneficios Vacacionales, que esta solicitando información de un paquete o requiriendo que descargue un archivo adjunto, es un correo fraudulento Mis Beneficios Vacacionales, solo envia correos que correspondan a nuestro dominio, ejemplo:
                                            <b>
                                                "asesor@pacifictravels.mx"
                                            </b>
                                            , de lo contrario podria ser victima de fraude o descargar un virus.
                                        </p>
                                        <p class="text-justify">
                                            <strong>
                                                No abra ni desacargue ningún archivo que no corresponda a lo anterior.
                                            </strong>
                                        </p>
                                    </div>
                                    <div class="col-md-3 offset-1">
                                        <img alt="" class="img-fluid" src="https://external-content.duckduckgo.com/iu/?u=http%3A%2F%2Fwww.email-support-desk.com%2Fblog%2Fwp-content%2Fuploads%2F2017%2F04%2Fspam-yahoo-mail.jpg&f=1&nofb=1">
                                        </img>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header" id="headingThree">
                            <h5 class="mb-0">
                                <button aria-controls="collapseThree" aria-expanded="false" class="btn btn-link collapsed" data-target="#collapseThree" data-toggle="collapse">
                                    Sitio Web
                                </button>
                            </h5>
                        </div>
                        <div aria-labelledby="headingThree" class="collapse" data-parent="#accordion" id="collapseThree">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-8">
                                        <p class="text-justify">
                                            Si tiene alguna duda con respecto a la autenticidad de un sitio web que utiliza la marca "Mis Beneficios Vacacionales", por favor, acceda siempre a los sitios web de
                                            <a href="https://pacifictravels.mx/" target="_blank">
                                                Mis Beneficios Vacacionales
                                            </a>
                                            por vía de nuestro sitio web internacional.
                                        </p>
                                        <p class="text-justify">
                                            Visita el sitio oficial de
                                            <a href="https://pacifictravels.mx/" target="_blank">
                                                Mis Beneficios Vacacionales
                                            </a>
                                        </p>
                                    </div>
                                    <div class="col-md-4">
                                        <img alt="" class="img-fluid" src="{{ asset('images/pagina.png') }}">
                                        </img>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header" id="headingFour">
                            <h5 class="mb-0">
                                <button aria-controls="collapseThree" aria-expanded="false" class="btn btn-link collapsed" data-target="#collapseFour" data-toggle="collapse">
                                    Denuncia de fraude
                                </button>
                            </h5>
                        </div>
                        <div aria-labelledby="headingThree" class="collapse" data-parent="#accordion" id="collapseFour">
                            <div class="card-body">
                                Favor de informar al servicio al cliente de Mis Beneficios Vacacionales, si recibe llamadas, correo electronicos o publicidad que pueda ser fraudulenta, al correo
                                <a href="mailto:servioalcliente@pacifictravels.mx">
                                    Servicio al cliente
                                </a>
                            </div>
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
