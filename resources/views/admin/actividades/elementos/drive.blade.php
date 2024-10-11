
<div class="card-body">
    <h4 class="card-title">
        Actividades {{ $user->fullName }}
    </h4>
    <h6 class="card-subtitle">
        {{ $req['desde'] }} a {{ $req['hasta'] }}
    </h6>
    <ul class="search-listing">
        @foreach ($concals as $concal)
        <li>
            <h3>
                <a href="javacript:void(0)">
                    {{ $concal['empresa'] }}
                </a>
                    <div class="pull-right">
                        <button class="btn btn-sm btn-dark" id="logConcal" data-id="{{ $concal['id'] }}">
                            <i class="fas fa-info-circle"></i>
                        </button>
                    </div>
            </h3>
            <p style="font-zise:101px">
                {!! str_replace("\r\n", "<br>", $concal['observaciones']) !!}
               <!--   {{ $concal['observaciones'] }} -->
            </p>
        </li>
        @endforeach
    </ul>
</div>
