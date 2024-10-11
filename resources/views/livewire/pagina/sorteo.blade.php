<div>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@700&display=swap" rel="stylesheet">
    <section class="breadcrumb breadcrumb_bg" style="background-image: url('https://content.r9cdn.net/rimg/dimg/f2/b1/89e06bf7-city-34713-16ed2f2c7f1.jpg?width=1366&height=768&xhint=1735&yhint=2084&crop=true');     height: 550px;">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb_iner">
                        <div class="breadcrumb_iner_item text-center">
                        @if (date('Y-m-d') >= $sorteo->fecha_inicio && date('Y-m-d') <= $sorteo->fecha_fin && $sorteo->flag == 0)
                            <h2 style="font-family: 'Dancing Script', cursive;">
                              GRAN SORTEO DE REYES 2024
                            </h2>
                        @else
                            <h2>
                                Este sorteo no se encuentra disponible.
                            </h2>
                        @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @if (date('Y-m-d') >= $sorteo->fecha_inicio && date('Y-m-d') <= $sorteo->fecha_fin && $sorteo->flag == 0)
        @if ($bandera == false)
        <section class="hotel_list single_page_hotel_list mt-5">
            <div class="container">
                <div class="row justify-content-start">
                    <div class="col-xl-12">
                        <div class="section_tittle">
                            <h2 class="text-center">
                                ¡Registrate, comparte tu experiencia y gana un viaje a CANCUN!
                            </h2>
                        </div>
                    </div>
                </div> 
                <div class="row mb-4" id="show_form" style="">
                    <div class="col-md-6">
                        <form wire:submit.prevent="save" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" value="{{ $_SERVER["REQUEST_URI"] }}" wire:model="url">
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="nombre">
                                        Nombre
                                    </label>
                                    <input class="form-control" id="nombre" wire:model="nombre" placeholder="Nombre (s)" type="text">
                                    </input>
                                    @error('nombre') <span class="error text-danger">{{ $message }}</span> @enderror
                                    <span class="text-danger error-nombre errors">
                                    </span>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="apellidos">
                                        Apellido (s)
                                    </label>
                                    <input class="form-control" id="apellidos" wire:model="apellidos" placeholder="Apellido (s)" type="text">
                                    </input>
                                      @error('apellidos') <span class="error text-danger">{{ $message }}</span> @enderror
                                    <span class="text-danger error-apellidos errors">
                                    </span>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="inputAddress">
                                        Correo electrónico
                                    </label>
                                    <input class="form-control" id="email" wire:model="email" placeholder="ejemplo@mail.com" type="mail">
                                    </input>
                                     @error('email') <span class="error text-danger">{{ $message }}</span> @enderror
                                    <span class="text-danger error-email errors">
                                    </span>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="telefono_celular">
                                        Teléfono
                                    </label>
                                    <input class="form-control" id="telefono_celular" wire:model="telefono_celular" placeholder="" type="text">
                                    </input>
                                     @error('telefono_celular') <span class="error text-danger">{{ $message }}</span> @enderror
                                    <span class="text-danger error-telefono_celular errors">
                                    </span>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="telefono_casa">
                                        Teléfono de oficina o casa
                                    </label>
                                    <input class="form-control" id="telefono_casa" wire:model="telefono_casa" type="text">
                                    </input>
                                     @error('telefono_casa') <span class="error text-danger">{{ $message }}</span> @enderror
                                    <span class="text-danger error-telefono_casa errors">
                                    </span>
                                </div>
                            </div>
                            <hr/>
                            <h2>¡Sube tu fotos o vídeos de las siguientes categorías y GANA!</h2>
                            {{--Sube dos fotos o un video o hasta 3 videos de tu viaje que dure minimo 30 segundos y represente la experiencia de tus vacaciones.--}}
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <label for="el_mas_chistoso">
                                        El mas chistoso
                                    </label>
                                    <input class="form-control" id="el_mas_chistoso" wire:model="el_mas_chistoso" type="file">
                                    </input>
                                     @error('el_mas_chistoso') <span class="error text-danger">{{ $message }}</span> @enderror
                                    <span class="text-danger error-el_mas_chistoso errors">
                                    </span>
                                </div>
                                <div class="form-group col-md-12">
                                    <label for="el_mas_divertido">
                                        El mas divertido
                                    </label>
                                    <input class="form-control" id="el_mas_divertido" wire:model="el_mas_divertido" type="file">
                                    </input>
                                     @error('el_mas_divertido') <span class="error text-danger">{{ $message }}</span> @enderror
                                    <span class="text-danger error-el_mas_divertido errors">
                                    </span>
                                </div>
                                <div class="form-group col-md-12">
                                    <label for="el_mas_romantico">
                                        El mas romántico
                                    </label>
                                    <input class="form-control" id="el_mas_romantico" wire:model="el_mas_romantico" type="file">
                                    </input>
                                     @error('el_mas_romantico') <span class="error text-danger">{{ $message }}</span> @enderror
                                    <span class="text-danger error-el_mas_romantico errors">
                                    </span>
                                </div>
                                <div class="form-group col-md-12">
                                    <label for="testimonio">
                                        Testimonio
                                    </label>
                                    <textarea class="form-control" id="testimonio" wire:model="testimonio" rows="3"></textarea>
                                     @error('testimonio') <span class="error text-danger">{{ $message }}</span> @enderror
                                    <span class="text-danger error-testimonio errors">
                                    </span>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="form-check">
                                    <input class="form-check-input" id="uso_multimedia" wire:model="uso_multimedia" type="checkbox" value="1">
                                        <label class="form-check-label" for="uso_multimedia">
                                            Acepto el uso de mis fotos y/o vídeos.
                                        </label>
                                    </input>
                                </div>  
                                @error('uso_multimedia') <span class="error text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="form-group form-check">
                                <input checked=""  class="form-check-input" id="publicidad_item" wire:model="publicidad" type="checkbox" value="1">
                                    <label class="form-check-label" for="publicidad_item">
                                        Recibir ofertas y noticias de
                                        <a href="http://beneficiosvacacionales.mx/" target="_blank">
                                            Beneficios Vacacionales
                                        </a>
                                    </label>
                                </input>
                                <span class="text-danger error-publicidad errors">
                                </span>
                            </div>
                            <div class="form-group mt-2">
                                <div wire:ignore>
                                    {!! NoCaptcha::renderJs() !!}
                                    {!! NoCaptcha::display(['data-callback' => 'onCallback']) !!}
                                </div>
                                 @error('recaptcha') <span class="error text-danger">{{ $message }}</span> @enderror
                            </div>
                            <button class="btn btn-primary" wire:loading.attr="disabled">
                                {{-- {{ $btn_message }} --}}
                                Enviar
                            </button>
                            <br>
                            <div class="alert alert-info mt-2" wire:loading wire:target="save">
                                <h3>
                                Enviando datos...    
                                </h3>
                            </div>
                        </form>
                    </div>
                    <div class="col-md-6">
                        <img alt="" class="img-fluid" src="{{ asset('images/sorteo_navidad.png') }}">
                        </img>
                    </div>
                </div>
                <div id="show_finish" style="display:none">
                    <div class="text-center">
                        <h1 class="text-center" style=" font-size: 48px;">
                            Beneficios Vacacionales agradece tu participación en nuestro sorteo
                        </h1>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <h2 class="lead mt-1 pt-1">
                            </h2>
                            <h3 style=" text-align: center; color: #00add8; margin-top: 40px;">
                                <strong>
                                    Recuerda conservar tu número de participante.
                                </strong>
                            </h3>
                            {{--
                            <h3 style=" text-align: center; color: #00add8; margin-top: 5px;">
                                <strong>
                                    de participante al sorteo de los viajes:
                                </strong>
                            </h3>
                            --}}
                            <p class="text-center" style="margin-top: 50px; font-size: 65px; color: #000; font-family: Righteous;">
                                N°
                                <strong id="num_folio">
                                </strong>
                            </p>
                        </div>
                        <div class="col-md-6 text-center">
                            <img alt="" src="{{ asset('images/trofeo.png') }}" style="height: 22em;">
                            </img>
                            <p class="mt-4">
                                <strong>
                                    El GANADOR se anunciará a través de la pagina
                                    <a href="https://www.beneficiosvacacionales.mx" style="color: #00add8;" target="_blank">
                                        <strong>
                                            www.beneficiosvacacionales.mx
                                        </strong>
                                    </a>
                                </strong>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        @else
            <div class="container mt-5">
                <div class="text-center">
                    <h1 class="text-center" style=" font-size: 48px;">
                        Beneficios Vacacionales agradece tu participación en nuestro sorteo
                    </h1>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <h2 class="lead mt-1 pt-1">
                        </h2>
                        <h3 style=" text-align: center; color: #00add8; margin-top: 40px;">
                            <strong>
                                Recuerda conservar tu número de participante.
                            </strong>
                        </h3>
                        {{--
                        <h3 style=" text-align: center; color: #00add8; margin-top: 5px;">
                            <strong>
                                de participante al sorteo de los viajes:
                            </strong>
                        </h3>
                        --}}
                        <p class="text-center" style="margin-top: 50px; font-size: 65px; color: #000; font-family: Righteous;">
                            N°
                            <strong id="num_folio">
                                {{ $folio }}
                            </strong>
                        </p>
                    </div>
                    <div class="col-md-6 text-center">
                        <img alt="" src="{{ asset('images/trofeo.png') }}" style="height: 22em;">
                        </img>
                        <p class="mt-4">
                            <strong>
                                El GANADOR se anunciará a través de la pagina
                                <a href="https://www.beneficiosvacacionales.mx" style="color: #00add8;" target="_blank">
                                    <strong>
                                        www.beneficiosvacacionales.mx
                                    </strong>
                                </a>
                            </strong>
                        </p>
                    </div>
                </div>
            </div>
        @endif
    @endif
</div>
@section('script')
<script>
    var onCallback = function(){
        @this.set('recaptcha', grecaptcha.getResponse());
    }
</script>
@endsection