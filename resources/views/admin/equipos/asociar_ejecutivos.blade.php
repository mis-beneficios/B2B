<form id="formEquipo">
	<input type="hidden" value="{{ $equipo->id }}" name="equipo_id" id="equipo_id"/>
    <div class="modal-body">
        <div class="row">
        	<div class="col-md-6">
        		<div class="col-md-12">
        			<div class="card table-responsive">
        				<div class="card-header">
			                <h4 class="card-title m-b-0">
			                	Supervisores
			                </h4>
			            </div>
        				<div class="card-body">
	        				<table class="table table-hover">
	        				  <tbody>
	        				    @foreach ($ejecutivos as $supervisor)
	        				    @if ($supervisor->role == 'supervisor')
	        				    	<tr>
	        				    		<td>
	        				    			{{ $supervisor->fullName }}
	        				    			<br>
	        				    			<small>
	        				    				{{ $supervisor->username }}
	        				    			</small>
	        				    		</td>
	        				    		<td>
	        				    			<button class="btn btn-dark btn-sm"><i class="fas fa-unlink"></i></button>
	        				    		</td>
	        				    	</tr>
	        				    @endif
	        				    @endforeach
	        				  </tbody>
	        				</table>
        				</div>
        			</div>
        		</div>
        		<div class="col-md-12">
        			<div class="card">
        				<div class="card-header">
			                <h4 class="card-title m-b-0">
			                	Ventas
			                </h4>
			            </div>
			            <div class="card-body">	
		        			<div class="table-responsive">
		        				<table class="table table-hover  table-bordered">
		        				  <tbody>
		        				    @foreach ($ejecutivos as $supervisor)
		        				    @if ($supervisor->role == 'sales')
		        				    	<tr>
		        				    		<td>
		        				    			{{ $supervisor->fullName }}
		        				    			<br>
		        				    			<small>
		        				    				{{ $supervisor->username }}
		        				    			</small>
		        				    		</td>
		        				    		<td>
		        				    			<button class="btn btn-dark btn-sm"><i class="fas fa-unlink"></i></button>
		        				    		</td>
		        				    	</tr>
		        				    @endif
		        				    @endforeach
		        				  </tbody>
		        				</table>
		        			</div>
			            </div>
        			</div>
        		</div>
        	</div>
        	<div class="col-md-6">
        		<div class="card">
					<div class="card-header">
					    <h4 class="card-title m-b-0">
					    	Sin asignar
					    </h4>
					</div>
					<div class="card-body">
						<form action="">
							<div class="form-group">
				        		<select name="ejecutivo[]" id="ejecutivo" multiple class="form-control" style="height: 400px">
				        			@foreach ($sin_asignar as $e)
				        				<option value="{{ $e->id }}"> 
				        					{{ $e->fullName . ' ('.  $e->username.')' }}
				        				</option>
				        			@endforeach
				        		</select>
							</div>

							<button type="submit" class="btn btn-sm btn-primary">Asociar</button>
						</form>
					</div>
        		</div>
        	</div>
        </div>

        {{-- <div class="form-row">
            <div class="form-group col-md-12">
              <label for="nombre">Nombre</label>
              <input type="text" class="form-control" required id="nombre" name="title" placeholder="Nombre del equipo">
            </div>
            <div class="form-group col-md-12">
              <label for="supervisor">Comision supervisor</label>
              <input type="text" class="form-control" id="supervisor" value="15.00">
            </div>
            <div class="form-group col-md-12">
                <label for="ejecutivo">Ejecutivo</label>
                <input type="text" class="form-control" id="ejecutivo" name="ejecutivo" value="100.00">
            </div>
        </div> --}}
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-dark btn-sm" data-dismiss="modal">Cerrar</button>
    </div>
</form>