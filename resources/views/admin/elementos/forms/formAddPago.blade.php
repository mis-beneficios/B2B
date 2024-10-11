<form action="{{ route('pagos.add_pago') }}" id="form_add_pago" method="post">
    @csrf
    <input id="contrato_id" name="contrato_id" type="hidden" value=""/>
    <div class="modal-body">
        <div class="row">
            <div class="col-lg-12 col-md-12">
                <div class="form-row">
                    <div class="form-group col-lg-6 col-md-6">
                        <label for="inputPassword4">
                            Cantidad
                        </label>
                        <input class="form-control" id="cantidad" name="cantidad" type="text"/>
                    </div>
                    <div class="form-group col-lg-6 col-md-6">
                        <label for="fecha_de_cobro">
                            Fecha de cobro
                        </label>
                        <input autocomplete="off" class="form-control datepicker" id="fecha_de_cobro" name="fecha_de_cobro" type="text" />
                    </div>
                    <div class="form-group col-lg-6 col-md-6">
                       <div class="demo-checkbox">
                            <input type="checkbox" id="md_checkbox_26" class="filled-in chk-col-blue">
                            <label for="md_checkbox_26">
                            ¿Es enganche?
                            </label>
                        </div>
                    </div>
                    <div class="form-group col-md-12">
                        <label for="concepto">
                            Concepto
                        </label>
                        <input autocomplete="off" class="form-control" id="concepto" name="concepto" type="text" />
                    </div>
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
<script>
    $('.datepicker').bootstrapMaterialDatePicker({
        weekStart: 0,
        time: false,
        lang: 'es',
    });

    $('#md_checkbox_26').on('change',  function(event) {
        event.preventDefault();
        if ($(this).is(':checked')) {
            $('#concepto').val('Enganche');
        }else{
            $('#concepto').val('');

        }
    });
</script>
