<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8"/>
        <meta content="ie=edge" http-equiv="x-ua-compatible"/>
        <title>
            Welcome to {{ env('APP_NAME_USA') }}
        </title>
        <meta content="width=device-width, initial-scale=1" name="viewport"/>
        <style type="text/css">
            @media screen {
            @font-face {
              font-family: 'Source Sans Pro';
              font-style: normal;
              font-weight: 400;
              src: local('Source Sans Pro Regular'), local('SourceSansPro-Regular'), url(https://fonts.gstatic.com/s/sourcesanspro/v10/ODelI1aHBYDBqgeIAH2zlBM0YzuT7MdOe03otPbuUS0.woff) format('woff');
            }

            @font-face {
              font-family: 'Source Sans Pro';
              font-style: normal;
              font-weight: 700;
              src: local('Source Sans Pro Bold'), local('SourceSansPro-Bold'), url(https://fonts.gstatic.com/s/sourcesanspro/v10/toadOcfmlt9b38dHJxOBGFkQc6VGVFSmCnC_l7QZG60.woff) format('woff');
            }
          }
          body,
          table,
          td,
          a {
            -ms-text-size-adjust: 100%; /* 1 */
            -webkit-text-size-adjust: 100%; /* 2 */
          }

          table,
          td {
            mso-table-rspace: 0pt;
            mso-table-lspace: 0pt;
          }
          img {
            -ms-interpolation-mode: bicubic;
          }
          a[x-apple-data-detectors] {
            font-family: inherit !important;
            font-size: inherit !important;
            font-weight: inherit !important;
            line-height: inherit !important;
            color: inherit !important;
            text-decoration: none !important;
          }
          div[style*="margin: 16px 0;"] {
            margin: 0 !important;
          }

          body {
            width: 100% !important;
            height: 100% !important;
            padding: 0 !important;
            margin: 0 !important;
          }
          table {
            border-collapse: collapse !important;
          }

          a {
            color: black;
          }

          img {
            height: auto;
            line-height: 100%;
            text-decoration: none;
            border: 0;
            outline: none;
          }
        </style>
    </head>
    <body style="background-color: #e9ecef; ">
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
                                    Bienvenido, {{ $user->fullName }}
                                </h1>
                                <p style="margin: 0;">
                                    Recibió este correo electrónico porque recibimos una solicitud para cambiar su contraseña para su
                                    <a href="https://beneficiosvacacionales.mx/login">
                                        panel como cliente.
                                    </a>
                                </p>
                                <br/>
                                <p>
                                    Nuevos accesos:
                                </p>
                                <p>
                                    Usuario: {{ $user->username }}
                                </p>
                                <p>
                                    Contraseña: {{ base64_decode($user->clave) }}
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
                    </table>
                </td>
            </tr>
        </table>
    </body>
</html>