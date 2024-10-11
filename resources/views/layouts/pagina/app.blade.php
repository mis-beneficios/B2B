<!DOCTYPE doctype html>
<html lang="es">
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8"/>
        <meta content="text/html; charset=utf-8" http-equiv="content-type"/>
        <meta content="width=device-width, initial-scale=1, shrink-to-fit=no" name="viewport"/>
        <meta content="{{ csrf_token() }}" name="csrf-token"/>
        <title>
            {{ env('APP_NAME') }}
        </title>
        <link href="{{ asset('images/icono01.png') }} " rel="icon"/>
        <!-- Bootstrap CSS -->
        <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet"/>
        <!-- animate CSS -->
        <link href="{{ asset('assets/css/animate.css') }}" rel="stylesheet"/>
        <!-- owl carousel CSS -->
        {{--
        <link href="{{ asset('assets/css/owl.carousel.min.css') }}" rel="stylesheet"/>
        --}}
        {{--
        <link href="{{ asset('plugins/owl-carousel/owl.carousel.css') }}" rel="stylesheet"/>
        <link href="{{ asset('plugins/owl-carousel/owl.theme.default.css') }}" rel="stylesheet"/>
        --}}
        <!-- themify CSS -->
        <link href="{{ asset('assets/css/themify-icons.css') }}" rel="stylesheet"/>
        <!-- flaticon CSS -->
        <link href="{{ asset('assets/css/flaticon.css') }}" rel="stylesheet"/>
        <!-- fontawesome CSS -->
        <link href="{{ asset('assets/fontawesome/css/all.min.css') }}" rel="stylesheet"/>
        <!-- magnific CSS -->
        <link href="{{ asset('assets/css/magnific-popup.css') }}" rel="stylesheet"/>
        <link href="{{ asset('assets/css/gijgo.min.css') }}" rel="stylesheet"/>
        <!-- niceselect CSS -->
        <link href="{{ asset('assets/css/nice-select.css') }}" rel="stylesheet"/>
        <!-- slick CSS -->
        <link href="{{ asset('assets/css/slick.css') }}" rel="stylesheet"/>
        <!-- style CSS -->
        <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet"/>
        <link href="{{ asset('css/style.css') }}" rel="stylesheet"/>
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet"/>
        <link href="{{ asset('plugins/toastr/build/toastr.min.css') }}" rel="stylesheet"/>
        <link href="{{ asset('plugins/alertifyjs/build/css/alertify.min.css') }}" rel="stylesheet"/>
        {{--
        <link href="{{ asset('plugins/alertifyjs/build/css/theme/bootstrap.min.css') }}" rel="stylesheet"/>
        --}}
        <link href="{{ asset('plugins/OwlCarousel2/dist/assets/owl.carousel.min.css') }}" rel="stylesheet"/>
        <link href="{{ asset('plugins/OwlCarousel2/dist/assets/owl.teheme.default.min.css') }}" rel="stylesheet"/>
        <script src="https://api.demo.convergepay.com/hosted-payments/Checkout.js">
        </script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js">
        </script>
        <link href="{{ asset('css/custom.css') }}" rel="stylesheet" type="text/css"/>
        <link href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" rel="stylesheet" type="text/css"/>
        <style>
            .errors{
                font-size: 12px;
            }
        </style>
        <link href="https://fonts.googleapis.com" rel="preconnect"/>
        <link crossorigin="" href="https://fonts.gstatic.com" rel="preconnect"/>
        <link href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@600&family=Fredoka+One&family=Koulen&family=Pacifico&family=Righteous&family=Smooch&display=swap" rel="stylesheet"/>
        @if (env('APP_PAIS_ID') == 1 && env('APP_ENV') == 'production')
        <!-- Google tag (gtag.js) -->
        <script async="" src="https://www.googletagmanager.com/gtag/js?id=G-G3HEX62RP8">
        </script>
        
        <!-- Meta Pixel Code -->
        <script>
        !function(f,b,e,v,n,t,s)
        {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
        n.callMethod.apply(n,arguments):n.queue.push(arguments)};
        if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
        n.queue=[];t=b.createElement(e);t.async=!0;
        t.src=v;s=b.getElementsByTagName(e)[0];
        s.parentNode.insertBefore(t,s)}(window, document,'script',
        'https://connect.facebook.net/en_US/fbevents.js');
        fbq('init', '306973608504462');
        fbq('track', 'PageView');
        </script>
        <noscript><img height="1" width="1" style="display:none"
        src="https://www.facebook.com/tr?id=306973608504462&ev=PageView&noscript=1"
        /></noscript>
        <!-- End Meta Pixel Code -->


        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());
            gtag('config', 'G-G3HEX62RP8');
        </script>

        <!-- Google tag (gtag.js) -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=G-24WZ43Z893"></script>
        <script>
          window.dataLayer = window.dataLayer || [];
          function gtag(){dataLayer.push(arguments);}
          gtag('js', new Date());

          gtag('config', 'G-24WZ43Z893');
        </script>

        
        @if (request()->getRequestUri() == '/empresas-afiliadas' || request()->getRequestUri() == '/beneficios-empresa'|| request()->getRequestUri() == '/beneficios-trabajadores'|| request()->getRequestUri() == '/conoce-nuestros-beneficios'|| request()->getRequestUri() == '/documentos-legales'|| request()->getRequestUri() == '/demo-flyer/modulo_3'|| request()->getRequestUri() == '/demo-flyer/modulo_7')
            @else
        <!-- Smartsupp Live Chat script -->
        <script type="text/javascript">
            var _smartsupp = _smartsupp || {};
            _smartsupp.key = 'c2292a71904ecc9da9ae8c91bbce56d42df2f10f';
            window.smartsupp||(function(d) {
              var s,c,o=smartsupp=function(){ o._.push(arguments)};o._=[];
              s=d.getElementsByTagName('script')[0];c=d.createElement('script');
              c.type='text/javascript';c.charset='utf-8';c.async=true;
              c.src='https://www.smartsuppchat.com/loader.js?';s.parentNode.insertBefore(c,s);
            })(document);
        </script>
        @endif
        @endif

        {{-- @if (env('APP_PAIS_ID') == 7 && env('APP_ENV') == 'production')
        <!-- Google tag (gtag.js) -->
        <script async="" src="https://www.googletagmanager.com/gtag/js?id=G-SFPVSBZ6SH">
        </script>
        <script>
            window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-SFPVSBZ6SH');
        </script>
        <!-- Smartsupp Live Chat script -->
        <script type="text/javascript">
            var _smartsupp = _smartsupp || {};
            _smartsupp.key = '03402fe577bf50630ea7d1e9e19c271e07dd2c8c';
            window.smartsupp||(function(d) {
              var s,c,o=smartsupp=function(){ o._.push(arguments)};o._=[];
              s=d.getElementsByTagName('script')[0];c=d.createElement('script');
              c.type='text/javascript';c.charset='utf-8';c.async=true;
              c.src='https://www.smartsuppchat.com/loader.js?';s.parentNode.insertBefore(c,s);
            })(document);
        </script>
        @endif --}}
    </head>
    <body>
        <div class="overlay" id="overlay" style="display: none;">
            <div class="overlay__inner">
                <div class="overlay__content">
                    @if (env('APP_PAIS_ID') != 7)
                    <img src="{{asset('images/icono02.png')}}"/>
                    @else
                    <img src="{{asset('images/eu/my_travel.png')}}"/>
                    @endif
                </div>
            </div>
        </div>
        {{-- @include('layouts.pagina.location') --}}
        @include('pagina.mx.navbar')
        <div class="fondo">
            @yield('content')
            @include('pagina.mx.elementos.pre_registro')
            @include('pagina.usa.elementos.pre_registro')
        </div>
        @include('layouts.pagina.footer')
        <script>
            var baseuri='{!!asset('');!!}';
        </script>
        <script src="{{ asset('assets/plugins/jquery/jquery.min.js') }}">
        </script>
        <!-- popper js -->
        <script src="{{ asset('assets/js/popper.min.js') }}">
        </script>
        <!-- bootstrap js -->
        <script src="{{ asset('assets/js/bootstrap.min.js') }}">
        </script>
        <!-- magnific js -->
        <script src="{{ asset('assets/js/jquery.magnific-popup.js') }}">
        </script>
        <script src="{{ asset('assets/plugins/moment/moment.js') }}">
        </script>


         <script src="https://pay.conekta.com/v1.0/js/conekta-checkout.min.js" type="text/javascript">
        </script>
        <script src="https://openpay.s3.amazonaws.com/openpay.v1.min.js" type="text/javascript">
        </script>
        <script src="https://openpay.s3.amazonaws.com/openpay-data.v1.min.js" type="text/javascript">
        </script>
        <script src="https://js.openpay.mx/openpay-data.v1.min.js" type="text/javascript">
        </script>
        <!-- swiper js -->
        {{--
        <script src="{{ asset('plugins/owl-carousel/owl.carousel.js') }}">
        </script>
        --}}
        <script src="{{ asset('plugins/OwlCarousel2/dist/owl.carousel.min.js') }}">
        </script>
        <!-- masonry js -->
        <script src="{{ asset('assets/js/masonry.pkgd.js') }}">
        </script>
        <!-- masonry js -->
        <script src="{{ asset('assets/js/jquery.nice-select.min.js') }}">
        </script>
        <script src="{{ asset('assets/js/gijgo.min.js') }}">
        </script>
        <!-- contact js -->
        <script src="{{ asset('assets/js/jquery.ajaxchimp.min.js') }}">
        </script>
        <script src="{{ asset('assets/js/jquery.form.js') }}">
        </script>
        <script src="{{ asset('assets/js/jquery.validate.min.js') }}">
        </script>
        <script src="{{ asset('assets/js/mail-script.js') }}">
        </script>
        <script src="https://unpkg.com/imask">
        </script>
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js">
        </script>
        <script src="{{ asset('plugins/toastr/build/toastr.min.js') }}">
        </script>
        <script src="{{ asset('plugins/alertifyjs/build/alertify.min.js') }}">
        </script>
        <script charset="utf-8" src="https://cdn.jsdelivr.net/gh/cosmogicofficial/quantumalert@latest/minfile/quantumalert.js">
        </script>
        <script src="{{ asset('assets/js/custom.js') }}">
        </script>
        <script src="{{ asset('js/custom.js') }}">
        </script>
        <script src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js" type="text/javascript">
        </script>
        @if (env('APP_PAIS') == 'en')
        <script src="{{ asset('js/optucorp.js') }}">
        </script>
        @endif
        <script src="//cdn.jsdelivr.net/npm/sweetalert2@11">
        </script>
         {{-- <script type="text/javascript" src="https://resources.openpay.mx/lib/openpay-data-js/1.2.38/openpay-data.v1.min.js"></script> --}}
        <script>
            const Toast = Swal.mixin({
              toast: true,
              position: 'center',
              showConfirmButton: false,
              timer: 3000,
              timerProgressBar: true,
              didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
              }
            })
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $('body').on('submit', '#form_register_alert_usa', function(event) {
                event.preventDefault();
                $.ajax({
                    url: baseuri + "user-alert-usa",
                    type: 'POST',
                    dataType: 'json',
                    data: $(this).serialize(),
                    beforeSend: function() {},
                    success: function(res) {
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
        </script>
        @yield('script')
    </body>
</html>
