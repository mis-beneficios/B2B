<script type="text/javascript">
    $(document).ready(function() {

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
        var email = @json($user->username);
        var telefono = @json($user->telefono);
        var user_data = @json($user);
        $('.btnAddHabitacion').attr('data-num_row_hab', habitacion);
        $('#padre_id').select2({
            dropdownParent: $('#modalAsignarReservacion .modal-body')
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
                        $('#modalAddReservacion').modal('hide');
                        $('#modalGeneral').modal('hide');
                        $(this).trigger('reset');
                        table_reservaciones.ajax.reload();
                        $('#table_contratos').DataTable().ajax.reload();
                        $('body btnReloadC').click();
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

        $('body').on('click', '#modalAddReservacion #addEmail', function(event) {
            event.preventDefault();
            console.log('add email');
            $('#modalAddReservacion #formAddReservacion #email').val(user_data.username);
        });


        $('body').on('click', '#modalAddReservacion #addTelefono', function(event) {
            event.preventDefault();
            console.log('add telefono');
            $('#modalAddReservacion #formAddReservacion #telefono').val(user_data.telefono);
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
            // console.log(contenedor, row_inicial, row);
            
            $('#'+contenedor+row_inicial).append('<tr id="row' + cont_n + '"><td><div class="input-group input-sm"><input type="text" id="edad_nino' + cont_n + '" min="1" name="edad_nino'+row_inicial+'[]" pattern="^[0-9]+" class="form-control required><div class="input-group-append"><button  data-field="'+contenedor+row_inicial+'"  name="remove" id="' + cont_n + '" class="btn btn-outline-danger btn_remove btn-sm" data-url_nino="false" type="button"><span class="fa fa-trash"></span></button></div></div></td></tr>');
            cont_n++;
        });

        $(document).on('click', '.btn_remove', function() {
            var button_id = $(this).attr("id");
            var contenedor_r = $(this).data('field');
            var url = $(this).data('url_nino');                
            if (url != false) {
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
            
            // console.log(contenedor, row_inicial, row);
            
            $('#'+contenedor+row_inicial).append('<tr id="row' + cont_n + '"><td><div class="input-group input-sm"><input type="text" id="edad_junior' + cont_n + '" min="1" name="edad_junior'+row_inicial+'[]" pattern="^[0-9]+" class="form-control required><div class="input-group-append"><button  data-field="'+contenedor+row_inicial+'"  name="remove" id="' + cont_n + '" class="btn btn-outline-danger btn_remove_j btn-sm" data-url_jr="false" type="button"><span class="fa fa-trash"></span></button></div></div></td></tr>');
            cont_n++;
        });

        $(document).on('click', '.btn_remove_j', function() {

            var button_id = $(this).attr("id");
            var contenedor_r = $(this).data('field');
            var url = $(this).data('url_jr');                
            if (url != false) {
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
                $('#modalAddReservacion #divReservacion').html(res.view);
                $('#modalAddReservacion .modal-dialog').addClass('modal-md');
                $('#modalAddReservacion .modal-title').html('Registrar nueva reservación');
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
                    $("#overlay").css("display", "none");
                    if (res.success != true) {
                        if (res.errors) {
                            pintar_errores(res.errors);
                        }else{
                            toastr['error'](res.errores);     
                        }
                    }else{
                        $("#overlay").css("display", "none");
                        $('#modalAddReservacion').modal('hide');
                        $('#formAddReservacion').trigger('reset');
                        toastr['success']('{{ __('messages.alerta.success') }}'); 
                        table_reservaciones.ajax.reload();
                    }
                }
            })
            .fail(function(jqXHR, textStatus, errorThrown) {
                toastr['error'](jqXHR.responseJSON);
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
                $("#overlay").css("display", "none");
            })
            .always(function() {
                $("#overlay").css("display", "none");
            });
        });



        /**
         * Ajustes de reservacion
         */
        
        $('#form_reservaciones_ajustes #admin_fecha_para_liquidar').datepicker({
            dateFormat: "yy-mm-dd",
            autoclose:true,
        });


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
         * Creado: 2023-04-18
         * Descripcion: Desviculamos el contratro de alguna reservacion asociada
         */

        $('body').on('click', '#btnDesvincular', function(event) {
            event.preventDefault();

            var folio_id = $(this).data('contrato_id');

            $.ajax({
                url: $(this).data('url'),
                type: 'GET',
                dataType: 'JSON',
                beforeSend:function(){
                    $("#overlay").css("display", "block");
                },
                success:function(res){

                    if (res.success = true) {
                        alertify.alert(res.message, res.question + res.table);
                    }
                }
            })
            .fail(function(jqXHR, textStatus, errorThrown) {
                $("#overlay").css("display", "none");
            })
            .always(function() {
                $("#overlay").css("display", "none");
            });
        });



               /**
         * Autor: ISW Diego Enrique Sanchez
         * Creado: 2023-04-18
         * Descripcion: Desviculamos el contratro de alguna reservacion asociada
         */

        $('body').on('click', '#btnDesvincularContrato', function(event) {
            event.preventDefault();

            var folio_id = $(this).data('contrato_id');
            var reservacion_id = $(this).data('reservacion_id');
            var url = $(this).data('url');
            

            var alerta = alertify.confirm('Desvincular folio', "¿Desea desvincular el folio: "+ folio_id + " de la reservacion: "+ reservacion_id +"?", 
                function(){ 
                    $.ajax({
                        url: url,
                        type: 'PUT',
                        dataType: 'JSON',
                        beforeSend:function(){
                            $("#overlay").css("display", "block");
                        },
                        success:function(res){
                            $("#overlay").css("display", "none");
                            if(res.success == false || res.errors){
                                toastr['error']('Intenta mas tarde...')
                                toastr['error'](res.errors)
                            }

                            if (res.success == true) {
                                alertify.alert().close(); 
                                
                                toastr['info'](res.message);
                                $('#table_contratos').DataTable().ajax.reload();
                                table_reservaciones.ajax.reload();
                            }
                        }
                    })
                    .fail(function(jqXHR, textStatus, errorThrown) {
                        $("#overlay").css("display", "none");
                    })
                    .always(function() {
                        $("#overlay").css("display", "none");
                    });
                }
                , function(){ 
                    toastr['info']('No se hizo ningun cambio...');
                });
        });



        $('body').on('click', '.contrato_id', function(event) {
            event.preventDefault();
            var contrato_id     = $(this).val();
            var reservacion_id  = $(this).data('reservacion_id');
            var estatus;

            if ($(this).is(':checked')) {
                estatus = true;
                $title = "¿Desea vincular el folio: "+ contrato_id + "?";
                $texto =  'Una vez vinculado el folio, si requiere desvincular, realizarlo desde opciones de contrato, opción Desvincular';
            }else{
                estatus = false;
                $title = "¿Desea desvincular el folio: "+ contrato_id + "?";
                $texto =  'Una vez desvinculado el folio podrá vincularlo en otra reservación';
            }

            Swal.fire({
                title: $title,
                text: $texto,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Si',
                cancelButtonText: 'No'
            }).then((result) => {
              if (result.isConfirmed) {
                $.ajax({
                    url: baseadmin + 'folio-reservacion/' + contrato_id +'/'+ reservacion_id,
                    type: 'GET',
                    dataType: 'JSON',
                    success:function(res){
                        if (res.success == true && res.vinculado == true) {
                            $('#folio_asociado'+contrato_id).prop('checked', true);    
                            toastr['info']('Se vinculo correctamente el folio: '+ contrato_id);
                        }else if (res.success == true && res.desvinculado == true) {
                            $('#folio_asociado'+contrato_id).prop('checked', false);    
                            toastr['info']('Se desvinculo correctamente el folio: '+ contrato_id);
                        }else{
                            toastr['error']('Inténtalo mas tarde...');
                        }

                        $('#table_contratos').DataTable().ajax.reload();
                        table_reservaciones.ajax.reload();
                    }
                })
                .fail(function(jqXHR, textStatus, errorThrown) {
                    $("#overlay").css("display", "none");
                })
                .always(function() {
                    $("#overlay").css("display", "none");
                });
                
              }else{
              }
            })
        });



        $(document).on('click', '#btnCanbiarEjecutivo', function(event) {
            event.preventDefault();
            var reservacion_id = $(this).data('reservacion_id');
            alertify.confirm('Editar ejecutivo', '¿Desea cambiar el ejecutivo?',
                function(){
                    $.ajax({
                         url: baseadmin + 'cambiar-ejecutivo/' + reservacion_id,
                         type: 'GET',
                         dataType: 'JSON',
                         beforeSend:function(){
                             $("#overlay").css("display", "block");
                         },
                         success:function(res){
                            $('#modalEjecutivo #modal-body').html(res.view);
                            $('#modalEjecutivo').modal('show');
                            $('#user_id').select2({
                                dropdownParent: $('#modalEjecutivo')
                            });
                         }
                    })
                    // .fail(function(jqXHR, textStatus, errorThrown) {
                    //     toastr['error'](errorThrown);
                    //     toastr['error'](jqXHR.responseJSON.message);
                    // })
                    .fail(function(jqXHR, textStatus, errorThrown) {
                        toastr['error'](errorThrown +'<br>'+ jqXHR.responseJSON.message);
                    })
                    .always(function() {
                        $("#overlay").css("display", "none");
                     });

                },
                function(){}
            );
        });


        $('body').on('submit', '#formEjecutivo', function(event) {
            event.preventDefault();
            var url = $(this).attr('action');
            var method = $(this).attr('method');
            $.ajax({
                url: url,
                type: method,
                dataType: 'json',
                data: $(this).serialize(),
                beforeSend:function(){
                    $("#overlay").css("display", "block");
                },
                success:function(res){
                    if (res.success == true) {
                        $("#overlay").css("display", "none");
                        $('#modalEjecutivo').modal('hide');
                        toastr['success']('{{ __('messages.alerta.success') }}');
                        table_reservaciones.ajax.reload();
                    }else{
                        toastr['error']('¡Error, intenta mas tarde!');
                    }

                }
            })
            .fail(function(jqXHR, textStatus, errorThrown) {
                toastr['error'](errorThrown +'<br>'+ errorThrown);
            })
            .always(function() {
                $("#overlay").css("display", "none");
            });
        });

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