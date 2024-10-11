@extends('layouts.admin.app')
@section('content')
<div class="row page-titles">
    <div class="col-md-5 col-8 align-self-center">
        <h3 class="text-themecolor">
            <a href="{{ route('campanas.index') }}">
                Campañas
            </a>
        </h3>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('dashboard') }}">
                    Home
                </a>
            </li>
            <li class="breadcrumb-item active">
                Campañas
            </li>
        </ol>
    </div>
</div>
<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="card">
            <div class="card-header">
                <div class="card-actions">
                    {{-- @if (Auth::user()->can('create', App\Tarjeta::class)) --}}
                    <button class="btn btn-info btn-xs" data-target="#modalCampana" data-toggle="modal" id="btnAddCampana">
                        <span>
                            <i class="fas fa-plus">
                            </i>
                            Agregar campaña
                        </span>
                    </button>
                    {{-- @endif --}}
                </div>
                <h4 class="card-title m-b-0">
                    Campañas activas
                </h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover dataTable" id="table_campanas" role="grid" style="width:100%">
                        <thead>
                            <tr role="row">
                                <th aria-sort="ascending" class="sorting_asc">
                                    ID
                                </th>
                                <th aria-controls="" aria-label="" aria-sort="ascending" class="sorting_asc" colspan="1" rowspan="1" tabindex="0">
                                    Convenio
                                </th>
                                <th aria-controls="" aria-label="" class="sorting" colspan="1" rowspan="1" tabindex="0">
                                    Fecha de inicio
                                </th>
                                <th aria-controls="" aria-label="" class="sorting" colspan="1" rowspan="1" tabindex="0">
                                    Fecha de fin
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal -->
<div aria-hidden="true" aria-labelledby="exampleModalLongTitle" class="modal fade" id="modalCampana" role="dialog" tabindex="-1">
    <div class="modal-dialog modal-dialog-scrollable|modal-dialog-centered modal-sm|modal-lg|modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">
                    Agregar campañas
                </h5>
                <button aria-label="Close" class="close" data-dismiss="modal" type="button">
                    <span aria-hidden="true">
                        ×
                    </span>
                </button>
            </div>
            <form action="{{ route('campanas.store') }}" id="formCampana" method="post">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <label for="">
                                Convenios
                            </label>
                            <select class="form-control custom-select select2 m-b-10 select2-multiple select2-hidden-accessible" id="convenios_id" multiple="" name="convenio_id[]" style="width: 100%;">
                                @foreach ($all_convenios as $key => $convenio)
                                <option value="{{ $convenio }}">
                                    {{ $key }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row mt-5">
                        <div class="col-md-6">
                            <label for="">
                                Fecha de inicio
                            </label>
                            <input autocomplete="off" class="form-control datepicker" id="fecha_inicio" name="fecha_inicio" type="text"/>
                        </div>
                        <div class="col-md-6">
                            <label for="">
                                Fecha de finalizacion
                            </label>
                            <input autocomplete="off" class="form-control datepicker" id="fecha_fin" name="fecha_fin" type="text"/>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" data-dismiss="modal" type="button">
                        Cerrar
                    </button>
                    <button class="btn btn-primary" type="submit">
                        Guardar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection


@section('script')
<script>
    $(document).ready(function() {
        $('#convenio_id').select2({
            // Funcionamiento correcto dentro de modales 
            dropdownParent: $('#modalSorteo'),
            allowClear: true
        });



       $('.datepicker').bootstrapMaterialDatePicker({
            weekStart: 0,
            time: false,
            lang: 'es',
        });

        var tabla = $('#table_campanas').DataTable({
            'responsive': true,
            'searching': true,
            "processing": true,
            'lengthMenu': [[10, 50, -1], [10, 50, "Todo"]],
            'pageLength': 10,
            "order": [[ 0, "desc" ]],
            "aoColumns": [{
                "mData": "0"
                }, {
                "mData": "1"
                },{
                "mData": "2"
                }, {
                "mData": "3"
                }
            ],
            "ajax": {
                url: baseadmin + "get-campanas",
                type: "get",
                dataType: "json",
                error: function(e) {
                    toastr['error'](e.responseText)
                }
            },
        });

        $('#formCampana').on('submit', function(event) {
            event.preventDefault();
            $.ajax({
                url: $(this).attr('action'),
                type: $(this).attr('method'),
                dataType: 'json',
                data: $(this).serialize(),
                beforeSend:function(){
                    $("#overlay").css("display", "block");
                },
                success:function(res){
                    if (res.success == true) {
                        tabla.ajax.reload();
                        $('#modalCampana').modal('hide');
                        $('#formCampana').trigger('reset');
                        toastr['success']('Se han agregado '+ res.cont +' convenio(s) a campaña.')
                    }
                }
            })
            .always(function() {
                $("#overlay").css("display", "none");
            });
            
        });
    });
</script>
@endsection
