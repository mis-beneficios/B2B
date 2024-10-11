<form action="{{ route('contratos.metodo_pago', $contrato->id) }}" id="form_editar_metodo_pago" method="put">
    <div class="modal-body">
        <div class="row">
            <div class="col-lg-12 col-md-12">
                <div class="form-row">
                    <div class="form-check mr-3">
                        <input {{ ($contrato->pago_con_nomina == 1 && $contrato->via_serfin == 0) ? 'checked' : ''}} class="form-check-input" id="nomina" name="metodo_de_pago" type="radio" value="nomina">
                            <label class="form-check-label" for="nomina">
                                Nomina
                            </label>
                        </input>
                    </div>
                    <div class="form-check">
                        <input {{ ($contrato->pago_con_nomina == 0 && $contrato->via_serfin == 0) ? 'checked' : ''}} class="form-check-input" id="terminal" name="metodo_de_pago" type="radio" value="terminal">
                            <label class="form-check-label" for="terminal">
                                Terminal
                            </label>
                        </input>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" id="serfin" name="metodo_de_pago" type="radio" value="serfin" {{ ($contrato->pago_con_nomina == 0 && $contrato->via_serfin == 1) ? 'checked' : ''}}>
                            <label class="form-check-label" for="serfin">
                                Via Serfin
                            </label>
                        </input>
                    </div>
                    <span class="text-danger error-tipo_cuenta errors">
                    </span>
                </div>
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
