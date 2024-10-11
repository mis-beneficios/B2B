<div class="form-body">
    <div class="row p-t-10">
        <div class="col-lg-4 col-md-4">
            <div class="form-group">
                <label class="control-label">
                    Nombre
                </label>
                <input class="form-control" id="title" name="title" type="text" value="{{ ($estancia) ? $estancia->title : '' }}">
                </input>
                <span class="text-danger error-title errors">
                </span>
            </div>
        </div>
        <div class="col-lg-1 col-md-1">
            <div class="form-group ">
                <label class="control-label">
                    Precio
                </label>
                <input class="form-control form-control" id="precio" name="precio" type="text" value="{{ ($estancia) ? $estancia->precio : '' }}">
                    <small class="form-control-feedback">
                    </small>
                </input>
                <span class="text-danger error-precio errors">
                </span>
            </div>
        </div>
        <div class="col-lg-2 col-md-2">
            <div class="form-group has-success">
                <label class="control-label">
                    Divisa
                </label>
                <select class="form-control select2 select2-hidden-accessible custom-select" id="divisa" name="divisa" style="width: 95%;">
                    <option value="">
                        Selecciona un divisa
                    </option>
                    @foreach ($divisas as $key => $divisa)
                    <option value="{{ $key }}" @if ($estancia->divisa == $key) selected @endif>
                        {{ $divisa }}
                    </option>
                    @endforeach
                </select>
                <br/>
                <span class="text-danger error-divisa errors">
                </span>
            </div>
        </div>
        <div class="col-lg-1 col-md-1 col-sm-6">
            <div class="form-group">
                <label class="control-label">
                    Descuento
                </label>
                <input autocomplete="off" class="form-control" placeholder="%" id="descuento" name="descuento" type="text" value="{{ ($estancia) ? $estancia->descuento : '' }}">
                    <small class="form-control-feedback">
                    </small>
                </input>
                <span class="text-danger error-descuento errors">
                </span>
            </div>
        </div>
        <div class="col-lg-1 col-md-1 col-sm-6">
            <div class="form-group ">
                <label class="control-label">
                    Noches
                </label>
                <input class="form-control form-control" id="noches" name="noches" placeholder="1" type="text" value="{{ ($estancia) ? $estancia->noches : '' }}">
                    <small class="form-control-feedback">
                    </small>
                </input>
                <span class="text-danger error-noches errors">
                </span>
            </div>
        </div>
        <div class="col-lg-1 col-md">
            <div class="form-group ">
                <label class="control-label">
                    Adultos
                </label>
                <input class="form-control form-control" id="adultos" name="adultos" placeholder="1" type="text" value="{{ ($estancia) ? $estancia->adultos : '' }}">
                    <small class="form-control-feedback">
                    </small>
                </input>
                <span class="text-danger error-adultos errors">
                </span>
            </div>
        </div>
        <div class="col-lg-1 col-md">
            <div class="form-group ">
                <label class="control-label">
                    Niños
                </label>
                <input class="form-control form-control" id="ninos" name="ninos" placeholder="1" type="text" value="{{ ($estancia) ? $estancia->ninos : '' }}">
                    <small class="form-control-feedback">
                    </small>
                </input>
                <span class="text-danger error-ninos errors">
                </span>
            </div>
        </div>
        <div class="col-lg-2 col-md">
            <div class="form-group ">
                <label class="control-label">
                    Edad max. de niños
                </label>
                <input class="form-control form-control" id="edad_max_ninos" name="edad_max_ninos" placeholder="11" type="text" value="{{ ($estancia) ? $estancia->edad_max_ninos : '' }}">
                    <small class="form-control-feedback">
                    </small>
                </input>
                <span class="text-danger error-edad_max_ninos errors">
                </span>
            </div>
        </div>
        <div class="col-lg-2 col-md">
            <div class="form-group ">
                <label class="control-label">
                    Precio por niño
                </label>
                <input class="form-control form-control" id="precio_por_nino" name="precio_por_nino" type="text"  placeholder="Precio por niño" value="{{ ($estancia) ? $estancia->precio_por_nino : '' }}">
                    <small class="form-control-feedback">
                    </small>
                </input>
                <span class="text-danger error-precio_por_nino errors">
                </span>
            </div>
        </div>
        <div class="col-lg-2 col-md">
            <div class="form-group ">
                <label class="control-label">
                    Precio por adulto
                </label>
                <input class="form-control form-control" id="precio_por_adulto" name="precio_por_adulto"  placeholder="Precio por adulto" type="text" value="{{ ($estancia) ? $estancia->precio_por_adulto : '' }}">
                    <small class="form-control-feedback">
                    </small>
                </input>
                <span class="text-danger error-precio_por_adulto errors">
                </span>
            </div>
        </div>
        <div class="col-lg-2 col-md-2 col-sm">
            <div class="form-group has-success">
                <label class="control-label">
                    No. de segmentos
                </label>
                <input type="text" value="{{ $estancia->cuotas }}" class="form-control" id="cuotas" name="cuotas"/>
               {{--  <select class="form-control select2 select2-hidden-accessible custom-select" id="convenio_id" name="convenio_id" style="width: 95%;">
                    <option value="">
                        Selecciona un cuota
                    </option>
                     @foreach ($cuotas as $key => $cuota)
                    <option value="{{ $key }}" @if ($estancia->cuotas == $key) selected @endif>
                        {{ $cuota }}
                    </option>
                    @endforeach
                </select>
                <br/> --}}
                <span class="text-danger error-cuotas errors">
                </span>
            </div>
        </div>


        <div class="col-lg-2 col-md-2">
            <div class="form-group has-success">
                <label class="control-label">
                    Tipo de registro
                </label>
                <select class="form-control select2 select2-hidden-accessible custom-select" id="tipo" name="tipo" style="width: 95%;">
                    <option value="">
                        Selecciona un tipo
                    </option>
                    @foreach ($tipo_estancia as $key => $est)
                    <option value="{{ $key }}" @if ($key == $estancia->tipo) selected @endif>
                        {{ $est }}
                    </option>
                    @endforeach
                </select>
                <br/>
                <span class="text-danger error-tipo errors">
                </span>
            </div>
        </div>

        <div class="col-lg-2 col-md-2 col-sm">
            <div class="form-group has-success">
                <label class="control-label">
                    Pais
                </label>
                <select class="form-control select2 select2-hidden-accessible custom-select" id="estancia_paise_id" name="estancia_paise_id" style="width: 95%;">
                    <option value="">
                        Selecciona el pais
                    </option>
                    @foreach ($paises as  $pais)
                    <option value="{{ $pais->id }}" @if ($estancia->estancia_paise_id == $pais->id) selected @endif>
                        {{ $pais->title }}
                    </option>
                    @endforeach
                </select>
                <br/>
                <span class="text-danger error-estancia_paise_id errors">
                </span>
            </div>
        </div>

        <div class="form-group col-md-2 mt-4">
            <div class="form-check">
                <input class="form-check-input" id="estancia_especial" name="estancia_especial" type="checkbox" value="1" {{ ($estancia) ? ($estancia->estancia_especial == 1) ?'checked' : '' : '' }}>
                    <label class="form-check-label" for="estancia_especial">
                        Estancia especial
                    </label>
                </input>
            </div>
        </div>
        <div class="col-lg-2 col-md">
            <div class="form-group ">
                <label class="control-label">
                    Enganche
                </label>
                <input class="form-control form-control" id="enganche_especial" name="enganche_especial" type="text"  placeholder="$" value="">
                    <small class="form-control-feedback">
                    </small>
                </input>
                <span class="text-danger error-enganche_especial errors">
                </span>
            </div>
        </div>
        <div class="col-lg-3 col-md-3 col-sm">
            <div class="form-group has-success">
                <label class="control-label">
                    Convenio asociado
                </label>
                <select class="form-control select2 select2-hidden-accessible custom-select" id="convenio_id" name="convenio_id" style="width: 95%;">
                    <option value="">
                        Selecciona un convenio
                    </option>
                    @foreach ($convenios as $key => $convenio)
                    <option value="{{ $convenio->id }}" @if ($estancia->convenio_id == $convenio->id) selected @endif>
                        {{ $convenio->empresa_nombre }}
                    </option>
                    @endforeach
                </select>
                <br/>
                <span class="text-danger error-convenio_id errors">
                </span>
            </div>
        </div>
        <div class="col-lg-2 col-md">
            <div class="form-group ">
                <label class="control-label">
                    Contrato
                </label>
                <br/>
                <button class="btn btn-info btn-sm" type="button" data-toggle="modal" data-target="#modalContrato">
                    Editar contrato
                </button>
            </div>
        </div>
        
        <div class="col-md-12">
            <div class="row">
                <div class="form-group col-md-2 mt-4">
                    <div class="form-check">
                        <input class="form-check-input" id="habilitada" name="habilitada" type="checkbox" {{ ($estancia) ? ($estancia->habilitada == 1) ?'checked' : '' : '' }} value="1">
                            <label class="form-check-label" for="habilitada">
                                Habilitada
                            </label>
                        </input>
                    </div>
                </div>

                <div class="form-group col-md-2 mt-4">
                    <div class="form-check">
                        <input class="form-check-input" id="solosistema" name="solosistema" type="checkbox" {{ ($estancia) ? ($estancia->solosistema == 1) ?'checked' : '' : '' }} value="1">
                            <label class="form-check-label" for="solosistema">
                                Solo sistema
                            </label>
                        </input>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-6">
                    <div class="col-lg col-md">
                        <div class="form-group ">
                            <label class="control-label">
                                Descripción
                            </label>
                            <textarea autocomplete="off" class="form-control form-control" id="descripcion" name="descripcion" rows="40">
                                {!! $estancia->descripcion !!}
                            </textarea>
                            <span class="text-danger error-descripcion errors">
                            </span>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="col-lg-12">    
                        <div class="form-group">
                            <label class="control-label">
                                Imagen principal
                            </label>
                            <input type="file" class="form-control" name="imagen_de_reemplazo" id="imagen_de_reemplazo"/>
                            <br/>
                            <span class="text-danger error-imagen_de_reemplazo errors">
                            </span>
                        </div> 
                    </div>
{{--                     <div class="col-lg-12">    
                        <div class="form-group">
                            <label class="control-label">
                                Slide
                            </label>
                            <input type="file" class="form-control" name="slide" id="slide"/>
                            <br/>
                            <span class="text-danger error-slide errors">
                            </span>
                        </div>
                    </div> --}}
                    <div class="col-lg-12">    
                        <div class="form-group">
                            <label class="control-label">
                                Imagen producto
                            </label>
                            <input type="file" class="form-control" name="img_producto" id="img_producto"/>
                            <br/>
                            <span class="text-danger error-img_producto errors">
                            </span>
                        </div>
                    </div>
                    <div class="col-lg-12">    
                        <div class="form-group">
                            <label class="control-label">
                                Imagen descripción
                            </label>
                            <input type="file" class="form-control" name="img_descripcion" id="img_descripcion"/>
                            <br/>
                            <span class="text-danger error-img_descripcion errors">
                            </span>
                        </div>
                    </div>
                    <div class="col-lg-12">    
                        <div class="form-group">
                            <label class="control-label">
                                Imagen secundaria
                            </label>
                            <input type="file" class="form-control" name="img_secundaria" id="img_secundaria"/>
                            <br/>
                            <span class="text-danger error-img_secundaria errors">
                            </span>
                        </div>
                    </div>
                    <div class="col-lg-12">    
                        <div class="form-group">
                            <label class="control-label">
                                Imagen opcional
                            </label>
                            <input type="file" class="form-control" name="img_opcional" id="img_opcional"/>
                            <br/>
                            <span class="text-danger error-img_opcional errors">
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="modalContrato" tabindex="-1"   data-bs-backdrop="static"  role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
      <div class="modal-dialog modal-xl modal-dialog-scrollable" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLongTitle">Contrato</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
                <textarea class="" id="descripcion_formal" name="descripcion_formal" rows="4" cols="50">
                    {!! $estancia->descripcion_formal !!}
                </textarea>
                <span class="text-danger error-descripcion_formal errors">
                </span>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary btn-sm" data-toggle="modal" data-target="#modalContrato">Cerrar</button>
            <button type="button" class="btn btn-primary btn-sm" id="btnUpdateContrato">Guardar</button>
          </div>
        </div>
      </div>
    </div>

</div>