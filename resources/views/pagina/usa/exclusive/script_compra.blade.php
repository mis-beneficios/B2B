@section('script')
<script>
    $(document).ready(function() {
            $('body').on('click', '.btnDetalles', function(event) {
                event.preventDefault();
                var id_estancia = $('#btnDetalles').attr('value');
                console.log(id_estancia);
                $('#modalDetalles').modal('show');
            });

            $('body').on('click', '#btnSiguiente', function(event) {
                event.preventDefault();
                $.ajax({
                    url: baseuri + 'process-payment/create',
                    type: 'GET',
                    dataType: 'json',
                    data: $('#form_compra_eu').serialize(),
                    beforeSend: function() {
                        $("#overlay").css("display", "block");
                    },
                    success: function(res) {
                        if (res.success == false) {
                            pintar_errores(res.errors);
                        }
                        if (res.success == true) {
                            window.location.href = res.card;
                        }
                    }
                })
                .always(function() {
                    $("#overlay").css("display", "none");
                });
            });

        });
</script>
@endsection
