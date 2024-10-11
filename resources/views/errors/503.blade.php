{{-- @extends('errors::minimal') --}}
@extends('errors::illustrated-layout')

@section('title', __('Service Unavailable'))
@section('code', '503')
@section('message', __($exception->getMessage() ?: 'Service Unavailable'))
{{-- @section('image')
<img alt="" class="img-fluid" src="{{ asset('images/logo_mb.jpg') }}" style="width: auto; height: auto%;">
    @endsection
</img>
--}}
