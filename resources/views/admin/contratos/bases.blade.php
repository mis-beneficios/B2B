@extends('layouts.admin.app')
@section('content')
@livewireStyles
@livewireScripts
<div class="row page-titles">
    <div class="col-md-5 col-8 align-self-center">
        <h3 class="text-themecolor">
            <a href="{{ route('dashboard') }}">
                Dashboard
            </a>
        </h3>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('dashboard') }}">
                    Inicio
                </a>
            </li>
            <li class="breadcrumb-item active">
                Bases
            </li>
        </ol>
    </div>
</div>
{{-- @livewire('bases.index') --}}
<div class="row">
    <div class="col-md">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title m-b-0">
                    Filtrar bases
                </h4>
            </div>
            <div class="card-body">
                <form id="formBase">
                    <div class="form-row">
                        <div class="form-group col-lg-2 col-md-3">
                            <label for="fecha_inicio">
                                Fecha inicio
                            </label>
                            <input type="text" id="fecha_inicio" autocomplete="off" name="fecha_inicio"  class="form-control datepicker"/> 
                            @error('fecha_inicio') <small class="error text-danger">{{ $message }}</small> @enderror
                        </div>
                        <div class="form-group col-lg-2 col-md-3">
                            <label for="fecha_fin">
                                Fecha fin
                            </label>
                            <input type="text" id="fecha_fin" autocomplete="off" name="fecha_fin"  class="form-control datepicker"/>
                             @error('fecha_fin') <small class="error text-danger">{{ $message }}</small> @enderror
                        </div>

                        <div class="form-group col-lg-8 col-md-6" wire:ignore>
                            <label for="inputPassword4">
                                Estatus
                            </label>
                            <select class="form-control custom-select select2 m-b-10 select2-multiple select2-hidden-accessible" multiple="" name="estatus_contratos[]" id="estatus_contratos" style="width: 100%;">
                                <option value="all">Todos</option>
                                @foreach ($estatus_contratos as $contrato)
                                <option value="{{ $contrato->estatus }}">
                                    {{ $contrato->estatus }}
                                </option>
                                @endforeach
                            </select>
                             @error('estatus') <span class="error text-danger">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-12" wire:ignore>
                            <label for="inputPassword4">
                                Ejecutivos
                            </label>
                            <select class="form-control custom-select select2 m-b-10 select2-multiple select2-hidden-accessible" multiple="" id="ejecutivos_select" name="ejecutivos_select[]" style="width: 100%;">
                                <option value="all">Todos</option>
                                @foreach ($ejecutivos as $ejecutivo)
                                <option value="{{ $ejecutivo->username }}">
                                    {{ $ejecutivo->fullName .' '. $ejecutivo->username}}
                                </option>
                                @endforeach
                            </select>
                             @error('ejecutivos_select') <span class="error text-danger">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <button class="btn btn-dark btn-sm" id="btnDescargarBase" type="button">
                        <i class="fas fa-file-excel-o">
                        </i>
                        Descargar
                    </button>
                </form>
            </div>
        </div>
    </div>
    <div class="col-md-12">
        @livewire('comisiones.show-files', ['tipo' => 'base'])
    </div>
</div>
@endsection
@section('script')
<script>
    $(document).ready(function() {

        $('#btnDescargarBase').on('click', function(event) {
            var notificacion_id;
            event.preventDefault();
            let fecha_inicio        = $('#fecha_inicio').val();
            let fecha_fin           = $('#fecha_fin').val();
            let estatus_contratos   = $('#estatus_contratos').val();
            let ejecutivos_select   = $('#ejecutivos_select').val();

            console.log(fecha_inicio, fecha_fin, estatus_contratos, ejecutivos_select);

            if (fecha_inicio === '' || fecha_fin === '' || estatus_contratos === '' || ejecutivos_select === '') {
                toastr['warning']('Ingresa los datos solicitados')
            }else{     
                Swal.fire({
                    title: "¿Desea que se le notifique cuando el archivo este listo?",
                    showDenyButton: true,
                    showCancelButton: false,
                    confirmButtonText: "Si",
                    denyButtonText: "No"
                }).then((result) => {
                    if (result.isConfirmed) {
                        Swal.fire({
                            html: 'Ingresa tu numero de teléfono a 10 dígitos',
                            input: "text",
                            inputAttributes: {
                                autocapitalize: "off",
                                required: true,
                            },
                            cancelButtonText: "No",
                            showCancelButton: false,
                            confirmButtonText: "Generar",
                            showLoaderOnConfirm: true,
                            preConfirm: async (telefono) => {
                                return new Promise((resolve, reject) => {
                                    $.ajax({
                                        url: "{{ route('contratos.generarBase') }}",
                                        type: 'POST',
                                        dataType: 'json',
                                        data: {
                                            telefono: telefono,
                                            job_name: 'Filtrado de base',
                                            fecha_inicio: $('#fecha_inicio').val(),
                                            fecha_fin: $('#fecha_fin').val(),
                                            tipo: 'base',
                                            estatus_contratos: $('#estatus_contratos').val(),
                                            ejecutivos_select: $('#ejecutivos_select').val(),
                                        },
                                    })
                                    .done(function(res) {
                                        if (res.success == true && res.notificacion) {
                                            toastr['info']('Se te enviara un SMS al numero: ' + res.notificacion['numero'] +' cuando el archivo este listo.')
                                            resolve(res.notificacion['id']);
                                        } else {
                                            toastr['warning']('¡Error al intentar notificar!')
                                            reject();
                                        }
                                    })
                                    .fail(function(jqXHR, textStatus, errorThrown) {
                                        toastr['warning'](jqXHR.responseJSON.message);
                                        toastr['error'](textStatus);
                                        reject();
                                          Swal.close();
                                    })
                                    .always(function() {
                                          Swal.close();
                                    });
                                });
                            },
                            allowOutsideClick: () => !Swal.isLoading()
                        }).then((notificacion_id) => {
                            if (notificacion_id.isConfirmed) {
                                // exportBase(notificacion_id.value); 
                            }
                              Swal.close();
                        });
                    } else if (result.isDenied) {
                          Swal.close();
                        Swal.fire("Changes are not saved", "", "info");
                    }
                });
            }

        });

        // $('#btnDescargarBase').on('click', function(event) {
        //     event.preventDefault();
        //     let fecha_inicio        = $('#fecha_inicio').val();
        //     let fecha_fin           = $('#fecha_fin').val();
        //     let estatus_contratos   = $('#estatus_contratos').val();
        //     let ejecutivos_select   = $('#ejecutivos_select').val();

        //     console.log(fecha_inicio, fecha_fin, estatus_contratos, ejecutivos_select);

        //     if (fecha_inicio === '' || fecha_fin === '' || estatus_contratos === '' || ejecutivos_select === '') {
        //         toastr['warning']('Ingresa los datos solicitados')
        //         return 0;
        //     }



        //     Swal.fire({
        //         title: "¿Desea que se le notifique cuando el archivo este listo?",
        //         showDenyButton: true,
        //         showCancelButton: false,
        //         confirmButtonText: "Si",
        //         denyButtonText: "No"
        //     }).then((result) => {
        //         if (result.isConfirmed) {
        //             Swal.fire({
        //                 html: "Ingresa tu numero a 10 dígitos",
        //                 input: "text",
        //                 inputAttributes: {
        //                     autocapitalize: "off",
        //                     required:true,
        //                 },
        //                 // showCancelButton: true,
        //                 confirmButtonText: "Generar",
        //                 showLoaderOnConfirm: true,
        //                 preConfirm: async (telefono) => {
        //                     $.ajax({
        //                         url: "{{ route('contratos.generarBase') }}",
        //                         type: 'POST',
        //                         dataType: 'json',
        //                         data: {
        //                             telefono: telefono,
        //                             job_name: 'Filtrado de base',
        //                             fecha_inicio: $('#fecha_inicio').val(),
        //                             fecha_fin: $('#fecha_fin').val(),
        //                             tipo: 'base',
        //                             estatus_contratos: $('#estatus_contratos').val(),
        //                             ejecutivos_select: $('#ejecutivos_select').val(),
        //                         },
        //                     })
        //                     .done(function(res) {
        //                         if (res.success == true && res.notificacion) {
        //                             toastr['info']('Se te enviara un SMS al numero: ' + res.notificacion['numero'] +' cuando el archivo este listo.')
        //                             resolve(res.notificacion['id']);
        //                         } else {
        //                             toastr['warning']('¡Error al intentar notificar!')
        //                             reject();
        //                         }
        //                     })
        //                     .fail(function(jqXHR, textStatus, errorThrown) {
        //                         toastr['warning'](jqXHR.responseJSON.message);
        //                         toastr['error'](textStatus);
        //                         reject();
        //                           Swal.close();
        //                     })
        //                     .always(function() {
        //                           Swal.close();
        //                     });
        //                 },
        //                 allowOutsideClick: () => !Swal.isLoading()
        //             }).then((result) => {
        //               if (result.isConfirmed) {
        //                 Swal.fire({
        //                   title: result.value.telefono +' numero ',
        //                 });
        //               }
        //             });
        //         } else if (result.isDenied) {
        //             Swal.fire("Changes are not saved", "", "info");
        //         }
        //     });
        // });

    });

    function exportBase(notificacion_id) {
        $.ajax({
            url: baseadmin + "base-export/" + notificacion_id,
            type: 'GET',
            dataType: 'json',
            data: $('#formBase').serialize(),
            beforeSend:function(){
                $("#overlay").css("display", "block");
            },
            success:function(res){
                if (res.success == true) {
                    alertify.alert('¡Alerta!',res.message);
                    // window.location.href = res.url;
                }else{
                    toastr['error'](res.exceptions);
                    toastr['warning']('Intenta con menos ejecutivos')
                }
            }
        })
        .always(function() {
            $("#overlay").css("display", "none");
        });
    }
</script>
@endsection
