<!DOCTYPE html>
<html lang="en">
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
            <meta content="width=device-width, initial-scale=1, shrink-to-fit=no" name="viewport">
                <title>
                    Cupon de confirmación
                </title>
                <link crossorigin="anonymous" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" rel="stylesheet">
                </link>
            </meta>
        </meta>
    </head>
    <body style="background-image:url({{ asset('images/back.jpg') }});">
        <div class="">
            <table style="width:100%">
                <thead>
                    <tr>
                        <th>
                            <img align="left" alt="" src="{{ asset('images/logo_mb.jpg') }}" width="220px">
                            </img>
                        </th>
                        <th style="
    background-color: #0480be;
    margin-top: 85px;
    padding: 10px;
    border-radius: 30px;
    color: white;text-align: center; ">
                            Confirmación de reservación
                        </th>
                    </tr>
                </thead>
            </table>
            <br/>
            <br/>
            <table style="width: 100%">
                <tbody>
                    <tr>
                        <td style="width: 70%;">
                            <table style="width:100%">
                                <tr>
                                    <td style="font-size: 13px;
                                            color: #0480be;
                                            font-style: italic;">
                                        <strong>
                                            NOMBRE PAX:
                                        </strong>
                                    </td>
                                    <td>
                                        {{ $reservacion->nombre_de_quien_sera_la_reservacion }}
                                    </td>
                                </tr>
                                <tr>
                                    <td style="font-size: 13px;
                                            color: #0480be;
                                            font-style: italic;">
                                        <strong>
                                            DESTINO:
                                        </strong>
                                    </td>
                                    <td>
                                        {{ $reservacion->destino }}
                                    </td>
                                </tr>
                                <tr>
                                    <td style="font-size: 13px;
                                            color: #0480be;
                                            font-style: italic;">
                                        <strong>
                                            NÚMERO DE PAX:
                                        </strong>
                                    </td>
                                    <td>
                                        {{ $data['pax'] }}
                                    </td>
                                </tr>
                                <tr>
                                    <td style="font-size: 13px;
                                            color: #0480be;
                                            font-style: italic;">
                                        <strong>
                                            HABITACIONES:
                                        </strong>
                                    </td>
                                    <td>
                                        {{ count($reservacion->r_habitaciones) }}
                                    </td>
                                </tr>
                            </table>
                        </td>
                        <td style="background-color: #e95b35;
                                padding: 10px;
                                border-radius: 20px;
                                color: white; width: 30%;">
                            <table style="width:100%;">
                                <tr>
                                    <td>
                                        <table>
                                            <tr>
                                                <th style="float:left; text-align: left;">
                                                    Clave: {{ $reservacion->clave }}
                                                </th>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div>
                                            <table>
                                                <tr>
                                                    <td style="font-size: 13px;font-style: italic;">
                                                        AÑO: {{ $data['ano'] }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="font-size: 13px;font-style: italic;">
                                                        DEL: {{ $data['entrada'] . ' de '. $data['mes'] }}
                                                    </td>
                                                </tr>
                                                
                                                <tr>
                                                    <td style="font-size: 13px;font-style: italic;">
                                                        AL: {{ $data['salida'] .' de ' . $data['mes_salida'] }}
                                                    </td>
                                                </tr>   
                                               {{--  <tr>
                                                    <td style="font-size: 13px;font-style: italic;">
                                                        MES: {{ $data['mes'] }}
                                                    </td>
                                                </tr> --}}
                                            </table>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </tbody>
            </table>
            <br/>
            <table>
                <tr>
                    <table>
                        <tr>
                            <td>
                                <table style="width:100%">
                                    <tr>
                                        <td style="font-size: 13px;
                                            color: #0480be;
                                            font-style: italic;">
                                            <strong>
                                                PLAN:
                                            </strong>
                                        </td>
                                        <td>
                                            {{ $reservacion->title }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="font-size: 13px;
                                            color: #0480be;
                                            font-style: italic;">
                                            <strong>
                                                HOTEL:
                                            </strong>
                                        </td>
                                        <td>
                                            {{ $reservacion->hotel }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="font-size: 13px;
                                            color: #0480be;
                                            font-style: italic;">
                                            <strong>
                                                CHECK IN:
                                            </strong>
                                        </td>
                                        <td>
                                            {{ $reservacion->entrada }} Hrs
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="font-size: 13px;
                                            color: #0480be;
                                            font-style: italic;">
                                            <strong>
                                                CHECK OUT:
                                            </strong>
                                        </td>
                                        <td>
                                            {{ $reservacion->salida }} Hrs
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="font-size: 13px;
                                            color: #0480be;
                                            font-style: italic;">
                                            <strong>
                                                DIRECCION DEL HOTEL:
                                            </strong>
                                        </td>
                                        <td>
                                            {{ $reservacion->direccion }}
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                </tr>
            </table>
            <hr style="
    margin-top: 30px;
    margin-bottom: 30px;
    border: 1px solid #0480be;
    border-radius: 5px;">
            </hr>
            <h5 style="color: #e95b35;">
                {{-- PARA SU REGISTRO EN EL HOTEL, ES NECESARIO PRESENTAR ESTE CUPÓN Y UNA IDENTIFICACIÓN --}}
                Para su registro en el hotel, es necesario presentar este cupón y una identificación oficial
            </h5>
            <table>
       {{--          <tr>
                    <td>
                        <img alt="" src="{{ asset('images/checked.png') }}" style="width:25px; margin-right: 10px;">
                        </img>
                    </td>
                    <td>
                        <b style="color: #0480be;">
                            UNA VEZ QUE RECIBA ESTE CUPÓN, NO HABRÁ CANCELACIÓN.
                        </b>
                    </td>
                </tr> --}}
                <tr>
                    <td>
                        <img alt="" src="{{ asset('images/checked.png') }}" style="width:25px; margin-right: 10px;">
                        </img>
                    </td>
                    <td>
                        <b style="color: #0480be;">
                            {{-- UNA VEZ EMITIDO ESTE CUPÓN NO HAY CAMBIOS NI CANCELACIONES EN CASO DE SOLICITARLO QUEDARÁ SUJETO A POLÍTICAS DEL HOTEL. --}}
                            Una vez emitido este cupón no hay cambios ni cancelaciones, en caso de solicitarlo quedará sujeto a políticas del hotel.
                        </b>
                    </td>
                </tr>
                <tr>
                    <td>
                        <img alt="" src="{{ asset('images/checked.png') }}" style="width:25px; margin-right: 10px;">
                        </img>
                    </td>
                    <td>
                        <b style="color: #0480be;">
                            La asignación de la habitación dependerá directamente del hotel.
                            {{-- LA ASIGNACIÓN DE LA HABITACIÓN DEPENDERA DIRECTAMENTE DEL HOTEL. --}}
                        </b>
                    </td>
                </tr>
            </table>
            <br/>
            <p style="font-size: 11px;">
                CLASULA DE ACEPTACIÓN DE REVISION EN BURÓ DE CRÉDITO.
            </p>
            <p style="font-size: 10px; text-align: justify;">
                Por medio del presente autorizó a Optu Travel Benefits S.A de C.V., para que solicite información de mis operaciones de crédito y otras análogas que tengo celebradas con instituciones de crédito y empresas comerciales a las sociedades de información crediticia en el entendido de que declaró bajo protesta de decir verdad que tengo pleno conocimiento de: 1-la naturaleza y alcance de la información que será proporcionada por las sociedades de información crediticia; 2- del uso que Optu Travel Benefits S.A. de C.V., dará a tal información; 3- que Optu Travel Benefits S.A. de C.V. podrá realizar consultas periódicas de mi historial crediticio durante todo el tiempo que se mantenga vigente está autorización, esto es, durante la vigencia del contrato signado con Optu Travel Benefits S.A. de C.V.
            </p>
            <table style="float: center; margin-top: 50px;">
                <tr>
                    <td align="right" style="padding: 20px;">
                        <ul style="list-style: none; font-size: 14px; color: #0480be;">
                            <li>
                                <strong>
                                    Whatsapp 
                                    <a href="https://api.whatsapp.com/send?phone=3221115496&text=Hola,%20Cupon%20de%20confirmacion:%20{{ $reservacion->id }}">
                                        322 111 5496
                                    </a>     
                                </strong>
                            </li>
                            <li>
                                <strong>
                                    Tel. <a href="tel:5541698290">
                                        554 1698290
                                    </a>
                                </strong>
                            </li>
                            <li>
                                <strong>
                                    Atención de lunes a viernes de 9:00 a 18:00 hrs
                                </strong>
                            </li>
                            <li>
                                <strong>
                                    Sábado de 9:00 a 13:00 hrs
                                </strong>
                            </li>

                            <li>
                                <strong>
                                    <a href="www.beneficiosvacacionales.mx" target="_blank">
                                        www.beneficiosvacacionales.mx
                                    </a>
                                </strong>
                            </li>
                        </ul>
                    </td>
                    <td style="border-left: 5px solid #e95b35;">
                        <img alt="" src="{{ asset('images/icono02.png') }}" style="margin-left: 20px;" width="200px">
                        </img>
                    </td>
                </tr>
            </table>
        </div>
    </body>
</html>
<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script crossorigin="anonymous" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" src="https://code.jquery.com/jquery-3.5.1.slim.min.js">
</script>
<script crossorigin="anonymous" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js">
</script>
<script crossorigin="anonymous" integrity="sha384-+YQ4JLhjyBLPDQt//I+STsc9iw4uQqACwlvpslubQzn4u2UU2UFM80nGisd026JF" src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.min.js">
</script>
