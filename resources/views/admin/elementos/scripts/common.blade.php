<script type="text/javascript">
    // Cargar metodos y funciones
	$(function() {
		var app = {
			init: function() {
				app.editarContrato();
			},
			editarContrato: function() {
				$(document).on('click', '#btnEditarContrato', function(event) {
					event.preventDefault();
					var contrato_id = $(this).attr('value');
					alertify.confirm('{{ __('messages.editar_contrato ') }}', '¿Desea editar el contrato seleccionado?',
						function() {
							$.ajax({
								url: baseadmin + 'contratos/' + contrato_id + '/edit',
								type: 'GET',
								dataType: 'json',
								beforeSend: function() {
									$("#overlay").css("display", "block");
								},
								success: function(res) {
									if (res.success == true) {
										$('#modalGeneral #modalGeneralLabel').html(res.titulo);
										$('#modalGeneral #modal-body').html(res.view);
										$('#modalGeneral').modal('show');
									}
								}
							}).always(function() {
								$("#overlay").css("display", "none");
							});
						},
						function() {
							toastr["info"]("!No se realizaron cambios!");
							$('#modalGeneral').modal('hide');
						});
				});

				$(document).on('submit', '#form_editar_contrato', function(event) {
					event.preventDefault();
					$.ajax({
						url: $(this).attr('action'),
						type: $(this).attr('method'),
						dataType: 'json',
						data: $(this).serialize(),
						beforeSend: function() {},
						success: function(res) {
							if (res.success == true) {
								window.location.reload();
								$('#modalGeneral').modal('hide');
								toastr['success']('{{ __('messages.alerta.success ') }}');
							} else {
								toastr['error']('No se pudieron aplicar los cambios, intentelo mas tarde');
							}
						}
					}).always(function() {
						$('#modalGeneral').modal('hide');
					});
				});
			}
		};
	})
</script>