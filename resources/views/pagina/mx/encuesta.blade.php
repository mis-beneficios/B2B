@extends('layouts.pagina.app')
@section('content')
<section class="breadcrumb breadcrumb_bg" style="background-image: url(https://external-content.duckduckgo.com/iu/?u=https%3A%2F%2Fi.pinimg.com%2Foriginals%2F69%2F5c%2F21%2F695c210a9dc69463aef15a9f07d8df7b.jpg&f=1&nofb=1)">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="breadcrumb_iner">
                    <div class="breadcrumb_iner_item text-center">
                        <h2>
                            ¡Gracias por participar en nuestra encuesta de satisfacción rápida!
                        </h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="hotel_list single_page_hotel_list mt-5">
    <div class="container">
        <div class="row justify-content-start">
            <div class="col-xl-12">
                <div class="section_tittle">
                    <h4 class="text-center">
                        El motivo de esta rápida encuesta es tener más contacto con usted y también saber si todo estuvo como lo esperaba en su estancia.
                    </h4>
                </div>
            </div>
        </div>
        <div class="row text-center justify-content-center mb-5">
            <div class="row">
                <form action="{{ route('encuestas.store') }}" id="formEncuesta" method="post">
                    @csrf
                    <input name="user_id" type="hidden" value="{{ $user->id }}"/>
                    <input name="user_hash" type="hidden" value="{{ $user->user_hash }}"/>
                    <input name="reservacion_id" type="hidden" value="{{ ($reservacion != false) ? $reservacion->id : null }}"/>

                    <div class="form-group">
                        <label for="">
                            1.- ¿Las distintas áreas le atendieron bien?
                        </label>
                        <br/>
                        <label class="c-input c-radio mr-5">
                            <input checked="" id="radio1" name="pregunta_1" type="radio" value="si">
                                <span class="c-indicator">
                                </span>
                                SI
                            </input>
                        </label>
                        <label class="c-input c-radio mr-5">
                            <input id="radio2" name="pregunta_1" type="radio" value="no">
                                <span class="c-indicator">
                                </span>
                                NO
                            </input>
                        </label>
                        <label for="inputAddress">
                            Comentarios
                        </label>
                        <textarea class="form-control" cols="50" id="" name="comentario_1" rows="2">
                        </textarea>
                          <span class="text-danger error-comentario_1 errors">
                                </span>
                    </div>
                    <div class="form-group">
                        <label for="">
                            2.- ¿Disfrutó del hotel asignado?
                        </label>
                        <br/>
                        <label class="c-input c-radio mr-5">
                            <input checked="" id="radio1" name="pregunta_2" type="radio" value="si">
                                <span class="c-indicator">
                                </span>
                                SI
                            </input>
                        </label>
                        <label class="c-input c-radio mr-5">
                            <input id="radio2" name="pregunta_2" type="radio" value="no">
                                <span class="c-indicator">
                                </span>
                                NO
                            </input>
                        </label>
                        <label for="inputAddress">
                            Comentarios
                        </label>
                        <textarea class="form-control" cols="50" id="" name="comentario_2" rows="2">
                        </textarea>
                          <span class="text-danger error-comentario_2 errors">
                                </span>
                    </div>
                    <div class="form-group">
                        <label for="">
                            3.- ¿Recomendaría nuestros servicios?
                        </label>
                        <br/>
                        <label class="c-input c-radio mr-5">
                            <input checked="" id="radio1" name="pregunta_3" type="radio" value="si">
                                <span class="c-indicator">
                                </span>
                                SI
                            </input>
                        </label>
                        <label class="c-input c-radio mr-5">
                            <input id="radio2" name="pregunta_3" type="radio" value="no">
                                <span class="c-indicator">
                                </span>
                                NO
                            </input>
                        </label>
                        <label for="inputAddress">
                            Comentarios
                        </label>
                        <textarea class="form-control" cols="50" id="" name="comentario_3" rows="2">
                        </textarea>
                          <span class="text-danger error-comentario_3 errors">
                                </span>
                    </div>
                    <button class="btn btn-primary" id="submit" type="submit">
                        Enviar
                    </button>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection
@section('script')
<script>
    $(document).ready(function() {
        $('body').on('submit', '#formEncuesta', function(event) {
            event.preventDefault();
            $.ajax({
                url: $(this).attr('action'),
                type: 'POST',
                dataType: 'json',
                data: $(this).serialize(),
                beforeSend:function(){
                    $('#formEncuesta #submit').html('Enviando...');
                    $('#formEncuesta #submit').prop("disabled", true);
                },
                success:function(res){
                    if (res.success == true) {
                        alertify.alert('Gracias', 'Gracias por responder esta pequeña encuesta, seguiremos trabajando para mejorar nuestros servicios. <br/><br/> Equipo Mis Beneficios Vacacionales');
                        window.location.href = '/';
                    }
                }
            })
            .always(function() {
                $('#formEncuesta #submit').html('Enviar');
                $('#formEncuesta #submit').prop("disabled", false);
            });
            
        });
    });
</script>
@endsection
