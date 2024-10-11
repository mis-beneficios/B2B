<div class="row">
    <div class="col-lg-12">
        {{-- <form action="{{ route('zoom.store') }}" class="" id="formMeeting" method="post"> --}}
            <div class="form-group row">
              <label for="example-text-input" class="col-2 col-form-label">Tema</label>
              <div class="col-10">
                 <input type="text" name="topic" class="form-control" id="topic" placeholder="Tema">
                <span class="text-danger error-topic errors"></span>
              </div>
            </div>
            <div class="form-group row">
              <label for="example-search-input" class="col-2 col-form-label">Descripción</label>
              <div class="col-10">
                <textarea name="agenda" id="agenda" rows="4" class="form-control" placeholder="Descripcion"></textarea>
                <span class="text-danger error-agenda errors"></span>
              </div>
            </div>
            <div class="form-group row">
                <label for="example-email-input" class="col-2 col-form-label">Fecha</label>
                <div class="col-3">
                    <input type="text" class="form-control datepicker" id="start_date" name="start_date" placeholder="Fecha">
                    <span class="text-danger error-start_date errors"></span>
                </div>
                <div class="col-3">
                   <div class="input-group bootstrap-timepicker timepicker">
                        <input id="start_time" name="start_time" type="text" class="form-control input-small timepicker">
                    </div>
                    <span class="text-danger error-start_time errors"></span>
                </div>
            </div>
            <div class="form-group row">
              <label for="example-url-input" class="col-2 col-form-label">Duración</label>
              <div class="col-10">
                <div class="row ">
                    <div class="col-sm-5 form-inline">
                        <select name="duration_h" id="duration_h" class="form-control mr-2">
                            @for($i = 0; $i <= 24; $i++)
                                <option value="{{$i * 60}}">{{$i}}</option>
                            @endfor
                        </select>
                        <label for="">Hras</label>
                         <span class="text-danger error-duration_h errors"></span>
                    </div>
                    <div class="col-sm-5 form-inline">
                        <select name="duration_m" id="duration_m" class="form-control mr-2">
                            <option value="">0</option>
                            @for($i = 15; $i <= 59; $i+=15)
                                <option value="{{$i}}">{{$i}}</option>
                            @endfor
                        </select>
                        <label for="">Min</label>
                         <span class="text-danger error-duration_m errors"></span>
                    </div>
                </div>
              </div>
            </div>
            <div class="form-group row">
              <label for="example-tel-input" class="col-2 col-form-label">Zona horaria</label>
              <div class="col-10">
                <select name="timezone" id="timezone" class="form-control">
                    <option value="America/Mexico_City">America/Mexico_City</option>
                </select>
                 <span class="text-danger error-timezone errors"></span>
              </div>
            </div>
            <div class="form-group row">
              <label for="example-password-input" class="col-2 col-form-label">Contraseña</label>
              <div class="col-10">
                 <input type="text" name="password" class="form-control" id="password" placeholder="Contraseña">
                  <span class="text-danger error-password errors"></span>
              </div>
            </div>
            <div class="form-group row">
              <label for="example-number-input" class="col-2 col-form-label">Vídeo anfitrión</label>
              <div class="col-10">
                <div class="demo-radio-button">
                    <input name="host_video" type="radio" id="radio_1" checked="" value="true">
                    <label for="radio_1">Encendido</label>
                    <input name="host_video" type="radio" id="radio_2" value="false">
                    <label for="radio_2">Apagado</label>
                </div>
              </div>
            </div>
            <div class="form-group row">
              <label for="participant_video" class="col-2 col-form-label">Vídeo participante</label>
              <div class="col-10">
                <div class="demo-radio-button">
                    <input name="participant_video" type="radio" id="radio_p1" checked="" value="true">
                    <label for="radio_p1">Encendido</label>
                    <input name="participant_video" type="radio" id="radio_p2" value="false">
                    <label for="radio_p2">Apagado</label>
                </div>
              </div>
            </div>
            <div class="form-group row">
              <label for="example-datetime-local-input" class="col-2 col-form-label">Opciones de la reunión</label>
              <div class="col-10">
                <div class="demo-checkbox">
                    <input type="checkbox" id="join_before_host" name="join_before_host" class="filled-in">
                    <label for="join_before_host">Habilitar entrar antes que el anfitrión</label>
                    <br>
                    <input type="checkbox" id="mute_upon_entry" name="mute_upon_entry" class="filled-in">
                    <label for="mute_upon_entry">Silenciar participantes al entrar</label>
                    <br>
                    <input type="checkbox" id="waiting_room" name="waiting_room" class="filled-in" checked>
                    <label for="waiting_room">Habilitar la sala de espera</label>
                    <br>
                </div>
              </div>
            </div>
            <div class="form-group row">
              <label for="example-date-input" class="col-2 col-form-label">Grabar reunión</label>
              <div class="col-10">
                 <div class="demo-radio-button">
                    <input name="auto_recording" type="radio" id="auto_recording1" checked="" value="none">
                    <label for="auto_recording1">No grabar la reunión</label>
                    <br>
                    <input name="auto_recording" type="radio" id="auto_recording2" value="local">
                    <label for="auto_recording2">Grabe la reunión automáticamente en la computadora local</label>
                    <br>
                    <input name="auto_recording" type="radio" id="auto_recording3" value="cloud">
                    <label for="auto_recording3">Grabe la reunión automáticamente en la nube</label>
                </div>
              </div>
            </div>
           {{--  <div class="form-group row">
              <label for="example-month-input" class="col-2 col-form-label">Compartir con</label>
              <div class="col-10">
                 <div class="demo-radio-button">
                    <input name="compartir" type="radio" id="compartir1"  value="1">
                    <label for="compartir1">No grabar la reunión</label>
                    <br>
                    <input name="compartir" type="radio" id="compartir2" value="2" checked="">
                    <label for="compartir2">Grabe la reunión automáticamente en la computadora local</label>
                </div>
              </div>
            </div> --}}
            <hr>
            <div class="form-actions">
                <div class="row">
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-md-offset-3 col-md-9">
                                <button type="submit" class="btn btn-success">Guardar</button>
                                <button type="button" class="btn btn-inverse" data-dismiss="modal" aria-label="Close">Cancelar</button>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6"> </div>
                </div>
            </div>
        {{-- </form> --}}
    </div>
</div>