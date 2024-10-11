@extends('layouts.admin.app')
@section('content')
<style>
    button > .infoPago{
        display: none;
    }

    #btnPago:hover{
        /*background-color: red;*/
    }

    #btnPago:hover  > .infoPago{
        display: block;
    }
    .mytooltip:hover{
        position:relative;
    }
    .tooltip-text {
        font-size: 14px;
        line-height: 24px;
        display: block;
        padding: 1.31em 1.21em 1.21em 3em;
        color: #ffffff;
    }
    .btn{
        margin:3px;
    }
    .btnsmall {
        padding: 0.15rem 0.2rem;
        font-size: 10px;
    }
</style>
@livewire('cobranza.terminal')
{{-- @livewire('cobranza.filtrado-termial') --}}
@endsection