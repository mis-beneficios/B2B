<div>
    <div class="row">
        <div class="col-lg-2">
            <button wire:click="render">Refresh</button>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-6">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Enganches - Hoy</h4>
                    <h3>
                       Total: ${{ number_format($pagos_hoy, 2,'.',',') }} MXN
                    </h3>
                    <div class="d-flex flex-row">
                     {{--    <div class="p-10 p-l-0 b-r">
                            <h6 class="font-light">$ Total</h6>
                            <b>
                                ${{ number_format($pagos_total, 2,'.',',') }} MXN
                            </b>
                        </div> --}}
                        <div class="p-10 b-r">
                            <h6 class="font-light">$ Pagables</h6>
                            <b>
                                ${{ number_format($pagos_pagados_hoy, 2,'.',',') }} MXN
                            </b>
                        </div>
                        <div class="p-10">
                            <h6 class="font-light">$ Pendiente</h6>
                            <b>
                                ${{ number_format($pagos_pendientes_hoy, 2,'.',',') }} MXN
                            </b>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
