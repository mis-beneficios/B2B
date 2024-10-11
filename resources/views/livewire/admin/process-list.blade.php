<div>
    <div class="card">
        {{-- <div class="card-header"> --}}
        
        {{-- </div> --}}
        <div class="card-body collapse show">
            <h4 class="card-title m-b-0">
                Procesos ejecutándose
            </h4>
            <div class="card-actions">
                
                <div class="controls">
                    <div class="input-group">
                        <select class="form-control" id="select_recargar" name="">
                            <option value="0">
                                Recargar automáticamente
                            </option>
                            <option value="1">
                                Tiempo Real
                            </option>
                            <option value="5" selected>
                                5s
                            </option>
                            <option value="10">
                                10s
                            </option>
                            <option value="15">
                                15s
                            </option>
                            <option value="20">
                                20s
                            </option>
                        </select>
    {{--                     <span class="input-group-btn">
                            <button class=" btn btn-danger btn-sm" id="btnCancelar" type="button">
                                <i class="fas fa-times">
                                </i>
                            </button>
                        </span>--}}
                        <span class="input-group-btn">
                            <button class="btn btn-sm btn-dark" id="recargar" type="button">
                                <i class="fas fa-sync-alt">
                                </i>
                            </button>
                        </span>  
                    </div>
                </div>
            </div>
           
            <div class="table-responsive">
                <form action="{{ route('settings.eliminar_procesos') }}" id="form_procesos" method="get">
                    <table class="table table-hover" id="table_procesos" style="width: 100%">
                        <thead >
                            <tr>
                                <th>
                                    SELECT
                                </th>
                                <th>
                                    ID
                                </th>
                                <th>
                                    USER
                                </th>
                                <th>
                                    HOST
                                </th>
                                <th>
                                    DB
                                </th>
                                <th>
                                    COMMAND
                                </th>
                                <th>
                                    TIME
                                </th>
                                <th>
                                    STATUS
                                </th>
                                <th>
                                    INFO
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($datos as $data)
                                <tr>
                                    <td></td>
                                    <td>{{ $data['Id'] }}</td>
                                    <td>{{ $data['User'] }}</td>
                                    <td>{{ $data['Host'] }}</td>
                                    <td>{{ $data['db'] }}</td>
                                    <td>{{ $data['Command'] }}</td>
                                    <td>{{ $data['Time'] }}</td>
                                    <td>{{ $data['State'] }}</td>
                                    <td>{{ $data['Info'] }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="mt-5">
                        <button class="btn btn-info btn-sm" type="submit">
                            Eliminar selección
                        </button>
                        <button class="btn btn-danger btn-sm" id="btnKill">
                            Eliminar todo
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    var intervalo = 0;
    // $('#select_recargar').val();
    if (repet == 5) {    
        //  var proccess = setInterval(function () {
        //     @this.call('render'); // Llama al método 'render' del componente Livewire para recargar los datos
        // }, 2000);
    }


    $('#select_recargar').change(function(event){
          event.preventDefault();
          var tiempo = $(this).val();
          clearInterval(intervalo);
          console.log(tiempo);
          if(tiempo != 0){
            intervalo = setInterval(function(){
                @this.call('render'); // Llama al método 'render' del componente Livewire para recargar los datos
            },(tiempo*1000));
          }else{
            clearInterval(intervalo);
            console.log('reload processlist cancel');
          }
    
    });
</script>