<div>
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Contratos registrados por el ejecutivo <b>{{ $user->fullName }}</b></h4>
            <div id="editable-datatable_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="dataTables_length" id="editable-datatable_length">
                            <label>Ver 
                                <select wire:model="paginate" aria-controls="editable-datatable" class="form-control input-sm">
                                    <option value="10">10</option>
                                    <option value="25">25</option>
                                    <option value="50">50</option>
                                    <option value="100">100</option>
                                </select> registros
                            </label>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div id="editable-datatable_filter" class="dataTables_filter">
                           <button class="btn btn-sm btn-success" wire:click="downloadExcel">
                                <i class="fas fa-file-excel"></i>
                                Excel
                            </button>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-sm-12 table-responsive">
                            <table class="table table-hover" id="editable-datatable" style="cursor: pointer; width: 100%;" role="grid" aria-describedby="editable-datatable_info">
                                <thead>
                                    <tr role="row">
                                        <th >
                                            Cliente
                                        </th>
                                        <th >
                                            Correo electrónico
                                        </th>
                                        <th >
                                            Convenio
                                        </th>
                                        <th >
                                            Registrado
                                        </th>
                                        <th >
                                            Opciones
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($contratos as $contrato)
                                        <tr>
                                            <td>
                                                {{ $contrato->cliente->fullName }}
                                            </td>
                                            <td>
                                                {{ $contrato->cliente->username }}
                                            </td>
                                            <td>
                                                {{ $contrato->convenio->empresa_nombre }}
                                            </td>
                                            <td>
                                                {{ $contrato->diffForhumans() }}
                                                <br>
                                                {{ $contrato->created }}
                                            </td>
                                            <td>
                                                <a href="{{ route('users.show', $contrato->cliente->id) }}" class="btn btn-sm btn-info" target="_blank">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="col-md">
                            <div class=" ml-3">
                                Mostrando {{ $contratos->firstItem() }} a {{ $contratos->lastItem() }} de {{ $contratos->total() }} registros.
                            </div>
                        </div>  
                        <div class="col-md mr-4">
                            <div class="float-right">
                                
                                {{ $contratos->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
