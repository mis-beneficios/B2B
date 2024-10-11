@extends('layouts.admin.app')
@section('content')
<div class="row page-titles">
    <div class="col-md-5 col-8 align-self-center">
        <h3 class="text-themecolor">
            <a href="{{ route('dashboard') }}">
                Dashboard
            </a>
        </h3>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('dashboard') }}">
                    Home
                </a>
            </li>
            <li class="breadcrumb-item active">
                Manual de usuarios rol: convenios
            </li>
        </ol>
    </div>
</div>
<style>
    iframe {
    display: block;       /* iframes are inline by default */
    background: #000;
    border: none;         /* Reset default border */
    height: 100vh;        /* Viewport-relative units */
    width: 100vw;
}
</style>
<div class="row">
    <div class="col-lg-12 col-md-12">
        <iframe class="form-control" frameborder="0" height="100%" src="{{ asset('files/manual_convenios.pdf') }}" style="overflow:hidden;overflow-x:hidden;overflow-y:hidden;height:1500px;width:100%;position:absolute;top:0px;left:0px;right:0px;bottom:0px" width="100%">
        </iframe>
    </div>
</div>
@endsection
