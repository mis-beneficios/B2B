@extends('layouts.pagina.app')
@section('content')
<section class="about_us mb-5">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <div class="about_img">
                    <img alt="#" class="img-thumbnail rounded" src="{{ asset('images/eu/logo.png') }}">
                    </img>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="about_text">
                    <h5>
                        Welcome
                    </h5>
                    <h2>
                        <strong class="text-capitalize">
                            {{ $contrato->cliente->fullName }}
                        </strong>
                    </h2>
                    <p>
                        {{__('messages.beneficio', ['empresa' => env('APP_NAME_USA')])}}
                    </p>
                    <p>
                        {{ __('messages.user.show.estancia') }}:
                        <strong>
                            {{$contrato->paquete}}
                        </strong>
                    </p>
                    <p>
                        {{ __('messages.user.show.folio') }}:
                        <strong>
                            {{$contrato->id}}
                        </strong>
                    </p>
                    <p>
                        {{ __('messages.validacion') }}:
                        <strong>
                            1 year
                        </strong>
                    </p>
                    <p>
                        {{ __('messages.cliente.precio') }}:
                        <strong>
                            ${{$contrato->precio_de_compra}} {{$contrato->estancia->divisa}}
                        </strong>
                    </p>
                    <div class="mt-3">
                        <button class="btn btn-primary btn-sm" data-target="#exampleModalLong" data-toggle="modal" type="button">
                            {{ __('messages.detalles') }}
                        </button>
                        <button class="btn btn-success btn-sm" id="btnContrato" type="button">
                            {{ __('messages.contrato') }}
                        </button>
                        <a class="btn btn-info btn-sm" href="{{ route('dashboard') }}" type="button">
                            {{-- Go to my dashboard --}}
                            {{ __('messages.ir_a_mi_panel') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Modal -->
<div aria-hidden="true" aria-labelledby="exampleModalLongTitle" class="modal fade" id="exampleModalLong" role="dialog" tabindex="-1">
    <div class="modal-dialog modal-dialog-scrollable|modal-dialog-centered modal-sm|modal-lg|modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">
                    Detalles
                </h5>
                <button aria-label="Close" class="close" data-dismiss="modal" type="button">
                    <span aria-hidden="true">
                        ×
                    </span>
                </button>
            </div>
            <div class="modal-body">
                <p>
                    Destinos:
                    <span>
                        {!!$contrato->estancia->descripcion!!}
                    </span>
                </p>
            </div>
            <div class="modal-footer">
                <button class="btn btn-light" data-dismiss="modal" type="button">
                    Cerrar
                </button>
            </div>
        </div>
    </div>
</div>
<div aria-hidden="true" aria-labelledby="exampleModalLongTitle" class="modal fade" id="modalContrato" role="dialog" tabindex="-1">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button aria-label="Close" class="close" data-dismiss="modal" type="button">
                    <span aria-hidden="true">
                        ×
                    </span>
                </button>
            </div>
            <div class="modal-body m-4" id="bodyContrato">
            </div>
            <div class="modal-footer">
                <button class="btn btn-light" data-dismiss="modal" type="button">
                    Close
                </button>
                <a class="btn btn-dark" href="{{ route('download_contrato', $contrato->id) }}" target="_blank" type="button">
                    Download
                </a>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
    $(document).ready(function() {
        $('#btnContrato').on('click',function(event){
            event.preventDefault();
            $.ajax({
                url: baseuri + 'show-contract/' +{{$contrato->id}},
                type: 'GET',
                dataType: 'json',
                beforeSend:function(){
                    $("#overlay").css("display", "block");
                },
                success:function(res){
                    $("#overlay").css("display", "none");
                    $('#bodyContrato').html(res);
                    $('#modalContrato').modal('show');
                }
            }).
            always(function(){
                $("#overlay").css("display", "none");
            });
        });
    });
</script>
@endsection
