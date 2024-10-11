<style>
    .fondomodal_mx {
        /*background-image: url(https://external-content.duckduckgo.com/iu/?u=https%3A%2F%2Fmexico10.com%2Fwp-content%2Fuploads%2F2020%2F03%2Fmazatlan-sinaloa-min.jpg&f=1&nofb=1);*/
        color: black;
        /*display: block;*/
        margin-left: auto;
        margin-right: auto;
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
    }

    .fondomodal_mx .overlay_h {
        background: rgba(0, 0, 0, 0.23);
    }

    .modal-title {
        color: white;
    }
    .overlay_h {
        opacity: .3; 
    }
</style>
<div aria-hidden="true" aria-labelledby="exampleModalLabel" class="modal fade mt-5 pt-5 mb-5 pb-5" data-backdrop="static" data-keyboard="false" id="moda_pre_registro_mx" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="fondomodal_mx">
                <div class="overlay_h">
                </div>
                <div class="modal-header">
                    <h5 class="modal-title text-info" id="exampleModalLabel">
                        Pre-registro
                    </h5>
                    <button aria-label="Close" class="close" data-dismiss="modal" type="button">
                        <span aria-hidden="true">
                            ×
                        </span>
                    </button>
                </div>
                <form id="form_register_alert_mx">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12 mb-2">
                                <small class="text-info">
                                    Bienvenido al gran beneficio que tu empresa ha extendido para ti. Ahora estás listo para disfrutar de la gran aventura en México, un maravilloso crucero o el resto del mundo. Este beneficio es exclusivo para las compañías afiliadas, proporciona tu información para comenzar.
                                </small>
                            </div>
                            <div class="col-md-12">
                                <div class="form-row">
                                    <div class="form-group col-lg-6 col-md-6">
                                        <label for="inputEmail4">
                                            Nombre
                                        </label>
                                        <input class="form-control" id="nombre" name="nombre" placeholder="Nombre (s)" type="text">
                                        </input>
                                        <span class="text-danger error-nombre errors">
                                        </span>
                                    </div>
                                    <div class="form-group col-lg-6 col-md-6">
                                        <label for="inputPassword4">
                                            Apellido (s)
                                        </label>
                                        <input class="form-control" id="apellidos" name="apellidos" placeholder="Apellido (s)" type="text">
                                        </input>
                                        <span class="text-danger error-apellidos errors">
                                        </span>
                                    </div>
                                    <div class="form-group col-lg-6 col-md-6">
                                        <label for="inputEmail4">
                                            Teléfono
                                        </label>
                                        <input class="form-control" id="telefono" name="telefono" placeholder="Teléfono" type="text">
                                        </input>
                                        <span class="text-danger error-telefono errors">
                                        </span>
                                    </div>
                                    <div class="form-group col-lg-6 col-md-6">
                                        <label for="inputPassword4">
                                            Correo electrónico
                                        </label>
                                        <input class="form-control" id="username" name="username" placeholder="example@mail.com" type="text">
                                        </input>
                                        <span class="text-danger error-username errors">
                                        </span>
                                    </div>
                                    <div class="form-group col-md-12 mt-2">
                                        {!! NoCaptcha::renderJs() !!}
                                        {!! NoCaptcha::display() !!}
                                        <span class="text-danger error-g-recaptcha-response errors">
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary btn-sm" data-dismiss="modal" type="button">
                            Cerrar
                        </button>
                        <button class="btn btn-primary btn-sm" id="submit" type="submit">
                            Enviar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
