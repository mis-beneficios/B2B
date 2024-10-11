 <div aria-hidden="true" aria-labelledby="modalNotificacion" class="modal fade" data-backdrop="static" id="modalNotificacion" tabindex="-1">
            <div class="modal-dialog modal-xl modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalNotificacionLabel">
                            Búsqueda avanzada
                        </h5>
                        <button aria-label="Close" class="close" data-dismiss="modal" type="button">
                            <span aria-hidden="true">
                                ×
                            </span>
                        </button>
                    </div>
                    <div class="modal-body table-responsive">
                        <h2>Nuevos prefijos de búsqueda avanzada</h2>
                        <p>
                            Para poder localizar distintos datos se ha implementado una actualización en la búsqueda con un prefijo para localizar el tipo y nivel de dato que se quiere obtener:
                        </p>
                        <p>
                            Los prefijos a utilizar son:
                        </p>
                        <ul>
                            <li>
                                <b class="text-danger">f: (f dos puntos)</b> mediante este prefijo podemos realizar la búsqueda unicamente comparando el texto ingresado a el <b class="text-danger">folio</b> del contrato almacenado en base de datos, dando como resultado el folio exacto localizado.
                                <br/>
                                Ejemplo:
                                <br/>
                                <br/>
                                <img src="{{ asset('images/admin/f.png') }}" alt="">
                            </li>
                            <li class="mt-4">
                                <b class="text-danger">t: (t dos puntos)</b> mediante este prefijo podemos realizar la búsqueda unicamente comparando el texto ingresado a la <b class="text-danger">tarjeta</b> de cliente almacenado en base de datos, dando como resultado el usuario exacto al cual le corresponde la tarjeta (método de pago).
                                <br/>
                                Ejemplo:
                                <br/>
                                <br/>
                                <img src="{{ asset('images/admin/t.png') }}" alt="">
                            </li>
                            <li class="mt-4">
                                <b class="text-danger">r: (r dos puntos)</b> mediante este prefijo podemos realizar la búsqueda  comparando el texto ingresado a la reservación en su campo <b class="text-danger">"nombre de quien sera la reservación"</b> de un cliente almacenado en base de datos, dando como resultado el usuario exacto de quien corresponde la reservación.
                                <br/>
                                Ejemplo:
                                <br/>
                                <br/>
                                <img class="img-thumbnail" src="{{ asset('images/admin/r.png') }}" alt="">
                                <img class="img-thumbnail" src="{{ asset('images/admin/r_2.png') }}" alt="">
                                <img class="img-thumbnail" src="{{ asset('images/admin/r_3.png') }}" alt="">
                            </li>
                            <li class="mt-4">
                                <b class="text-danger">n: (n dos puntos)</b> mediante este prefijo podemos realizar la búsqueda  comparando el texto ingresado al  <b class="text-danger">id</b> de la reservacion  de un cliente almacenado en base de datos, dando como resultado el usuario exacto de quien corresponde la reservacion.
                                <br/>
                                Ejemplo:
                                <br/>
                                <br/>
                                <img class="img-thumbnail" src="{{ asset('images/admin/n.png') }}" alt="">
                            </li>
                            <li class="mt-4">
                                <b class="text-danger">c: (c dos puntos)</b> mediante este prefijo podemos realizar la búsqueda  comparando el texto ingresado a la <strong class="text-danger">clave</strong> de la reservacion de un cliente almacenado en base de datos, dando como resultado el usuario exacto de quien corresponde la reservacion.
                                <br/>
                                Ejemplo:
                                <br/>
                                <br/>
                                <img class="img-thumbnail" src="{{ asset('images/admin/c.png') }}" alt="">
                            </li>

                            <li class="mt-4">
                                <b class="text-danger">u: (u dos puntos)</b> mediante este prefijo podemos realizar la búsqueda  comparando el texto ingresado al <strong class="text-danger">nombre, apellidos, teléfono, teléfono casa, teléfono oficina y correo electrónico</strong> del cliente almacenado en base de datos, dando como resultado el usuario exacto del usuario ingresado.
                                <br/>
                                Ejemplo:
                                <br/>
                                <br/>
                                <img class="img-thumbnail" src="{{ asset('images/admin/u.png') }}" alt="">
                                <img class="img-thumbnail" src="{{ asset('images/admin/u_2.png') }}" alt="">
                                <img class="img-thumbnail" src="{{ asset('images/admin/u_3.png') }}" alt="">
                            </li>
                            <li class="mt-4">
                                <b class="text-danger">Numérico:</b> en caso de no ingresar ningún prefijo y el texto ingresado a la búsqueda es numérico, el sistema tomara como referencia la búsqueda por <b class="text-danger">folio y teléfono del cliente</b> el cual se buscara en base a "si coincide con el dato ingresa" (búsqueda ambigua, pueden salir mas de 1 registro si existe el caso).
                                <br/>
                                Ejemplo:
                                <br/>
                                <br/>
                                <img class="img-thumbnail" src="{{ asset('images/admin/libre.png') }}" alt="">
                                <img class="img-thumbnail" src="{{ asset('images/admin/libre_1.png') }}" alt="">
                            </li>
                            <li class="mt-4">
                                <b class="text-danger">Alfanumérico:</b> en caso de no ingresar ningún prefijo y el texto ingresado a la búsqueda es alfanumérico, el sistema tomara como referencia la búsqueda por <b class="text-danger">nombre, apellidos y correo electrónico</b> el cual se buscara en base a "si coincide con el dato ingresa" (búsqueda ambigua, pueden salir mas de 1 registro si existe el caso).
                                <br/>
                                Ejemplo:
                                <br/>
                                <br/>
                                <img class="img-thumbnail" src="{{ asset('images/admin/test.png') }}" alt="">
                                <img class="img-thumbnail" src="{{ asset('images/admin/test_2.png') }}" alt="">
                            </li>
                        </ul>

                        <p>
                            <b class="text-danger">Importante:</b> Al visualizar la información, se puede realizar una búsqueda adicional dentro de la tabla de resultados y si es el caso la paginacion de datos si excede el limite por vista.
                        </p>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" data-dismiss="modal" type="button">
                            Cerrar
                        </button>
                    </div>
                </div>
            </div>
        </div>