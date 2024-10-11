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
                    <td align="left" bgcolor="#ffffff" style="padding: 25px; font-family: 'Source Sans Pro', Helvetica, Arial, sans-serif; font-size: 16px; line-height: 24px;">
                        <h1 style="margin: 0 0 5px; font-size: 32px; font-weight: 400; line-height: 48px;">
                            ¡Hola {{ $sorteo->nombre_completo .' '. $sorteo->apellidos }}!
                        </h1>
                        <p>
                            Beneficios Vacacionales te agradece haber participado en nuestro sorteo, te enviamos el folio de registro para tenerlo a la mano al momento de realizar la selección del ganador.
                        </p>
                        <p>
                            Te deseamos toda la suerte.
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
                                                {{--
                                                <a href="#" rel="noopener noreferrer" style="display: inline-block; padding: 16px 36px; font-family: 'Source Sans Pro', Helvetica, Arial, sans-serif; font-size: 16px; color: #ffffff; text-decoration: none; border-radius: 6px;">
                                                    {{ $sorteo->id }}
                                                </a>
                                                --}}
                                                <p class="text-center" style="margin-top: 50px; font-size: 65px; color: #fff; font-family: Righteous; padding: 6px 36px;">
                                                    N°
                                                    <strong id="num_folio">
                                                        {{ $sorteo->id }}
                                                    </strong>
                                                </p>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                {{--
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
                --}}
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
                            <a href="{{ url('/') }}">
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
