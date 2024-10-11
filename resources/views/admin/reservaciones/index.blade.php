@extends('layouts.admin.app')
@section('content')
<div class="row page-titles">
    <div class="col-md-5 col-8 align-self-center">
        <h3 class="text-themecolor text-capitalize">
            Bienvenid@: {{ Auth::user()->fullName }}
        </h3>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="javascript:void(0)">
                    Home
                </a>
            </li>
            <li class="breadcrumb-item active">
                Dashboard
            </li>
        </ol>
    </div>
</div>
<div class="row">
    <div class="col-lg-3 col-md-6">
        <div class="card">
            <div class="card-body">
                <a href="{{ asset('files/Manual_Reservaciones.pdf') }}" target="_blank">
                    <div class="d-flex flex-row">
                        <div class="round round-lg align-self-center round-success">
                            <i class="fas fa-file-pdf">
                            </i>
                        </div>
                        <div class="m-l-10 align-self-center">
                            <h5 class="text-muted m-b-0">
                                Manual de Reservaciones
                            </h5>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header">
                <div class="card-actions">
                    <a class="" data-action="collapse">
                        <i class="ti-minus">
                        </i>
                    </a>
                    <a class="btn-close" data-action="close">
                        <i class="ti-close">
                        </i>
                    </a>
                </div>
                <h4 class="card-title m-b-0">
                    Regiones
                </h4>
            </div>
            <div class="card-body">
                @foreach ($data as $d)
                <div class="card">
                    <div class="card-header">
                        <a href="{{ route('reservations.filtrados', $d->id) }}">
                            {{ $d->paise_title }}
                        </a>
                    </div>
                    <div class="card-body">
                        <h4 class="card-title">
                            {{ $d->title }}
                        </h4>
                        <a class="btn btn-dark btn-sm" href="{{ route('reservations.filtrados', $d->id) }}">
                            {{ $d->NC }} NC
                        </a>
                        <a class="btn btn-dark btn-sm" href="{{ route('reservations.filtrados', $d->id) }}">
                            {{ $d->NR }} NR
                        </a>
                        <a class="btn btn-dark btn-sm" href="{{ route('reservations.filtrados', $d->id) }}">
                            {{ $d->EP }} EP
                        </a>
                        <a class="btn btn-dark btn-sm" href="{{ route('reservations.filtrados', $d->id) }}">
                            {{ $d->CE }} CE
                        </a>
                        <a class="btn btn-dark btn-sm" href="{{ route('reservations.filtrados', $d->id) }}">
                            {{ $d->CA }} CA
                        </a>
                        <a class="btn btn-dark btn-sm" href="{{ route('reservations.filtrados', $d->id) }}">
                            {{ $d->PN }} PN
                        </a>
                        <a class="btn btn-dark btn-sm" href="{{ route('reservations.filtrados', $d->id) }}">
                            {{ $d->RE }} RE
                        </a>
                        <a class="btn btn-dark btn-sm" href="{{ route('reservations.filtrados', $d->id) }}">
                            {{ $d->OK }} OK
                        </a>
                        <a class="btn btn-dark btn-sm" href="{{ route('reservations.filtrados', $d->id) }}">
                            {{ $d->SG }} SG
                        </a>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    <div class="col-md-6">
         <div class="card">
            <div class="card-header">
                <div class="card-actions">
                    <a class="" data-action="collapse">
                        <i class="ti-minus">
                        </i>
                    </a>
                    <a class="btn-close" data-action="close">
                        <i class="ti-close">
                        </i>
                    </a>
                </div>
                <h4 class="card-title m-b-0">
                    Sin asignar
                </h4>
            </div>
            <div class="card-body table-responsive">
                <table class="table table-hover" id="sin_asignar" style="width:100%">
                    <thead>
                        <tr>
                            <th>
                                Folio
                            </th>
                            <th>
                                Cliente
                            </th>
                            <th>
                                Estatus
                            </th>
                            <th>
                                Destino
                            </th>
                            <th>
                                Opciones
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<!-- Modal -->
@include('admin.reservaciones.elementos.modal_reasignar')
@endsection
@section('script')
<script>
    $(document).ready(function() {

        $('#padre_id').select2({
             dropdownParent: $('#modalAsignarReservacion .modal-body')
        });
        
        var sin_asignar = $('#sin_asignar').DataTable({
            processing: true,
            serverSide: true,
            bDestroy: true,
            searching: false,
            bInfo: false,
            ajax: baseadmin + "reservaciones-sin-asignar",
            columns: [
                {data: 'id', name: 'id'},
                {data: 'nombre_add', name: 'nombre_add'},
                {data: 'email_add', name: 'email_add'},
                {data: 'destino_add', name: 'destino_add'},
                {data: 'actions', name: 'actions'},
            ],
        });

        // btnTomarReserva
        // btnAsignarReserva
        $(document).on('click', '#btnTomarReserva', function(event) {
            event.preventDefault();
            var id = $(this).data('reservacion_id');
            var user_id = $(this).data('user_id');
            alertify.confirm('Confirmar', '¿Desea tomar esta reservacion?', 
                function(){  
                    $.ajax({
                        url: baseadmin + 'tomar-reservacion/'+ id +'/'+user_id,
                        type: 'GET',
                        dataType: 'JSON',
                        beforeSend:function(){
                             $("#overlay").css("display", "block");
                        },
                        success:function(res){
                            if (res.success == true) {
                                toastr['success']('¡Registros exitoso!');
                                sin_asignar.ajax.reload();
                                asignadas.ajax.reload();
                            }else{
                                toastr['error']('Intentar mas tarde...')
                            }
                        }
                    })
                    .always(function() {
                         $("#overlay").css("display", "none");
                    });
                }
                , function(){});
        });

        $(document).on('click', '#btnAsignarReserva', function(event) {
            event.preventDefault();
            var id = $(this).data('reservacion_id');
            $('#reservacion_id').val(id);
            $('modalAsignarReservacion').modal('show');
            
        });
        $(document).on('submit', '#formAsignarReservacion', function(event) {
            event.preventDefault();
            $.ajax({
                url: baseadmin + 'asignar-reservacion',
                type: 'POST',
                dataType: 'JSON',
                data: $(this).serialize(),
                beforeSend:function(){
                    $("#overlay").css("display", "block");
                },
                success:function(res){
                    if (res.success == true) {
                        $('#modalAsignarReservacion').modal('hide');
                        toastr['success']('¡Registros exitoso!');
                        sin_asignar.ajax.reload();
                        asignadas.ajax.reload();
                    }else{
                        toastr['error']('Intentar mas tarde...')
                    }
                }
            })
            .fail(function() {
                console.log("error");
            })
            .always(function() {
                $("#overlay").css("display", "none");
            });
            
        });
    });
</script>
@stop
