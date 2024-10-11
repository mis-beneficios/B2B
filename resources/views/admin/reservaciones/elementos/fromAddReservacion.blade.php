<form action="{{ route('reservations.store') }}" id="formAddReservacion" method="post">
    @csrf
    <input id="user_id" name="user_id" type="hidden" value="{{ $user->id }}"/>
    <div class="modal-body" id="modal-body">
        <div class="form-row">
            <div class="form-group col-md-12">
                <label for="inputEmail4">
                    Nombre a quien sera la reservación
                </label>
                <div class="input-group mb-3">
                    <input class="form-control" id="titular" name="titular" placeholder="Titular" type="text">
                        <button class="btn btn-outline-secondary btn-xs" id="btnAddName" type="button">
                            importar nombre
                        </button>
                    </input>
                </div>
                <span class="text-danger error-titular errors">
                </span>
            </div>
            <div class="col-md-7">
                <div class="form-group">
                    <label for="inputEmail4">
                       Correo electrónico
                    </label>
                    <div class="input-group mb-3">
                        <input class="form-control" id="email" name="email" placeholder="Correo electronico" type="text">
                            <button class="btn btn-outline-secondary btn-sm" id="addEmail" type="button">
                                importar
                            </button>
                        </input>
                    </div>
                    <span class="text-danger error-email errors">
                    </span>
                </div>
            </div>

             <div class="col-md-5">
                <div class="form-group">
                    <label for="inputEmail4">
                        Teléfono
                    </label>
                    <div class="input-group mb-3">
                        <input class="form-control" id="telefono" name="telefono" placeholder="Telefono" type="text">
                            <button class="btn btn-outline-secondary btn-sm" id="addTelefono" type="button">
                                importar
                            </button>
                        </input>
                    </div>
                    <span class="text-danger error-telefono errors">
                    </span>
                </div>
            </div>
            <div class="form-group col-md-7">
                <label for="inputPassword4">
                    Destino
                </label>
                <input class="form-control" id="destino" name="destino" type="text">
                </input>
                <span class="text-danger error-destino errors">
                </span>
            </div>
            <div class="form-group col-md-5">
                <label for="inputPassword4">
                    Fechas
                </label>
                <input class="form-control input-limit-datepicker" id="fechas" name="fechas" type="text">
                </input>
                <span class="text-danger error-fechas errors">
                </span>
            </div>
            <div class="form-group col-md-12">
                <label for="inputEmail4">
                    Estancia
                </label>
                <select class="form-control" id="estancia_id" name="estancia_id">
                    <option value="">Selecciona una opción</option>
                    @foreach ($estancias as $estancia)
                    <option value="{{ $estancia->id }}">
                        {{ $estancia->title }}
                    </option>
                    @endforeach
                </select>
                <span class="text-danger error-estancia_id errors">
                </span>
            </div>
        </div>
        <div class="form-row">
            {{--
            <div class="form-group col-md-4">
                <label for="inputPassword4">
                    Habitaciones
                </label>
                <input class="form-control" id="habitaciones" name="habitaciones" placeholder="" type="text">
                </input>
                <span class="text-danger error-habitaciones errors">
                </span>
            </div>
            --}}
            <div class="form-group col-md-4">
                <label for="inputPassword4">
                    Tipo de reservacion
                </label>
                <select class="form-control" id="tipo_reservacion" name="tipo_reservacion">
                    @foreach ($tipo_reservacion as $val => $tipo_reserva)
                    <option value="{{ $val }}">
                        {{ $tipo_reserva }}
                    </option>
                    @endforeach
                </select>
                <span class="text-danger error-habitaciones errors">
                </span>
            </div>
            <div class="form-group col-md-8">
                <label for="inputPassword4">
                    Región
                </label>
                <select class="js-example-responsive js-states form-control " id="regione_id" name="regione_id">
                    <option value="1">
                        México General
                    </option>
                    <option value="7">
                        Estados Unidos General
                    </option>
                </select>
                <span class="text-danger error-regione_id errors">
                </span>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-12">
                <label for="inputPassword4">
                    Tarjeta
                </label>
                <select class="js-example-responsive js-states form-control " id="tarjeta_id" name="tarjeta_id">
                    <option value="">Selecciona una opción</option>
                    @foreach ($tarjetas as $tarjeta)
                    <option value="{{ $tarjeta->id }}">
                        {{ $tarjeta->numeroTarjeta }}
                    </option>
                    @endforeach
                </select>
                <span class="text-danger error-tarjeta_id errors">
                </span>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button class="btn btn-secondary btn-sm" data-dismiss="modal" type="button">
            {{ __('messages.cerrar') }}
        </button>
        <button class="btn btn-primary btn-sm" type="submit">
            {{ __('messages.guardar') }}
        </button>
    </div>
</form>
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

    $('#estancia_id').select2();
</script>