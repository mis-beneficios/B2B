<div class="row">
  <div class="col-sm-12">
    @if ($meeting['success'] === true)
      <div id="text_info_meeting">
          <div class="form-group row">
              <label for="example-text-input" class="col-2 col-form-label">Tema</label>
              <div class="col-10">
                  {{ $meeting['data']['topic'] }}
              </div>
          </div>
          <div class="form-group row">
              <label for="example-search-input" class="col-2 col-form-label">Agenda</label>
              <div class="col-10">
                  {{ $meeting['data']['agenda'] }}
              </div>
          </div>
          <div class="form-group row">
              <label for="example-email-input" class="col-2 col-form-label">Fecha de inicio</label>
              <div class="col-10">
                {{ \Carbon\Carbon::create($meeting['data']['start_time'])->format('Y-m-d h:i A') }}
              </div>
          </div>
          <div class="form-group row">
              <label for="example-url-input" class="col-2 col-form-label">Seguridad</label>
              <div class="col-10">
                <ul class="list-unstyled">
                  <li>
                    ID de meeting: <a href="#">{{ $meeting['data']['id'] }}</a>
                  </li>
                  <li>
                    Clave de acceso:  <a href="#">{{ $meeting['data']['password'] }}</a>
                  </li>
                </ul>
              </div>
          </div>
          <div class="form-group row">
              <label for="example-tel-input" class="col-2 col-form-label">Unirse</label>
              <div class="col-10">
                  <a href="{{ $meeting['data']['join_url'] }}" target="_blank">
                    {{ $meeting['data']['join_url'] }}
                  </a>
              </div>
          </div>
      </div>
    @else
    No existe la reunion seleccionada
    @endif

{{-- 
      <div  id="text_info_meeting_v1" style="display: block;">        
        <ul class="list-unstyled">
          <li>
            <b>Tema:</b> {{ $meeting['data']['topic'] }}
          </li>
          <li>
            <b>Agenda:</b> {{ $meeting['data']['agenda'] }}
          </li>
          <li>
            <b>Fecha de inicio:</b>  {{ \Carbon\Carbon::create($meeting['data']['start_time'])->format('Y-m-d h:i A') }}
          </li>
          <li>
            <b>Seguridad: </b>
              <ul class="list-unstyled ml-4">
                <li>
                  <b>ID de meeting:</b> <a href="#">{{ $meeting['data']['id'] }}</a>
                </li>
                <li>
                  <b>Clave de acceso:</b>  <a href="#">{{ $meeting['data']['password'] }}</a>
                </li>
              </ul>
          </li>
          <li>
            <b>Unirse:</b>  
            <a href=" {{ $meeting['data']['join_url'] }}" target="_blank">
               {{ $meeting['data']['join_url'] }}
            </a>
          </li>
        </ul>
      </div> --}}
      <div class="modal-footer">
        @if ($meeting['success'] == true)
        <a href="{{ $meeting['data']['start_url'] }}" target="_blank" class="btn btn-info btn-sm">Iniciar</a>
        <button class="btn btn-dark btn-sm" id="copyZoom">Copiar invitación</button>
        @endif
        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Cerrar</button>
      </div>
  </div>
</div>
