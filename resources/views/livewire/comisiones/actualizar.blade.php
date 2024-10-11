<div>
    @if (session()->has('message'))
        <div class="alert alert-success">
            {{ session('message') }}
        </div>
    @endif
    <div class="row">
        <div class="col-lg-4 col-md-12">
            <div class="card">
                <div class="card-header bg-success">
                    <h4 class="text-white card-title">Cargar archivo</h4>
                </div>
                <div class="card-body">
                    <form wire:submit.prevent="procesarComisiones" enctype="multipart/form-data">
                        <div class="message-box contact-box">
                            <h2 class="add-ct-btn">
                                <button type="submit" class="btn btn-dark waves-effect waves-dark"  wire:loading.attr="disabled">
                                    <i class="fa fa-spin fa-refresh"></i> Actualizar
                                </button>
                            </h2>
                        </div>
                        <div class="row">  
                            <div class="col-md-12">  
                                <div class="form-group">
                                    <label>Comisiones finiquitadas</label>
                                    <input type="file" class="form-control" wire:model="archivo_comisiones">
                                    <div wire:loading wire:target="archivo_comisiones" >
                                        <p class="text-warning">Cargando...</p>
                                    </div>
                                     @error('archivo_comisiones') <b class="text text-danger">{{ $message }}</b> @enderror
                                </div>
                            </div>
                        </div>
                            <div class="alert alert-info w-100" wire:loading wire:target="procesarComisiones">
                                Espera, se están actualizando las comisiones...
                            </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-lg-8 col-md-12">
            <div class="card">
                <div class="card-body">
                    <h3 class="card-title">¿Como actualizar?</h3>
                    <p class="card-text">
                        Cargar el archivo excel con los datos indicados a continuación:
                    </p>
                    <ul>
                        <li>
                            1er columna: indicamos el folio del contrato el cual se actualizaran los registros
                        </li>
                        <li>
                            2da columna: indicamos el estatus de la comisión los cuales podrían ser unicamente:  <b>Pagable, Pagado, Pagada, Finiquitadas, Finiquitada, Rechazada, Rechazado, Pendiente</b>
                        </li>
                        <li>
                            3er columna: indicamos el archivo o descripción de donde fue actualizada la comisión
                        </li>
                        <li>
                            4ta columna: indicamos el tipo de registro a actualizar usar unicamente <b>Comision o Enganche</b>
                        </li>
                    </ul>
                    <button wire:click="downloadExcel" class="btn btn-success">Descargar archivo base de actualización de comisiones</button>
                </div>
            </div>
        </div>
    </div>
</div>  