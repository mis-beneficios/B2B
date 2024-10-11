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

    select.custom-select{
        width: 95%;
    }
</style>
<div class="row page-titles">
    <div class="col-md-5 col-8 align-self-center">
        <h3 class="text-themecolor">
            Nuevo usuario
        </h3>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="javascript:void(0)">
                    Home
                </a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ route('users.show_clientes') }}">
                    User
                </a>
            </li>
            <li class="breadcrumb-item active">
                Registrar nuevo usuario
            </li>
        </ol>
    </div>
</div>
<div class="">
    <div class="row">
        <div class="col-lg-12 col-md-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('users.store') }}" id="form_user" method="post">
                        @csrf
                        <h3 class="card-title">
                            Registrar usuario
                        </h3>
                        <div class="form-body">
                            <div class="row p-t-10">
                                <div class="col-lg-3 col-md-4 col-sm-6">
                                    <div class="form-group">
                                        <label class="control-label">
                                            {{ __('messages.user.show.nombre') }}
                                        </label>
                                        <input class="form-control" id="nombre" name="nombre" placeholder="Nombre (s)" type="text">
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
                                        <input class="form-control form-control" id="apellidos" name="apellidos" placeholder="Apellidos" type="text">
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
                                        <input autocomplete="off" class="form-control" id="username" name="username" placeholder="ejemplo@mail.com" type="mail">
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
                                        <input autocomplete="off" class="form-control form-control" id="password" name="password" type="password">
                                            <small class="form-control-feedback">
                                            </small>
                                        </input>
                                        <span class="text-danger error-password errors">
                                        </span>
                                    </div>
                                </div>
                                @if (Auth::user()->role == 'admin')
                                <div class="col-lg-3 col-md-4 col-sm-6">
                                    <div class="form-group ">
                                        <label class="control-label">
                                            {{ __('messages.user.show.rol') }}
                                        </label>
                                        {{-- select2 select2-hidden-accessible custom-select --}}
                                        <select class="form-control select2 select2-hidden-accessible" id="role" name="role" style="width:100%; background-color: #fff;">
                                            <option value="">
                                                {{ __('messages.selecciona_opcion') }}
                                            </option>
                                            @foreach ($roles as $key => $value)
                                            <option value="{{ $key }}">
                                                {{ $value }}
                                            </option>
                                            @endforeach
                                        </select>
                                        <br/>
                                        <span class="text-danger error-role errors">
                                        </span>
                                    </div>
                                </div>
                                @endif
                                <div class="col-lg-3 col-md-3 col-sm-6">
                                    <div class="form-group ">
                                        <label class="control-label">
                                            {{ __('messages.user.show.telefono') }}
                                        </label>
                                        <input class="form-control form-control" id="telefono" name="telefono" placeholder="01234567890" type="text">
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
                                        <input class="form-control form-control" id="telefono_casa" name="telefono_casa" placeholder="01234567890" type="text">
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
                                        <input class="form-control form-control" id="telefono_oficina" name="telefono_oficina" placeholder="01234567890" type="text">
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
                                    <div class="form-group has-success">
                                        <label class="control-label">
                                            {{ __('messages.user.show.convenio') }}
                                        </label>
                                        {{-- select2 select2-hidden-accessible custom-select --}}
                                        <select class="form-control select2 select2-hidden-accessible" id="convenio_id" name="convenio_id" style="width:100%; background-color: #fff;">
                                            <option value="">
                                                Selecciona un convenio
                                            </option>
                                            @foreach ($all_convenios as $key => $convenio)
                                            <option value="{{ $convenio }}">
                                                {{ $key }}
                                            </option>
                                            @endforeach
                                        </select>
                                        <br/>
                                        <span class="text-danger error-convenio_id errors">
                                        </span>
                                    </div>
                                </div>
                                <!--/span-->
                                <div class="col-lg-3 col-md-4 col-sm-6">
                                    <div class="form-group">
                                        <label class="control-label">
                                            {{ __('messages.user.show.fecha_nacimiento') }}
                                        </label>
                                        <input autocomplete="off" class="form-control datepicker" data-provide="datepicker" id="cumpleanos" name="cumpleanos" placeholder="" type="text">
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
                                        <input class="form-control" id="rfc" name="rfc" placeholder="" type="text">
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
                                        <input class="form-control form-control" id="no_empleado" name="no_empleado" type="text">
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
                                    <input aria-describedby="codigo_postal" class="form-control" id="cp" name="cp" onkeyup="buscar_cp()" placeholder="12345" type="text" value="">
                                    </input>
                                    <span class="text-danger error-cp errors">
                                    </span>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="cp">
                                        {{ __('messages.user.show.ciudad') }}
                                    </label>
                                    <input class="form-control" id="estado" name="estado" placeholder="Estado" type="text" value=""/>
                                    <span class="text-danger error-estado errors">
                                    </span>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="cp">
                                        {{ __('messages.user.show.estado') }}
                                    </label>
                                    <input class="form-control" id="delegacion" name="delegacion" placeholder="Delegación" type="text" value=""/>
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
                                        {{--
                                        <select class="form-control" id="pais" name="pais">
                                            <option value="México">
                                                México
                                            </option>
                                            <option value="United States">
                                                United States
                                            </option>
                                            <option value="Colombia">
                                                Colombia
                                            </option>
                                        </select>
                                        --}}
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
                                        <textarea class="form-control" cols="20" id="direccion" name="direccion" placeholder="Dirección" rows="4">
                                        </textarea>
                                        <span class="text-danger error-direccion errors">
                                        </span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>
                                            Información extra
                                        </label>
                                        <textarea class="form-control" cols="20" id="direccion2" name="direccion2" placeholder="Información adicional" rows="4">
                                        </textarea>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>
                                            ¿Como se entero?
                                        </label>

                                        <select class="form-control select2 select2-hidden-accessible custom-select js-example-basic-single" id="como_se_entero" name="como_se_entero" style="width:100%; background-color: #fff;">
                                            <option value="">
                                                Como se entero
                                            </option>
                                            @foreach ($como_se_entero as $key => $value)
                                            <option value="{{ $key }}">
                                                {{ $value }}
                                            </option>
                                            @endforeach
                                        </select>
                                        <br/>
                                        <span class="text-danger error-como_se_entero errors">
                                        </span>
                                    </div>
                                </div>
                                <div class="col-md-3 mt-4 pt-2">
                                    <input checked="" class="ml-3" id="enviar_contrasena" name="enviar_contrasena" type="checkbox">
                                        <label for="enviar_contrasena">
                                            Enviar contraseña
                                        </label>
                                    </input>
                                </div>
                                <div class="col-md-3 mt-4 pt-2">
                                    <input id="activiar_usuario" name="activiar_usuario" type="checkbox">
                                        <label for="activiar_usuario">
                                            Activar usuario
                                        </label>
                                    </input>
                                </div>

                                <div class="col-md-3" id="divEquipo" style="display: none">
                                    <div class="form-group">
                                        <label>
                                            Equipo de venta
                                        </label>

                                        <select class="form-control select2 select2-hidden-accessible custom-select js-example-basic-single" id="salesgroup_id" name="salesgroup_id" style="width:100%; background-color: #fff;">
                                            <option value="">
                                                Selecciona un equipo
                                            </option>
                                           <option value="">Selecciona un equipo</option>
                                            @foreach ($equipos as $equipo)
                                                <option value="{{ $equipo->id }}">{{ $equipo->title }}</option>
                                            @endforeach
                                        </select>
                                        <br/>
                                        <span class="text-danger error-salesgroup_id errors">
                                        </span>
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
                            <a class="btn btn-inverse" href="{{ route('dashboard') }}" type="button">
                                Cancelar
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
<script>
    $(document).ready(function() {
        $('#cumpleanos').datepicker({
            dateFormat: "yy-mm-dd",
            autoclose:true,
            language: 'es'
        });

        $('#role').on('change', function(event) {
            event.preventDefault();
            if ($(this).val() == 'sales' || $(this).val() == 'supervisor') {
                $('#divEquipo').css('display', 'block');
            }else{
                $('#divEquipo').css('display', 'none');
            }
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

                        // setTimeout(function(){
                        window.location.href = res.url;
                        // }, 1500);
                    }
                    if (res.success == false) {
                        toastr['error']('Revisa los campos ingresados o faltantes...')
                        pintar_errores(res.errors);
                    }
                }
            })
            .always(function() {
                $("#overlay").css("display", "none");
            });

        });


        //Validar si el correo ingresado existe en la tabla alertas para definir el convenio al que pertenece
        $('#username').blur(function() {
            var email = $(this).val();
            $.ajax({
                url: baseadmin + 'validar-email/' + email,
                type: 'GET',
                dataType: 'json',
                // data: {username: email},
                success:function(res){
                    if (res.success === true) {
                        $('#convenio_id').val(res.convenio.id).trigger('change');
                        toastr['info']('Este registro pertenece al convenio: ' + res.convenio.empresa_nombre)
                    }
                }
            })
            .always(function() {
            });
            
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
            },
            success: function(res) {
                console.log(res);
                $('#colonia').html('');
                $("#estado").val(res.info[0].id_estado);
                $("#delegacion").val(res.info[0].id_municipio);
                if (res.colonia.length > 0) {
                    for (var i = 0; i < res.colonia.length; i++) {
                        $('#colonia').append('<option value=' + res.colonia[i].id + '>' + res.colonia[i]
                            .colonia + '</option>');
                    }
                }
            }
        })
        .always(function() {
        });

    }
</script>
@endsection
