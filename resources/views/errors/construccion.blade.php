<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8"/>
        <meta content="IE=edge" http-equiv="X-UA-Compatible"/>
        <!-- Tell the browser to be responsive to screen width -->
        <meta content="width=device-width, initial-scale=1" name="viewport"/>
        <meta content="" name="description"/>
        <meta content="" name="author"/>
        <!-- Favicon icon -->
        <link href="{{ asset('images/icono01.png') }} " rel="icon"/>
        <title>
            Mis Beneficios Vacacionales
        </title>
        <!-- Bootstrap Core CSS -->
        <link href="{{ asset('back/assets/plugins/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet"/>
        <!-- Custom CSS -->
        <link href="{{ asset('back/css/style.css') }}" rel="stylesheet"/>
        <!-- You can change the theme colors from here -->
        <link href="{{ asset('back/css/colors/blue.css') }}" id="theme" rel="stylesheet"/>
        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->
        <style>
            .error-body h1 {
    font-size: 100px;
    font-weight: 900;
    line-height: 164px;
}
        </style>
    </head>
    <body class="fix-header card-no-border logo-center">
        <!-- ============================================================== -->
        <!-- Main wrapper - style you can find in pages.scss -->
        <!-- ============================================================== -->
        <section class="error-page" id="wrapper">
            <div class="error-box">
                <div class="error-body text-center">
                    <h1>
                        Pagina en construcción
                    </h1>
                    <h3 class="text-uppercase">
                        Disculpe las molestias estamos trabajando para mejorar su experiencia de usuario.
                    </h3>
                    {{--
                    <p class="text-muted m-t-30 m-b-30">
                        YOU SEEM TO BE TRYING TO FIND HIS WAY HOME
                    </p>
                    --}}
                    <a class="btn btn-info btn-rounded waves-effect waves-light m-b-40" href="{{ route('inicio')  }}">
                        Volver al inicio
                    </a>
                    <h3 class="">
                        <strong class="text-uppercase">
                            Para seguir con su proceso de reservación le recomendamos enviar su papeleta al correo:
                        </strong>
                        <a href="mailto:reservacionescorporativo@beneficiosvacacionales.mx">
                            reservacionescorporativo@beneficiosvacacionales.mx
                        </a>
                    </h3>
                    <div class="text-center">
                        <a class="btn btn-success btn-rounded waves-effect waves-light m-b-40" href="{{ asset('files/papeleta.pdf') }}" target="_blank">
                            Descargar papeleta
                        </a>
                    </div>
                </div>
                <footer class="footer text-center">
                    © {{ date('Y') .' '. env('APP_NAME')}}
                </footer>
            </div>
        </section>
        <script src="{{ asset('back/assets/plugins/jquery/jquery.min.js') }}">
        </script>
        <!-- Bootstrap tether Core JavaScript -->
        <script src="{{ asset('back/assets/plugins/bootstrap/js/popper.min.js') }}">
        </script>
        <script src="{{ asset('back/assets/plugins/bootstrap/js/bootstrap.min.js') }}">
        </script>
        <!--Wave Effects -->
        <script src="{{ asset('back/js/waves.js') }}">
        </script>
    </body>
</html>
