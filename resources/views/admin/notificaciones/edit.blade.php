@extends('layouts.admin.app')
@section('content')
<div class="row page-titles">
    <div class="col-md-5 col-8 align-self-center">
        <h3 class="text-themecolor">
            Editar notificación
        </h3>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('dashboard') }}">
                    Inicio
                </a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ route('notificaciones.index') }}">
                    Notificaciones
                </a>
            </li>
            <li class="breadcrumb-item">
                Editar
            </li>
            <li class="breadcrumb-item">
                {{ $notificacion->nombre }}
            </li>
        </ol>
    </div>
</div>
<form action="{{ route('notificaciones.update', $notificacion->id) }}" method="PUT" id="formNotificacion">
@csrf   
    <div class="row">
        <div class="col-lg-12 col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="card-actions">
                        <a href="{{ route('notificaciones.index') }}" type="button" class="btn btn-dark btn-sm text-white" data-dismiss="modal">
                            <i class="fas fa-arrow-left"></i>
                            Cancelar
                        </a>
                        <button type="submit" class="btn btn-primary btn-sm">
                            <i class="fas fa-save"></i>
                            Guardar
                        </button>
                    </div>
                    <h4 class="card-title m-b-0">
                        {{ __('Crear nueva notificación') }}
                    </h4>
                </div>
                <div class="card-body">
                    <div class="form-body">
                        <div class="row p-t-10">
                            <div class="col-lg-4 col-md-4">
                                <div class="form-group">
                                    <label class="control-label">
                                        Nombre
                                    </label>
                                    <input class="form-control" id="nombre" name="nombre" type="text" value="{{ isset($notificacion) ? $notificacion->nombre : ''}}">
                                    </input>
                                    <span class="text-danger error-nombre errors">
                                    </span>
                                </div>
                            </div>
                            <div class="col-lg-2 col-md-2">
                                <div class="form-group">
                                    <label class="control-label">
                                        Llave cache
                                    </label>
                                    <input class="form-control" id="key_cache" name="key_cache" type="text" {{ isset($notificacion) ? 'readonly' : '' }} value="{{ isset($notificacion) ? $notificacion->key_cache : '' }}">
                                    </input>
                                    <span class="text-danger error-key_cache errors">
                                    </span>
                                </div>
                            </div>
                            <div class="col-lg-2 col-md-2">
                                <div class="form-group has-success">
                                    <label class="control-label">
                                        Estatus
                                    </label>
                                    <select class="form-control select2 select2-hidden-accessible custom-select" id="estatus" name="estatus" style="width: 95%;">
                                        <option value="">
                                            Selecciona el estatus
                                        </option>
                                        <option value="0" {{ ($notificacion->estatus== 0) ? 'selected' : '' }}>Activo</option>
                                        <option value="1" {{ ($notificacion->estatus== 1) ? 'selected' : '' }}>Inactivo</option>
                                    </select>
                                    <br/>
                                    <span class="text-danger error-estatus errors">
                                    </span>
                                </div>
                            </div>
                            <div class="col-lg-2 col-md-2">
                                <div class="form-group">
                                    <label class="control-label">
                                        Activo hasta
                                    </label>
                                    <input class="form-control datepicker" id="activo_hasta" name="activo_hasta" type="text" value="{{ isset($notificacion) ? $notificacion->activo_hasta : '' }}">
                                    </input>
                                    <span class="text-danger error-activo_hasta errors">
                                    </span>
                                </div>
                            </div>
                            <div class="col-lg-12 col-md-12">
                                <div class="form-group has-success">
                                    <label class="control-label">
                                        Mostrar a
                                    </label>
                                     <select class="form-control custom-select select2 m-b-10 select2-multiple select2-hidden-accessible" id="show_role" multiple="" name="show_role[]" style="width: 95%;">
                                        <option value="all" {{ (in_array('all', explode(',', $notificacion->show_role))) ? 'selected' : '' }}>Todos</option>
                                        @foreach ($roles as $rol => $val)
                                        <option  value="{{ $rol }}" {{ (in_array($rol, explode(',', $notificacion->show_role))) ? 'selected' : '' }}>{{ $val }}</option>
                                        @endforeach
                                    </select>
                                    <br/>
                                    <span class="text-danger error-show_role errors">
                                    </span>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="col-lg col-md">
                                    <div class="form-group ">
                                        <label class="control-label">
                                            Cuerpo de notificación
                                        </label>
                                        <textarea autocomplete="off" class="form-control" id="cuerpo" name="cuerpo" rows="40">{!! isset($notificacion) ? $notificacion->cuerpo : '' !!}</textarea>
                                        <span class="text-danger error-cuerpo errors">
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection


@section('script')
<script>
    $(document).ready(function() {
        $('#cuerpo').summernote({
            height: 350,
            codemirror: {
                theme: 'monokai'
            }
        });
        $('#formNotificacion').submit(function(event) {
            event.preventDefault();
            $.ajax({
                url: $(this).attr('action'),
                type: $(this).attr('method'),
                dataType: 'JSON',
                data: $(this).serialize(),
                beforeSend:function(){
                    $('#overlay').css('display', 'block');
                }, 
                success:function(res){
                    $("#overlay").css("display", "none");
                    if (res.success==true) {
                        toastr['success']('¡Registro exitoso!');
                        window.location.href = res.url;
                    }else{
                        toastr['error']('¡Intentar mas tarde!')
                    }
                }
            })
            .fail(function(jqXHR, textStatus, errorThrown) {
                $("#overlay").css("display", "none");
                toastr['error'](errorThrown);
            })
            .always(function() {
                $('#overlay').css('display', 'none');
            });  
        });
    });
</script>
@endsection
