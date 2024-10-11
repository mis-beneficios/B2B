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
            Bienvenido {{ env('APP_NAME') }}
        </title>
        <!-- Bootstrap Core CSS -->
        <link href="{{ asset('back/assets/plugins/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet"/>
        <!-- Custom CSS -->
        <link href="{{ asset('back/css/style.css') }}" rel="stylesheet"/>
        <!-- You can change the theme colors from here -->
        <link href="{{ asset('back/css/colors/blue.css') }}" id="theme" rel="stylesheet"/>
        <link href="{{ asset('plugins/toastr/build/toastr.min.css') }}" rel="stylesheet"/>
        <link rel="stylesheet" href="{{ asset('css/beneficios.css') }}">
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
              /* Full height */
                background: url({{ $back_image }});
                height: 100%;
              /* Center and scale the image nicely */
                background-position: center;
                -webkit-background-size: cover;
                -moz-background-size: cover;
                -o-background-size: cover;
                background-size: cover;
            }
            body:after {
              content: "ISW Diego Sanchez"; 
              font-size: 12px;  
              color: rgba(254, 254, 254, 0.4);
              z-index: 9999;
             
              display: flex;
              align-items: center;
              justify-content: center;
              position: fixed;
              top: 50%;
              right: 0;
              bottom: 0;
              left: 0;
                
              -webkit-pointer-events: none;
              -moz-pointer-events: none;
              -ms-pointer-events: none;
              -o-pointer-events: none;
              pointer-events: none;

              -webkit-user-select: none;
              -moz-user-select: none;
              -ms-user-select: none;
              -o-user-select: none;
              user-select: none;
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
        <div class="overlay" id="overlay" style="display: none;">
            <div class="overlay__inner">
                <div class="overlay__content">
                    <img src="{{asset($preload_image)}}" style="width: 280px;"/>
                </div>
            </div>
        </div>
        <!-- ============================================================== -->
        <!-- Main wrapper - style you can find in pages.scss -->
        <!-- ============================================================== -->
        <section class="wrapper" id="wrapper">
            <div class="agua"></div>
            <div class="login-register">
                <div class="login-box card" style="background-color: rgba(255, 255, 255, 1);">
                    <div class="card-body">
                        <div class="text-center">
                            <img alt="" class="" src="{{ asset($preload_image) }}" width='200px"/'>
                            </img>
                        </div>
                        <form action="{{ route('login') }}" class="form-horizontal form-material" id="loginform" method="post">
                            @csrf
                            <h3 class="box-title m-b-20 text-center">
                                {{ __('messages.login.titulo') }}
                            </h3>
                            @if (session('info'))
                            <div class="alert alert-danger">
                                {{ session('info') }}
                            </div>
                            @endif
                            <div class="form-group ">
                                <div class="col-xs-12">
                                    <input class="form-control" id="username" name="username" onblur="this.placeholder = 'Correo electrónico'" onfocus="this.placeholder = ''" placeholder="{!! trans('messages.login.correo')!!}" required="" style="color: black;" type="email" value="{{ old('username') }}">
                                    </input>
                                </div>
                                @error('username')
                                <span class="invalid-feedback" role="alert">
                                    <strong>
                                        {{ $message }}
                                    </strong>
                                </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <div class="col-xs-12">
                                    <input class="form-control" id="pass_hash" name="pass_hash" onblur="this.placeholder = 'Contraseña'" onfocus="this.placeholder = ''" placeholder="{!! trans('messages.login.contrasena')!!}" required="" type="password">
                                    </input>
                                </div>
                                @error('pass_hash')
                                <span class="invalid-feedback" role="alert">
                                    <strong>
                                        {{ $message }}
                                    </strong>
                                </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <div class="col-md-12">
                                    {{--
                                    <a class="text-dark pull-right" href="{{ route('password.request') }}" id="to-recover">
                                        <i class="fa fa-lock m-r-5">
                                        </i>
                                        {{ __('messages.login.forgot_pass') }}
                                    </a>
                                    --}}
                                    <a class="text-dark pull-right" href="javascript:void(0)" id="to-recover">
                                        <i class="fa fa-lock m-r-5">
                                        </i>
                                        {{ __('messages.login.forgot_pass') }}
                                    </a>
                                </div>
                            </div>
                            <div class="form-group text-center m-t-20">
                                <div class="col-xs-12">
                                    <button class="btn btn-info btn-sm btn-block text-uppercase waves-effect waves-light" id="btnLogin" type="submit">
                                        {{ __('messages.login.submit') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                        {{--
                        <form action="index.html" class="form-horizontal form-material" id="loginform">
                            <h3 class="box-title m-b-20">
                                Sign In
                            </h3>
                            <div class="form-group ">
                                <div class="col-xs-12">
                                    <input class="form-control" placeholder="Username" required="" type="text">
                                    </input>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-xs-12">
                                    <input class="form-control" placeholder="Password" required="" type="password">
                                    </input>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-12">
                                    <div class="checkbox checkbox-primary pull-left p-t-0">
                                        <input id="checkbox-signup" type="checkbox">
                                            <label for="checkbox-signup">
                                                Remember me
                                            </label>
                                        </input>
                                    </div>
                                    <a class="text-dark pull-right" href="javascript:void(0)" id="to-recover">
                                        <i class="fa fa-lock m-r-5">
                                        </i>
                                        Forgot pwd?
                                    </a>
                                </div>
                            </div>
                            <div class="form-group text-center m-t-20">
                                <div class="col-xs-12">
                                    <button class="btn btn-info btn-lg btn-block text-uppercase waves-effect waves-light" type="submit">
                                        Log In
                                    </button>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12 m-t-10 text-center">
                                    <div class="social">
                                        <a class="btn btn-facebook" data-toggle="tooltip" href="javascript:void(0)" title="Login with Facebook">
                                            <i aria-hidden="true" class="fa fa-facebook">
                                            </i>
                                        </a>
                                        <a class="btn btn-googleplus" data-toggle="tooltip" href="javascript:void(0)" title="Login with Google">
                                            <i aria-hidden="true" class="fa fa-google-plus">
                                            </i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group m-b-0">
                                <div class="col-sm-12 text-center">
                                    <p>
                                        Don't have an account?
                                        <a class="text-info m-l-5" href="register.html">
                                            <b>
                                                Sign Up
                                            </b>
                                        </a>
                                    </p>
                                </div>
                            </div>
                        </form>
                        --}}
                        {{--
                        <form action="index.html" class="form-horizontal" id="recoverform">
                            --}}
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
                            {{--
                        </form>
                        --}}
                    </div>
                </div>
            </div>
        </section>
        <!-- ============================================================== -->
        <!-- End Wrapper -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- All Jquery -->
        <!-- ============================================================== -->
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
        <script>

            $(document).ready(function() {

                document.getElementById('loginform').addEventListener('submit', function() {
                    $("#overlay").css("display", "block");
                });
           
                toastr.options = {
                    "closeButton": true,
                    "debug": false,
                    "newestOnTop": false,
                    "progressBar": true,
                    "positionClass": "toast-top-right",
                    "preventDuplicates": false,
                    "onclick": null,
                    "showDuration": "400",
                    "hideDuration": "1000",
                    "timeOut": "5000",
                    "extendedTimeOut": "1000",
                    "showEasing": "swing",
                    "hideEasing": "linear",
                    "showMethod": "fadeIn",
                    "hideMethod": "fadeOut"
                }
                
                // $('body').on('submit', '#loginform', function(event) {
                //     event.preventDefault();
                //     $.ajax({
                //         type: $(this).attr('method'),
                //         url: $(this).attr('action'),
                //         data: $(this).serialize(),
                //         dataType: "json",
                //         beforeSend: function() {
                //             $('#overlay').css('display', 'block');
                //             $('#btnLogin').html('Espere...');
                //         },
                //         success: function(res) {
                //             if (res.success == false && res.user == false) {
                //                 // toastr['error']('Usuario y/o contraseña incorrecto');
                //                 toastr['error'](res.error);
                //             }
                //             if (res.success == true) {
                //                 toastr['info']('Redireccionando...');
                //                 window.location.href = res.url;
                //             }
                //         },
                //         error() {}
                //     }).always(function() {
                //         $('#btnLogin').html('Entrar');
                //         $('#overlay').css('display', 'none');
                //     });
                // });


                $('body').on('submit', '#recoverform', function(event) {
                    event.preventDefault();
                    $.ajax({
                        url: $(this).attr('action'),
                        type: $(this).attr('method'),
                        dataType: 'json',
                        data: $(this).serialize(),
                        beforeSend: function() {
                            $('#overlay').css('display', 'block');
                        },
                        success: function(res) {
                            toastr[(res.success == true) ? 'success' : 'error'](res.message);
                        }
                    }).always(function() {
                        $('#overlay').css('display', 'none');
                    });
                });

                $('body').on('click', '.modal_hoteles', function(event) {
                    event.preventDefault();
                    $hotel = $(this).data('hotel');
                    $('#modalHoteles #titulo').append($(this).data('titulo'));
                    $('#modalHoteles .modal-body').html('<img src="' + baseuri + $hotel + '" class="img-fluid" alt="Responsive image">');
                    $('#modalHoteles').modal('show');
                });

                $('body').on('submit', '#form_register_alert_mx', function(event) {
                    event.preventDefault();
                    $.ajax({
                        url: baseuri + "user-alert-mx",
                        type: 'POST',
                        dataType: 'json',
                        data: $(this).serialize(),
                        beforeSend: function() {},
                        success: function(res) {
                            console.log(res);
                            if (res.success == false) {
                                pintar_errores(res.errors)
                            }
                            if (res.success == true) {
                                $('#moda_pre_registro_usa').modal('hide');
                                toastr['success']('You are now subscribed, you have been assigned an account manager and travel perks specialist will get in touch shortly to help tailor the perfect vacation!');
                                toastr.options = {
                                    "closeButton": true,
                                    "debug": false,
                                    "newestOnTop": false,
                                    "progressBar": true,
                                    "positionClass": "toast-top-right",
                                    "preventDuplicates": false,
                                    "onclick": null,
                                    "showDuration": "300",
                                    "hideDuration": "3000",
                                    "timeOut": "8000",
                                    "extendedTimeOut": "1000",
                                    "showEasing": "swing",
                                    "hideEasing": "linear",
                                    "showMethod": "fadeIn",
                                    "hideMethod": "fadeOut"
                                }
                            };
                        }
                    }).always(function() {});
                });
            });

            function pintar_errores(errores = null) {
                $(".errors").html('');
                $(".errors").parent().removeClass('has-error');
                $.each(errores, function(k, v) {
                    $(".error-" + k).html(v + ' <br/>');
                    $(".error-" + k).parent().addClass('has-error');
                });
            }
        </script>
    </body>
</html>