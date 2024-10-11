<div>
    <div class="card">
        <div class="card-header bg-success">
            <h4 class="text-white card-title">Cargar imagen de fondo</h4>
        </div>
        <div class="card-body">
            <form wire:submit.prevent="save" enctype="multipart/form-data">
                <div class="message-box contact-box">
                    <h2 class="add-ct-btn">
                        <button type="submit" class="btn btn-dark waves-effect waves-dark">
                            <i class="fas fa-save"></i> Cargar imagen
                        </button>
                    </h2>
                </div>
                <div class="row">  
                    <div class="col-md-4">
                        @if ($flag == true)
                            <img class="img-responsive" src="{{ $photo->temporaryUrl() }}">
                        @else
                            <img class="img-responsive" src="{{ asset($photo) }}">
                        @endif
                    </div>
                    <div class="col-md-8">  
                        <div class="form-group">
                            <label>Imagen de fondo</label>
                            <input type="file" class="form-control" wire:model="photo">
                            <div wire:loading wire:target="photo">
                                <p class="text-warning">Cargando...</p>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>  