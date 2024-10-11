@if (Auth::id() == 691650)
<div class="card ">
    <div class="card-body">
        <small class="text-muted">
            {{ __('messages.user.show.username') }}:
        </small>
        <h6>
            {{ $user->username }}
        </h6>
        <small class="text-muted">
            {{ __('messages.login.contrasena') }}:
        </small>
        <h6>
            {{ (isset($user->clave)) ? base64_decode($user->clave) : 'S/R' }}
        </h6>
    </div>
</div>
@endif
