@extends('layouts.admin.app')
@section('content')
<style>
    button > .infoPago{
        display: none;
    }

    #btnPago:hover{
        /*background-color: red;*/
    }

    #btnPago:hover  > .infoPago{
        display: block;
    }
</style>
<div class="row page-titles">
    <div class="col-md-5 col-8 align-self-center">
        <h3 class="text-themecolor text-capitalize">
            Exportar contratos
        </h3>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('dashboard') }}">
                    Home
                </a>
            </li>
            <li class="breadcrumb-item active">
                Convertir folios a cobro por via serfin
            </li>
        </ol>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <div class="card-actions">
                    <button class="btn btn-dark btn-sm" id="btnReloadC">
                        <i class="fa fa-spin fa-refresh">
                        </i>
                    </button>
                    <button class="btn btn-info btn-sm" id="btnGenerarLayout">
                        Generar layout
                    </button>
                </div>
                Resultados
            </div>
            <div class="card-body table-responsive">
                <table class="table table-hover" id="tableContratos">
                    <thead>
                        <tr>
                            <th scope="col">
                                Folio
                            </th>
                            <th scope="col">
                                Clave Serfin
                            </th>
                            <th scope="col">
                                Fecha de compra
                            </th>
                            <th scope="col">
                                Propietario
                            </th>
                            <th scope="col">
                                Tarjeta asignada
                            </th>
                            <th scope="col">
                                Tarjetahabiente
                            </th>
                            <th scope="col">
                               Tipo
                            </th>
                            <th scope="col">
                                Banco
                            </th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection

@section('script')
<script>
    $(document).ready(function() {
        var table_contratos;

        var table_contratos = $('#tableContratos').dataTable({
            // processing: true,
            // serverSide: true,
            bDestroy: true,
            // bInfo: false,
            ajax: {
                url: baseadmin + "get-contratos-exportar",
                 error: function (xhr, error, code) {
                    // table_contratos.ajax.reload();
                }
            },
            columns: [
                {data: 'folio_data', name: 'folio_data'},
                {data: 'clave_opt', name: 'clave_opt'},
                {data: 'fecha_compra_data', name: 'fecha_compra_data'},
                {data: 'cliente_data', name: 'cliente_data'},
                {data: 'tarjeta_data', name: 'tarjeta_data'},
                {data: 'tarjetahambiente_data', name: 'tarjetahambiente_data'},
                {data: 'tipo_data', name: 'tipo_data'},
                {data: 'banco_data', name: 'banco_data'},
            ]
        }).DataTable();


        $(document).on('click', '#btnReloadC', function(event) {
            event.preventDefault();
            table_contratos.ajax.reload();
            toastr['info']('Recargando datos...')
        });

        $(document).on('click', '#btnGenerarLayout', function(event) {
            event.preventDefault();
            Swal.fire({
                title: "¿Desea crear las OPT's para los registros existentes?",
                text: "Los datos se convertiran a cobro por via SERFIN",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Si, crear',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: baseadmin + 'generate-opt',
                        type: 'GET',
                        dataType: 'json',
                        beforeSend:function(){
                             $("#overlay").css("display", "block");
                        }
                    })
                    .done(function(res) {
                        if (res.success == true) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Se gan generado: ' + res.num_contratos + ' Opt´s a via serfin.',
                                showConfirmButton: true,
                            })

                            table_contratos.ajax.reload();
                        }else{
                            toastr['error']('Intentar mas tarde...');
                        }
                    })
                    .fail(function(jqXHR, textStatus, errorThrown) {
                        $("#overlay").css("display", "none");
                        toastr['error'](errorThrown);
                        toastr['error'](jqXHR.responseJSON.message);
                    })
                    .always(function() {
                         $("#overlay").css("display", "none");
                    });
                }
            })
            
            
        });
    });
</script>
@stop
