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
            <li class="breadcrumb-item">
                Sorteos
            </li>
            <li class="breadcrumb-item active">
                {{ $sorteo->convenio }}
            </li>
        </ol>
    </div>
</div>
<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="card">
            <div class="card-header">
                <div class="card-actions">
                    <a class="btn btn-info btn-sm" href="{{ route('sorteos.download', $sorteo->id) }}" id="btnDownload">
                        <span>
                            <i class="fas fa-file-excel-o">
                            </i>
                            Exportar datos
                        </span>
                    </a>
                </div>
                <h4 class="card-title m-b-0">
                    Registros del sorteo de {{ $sorteo->convenio }}
                </h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover dataTable" id="table_registros" role="grid" style="width:100%">
                        <thead>
                            <tr role="row">
                                <th>
                                    Folio
                                </th>
                                <th>
                                    Nombre
                                </th>
                                <th>
                                    Correo Electrónico
                                </th>
                                <th>
                                    Teléfono
                                </th>
                                <th>
                                    Teléfono oficina o casa
                                </th>
                                 @if ($sorteo->tipo_sorteo == 'multimedia')
                                    <th>
                                        Testimonio
                                    </th>
                                 @else
                                    <th>
                                        No. Empleado
                                    </th>
                                 @endif
                                <th>
                                    Creado
                                </th>
                                @if ($sorteo->tipo_sorteo == 'multimedia')
                                    <th>
                                        Opciones
                                    </th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($registros as $registro)
                            <tr>
                                <td>
                                    {{ $registro->id }}
                                </td>
                                <td>
                                    {{ $registro->nombre_completo . ' ' . $registro->apellidos }}
                                </td>
                                <td>
                                    {{ $registro->email }}
                                </td>
                                <td>
                                    {{ $registro->telefono_casa }}
                                </td>
                                <td>
                                    {{ $registro->telefono_celular }}
                                </td>
                                 @if ($sorteo->tipo_sorteo == 'multimedia')
                                    <td>
                                        {{ $registro->testimonio }}
                                    </td>
                                 @else
                                    <td>
                                        {{ $registro->numero_empleado }}
                                    </td>
                                 @endif
                                <td>
                                    {{ $registro->created }}
                                </td>
                                @if ($sorteo->tipo_sorteo == 'multimedia')
                                    <td>
                                        <button class="btn btn-xs btn-info" data-url="{{ route('sorteos.show_media', $registro->id) }}" id="btnMedia" data-id="{{ $registro->id }}"><i class="fas fa-eye"></i> Ver archivos</button>
                                    </td>
                                @endif
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalMedia" tabindex="-1" role="dialog" aria-labelledby="modalMediaTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Multimedia</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="modal-body">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Cerrar</button>
        {{-- <button type="button" class="btn btn-primary|secondary|success|danger|warning|info|light|dark">Save changes</button> --}}
      </div>
    </div>
  </div>
</div>
@endsection


@section('script')
<script>
    $(document).ready(function() {
        $('#table_registros').DataTable();

        $(document).on('click', '#btnMedia', function(event) {
            event.preventDefault();
            $.ajax({
                url: $(this).data('url'),
                type: 'GET',
                dataType: 'json',
                beforeSend:function(){
                     $("#overlay").css("display", "block");
                },
                success:function(res){
                    if (res.success == true) {
                        $('#modalMedia #modal-body').html(res.view);
                        $('#modalMedia').modal('show');
                    }
                }
            })            
            .fail(function(jqXHR, textStatus, errorThrown) {
                $("#overlay").css("display", "none");
                toastr['error'](errorThrown);
            })
            .always(function() {
                $("#overlay").css("display", "none");
            });
            
        });
        // $('#btnDownload').on('click', function(event) {
        //     event.preventDefault();
        //     $.ajax({
        //         url: $(this).data('url'),
        //         type: 'GET',
        //         dataType: 'JSON',
        //     })
        //     .done(function() {
        //         console.log("success");
        //     })
        //     .fail(function() {
        //         console.log("error");
        //     })
        //     .always(function() {
        //         console.log("complete");
        //     });
            
        // });
    });
</script>
@endsection
