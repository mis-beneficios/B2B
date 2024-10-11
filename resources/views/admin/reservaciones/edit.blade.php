<div class="card-body">
    <div class="row">
         <div class="col-lg-12 col-md-12">
                <h3>
                    Reservación #{{ $reservacion->id }}
                </h3>
            </div>
        <div class="col-md-12">
            <form action="{{ route('reservations.update', $reservacion->id) }}" class="" autocomplete="off" id="form_reservaciones_edit" method="PUT">
                @csrf
                <input id="reservacion_id" name="reservacion_id" type="hidden" value="{{ $reservacion->id }}"/>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>
                                {{ __('messages.cliente.estatus') }}:
                            </label>
                            <select class="form-control" id="estatus" name="estatus">
                                @foreach ($estatus_reservacion as $estatus => $val)
                                    <option value="{{ $estatus }}"  @if ($estatus == $reservacion->estatus) selected @endif>
                                        {{ $val }}
                                    </option>
                                @endforeach
                            </select>
                            <span class="text-danger error-folio errors">
                            </span>
                        </div> 
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="inputPassword4">
                                Fechas
                            </label>
                            <input class="form-control input-limit-datepicker" id="fechas" name="fechas" value="{{ $reservacion->fecha_de_ingreso .' al '. $reservacion->fecha_de_salida }}" type="text" autocomplete="off">
                            </input>
                            <span class="text-danger error-fechas errors">
                            </span>
                        </div>
                    </div>
                    <div class="col-lg-12 col-md-12">
                        <label class="">Nombre de quien sera la reservación:</label>
                        <div class="input-group">
                             <input class="form-control" id="nombre_adquisitor" name="nombre_adquisitor" placeholder="" type="text" value="{{ $reservacion->nombre_de_quien_sera_la_reservacion }}">
                            </input>
                              <span class="text-danger error-nombre_adquisitor errors">
                            </span>
                            <span class="input-group-btn">
                                <button type="button" id="addName" class="btn btn-outline-secondary">Importar</button>
                            </span>
                        </div>
                    </div>
        
                    <div class="col-md-7 m-t-20">
                        <div class="form-group">
                            <label for="inputEmail4">
                               Correo electrónico
                            </label>
                            <div class="input-group mb-3">
                                <input class="form-control" id="email" name="email" placeholder="Correo electronico" type="text" value="{{ $reservacion->email }}">
                                    <button class="btn btn-outline-secondary btn-sm" id="addEmail" type="button">
                                        importar
                                    </button>
                                </input>
                            </div>
                            <span class="text-danger error-email errors">
                            </span>
                        </div>
                    </div>

                     <div class="col-md-5 m-t-20">
                        <div class="form-group">
                            <label for="inputEmail4">
                                Teléfono
                            </label>
                            <div class="input-group mb-3">
                                <input class="form-control" id="telefono" name="telefono" placeholder="Telefono" type="text" value="{{ $reservacion->telefono }}">
                                    <button class="btn btn-outline-secondary btn-sm" id="addTelefono" type="button">
                                        importar
                                    </button>
                                </input>
                            </div>
                            <span class="text-danger error-telefono errors">
                            </span>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-12">
                        <div class="form-group">
                            <label>
                                Destino:
                            </label>
                            <input class="form-control" id="destino" name="destino" type="text" value="{{ $reservacion->destino }}"/>
                            <span class="text-danger error-destino errors">
                            </span>
                        </div>
                    </div>
                    <div class="col-lg-8 col-md-12">
                        <div class="form-group">
                             <label>
                                Tipo de plan:
                            </label>
                             <select class="form-control" id="estancia_id" name="estancia_id">
                            <option value="0" >Seleccione una opción</option>
                            @foreach ($estancias_global as $estancia)
                                <option value="{{ $estancia->id }}"  @if ($estancia->id == $reservacion->estancia_id) selected @endif>
                                    {{ $estancia->title }}
                                </option>
                            @endforeach
                        </select>
                        <span class="text-danger error-estancia_id errors">
                        </span>

                        </div>
                    </div>
                     <div class="form-group col-lg-8 col-md-6">
                        <label for="tipo_reserva">
                            Estancia:
                        </label>
                        <input class="form-control" id="title" name="title" type="text" value="{{ $reservacion->title }}">
                        </input>
                    </div>
                    <div class="form-group col-lg-4 col-md-6">
                        <label for="tipo_reserva">
                            Tipo de reservación:
                        </label>
                        <select class="form-control" id="tipo_reserva" name="tipo_reserva">
                            <option >Seleccione una opción</option>
                            @foreach ($tipo_reservacion as $tipo => $val)
                                <option value="{{ $tipo }}"  @if ($tipo == $reservacion->tipo) selected @endif>
                                    {{ $val }}
                                </option>
                            @endforeach
                        </select>
                        <span class="text-danger error-tipo_reserva errors">
                        </span>
                    </div>
                    <div class="form-group col-lg-6  col-md-6 ">
                        <label for="region">
                            Región:
                        </label>
                        <select class="form-control" name="regione_id">
                            <option>
                                Selecciona una opción
                            </option>
                            @foreach ($regiones as $region => $val)
                            <option value="{{ $val }}" @if ($val == $reservacion->regione_id) selected @endif>
                                {{ $region }}
                            </option>
                            @endforeach
                        </select>
                        <span class="text-danger error-region errors">
                        </span>
                    </div>
                    <div class="form-group col-lg-6  col-md-6">
                        <label for="tarjeta">
                            Tarjeta:
                        </label>
                        <select class="form-control" name="tarjeta_id">
                            @foreach ($reservacion->cliente->tarjetas as $tarjeta)
                            <option value="{{ $tarjeta->id }}" @if ($tarjeta->id == $reservacion->tarjeta_id) selected @endif>
                                {{ $tarjeta->numeroTarjeta }}
                            </option>
                            @endforeach
                        </select>
                        <span class="text-danger error-tarjeta errors">
                        </span>
                    </div>
                    <div class="form-group col-md-12">
                        <label>
                            {{ __('messages.cliente.observaciones') }}:
                        </label>
                        <textarea class="form-control" id="comentario" name="comentario" rows="5"></textarea>
                        <span class="text-danger error-comentario errors">
                        </span>
                    </div>
                    <div class="col-md-12">
                        <button class="btn btn-info btn-sm" type="submit">
                           <!--  <i class="fa fa-paper-plane">
                            </i> -->
                            {{ __('messages.guardar') }}
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
   
        $('#fechas').daterangepicker({
            autoUpdateInput: true,
            locale: {
                format: 'YYYY-MM-DD',
                separator: ' al ',
                applyLabel: 'Aplicar',
                cancelLabel: 'Cancelar',
                fromLabel: 'Desde',
                toLabel: 'Hasta',
                customRangeLabel: 'Personalizado',
                weekLabel: 'W',
                daysOfWeek: ['Dom', 'Lun', 'Mar', 'Mié', 'Jue', 'Vie', 'Sáb'],
                monthNames: [
                    'Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'
                ],
                firstDay: 1
            }
        });

        // $('#fechas').data('daterangepicker').setStartDate(@json(\Carbon\Carbon::create($reservacion->fecha_de_ingreso)->format('Y-m-d')));
        // $('#fechas').data('daterangepicker').setEndDate(@json(\Carbon\Carbon::create($reservacion->fecha_de_salida)->format('Y-m-d')));
        // $('#fechas').data('daterangepicker').setStartDate(@json($reservacion->fecha_de_ingreso));
        // $('#fechas').data('daterangepicker').setEndDate(@json($reservacion->fecha_de_salida));
</script>
