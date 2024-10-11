@extends('layouts.admin.app')
@section('content')
<style>
    .table_pagos thead{
        font-size: 12px;
    }
    .table_pagos tbody tr{
        font-size: .8em;
    }
    .dataTables_paginate{
        font-size: 12px;
    }
</style>
<div class="row page-titles">
    <div class="col-md-5 col-8 align-self-center">
        <h3 class="text-themecolor">
            Inicio
        </h3>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="javascript:void(0)">
                    Tarjetas
                </a>
            </li>
            <li class="breadcrumb-item active">
                Listar
            </li>
        </ol>
    </div>
</div>
<div class="row mt-4">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">
                    {{ __('messages.cliente.mis_tarjetas') }}
                    <div class="pull-right">
                        <button class="btn btn-info btn-sm" id="modal_add_card" type="button">
                            <i class="fa fa-plus">
                            </i>
                            {{ __('messages.cliente.agregar') }}
                        </button>
                    </div>
                </h4>
                <div class="table-responsive m-t-20">
                    <table class="table stylish-table" id="table_tarjetas" style="width: 100%;">
                        <thead>
                            <tr>
                                <th>
                                    #
                                </th>
                                <th>
                                    {{ __('messages.cliente.titular') }}
                                </th>
                                <th>
                                    {{ __('messages.cliente.numero') }}
                                </th>
                                <th>
                                    {{ __('messages.cliente.expiracion') }}
                                </th>
                                <th>
                                    {{ __('messages.cliente.banco') }}
                                </th>
                                <th>
                                    {{ __('messages.cliente.banca') }}
                                </th>
                                <th>
                                    {{ __('messages.cliente.tipo') }}
                                </th>
                                <th>
                                    {{ __('messages.cliente.estatus') }}
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
<!-- Button trigger modal -->
<!-- Modal -->
<div aria-hidden="true" aria-labelledby="exampleModalLongTitle" class="modal fade" id="modalCard" role="dialog" tabindex="-1">
    <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitle">
                    {{ __('messages.cliente.agregar_tarjeta') }}
                </h5>
                <button aria-label="Close" class="close" data-dismiss="modal" type="button">
                    <span aria-hidden="true">
                        ×
                    </span>
                </button>
            </div>
            <form action="{{ route('tarjetas.store') }}" id="form_card" method="post">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label for="titular">
                                {{ __('messages.cliente.titular') }}
                            </label>
                            <input aria-describedby="titular" class="form-control" id="titular" name="titular" placeholder="Titular" type="text" value="{{ Auth::user()->fullName }}">
                                <small class="form-text text-muted">
                                </small>
                            </input>
                            <span class="text-danger error-titular errors">
                            </span>
                        </div>
                        <div class="col-md-6 form-group">
                            <label for="numero_tarjeta">
                                {{ __('messages.cliente.numero') }}
                            </label>
                            <input aria-describedby="numero_tarjeta" class="form-control" data-placement="right" data-toggle="tooltip" id="numero_tarjeta" name="numero_tarjeta" placeholder="1111-2222-3333-4444" title="Tus datos estan cifrados de lado a lado" type="text">
                                <small class="form-text text-muted">
                                </small>
                            </input>
                            <span class="text-danger error-numero_tarjeta errors">
                            </span>
                        </div>
                        <div class="col-md-4 form-group">
                            <label for="red_bancaria">
                                {{ __('messages.cliente.banca') }}
                            </label>
                            <select class="form-control" id="red_bancaria" name="red_bancaria">
                                <option value="Master Card">
                                    Master Card
                                </option>
                                <option value="VISA">
                                    Visa
                                </option>
                            </select>
                            <span class="text-danger error-red_bancaria errors">
                            </span>
                        </div>
                        <div class="col-md-4 form-group">
                            <label for="email">
                                {{ __('messages.cliente.banco') }}
                            </label>
                            <select class="form-control js-example-responsive js-states" id="banco" name="banco_id">
                            </select>
                            <span class="text-danger error-banco errors">
                            </span>
                        </div>
                        <div class="col-md-4 form-group">
                            <label for="password">
                                {{ __('messages.cliente.tipo') }}
                            </label>
                            <select class="form-control" id="tipo" name="tipo">
                                <option value="Debito">
                                    {{ __('messages.cliente.debito') }}
                                </option>
                                <option value="Credito">
                                    {{ __('messages.cliente.credito') }}
                                </option>
                            </select>
                            <span class="text-danger error-tipo errors">
                            </span>
                        </div>
                        <div class="col-md-4 form-group">
                            <label for="confirmar_password">
                                {{ __('messages.cliente.expiracion') }}
                            </label>
                            <input class="form-control" id="vencimiento" name="vencimiento" placeholder="12/22" type="text">
                            </input>
                            <span class="text-danger error-vencimiento errors">
                            </span>
                        </div>
                        <div class="col-md-2 form-group">
                            <label for="confirmar_password">
                                {{ __('messages.cliente.cvv') }}
                            </label>
                            <input class="form-control" id="cvv" name="cvv" placeholder="123" type="password">
                            </input>
                            <span class="text-danger error-cvv errors">
                            </span>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" data-dismiss="modal" type="button">
                            {{ __('messages.cerrar') }}
                        </button>
                        <button class="btn btn-success" type="submit">
                            {{ __('messages.guardar') }}
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
    $(document).ready(function() {
        var element = document.getElementById('numero_tarjeta');
        var maskOptions = {
            mask: '0000-0000-0000-0000'
        };
        var mask = IMask(element, maskOptions);
        var element2 = document.getElementById('cvv');
        var maskOptions2 = {
            mask: '0000'
        };
        var mask = IMask(element2, maskOptions2);
        var element3 = document.getElementById('vencimiento');
        var maskOptions3 = {
            mask: '00/00'
        };
        var mask = IMask(element3, maskOptions3);
        var table =  $('#table_tarjetas').DataTable({
            // order: ([0, 'DESC']),
            lengthMenu: [[5, 10, 25, 50, -1], [5, 10, 25, 50, "Todo"]],
            pageLength: 5,
            searching:false,
            ajax: baseuri + "cliente/obtener-tarjetas",
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                {data: 'name', name: 'name'},
                {data: 'numero', name: 'numero'},
                {data: 'vencimiento', name: 'vencimiento'},
                {data: 'banco_id', name: 'banco_id'},
                {data: 'banco', name: 'banco'},
                {data: 'tipo', name: 'tipo'},
                {data: 'estatus', name: 'estatus'},
            ]
        });

        $('#modal_add_card').click(function(e){
            $('#form_card').trigger('reset');

            $.ajax({
                url: baseuri + 'cliente/obtener-bancos',
                type: 'GET',
                dataType: 'json',
                success: function(res) {
                    $.each(res, function(index, val) {
                        $('#banco').append('<option value="'+val.id+'">'+val.title+'</option>')
                    });
                }
            });
            // $('#banco').select2();
            $('#modalCard').modal('show');
        })

        $('#form_card').submit(function(e){
            e.preventDefault();
            $.ajax({
                url: $(this).attr('action'),
                type: $(this).attr('method'),
                dataType: 'json',
                data: $(this).serialize(),
                beforeSend: function() {
                    $(".preloader").css("display", "block");
                },
                success: function(res) {
                    if (res.success == false) {
                        if (res.message) {
                            toastr['warning'](res.message);    
                        }
                        pintar_errores(res.errors);
                    } else if (res.success == true) {
                        toastr['success']("{{ __('messages.alerta.success') }}");
                        table.ajax.reload();
                        $('#form_card').trigger('reset');
                        $('#modalCard').modal('hide');
                    } else {
                        alert('sin accion');
                    }
                }
            })
            .always(function() {
                $(".preloader").css("display", "none");
            });  
        })
    });
</script>
@endsection
