{{-- @extends('errors::minimal') --}}
@extends('errors::illustrated-layout')

@section('title', __('messages.Forbidden'))
@section('code', '403')
@section('message', __('messages.Forbidden'))
{{-- @section('message', __($exception->getMessage() ?: 'messages.Forbidden')) --}}
{{-- @section('image')
<img alt="" class="img-fluid" src="{{ asset('images/event_bg.png') }}">
</img>
@endsection --}}
