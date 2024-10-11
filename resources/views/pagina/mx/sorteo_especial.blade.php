@extends('layouts.pagina.app')
@section('content')
@livewireStyles
@livewireScripts
@livewire('pagina.sorteo', ['llave'=> $sorteo->llave])
@endsection