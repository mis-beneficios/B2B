<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
            <meta content="ie=edge" http-equiv="x-ua-compatible">
                <title>
                    Welcome to {{ env('APP_NAME_USA') }}
                </title>
                <meta content="width=device-width, initial-scale=1" name="viewport">
                    <style type="text/css">
                        /**
   * Google webfonts. Recommended to include the .woff version for cross-client compatibility.
   */
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

  /**
   * Avoid browser level font resizing.
   * 1. Windows Mobile
   * 2. iOS / OSX
   */
  body,
  table,
  td,
  a {
    -ms-text-size-adjust: 100%; /* 1 */
    -webkit-text-size-adjust: 100%; /* 2 */
  }

  /**
   * Remove extra space added to tables and cells in Outlook.
   */
  table,
  td {
    mso-table-rspace: 0pt;
    mso-table-lspace: 0pt;
  }

  /**
   * Better fluid images in Internet Explorer.
   */
  img {
    -ms-interpolation-mode: bicubic;
  }

  /**
   * Remove blue links for iOS devices.
   */
  a[x-apple-data-detectors] {
    font-family: inherit !important;
    font-size: inherit !important;
    font-weight: inherit !important;
    line-height: inherit !important;
    color: inherit !important;
    text-decoration: none !important;
  }

  /**
   * Fix centering issues in Android 4.4.
   */
  div[style*="margin: 16px 0;"] {
    margin: 0 !important;
  }

  body {
    width: 100% !important;
    height: 100% !important;
    padding: 0 !important;
    margin: 0 !important;
  }

  /**
   * Collapse table borders to avoid space between cells.
   */
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
                </meta>
            </meta>
        </meta>
    </head>
    <body style="background-color: #e9ecef;">
        <table border="0" cellpadding="0" cellspacing="0" width="100%">
            <tr>
                <td align="center" bgcolor="#e9ecef">
                    <table border="0" cellpadding="0" cellspacing="0" style="max-width: 600px;" width="100%">
                        <tr>
                            <td align="center" style="padding: 36px 24px;" valign="top">
                                <a href="https://sendgrid.com" rel="noopener noreferrer" style="display: inline-block;" target="_blank">
                                    <img alt="Logo" border="0" src="{{ asset('images/eu/op.png') }}" style="display: block; width: 78px; max-width: 78px; min-width: 78px;" width="78">
                                    </img>
                                </a>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td align="center" bgcolor="#e9ecef">
                    <table border="0" cellpadding="0" cellspacing="0" style="max-width: 600px;" width="100%">
                        <tr>
                            <td align="center" bgcolor="#ffffff">
                                <img alt="Welcome" src="{{ asset('images/eu/my_travel.png') }}" style="display: block; width: 100%; max-width: 50%;" width="600">
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
                                    Hi, {{ $cliente }}
                                </h1>
                                <p style="margin: 0;">
                                    Congratulation. New order is created for you. Below are the order details..
                                </p>
                                <br/>
                                <p>
                                    Package Name: {{ $paquete }}
                                </p>
                                <p>
                                    Package Cost: {{ $costo_paquete }}
                                </p>
                                <p>
                                    EMI Frequency: {{ $metodo_pago }}
                                </p>
                                <p>
                                    EMI Amount: {{ $pagos }}
                                </p>
                                <p>
                                    EMI Date: {{ $fecha_primer_cobro }}
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td align="left" bgcolor="#ffffff" style="padding: 24px; font-family: 'Source Sans Pro', Helvetica, Arial, sans-serif; font-size: 16px; line-height: 24px;">
                                <p>
                                    For any query you can contact on below contact details.
                                </p>
                                <p>
                                    Email:
                                    <a href="mailto:customerservice@optucorp.com">
                                        customerservice@optucorp.com
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
                                                        <a href="https://products.optucorp.com/login" rel="noopener noreferrer" style="display: inline-block; padding: 16px 36px; font-family: 'Source Sans Pro', Helvetica, Arial, sans-serif; font-size: 16px; color: #ffffff; text-decoration: none; border-radius: 6px;" target="_blank">
                                                            Go to panel
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
                                    Tanks
                                    <br>
                                        {{ env('APP_NAME_USA') }}
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
