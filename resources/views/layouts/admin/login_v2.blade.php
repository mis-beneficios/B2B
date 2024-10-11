<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8"/>
        <meta content="IE=edge" http-equiv="X-UA-Compatible"/>
        <!-- Tell the browser to be responsive to screen width -->
        <meta content="width=device-width, initial-scale=1" name="viewport"/>
        <meta content="" name="description"/>
        <meta content="ISW. Diego Enrique Sanchez" name="author"/>
        <title>
            @if (env('APP_PAIS_ID') == 1)
            Bienvenido {{ env('APP_NAME') }}
            @else
            Bienvenido {{ env('APP_NAME_USA') }}
            @endif
        </title>
        <!-- Bootstrap Core CSS -->
        <link href="{{ asset('back/assets/plugins/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet"/>
        <!-- Custom CSS -->
        <link href="{{ asset('back/css/style.css') }}" rel="stylesheet"/>
        <!-- You can change the theme colors from here -->
        <link href="{{ asset('back/css/colors/blue.css') }}" id="theme" rel="stylesheet"/>
        <link href="{{ asset('plugins/toastr/build/toastr.min.css') }}" rel="stylesheet"/>
        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
            <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->
        <style>
            body, html {
              height: 100%;
            }
            .wrapper{
                background: url({{ $fondo }}) no-repeat center center fixed;

              /* Full height */
              height: 100%;

              /* Center and scale the image nicely */
              background-position: center;
             -webkit-background-size: cover;
              -moz-background-size: cover;
              -o-background-size: cover;
              background-size: cover;
            }
        </style>
    </head>
    <body>
        <!-- ============================================================== -->
        <!-- Preloader - style you can find in spinners.css -->
        <!-- ============================================================== -->
        <div class="preloader">
            <svg class="circular" viewbox="25 25 50 50">
                <circle class="path" cx="50" cy="50" fill="none" r="20" stroke-miterlimit="10" stroke-width="2">
                </circle>
            </svg>
        </div>
        <section class="login-register login-sidebar" id="wrapper" style="background-image:url(https://wallpaper-house.com/data/out/10/wallpaper2you_401849.jpg);">
            <div class="login-box card">
                <div class="card-body">
                    <form action="{{ route('login') }}" class="form-horizontal form-material mt-5" id="loginform" method="post">
                        @csrf
                        <a class="text-center db" href="javascript:void(0)">
                            <img alt="" class="" src="{{ asset('images/icono01.png') }}" width='200px"/'>
                            </img>
                        </a>
                        <div class="form-group m-t-40">
                            <div class="col-xs-12">
                                <input class="form-control" id="username" name="username" onblur="this.placeholder = 'Correo electrónico'" onfocus="this.placeholder = ''" placeholder="{!! trans('messages.login.correo')!!}" required="" style="color: black;" type="email" value="{{ old('username') }}">
                                </input>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-12">
                                <input class="form-control" id="pass_hash" name="pass_hash" onblur="this.placeholder = 'Contraseña'" onfocus="this.placeholder = ''" placeholder="{!! trans('messages.login.contrasena')!!}" required="" type="password">
                                </input>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-12">
                                <a class="text-dark pull-right" href="javascript:void(0)" id="to-recover">
                                    <i class="fa fa-lock m-r-5">
                                    </i>
                                    {{ __('messages.login.forgot_pass') }}
                                </a>
                            </div>
                        </div>
                        <div class="form-group text-center m-t-20">
                            <div class="col-xs-12">
                                <button class="btn btn-info btn-block text-uppercase waves-effect waves-light" id="btnLogin" type="submit">
                                    {{ __('messages.login.submit') }}
                                </button>
                            </div>
                        </div>
                    </form>
                    <form action="{{ route('password.email') }}" class="form-horizontal form-material" id="recoverform" method="POST">
                        @csrf
                        <div class="form-group ">
                            <div class="col-xs-12">
                                <h3>
                                    {{ __('messages.login.restablecer') }}
                                </h3>
                            </div>
                        </div>
                        <div class="form-group ">
                            <div class="col-xs-12">
                                <input autocomplete="username" autofocus="" class="form-control @error('username') is-invalid @enderror" id="username" name="username" placeholder="Correo electrónico" required="" type="email" value="{{ old('username') }}">
                                    @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>
                                            {{ $message }}
                                        </strong>
                                    </span>
                                    @enderror
                                </input>
                            </div>
                        </div>
                        <div class="form-group text-center m-t-20">
                            <div class="col-xs-12">
                                <button class="btn btn-info btn-block btn-sm" type="submit">
                                    {{ __('messages.login.enviar_link') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </section>
        <script src="{{ asset('back/assets/plugins/jquery/jquery.min.js') }}">
        </script>
        <!-- Bootstrap tether Core JavaScript -->
        <script src="{{ asset('back/assets/plugins/bootstrap/js/popper.min.js') }}">
        </script>
        <script src="{{ asset('back/assets/plugins/bootstrap/js/bootstrap.min.js') }}">
        </script>
        <!-- slimscrollbar scrollbar JavaScript -->
        <script src="{{ asset('back/js/jquery.slimscroll.js') }}">
        </script>
        <!--Wave Effects -->
        <script src="{{ asset('back/js/waves.js') }}">
        </script>
        <!--Menu sidebar -->
        <script src="{{ asset('back/js/sidebarmenu.js') }}">
        </script>
        <!--stickey kit -->
        <script src="{{ asset('back/assets/plugins/sticky-kit-master/dist/sticky-kit.min.js') }}">
        </script>
        <script src="{{ asset('back/assets/plugins/sparkline/jquery.sparkline.min.js') }}">
        </script>
        <!--Custom JavaScript -->
        <script src="{{ asset('back/js/custom.min.js') }}">
        </script>
        <!-- ============================================================== -->
        <!-- Style switcher -->
        <!-- ============================================================== -->
        <script src="{{ asset('back/assets/plugins/styleswitcher/jQuery.style.switcher.js') }}">
        </script>
        <script src="{{ asset('plugins/toastr/build/toastr.min.js') }}">
        </script>
    </body>
</html>