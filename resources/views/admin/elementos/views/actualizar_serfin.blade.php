@php
    $files = Storage::disk('sftp')->allFiles('Outbox');
    $flag = false;
@endphp

<div class="card">
    <div class="card-body little-profile text-center">
        <h3 class="m-b-0">Actualizar Serfin</h3>
        <p>
            @foreach ($files as $f)
            @if (substr($f, 15, 8) == date('Ymd') && preg_match('/[A-Z0-9]+C/', $f))
            @php
                $flag = true;
                $name = substr($f, 7);
            @endphp
                {{ substr($f, 7) }}    
            @endif
            @endforeach
        </p>      
        @if ((isset($flag) && $flag))
            @if ($panel['actualizacion'] == null)
            <a href="javascript:void(0)" class="m-t-10 waves-effect waves-dark btn btn-primary btn-md btn-rounded"  id="respuesta_diaria">
                Actualizar
            </a>
            @else
             <a href="{{ route('download_excel', $name) }}" class="m-t-10 waves-effect waves-dark btn btn-success btn-md btn-rounded"  id="download_excel">
                <i class="fas fa-file-excel-o"></i>
                Descargar respuesta</a>
            @endif
        @endif
        <div class="row text-center m-t-20">
            <div class="col-lg-3 col-md-3 m-t-20">
                <h3 class="m-b-0 font-light" id="registros">{{ $panel['actualizacion']['origen_pacific'] ?? '' }}</h3>
                <small>Registros</small>
            </div>
            <div class="col-lg-3 col-md-3 m-t-20">
                <h3 class="m-b-0 font-light" id="errores">{{ $panel['actualizacion']['errores_pacific'] ?? '' }}</h3>
                <small>Errores</small>
            </div>
            <div class="col-lg-3 col-md-3 m-t-20">
                <h3 class="m-b-0 font-light" id="insertados">{{ $panel['actualizacion']['srf_pacific'] ?? '' }}</h3>
                <small>Insertados</small>
            </div> 
            <div class="col-lg-3 col-md-3 m-t-20">
                <h3 class="m-b-0 font-light" id="actualizados">{{ $panel['actualizacion']['srf_pacific_update'] ?? '' }}</h3>
                <small>Actualizados</small>
            </div>
        </div>
    </div>
</div>

{{-- @section('script') --}}
<script>
    $(document).ready(function() {

        $(document).on('click', '.btnDownload', function(event) {
            event.preventDefault();
            var url = $(this).attr('href');
            console.log(url);
        });


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
                if (res.success == true) {
                    Swal.DismissReason.close;
                    $('#registros').html(res.registros);
                    Toast.fire({
                        icon: 'info',
                        title:  'Se han insertado ' + res.registros + ' registros',
                    });
                    get_errores();

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


    function get_errores() {
        $.ajax({
            url: '{{ route('errores') }}',
            type: 'GET',
            beforeSend: function() {
                Swal.fire({
                    icon: 'info',
                    title: 'Comprobando si existen errores.',
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
                if (res.estatus == true) {
                    Swal.DismissReason.close;
                    Toast.fire({
                        icon: 'info',
                        title: 'Descargando errores...'
                    })
                    window.location.href = '{{ route('download_errores') }}';
                    
                    $('#errores').html(res.registros)
                } else {
                    Swal.DismissReason.close;
                    Toast.fire({
                        icon: 'success',
                        title: 'No se encontraron errores...'
                    })
                }

                procesar_serfin();
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
                showConfirmButton: false,
                showCloseButton: true,
            })
        });
    }


    function procesar_serfin() {
        $.ajax({
            url: '{{ route('insert_serfin') }}',
            type: 'GET',
            beforeSend: function() {
                Swal.fire({
                    icon: 'warning',
                    title: 'Insertando',
                    html: 'Los datos se están insertando, espera...',
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
                    $('#insertados').html(res.registros);
                    Swal.DismissReason.close;
                    $.ajax({
                        url: '{{ route('update_serfin') }}',
                        type: 'GET',
                        beforeSend: function() {
                            Swal.fire({
                                icon: 'warning',
                                title: 'Actualizando',
                                html: 'Los datos se están actualizando, espera...',
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
                                
                                $('#actualizados').html(res.registros);
                                
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Se han actualizado '+ res.registros + ' registros exitosamente',
                                    html: 'No cierre ni actualice esta ventana hasta que termine de actualizar el sistema',
                                    timerProgressBar: true,
                                    showConfirmButton: false,
                                    allowOutsideClick: false,
                                    didOpen: () => {
                                        Swal.showLoading()
                                    }
                                })
                                eliminar_origen();
                            }
                        }
                    });

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
    }


    function eliminar_origen() {
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
                    // Swal.fire(
                    //     'Alerta',
                    //     res.registros +
                    //     ' registros eliminados correctamente',
                    //     'success'
                    // )

                    Swal.fire(
                      '¡Hecho!',
                      'Sistema actualizado exitosamente',
                      'success'
                    )

                    setTimeout(() => {
                        location.reload();
                    }, 5000);
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
    }
</script>
{{-- @stop --}}


{{-- <div class="card">
    <div class="card-body bg-info">
        <h4 class="text-white card-title">My Contacts</h4>
        <h6 class="card-subtitle text-white m-b-0 op-5">Checkout my contacts here</h6>
    </div>
    <div class="card-body">
        <div class="message-box contact-box">
            <h2 class="add-ct-btn"><button type="button" class="btn btn-circle btn-lg btn-success waves-effect waves-dark">+</button></h2>
            <div class="message-widget contact-widget">
                <!-- Message -->
                <a href="#">
                    <div class="user-img"> <img src="../assets/images/users/1.jpg" alt="user" class="img-circle"> <span class="profile-status online pull-right"></span> </div>
                    <div class="mail-contnet">
                        <h5>Pavan kumar</h5> <span class="mail-desc">info@wrappixel.com</span></div>
                </a>
                <!-- Message -->
                <a href="#">
                    <div class="user-img"> <img src="../assets/images/users/2.jpg" alt="user" class="img-circle"> <span class="profile-status busy pull-right"></span> </div>
                    <div class="mail-contnet">
                        <h5>Sonu Nigam</h5> <span class="mail-desc">pamela1987@gmail.com</span></div>
                </a>
                <!-- Message -->
                <a href="#">
                    <div class="user-img"> <span class="round">A</span> <span class="profile-status away pull-right"></span> </div>
                    <div class="mail-contnet">
                        <h5>Arijit Sinh</h5> <span class="mail-desc">cruise1298.fiplip@gmail.com</span></div>
                </a>
                <!-- Message -->
                <a href="#">
                    <div class="user-img"> <img src="../assets/images/users/4.jpg" alt="user" class="img-circle"> <span class="profile-status offline pull-right"></span> </div>
                    <div class="mail-contnet">
                        <h5>Pavan kumar</h5> <span class="mail-desc">kat@gmail.com</span></div>
                </a>
            </div>
        </div>
    </div>
</div>
 --}}