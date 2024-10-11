 <div aria-hidden="true" aria-labelledby="modalDescuento" class="modal fade" data-backdrop="static" id="modalDescuento" tabindex="-1">
            <div class="modal-dialog modal-xl modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalDescuentoLabel">
                            Aplicar descuento a folios
                        </h5>
                        <button aria-label="Close" class="close" data-dismiss="modal" type="button">
                            <span aria-hidden="true">
                                ×
                            </span>
                        </button>
                    </div>
                    <div class="modal-body table-responsive">
                        {{-- <h2>Nuevos prefijos de búsqueda avanzada</h2> --}}
                        <p>
                            Para aplicar el descuento definido por estancia, se realizar mediante la configuración de los segmentos, con el botón "aplicar descuento" el cual dependiendo la estancia, se encuentra ya definido el porcentaje % de descuento que se aplicara.
                        </p>
                        <img src="{{ asset('images/admin/d.png') }}" class="img-fluid" alt="">
                        <p class="mt-4">
                            Al seleccionar el boton "Aplicar descuento", mostrara una leyenda notificando que se aplicara el porcentaje % definido por la estancia y la vigencia que aplicara.
                        </p>
                        <img src="{{ asset('images/admin/d_2.png') }}" class="img-fluid" alt="">
                        <p  class="mt-4">
                            Los segmentos se reducirán a 24 por defecto calculando así el precio final aplicando el % de descuento.
                        </p>
                        <p>
                            Si se deshabilita esta opción de "Aplicar descuento", se notificara la acción a realzar.
                        </p>
                        <img src="{{ asset('images/admin/d_3.png') }}" class="img-fluid" alt="">
                        <p  class="mt-4">
                            Cambiando así nuevamente el numero de segmentos a 36 por defecto.
                        </p>

                        <p>
                            <b class="text-danger">Importante:</b>
                            ingresar los datos en el orden que se indica en pantalla
                        </p>
                        <ol>
                            <li>
                                Metodo de pago (periodo en el que se realizaran los cargos)
                            </li>
                            <li>
                                Fecha de inicio
                            </li>
                            <li>
                                Segmentos (Opcional)*
                            </li>
                            <li>
                                Aplicar descuento*
                            </li>
                        </ol>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" data-dismiss="modal" type="button">
                            Cerrar
                        </button>
                    </div>
                </div>
            </div>
        </div>