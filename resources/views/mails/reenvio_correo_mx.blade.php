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
                    <td align="left" bgcolor="#ffffff" style="padding: 24px; font-family: 'Source Sans Pro', Helvetica, Arial, sans-serif; font-size: 16px; line-height: 24px;">
                        <h1 style="margin: 0 0 12px; font-size: 32px; font-weight: 400; line-height: 48px;">
                            Hola, {{ $contrato->cliente->fullName }}
                        </h1>
                        <p style="margin: 0;">
                            Recibió este correo electrónico porque recibimos una solicitud para enviarle una copia de su contrato con folio: {{ $contrato->id }}.
                            <br/>
                            Le recordamos que esta y mas información referente a sus paquetes la puede visualizar directamente desde su
                            <a href="{{ env('FRONTEND_URL') }}login">
                                panel como cliente.
                            </a>
                        </p>
                    </td>
                </tr>
                <tr>
                    <td align="left" bgcolor="#ffffff">
                        <table border="0" cellpadding="0" cellspacing="0" width="100%">
                            <tr>
                                <td align="center" bgcolor="#ffffff" style="padding: 12px;">
                                    <table border="0" cellpadding="0" cellspacing="0">
                                        <tr>
                                            <td align="center" bgcolor="#1a82e2" style="border-radius: 6px;">
                                                <a href="{{ env('FRONTEND_URL') }}login" rel="noopener noreferrer" style="display: inline-block; padding: 16px 36px; font-family: 'Source Sans Pro', Helvetica, Arial, sans-serif; font-size: 16px; color: #ffffff; text-decoration: none; border-radius: 6px;" target="_blank">
                                                    Ir a panel
                                                </a>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
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
                        <small style="margin: 0;">
                            Hacer caso omiso si usted no solicito esta información.
                        </small>
                        <small>
                            Respuesta automática por el equipo de
                            <a href="{{ env('FRONTEND_URL') }}">
                                {{ env('APP_NAME') }}
                            </a>
                        </small>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
@endsection
