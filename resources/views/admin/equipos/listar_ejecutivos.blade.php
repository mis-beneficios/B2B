<div class="modal-body">
	<div class="table-responsive">
		<table class="table table-hover table-stats datatable_sample" id="tableEjecutivos">
		  <thead>
		    <tr>
		      <th scope="col">#</th>
		      <th scope="col">Nombre</th>
		      <th scope="col">Correo</th>
		      <th scope="col">Rol</th>
		      <th>Opciones</th>
		    </tr>
		  </thead>
		  <tbody>
		   	@foreach ($usuarios as $u)
		   	<tr id="{{ $u->id }}">
		   		<td>
		   			{{$u->id}} <br>
		   			{{ ($u->admin_padre) ?  $u->admin_padre->id : 'N/A' }}</td>
		   		<td> {{ $u->fullName }} </td>
		   		<td> {{ $u->username }}</td>
		   		<td> {{ $u->perfil }}</td>
		   		<td>
		   			<button class="btn btn-dark btn-sm desvincularEjecutivo" data-url="{{ route('equipos.desvincular', $u->id) }}"><i class="fas fa-unlink"></i></button>
		   		</td>
		   	</tr>
		   	@endforeach
		  </tbody>
		</table>
	</div>
</div>
<div class="modal-footer">
    <button class="btn btn-secondary btn-sm" data-dismiss="modal" type="button">
        Cerrar
    </button>
</div>
