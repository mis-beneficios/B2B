@extends('layouts.admin.app')
@section('content')
<div class="row page-titles">
    <div class="col-md-12 col-8 align-self-center">
        <h3 class="text-themecolor">
            <a href="{{ route('estancias.index') }}">
                Estancias
            </a>
        </h3>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('dashboard') }}">
                    Dashboad
                </a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ route('estancias.index') }}">
                    Estancias
                </a>
            </li>
            <li class="breadcrumb-item">
                Crear
            </li>
        </ol>
    </div>
</div>
<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('estancias.store') }}" id="form_estancia" method="POST">
                    @csrf
                    <h3 class="card-title">
                        Crear estancia
                    </h3>
                    @include('admin.estancias.elementos.form')
                    <hr>
                    <div class="form-actions my-auto">
                        <button class="btn btn-success btn-sm" type="submit">
                            <i class="fa fa-check">
                            </i>
                            Guardar
                        </button>
                        <a class="btn btn-inverse btn-sm" href="{{ route('estancias.index') }}" type="button">
                            Cancelar
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


@endsection


@section('script')
<script>
    $(document).ready(function() {
        $('.custom-select').select2();
        
        $('#descripcion').summernote({
            height: 300,
        });

        $('#descripcion_formal').summernote({
            height: 350,
            codemirror: {
                theme: 'monokai'
            }
        });

        $('body').on('click', '#btnUpdateContrato', function(event) {
            event.preventDefault();
            $.ajax({
                url: url,
                type: 'PUT',
                dataType: 'json',
                data: {descripcion_formal: $('#descripcion_formal').val()},
                beforeSend:function(){
                     $("#overlay").css("display", "block");
                },
                success:function(res){
                    if (res.success == true) {
                        toastr['success']('¡Registro exitoso!');
                        $('#modalContrato').modal('hide')
                    }else{
                        toastr['error']('Intentar mas tarde!');
                    }
                }
            })
            .fail(function() {
                 $("#overlay").css("display", "none");
            })
            .always(function() {
                 $("#overlay").css("display", "none");
            });

        });

        $('#form_estancia').submit(function(e){
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
                        // Toast.fire({
                        //     icon: 'success',
                        //     title:'¡Registro exitoso!'
                        // });
                        toastr['success']('¡Registro exitoso!');

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
            .fail(function(jqXHR, textStatus, errorThrown) {
                toastr['error'](errorThrown);
                toastr['error'](jqXHR.responseJSON.message);
            })
            .always(function() {
                $("#overlay").css("display", "none");
            });

        });

    });
</script>
@endsection
