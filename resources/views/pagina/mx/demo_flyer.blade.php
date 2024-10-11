@extends('layouts.pagina.app')
@section('content')
<section class="top_place mt-5 mb-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-8">
                <img alt="" class="img-fluid" src="{{ asset('images/convenios/'. $tipo) }}">
                </img>
            </div>
        </div>
    </div>
</section>
@endsection
