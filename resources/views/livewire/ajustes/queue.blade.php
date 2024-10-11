<div>
    @if ($visible )
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">
                       <strong class="text-danger">
                           {{ $jobs->total() }}
                       </strong>  
                       {{ $title }}
                    </h4>
                 
                    <div class="table-responsive m-t-20">
                        <table class="table stylish-table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Queue</th>
                                    <th>Payload</th>
                                    <th>Intentos</th>
                                    <th>Reservado en</th>
                                    <th>Disponible</th>
                                    <th>Creado</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($jobs as $job) 
                                   <tr>
                                        <td>{{ $job->id }}</td>
                                        <td>{{ $job->queue }}</td>
                                        <td>{{ substr($job->payload, 0,150) }}...</td>
                                        <td>{{ $job->attempts }}</td>
                                        <td>{{ $job->reserved_at }}</td>
                                        <td>{{ Carbon\Carbon::createFromTimestamp($job->available_at)->format('Y-m-d H:i:s') }}</td>
                                        <td>{{ Carbon\Carbon::createFromTimestamp($job->created_at)->format('Y-m-d H:i:s') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="pagination text-center justify-content-center pagination-sm">
                            {{ $jobs->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>

{{-- @if ($visible == true) --}}
<script>
    // console.log(@json($visible));
    var que = setInterval(function () {
        @this.call('render'); // Llama al método 'render' del componente Livewire para recargar los datos
        // console.log('Recargando datos...');
    }, 5000);
    


    if (@json($visible) == false) {
        clearInterval(que);
    }    
    // }else{
    // }
</script>
{{-- @endif --}}