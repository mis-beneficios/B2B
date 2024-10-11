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
                            Nueva reservación registrada por el cliente: {{ $reservacion->cliente->fullName }}
                        </h1>
                        <br/>
                        <p>
                            ID: {{ $reservacion->id }}
                        </p>
                        <p>
                            Nombre del paquete: {{ $reservacion->title }}
                        </p>
                        <p>
                            Cliente: {{ $reservacion->cliente->fullName }}
                        </p>
                        <p>
                            Estatus: {{ $reservacion->estatus }}
                        </p>
                        <p>
                            Destino: {{ $reservacion->destino }}
                        </p>
                        <p>
                            Fechas: {{ $reservacion->fecha_de_ingreso }} al {{ $reservacion->fecha_de_salida }}
                        </p>
                        <p>
                            Nombre a quien reserva: {{ $reservacion->nombre_de_quien_sera_la_reservacion }}
                        </p>
                        <p>
                            Destino: {{ $reservacion->destino }}
                        </p>
                        <p>
                            Teléfono: {{ $reservacion->telefono }}
                        </p>
                        <p>
                            Correo Electrónico: {{ $reservacion->email }}
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
                            <a href="https://beneficiosvacacionales.mx">
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
