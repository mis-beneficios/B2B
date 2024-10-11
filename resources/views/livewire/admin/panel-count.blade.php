<div>
    <div class="card">
        <div class="card-body">
            <a href="{{ $route }}">
                <div class="d-flex flex-row">
                    <div class="round round-lg align-self-center {{ $color }}">
                        <i class="{{ $icon }}">
                        </i>
                    </div>
                    <div class="m-l-10 align-self-center">
                        <h3 class="m-b-0 font-light">
                            {{-- {{ $panel['por_autorizar'] }} --}}
                            {{ $total }}
                        </h3>
                        <h5 class="text-muted m-b-0">
                            {{ $title }}
                        </h5>
                    </div>
                </div>
            </a>
        </div>
    </div>
</div>

<script>
    // setInterval(function () {
    //     @this.call('render');
    // }, 5000); 
</script>