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
                            Nuevo registro de compra {{ ($contrato->estancia->estancia_paise_id == 1) ? 'Mexico' : 'USA' }}
                        </h1>
                        <ul>
                            <li>
                                Nombre: {{ $contrato->cliente->nombre }}
                            </li>
                            <li>
                                Apellidos: {{ $contrato->cliente->apellidos }}
                            </li>
                            <li>
                                Correo: {{ $contrato->cliente->username }}
                            </li>
                            <li>
                                Teléfono: {{ $contrato->cliente->telefono }}
                            </li>
                            <li>
                                Empresa: {{ $contrato->cliente->convenio->empresa_nombre }}
                            </li>
                            <li>
                                Fecha de registro: {{ $contrato->created }}
                            </li>
                        </ul>
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
                                                <a href="{{ route('users.show', $contrato->cliente->id) }}" rel="noopener noreferrer" style="display: inline-block; padding: 16px 36px; font-family: 'Source Sans Pro', Helvetica, Arial, sans-serif; font-size: 16px; color: #ffffff; text-decoration: none; border-radius: 6px;" target="_blank">
                                                    Ver registro
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
                            Respuesta automatica por el equipo de
                            <br>
                                Equipo {{ env('APP_NAME') }}
                            </br>
                        </p>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
@endsection
