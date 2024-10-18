<div aria-hidden="true" aria-labelledby="modalAddTarjeta" class="modal fade" id="modalAddTarjeta" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalAddTarjetaLabel">
                    Agregar nueva tarjeta
                </h5>
                <button aria-label="Close" class="close" data-dismiss="modal" type="button">
                    <span aria-hidden="true">
                        ×
                    </span>
                </button>
            </div>
            <form id="formAddCard">
                <div class="modal-body" id="modal-body">
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label for="inputEmail4">
                                Titular
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
                        <div class="form-group col-md-8">
                            <label for="inputPassword4">
                                Numero de tarjeta
                            </label>
                            <input class="form-control" id="numero_tarjeta" name="numero_tarjeta" placeholder="1111222233334444" type="text">
                            </input>
                            <span class="text-danger" style="font-size: 12px;">
                                Ingresar solo numeros sin guiones ni espacios.
                            </span>
                            <br/>
                            <span class="text-danger error-numero_tarjeta errors">
                            </span>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="inputEmail4">
                                Vencimiento
                            </label>
                            <input class="form-control vencimiento" id="vencimiento" name="vencimiento" placeholder="01/20" type="text">
                            </input>
                            <span class="text-danger error-vencimiento errors">
                            </span>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-3">
                            <label for="inputPassword4">
                                CVV
                            </label>
                            <input class="form-control" id="cvv2" name="cvv2" placeholder="" type="password">
                            </input>
                            <span class="text-danger error-cvv2 errors">
                            </span>
                        </div>
                        {{-- <div class="form-group col-md-8">
                            <label for="inputPassword4">
                                Banco emisor
                            </label>
                            <select class="js-example-responsive js-states form-control " id="banco" name="banco">
                                @foreach ($bancos_mx as $banco)
                                <option class="text-uppercase" value="{{ $banco['id'] }}">
                                    {{ $banco['title'] }}
                                </option>
                                @endforeach
                            </select>
                            <span class="text-danger error-banco errors">
                            </span>
                        </div> --}}
                        <div class="mt-1 col-md-8">
                            <label for="inputPassword4">
                                Banco emisor
                            </label>
                            <div class="input-group">              
                                <select class="js-example-responsive js-states form-control" id="banco" name="banco">
                                    @foreach (session('config.bancos_mx') as $banco)
                                    <option class="text-uppercase" value="{{ $banco['id'] }}">
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
                        <div class="form-check mr-3">
                            <input checked="" class="form-check-input" id="tarjeta" name="tipo_cuenta" type="radio" value="03">
                                <label class="form-check-label" for="tarjeta">
                                    Tarjeta
                                </label>
                            </input>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" id="clave" name="tipo_cuenta" type="radio" value="40">
                                <label class="form-check-label" for="clave">
                                    Clave interbancaria
                                </label>
                            </input>
                        </div>
                        <span class="text-danger error-tipo_cuenta errors">
                        </span>
                    </div>
                    <div class="form-row">
                        <div class="form-check mr-3">
                            <input class="form-check-input" id="exampleRadios1" name="tipo_card" type="radio" value="Master Card">
                                <label class="form-check-label" for="exampleRadios1">
                                    Master Card
                                </label>
                            </input>
                        </div>
                        <div class="form-check mr-3">
                            <input checked="" class="form-check-input" id="exampleRadios2" name="tipo_card" type="radio" value="VISA">
                                <label class="form-check-label" for="exampleRadios2">
                                    Visa
                                </label>
                            </input>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" id="exampleRadios3" name="tipo_card" type="radio" value="Otro">
                                <label class="form-check-label" for="exampleRadios3">
                                    Otros
                                </label>
                            </input>
                        </div>
                        <span class="text-danger error-tipo_card errors">
                        </span>
                    </div>
                    <div class="form-row">
                        <div class="form-check mr-3">
                            <input class="form-check-input" id="credito" name="tipo" type="radio" value="Credito">
                                <label class="form-check-label" for="credito">
                                    Credito
                                </label>
                            </input>
                        </div>
                        <div class="form-check mr-3">
                            <input checked="" class="form-check-input" id="debito" name="tipo" type="radio" value="Debito">
                                <label class="form-check-label" for="debito">
                                    Debito
                                </label>
                            </input>
                        </div>
                        <span class="text-danger error-tipo errors">
                        </span>
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
        </div>
    </div>
</div>
