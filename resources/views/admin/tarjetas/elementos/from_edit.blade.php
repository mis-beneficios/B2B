<form id="formEditCard" action="{{ route('cards.update', $tarjeta->id) }}">
    <div class="modal-body" id="modal-body">
        <div class="form-row">
            <div class="col-md-12">
                <label for="inputEmail4">
                    Estatus
                </label>
                <div class="input-group">
                    <select name="estatus" id="estatus" class="form-control select2">
                        @foreach (session('config.estatus_tarjetas') as $tar => $val)
                            <option value="{{$tar}}">{{$val}}</option>
                        @endforeach
                    </select>
                </div>
                <span class="text-danger error-titular errors">
                </span>
            </div>
            <div class="col-md-12">
                <label for="inputEmail4">
                    Titular
                </label>
                <div class="input-group mb-2">
                    <input class="form-control" id="titular" name="titular" placeholder="Titular" type="text" value="{{$tarjeta->name}}">
                        <button class="btn btn-outline-secondary btn-xs" id="btnAddName" type="button">
                            importar nombre
                        </button>
                    </input>
                </div>
                <span class="text-danger error-titular errors">
                </span>
            </div>
            <div class="mt-1 col-md-8">
                <label for="inputPassword4">
                    Numero de tarjeta
                </label>
                <input class="form-control" id="numero_tarjeta" name="numero_tarjeta" value="{{$tarjeta->numero}}" placeholder="1111222233334444" type="text">
                </input>
                <span class="text-danger" style="font-size: 12px;">
                    Ingresar solo numeros sin guiones ni espacios.
                </span>
                <br/>
                <span class="text-danger error-numero_tarjeta errors">
                </span>
            </div>
            <div class="mt-1 col-md-4">
                <label for="inputEmail4">
                    Vencimiento
                </label>
                <input class="form-control vencimiento" id="vencimiento" name="vencimiento" placeholder="01/20" type="text" value="{{ ((strlen($tarjeta->mes) == 1) ? '0'.$tarjeta->mes : $tarjeta->mes) .'/'. ((strlen($tarjeta->ano) == 4) ? substr($tarjeta->ano, -2) : $tarjeta->ano) }}">
                </input>
                <span class="text-danger error-vencimiento errors">
                </span>
            </div>
        </div>
        <div class="form-row">
            <div class="mt-1 col-md-3">
                <label for="inputPassword4">
                    CVV
                </label>
                <input class="form-control" id="cvv2" name="cvv2" placeholder="" type="password">
                </input>
                <span class="text-danger error-cvv2 errors">
                </span>
            </div>
            <div class="mt-1 col-md-8">
                <label for="inputPassword4">
                    Banco emisor
                </label>
                <div class="input-group">              
                    <select class="js-example-responsive js-states form-control select2" id="banco" name="banco">
                        @foreach (session('config.bancos_mx') as $banco)
                        <option class="text-uppercase" value="{{ $banco['id'] }}" @if ($tarjeta->banco_id == $banco['id'])
                            selected
                        @endif>
                            {{ $banco['title'] }}
                        </option>
                        @endforeach
                    </select>
                    <button class="btn btn-dark btn-xs ml-1" id="btnReloadBank"><i class="fas fa-refresh"></i></button>
                </div>
                <span class="text-danger error-banco errors">
                </span>
            </div>
        </div>
        <div class="form-row">
            <div class="mt-1 col-md-6">
                <label for="inputPassword4">
                    Tipo de pago
                </label>
                <select  class="js-example-responsive js-states form-control " id="tipo_cuenta" name="tipo_cuenta">
                    <option @if ($tarjeta->tipocuenta == '03') selected @endif value="03">Tarjeta</option>
                    <option @if ($tarjeta->tipocuenta == '40') selected @endif value="40">Clabe Interbancaria</option>
                </select>
                <span class="text-danger error-tipo_cuenta errors">
                </span>
            </div>

            <div class="mt-1 col-md-6">
                <label for="inputPassword4">
                    Tipo
                </label>
                <select  class="js-example-responsive js-states form-control " id="tipo_card" name="tipo_card">
                    <option value="">Seleccione una optión</option>
                    <option @if ($tarjeta->banco == 'VISA') selected @endif value="VISA">VISA</option>
                    <option @if ($tarjeta->banco == 'Master Card') selected @endif value="Master Card">Master Card</option>
                    <option @if ($tarjeta->banco == 'Otro') selected @endif value="Otro">Otro</option>
                </select>
                <span class="text-danger error-tipo_card errors">
                </span>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="inputPassword4">
                    Tipo de tarjeta
                </label>
                <select  class="js-example-responsive js-states form-control " id="tipo" name="tipo">
                    <option value="">Seleccione una optión</option>
                    <option @if ($tarjeta->tipo == 'Debito') selected @endif value="Debito">Debito</option>
                    <option @if ($tarjeta->tipo == 'Credito') selected @endif value="Credito">Credito</option>
                </select>
                <span class="text-danger error-tipo errors">
                </span>
            </div>
            {{-- <div class="form-check mr-3">
                <input @if ($tarjeta->tipo == 'Credito') checked="" @endif class="form-check-input" id="credito" name="tipo" type="radio" value="Credito">
                    <label class="form-check-label" for="credito">
                        Credito
                    </label>
                </input>
            </div>
            <div class="form-check mr-3">
                <input @if ($tarjeta->tipo == 'Debito') checked="" @endif checked="" class="form-check-input" id="debito" name="tipo" type="radio" value="Debito">
                    <label class="form-check-label" for="debito">
                        Debito
                    </label>
                </input>
            </div>
            <span class="text-danger error-tipo errors">
            </span> --}}
        </div>
    </div>
    <div class="modal-footer">
        <button class="btn btn-secondary btn-sm" data-dismiss="modal" type="button">
            Cerrar
        </button>
        <button class="btn btn-primary btn-sm" type="submit">
            Guardar
        </button>
    </div>
</form>
<script>
        // var element = document.getElementById('vencimiento_edit');
        // var options = {
        //     mask: '00/00'
        // };

        // IMask(element, options);
</script>
