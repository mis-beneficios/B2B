@extends('layouts.pagina.app')
@section('content')
<section class="top_place mt-5 mb-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-12">
                <iframe class="form-control" src="{{ asset('files/id.pdf') }}" style="height:1000px">
                </iframe>
            </div>
            <div class="col-xl-12">
                <iframe class="form-control" src="{{ asset('files/sectur.pdf') }}" style="height:1000px">
                </iframe>
            </div>
        </div>
    </div>
</section>
@endsection
