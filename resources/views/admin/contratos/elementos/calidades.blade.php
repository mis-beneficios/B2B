{{-- <div class="row">
@foreach ($images as $imagen)
	<div class="col-md-4" id="elemento{{ $loop->index }}">
        <div class="card">
            <img class="card-img-top img-responsive" src="{{ Storage::disk($imagen->driver)->url($imagen->path) }}" alt="{{ $imagen->nombre }}">
            <div class="card-body">
                <h6 class="card-title">{{ $imagen->nombre }}</h6>
                <a href="{{ route('download_calidad', str_replace('/', ',', $imagen->path)) }}" target="_blank" class="btn btn-primary btn-sm" data-elemento="elemento{{ $loop->index }}"><i class="fas fa-download"></i> </a>
                <a  class="btn btn-danger btn-sm" id="btnEliminarCalidad" href="{{ route('delete_calidad', [str_replace('/', ',', $imagen->path), $imagen->id]) }}" data-nombre="{{ $imagen->nombre }}" value="{{ $imagen->id }}" data-elemento="elemento{{ $loop->index }}"><i class="fas fa-trash"></i></a>
            </div>
        </div>
    </div>
@endforeach
</div> --}}

<div class="card-columns el-element-overlay" id="el-element-overlay">
    @foreach ($images as $imagen)
    <div class="card">
        <div class="el-card-item">
            <div class="el-card-avatar el-overlay-1">
                <a class="image-popup-vertical-fit" href="{{ Storage::disk($imagen->driver)->url($imagen->path) }}"> 
                    <img src="{{ Storage::disk($imagen->driver)->url($imagen->path) }}" alt="{{ $imagen->nombre }}" /> 
                </a>
            </div>
            <div class="el-card-content">
                <p>
                    {{ $imagen->nombre }}
                </p> 
                <small>
                    
                <ul class="list-unstyled">
                    @if ($imagen->user)
                    <li>Cargado por: <a href="{{ route('users.show', $imagen->user->id) }}">{{ $imagen->user->fullName }}</a></li>
                    @endif
                    <li>
                        Cargado el: {{ $imagen->created_at }}
                    </li>
                </ul>
                </small>
                <small class="text-white">
                    <a href="{{ route('download_calidad', str_replace('/', ',', $imagen->path)) }}" target="_blank" class="btn btn-primary btn-sm" data-elemento="elemento{{ $loop->index }}"><i class="fas fa-download"></i> </a>
                    <a  class="btn btn-danger btn-sm" id="btnEliminarCalidad" href="{{ route('delete_calidad', [str_replace('/', ',', $imagen->path), $imagen->id]) }}" data-nombre="{{ $imagen->nombre }}" value="{{ $imagen->id }}" data-elemento="elemento{{ $loop->index }}"><i class="fas fa-trash"></i></a>
                </small>
                <br/> 
            </div>
        </div>
    </div>
    @endforeach
</div>

<script>
     // lightGallery(document.getElementById('el-element-overlay')); 
    $('.image-popup-vertical-fit').magnificPopup({
        type: 'image',
        callbacks: {
            close: function() {
                $('#modalVerCalidad').modal('show')
                // Agrega aquí tu lógica personalizada al cerrar el popup
            }
        }
        // other options
    });


    $('.image-popup-vertical-fit').click(function () {
        $('#modalVerCalidad').modal('hide')
    });

</script>