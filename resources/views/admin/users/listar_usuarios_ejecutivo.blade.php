@extends('layouts.admin.app')
@section('content')
@livewireStyles
@livewireScripts
<div class="row page-titles">
    <div class="col-md-5 col-8 align-self-center">
        <h3 class="text-themecolor">
            <a href="{{ route('dashboard') }}">
                Usuarios
            </a>
        </h3>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('dashboard') }}">
                    Home
                </a>
            </li>
            <li class="breadcrumb-item active">
                Usuarios registrados
            </li>
        </ol>
    </div>
</div>
@livewire('user.clientes-ejecutivo', ['user_id' => $user_id])
@endsection
{{-- 

@section('script')
<script>
    $(document).ready(function() {
        var tabla = $('#table_usuarios').DataTable({
            'responsive': true,
            'searching': true,
            'lengthMenu': [[10, 50, -1], [10, 50, "Todo"]],
            'pageLength': 10,
            "aoColumns": [{
                "mData": "0"
                }, {
                "mData": "1"
                },{
                "mData": "2"
                }, {
                "mData": "3"
                }, {
                "mData": "4"
                }
            ],
            "ajax": {
                url: baseuri + "admin/listar-usuarios/{{ $user_id }}",
                type: "get",
                dataType: "json",
                error: function(e) {
                  console.log(e.responseText);
                }
            },
        });


       
    });
</script>
@endsection
 --}}