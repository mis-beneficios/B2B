<div>
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">
                Numero de archivos encontrados {{$contador}}
            </h4>
            @if ($mostrar == true)
                <div class="row"> 
                    @foreach ($files as $file)
                    <div class="col-lg-3 col-md-4 col-sm-6">
                        <div class="card p-10 text-center">
                            <div class="el-card-item">
                                <div class="el-card-avatar mb-2">   
                                    <i class="fas fa-file-excel-o" style="font-size: 5em;"></i>
                                </div>
                                <div class="el-card-content">
                                    <p class="box-title">
                                        {{ $file['job_name'] }}
                                    </p> 
                                    <button wire:click="downloadExcel('{{$file['job_name']}}')" target="_blank" class="btn btn-block btn-sm btn-dark"><i class="fas fa-download"></i> Descargar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            @else
            <div class="text-center">
                <h3 class="text-danger">Sin archivos</h3>
            </div>
            @endif
        </div>
    </div>
</div>

<script>
    // Actualizar automáticamente cada 5 minutos (300,000 milisegundos)
    setInterval(function () {
        @this.call('render');
    }, 10000);
</script>