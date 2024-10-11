@extends('layouts.admin.app')
@section('content')
<div class="row page-titles">
    <div class="col-md-5 col-8 align-self-center">
        <h3 class="text-themecolor text-capitalize">
            <a href="{{ route('reservations.index') }}">
                Reservaciones
            </a>
        </h3>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('dashboard') }}">
                    Home
                </a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ route('users.show', $reservacion->user_id) }}">
                    Usuario: {{ $reservacion->cliente->fullName }}
                </a>
            </li>
            <li class="breadcrumb-item active">
                # {{ $reservacion->id }}
            </li>
        </ol>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body p-b-0">
                <h4 class="card-title">
                    Reservacion #{{ $reservacion->id }}
                </h4>
            </div>
            <!-- Nav tabs -->
            <ul class="nav nav-tabs customtab" role="tablist">
                <li class="nav-item">
                    <a aria-expanded="true" class="nav-link active" data-toggle="tab" href="#ver" role="tab">
                        <span class="hidden-sm-up">
                            <i class="ti-home">
                            </i>
                        </span>
                        <span class="hidden-xs-down">
                            Ver
                        </span>
                    </a>
                </li>
                <li class="nav-item">
                    <a aria-expanded="false" class="nav-link" data-toggle="tab" href="#editar" role="tab">
                        <span class="hidden-sm-up">
                            <i class="ti-user">
                            </i>
                        </span>
                        <span class="hidden-xs-down">
                            Editar
                        </span>
                    </a>
                </li>
                <li class="nav-item">
                    <a aria-expanded="false" class="nav-link" data-toggle="tab" href="#ajustes" role="tab">
                        <span class="hidden-sm-up">
                            <i class="ti-email">
                            </i>
                        </span>
                        <span class="hidden-xs-down">
                            Ajustes
                        </span>
                    </a>
                </li>
                <li class="nav-item">
                    <a aria-expanded="false" class="nav-link" data-toggle="tab" href="#pagos" role="tab">
                        <span class="hidden-sm-up">
                            <i class="ti-email">
                            </i>
                        </span>
                        <span class="hidden-xs-down">
                            Pagos
                        </span>
                    </a>
                </li>
            {{--    <li class="nav-item">
                    <a aria-expanded="false" class="nav-link" data-toggle="tab" href="#cupon_confirmacion" role="tab">
                        <span class="hidden-sm-up">
                            <i class="ti-email">
                            </i>
                        </span>
                        <span class="hidden-xs-down">
                            Cupon de confirmacion
                        </span>
                    </a>
                </li>
                <li class="nav-item">
                    <a aria-expanded="false" class="nav-link" data-toggle="tab" href="#cupon_cobro" role="tab">
                        <span class="hidden-sm-up">
                            <i class="ti-email">
                            </i>
                        </span>
                        <span class="hidden-xs-down">
                            Cupon de cobro
                        </span>
                    </a>
                </li>  --}}
                <li class="nav-item">
                    <a aria-expanded="false" class="nav-link" data-toggle="tab" href="#contratos_habitaciones" role="tab">
                        <span class="hidden-sm-up">
                            <i class="ti-email">
                            </i>
                        </span>
                        <span class="hidden-xs-down">
                            Contratos y habitaciones
                        </span>
                    </a>
                </li>
                <li class="nav-item">
                    <a aria-expanded="false" class="nav-link" data-toggle="tab" href="#cupones" role="tab">
                        <span class="hidden-sm-up">
                            <i class="ti-email">
                            </i>
                        </span>
                        <span class="hidden-xs-down">
                            Cupones
                        </span>
                    </a>
                </li>
            </ul>
            <!-- Tab panes -->
            <div class="tab-content">
                <div aria-expanded="true" class="tab-pane active" id="ver" role="tabpanel">
                    @include('admin.reservaciones.show')
                </div>
                <div aria-expanded="false" class="tab-pane p-20" id="editar" role="tabpanel">
                    @include('admin.reservaciones.edit')
                </div>
                <div aria-expanded="false" class="tab-pane p-20" id="ajustes" role="tabpanel">
                    @include('admin.reservaciones.ajustes')
                </div>
                <div aria-expanded="false" class="tab-pane p-20" id="pagos" role="tabpanel">
                    @include('admin.reservaciones.pagos')
                </div>
                <div aria-expanded="false" class="tab-pane p-20" id="contratos_habitaciones" role="tabpanel">
                    @include('admin.reservaciones.asociar_folios')
                </div>
                <div aria-expanded="false" class="tab-pane p-20" id="cupones" role="tabpanel">
                    <div class="row text-center">
                        <div class="col-lg-3 col-md-6">
                            <div class="card">
                                <div class="el-card-item">
                                    <div class="el-card-avatar text-center text-inverse mt-2">
                                        <i class="fas fa-file-pdf m-t-2" style="font-size: 120px;"></i>
                                    </div>
                                    <div class="el-card-content">
                                        <h3 class="box-title mt-3">Cupón de pago</h3>
                                        <div class="row m-4">
                                            <div class="col-md-6">
                                                <a href="{{  route('reservations.cuponPago', $reservacion->id) }}" target="_blank" class="btn btn-primary btn-sm btn-block">
                                                    <i class="fa fa-eye"></i>
                                                    Ver
                                                </a>
                                            </div>
                                            <div class="col-md-6">
                                                <button class="btn btn-success btn-sm btn-block" id="btnEnviarPago" data-url="{{ route('reservations.enviarPago') }}">
                                                    <i class="fa fa-send"></i>
                                                    Enviar cupón
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6">
                            <div class="card">
                                <div class="el-card-item">
                                    <div class="el-card-avatar text-center text-inverse mt-2">
                                        <i class="fas fa-file-pdf m-t-2" style="font-size: 120px;"></i>
                                    </div>
                                    <div class="el-card-content">
                                        <h3 class="box-title mt-3">Cupón de confirmación</h3>
                                        <div class="row m-4">
                                            <div class="col-md-6">
                                                <a href="{{ route('reservations.cuponConfirmacion', $reservacion->id)  }}" target="_blank" class="btn btn-primary btn-sm btn-block">
                                                    <i class="fa fa-eye"></i>
                                                    Ver
                                                </a>
                                            </div>
                                            <div class="col-md-6">
                                                <button class="btn btn-success btn-sm btn-block" data-url="{{ route('reservations.enviarConfirmacion') }}" id="btnEnviarConfirmacion">
                                                    <i class="fa fa-send"></i>
                                                    Enviar cupón
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" id="modalEnviarConfirmacion">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myLargeModalLabel">Enviar cupón de confirmación</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <form action="" method="post" id="formEnviarCupones">
                <input type="hidden" value="{{ $reservacion->id }}" name="id">
                <div class="modal-body">
                    <div class="card-body">
                        <div class="form-group row">
                            <label for="example-text-input"  class="col-2 col-form-label">Para:</label>
                            <div class="col-10">
                                {{-- <input class="form-control" type="text" value="Artisanal kale" id="example-text-input"> --}}
                                <input class="form-control" name="para" placeholder="Para:" value="{{ ($reservacion->email) ? $reservacion->email : $reservacion->user->username }}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="example-text-input" class="col-2 col-form-label">De:</label>
                            <div class="col-10">
                                {{-- <input class="form-control" type="text" value="Artisanal kale" id="example-text-input"> --}}
                                <input class="form-control" name="de" placeholder="De:" value="{{ (Auth::user()->config) ? Auth::user()->config->email :  Auth::user()->username }}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="example-text-input" class="col-2 col-form-label">Asunto:</label>
                            <div class="col-10">
                                {{-- <input class="form-control" type="text" value="Artisanal kale" id="example-text-input"> --}}
                                <input class="form-control" name="asunto" placeholder="Asunto:" value="Cupón de confirmación para el folio: {{ $reservacion->id }}">
                            </div>
                        </div>
                        <div class="form-group">
                           <textarea name="cuerpo" id="cuerpo" rows="20" class="form-control">
                                <div class="text-justify" >
                                    <br>
                                    <h3>Estimado cliente</h3>
                                   <p style="text-align: justify;">
                                        Es un gusto confirmar y dar por finalizado el trámite de reservación haciendo llegar el cupón de confirmación.
                                    </p>
                                    <p style="text-align: justify;">
                                        <b>
                                            A su vez le comento que cada destino cuenta con un nuevo impuesto por concepto de "Derecho de Saneamiento Ambiental" implementado por los gobiernos municipales, el cual varía en cada destino y deberá ser cubierto directamente en el hotel por el huésped.
                                        </b>
                                    </p>
                                    <p style="text-align: justify;">
                                        Debe presentar este cupón adjunto, impreso y una identificación al momento de registrarse en el hotel. Una vez emitido este cupón no se aceptan cambios ni cancelaciones, en caso de solicitarse estarán sujetos a una posible penalidad por parte del hotel. Se notifica que la asignación de la habitación depende directamente del hotel.
                                    </p>

                                    <b style="text-align: justify;">
                                        Favor de revisar que los datos del cupón estén correctos
                                    </b>
                                    <br>
                                    <p style="text-align: justify;">
                                        Agradeciendo se confirme de recibido.
                                    </p>
                                </div>
                           </textarea>
                        </div>

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success m-t-20">
                        <i class="fa fa-paper-plane"></i>
                        Enviar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" id="modalEnviarPago">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myLargeModalLabel">Enviar cupón de pago pediente</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <form action="" method="post" id="formEnviarPago">
                <input type="hidden" value="{{ $reservacion->id }}" name="id">
                <div class="modal-body">
                    <div class="card-body">
                        <div class="form-group row">
                            <label for="example-text-input"  class="col-2 col-form-label">Para:</label>
                            <div class="col-10">
                                {{-- <input class="form-control" type="text" value="Artisanal kale" id="example-text-input"> --}}
                                <input class="form-control" name="para_p" placeholder="Para:" value="{{ ($reservacion->email) ? $reservacion->email : $reservacion->user->username }}"/>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="example-text-input" class="col-2 col-form-label">De:</label>
                            <div class="col-10">
                                {{-- <input class="form-control" type="text" value="Artisanal kale" id="example-text-input"> --}}
                                <input class="form-control" name="de_p" placeholder="De:" value="{{ (Auth::user()->config) ? Auth::user()->config->email :  Auth::user()->username }}"/>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="example-text-input" class="col-2 col-form-label">Asunto:</label>
                            <div class="col-10">
                                {{-- <input class="form-control" type="text" value="Artisanal kale" id="example-text-input"> --}}
                                <input class="form-control" name="asunto_p" placeholder="Asunto:" value="Cupón de pago para el folio: {{ $reservacion->id }}"/>
                            </div>
                        </div>
                        <div class="form-group">
                           <textarea name="cuerpo_p" id="cuerpo_p" rows="20" class="form-control">
                                <div class="text-justify" style="color:black">
                                    <br>
                                    <h3>Estimado cliente</h3>
                                    @php
                                    $data['pax']    = "";
                                    $adultos        = 0;
                                    $menores        = 0;
                                    $juniors        = 0;
                                    $edades         = array();
                                    $edades_juniors = array();
                                        foreach ($reservacion->r_habitaciones as $key => $habitacion) {
                                            $adultos = $adultos + $habitacion['adultos'];
                                            $menores = $menores + $habitacion['menores'];
                                            $juniors = $juniors + $habitacion['juniors'];

                                            for ($i = 1; $i <= $habitacion['menores']; $i++) {
                                                $edades[] = $habitacion['edad_menor_' . $i];
                                            }

                                            for ($i = 1; $i <= $habitacion['juniors']; $i++) {
                                                $edades_juniors[] = $habitacion['edad_junior_' . $i];
                                            }

                                        }

                                        if ($adultos > 0) {
                                            $data['pax'] .= $adultos . ' Adulto(s)';
                                        }

                                        if ($menores > 0) {
                                            $data['pax'] .= ' / ' . $menores . ' Menor(es) - ' . implode(",", $edades) . ' Años';
                                        }

                                        if ($juniors > 0) {
                                            $data['pax'] .= ' / ' . $juniors . ' Junior(s) - ' . implode(",", $edades_juniors) . ' Años';
                                        }
                                    @endphp
                                   <p style="text-align: justify;">
                                       Es un gusto saludarle, confirmo su reservación para;
                                       <ul class="list-unstyled">
                                           <li>
                                            Hotel: <b>{{ $reservacion->hotel }}, {{ $reservacion->destino }}</b>
                                           </li>
                                           <li>
                                            Plan: <b>{{ $reservacion->title }}</b>
                                           </li>
                                           <li>
                                            Habitación(es): <b>{{ count($reservacion->r_habitaciones) }}</b>
                                           </li>
                                           <li>
                                               Para: <b>{{  $data['pax'] }}</b>
                                           </li>
                                       </ul>
                                    </p>
                                    <p style="text-align: justify;">
                                       Le adjunto un cupón de cobro con fecha límite para continuar con su proceso de reservación, le pido que al realizar el pago me envíe la ficha de depósito con su nombre por este medio, en caso de no recibir el comprobante en la fecha indicada se cancela su reservación automáticamente.
                                    </p>
                                    <div>
                                        <p style="text-align: justify;">
                                            <b>
                                                A su vez le comento que cada destino cuenta con un nuevo impuesto por concepto de "Derecho de Saneamiento Ambiental" implementado por los gobiernos municipales, el cual varía en cada destino y deberá ser cubierto directamente en el hotel por el huésped.
                                            </b>
                                        </p>
                                        <b style="text-align: justify;">
                                            El cargo se puede aplicar a alguna tarjeta de débito o crédito o bien depositar en nuestra cuenta en:
                                        </b>
                                        <table style="width:100%">
                                            <tr>
                                                <td style="border-left: 5px solid #e95b35; ">
                                                    <ul style="list-style:none; color: #0480be">
                                                        <li>
                                                            <b>
                                                                BBVA
                                                            </b>
                                                        </li>
                                                        <li>
                                                            <b>
                                                                Optu Travel Benefits S.A. de C.V.
                                                            </b>
                                                        </li>
                                                        <li>
                                                            <b>
                                                                Número de cuenta: 0117518781
                                                            </b>
                                                        </li>
                                                        <li>
                                                            <b>
                                                                Clabe Interbancaria: 012375001175187813
                                                            </b>
                                                        </li>
                                                    </ul>
                                                </td>

                                            </tr>
                                        </table>
                                    </div>
                                    <br>
                                    <p style="text-align: justify;">
                                    Es necesario corroborar los datos de reservación (hotel - fechas de viaje – destino – numero de personas - nombre de quien se reserva) antes de efectuar el pago, en caso de no estar correcta la información favor indicar para generar el cambio, de manera contraria su reservación quedara realizada conforme a lo antes estipulado.
                                    </p>

                                    <b style="text-align: justify; font-size: 14px;">
                                        NOTA: Confirmada la reservación no se podrán generar cambios .Se notifica que la asignación de la habitación depende directamente del hotel.
                                    </b>
                                    <br>
                                 {{--    <b style="text-align: justify; font-size: 14px;">
                                        Cada destino cuenta con un nuevo impuesto por concepto de "Derecho de Saneamiento Ambiental" implementado por los gobiernos municipales, el cual varía en cada destino y deberá ser cubierto directamente en el hotel por el huesped.
                                    </b> --}}
                                    <br>
                                    <br>
                                    <h5>
                                        Sin más por ahora quedo a sus órdenes para cualquier duda; {{ (Auth::user()->config) ? Auth::user()->config->from_name :  Auth::user()->fullName }}
                                    </h5>
                                    <h4>Gracias</h4>
                                </div>
                           </textarea>
                        </div>
                        <p><i class="fas fa-file-pdf"></i> Archivo adjunto...</p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success m-t-20">
                        <i class="fa fa-paper-plane"></i>
                        Enviar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
{{-- @include('admin.users.reservaciones_script') --}}
@section('script')
<script type="text/javascript">
    $(document).ready(function() {
        $('#cuerpo').summernote({
            height: 300,
        });

        $('#cuerpo_p').summernote({
            height: 300,
        });
        $(document).on('click', '#btnEnviarConfirmacion', function(event) {
            event.preventDefault();
            $('#myLargeModalLabel').html('Enviar cupón de confirmación');
            $('#formEnviarCupones').attr('action', $(this).data('url'));
            $('#modalEnviarConfirmacion').modal('show');
        });

        $(document).on('click', '#btnEnviarPago', function(event) {
            event.preventDefault();
            $('#myLargeModalLabel').html('Enviar cupón de pago');
            $('#formEnviarPago').attr('action', $(this).data('url'));
            $('#modalEnviarPago').modal('show');
        });

        $(document).on('submit', '#formEnviarCupones', function(event) {
             event.preventDefault();
             $.ajax({
                 url: $(this).attr('action'),
                 type: 'POST',
                 dataType: 'json',
                 data: $(this).serialize(),
                 beforeSend:function(){
                     $("#overlay").css("display", "block");
                 },
                 success:function(res){
                    if (res.success==true) {
                        $("#overlay").css("display", "none");
                        $('#modalEnviarConfirmacion').modal('hide');
                        $('#formEnviarCupones').trigger('reset');
                        toastr['info']('¡Cupón de confirmación enviado exitosamente!');
                    }else{
                        $("#overlay").css("display", "none");
                        toastr['error']('Cupón de confirmación no se pudo enviar, intenta mas tarde')
                        toastr['warning'](res.errors);
                    }
                 }
             })
             .done(function() {
                 // console.log("success");
             })
             .fail(function() {
                 // console.log("error");
             })
             .always(function() {
                 $("#overlay").css("display", "none");
             });

         });
        $(document).on('submit', '#formEnviarPago', function(event) {
             event.preventDefault();
             $.ajax({
                 url: $(this).attr('action'),
                 type: 'POST',
                 dataType: 'json',
                 data: $(this).serialize(),
                 beforeSend:function(){
                     $("#overlay").css("display", "block");
                 },
                 success:function(res){
                    if (res.success==true) {
                        $("#overlay").css("display", "none");
                        $('#modalEnviarPago').modal('hide');
                        $('#formEnviarPago').trigger('reset');
                        toastr['info']('¡Cupón de confirmación enviado exitosamente!');
                    }else{
                        $("#overlay").css("display", "none");
                        toastr['error']('Cupón de confirmación no se pudo enviar, intenta mas tarde')
                        toastr['warning'](res.errors);
                    }
                 }
             })
             .done(function() {
                 // console.log("success");
             })
             .fail(function() {
                 // console.log("error");
             })
             .always(function() {
                 $("#overlay").css("display", "none");
             });

         });


        var ninos = 1;
        var juniors = 1;
        var endDays = 1;
        var cont_n = 1;
        var cont_j = 1;
        var cont_fild = 1;
        var flag = true;
        var habitacion = 1;
        var user_id = @json($user->id);
        var user_name = @json($user->fullName);
        $('.btnAddHabitacion').attr('data-num_row_hab', habitacion);
        $('#padre_id').select2({
            dropdownParent: $('#modalAsignarReservacion .modal-body')
        });


        var cliente = @json($user);
        $('body').on('click', '#addName', function(event) {
            event.preventDefault();
            $('#nombre_adquisitor').val(cliente.nombre + ' ' + cliente.apellidos);
        });


        $('body').on('click', '#addEmail', function(event) {
            event.preventDefault();
            $('#email').val(cliente.username);
        });


        $('body').on('click', '#addTelefono', function(event) {
            event.preventDefault();
            $('#telefono').val(cliente.telefono);
        });


        /*=====================================
        =            Reservaciones            =
        =====================================*/
        var user_id = @json($user->id);
        var user_name = @json($user->fullName);
        var table_reservaciones;
        setTimeout(function(){
            table_reservaciones = $('#table_reservaciones').DataTable({
                'responsive': true,
                'searching': true,
                'lengthMenu': [[10, 20, -1], [10, 20, "Todo"]],
                'pageLength': 10,
                "aoColumns": [{
                    "mData": "1"
                    }, {
                    "mData": "2"
                    },{
                    "mData": "3"
                    }, {
                    "mData": "4"
                    },{
                    "mData": "5"
                    },{
                    "mData": "6"
                    }
                ],
                "ajax": {
                    url: baseuri + "admin/get-reservaciones/"+user_id,
                    type: "get",
                    dataType: "json",
                    error: function (xhr, error, code) {
                        // toastr['error'](xhr, code);
                        table_reservaciones.ajax.reload();
                    }
                },
            });
        }, 100);

        /*=====  End of Reservaciones  ======*/

        /**
         * Autor: ISW Diego Sanchez
         * Eliminar reservacion
         *
         */
        $('body').on('click', '#btnDeleteR', function(event) {
            event.preventDefault();
            var id = $(this).data('id');
             alertify.confirm('Confirmar', '¿Desea eliminar la reservacion con folio: '+id+ '?',function(){
                $.ajax({
                    url: baseadmin + 'reservations/'+ id,
                    type: 'DELETE',
                    dataType: 'JSON',
                    beforeSend:function(){
                        $("#overlay").css("display", "block");
                    },
                    success:function(res){
                        if (res.success == true) {
                            table_reservaciones.ajax.reload();
                            toastr['success']('Reservacion eliminada');
                        }
                    }
                })
                .fail(function() {
                    toastr['error']('Intentar mas tarde...');
                })
                .always(function() {
                    $("#overlay").css("display", "none");
                });

            }
            ,function(){});
        });


        /**
         * Recargar datos de la tabla en caso de no cargar automaticamente
         */
        $('body').on('click', '#btnReloadR', function(event) {
            event.preventDefault();
             toastr['info']('Recargando datos...');
            table_reservaciones.ajax.reload();
        });

        /**
         * Mostramos el historial de la reservacion
         */
        $('body').on('click', '#btnLogReservacion', function(event) {
            event.preventDefault();
            var reservacion_id = $(this).data('reservacion_id');
            $.ajax({
                url: baseadmin + 'log-reservacion/'+reservacion_id,
                type: 'GET',
                dataType: 'json',
                beforeSend:function(){
                    $("#overlay").css("display", "block");
                },
                success:function(res){
                    $('#modalHistorial #modal-body').removeClass('historico')
                    $('#modalHistorial #modal-body').addClass('historical-log')
                    $('#modalHistorial #modalSearchLabel').html('Historial');
                    $('#modalHistorial #modal-body').html(res.historico);
                    $('#modalHistorial').modal('show');
                }
            })
            .always(function() {
                $("#overlay").css("display", "none");
            });
        });


        /**
         * Mostramos la informacion de la reservacion
         * exportacion a pdf
         */
        $('body').on('click', '#btnShow', function(event) {
            event.preventDefault();
            var reservacion_id = $(this).attr('value');
            $.ajax({
                url: baseadmin + 'reservations/'+reservacion_id,
                type: 'GET',
                dataType: 'json',
                beforeSend:function(){
                    $("#overlay").css("display", "block");
                },
                success:function(res){
                    console.log(res);
                    // $('#modalHistorial #modal-body').removeClass('historico')
                    // $('#modalHistorial #modal-body').addClass('historical-log')
                    $('#modalGeneral #modal-body').html(res.view);
                    $('#modalGeneral .modal-dialog').addClass('modal-lg');
                    $('#modalGeneral').modal('show');
                }
            })
            .fail(function() {
                toastr['error']('Intentelo mas tarde');
                $("#overlay").css("display", "none");
            })
            .always(function() {
                $("#overlay").css("display", "none");
            });

        });


        /**
         * Autor: ISW Diego Sanchez
         * Creado: 2022-09-13
         * Editar reservacion
         */
        $('body').on('click', '#btnEditR', function(event) {
            event.preventDefault();
            var reservacion_id = $(this).attr('value');
            $.ajax({
                url: $(this).data('url'),
                type: 'GET',
                dataType: 'json',
                beforeSend:function(){
                    $("#overlay").css("display", "block");
                },
                success:function(res){

                    $('#modalGeneral #modal-body').html(res.view);
                    $('#modalGeneral .modal-dialog').addClass('modal-lg');
                    $('#modalGeneral').modal('show');
                }
            })
            .fail(function() {
                toastr['error']('Intentelo mas tarde');
                $("#overlay").css("display", "none");
            })
            .always(function() {
                $("#overlay").css("display", "none");
            });

        });


        // $(document).on('change', '#estancia_id', function(event) {
        //     event.preventDefault();
        //     $('#title').val($("#estancia_id option:selected").text());
        // });

        /**
         * Autor: ISW Diego Sanchez
         * Creado: 2022-09-22
         * Pagos de reservacion
         */
        $('body').on('click', '#btnPagosR', function(event) {
            event.preventDefault();
            var reservacion_id = $(this).attr('value');
            $.ajax({
                url: $(this).data('url'),
                type: 'GET',
                dataType: 'json',
                beforeSend:function(){
                    $("#overlay").css("display", "block");
                },
                success:function(res){

                    $('#modalGeneral #modal-body').html(res.view);
                    $('#modalGeneral .modal-dialog').addClass('modal-lg');
                    $('#modalGeneral').modal('show');
                }
            })
            .fail(function() {
                toastr['error']('Intentelo mas tarde');
                $("#overlay").css("display", "none");
            })
            .always(function() {
                $("#overlay").css("display", "none");
            });

        });

        /**
         * Modificacion de reservacion
         */
        $('body').on('submit', '#form_reservaciones_edit', function(event) {
            event.preventDefault();
             $.ajax({
                url: $(this).attr('action'),
                type: $(this).attr('method'),
                dataType: 'json',
                data: $(this).serialize(),
                beforeSend:function(){
                    $("#overlay").css("display", "block");
                },
                success:function(res){
                    if (res.success == true) {
                        $('#modalGeneral').modal('hide');
                        $(this).trigger('reset');
                        table_reservaciones.ajax.reload();
                        toastr['success']('{{ __('messages.alerta.success') }}');
                    }else{
                        toastr['error'](res.errors);
                        toastr['error']('{{ __('messages.alerta.error') }}');
                    }
                }
            })
            .always(function() {
                $("#overlay").css("display", "none");
            });
        });

        $('body').on('click', '#modalAddReservacion #btnAddName', function(event) {
            event.preventDefault();
            $('#modalAddReservacion #formAddReservacion #titular').val(user_name);
        });



        /**
         * Autor: ISW Diego Sanchez
         * Creado: 2022-09-26
         * Cupon de confirmacion
         */
        $('body').on('click', '#btnCuponCR', function(event) {
            event.preventDefault();
            var reservacion_id = $(this).attr('value');
            window.open($(this).data('url'), '_blank')
        });

        /**
         * Autor: ISW Diego Sanchez
         * Creado: 2022-09-27
         * Cupon de pago reservacion
         */
        $('body').on('click', '#btnCuponPR', function(event) {
            event.preventDefault();
            var reservacion_id = $(this).attr('value');
            window.open($(this).data('url'), '_blank')
        });

        /**
         * Autor: ISW Diego Sanchez
         * Creado: 2022-09-28
         * Asociar folios con reservacion y habitaciones
         */
        // $('body').on('click', '#btnConfig', function(event) {
        //  event.preventDefault();
        //  var reservacion_id = $(this).attr('value');
        //  window.open($(this).data('url'), '_blank')
        // });

        $('body').on('click', '#btnConfig', function(event) {
            event.preventDefault();
            var reservacion_id = $(this).attr('value');
            habitacion = 1;
            $.ajax({
                url: $(this).data('url'),
                type: 'GET',
                dataType: 'json',
                beforeSend:function(){
                    $("#overlay").css("display", "block");
                },
                success:function(res){
                    console.log(res);
                    $('#modalAddReservacion #divReservacion').html(res.view);
                    $('#modalAddReservacion .modal-dialog').addClass('modal-xl');
                    $('#modalAddReservacion .modal-title').html('Asociar folios y habitaciones');
                    $('#modalAddReservacion').modal('show');
                }
            })
            .fail(function() {
                toastr['error']('Intentelo mas tarde');
                $("#overlay").css("display", "none");
            })
            .always(function() {
                $("#overlay").css("display", "none");
            });

        });



        /**
          * agregar registros de menores dinamicos
          */
        $('body').on('click', '.btnAdd', function(event) {
            event.preventDefault();
            var contenedor = $(this).data('field');
            var num_cont = $(this).data('num_row');
            var row_inicial = $(this).data('row');
            var row = $(this).attr('id');

            if (num_cont != null) {
                cont_n = num_cont +1 ;
            }
            console.log(contenedor, row_inicial, row);

            $('#'+contenedor+row_inicial).append('<tr id="row' + cont_n + '"><td><div class="input-group input-sm"><input type="text" id="edad_nino' + cont_n + '" min="1" name="edad_nino'+row_inicial+'[]" pattern="^[0-9]+" class="form-control required><div class="input-group-append"><button  data-field="'+contenedor+row_inicial+'"  name="remove" id="' + cont_n + '" class="btn btn-outline-danger btn_remove btn-sm" type="button"><span class="fa fa-trash"></span></button></div></div></td></tr>');
            cont_n++;
        });

        $(document).on('click', '.btn_remove', function() {
            var button_id = $(this).attr("id");
            var contenedor_r = $(this).data('field');
            if ($('#form_reservaciones_edit').attr('method') == 'PUT') {
                var url = $(this).data('url_nino');
                alertify.confirm('Eliminar menor', '¿Desea eliminar el menor seleccionado?',
                    function(){
                        $.ajax({
                            url: url,
                            type: 'GET',
                            dataType: 'JSON',
                            beforeSend:function(){

                            },
                            success:function(res){
                                if (res.success == true) {
                                    toastr['success']('{{ __('messages.alerta.success') }}');
                                    cont_n = cont_n - 1;
                                    $('#'+contenedor_r+' #row' + button_id + '').remove();

                                    $('.btnAddHabitacion').attr('data-num_row_hab', habitacion);
                                }else{
                                     toastr['error']('{{ __('messages.alerta.error') }}');
                                }
                            }
                        })
                        .always(function() {
                            console.log("complete");
                        });
                    },
                    function(){});
            }else{

                cont_n = cont_n - 1;
                $('#'+contenedor_r+' #row' + button_id + '').remove();
            }
        });


        /** Agregar juniors a la habitacion seleccionada */
        $('body').on('click', '.btnAddJ', function(event) {
            event.preventDefault();
            var contenedor = $(this).data('field');
            var row_inicial = $(this).data('row');
            var row = $(this).attr('id');

            console.log(contenedor, row_inicial, row);

            $('#'+contenedor+row_inicial).append('<tr id="row' + cont_n + '"><td><div class="input-group input-sm"><input type="text" id="edad_junior' + cont_n + '" min="1" name="edad_junior'+row_inicial+'[]" pattern="^[0-9]+" class="form-control required><div class="input-group-append"><button  data-field="'+contenedor+row_inicial+'"  name="remove" id="' + cont_n + '" class="btn btn-outline-danger btn_remove_j btn-sm" type="button"><span class="fa fa-trash"></span></button></div></div></td></tr>');
            cont_n++;
        });

        $(document).on('click', '.btn_remove_j', function() {
            // var button_id = $(this).attr("id");
            // var contenedor_r = $(this).data('field');
            // cont_n = cont_n - 1;
            // $('#'+contenedor_r+' #row' + button_id + '').remove();


            var button_id = $(this).attr("id");
            var contenedor_r = $(this).data('field');
            if ($('#form_reservaciones_edit').attr('method') == 'PUT') {
                var url = $(this).data('url_jr');
                alertify.confirm('Eliminar menor', '¿Desea eliminar el jr seleccionado?',
                    function(){
                        $.ajax({
                            url: url,
                            type: 'GET',
                            dataType: 'JSON',
                            beforeSend:function(){

                            },
                            success:function(res){
                                if (res.success == true) {
                                    toastr['success']('{{ __('messages.alerta.success') }}');
                                    cont_n = cont_n - 1;
                                    $('#'+contenedor_r+' #row' + button_id + '').remove();

                                    $('.btnAddHabitacion').attr('data-num_row_hab', habitacion);
                                }else{
                                     toastr['error']('{{ __('messages.alerta.error') }}');
                                }
                            }
                        })
                        .always(function() {
                            console.log("complete");
                        });
                    },
                    function(){});
            }else{

                cont_n = cont_n - 1;
                $('#'+contenedor_r+' #row' + button_id + '').remove();
            }

        });


        $('#btnAddReservacion').on('click', function(event) {
            event.preventDefault();

            var user_id = $(this).data('user_id');
            $.ajax({
                url: baseadmin + 'agregar-reservacion/' + user_id,
                type: 'GET',
                dataType: 'json',
                beforeSend:function(){
                    $("#overlay").css("display", "block");
                }
            })
            .done(function(res) {
                $('#modalAddReservacion #divReservacion').html(res.view)
                $('#modalAddReservacion').modal('show');
            })
            .fail(function(jqXHR, textStatus, errorThrown) {
                toastr['error'](errorThrown);
                toastr['error'](jqXHR.responseJSON.message);
            })
            .always(function() {
                $("#overlay").css("display", "none");
            });
        });

        $('body').on('submit','#formAddReservacion', function(event) {
            event.preventDefault();
            $.ajax({
                url: $(this).attr('action'),
                type: 'POST',
                dataType: 'JSON',
                data: $(this).serialize(),
                beforeSend:function(){
                    $("#overlay").css("display", "block");
                },
                success:function(res){
                    if (res.success != true) {
                        $("#overlay").css("display", "none");
                        pintar_errores(res.errors);
                    }else{
                        $('#modalAddReservacion').modal('hide');
                        $('#formAddReservacion').trigger('reset');
                        toastr['success']('{{ __('messages.alerta.success') }}');
                        table_reservaciones.ajax.reload();
                    }
                }
            })
            .fail(function(jqXHR, textStatus, errorThrown) {
                toastr['error'](jqXHR.responseJSON.message);
                toastr['error'](errorThrown);
                $("#overlay").css("display", "none");
            })
            .always(function() {
                $("#overlay").css("display", "none");
            });

        });


        ///////////////////////////////////////
        //Agregar habitaciones a reservacion //
        ///////////////////////////////////////
        $(document).on('click', '.btnAddHabitacion', function(event) {
            event.preventDefault();
            if (($('#form_reservaciones_edit').attr('method')) == 'PUT') {
                var num_row_hab = $(this).data('num_row_hab');
                if (num_row_hab) {
                    habitacion = num_row_hab;
                }
            }
            habitacion++;
            $('#divHabitacion').append(
                '<div class="row" id="rowHabitacion' + habitacion + '">'+
                    '<input name="num_habitacion[]" type="hidden" value="'+habitacion+'"/>'+
                    '<div class="col-md-12">'+
                    '<div class="row">'+
                        '<div class="col-md-6">'+
                        '    <p>'+
                        '        Habitacion '+ habitacion+
                        '    </p>'+
                        '</div>'+
                        '<div class="col-md-6">'+
                        ' <div class="pull-right">'+
                        '    <button class="btn btn-xs btn-danger removeHabitacion"  data-id="'+habitacion+'"  type="button">'+
                        '        <i class="fas fa-trash">'+
                        '        </i>'+
                        '        Eliminar'+
                        '    </button>'+
                        '</div>'+
                        '</div>'+
                    '</div>'+
                    '</div>'+
                    '<div class="form-group col-md-6">'+
                    '    <label for="adultos">'+
                    '        Adultos'+
                    '    </label>'+
                    '    <input class="form-control" id="adultos" name="adultos[]" type="text" value="'+ $(this).data('adultos') +'">'+
                    '    </input>'+
                    '    <span class="text-danger error-adultos errors">'+
                    '    </span>'+
                    '</div>'+
                    '<div class="form-group col-md-6">'+
                    '    <label for="noches">'+
                    '        Noches'+
                    '    </label>'+
                    '    <input class="form-control" id="noches" name="noches[]" type="text" value="'+ $(this).data('noches') +'">'+
                    '    </input>'+
                    '    <span class="text-danger error-noches errors">'+
                    '    </span>'+
                    '</div>'+
                    '<div class="form-group col-md-6">'+
                    '    <label for="ninos">'+
                    '        Niños:'+
                    '    </label>'+
                    '    <br/>'+
                    '    <button class="btn btn-info btn-xs btnAdd" data-cantidad-row="" data-field="dynamic_field_"  data-row="'+habitacion+'" id="btnAdd" type="button">'+
                    '        <i class="fa fa-plus">'+
                    '        </i>'+
                    '        Agregar'+
                    '    </button>'+
                    '    <div class="row">'+
                    '        <div class="col-md-8">'+
                    '            <table class="table" id="dynamic_field_'+habitacion+'">'+
                    '            </table>'+
                    '        </div>'+
                    '    </div>'+
                    '    <span class="help-block text-muted">'+
                    '        <small>'+
                    '            {{ __('messages.cliente.menores_12') }}'+
                    '        </small>'+
                    '    </span>'+
                    '</div>'+
                    '<div class="form-group col-md-6">'+
                    '    <label for="junior">'+
                    '        {{ __('messages.cliente.juniors') }}:'+
                    '    </label>'+
                    '    <br/>'+
                    '    <button class="btn btn-info btn-xs btnAddJ" data-field="dynamic_field_j_" data-row="'+habitacion+'" id="btnAddJ" type="button">'+
                    '        <i class="fa fa-plus">'+
                    '        </i>'+
                    '        {{ __('messages.cliente.agregar') }}'+
                    '    </button>'+
                    '    <div class="row">'+
                    '        <div class="col-md-8">'+
                    '            <table class="table" id="dynamic_field_j_'+habitacion+'">'+
                    '                <tbody>'+
                    '               </tbody>'+
                                '</table>'+
                            '</div>'+
                        '</div>'+
                    '</div>'+
                '</div>'
            );
        });

        $(document).on('click', '.removeHabitacion', function() {
            event.preventDefault();
            var id = $(this).data("id");
            if ($('#form_reservaciones_edit').attr('method') == 'PUT') {
                var hab_id = $(this).attr('value');
                alertify.confirm('Eliminar habitacion', '¿Desea eliminar la habitacion seleccionada?',
                    function(){
                        $.ajax({
                            url: baseadmin + 'habitaciones/'+hab_id,
                            type: 'DELETE',
                            dataType: 'JSON',
                            beforeSend:function(){

                            },
                            success:function(res){
                                if (res.success == true) {
                                    toastr['success']('{{ __('messages.alerta.success') }}');
                                    $('#rowHabitacion' + id + '').remove();
                                    habitacion = habitacion - 1;
                                    $('.btnAddHabitacion').attr('data-num_row_hab', habitacion);
                                }else{
                                     toastr['error']('{{ __('messages.alerta.error') }}');
                                }
                            }
                        })
                        .always(function() {
                            console.log("complete");
                        });
                    },
                    function(){});
            }else{
                $('#rowHabitacion' + id + '').remove();
                habitacion = habitacion - 1;
                $('.btnAddHabitacion').attr('data-num_row_hab', habitacion);
            }

        });


        /**
         * Script para pagos de reservacion
         */

        $(document).on('submit', '#formPagosReservacion', function(event) {
            event.preventDefault();
            $.ajax({
                url: $(this).attr('action'),
                type: 'PUT',
                dataType: 'JSON',
                data: $(this).serialize(),
                beforeSend:function(){
                    $("#overlay").css("display", "block");
                },
                success:function(res){
                    if (res.success == true) {
                        $(this).trigger('reset');
                        table_reservaciones.ajax.reload();
                        toastr['success']('{{ __('messages.alerta.success') }}');
                        $('#modalGeneral').modal('hide');
                    }else{
                        if (res.errors) {
                            pintar_errores(res.errors);
                        }else{
                            toastr['error'](res.errores);
                            toastr['error']('{{ __('messages.alerta.error') }}');
                        }
                    }
                }
            })
            .fail(function(jqXHR, textStatus, errorThrown) {
                toastr['error'](errorThrown);
                toastr['error'](jqXHR.responseJSON.message);
            })
            .always(function() {
                $("#overlay").css("display", "none");
            });
        });



        /**
         * Ajustes de reservacion
         */

        /**
         * Autor: ISW Diego Sanchez
         * Creado: 2022-12-06
         * Ajustes de reservacion, pagos e informacion de hotel
         */
        $(document).on('click', '#btnAjustesR', function(event) {
            event.preventDefault();
            var reservacion_id = $(this).attr('value');
            $.ajax({
                url: $(this).data('url'),
                type: 'GET',
                dataType: 'json',
                beforeSend:function(){
                    $("#overlay").css("display", "block");
                },
                success:function(res){

                    $('#modalGeneral #modal-body').html(res.view);
                    $('#modalGeneral .modal-dialog').addClass('modal-lg');
                    $('#modalGeneral').modal('show');
                }
            })
            .fail(function() {
                toastr['error']('Intentelo mas tarde');
                $("#overlay").css("display", "none");
            })
            .always(function() {
                $("#overlay").css("display", "none");
            });
        });


        /**
         * Modificacion de reservacion
         */
        $('body').on('submit', '#form_reservaciones_ajustes', function(event) {
            event.preventDefault();
             $.ajax({
                url: $(this).attr('action'),
                type: $(this).attr('method'),
                dataType: 'json',
                data: $(this).serialize(),
                beforeSend:function(){
                    $("#overlay").css("display", "block");
                },
                success:function(res){
                    if (res.success == true) {
                        $(this).trigger('reset');
                        table_reservaciones.ajax.reload();
                        toastr['success']('{{ __('messages.alerta.success') }}');
                        $('#modalGeneral').modal('hide');
                    }else{
                        pintar_errores(res.errors);
                        // toastr['error']('{{ __('messages.alerta.error') }}');
                    }
                }
            })
            .always(function() {
                $("#overlay").css("display", "none");
            });
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
                        table_reservaciones.ajax.reload();
                        toastr['success']('¡Registros exitoso!');
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

        /**
         * Autor: ISW Diego Enrique Sanchez
         * Creado: 2022-12-20
         * Elimina el menos registrado en la habitacion
         */
        // $(document).on('click', '.deleteNino', function(event) {
        //     event.preventDefault();
        //     var habitacion_id = $(this).data('habitacion_id');
        //     var nino_id = $(this).data('nino_id');
        //     Swal.fire({
        //       title: 'Confirmación',
        //       text: "¿Desea eliminar el menos seleccionado?",
        //       icon: 'warning',
        //       showCancelButton: true,
        //       confirmButtonColor: '#3085d6',
        //       cancelButtonColor: '#d33',
        //       confirmButtonText: 'Yes, delete it!'
        //     }).then((result) => {
        //       if (result.isConfirmed) {
        //         Swal.fire(
        //           'Deleted!',
        //           'Your file has been deleted.',
        //           'success'
        //         )
        //       }
        //     })

        // });
    });


    function pintar_contratos(user_id) {
        tabla_contratos = $('#table_contratos').DataTable({
                'responsive': true,
                'searching': true,
                'lengthMenu': [[10, 20, -1], [10, 20, "Todo"]],
                'pageLength': 10,
                "aoColumns": [{
                    "mData": "0"
                    },{
                    "mData": "1"
                    }, {
                    "mData": "2"
                    },{
                    "mData": "3"
                    }, {
                    "mData": "4"
                    },
                    //  {
                    // "mData": "5"
                    // },
                    {
                    "mData": "6"
                    }, {
                    "mData": "7"
                    }
                ],
                "ajax": {
                    url: baseuri + "admin/listar-contratos/"+user_id,
                    type: "get",
                    dataType: "json",
                    error: function(e) {
                      console.log(e.responseText);
                    }
                },
            });
    }
</script>
@stop
