@php
    $extensionesImagen = ['jpg', 'jpeg', 'png', 'gif'];
    $extensionesVideo = ['mp4', 'avi', 'mkv', 'mov'];
@endphp

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body collapse show">
                <h4 class="card-title">Testimonio</h4>
                <p class="card-text">
                    {{ $registro->testimonio }}
                </p>
            </div>
        </div>
    </div>
</div>
<div class="row image-popup-vertical-fit">
    @if ($registro->media_chistoso != null)      
    <div class="col-md">
        <div class="card">
            <h4 class="card-title">El mas chistoso</h4>
            <div class="el-card-item">
                <div class="el-card-avatar el-overlay-1">
                    @php
                        $archivo = $registro->media_chistoso;
                        $infoArchivo = pathinfo($archivo);
                        $extension = strtolower($infoArchivo['extension']);
                    @endphp
                    <a class="image-popup-vertical-fit" target="_blank" href="{{ env('FRONTEND_URL') . $registro->media_chistoso }}"> 
                        @if (in_array($extension, $extensionesImagen))
                            <img class="img-fluid" src="{{ env('FRONTEND_URL') . $registro->media_chistoso }}" alt="{{ $registro->media_chistoso }}" /> 
                        @elseif (in_array($extension, $extensionesVideo))
                            <video width="640" height="360" controls>
                                <source src="{{ env('FRONTEND_URL') . $registro->media_chistoso }}" type="video/mp4">
                            </video>
                        @else
                        <p>No se puede abrir el archivo</p>
                        @endif
                    </a>
                </div>
                <div class="el-card-content">
                    <p>
                        {{ $registro->media_chistoso }}
                    </p> 
                    <br/> 
                </div>
            </div>
        </div>
    </div>
    @endif
    @if ($registro->media_divertido != null)    
    <div class="col-md">
        <div class="card">
              <h4 class="card-title">El mas divertido</h4>
            <div class="el-card-item">
                <div class="el-card-avatar el-overlay-1">
                    @php
                        $archivo = $registro->media_divertido;
                        $infoArchivo = pathinfo($archivo);
                        $extension = strtolower($infoArchivo['extension']);
                    @endphp
                    <a class="image-popup-vertical-fit" target="_blank" href="{{ env('FRONTEND_URL') . $registro->media_divertido }}"> 
                        @if (in_array($extension, $extensionesImagen))
                            <img class="img-fluid" src="{{ env('FRONTEND_URL') . $registro->media_divertido }}" alt="{{ $registro->media_divertido }}" /> 
                        @elseif (in_array($extension, $extensionesVideo))
                            <video width="640" height="360" controls>
                                <source src="{{ env('FRONTEND_URL') . $registro->media_divertido }}" type="video/mp4">
                            </video>
                        @else
                        <p>No se puede abrir el archivo</p>
                        @endif
                    </a>
                </div>
                <div class="el-card-content">
                    <p>
                        {{  $registro->media_divertido }}
                    </p> 
                </div>
            </div>
        </div>
    </div>
    @endif
    
    @if ($registro->media_romantico != null)
    <div class="col-md">
        <div class="card">
              <h4 class="card-title">El mas romantico</h4>
            <div class="el-card-item">

                <div class="el-card-avatar el-overlay-1">
                    @php
                        $archivo = $registro->media_romantico;
                        $infoArchivo = pathinfo($archivo);
                        $extension = strtolower($infoArchivo['extension']);
                    @endphp
                    <a class="image-popup-vertical-fit" target="_blank" href="{{ env('FRONTEND_URL') . $registro->media_romantico }}"> 
                        @if (in_array($extension, $extensionesImagen))
                            <img class="img-fluid" src="{{ env('FRONTEND_URL') . $registro->media_romantico }}" alt="{{ $registro->media_romantico }}" /> 
                        @elseif (in_array($extension, $extensionesVideo))
                            <video width="640" height="360" controls>
                                <source src="{{ env('FRONTEND_URL') . $registro->media_romantico }}" type="video/mp4">
                            </video>
                        @else
                        <p>No se puede abrir el archivo</p>
                        @endif
                    </a>
                </div>
                
                <div class="el-card-content">
                    <p>
                        {{ $registro->media_romantico }}
                    </p> 
                </div>
            </div>
        </div>
    </div>
    @endif
</div>
<script>
 
    // $('.image-popup-vertical-fit').magnificPopup({
    //     type: 'image',
    //     callbacks: {
    //         close: function() {
    //             $('#modalMedia').modal('show')
    //         }
    //     }
    // });


    // $('.image-popup-vertical-fit').click(function () {
    //     $('#modalMedia').modal('hide')
    // });

</script>