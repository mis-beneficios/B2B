@extends('layouts.pagina.app')
@section('content')
<section class="breadcrumb breadcrumb_bg" style="background-image: url(https://www.qhn.es/wp-media/2020/01/la-laguna-bacalar.jpg)">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="breadcrumb_iner">
                    <div class="breadcrumb_iner_item text-center">
                        <h2>
                            Sorteo exclusivo para colavoradores de
                            <strong>
                                {{ $convenio->empresa_nombre }}
                            </strong>
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
                    <h2 class="text-center">
                        ¡¡Participa y Gana!!
                    </h2>
                </div>
            </div>
        </div>
        <div class="row text-center justify-content-center">
            <div class="row">
            </div>
        </div>
    </div>
</section>
@endsection

@section('script')
<script>
    $('body').on('click', '#btnDetalles', function(event) {
        event.preventDefault();
        var id_estancia = $(this).attr('value');
        var titulo = $(this).data('titulo');
        console.log(id_estancia);
        $.ajax({
            url: baseuri + 'estancia-detalles/'+id_estancia,
            type: 'GET',
            dataType: 'json',
            beforeSend:function(){
                $("#overlay").css("display", "block");
            },
            success:function(res){
                $("#overlay").css("display", "none");
                console.log(res);
                if (res.success == true) {
                    $('#modalDetalles #estancia_titulo').html('Detalles: '+ titulo);
                    $('#modalDetalles #modal_content').html(res.estancia.descripcion);
                    $('#modalDetalles').modal('show');
                }
            },
        });
        
        
    });
</script>
@endsection
