@extends('layouts.admin.app')
@section('content')
<div class="row page-titles">
    <div class="col-md-5 col-8 align-self-center">
        <h3 class="text-themecolor">
            <a href="{{ route('dashboard') }}">
                Dashboard
            </a>
        </h3>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('dashboard') }}">
                    Home
                </a>
            </li>
            <li class="breadcrumb-item active">
                Bancos
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
                    <button class="btn btn-info btn-xs" data-target="#modalBanco" data-toggle="modal" id="btnAddBanco">
                        <span>
                            <i class="fas fa-plus">
                            </i>
                            Agregar banco
                        </span>
                    </button>
                    {{-- @endif --}}
                </div>
                <h4 class="card-title m-b-0">
                    Bancos
                </h4>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover dataTable" id="table_bancos" role="grid" style="width:100%">
                                <thead>
                                    <tr role="row">
                                        <th aria-sort="ascending" class="sorting_asc">
                                            ID
                                        </th>
                                        <th aria-controls="" aria-label="" aria-sort="ascending" class="sorting_asc" colspan="1" rowspan="1" tabindex="0">
                                            Banco
                                        </th>
                                        <th aria-controls="" aria-label="" class="sorting" colspan="1" rowspan="1" tabindex="0">
                                            Clave
                                        </th>
                                        <th aria-controls="" aria-label="" class="sorting" colspan="1" rowspan="1" tabindex="0">
                                            Ignorar via serfin
                                        </th>
                                        <th aria-controls="" aria-label="" class="sorting" colspan="1" rowspan="1" tabindex="0">
                                            Pais
                                        </th>
                                        <th>
                                            Opciones
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
    </div>
</div>
<!-- Modal -->
<div aria-hidden="true" aria-labelledby="exampleModalLongTitle" class="modal fade" id="modalBanco" role="dialog" tabindex="-1">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">
                    Agregar banco
                </h5>
                <button aria-label="Close" class="close" data-dismiss="modal" type="button">
                    <span aria-hidden="true">
                        ×
                    </span>
                </button>
            </div>
            <form action="{{ route('bancos.store') }}" id="formBanco" method="post">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <label for="">
                                Nombre
                            </label>
                            <input class="form-control" id="title" name="title" type="text">
                            </input>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-md-6">
                            <label for="">
                                Clave
                            </label>
                            <input autocomplete="off" class="form-control" id="clave" maxlength="3" name="clave" type="text"/>
                        </div>
                        <div class="col-md-6">
                            <label for="">
                                Ignorar via serfin
                            </label>
                            {{--
                            <input autocomplete="off" class="form-control" id="ignorar_en_via_serfin" name="ignorar_en_via_serfin" type="text"/>
                            --}}
                            <div class="demo-radio-button form-inline">
                                <input checked="" id="radio_1" name="ignorar_en_via_serfin" type="radio" value="0"/>
                                <label for="radio_1">
                                    No
                                </label>
                                <input id="radio_2" name="ignorar_en_via_serfin" type="radio" value="1"/>
                                <label for="radio_2">
                                    Si
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label for="">
                                Pais
                            </label>
                            <select class="form-control" id="paise_id" name="paise_id">
                                @foreach ($paises as $pais)
                                <option value="{{ $pais->id }}">
                                    {{ $pais->title }}
                                </option>
                                @endforeach
                            </select>
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



        $('.datepicker').datepicker({
            dateFormat: "yy-mm-dd",
            startDate: '-1d',
            endDate: '+2m',
            autoclose:true,
            language: 'es'
        });

        var tabla = $('#table_bancos').DataTable({
            'responsive': true,
            'searching': true,
            "processing": true,
            'lengthMenu': [[10, 50, -1], [10, 50, "Todo"]],
            'pageLength': 10,
            // "order": [[ 0, "ASC" ]],
            "aoColumns": [{
                "mData": "0"
                }, {
                "mData": "1"
                },{
                "mData": "2"
                }, {
                "mData": "4"
                }, {
                "mData": "3"
                }, {
                "mData": "5"
                }
            ],
            "ajax": {
                url: baseadmin + "get-bancos",
                type: "get",
                dataType: "json",
                // beforeSend:function(){
                //     console.log('esperando');
                // },
                // success:function(){
                //     console.log('finalizo');
                // },
                error: function(e) {
                  console.log(e.responseText);
                }
            },
        });

        $('#formBanco').on('submit', function(event) {
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
                        $('#modalBanco').modal('hide');
                        $('#formBanco').trigger('reset');
                        toastr['success']('¡Registro exitoso!.')
                    }
                }
            })
            .always(function() {
                $("#overlay").css("display", "none");
            });
            
        });


        $('body').on('click', '#btnEdit', function(event) {
            event.preventDefault();
            var banco_id = $(this).data('id');
            var route = $(this).data('route');
            var route_update = $(this).data('route-update');
            $.ajax({
                url: route,
                type: 'GET',
                dataType: 'JSON',
                beforeSend:function(){
                     $("#overlay").css("display", "block");
                },
                success:function(res){
                    if (res.success == true) {
                        $('#formBanco').attr({
                            'action': route_update,
                            'method': 'PUT'
                        });
                        $('#title').val(res.banco.title);
                        $('#clave').val(res.banco.clave);
                        // $('#ignorar_en_via_serfin').val(res.banco.ignorar_en_via_serfin);
                        if (res.banco.ignorar_en_via_serfin == 0) {
                            $('#radio_1').removeAttr('checked');
                            $('#radio_2').removeAttr('checked');
                            $('#radio_1').attr('checked', true);
                        }else{
                            $('#radio_1').removeAttr('checked');
                            $('#radio_2').removeAttr('checked');
                            $('#radio_2').attr('checked', true);
                        }
                        $('#paise_id').val(res.banco.paise_id);
                        $('#modalBanco').modal('show');
                    }
                }
            })
            .fail(function() {
                toastr['error']('Ha ocurrido un error, inténtalo más tarde.');
            })
            .always(function() {
                 $("#overlay").css("display", "none");
            });
            
        });
    });
</script>
@endsection
