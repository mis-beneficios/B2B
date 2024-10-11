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
            Cargar archivo Serfin
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
                Cargar archivo
            </li>
        </ol>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <!-- Nav tabs -->
            <ul class="nav nav-tabs profile-tab" role="tablist">
                <li class="nav-item">
                    <a aria-expanded="true" class="nav-link active" data-toggle="tab" href="#subir_archivo" role="tab">
                        Subir archivo
                    </a>
                </li>
                <li class="nav-item">
                    <a aria-expanded="false" class="nav-link" data-toggle="tab" href="#archivo_cargado" role="tab">
                        Archivos cargados
                    </a>
                </li>
                <li class="nav-item">
                    <a aria-expanded="false" class="nav-link" data-toggle="tab" href="#validacion" role="tab">
                        Validaciones
                    </a>
                </li>
                <li class="nav-item">
                    <a aria-expanded="false" class="nav-link" data-toggle="tab" href="#devoluciones" role="tab">
                        Devoluciones
                    </a>
                </li>
                <li class="nav-item">
                    <a aria-expanded="false" class="nav-link" data-toggle="tab" href="#respuesta" role="tab">
                        Respuestas
                    </a>
                </li>
            </ul>


            <!-- Tab panes -->
            <div class="tab-content">
                <div aria-expanded="true" class="tab-pane active" id="subir_archivo" role="tabpanel">
                    <div class="card-body">
                        <form action="javascript:;" enctype="multipart/form-data" id="subir_archivo_form" method="POST" role="form">
                            <input id="token" name="_token" type="hidden" value="{{ csrf_token() }}"/>
                            <legend>
                                Subir archivo
                            </legend>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <input accept="application/vnd.ms-excel" class="form-control" id="file_excel" name="file_excel" placeholder="Archivo" type="file">
                                        </input>
                                        <br/>
                                        @error('file_excel')
                                        <div class="alert alert-danger">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <button class="btn btn-primary btn-sm" type="submit">
                                Enviar archivo
                            </button>
                        </form>
                    </div>
                </div>
                <!--second tab-->
                <div aria-expanded="false" class="tab-pane" id="archivo_cargado" role="tabpanel">
                    <div class="card-body">
                        @php
                        $files = Storage::disk('sftp')->files('Inbox')
                        @endphp
                        <div class="row text-center">
                            @foreach ($files as $f)
                            @if (substr($f, 13,8) == date('Ymd'))
                            <div class="card m-4" style="width: 18rem; text-align: center; align-items: center">
                                <div class="card-body">
                                    <i class="fas fa-file-text" style="font-size: 5em;"></i>
                                    <h5 class="card-title mt-3">
                                        {{ substr($f, 6) }}
                                    </h5>
                                    <br/>
                                    <a class="btn btn-outline-warning btn-sm" href="{{ route('download_sftp_inbox', substr($f, 6)) }}">
                                        <span class="fa fa-download">
                                        </span>
                                        Descargar
                                    </a>
                                </div>
                            </div>
                            @endif
                            @endforeach
                        </div>
                    </div>
                </div>
                <div aria-expanded="false" class="tab-pane" id="respuesta" role="tabpanel">
                    <div class="card-body">
                        @php
                        $files = Storage::disk('sftp')->allFiles('Outbox')
                        @endphp
                        <div class="row text-center">
                        @foreach ($files as $f)
                        @if (substr($f, 15,8) == date('Ymd') && preg_match("/[A-Z0-9]+C/", $f))
                        <div class="card m-4" style="width: 20rem; text-align: center; align-items: center">
                            <div class="card-body">
                                <i class="fas fa-file-text" style="font-size: 5em;"></i>
                                <h5 class="card-title mt-3">
                                    {{ substr($f, 7) }}
                                </h5>
                                <br/>
                                <a class="btn btn-outline-warning btn-sm" href="{{ route('downloadSFTP', substr($f, 7) ) }}">
                                    <i class="fas fa-text-width">
                                    </i>
                                    Descargar TXT
                                </a>
                                <br>
                                <br>
                                <a class="btn btn-outline-success btn-sm" href="{{ route('download_excel', substr($f, 7) ) }}">
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
                <div aria-expanded="false" class="tab-pane" id="validacion" role="tabpanel">
                    <div class="card-body">
                        @php
                        $files = Storage::disk('sftp')->allFiles('Outbox')
                        @endphp
                        <div class="row">
                        @php
                            $index = 1;
                        @endphp
                        @foreach ($files as $f)
                            @if (substr($f, 15,8) == date('Ymd') && preg_match("/[A-Z0-9]+V/", $f))
                            <div class="col-md-3">
                                <div class="card text-center">
                                    <div class="card-body">
                                        <h4 class="card-title"><i class="fas fa-file-text" style="font-size: 48px;"></i></h4>
                                        <p class="card-text">{{ substr($f, 7) }}</p>
                                        <a href="{{ route('downloadSFTP', substr($f, 7) ) }}" class="btn btn-outline-success btn-sm "><i class="fas fa-download"></i>
                                            Descargar
                                        </a>
                                        <a href="#" class="btn btn-outline-info  btn-sm " data-toggle="modal" data-target="#modal{{$index}}"><i class="fas fa-eye"></i>
                                            Ver
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <div aria-hidden="true" aria-labelledby="modal{{substr($f, 7)}}" class="modal fade" data-backdrop="static" id="modal{{$index}}" tabindex="-1">
                                <div class="modal-dialog modal-xl">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="modalAddContratoLabel">
                                                Validacion {{substr($f, 7)}}
                                            </h5>
                                            <button aria-label="Close" class="close" data-dismiss="modal" type="button">
                                                <span aria-hidden="true">
                                                    ×
                                                </span>
                                            </button>
                                        </div>
                                        <div class="p-3">
                                            <pre style="background-color:white">
                                                {!! nl2br(Storage::disk('sftp')->get('Outbox/'.substr($f, 7))) !!}
                                            </pre>
                                            {{-- <textarea name="" class="validacion" id="" cols="30" rows="10">{{ Storage::disk('sftp')->get('Outbox/'.substr($f, 7)) }}</textarea> --}}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @php
                                $index++;
                            @endphp
                            @endif
                        @endforeach
                        </div>
                    </div>
                </div>
                <div aria-expanded="false" class="tab-pane" id="devoluciones" role="tabpanel">
                    
                    <div class="card-body">
                        <h4 class="card-title">Hoy</h4>
                        @php
                        $files = Storage::disk('sftp')->allFiles('Outbox')
                        @endphp
                        <div class="row">
                        @php
                            $index = 1;
                        @endphp
                        @foreach ($files as $f)
                            @if (substr($f, 15,8) == date('Ymd') && preg_match("/[A-Z0-9]+D/", $f))
                            <div class="col-md-3">
                                <div class="card text-center">
                                    <div class="card-body">
                                        <h4 class="card-title"><i class="fas fa-file-text" style="font-size: 48px;"></i></h4>
                                        <p class="card-text">{{ substr($f, 7) }}</p>
                                        <a href="{{ route('downloadSFTP', substr($f, 7) ) }}" class="btn btn-outline-success btn-sm "><i class="fas fa-download"></i>
                                            Descargar
                                        </a>
                                        <a href="#" class="btn btn-outline-info  btn-sm " data-toggle="modal" data-target="#modal-dev{{$index}}"><i class="fas fa-eye"></i>
                                            Ver
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <div aria-hidden="true" aria-labelledby="modal-dev{{substr($f, 7)}}" class="modal fade" data-backdrop="static" id="modal-dev{{$index}}" tabindex="-1">
                                <div class="modal-dialog modal-xl">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="modalAddContratoLabel">
                                                Validacion {{substr($f, 7)}}
                                            </h5>
                                            <button aria-label="Close" class="close" data-dismiss="modal" type="button">
                                                <span aria-hidden="true">
                                                    ×
                                                </span>
                                            </button>
                                        </div>
                                        <div class="p-3">
                                            <pre style="background-color:white">
                                                {!!  nl2br(Storage::disk('sftp')->get('Outbox/'.substr($f, 7))) !!}
                                            </pre>
                                            {{-- <textarea name="" class="validacion" id="" cols="30" rows="10">{{ Storage::disk('sftp')->get('Outbox/'.substr($f, 7)) }}</textarea> --}}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @php
                                $index++;
                            @endphp
                            @endif
                        @endforeach       
                        </div>

                        <hr>
                         <h4 class="card-title">Anteriores</h4>
                        @php
                        $files_d = Storage::disk('sftp')->allFiles('Outbox')
                        @endphp
                        <div class="row">
                        @foreach ($files_d as $file)
                            @if (substr($file, 15,8) != date('Ymd') && preg_match("/[A-Z0-9]+D/", $file))
                            <div class="col-md-3">
                                <div class="card text-center">
                                    <div class="card-body">
                                        <h4 class="card-title"><i class="fas fa-file-text" style="font-size: 48px;"></i></h4>
                                        <p class="card-text">{{ substr($file, 7) }}</p>
                                        <a href="{{ route('downloadSFTP', substr($file, 7) ) }}" class="btn btn-outline-success btn-sm "><i class="fas fa-download"></i>
                                            Descargar
                                        </a>
                                        <a href="#" class="btn btn-outline-info  btn-sm " data-toggle="modal" data-target="#modal-dev{{$index}}"><i class="fas fa-eye"></i>
                                            Ver
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <div aria-hidden="true" aria-labelledby="modal-dev{{substr($file, 7)}}" class="modal fade" data-backdrop="static" id="modal-dev{{$index}}" tabindex="-1">
                                <div class="modal-dialog modal-xl">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="modalAddContratoLabel">
                                                Validacion {{substr($file, 7)}}
                                            </h5>
                                            <button aria-label="Close" class="close" data-dismiss="modal" type="button">
                                                <span aria-hidden="true">
                                                    ×
                                                </span>
                                            </button>
                                        </div>
                                        <div class="p-3">
                                            <pre style="background-color:white">
                                                {!!  nl2br(Storage::disk('sftp')->get('Outbox/'.substr($file, 7))) !!}
                                            </pre>
                                            {{-- <textarea name="" class="validacion" id="" cols="30" rows="10">{{ Storage::disk('sftp')->get('Outbox/'.substr($f, 7)) }}</textarea> --}}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @php
                                $index++;
                            @endphp
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script') 
<script>
    $(document).ready(function() {
        $('.validacion').summernote({
            height: 300,
        });

        $("#subir_archivo_form").bind("submit",function(event){
            event.preventDefault();
            var token = $("#token").val();
            var form = $("#subir_archivo_form");
            var data = new FormData(form[0]);

            $.ajax({
                url: '{{ route('cobranza.excel') }}',
                type:"POST",
                data:data,
                processData:false,
                contentType:false,
                cache:false,
                headers: {'X-CSRF-TOKEN': token},
                beforeSend:function(){
                    Swal.fire({
                        icon: 'info',
                        title: 'Creando archivo',
                        html: 'No cierre ni actualice esta ventana hasta que se cree y se cargue el archivo a serfin.',
                        timerProgressBar: true,
                        showConfirmButton: false,
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading()
                        }
                    });
                },
                success:function(res){
                    Swal.DismissReason.close;
                    if (res.estatus == true) {
                        Swal.fire(
                            '¡Hecho!',
                            'Se ha cargado un archivo con: '+res.registros+' registros',
                            'success'
                        );
                    }else{
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            html: 'No se pudo crear y cargar el archivo a serfin.',
                            showConfirmButton: true,
                            allowOutsideClick: false,
                        });
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
                    showConfirmButton: false,
                    showCloseButton: true,
                })
            });
        });


        // $('#subir_archivo_form').on('submit', function(event) {
        //     event.preventDefault();
        //     var formData = new FormData(document.getElementById("subir_archivo_form"));
        //     $.ajax({
        //         type:'POST',
        //         url: '{{ route('cobranza.excel') }}',
        //         data:formData,
        //         cache:false,
        //         contentType: false,
        //         processData: false,
        //         beforeSend:function(){
        //             $("#overlay").css("display", "block");
        //         },
        //         success:function(res){
        //             console.log(res);
        //             // if (res.success != true) {
        //             //     toastr['error']('¡Error al cargar imagen!');
        //             // }
        //             // toastr['success']('¡Se ha cargado la imagen correctamente!');
        //             // $(this).trigger('reset');
        //         }
        //     })
        //     .always(function() {
        //         $('#modalImagen').modal('hide');
        //         $("#overlay").css("display", "none");
        //     });
            
        // });  
    });
</script>
@stop
