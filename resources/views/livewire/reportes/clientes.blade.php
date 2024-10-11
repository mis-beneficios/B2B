<div>
    <div class="card-body">
        <h4 class="card-title">Clientes con contratos: {{ $estatus_con }}</h4>
        {{-- <h6 class="card-subtitle"></h6> --}}
        <div class="row m-t-10">
            @foreach ($contratos_estatus as $con)
                <div class="col-md-2 col-lg-2 col-xlg-2" style="cursor: pointer" wire:click="changeEstatus('{{ $con->estatus }}')">
                    <div class="card card-inverse card-info">
                        <div class="box text-center" style="background-color: {{ $con->color_estatus() }};">
                            <h1 class="font-light text-white">{{ $con->num_clientes }}</h1>
                            <h6 class="text-white">{{ $con->estatus }}</h6>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <hr>
        <h3 class="card-subtitle">Clientes con contratos en estatus: {{ $estatus_con }}</h3>
        <div class="table-responsive">
            <div wire:loading>
                Cargando datos...
            </div>
            <table id="demo-foo-addrow" class="table m-t-30 table-hover no-wrap contact-list footable-loaded footable" data-page-size="10">
                <thead>
                    <tr>
                        <th class="footable-sortable">ID #<span class="footable-sort-indicator"></span></th>
                        <th class="footable-sortable">Cliente<span class="footable-sort-indicator"></span></th>
                        <th class="footable-sortable">Paquete<span class="footable-sort-indicator"></span></th>
                        <th class="footable-sortable">Convenio<span class="footable-sort-indicator"></span></th>
                        <th class="footable-sortable">Estatus<span class="footable-sort-indicator"></span></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($contratos as $contrato)
                        <tr>
                            <td>
                                <a href="{{ ($contrato->cliente) ?  route('users.show', $contrato->cliente->id)  : 'javascript:void(0);alert("Sin accion para este registro")'}}" target="_blank">
                                    {{ $contrato->id }}
                                </a>
                            </td>

                            <td>
                                @if ($contrato->cliente)
                                <a href="{{ ($contrato->cliente) ?  route('users.show', $contrato->cliente->id)  : 'javascript:void(0);alert("Sin accion para este registro")'}}" target="_blank">
                                    {{ $contrato->cliente->fullName }}</td>
                                </a>
                                @else
                                S/R
                                @endif
                            <td>{{ $contrato->paquete }}</td>
                            <td>{{ $contrato->convenio->empresa_nombre }}</td>
                            <td>{{ $contrato->estatus }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div>
                {{ $contratos->links() }}
            </div>
            <div class="">
               Total: {{ $contratos->total() }}
            </div>
        </div>
    </div>
</div>  
@section('script')
    <script>
        document.addEventListener("livewire:load", function () {
            Livewire.hook('beforeDomUpdate', () => {
                window.livewirePage = @this.page;
            });

            Livewire.hook('afterDomUpdate', () => {
                if (window.livewirePage !== undefined && window.livewirePage != 1) {
                    @this.gotoPage(1);
                }
            });
        });
    </script>
@endsection