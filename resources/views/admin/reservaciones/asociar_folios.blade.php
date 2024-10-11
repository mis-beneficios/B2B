<div class="card-body">
    @if (count($reservacion->contratos) != 0)
        @php
            $route = route('reservations.editarAjustes', $reservacion->id)
        @endphp
        @else
        @php
            $route = route('reservations.ajustes', $reservacion->id)
        @endphp
    @endif
    @php
        $contratosVinculados = 0;
        $nochesVinculados = 0;
        $adultosVinculados = 0;
        $ninosVinculados = 0;
        $juniorsVinculados = 0;
        $totalPagado = 0;
        $totalComprado = 0;
        $nochesDefault = 2;
        $adultosDefault = 2;
        $ninosDefault = 0;
        $juniorsDefault = 0;
        $nochesQuedan = 0;  
    @endphp
    <form action="{{ $route}}" class="" id="form_reservaciones_edit" method="PUT">
        @csrf
        <input id="reservacion_id" name="reservacion_id" type="hidden" value="{{ $reservacion->id }}"/>
        <h2 class="text-info">Reservacion #{{$reservacion->id}}</h2>
        <div class="row">
            <div class="col-md-12 mb-2">
                <p>Detalles:</p>
                <div class="row">
                    <div class="col-md-4">
                        {{ 'Fecha de ingreso: '.$reservacion->fecha_de_ingreso }}
                    </div>
                    <div class="col-md-4">
                        {{ 'Fecha de salida: ' . $reservacion->fecha_de_salida }}
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="row">                
                    <div class="col-md-4">
                       <div class="form-group row">
                          <label for="example-text-input" class="col-3 col-form-label">Noches:</label>
                          <div class="col-4">
                            <input class="form-control" readonly type="text" value="{{ $reservacion->num_noches() }}" id="noches_res">
                          </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                       <div class="form-group row">
                          <label for="example-text-input" class="col-3 col-form-label">Dias:</label>
                          <div class="col-4">
                            <input class="form-control" readonly type="text" value="{{ $reservacion->num_dias() }}" id="noches_res">
                          </div>
                        </div>
                    </div>
                </div>
            </div>
            <hr>
            <div class="col-md-6">
                <p>
                    Contratos / Cobros GRV
                </p>
                <table class="table table-condensed table-hover table-stats" style="font-size: 12px;">
                    @foreach ($contratos as $contrato)
                    @php
                        $contratoVinculado = 0;
                        $montoPagado = 0;
                        $reservacionVinculada = 0;
                    @endphp
                    @foreach ($contrato->pagos_contrato as $pago)
                        @if ($pago->estatus == 'Pagado')
                            @php
                                $montoPagado += $pago->cantidad;
                            @endphp
                        @endif
                    @endforeach
                    @php
                        $montoPendiente = round($contrato['precio_de_compra'] - $montoPagado, 2);
                        $porcentajePagado = round(($montoPagado / $contrato['precio_de_compra']) * 100, 2);
                    @endphp
                    @foreach ($vinculados as $vinculado)
                    @if($vinculado->id == $contrato->id)
                        @php
                            $contratosVinculados++;
                            $nochesVinculados += $contrato['noches'];
                            $nochesQuedan = $nochesVinculados;
                            $adultosVinculados = $contrato['adultos'];
                            $ninosVinculados = $contrato['ninos'];
                            $juniorsVinculados = $contrato['juniors'];
                            $totalComprado =  round($totalComprado + $contrato['precio_de_compra'], 2);
                            $totalPagado = round($totalPagado + $montoPagado, 2);
                            $contratoVinculado = $vinculado->id;
                        @endphp
                        @endif
                    @endforeach     
                    @php
                        $class = ($contratoVinculado > 0) ? 'table-info' : ($contrato->estatus == 'viajado' ? 'table-dark' : '');
                    @endphp
                    <tr class="{{ $class }}">
                        <td >
                            {{ $contrato->id }}
                            <br/>
                            <small>
                                {{ $contrato->paquete }}
                            </small>
                            <br>
                                <span class="text-uppercase">
                                    {{ $contrato->metodo_de_pago() }}
                                </span>
                                (Pend. ${{ number_format($contrato->precio_de_compra - $contrato->sum_pagos_concretados(),2) }} de ${{ number_format($contrato->precio_de_compra,2) }} :  {{ round(($contrato->sum_pagos_concretados() / $contrato->precio_de_compra) * 100, 2) }}%)
                            </br>
                        </td>
                        <td>
                            {{ $contrato->noches }} N
                            {{ $contrato->adultos }} A
                            {{ $contrato->ninos }} K
                            {{ $contrato->juniors }} K
                        </td>
                        <td>
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <input name="contrato_id[]" {{ ($contratoVinculado > 0  || $contrato->estatus == 'viajado') ? 'checked' : '' }}   class="contrato_id"  data-validar="{{ ($contrato->estatus == 'viajado') ? 'true' : 'false' }}"  {{ ($contratoVinculado > 0 || $contrato->estatus == 'viajado') ? 'disabled' : '' }}   type="checkbox" id="folio_asociado{{ $contrato->id }}" value="{{ $contrato->id }}" data-reservacion_id="{{ $reservacion->id }}">
                                    </input>
                                    
                                </span>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                    <tr>
                    <th style="background-color:#F93; color: #FFF;">
                        {{ $contratosVinculados }} Contratos vinculados, {{ $nochesVinculados }}N, {{ $adultosVinculados }}A, {{ $ninosVinculados }}K.
                        <br/>
                        Pagado ${{ number_format($totalPagado,2) }} de $ {{ number_format($totalComprado,2) }}
                    </th>
                </tr>
                </table>
            </div>


            {{-- Habitaciones --}}
            <div class="col-md-6">
                <div class="pull-right">
                    <button class="btn btn-xs btn-info btnAddHabitacion" data-adultos="{{ ($reservacion->estancia) ? $reservacion->estancia->adultos :  2 }}" data-estatus="{{ $reservacion->estatus }}" data-noches="{{ ($reservacion->estancia) ? $reservacion->estancia->noches : 2 }}" data-user_id="{{ $reservacion->user_id }}" type="button" data-num_row_hab="{{ count($reservacion->r_habitaciones) }}">
                        <i class="fas fa-plus">
                        </i>
                        Agregar
                    </button>
                </div>
                @if (count($reservacion->r_habitaciones)!=0)
                @foreach ($reservacion->r_habitaciones as $habitacion)
                <div class="row" id="rowHabitacion{{ $loop->iteration }}">
                    <input name="num_habitacion[]" type="hidden" value="{{ $loop->iteration }}"/>
                    <input name="habitacion_id[]" type="hidden" value="{{ $habitacion->id }}"/>
                    <div class="col-md-12">
                        Habitacion {{ $loop->iteration }}
                        @if(!$loop->first)
                        <div class="pull-right">
                            <button class="btn btn-xs btn-danger removeHabitacion"  data-id="{{ $loop->iteration }}" data-url_habitacion="{{ route('habitaciones.destroy', $habitacion->id) }}"  value="{{ $habitacion->id }}" id="btnEliminarHabitacionR" type="button">
                                <i class="fas fa-trash">
                                </i>
                                Eliminar
                            </button>
                        </div>
                        @endif
                    </div>
                    <div class="form-group col-md-6">
                        <label for="adultos">
                            Adultos
                        </label>
                        <input class="form-control" id="adultos" name="adultos[]" type="text" value="{{ $habitacion->adultos }}">
                        </input>
                        <span class="text-danger error-adultos errors">
                        </span>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="noches">
                            Noches
                        </label>
                        <input class="form-control" id="noches" name="noches[]" type="text" value="{{  $habitacion->noches }}">
                        </input>
                        <span class="text-danger error-noches errors">
                        </span>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="ninos">
                            Niños:
                        </label>
                        <br/>
                        <button class="btn btn-info btn-xs btnAdd" data-field="dynamic_field_" data-num_row="{{  $loop->iteration  }}" data-row="{{  $loop->iteration  }}" id="btnAdd" type="button">
                            <i class="fa fa-plus">
                            </i>
                            Agregar
                        </button>
                        <div class="row">
                            <div class="col-md-8">
                                <table class="table" id="dynamic_field_{{  $loop->iteration  }}">
                                    @for ($i = 1; $i <= $habitacion->menores ; $i++)
                                    @php
                                        $nom = "edad_menor_".$i;
                                    @endphp
                                    <tr id="row{{ $i }}">
                                        <td>
                                            <div class="input-group input-sm">
                                                <input class="form-control" id="edad_nino{{ $loop->iteration }}" min="1" name="edad_nino{{ $loop->iteration }}[]" pattern="^[0-9]+" required="" type="text" value="{{ $habitacion[$nom] }}"/>
                                                <div class="input-group-append">
                                                    <button class="btn btn-outline-danger btn_remove btn-sm" data-url_nino="{{ url('admin/delete-menor/'. $habitacion->id .'/'. $i) }}"  data-habitacion_id="{{ $habitacion->id }}" data-nino_id="{{ $i }}" data-field="dynamic_field_{{ $loop->iteration }}" id="{{ $i }}" name="remove" type="button">
                                                        <span class="fa fa-trash">
                                                        </span>
                                                    </button>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    @endfor
                                </table>
                            </div>
                        </div>
                        <span class="help-block text-muted">
                            <small>
                                {{ __('messages.cliente.menores_12') }}
                            </small>
                        </span>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="junior">
                            {{ __('messages.cliente.juniors') }}:
                        </label>
                        <br/>
                        <button class="btn btn-info btn-xs btnAddJ" data-field="dynamic_field_j_" data-num_row="{{  $loop->iteration  }}"  data-row="{{  $loop->iteration  }}" id="btnAddJ" type="button">
                            <i class="fa fa-plus">
                            </i>
                            {{ __('messages.cliente.agregar') }}
                        </button>
                        <div class="row">
                            <div class="col-md-10">
                                <table class="table" id="dynamic_field_j_{{  $loop->iteration  }}">
                                    @for ($i = 1; $i <= $habitacion->juniors ; $i++)
                                    @php
                                        $nom = "edad_junior_".$i;
                                    @endphp
                                    <tr id="row{{ $i }}">
                                        <td>
                                            <div class="input-group input-sm">
                                                <input class="form-control" id="edad_junior{{ $loop->iteration }}" min="1" name="edad_junior{{ $loop->iteration }}[]" pattern="^[0-9]+" required="" type="text" value="{{ $habitacion[$nom] }}"/>
                                                <div class="input-group-append">
                                                    <button class="btn btn-outline-danger btn_remove_j btn-sm" data-field="dynamic_field_j_{{ $loop->iteration }}" data-url_jr="{{ url('admin/delete-junior/'. $habitacion->id .'/'. $i) }}"  id="{{ $i }}" name="remove" type="button">
                                                        <span class="fa fa-trash">
                                                        </span>
                                                    </button>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    @endfor
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
                @else
                <div class="row" id="rowHabitacion1">
                    <input name="num_habitacion[]" type="hidden" value="1"/>
                    <div class="col-md-12">
                        Habitacion 1
                    </div> 
                    <div class="form-group col-md-6">
                        <label for="adultos">
                            Adultos
                        </label>
                        <input class="form-control" id="adultos" name="adultos[]" type="text" value="{{ $reservacion->estancia->adultos }}">
                        </input>
                        <span class="text-danger error-adultos errors">
                        </span>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="noches">
                            Noches
                        </label>
                        <input class="form-control" id="noches" name="noches[]" type="text" value="{{ $reservacion->noches }}">
                        </input>
                        <span class="text-danger error-noches errors">
                        </span>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="ninos">
                            Niños:
                        </label>
                        <br/>
                        <button class="btn btn-info btn-xs btnAdd" data-cantidad-row="" data-field="dynamic_field_" data-row="1" id="btnAdd" type="button">
                            <i class="fa fa-plus">
                            </i>
                            Agregar
                        </button>
                        <div class="row">
                            <div class="col-md-8">
                                <table class="table" id="dynamic_field_1">
                                </table>
                            </div>
                        </div>
                        <span class="help-block text-muted">
                            <small>
                                {{ __('messages.cliente.menores_12') }}
                            </small>
                        </span>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="junior">
                            {{ __('messages.cliente.juniors') }}:
                        </label>
                        <br/>
                        <button class="btn btn-info btn-xs btnAddJ" data-field="dynamic_field_j_" data-row="1" id="btnAddJ" type="button">
                            <i class="fa fa-plus">
                            </i>
                            {{ __('messages.cliente.agregar') }}
                        </button>
                        <div class="row">
                            <div class="col-md-10">
                                <table class="table" id="dynamic_field_j_1">
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
                <div id="divHabitacion">
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button class="btn btn-secondary btn-sm" data-dismiss="modal" type="button">
                Cerrar
            </button>
            <button class="btn btn-info btn-sm" type="submit">
                Guardar
            </button>
        </div>
    </form>
</div>
