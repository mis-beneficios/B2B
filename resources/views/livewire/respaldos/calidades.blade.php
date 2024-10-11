<div>
    <div class="card" >
        <div class="card-header">
            Filtrar calidades
        </div>
        
        <div class="card-body text-dark">
            <div class="table-responsive">
                <table class="table table-hover">
                  <thead class="thead-dark|thead-light">
                    <tr>
                      <th scope="col">#</th>
                      <th scope="col">Folio</th>
                      <th scope="col">Nombre</th>
                      <th scope="col">Subido por</th>
                      <th scope="col">Cliente</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($respaldos as $respaldo)
                        <tr>
                            <td>{{ $respaldo->id }}</td>
                            <td>{{ $respaldo->model_id }}</td>
                            <td>{{ $respaldo->nombre }}</td>
                            <td>{{ $respaldo->user_id }}</td>
                            <td>{{ $respaldo->cliente_id }}</td>
                        </tr>
                    @endforeach
                  </tbody>
                </table>
            </div>
            <div>
                {{ $respaldos->links() }}
            </div>
        </div>
    </div>
</div>
