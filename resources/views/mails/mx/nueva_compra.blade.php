@extends('mails.layout')
@section('content')
<table border="0" cellpadding="0" cellspacing="0" width="100%">
    <tr>
        <td align="center" bgcolor="#e9ecef">
            <table border="0" cellpadding="0" cellspacing="0" style="max-width: 600px; padding-top: 150px;" width="100%">
                <tr>
                    <td align="center" bgcolor="#ffffff">
                        <img alt="Beneficios Vacacionales" src="{{ asset('images/mis_beneficios.png') }}" style="display: block; width: 100%; max-width: 50%;" width="600">
                        </img>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td align="center" bgcolor="#e9ecef">
            <table border="0" cellpadding="0" cellspacing="0" style="max-width: 600px;" width="100%">
                <tr>
                    <td align="left" bgcolor="#ffffff" style="padding: 5px; font-family: 'Source Sans Pro', Helvetica, Arial, sans-serif; font-size: 16px; line-height: 24px;">
                        <h1 style="margin: 0 0 5px; font-size: 32px; font-weight: 400; line-height: 48px;">
                            Hola, {{ $contrato->cliente->fullName }}
                        </h1>
                        <p style="margin: 0;">
                            Enhorabuena.
                        </p>
                        <p>
                            Se crea un nuevo contrato para ti. A continuación se muestran los detalles del contrato...
                        </p>
                        <br/>
                        <p>
                            Nombre del paquete: {{ $contrato->paquete }}
                        </p>
                        <p>
                            Precio: ${{ number_format($contrato->precio_de_compra,2) }} {{ $contrato->divisa }}
                        </p>
                        @php
                          switch ($contrato->num_segmentos()) {
                            case 48:
                            case 72:
                                $cuotas_title = 'SEMANALES';
                                break;
                            case 24:
                            case 36:
                                $cuotas_title = 'QUINCENALES';
                                break;
                            case 12:
                                $cuotas_title = 'MENSUALES';
                                break;
                            default:
                            $cuotas_title = 'QUINCENALES';
                                break;
                        }
                        @endphp
                        <p>
                            Frecuencia de pagos:  {{  $cuotas_title }}
                        </p>
                        <p>
                            {{-- Monto: ${{ number_format($contrato->precio_de_compra / $contrato->estancia->cuotas,2) }} {{ $contrato->divisa }} --}}
                            Monto: ${{ number_format($contrato->precio_de_compra / $contrato->num_segmentos(),2) }} {{ $contrato->divisa }}
                        </p>
                        <p>
                            Fecha del primer descuento: {{ (count($contrato->pagos_contrato) > 0 ) ? $contrato->fecha_primer_descuento() : 'No especificado'}}
                            {{-- Fecha del primer descuento: {{ (count($contrato->pagos_contrato) > 0 ) ? $contrato->pagos_contrato[0]->fecha_de_cobro : 'No especificado'}} --}}
                        </p>
                    </td>
                </tr>
                <tr>
                    <td align="left" bgcolor="#ffffff" style="padding: 24px; font-family: 'Source Sans Pro', Helvetica, Arial, sans-serif; font-size: 16px; line-height: 24px;">
                        <p>
                            Para cualquier duda, puede ponerse en contacto con los datos de contacto a continuación.
                        </p>
                        <p>
                            Correo electrónico:
                            <a href="mailto:atencionalcliente@beneficiosvacacionales.mx">
                                atencionalcliente@beneficiosvacacionales.mx
                            </a>
                        </p>
                    </td>
                </tr>
                <tr>
                    <td align="left" bgcolor="#ffffff" style="padding: 24px; font-family: 'Source Sans Pro', Helvetica, Arial, sans-serif; font-size: 16px; line-height: 24px; border-bottom: 3px solid #d4dadf">
                        <p style="margin: 0;">
                            Gracias
                            <br>
                                Equipo {{ env('APP_NAME') }}
                            </br>
                        </p>
                    </td>
                </tr>
                <tr>
                    <td align="left" bgcolor="#ffffff" style="padding: 24px; font-family: 'Source Sans Pro', Helvetica, Arial, sans-serif; font-size: 16px; line-height: 24px; border-bottom: 3px solid #d4dadf">
                        <small>
                            Respuesta automática por el equipo de
                            <a href="https://beneficiosvacacionales.mx/">
                                {{ env('APP_NAME') }}
                            </a>
                            , no responder a este correo electrónico.
                        </small>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
@endsection
