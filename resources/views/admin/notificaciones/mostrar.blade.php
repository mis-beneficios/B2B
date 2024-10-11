{{-- {{ $notificacion }} --}}

<div aria-hidden="true" aria-labelledby="modalShowNotificacion{{ $notificacion->key_cache }}" class="modal fade" data-backdrop="static" id="modalShowNotificacion{{ $notificacion->key_cache }}" tabindex="-1">
    <div class="modal-dialog  modal-dialog-scrollable modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalSearchLabel">
                    {{ $notificacion->nombre }}
                </h5>
                <button aria-label="Close" class="close" data-dismiss="modal" type="button">
                    <span aria-hidden="true">
                        ×
                    </span>
                </button>
            </div>
            <div class="modal-body table-responsive">
            	{!! $notificacion->cuerpo !!}
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary btn-sm" data-dismiss="modal" type="button">
                    Cerrar
                </button> 
                <button class="btn btn-info btn-sm" id="noVolverAMostrar" data-url="{{ route('notificaciones.ocultar', $notificacion->key_cache) }}" type="button">
                    No volver a mostrar
                </button>
            </div>
        </div>
    </div>
</div>


<script>

	var cache = "{{ isset($_COOKIE[$notificacion->key_cache])}}";
	var val_cache = "{{ isset($_COOKIE[$notificacion->key_cache]) ? $_COOKIE[$notificacion->key_cache] : 'true' }}";


	console.log(cache,val_cache);
	var modal =  "modalShowNotificacion{{ $notificacion->key_cache }}";

	if (val_cache == 'false') {
		setTimeout(function(){
			$('#'+modal).modal('show');
		},5000);
	}


	$('#noVolverAMostrar').on('click', function(event) {
		event.preventDefault();
		$.ajax({
			url: $(this).data('url'),
			type: 'GET',
			dataType: 'json',
			beforeSend:function(){
				$('#overlay').css('display', 'block');
			},
			success:function(res){
				if (res.success == true) {
					$('#'+modal).modal('hide');
				}
			}
		})
		.always(function() {
			$('#overlay').css('display', 'none');
		});
		

	});
</script>