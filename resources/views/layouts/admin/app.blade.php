<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8" />
    <meta content="IE=edge" http-equiv="X-UA-Compatible" />
    <meta content="width=device-width, initial-scale=1" name="viewport" />
    <meta content="" name="Sistema administrativo Beneficios Vacacionales" />
    <meta content="{{ csrf_token() }}" name="csrf-token" />
    <link href="{{ session('config.preload_image') }} " rel="icon" sizes="16x16" type="image/png" />
    <title>
        Bienvenido {{ env('APP_NAME', 'Mis Beneficios Vacacionales') }}
    </title>
    @include('layouts.admin.head')
    <link rel="stylesheet" href="{{ asset('css/beneficios.css') }}">
    <script src="https://cdn.jsdelivr.net/npm/intro.js@7.0.1/intro.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/intro.js@7.0.1/minified/introjs.min.css" rel="stylesheet">
</head>

<body class="fix-header card-no-border logo-center">
    @include('admin.elementos.views.efecto_nieve')
    <div class="preloader">
        <svg class="circular" viewbox="25 25 50 50">
            <circle class="path" cx="50" cy="50" fill="none" r="20" stroke-miterlimit="10"
                stroke-width="2">
            </circle>
        </svg>
    </div>
    <div class="overlay" id="overlay" style="display: none;">
        <div class="overlay__inner">
            <div class="overlay__content">
                <img src="{{ session('config.preload_image') }}" style="width: 280px;" />
            </div>
        </div>
    </div>
    <div id="preload-overlay" style="display: none;">
        <div id="preload-spinner"></div>
    </div>
    <div id="main-wrapper">
        <header class="topbar">
            <nav class="navbar top-navbar navbar-expand-md navbar-light">
                <div class="navbar-header">
                    <a class="navbar-brand" href="{{ url('/') }}">
                        <img alt="homepage" class="dark-logo hidden-sm-down"
                            src="{{ asset('images/mis_beneficios.png') }}" width="150px" />
                        <img alt="homepage" class="light-logo hidden-sm-down"
                            src="{{ asset('images/mis_beneficios.png') }}" width="150px" />
                    </a>
                </div>
                <div class="navbar-collapse">
                    <ul class="navbar-nav mr-auto mt-md-0">
                        <li class="nav-item">
                            <a class="nav-link nav-toggler hidden-md-up text-muted waves-effect waves-dark"
                                href="javascript:void(0)">
                                <i class="mdi mdi-menu">
                                </i>
                            </a>
                        </li>
                        @if (Auth::user()->role != 'client')
                            <li class="nav-item hidden-sm-down search-box">
                                <a class="nav-link hidden-sm-down text-muted waves-effect waves-dark"
                                    href="javascript:void(0)">
                                    <i class="ti-search">
                                    </i>
                                </a>
                                <form class="app-search" id="app_search">
                                    <input class="form-control" id="text_search" name="text_search"
                                        placeholder="Buscar..." type="text">
                                    <a class="srh-btn">
                                        <i class="ti-close">
                                        </i>
                                    </a>
                                    </input>
                                </form>
                            </li>
                        @endif
                    </ul>
                    <ul class="navbar-nav my-lg-0">
                        @if (Auth::user()->role != 'client')
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle text-muted waves-effect waves-dark" href=""
                                    id="2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fa fa-bell"></i>
                                    <div class="notify"> <span class="heartbit"></span> <span class="point"></span>
                                    </div>
                                </a>
                                <div class="dropdown-menu mailbox dropdown-menu-right scale-up" aria-labelledby="2">
                                    <ul>
                                        <li>
                                            <div class="drop-title">Tienes 2 nuevas notificaciones</div>
                                        </li>
                                        <li>
                                            <div class="slimScrollDiv"
                                                style="position: relative; overflow: hidden; width: auto; height: auto;">
                                                <div class="message-center"
                                                    style="overflow: hidden; width: auto; height: auto;">
                                                    <a href="#" data-toggle="modal"
                                                        data-target="#modalNotificacion">
                                                        <div class="mail-contnet">
                                                            <h5>Busqueda avanzada</h5>
                                                            <span class="mail-desc">Sistema administrativo</span>
                                                            <span class="time">Actualización</span>
                                                        </div>
                                                    </a>
                                                </div>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="slimScrollDiv"
                                                style="position: relative; overflow: hidden; width: auto; height: auto;">
                                                <div class="message-center"
                                                    style="overflow: hidden; width: auto; height: auto;">
                                                    <a href="#" data-toggle="modal"
                                                        data-target="#modalDescuento">
                                                        <div class="mail-contnet">
                                                            <h5>Aplicar descuento a folios</h5>
                                                            <span class="mail-desc">Sistema administrativo</span>
                                                            <span class="time">Actualización</span>
                                                        </div>
                                                    </a>
                                                </div>
                                            </div>
                                        </li>
                                        {{--  <li>
                                                <a class="nav-link text-center" href="javascript:void(0);"> <strong>See all e-Mails</strong> <i class="fa fa-angle-right"></i> </a>
                                            </li> --}}
                                    </ul>
                                </div>
                            </li>
                        @endif
                        <li class="nav-item dropdown">
                            <a aria-expanded="false" aria-haspopup="true"
                                class="nav-link dropdown-toggle text-muted waves-effect waves-dark"
                                data-toggle="dropdown" href="">
                                <i class="fas fa-user">
                                </i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right scale-up">
                                <ul class="dropdown-user">
                                    <li>
                                        <div class="dw-user-box">
                                            <div class="u-text">
                                                <h4>
                                                    {{ Auth::user()->fullName }}
                                                </h4>
                                                <p class="text-muted">
                                                    {{ Auth::user()->username }}
                                                </p>
                                            </div>
                                        </div>
                                    </li>
                                    {{--    <li>
                                            <a href="{{ route('perfil') }}">
                                                <i class="fa fa-user"></i>
                                                Perfil
                                            </a>
                                        </li> --}}
                                    @if (env('APP_PAIS_ID') != 7)
                                        <li>
                                            <a data-target="#modalColor" data-toggle="modal" href="javascript():;">
                                                <i aria-hidden="true" class="fa fa-paint-brush">
                                                </i>
                                                Cambiar tema
                                            </a>
                                        </li>
                                    @endif
                                    <li class="divider" role="separator">
                                    </li>
                                    <li>
                                        <a href="{{ route('logout') }}"
                                            onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                            <i class="fa fa-power-off">
                                            </i>
                                            {{ __('messages.cliente.salir') }}
                                        </a>
                                        <form action="{{ route('logout') }}" class="d-none" id="logout-form"
                                            method="POST">
                                            @csrf
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        </li>
                    </ul>
                </div>
            </nav>
        </header>
        {{-- @if (Auth::user()->username == 'dsanchez@pacifictravels.mx') --}}
        <div class="">
            <button
                class="right-side-toggle waves-effect waves-light btn-success btn btn-circle btn-sm pull-right m-l-10">
                <i class="ti-settings text-white">
                </i>
            </button>
        </div>
        {{-- @endif --}}
        <aside class="left-sidebar">
            <div class="scroll-sidebar">
                @include('layouts.admin.menus.' . Auth::user()->role)
            </div>
        </aside>


        <div class="page-wrapper" id="">
            <div class="container-fluid" id="app">
                {{--    <div class="row">
                        <div class="alert alert-info mt-2">
                            <button aria-label="Close" class="close" data-dismiss="alert" type="button">
                                <span aria-hidden="true">
                                    ×
                                </span>
                            </button>
                            <h4 class="text-info">
                                <i class="fa fa-exclamation-circle">
                                </i>
                                Notificación
                            </h4>
                            Estimado miembro de Beneficios Vacacionales, se estará llevando a cabo una migración de archivos a un almacenamiento externo AWS S3 el cual podría verse afectada la carga de archivos al sistema como: imágenes, documentos, etc.
                            <br>
                            Sin mas por el momento, este proceso, no afectara en el registro de datos (clientes, ventas, convenios, reservaciones, etc).
                        </div>
                    </div> --}}
                @yield('content')
                <div class="right-sidebar">
                    <div class="slimscrollright">
                        <div class="rpanel-title">
                            Opciones de sistema
                            <span>
                                <i class="ti-close right-side-toggle">
                                </i>
                            </span>
                        </div>
                        <div class="r-panel-body">
                            <ul class="m-t-20">
                                <li>
                                    <a class="btn btn-rounded btn-outline-primary btn-block" href="javascript:void(0)"
                                        id="btnEliminarCache">
                                        <i class="fas fa-trash">
                                        </i>
                                        Eliminar cache
                                    </a>
                                </li>
                                <li>
                                    <a class="btn btn-rounded btn-outline-warning btn-block"
                                        href="{{ route('settings.process') }}">
                                        <i class="fas fa-cogs">
                                        </i>
                                        Tabla de procesos
                                    </a>
                                </li>
                                <li>
                                    <a class="btn btn-rounded btn-outline-info btn-block"
                                        href="{{ route('notificaciones.index') }}">
                                        <i class="fa fa-terminal">
                                        </i>
                                        Notificaciones
                                    </a>
                                </li>
                                <li>
                                    <a class="btn btn-rounded btn-outline-success btn-block"
                                        href="{{ url('log-viewer') }}">
                                        <i class="fa fa-warning">
                                        </i>
                                        Log Viewer
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            {{-- 
                @foreach ($notificaciones as $notificacion)
                    @if ($notificacion->estatus == 0 && in_array(Auth::user()->role, explode(',', $notificacion->show_role)))
                        @include('admin.notificaciones.mostrar', ['notificacion' => $notificacion])
                    @endif
                @endforeach 
            --}}

            <footer class="footer" style="width: 100%">
                <p class="footer-text pull-left m-0">
                    Copyright © 2022cTodos los Derechos Reservados :: <b> {{ env('APP_NAME') }}</b> v3.4
                </p>
                <b class="pull-right hidden-xs-down hidden-sm-down hidden-md-down">
                    Design & Development by:
                    @if (Auth::user()->role != 'client')
                        <a href="#">
                            Isw. Diego Enrique Sanchez
                        </a>
                    @else
                        <a href="#">
                            Isw. Diego Enrique Sanchez
                        </a>
                    @endif
                </b>
            </footer>
        </div>
    </div>
    @include('admin.elementos.modales.modalBuscarCliente')
    @include('admin.elementos.modales.modalSearch')

    {{--
    -- @include('admin.elementos.modales.modalHistorial')
    @include('admin.elementos.modales.modalHistorialEmpresa')
    -- @include('admin.elementos.modales.modalLog')
    -- @include('admin.elementos.modales.modalAddTarjeta')
    -- @include('admin.elementos.modales.modalAddContrato')
    
    -- @include('admin.elementos.modales.modalShowPagos')
    -- @include('admin.elementos.modales.modalVerContrato')
    
    @include('admin.elementos.modales.modalCambioEstancia')
    @include('admin.elementos.modales.modalAddPago')
    @include('admin.elementos.modales.modalGeneral')
    @include('admin.elementos.modales.modalAutorizar')
    @include('admin.elementos.modales.modalDesTarjetas')
    @include('admin.elementos.modales.modalRechazarPago')
    @include('admin.elementos.modales.modalColor')
    @include('admin.elementos.modales.modalEmpresa')
        
    @include('admin.elementos.modales.modalNotificacionBusqueda')
    @include('admin.elementos.modales.modalNotificacionDescuento')
    @include('admin.elementos.modales.modalClear')
--}}
    <script>
        // introJs().setOption("dontShowAgain", false).start();

        document.getElementById('modalBuscarCliente').addEventListener('click', function() {
            const input = document.getElementById('text_search_2');
            input.focus();
        });

        $(function() {
            $('[data-toggle="tooltip"]').tooltip()
        })
        if (@json(config('app.locale')) == 'es') {
            $.extend($.fn.dataTable.defaults, {
                language: {
                    "sProcessing": "Procesando...",
                    "sLengthMenu": "Mostrar _MENU_ registros",
                    "sZeroRecords": "No se encontraron resultados",
                    "sEmptyTable": "Ningún dato disponible en esta tabla",
                    "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                    "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
                    "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
                    "sInfoPostFix": "",
                    "sSearch": "Buscar:",
                    "sUrl": "",
                    "sInfoThousands": ",",
                    "sLoadingRecords": "Cargando...",
                    "oPaginate": {
                        "sFirst": "Primero",
                        "sLast": "Último",
                        "sNext": "Siguiente",
                        "sPrevious": "Anterior"
                    },
                    "oAria": {
                        "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
                        "sSortDescending": ": Activar para ordenar la columna de manera descendente"
                    }
                }
            });

            $.datepicker.regional['es'] = {
                closeText: 'Cerrar',
                prevText: '< Ant',
                nextText: 'Sig >',
                currentText: 'Hoy',
                monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre',
                    'Octubre', 'Noviembre', 'Diciembre'
                ],
                monthNamesShort: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
                dayNames: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
                dayNamesShort: ['Dom', 'Lun', 'Mar', 'Mié', 'Juv', 'Vie', 'Sáb'],
                dayNamesMin: ['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sá'],
                weekHeader: 'Sm',
                dateFormat: 'dd/mm/yy',
                firstDay: 1,
                isRTL: false,
                showMonthAfterYear: false,
                yearSuffix: ''
            };

            $.datepicker.setDefaults($.datepicker.regional['es']);
        }

        $('.datepicker_material').bootstrapMaterialDatePicker({
            weekStart: 0,
            time: false,
            lang: 'es',
        });
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        toastr.options = {
            "closeButton": true,
            "debug": false,
            "newestOnTop": true,
            "progressBar": true,
            // "positionClass": "toast-top-center",
            "positionClass": "toast-top-full-width",
            "preventDuplicates": true,
            "onclick": null,
            "showDuration": "500",
            "hideDuration": "1000",
            "timeOut": "5000",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        }
        $('[data-toggle="tooltip"]').tooltip();

        $('.select2').select2({
            width: 'resolve'
        });
        $.fn.select2.defaults.set("theme", "classic");
        $.fn.modal.Constructor.prototype.enforceFocus = function() {};

        const Toast = Swal.mixin({
            toast: true,
            position: 'top',
            showConfirmButton: false,
            timer: 5000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        })
        moment.locale('es');
        $('.datatable_sample').dataTable();
        $('.timepicker').bootstrapMaterialDatePicker({
            format: 'HH:mm',
            time: true,
            date: false
        });

        $('.summernote').summernote({
            height: 300,
        });

        window.addEventListener('alert', event => {
            toastr[event.detail.type](event.detail.message,
                event.detail.title ?? ''), toastr.options = {
                "closeButton": true,
                "progressBar": true,
            }
        });
        window.addEventListener('alertSweet', event => {
            Swal.fire({
                title: event.detail.title,
                html: event.detail.message,
                icon: event.detail.type
            });
        });
    </script>
    @if (!isset($_COOKIE['color_system']) && env('APP_ADMIN') == true && Auth::user()->role != 'client')
        <script>
            setTimeout(function() {
                $('#modalColor').modal('show');
            }, 1000);
        </script>
    @endif
    <script src="{{ asset('js/custom_admin.js') }}"></script>
    @yield('script')

</body>

</html>
