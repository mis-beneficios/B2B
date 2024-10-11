<div class="col-xl-12 mt-5" style="margin-bottom: -20px;">
    <div class="section_tittle" id="titulo">
        <h2 class="text-center">
            Step 2
        </h2>
        <p class="text-center">
            Provide your contact information.
        </p>
    </div>
</div>
<div class="col-md-10 offset-md-1">
    <div class="row" id="form_data">
        <div class="col-lg-4 col-md-6 col-sm-12 form-group">
            <label for="nombre">
                First Name
            </label>
            <input aria-describedby="Nombre" class="form-control error" id="nombre" name="nombre" placeholder="First Name" type="text" value="{{ request()->session()->get('nombre') }}">
                <span class="text-danger error-nombre errors">
                </span>
            </input>
        </div>
        <div class="col-lg-4 col-md-6 col-sm-12 form-group">
            <label for="apellidos">
                Last Name
            </label>
            <input aria-describedby="apellidos" class="form-control" id="apellidos" name="apellidos" placeholder="Last Name" type="text" value="{{ request()->session()->get('apellidos') }}">
                <span class="text-danger error-apellidos errors">
                </span>
            </input>
        </div>
        <div class="col-md-4 form-group">
            <label for="telefono">
                Phone
            </label>
            <input aria-describedby="telefono" class="form-control" id="telefono" name="telefono" placeholder="1234567890" type="text" value="{{ request()->session()->get('telefono') }}">
                <span class="text-danger error-telefono errors">
                </span>
            </input>
        </div>
        <div class="col-lg-4 col-md-8 form-group">
            <label for="username">
                Email
            </label>
            <input aria-describedby="username" class="form-control" id="username" name="username" placeholder="ejemplo@dominio.com" type="email" value="{{ request()->session()->get('username') }}">
                <span class="text-danger error-username errors">
                </span>
            </input>
        </div>
        <div class="col-lg-4 col-md-6 form-group">
            <label for="password">
                Password
            </label>
            <input aria-describedby="password" class="form-control" id="password" name="password" type="password">
                <span class="text-danger error-password errors">
                </span>
            </input>
        </div>
        <div class="col-lg-4 col-md-6 form-group">
            <label for="confirmar_password">
                Password Confirma
            </label>
            <input class="form-control" id="password_confirmation" name="password_confirmation" type="password">
            </input>
        </div>
        <div class="col-md-3 form-group">
            <label for="cp">
                Zipcode
            </label>
            <input aria-describedby="cp" class="form-control" id="cp" name="cp" placeholder="12345" type="text" value="{{ request()->session()->get('cp') }}">
                <span class="text-danger error-cp errors">
                </span>
            </input>
        </div>
        <div class="form-group col-md-4">
            <label for="cp">
                City
            </label>
            <input class="form-control" id="ciudad" name="ciudad" placeholder="City" type="text" value=""/>
            <span class="text-danger error-ciudad errors">
            </span>
        </div>
        <div class="form-group col-md-4">
            <label for="cp">
                State
            </label>
            <input class="form-control" id="estado" name="estado" placeholder="State" type="text" value=""/>
            <span class="text-danger error-estado errors">
            </span>
        </div>
        <div class="col-md-12 form-group">
            <label for="direccion">
                Adress
            </label>
            <input aria-describedby="direccion" class="form-control" id="direccion" name="direccion" placeholder="Adress" type="text" value="{{ request()->session()->get('direccion') }}">
                <span class="text-danger error-direccion errors">
                </span>
            </input>
        </div>
    </div>
</div>