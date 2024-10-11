
<div>
    <div class="card">
        <div class="card-body">
            <div wire:loading wire:target="downloadExcel">
                <div class="alert alert-info w-auto" style="width: 90%">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">×</span> </button>
                    <h3 class="text-info"><i class="fa fa-exclamation-triangle"></i> 
                        Espere...
                    </h3>

                    Descarando archivo...
                </div>
            </div>
            <div wire:loading wire:target="download">
                <div class="alert alert-info w-auto" style="width: 90%">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">×</span> </button>
                    <h3 class="text-info"><i class="fa fa-exclamation-triangle"></i> 
                        Espere...
                    </h3>

                    Descarando archivo...
                </div>
            </div>
            <form wire:submit.prevent="get_files">
                <div class="form-body">
                    <div class="row">
                        <div class="col-md-2">
                            <div class="form-group">
                                <label class="control-label">Fecha</label>
                                <input type="text" id="fecha" autocomplete="off" wire:model.lazy="fecha"  class="form-control">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-actions">
                    <button type="submit" class="btn btn-success"> <i class="fa fa-search"></i> Buscar</button>
                </div>
            </form>
            <hr>
            @if ($show_files == true)
            <div class="row">
                @foreach ($files as $file)
                <div class="col-lg-3 col-md-6">
                    <div class="card">
                        <div class="row">
                            <div class="col-12">
                                <div class="social-widget">
                                    <div class="soc-header box-facebook">
                                        <i class="fa fa-file-text" style="font-size: 2em"></i>
                                        <h3 class="text-white">{{ $file['name'] }}</h3>
                                    </div>
                                    <div class="soc-content">
                                        <div class="col-4 b-r">
                                            <button class="btn btn-success btn-block" wire:click="show_data('{{ $file['path'] }}')"><i class="fa fa-eye"></i></button>
                                        </div>
                                        <div class="col-4">
                                            <button class="btn btn-info btn-block" wire:click="download('{{ $file['path'] }}')"><i class="fa fa-download"></i></button>
                                        </div>
                                        <div class="col-4">
                                            <button class="btn btn-primary btn-block" wire:click="downloadExcel('{{ $file['path'] }}', '{{ $file['name'] }}')"><i class="fa fa-file-excel-o"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
                <hr>
                @if ($content_file == true)
                     <pre style="height:800px">
                          {!!  nl2br(Storage::disk('public_cobra')->get($file_data)) !!}
                     </pre>
                @endif
            </div>
            @endif
        </div>
    </div>
</div>
@section('script')
<script>
window.addEventListener('alert', event => { 
    toastr[event.detail.type](event.detail.message, 
    event.detail.title ?? ''), toastr.options = {
        "closeButton": true,
        "progressBar": true,
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
