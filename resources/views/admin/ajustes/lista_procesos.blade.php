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
                    <span class="input-group-btn">
                        <button class=" btn btn-danger btn-sm" id="btnCancelar" type="button">
                            <i class="fas fa-times">
                            </i>
                        </button>
                    </span>
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
{{-- @section('script') --}}
<script>
    $(document).ready(function() {
    var intervalo = '';
    var tabla = $('#table_procesos').dataTable({
      buttons: [{
          text: 'Reload',
          action: function ( e, dt, node, config ) {
            dt.ajax.reload();
          }
      }],
      'responsive': true,
      "aoColumns": [{
        "mData": "1"
        }, {
        "mData": "2"
        },{
        "mData": "3"
        }, {
        "mData": "4"
        }, {
        "mData": "5"
        }, {
        "mData": "6"
        }, {
        "mData": "7"
        },{
        "mData": "8"
        },{
        "mData": "9"
        }
      ],
      "ajax": {
        url: baseadmin+'listar-procesos',
        type: "get",
        dataType: "json",
        error: function(e) {
          Toast.fire({
                icon: 'error',
                title: 'Error al cargar procesos',
            })
        }
      },
      searching: false,
      
      // "order": [ 0, 'desc' ],
      // "bDestroy": true
    }).DataTable();

    $('#select_recargar').change(function(event){
          event.preventDefault();
          var tiempo = $(this).val();
          clearInterval(intervalo);
          console.log(tiempo);
          if(tiempo != 0){
            intervalo = setInterval(function(){
              tabla.ajax.reload();
            },(tiempo*1000));
          }else
          {
            clearInterval(intervalo);
            console.log('reload processlist cancel');
          }
    
    });

    $('#btnCancelar').on('click', function(event){
      event.preventDefault();
      clearInterval(intervalo);
      console.log('reload processlist cancel');
    });

    $('#recargar').on('click', function(event){
      event.preventDefault();
      tabla.ajax.reload();
        Toast.fire({
            icon: 'info',
            title: 'Recargando datos...'
        });
    });
    $('#form_procesos').submit(function(event){
      event.preventDefault();
      $.ajax({
        type: $(this).attr('method'),
        url: $(this).attr('action'),
        data: $("#form_procesos").serialize(),
        dataType: 'json',
        // beforeSend:function(){
          
        // },
        success: function (res) {
          Swal.DismissReason.close;
          if(res.success == 'true'){
            tabla.ajax.reload();
          }else{
            Toast.fire({
                icon: 'error',
                title: 'No se pudo eliminar el proceso'
            });     
          }
        }
      });
    });

    $('#btnKill').on('click', function(event){
      event.preventDefault();
      $.ajax({
          type: 'GET',
          url: baseadmin + 'kill-procesos',
          dataType: 'json',
          success: function (res) {
            if(res.success == 'true'){
              tabla.ajax.reload();
            }
          }
          , error: function (e) {
            console.log("ERROR ", e);
            tabla.ajax.reload();
          }
      });
    });
  });
</script>
{{-- @endsection --}}
