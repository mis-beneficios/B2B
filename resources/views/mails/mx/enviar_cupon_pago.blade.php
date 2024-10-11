@extends('mails.layout')
@section('content')
<table border="0" cellpadding="0" cellspacing="0" width="100%">
    <tr>
        <td align="center" bgcolor="#e9ecef">
            <table border="0" cellpadding="0" cellspacing="0" style="max-width: 600px; padding-top: 150px;" width="100%">
                <tr>
                    <td align="center" bgcolor="#ffffff">
                        <img alt="Mis Beneficios Vacacionales" src="{{ asset('images/mis_beneficios.png') }}" style="display: block; width: 100%; max-width: 50%;" width="600">
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
                    <td align="left" bgcolor="#ffffff" style="padding: 25px; font-family: 'Source Sans Pro', Helvetica, Arial, sans-serif; font-size: 16px; line-height: 24px;">
                       {!! $data['cuerpo'] !!} 
                       
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
