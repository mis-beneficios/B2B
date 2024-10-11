@extends('layouts.admin.app')
@section('content')
<style>
    #convenios_table_processing{
        color: red;
        font-size: 1.5em;
        align-items: center;
        align-content: center;
        left: 50%;
    }
</style>
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
                    Home
                </a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ route('convenios.index') }}">
                    Convenios
                </a>
            </li>
            <li class="breadcrumb-item">
                Editar
            </li>
            <li class="breadcrumb-item">
                {{ $convenio->empresa_nombre }}
            </li>
        </ol>
    </div>
</div>
<div class="row">
    <div class="col-lg-12 col-md-12" data-title="¡Hola!" data-intro="Te dare un recorrido por los nuevos cambios realizados a esta vista! ✅">
        <div class="card card-body row">
            <div class="col-12">
                <div class="d-flex flex-wrap">
                    <div class="ml-auto">
                        <ul class="list-inline">
                            <li data-intro="Volver a la pagina de informacion del convenio">
                                <a href="{{ route('convenios.show', $convenio->id) }}" class="btn btn-info btn-sm">
                                    <i class="fas fa-reply"></i>
                                    Volver al convenio
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <form action="{{ route('convenios.update', $convenio->id) }}" enctype="multipart/form-data" id="formUpdateConvenio" method="PUT">
                <div class="modal-body" id="modal-body">
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label for="empresa_nombre">
                                Empresa
                            </label>
                            <input class="form-control" id="empresa_nombre" name="empresa_nombre" placeholder="Nombre de la empresa" type="text">
                            </input>
                            <span class="text-danger error-empresa_nombre errors">
                            </span>
                        </div>
                        <div class="form-group col-md-3">
                            <label for="inputEmail4">
                                Llave
                            </label>
                            <input class="form-control" id="llave" name="llave" placeholder="Sitio web" @if (Auth::user()->role != 'admin')
                                readonly=""
                            @endif type="text">
                            </input>
                            <span class="text-danger error-llave errors">
                            </span>
                        </div>
                        <div class="form-group col-md-2">
                            <label for="inputEmail4">
                                Activo hasta
                            </label>
                            <input class="form-control datepicker" id="activo_hasta" name="activo_hasta" type="text">
                            </input>
                            <span class="text-danger error-activo_hasta errors">
                            </span>
                        </div>
                        <div class="form-group col-md-2">
                            <label for="inputEmail4">
                                Comision
                            </label>
                            <input class="form-control" id="comision_conveniador" name="comision_conveniador" type="text">
                            </input>
                            <span class="text-danger error-comision_conveniador errors">
                            </span>
                        </div>
                        <div class="col-md-2" data-intro="Convenio se encuentra activo">
               {{--              <div class="demo-checkbox">
                                <input type="checkbox" id="disponible" name="disponible" class="filled-in" value="1">
                                <label for="basic_checkbox_2">Activo</label>
                            </div>
 --}}
                            <label for="">
                                Disponible
                            </label>
                            <div class="switch">
                                <label>
                                    NO
                                    <input id="disponible" name="disponible" type="checkbox" value="1">
                                        <span class="lever">
                                        </span>
                                        SI
                                    </input>
                                </label>
                            </div>
                            <input type="hidden" name="val_disponible" id="val_disponible" value="{{ $convenio->disponible }}">
                        </div>
                        <div class="col-md-2">
                            <label for="">
                                Nomina
                            </label>
                            <div class="switch">
                                <label>
                                    NO
                                    <input id="nomina" name="nomina" type="checkbox">
                                        <span class="lever">
                                        </span>
                                        SI
                                    </input>
                                </label>
                            </div>
                              <input type="hidden" name="val_nomina" id="val_nomina" value="{{ $convenio->nomina }}">
                        </div>
                        <div class="col-md-2">
                            <label for="">
                                Convenio bancario
                            </label>
                            <div class="switch">
                                <label>
                                    NO
                                    <input id="convenio_bancario" name="convenio_bancario" type="checkbox">
                                        <span class="lever">
                                        </span>
                                        SI
                                    </input>
                                </label>
                            </div>
                            <input type="hidden" name="val_convenio_banc" id="val_convenio_banc" value="{{ $convenio->convenio_bancario }}">
                        </div>
                        <div class="form-group col-md-2">
                            <label for="inputEmail4">
                                Inicio de campaña
                            </label>
                            <input class="form-control datepicker" id="campana_inicio" name="campana_inicio" type="text">
                            </input>
                            <span class="text-danger error-campana_inicio errors">
                            </span>
                        </div>
                        <div class="form-group col-md-2">
                            <label for="inputEmail4">
                                Fin de campaña
                            </label>
                            <input class="form-control datepicker" id="campana_fin" name="campana_fin" type="text">
                            </input>
                            <span class="text-danger error-campana_fin errors">
                            </span>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label for="inputEmail4">
                                Portal de beneficios
                            </label>
                            <input class="form-control " id="url" name="url" type="text">
                            </input>
                            <span class="text-danger error-url errors">
                            </span>
                        </div>
                        <div class="form-group col-md-3">
                            <label for="inputEmail4">
                                Paquete de campaña
                            </label>
                            <input class="form-control " id="campana_paquetes" name="campana_paquetes" type="text">
                            </input>
                            <span class="text-danger error-campana_paquetes errors">
                            </span>
                        </div>
                        <div class="form-group col-md-1">
                            {{--
                            <label for="">
                                Logo
                            </label>
                            --}}
                            <br/>
                            <button class="btn btn-dark btn-sm mt-2 change_img logo" data-type="logo" type="button" data-intro="Cambiar el logo del convenio, el cual se vera reflejado en la pagina web en el apartado de logos parte superior de la pagina web">
                                Cambiar logo
                            </button>
                            {{--
                            <input class="form-control" id="logo" name="logo" type="file">
                            </input>
                            --}}
                            <span class="text-danger error-logo errors">
                            </span>
                        </div>
                        <div class="form-group col-md-2">
                            <br/>
                            <button class="btn btn-dark btn-sm mt-2 change_img img_bienvenida" data-type="img_bienvenida" type="button" data-intro="Cambiar la imagen de bienvenida del convenio, el cual se vera reflejado en la pagina web en el apartado de bienvenidas de la pagina web">
                                Cambiar imagen de bienvenida
                            </button>
                            <span class="text-danger error-img_bienvenida errors">
                            </span>
                        </div>
                        <div class="form-group col-md-2">
                            <br/>
                            <button class="btn btn-info btn-sm mt-2 change_img convenio_file" data-type="convenio_file" type="button" data-intro="Se carga el documento del convenio con la empresa seleccionada">
                                Cargar archivo de convenio
                            </button>
                            <span class="text-danger error-convenio_file errors">
                            </span>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label for="inputPassword4">
                                Bienvenida Convenio
                            </label>
                            <textarea class="form-control summer" id="bienvenida_convenio" name="bienvenida_convenio">
                            </textarea>
                            <span class="text-danger error-bienvenida_convenio errors">
                            </span>
                        </div>
                        <div class="form-group col-md-12">
                            <label for="inputPassword4">
                                Términos y condiciones
                            </label>
                            <textarea class="form-control summer" id="terminos_y_condiciones" name="terminos_y_condiciones">
                            </textarea>
                            <span class="text-danger error-terminos_y_condiciones errors">
                            </span>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary btn-sm" type="submit">
                        Guardar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<div aria-hidden="true" aria-labelledby="exampleModalLabel" class="modal fade" id="modalImagen" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">
                    Cargar imagen
                </h5>
                <button aria-label="Close" class="close" data-dismiss="modal" type="button">
                    <span aria-hidden="true">
                        ×
                    </span>
                </button>
            </div>
            <form action="{{ route('convenios.cargar_imagen') }}" id="chargeImage" method="POST">
                <input name="convenio_id" type="hidden" value="{{ $convenio->id }}"/>
                <div class="modal-body">
                    <div class="form-group col-md-12">
                        <label for="inputPassword4">
                            Cargar imagen
                        </label>
                        <input class="form-control" id="imagen_upload" name="" type="file"/>
                        <span class="text-danger error-imagen_upload errors">
                        </span>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary btn-sm" data-dismiss="modal" type="button">
                        Cerrar
                    </button>
                    <button class="btn btn-primary btn-sm" type="submit">
                        Cargar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
@section('script')

<script>
    // introJs().start();
    $(document).ready(function() {
        var convenio = @json($convenio);
        
        $.each(convenio, function(index, val) {
            $('#'+index).val(val);
        });

        $('.datepicker').datepicker({
            orientation: "bottom",
            format:'yyyy-mm-dd'
        });
        if (convenio.disponible == 1) {
            $('#disponible').attr('checked', true);
        }

        if (convenio.nomina == 1) {
            $('#nomina').attr('checked', true);
        }

        if (convenio.convenio_bancario == 1) {
            $('#convenio_bancario').attr('checked', true);
        }

        $('.summer').summernote({
            height: 350,
            codemirror: {
                theme: 'monokai'
            }
        });

        $('#disponible').on('change', function(event) {
            event.preventDefault();
            if ($(this).is(':checked')) {
                $('#val_disponible').val(1);
            }else{
                $('#val_disponible').val(0);
            }
        });


        $('#nomina').on('change', function(event) {
            event.preventDefault();
            if ($(this).is(':checked')) {
                $('#val_nomina').val(1);
            }else{
                $('#val_nomina').val(0);
            }
        });

        $('#convenio_bancario').on('change', function(event) {
            event.preventDefault();
            if ($(this).is(':checked')) {
                $('#val_convenio_banc').val(1);
            }else{
                $('#val_convenio_bancario').val(0);
            }
        });


        $('body').on('click', '.change_img', function(event) {
            event.preventDefault();
            var tipo = $(this).data('type');
            $('#chargeImage #imagen_upload').attr('name', tipo);
            $('#modalImagen').modal('show');
        });

        $('#formUpdateConvenio').on('submit', function(event) {
            event.preventDefault();
            $.ajax({
                url: $(this).attr('action'),
                type: $(this).attr('method'),
                dataType: 'json',
                data: $(this).serialize(),
                beforeSend:function(){
                    $("#overlay").css("display", "block");
                },
                success:function(res){
                    if (res.success != true) {
                        // toastr['error']('¡Error al actualizar datos! <br> Intentar mas tarde...');
                        pintar_errores(res.errors);
                    }else{
                        toastr['success']('¡Registro exitoso!');
                        window.location.href = res.url;
                    }
                }
            })
            .always(function() {
                $("#overlay").css("display", "none");
            });
            
        });

        $('#chargeImage').on('submit', function(event) {
            event.preventDefault();
            var formData = new FormData(this);
            $.ajax({
                type:'POST',
                url: "{{ route('convenios.cargar_imagen')}}",
                data:formData,
                cache:false,
                contentType: false,
                processData: false,
                beforeSend:function(){
                    $("#overlay").css("display", "block");
                },
                success:function(res){
                    if (res.success != true) {
                        toastr['error']('¡Error al cargar imagen!');
                    }
                    toastr['success']('¡Se ha cargado la imagen correctamente!');
                    $(this).trigger('reset');
                }
            })
            .always(function() {
                $('#modalImagen').modal('hide');
                $("#overlay").css("display", "none");
            });
            
        });             


    });
</script>

@endsection
