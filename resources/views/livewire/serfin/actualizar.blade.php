<div>
<button wire:click="render">Refresh</button>
    <div class="card">
        @if ($show_message == true)
            <div class="alert alert-warning">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">×</span> </button>
                <h3 class="text-warning"><i class="fa fa-exclamation-triangle"></i>
                    Advertencia
                </h3> 
                {{ $text_message }}
            </div>
        @endif
        <div class="row">
            <div class="col-12">
                <div class="social-widget">
                    <div class="soc-header">
                        <h3 class="">{{ $text_estatus }}</h3>
                        <h4>
                            @foreach ($files as $f)
                            @if (substr($f['path'], 15, 8) == date('Ymd') && preg_match('/[A-Z0-9]+C/', $f['path']))
                            @php
                                $flag = true;
                                $name = substr($f['path'], 7);
                            @endphp
                                {{ substr($f['path'], 7) }}    
                            @endif
                            @endforeach
                        </h4>       

                        @if ((isset($flag) && $flag))
                            @if ($actualizacion == null)
                            <button class="m-t-10 waves-effect waves-dark btn btn-primary btn-md btn-rounded" wire:click="actualizar_serfin('{{ $name }}')" >
                                {{-- wire:loading.attr="disabled" wire:loading.class="disabled" --}}
                                Actualizar
                            </button>
                            @else
                             <a href="{{ route('download_excel', $name) }}" class="m-t-10 waves-effect waves-dark btn btn-success btn-md btn-rounded"  id="download_excel">
                                <i class="fas fa-file-excel-o"></i>
                                Descargar respuesta</a>
                            @endif
                        @endif
                    </div>
                    @if ($show_res)
                    <div class="soc-content">
                        <div class="col-6 b-r">
                            <h3 class="font-medium">456</h3>
                            <h5 class="text-muted">Followers</h5>
                        </div>
                        <div class="col-6">
                            <h3 class="font-medium">456</h3>
                            <h5 class="text-muted">Tweets</h5>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@section('script')
<script>
window.addEventListener('sweet', event => { 
    // toastr[event.detail.type](event.detail.message, 
    // event.detail.title ?? ''), toastr.options = {
    //     "closeButton": true,
    //     "progressBar": true,
    // }
    // 
    if (event.detail.close == true) {
        Swal.DismissReason.close;
    }else{
        Swal.fire({
            icon: event.detail.type,
            title: event.detail.message,
            html: 'No cierre ni actualice esta ventana hasta que termine de actualizar el sistema',
            timerProgressBar: true,
            showConfirmButton: false,
            allowOutsideClick: true,
            didOpen: () => {
                Swal.showLoading()
            }
        });

    }
});

flatpickr("#fecha", {
    enableTime: false,
    dateFormat: "Y-m-d", 
    locale:"es",
    onChange: function (selectedDates, dateStr) {
        @this.set('fecha', dateStr);
    }
});
</script>
@endsection
