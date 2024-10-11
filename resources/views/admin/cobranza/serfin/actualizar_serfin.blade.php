@extends('layouts.admin.app')
@section('content')
<style>
    button > .infoPago{
        display: none;
    }

    #btnPago:hover{
        /*background-color: red;*/
    }

    #btnPago:hover  > .infoPago{
        display: block;
    }
</style>
<div class="row page-titles">
    <div class="col-md-5 col-8 align-self-center">
        <h3 class="text-themecolor text-capitalize">
            Actualizar cobranza
        </h3>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('dashboard') }}">
                    Home
                </a>
            </li>
            <li class="breadcrumb-item">
                Serfin
            </li>
            <li class="breadcrumb-item active">
                Actualizar respuesta serfin
            </li>
        </ol>
    </div>
</div>

<div class="row">
    <div class="col-lg-8 col-xlg-8 col-md-8">
        <div class="card">
            <!-- Nav tabs -->
            <ul class="nav nav-tabs profile-tab" role="tablist">
                <li class="nav-item">
                    <a aria-expanded="true" class="nav-link active" data-toggle="tab" href="#home" role="tab">
                        Respuesta
                    </a>
                </li>
                <li class="nav-item">
                    <a aria-expanded="false" class="nav-link" data-toggle="tab" href="#errores" role="tab">
                        Consultar errores
                    </a>
                </li>
                <li class="nav-item">
                    <a aria-expanded="false" class="nav-link" data-toggle="tab" href="#update" role="tab">
                        Intertar y actualizar registros
                    </a>
                </li>
                <li class="nav-item">
                    <a aria-expanded="false" class="nav-link" data-toggle="tab" href="#delete" role="tab">
                        Eliminar registros
                    </a>
                </li>
            </ul>
            <!-- Tab panes -->
            <div class="tab-content">
                <div aria-expanded="true" class="tab-pane active" id="home" role="tabpanel">
                    <div class="card-body">
                        @php
                            $files = Storage::disk('sftp')->allFiles('Outbox');
                        @endphp
                        <div class="row text-center">
                            @foreach ($files as $f)
                            @if (substr($f, 15, 8) == date('Ymd') && preg_match('/[A-Z0-9]+C/', $f))
                            <div class="col-lg-4 col-md-6 col-sm-8 col-xs-12">
                                <div class="card" style="width: 18rem; text-align: center; align-items: center">
                                    <div class="card-body">
                                        <h5 class="card-title">
                                            {{ substr($f, 7) }}
                                        </h5>
                                        <a class="btn btn-outline-info" href="javascript:;" id="respuesta_diaria">
                                            <i class="fas fa-database">
                                            </i>
                                            Insertar registros
                                        </a>
                                        <br/>
                                        <br/>
                                        <a class="btn btn-outline-warning btnDownload" id="btnTxt" href="{{ route('downloadSFTP', substr($f, 7) ) }}">
                                            <i class="fas fa-text-width">
                                            </i>
                                            Descargar TXT
                                        </a>
                                        <br/>
                                        <br/>
                                        <a class="btn btn-outline-success btnDownload" id="btnExcel" href="{{ route('download_excel', substr($f, 7) ) }}">
                                            <i class="fas fa-file-excel">
                                            </i>
                                            Descargar Excel
                                        </a>
                                    </div>
                                </div>
                            </div>
                            @endif
                            @endforeach
                        </div>
                    </div>
                </div>
                <!--second tab-->
                <div aria-expanded="false" class="tab-pane" id="errores" role="tabpanel">
                    <div class="card-body">
                        <a class="btn btn-outline-primary text-uppercase" href="javascript:;" id="btnErrores">
                            <i class="fa fa-file-excel-o">
                            </i>
                            Consultar errores
                        </a>
                    </div>
                </div>
                <div aria-expanded="false" class="tab-pane" id="update" role="tabpanel">
                    <div class="card-body">
                        <a class="btn btn-outline-primary text-uppercase" href="javascript:;" id="btnInsertar">
                            <i class="fa fa-database">
                            </i>
                            Procesar registros
                        </a>
                        <br/>
                        <br/>
                        <br/>
                        <a class="btn btn-warning text-uppercase" href="javascript:;" id="btnInsertarPagados">
                            <i class="fa fa-database">
                            </i>
                            Procesar solo pagados
                        </a>
                    </div>
                </div>
                <div aria-expanded="false" class="tab-pane" id="delete" role="tabpanel">
                    <div class="card-body">
                        <a class="btn btn-outline-danger text-uppercase" href="javascript:;" id="btnEliminar">
                            <i class="fa fa-trash">
                            </i>
                            Vaciar registros
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4 col-md-4">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">
                    Ingresos
                </h4>
                <div class="text-right">
                    <h1 class="font-light" id="ingresos">
                    </h1>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
    $(document).ready(function() {
        get_ingresos();

        @if (env('APP_ENV') == 'production')
            setInterval(get_ingresos, 5000);
        @endif


        // $(document).on('click', '.btnDownload', function(event) {
        //     event.preventDefault();
        //     var url = $(this).attr('href');

        //     console.log(url);
        // });




        // $('#respuesta_diaria').on('click', function(event) {
        //     event.preventDefault();
        //     $.ajax({
        //         url: '{{ route('daily_response') }}',
        //         type: 'get',
        //         beforeSend: function() {
        //             Swal.fire({
        //                 title: 'Descargando datos de la respuesta',
        //                 timerProgressBar: true,
        //                 showConfirmButton: false,
        //                 allowOutsideClick: false,
        //                 didOpen: () => {
        //                     Swal.showLoading()
        //                 }
        //             });
        //         },
        //         success: function(res) {
        //             console.log(res);
        //             if (res.estatus == true) {
        //                 Swal.DismissReason.close;
        //                 Swal.fire({
        //                     icon: 'success',
        //                     title: 'Se han insertado ' + res.registros.mb + ' registros',
        //                     showConfirmButton: true,
        //                 })
        //             } else {
        //                 Swal.DismissReason.close;

        //                 Swal.fire({
        //                   icon: 'error',
        //                   title: 'No se pudo procesar el archivo.',
        //                   showConfirmButton: true,
        //                 })
        //             }
        //         }
        //     })
        //     .fail(function(jqXHR, textStatus, errorThrown) {
        //         Swal.DismissReason.close;
        //         Swal.close()
        //         Swal.fire({
        //             icon: 'error',
        //             title: errorThrown,
        //             text: jqXHR.responseJSON.message,
        //             showConfirmButton: false,
        //             showCloseButton: true,
        //         })
        //     })
        //     .always(function(){
        //         Swal.DismissReason.close;
        //     });         
        // });
        // 
        // 
        $('#respuesta_diaria').on('click', function(event) {
            event.preventDefault();
            $.ajax({
                url: '{{ route('copy_response') }}',
                type: 'GET',
                dataType: 'JSON',
                beforeSend: function() {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Copiando respuesta',
                        html: 'No cierre ni actualice esta ventana hasta que termine de actualizar el sistema',
                        timerProgressBar: true,
                        showConfirmButton: false,
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading()
                        }
                    });
                },
                success: function(res) {
                    Swal.DismissReason.close;
                    if (res.success == true) {
                        Toast.fire({
                            icon: 'info',
                            title:  'Archivo copiado exitosamente',
                        });

                        response_day();
                    }else{
                        Toast.fire({
                            icon: 'error',
                            title:  'El archivo no se pudo copiar correctamente...',
                        });
                    }
                }
            })
            .fail(function(jqXHR, textStatus, errorThrown) {
                Swal.DismissReason.close;
                Swal.close()
                Swal.fire({
                    icon: 'error',
                    title: errorThrown,
                    text: jqXHR.responseJSON.message,
                    showConfirmButton: false,
                    showCloseButton: true,
                })
            })
            .always(function(){
                Swal.DismissReason.close;
            });    
        });

        $('#btnInsertar').on('click', function(event) {
            event.preventDefault();
            $.ajax({
                url: '{{ route('insert_serfin') }}',
                type: 'GET',
                beforeSend: function() {
                    Swal.fire({
                        icon: 'info',
                        title: 'Insertando',
                        html: 'Los datos se estan insertando...',
                        timerProgressBar: true,
                        showConfirmButton: false,
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading()
                        },
                    });
                },
                success: function(res) {
                    if (res.estatus == true) {
                        Swal.DismissReason.close;
                        Swal.fire({
                            title: 'Actualizar',
                            html: 'Se han insertado: ' + res.registros +
                                ' registros, <br/> ¿Desea actualizar los registros?',
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            confirmButtonText: 'Si, Actualizar',
                            cancelButtonText: 'Cancelar',
                            allowOutsideClick: false
                        }).then((result) => {
                            if (result.value) {
                                $.ajax({
                                    url: '{{ route('update_serfin') }}',
                                    type: 'GET',
                                    beforeSend: function() {
                                        Swal.fire({
                                            icon: 'warning',
                                            title: 'Actualizando',
                                            html: 'Los datos se estan actualizando...',
                                            timerProgressBar: true,
                                            showConfirmButton: false,
                                            allowOutsideClick: false,
                                            didOpen: () => {
                                                Swal.showLoading()
                                            },
                                        });
                                    },
                                    success: function(res) {
                                        console.log(res);
                                        if (res.estatus == true) {
                                            Swal.DismissReason.close;
                                            Swal.fire(
                                                'Alerta',
                                                res.registros +
                                                ' registros actualizados correctamente',
                                                'success'
                                            )
                                        }
                                    }
                                });
                            } else {
                                Swal.fire({
                                    title: 'Alerta',
                                    text: 'No se actualizaron los registros',
                                    icon: 'error',
                                })
                            }
                        })

                    } else {
                        Swal.DismissReason.close;
                        Toast.fire({
                            type: 'error',
                            html: '<p>No se pudieron insertar los registros.</p> <p>' +
                                res.mensaje + '</p>'
                        })
                    }
                }
            }).fail(function(jqXHR, textStatus, errorThrown) {
                if (jqXHR.status === 0) {
                    $mensaje = 'Not connect: Verify Network.';
                } else if (jqXHR.status == 404) {
                    $mensaje = 'Requested page not found [404]';
                } else if (jqXHR.status == 500) {
                    $mensaje = 'Internal Server Error [500].';
                } else if (textStatus === 'parsererror') {
                    $mensaje = 'Requested JSON parse failed.';
                } else if (textStatus === 'timeout') {
                    $mensaje = 'Time out error.';
                } else if (textStatus === 'abort') {
                    $mensaje = 'Ajax request aborted.';
                } else {
                    $mensaje = 'Uncaught Error: ' + jqXHR.responseText;
                }
                Swal.close()
                Swal.fire({
                    title: '¡Alerta!',
                    text: $mensaje,
                    // toast:true,
                    showConfirmButton: false,
                    showCloseButton: true,
                })
            });
        });

        $('#btnEliminar').on('click', function(event) {
            event.preventDefault();
            const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: 'btn btn-success',
                    cancelButton: 'btn btn-danger'
                },
                buttonsStyling: false
            })
            Swal.fire({
                title: 'Eliminar',
                text: '¿Desea eliminar los registros de la respuesta?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Si, Eliminar',
                cancelButtonText: 'Cancelar',
                allowOutsideClick: false
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        url: '{{ route('delete_origen') }}',
                        type: 'GET',
                        beforeSend: function() {
                            Swal.fire({
                                icon: 'warning',
                                title: 'Eliminar registros',
                                html: 'Los datos se estan eliminando de la tabla origen...',
                                timerProgressBar: true,
                                showConfirmButton: false,
                                allowOutsideClick: false,
                                didOpen: () => {
                                    Swal.showLoading()
                                },
                            });

                        },
                        success: function(res) {
                            if (res.estatus == true) {
                                Swal.DismissReason.close;
                                Swal.fire(
                                    'Alerta',
                                    res.registros +
                                    ' registros eliminados correctamente',
                                    'success'
                                )
                            } else {
                                Swal.close()
                                Swal.DismissReason.close;
                            }
                        }
                    })
                    .fail(function(jqXHR, textStatus, errorThrown) {
                        if (jqXHR.status === 0) {
                            $mensaje = 'Not connect: Verify Network.';
                        } else if (jqXHR.status == 404) {
                            $mensaje = 'Requested page not found [404]';
                        } else if (jqXHR.status == 500) {
                            $mensaje = 'Internal Server Error [500].';
                        } else if (textStatus === 'parsererror') {
                            $mensaje = 'Requested JSON parse failed.';
                        } else if (textStatus === 'timeout') {
                            $mensaje = 'Time out error.';
                        } else if (textStatus === 'abort') {
                            $mensaje = 'Ajax request aborted.';
                        } else {
                            $mensaje = 'Uncaught Error: ' + jqXHR.responseText;
                        }
                        Swal.close()
                        Swal.fire({
                            title: '¡Alerta!',
                            text: $mensaje,
                            // toast:true,
                            showConfirmButton: false,
                            showCloseButton: true,
                        })
                    })
                    .always(function(){
                        Swal.DismissReason.close;
                    });
                } else {
                    Swal.DismissReason.close;
                    Swal.fire({
                        title: 'Alerta',
                        text: 'No se realizaron cambios',
                        icon: 'error',
                    })
                }
            })
        });

        $('#btnErrores').on('click', function(event) {
            event.preventDefault();
            $.ajax({
                url: '{{ route('errores') }}',
                type: 'GET',
                beforeSend: function() {
                    Swal.fire({
                        title: 'Comprobando si existen errores...',
                        timerProgressBar: true,
                        showConfirmButton: false,
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading()
                        }
                    });
                },
                success: function(res) {
                    Swal.DismissReason.close;
                    if (res.estatus == true) {
                        Swal.fire({
                            title: 'Errores',
                            text: "Descargar Archivo",
                            icon: 'warning',
                            showCancelButton: false,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            confirmButtonText: 'Descargar',
                            timerProgressBar: true,
                            showConfirmButton: true,
                            showCloseButton: true
                        }).then((result) => {
                            if (result.value) {
                                window.location.href =
                                    '{{ route('download_errores') }}';
                            }
                        })
                    } else {
                        Swal.DismissReason.close;
                        Swal.fire(
                            'No se encontraron errores',
                            '',
                            'error'
                        )
                    }
                }
            }).fail(function(jqXHR, textStatus, errorThrown) {
                if (jqXHR.status === 0) {
                    $mensaje = 'Not connect: Verify Network.';
                } else if (jqXHR.status == 404) {
                    $mensaje = 'Requested page not found [404]';
                } else if (jqXHR.status == 500) {
                    $mensaje = 'Internal Server Error [500].';
                } else if (textStatus === 'parsererror') {
                    $mensaje = 'Requested JSON parse failed.';
                } else if (textStatus === 'timeout') {
                    $mensaje = 'Time out error.';
                } else if (textStatus === 'abort') {
                    $mensaje = 'Ajax request aborted.';
                } else {
                    $mensaje = 'Uncaught Error: ' + jqXHR.responseText;
                }
                Swal.close()
                Swal.fire({
                    title: '¡Alerta!',
                    text: $mensaje,
                    // toast:true,
                    showConfirmButton: false,
                    showCloseButton: true,
                })
            });
        });


        // Solo pagados
        $('#btnInsertarPagados').on('click', function(event) {
            event.preventDefault();
            $.ajax({
                url: '{{ route('insert_serfin_pagados') }}',
                type: 'GET',
                beforeSend: function() {
                    Swal.fire({
                        icon: 'info',
                        title: 'Insertando',
                        text: 'Los datos se estan insertando...',
                        timerProgressBar: true,
                        showConfirmButton: false,
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading()
                        },
                    });
                },
                success: function(res) {
                    console.log(res);
                    if (res.estatus == true) {
                        Swal.DismissReason.close;
                        Swal.fire({
                            title: 'Actualizar solo pagados',
                            html: 'Se han insertado: ' + res.registros +
                                ' registros, <br/> ¿Desea actualizar los registros?',
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            confirmButtonText: 'Si, Actualizar',
                            cancelButtonText: 'Cancelar',
                            allowOutsideClick: false
                        }).then((result) => {
                            if (result.value) {
                                $.ajax({
                                    url: '{{ route('update_serfin_pagados') }}',
                                    type: 'GET',
                                    beforeSend: function() {
                                        Swal.fire({
                                            icon: 'info',
                                            title: 'Actualizando solo pagados',
                                            text: 'Los datos se estan actualizando...',
                                            timerProgressBar: true,
                                            showConfirmButton: false,
                                            allowOutsideClick: false,
                                            didOpen: () => {
                                                Swal.showLoading()
                                            },
                                        });

                                    },
                                    success: function(res) {
                                        console.log(res);
                                        if (res.estatus == true) {
                                            Swal.DismissReason.close;
                                            Swal.fire(
                                                'Alerta',
                                                res.registros +
                                                ' registros actualizados correctamente',
                                                'success'
                                            )
                                        }
                                    }
                                });
                            } else {
                                Swal.fire({
                                    title: 'Alerta',
                                    text: 'No se actualizaron los registros',
                                    icon: 'error',
                                })
                            }
                        })

                    } else {
                        Swal.DismissReason.close;
                        Toast.fire({
                            type: 'error',
                            html: '<p>No se pudieron insertar los registros.</p> <p>' +
                                res.mensaje + '</p>'
                        })
                    }
                }
            }).fail(function(jqXHR, textStatus, errorThrown) {
                if (jqXHR.status === 0) {
                    $mensaje = 'Not connect: Verify Network.';
                } else if (jqXHR.status == 404) {
                    $mensaje = 'Requested page not found [404]';
                } else if (jqXHR.status == 500) {
                    $mensaje = 'Internal Server Error [500].';
                } else if (textStatus === 'parsererror') {
                    $mensaje = 'Requested JSON parse failed.';
                } else if (textStatus === 'timeout') {
                    $mensaje = 'Time out error.';
                } else if (textStatus === 'abort') {
                    $mensaje = 'Ajax request aborted.';
                } else {
                    $mensaje = 'Uncaught Error: ' + jqXHR.responseText;
                }
                Swal.close()
                Swal.fire({
                    title: '¡Alerta!',
                    text: $mensaje,
                    // toast:true,
                    showConfirmButton: false,
                    showCloseButton: true,
                })
            });
        });

    });


    function response_day() {
        $.ajax({
            url: '{{ route('daily_response') }}',
            type: 'get',
            beforeSend: function() {
                Swal.fire({
                    icon: 'info',
                    title: 'Actualizando sistema',
                    html: 'No cierre ni actualice esta ventana hasta que termine de actualizar el sistema',
                    timerProgressBar: true,
                    showConfirmButton: false,
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading()
                    }
                });
            },
            success: function(res) {
                console.log(res);
                if (res.success == true) {
                    Swal.DismissReason.close;
                    $('#registros').html(res.registros);
                    Toast.fire({
                        icon: 'info',
                        title:  'Se han insertado ' + res.registros.mb + ' registros',
                    });

                } else {
                    Swal.DismissReason.close;
                    Swal.fire({
                      icon: 'error',
                      title: 'No se pudo procesar el archivo.',
                      showConfirmButton: true,
                    })
                }
            }
        })
        .fail(function(jqXHR, textStatus, errorThrown) {
            Swal.DismissReason.close;
            Swal.close()
            Swal.fire({
                icon: 'error',
                title: errorThrown,
                text: jqXHR.responseJSON.message,
                showConfirmButton: false,
                showCloseButton: true,
            })
        })
        .always(function(){
            Swal.DismissReason.close;
        }); 
    }

    function get_ingresos() {
        $.ajax({
            url: '{{ route('ingresos_del_dia') }}',
            type: 'GET',
            dataType: 'JSON',
            success:function(res){
                $('#ingresos').html('$' + res + 'MXN');
            }
        })
        .done(function() {
            console.log("success");
        })
        .fail(function() {
            console.log("error");
        })
        .always(function() {
            console.log("complete");
        });
        
    }
</script>
@stop
