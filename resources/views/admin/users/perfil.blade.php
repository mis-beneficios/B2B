@extends('layouts.admin.app')
@section('content')
<div class="row page-titles">
    <div class="col-md-5 col-8 align-self-center">
        <h3 class="text-themecolor">
            Mi perfil
        </h3>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('dashboard') }}">
                    Home
                </a>
            </li>
            <li class="breadcrumb-item active">
                Editar
            </li>
        </ol>
    </div>
</div>
<div class="row">
    <div class="col-lg-4 col-xlg-3 col-md-5">
       <div class="card ">
            <div class="card-body">
                <small class="text-muted">
                    {{ __('messages.user.show.nombre') }}:
                </small>
                <h6>
                    {{ $user->nombre }}
                </h6>
                <small class="text-muted">
                    {{ __('messages.user.show.apellidos') }}:
                </small>
                <h6>
                    {{ $user->apellidos }}
                </h6>
                <small class="text-muted">
                    {{ __('messages.user.show.username') }}:
                </small>
                <h6>
                    {{ $user->username }}
                </h6>
                @if (Auth::user()->role != 'sales')
                <small class="text-muted">
                    {{ __('messages.user.show.empresa') }}:
                </small>
                <h6>
                    {{ ($user->convenio) ? $user->convenio->empresa_nombre : 'N/A' }}
                </h6>
                <small class="text-muted">
                    {{ __('messages.user.show.convenio') }}:
                </small>
                <h6>
                    {{ ($user->convenio) ? $user->convenio->empresa_nombre : 'N/A' }}
                </h6>
                <small class="text-muted">
                    {{ __('messages.user.show.registrado_por') }}:
                </small>
                <h6>
                    {{ ($user->padre) ? $user->padre->title : 'S/R' }}
                </h6>
                <small class="text-muted">
                    {{ __('messages.user.show.rol') }}:
                </small>
                <h6>
                    {{ $user->role }}
                </h6>
                <small class="text-muted">
                    {{ __('messages.user.show.created_at') }}:
                </small>
                <h6>
                    {{ $user->created }}
                </h6>
                <small class="text-muted">
                    {{ __('messages.user.show.updated_at') }}:
                </small>
                <h6>
                    {{ $user->modified }}
                </h6>
                <small class="text-muted">
                    {{ __('messages.user.show.direccion') }}:
                </small>
                <h6>
                    {{ $user->direccion }}
                </h6>
                <small class="text-muted">
                    {{ __('messages.user.show.direccion_alt') }}:
                </small>
                <h6>
                    {{ $user->direccion2 }}
                </h6>
                <small class="text-muted">
                    {{ __('messages.user.show.cp') }}:
                </small>
                <h6>
                    {{ $user->codigo_postal }}
                </h6>
                <small class="text-muted">
                    {{ __('messages.user.show.ciudad') }}:
                </small>
                <h6>
                    {{ $user->ciudad }}
                </h6>
                <small class="text-muted">
                    {{ __('messages.user.show.pais') }}:
                </small>
                <h6>
                    {{ $user->pais }}
                </h6>
                <small class="text-muted">
                    {{ __('messages.user.show.telefono') }}:
                </small>
                <h6>
                    {{ $user->telefono }}
                </h6>
                <small class="text-muted">
                    {{ __('messages.user.show.telefono_casa') }}:
                </small>
                <h6>
                    {{ $user->telefono_casa }}
                </h6>
                <small class="text-muted">
                    {{ __('messages.user.show.telefono_oficina') }}:
                </small>
                <h6>
                    {{ $user->telefono_oficina }}
                </h6>
                <small class="text-muted">
                    {{ __('messages.user.show.fecha_nacimiento') }}:
                </small>
                <h6>
                    {{ $user->cumpleanos }}
                </h6>
                @endif
            </div>
        </div>
    </div>
    <!-- Column -->
    <!-- Column -->
    <div class="col-lg-8 col-xlg-9 col-md-7">
        <div class="card">
            <!-- Nav tabs -->
            <ul class="nav nav-tabs profile-tab" role="tablist">
                <li class="nav-item"> <a class="nav-link active" data-toggle="tab" href="#profile" role="tab" aria-expanded="false">Perfil</a> </li>
                <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#settings" role="tab">Inicios de sesión</a> </li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane active" id="profile" role="tabpanel" aria-expanded="false">
                    <div class="card-body">
                        <form action="{{ route('users.update_perfil', $user->id) }}" id="form_user" method="put">
                            @csrf
                            <div class="form-body">
                                <h3 class="card-title">
                                    Editar usuario
                                </h3>
                                <div class="row p-t-10">
                                    <div class="col-lg-3 col-md-4 col-sm-6">
                                        <div class="form-group">
                                            <label class="control-label">
                                                {{ __('messages.user.show.nombre') }}
                                            </label>
                                            <input class="form-control" id="nombre" name="nombre" type="text" value="{{ $user->nombre }}">
                                            </input>
                                            <span class="text-danger error-nombre errors">
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-md-4 col-sm-6">
                                        <div class="form-group ">
                                            <label class="control-label">
                                                {{ __('messages.user.show.apellidos') }}
                                            </label>
                                            <input class="form-control form-control" id="apellidos" name="apellidos" type="text" value="{{ $user->apellidos }}">
                                                <small class="form-control-feedback">
                                                </small>
                                            </input>
                                            <span class="text-danger error-apellidos errors">
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-md-4 col-sm-6">
                                        <div class="form-group">
                                            <label class="control-label">
                                                {{ __('messages.user.show.username') }}
                                            </label>
                                            <input class="form-control" id="username" name="username" placeholder="ejemplo@mail.com" type="mail" value="{{ $user->username }}">
                                                <small class="form-control-feedback">
                                                </small>
                                            </input>
                                            <span class="text-danger error-username errors">
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-md-4 col-sm-6">
                                        <div class="form-group ">
                                            <label class="control-label">
                                                {{ __('messages.login.contrasena') }}
                                            </label>
                                            <input class="form-control form-control" id="password" name="password" type="password">
                                                <small class="form-control-feedback">
                                                </small>
                                            </input>
                                            <span class="text-danger error-password errors">
                                            </span>
                                        </div>
                                    </div>
                                  
                                    <div class="col-lg-3 col-md-3 col-sm-6">
                                        <div class="form-group ">
                                            <label class="control-label">
                                                {{ __('messages.user.show.telefono') }}
                                            </label>
                                            <input class="form-control form-control" id="telefono" name="telefono" placeholder="01234567890" type="text" value="{{ $user->telefono }}">
                                                <small class="form-control-feedback">
                                                </small>
                                            </input>
                                            <span class="text-danger error-telefono errors">
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-md-3 col-sm-6">
                                        <div class="form-group ">
                                            <label class="control-label">
                                                {{ __('messages.user.show.telefono_casa') }}
                                            </label>
                                            <input class="form-control form-control" id="telefono_casa" name="telefono_casa" placeholder="01234567890" type="text" value="{{ $user->telefono_casa }}">
                                                <small class="form-control-feedback">
                                                </small>
                                            </input>
                                            <span class="text-danger error-telefono_casa errors">
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-md-3 col-sm-6">
                                        <div class="form-group ">
                                            <label class="control-label">
                                                {{ __('messages.user.show.telefono_oficina') }}
                                            </label>
                                            <input class="form-control form-control" id="telefono_oficina" name="telefono_oficina" placeholder="01234567890" type="text" value="{{ $user->telefono_oficina }}">
                                                <small class="form-control-feedback">
                                                </small>
                                            </input>
                                            <span class="text-danger error-telefono_oficina errors">
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-3 col-md-4 col-sm-6">
                                        <div class="form-group">
                                            <label class="control-label">
                                                {{ __('messages.user.show.fecha_nacimiento') }}
                                            </label>
                                            <input class="form-control" id="cumpleanos" name="cumpleanos" placeholder="yyyy-mm-dd" type="text" value="{{ $user->cumpleanos }}">
                                            </input>
                                            <span class="text-danger error-cumpleanos errors">
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-lg-2 col-md-4 col-sm-6">
                                        <div class="form-group">
                                            <label class="control-label">
                                                {{ __('messages.user.show.rfc') }}
                                            </label>
                                            <input class="form-control" id="rfc" name="rfc" placeholder="" type="text" value="{{ $user->rfc }}">
                                                <small class="form-control-feedback">
                                                </small>
                                            </input>
                                            <span class="text-danger error-rfc errors">
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-lg-2 col-md-3 col-sm-6">
                                        <div class="form-group ">
                                            <label class="control-label">
                                                {{ __('messages.user.show.no_empleado') }}
                                            </label>
                                            <input class="form-control form-control" id="no_empleado" name="no_empleado" type="text" value="{{ $user->no_empleado }}">
                                                <small class="form-control-feedback">
                                                </small>
                                            </input>
                                            <span class="text-danger error-no_empleado errors">
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-2 col-md-4 col-sm-6 form-group">
                                        <label for="cp">
                                            {{ __('messages.user.show.cp') }}
                                        </label>
                                        <input aria-describedby="codigo_postal" class="form-control" id="cp" name="cp" onkeyup="buscar_cp()" placeholder="12345" type="text" value="{{ $user->codigo_postal }}">
                                        </input>
                                        <span class="text-danger error-cp errors">
                                        </span>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="cp">
                                            {{ __('messages.user.show.estado') }}
                                        </label>
                                        <input class="form-control" id="estado" name="estado" placeholder="Estado" type="text" value="{{ $user->provincia }}"/>
                                        <span class="text-danger error-estado errors">
                                        </span>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="cp">
                                            {{ __('messages.user.show.estado') }}
                                        </label>
                                        <input class="form-control" id="delegacion" name="delegacion" placeholder="Delegación" type="text" value="{{ $user->ciudad }}"/>
                                        <span class="text-danger error-delegacion errors">
                                        </span>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="cp">
                                            Colonia
                                        </label>
                                        <select class="form-control" id="colonia" name="colonia">
                                            <option value="0">
                                                SELECCIONA TU COLONIA
                                            </option>
                                        </select>
                                        <span class="text-danger error-colonia errors">
                                        </span>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>
                                                Pais
                                            </label>
                                            <input class="form-control" id="pais" name="pais" type="text" value="{{ (env('APP_PAIS_ID') == 1) ? 'México' : 'United States' }}">
                                            </input>
                                            <span class="text-danger error-pais errors">
                                            </span>
                                        </div>
                                    </div>
                                    <!--/span-->
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>
                                                Dirección
                                            </label>
                                            <textarea class="form-control" cols="20" id="direccion" name="direccion" rows="4">{{ $user->direccion }}</textarea>
                                            <span class="text-danger error-direccion errors">
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>
                                                Información extra
                                            </label>
                                            <textarea class="form-control" cols="20" id="direccion2" name="direccion2" rows="4" value="">{{ $user->direccion2 }}</textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-actions my-auto">
                                <button class="btn btn-success" type="submit">
                                    <i class="fa fa-check">
                                    </i>
                                    Guardar
                                </button>
                               <a class="btn btn-inverse" href="{{ route('users.show', $user->id) }}" type="button">
                                    Cancelar
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="tab-pane" id="settings" role="tabpanel">
                    <div class="card-body">
                        @foreach ($inicios as $inicio)
                        <br>
                        <div class="row">
                            <div class="col-md-1">
                                <img src="https://simpleicon.com/wp-content/uploads/pc.svg" alt="" style="width:70%">
                            </div>
                            <div class="col-md">
                                <p>
                                    {!! ($inicio->descripcion != null) ? $inicio->descripcion : $inicio->caso !!}
                                </p>
                            </div>
                            <div class="col-md-2">
                                {{ $inicio->created }}
                                <br>
                                {{ $inicio->diffForhumans() }}
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Column -->
</div>
@endsection

@section('script')
<script>
    var cp_id = @json($user->cp_id);
    var cp = @json($user->codigo_postal);
    buscar_cp(cp);
    $('#cumpleanos').datepicker({
        format: 'yyyy-mm-dd',
        autoclose:true,
        language: 'es'
    });

    $('#form_user').submit(function(e){
        e.preventDefault();
        $.ajax({
            url: $(this).attr('action'),
            type: $(this).attr('method'),
            dataType: 'json',
            data: $(this).serialize(),
            beforeSend:function(){
                $("#overlay").css("display", "block");
            },
            success:function(res){
                if (res.success == true) {
                    $(this).trigger('reset');
                    Toast.fire({
                        icon: 'success',
                        title:'¡Registro exitoso!'
                    });
                    location.reload();

                }
                if (res.success == false) {
                    pintar_errores(res.errors);
                }
            }
        })
        .fail(function(jqXHR, textStatus, errorThrown) {
            toastr['error'](errorThrown);
            toastr['error'](jqXHR.responseJSON.message);
        })
        .always(function() {
            $("#overlay").css("display", "none");
        });

    });

    function buscar_cp(cp) {
        var cp = $("#cp").val();
        if (cp.length < 5) return 0;
        $.ajax({
            url: baseuri + 'cp/' + cp,
            type: 'GET',
            dataType: 'json',
            beforeSend:function(){
                // $('.preloader').css('display','block');
            },
            success: function(res) {
                console.log(res);
                $('#colonia').html('');
                $("#estado").val(res.info[0].id_estado);
                $("#delegacion").val(res.info[0].id_municipio);
                if (res.colonia.length > 0) {
                    for (var i = 0; i < res.colonia.length; i++) {
                        if (cp_id == res.colonia[i].id) {
                            $('#colonia').append('<option selected value=' + res.colonia[i].id + '>' + res.colonia[i]
                            .colonia + '</option>');
                        }else{
                            $('#colonia').append('<option value=' + res.colonia[i].id + '>' + res.colonia[i]
                            .colonia + '</option>');
                        }
                    }
                }
            }
        })
        .always(function() {
            // $('.preloader').css('display','none')
        });

    }
</script>
@endsection