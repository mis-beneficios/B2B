<script>
    $(document).ready(function() {

       // Obtener el elemento input y el elemento para mostrar el valor



        $('body .datepicker').datepicker({
            dateFormat: "yy-mm-dd",
            autoclose:true,
            language: 'es',
            orientation: 'bottom',
        });

        moment.locale('es');
        var user_id = @json($user->id);
        var user_name = @json($user->fullName);
        var tabla;
        var tabla_pagos;
        var tabla_contratos;
        var validar = @json($cont);
        $('#estancia_id').select2({
             dropdownParent: $('#modalCambioEstancia')
        });

        setTimeout(function(){
            console.log("consultamos contratos (1)");
        }, 800);


        setTimeout(function(){
            console.log("consultamos contratos");
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
                        toastr['error'](e.responseText);
                        tabla_contratos.ajax.reload();
                    }
                },
                "createdRow": function(row, data, dataIndex) {
                    if (data['8']) {
                        $(row).addClass('inactive-row').removeClass('active-row');
                    } else {
                        $(row).addClass('active-row').removeClass('inactive-row');
                    }
                }
            });
        }, 800);

        $('body').on('click', '#btnReloadC', function(event) {
            event.preventDefault();
            toastr['info']('Recargando datos...');
            tabla_contratos.ajax.reload();
        });


        /**
         * Description
         */

        $('body').on('click', '#btnReloadBank', function(event) {
            event.preventDefault();
            $.ajax({
                url: '{{route('bancos.obtener_bancos')}}',
                type: 'GET',
                dataType: 'json',
                success:function(res){
                    $('#formEditCard #banco').html('');
                    $('#formAddCard #banco').html('');
                    toastr['info']('Recargando bancos...');
                    $.each(res, function(index, val) {
                        $('#formEditCard #banco').append('<option class="text-uppercase" value="'+val.id+'">'+val.title+'</option>');
                        $('#formAddCard #banco').append('<option class="text-uppercase" value="'+val.id+'">'+val.title+'</option>');
                    });
                }
            });
        });



        /*==================================
        =            Cards User            =
        ==================================*/
        setTimeout(function(){
            tabla = $('#table_tarjetas').DataTable({
                'responsive': true,
                'searching': false,
                'lengthMenu': [[5, 10, -1], [5, 10, "Todo"]],
                'pageLength': 5,
                // "order": [4, 'asc'],
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
                    }, {
                    "mData": "6"
                    }, {
                    "mData": "5"
                    }
                ],
                "ajax": {
                    url: baseuri + "admin/listar-tarjetas/"+user_id,
                    type: "get",
                    dataType: "json",
                    error: function(e) {
                      tabla.ajax.reload();
                    }
                },
            });
        }, 800);

        $('body').on('click', '#btnReloadT', function(event) {
            event.preventDefault();
            toastr['info']('Recargando datos...');
            tabla.ajax.reload();
        });

        var element3 = document.getElementById('vencimiento');
        var maskOptions3 = {
            mask: '00/00'
        };
        IMask(element3, maskOptions3);

        $('#btnAddTarjeta').click(function(event){
            event.preventDefault();
            console.log(validar);
            if (validar.user_tarjetas <= validar.max_tarjetas || (validar.role != 'sales' && validar.role != 'supervisor')) {
                var user_id = $(this).data('user_id');
                $('#modalAddTarjeta #formAddCard #modal-body').append('<input type="hidden" name="user_id" id="user_id" value="'+ user_id +'"/>');
                $('#modalAddTarjeta').modal('show');
            }else{
                Swal.fire({
                    icon: 'warning',
                    title: 'Alerta',
                    text: '¡El usuario a superado el limite de tarjetas registradas!',
                    showConfirmButton: true,
                    // timer: 2500
                })
            }

        });


        $('#btnAddName').click(function(event){
            event.preventDefault();
            $('#titular').val(user_name);
        });

        $('body').on('click', '#btnInfoContrato', function(event) {
            event.preventDefault();

            alertify.alert('Vigencia de contrato', $(this).data('title'),
                function(){
                });
        });

        $('#formAddCard').submit(function(event){
            event.preventDefault();
            $.ajax({
                url: baseuri + 'admin/cards',
                type: 'POST',
                dataType: 'json',
                data: $(this).serialize(),
                beforeSend: function() {
                    $("#overlay").css("display", "block");
                },
                success:function(res){

                    if(res.message){
                        toastr["error"](res.message)
                        $('#formAddCard').trigger('reset');
                        $('#modalAddTarjeta').modal('hide');
                    }
                    if (res.success == false) {
                        pintar_errores(res.errors);
                    }else{
                        toastr["success"]("Registro exitoso!")
                        tabla.ajax.reload();
                        $('#formAddCard').trigger('reset');
                        $('#modalAddTarjeta').modal('hide');
                    }
                }
            })
            .fail(function(jqXHR, textStatus, errorThrown) {
                $("#overlay").css("display", "none");
                toastr['error'](errorThrown);
                toastr['error'](jqXHR.responseJSON.message);
            })
            .always(function() {
                $("#overlay").css("display", "none");
            });
        });


        $(document).on('click', '#btnEditarTarjeta', function(event) {
            event.preventDefault();
            $url = $(this).data('url');
            $.ajax({
                url: $url,
                type: 'GET',
                dataType: 'JSON',
                beforeSend:function(){
                    $("#overlay").css("display", "block");
                }
            })
            .done(function(res) {
                if (res.success == true) {
                    $('#modalGeneral #modalGeneralLabel').html('Editar tarjeta');
                    $('#modalGeneral #modal-body').html(res.view);
                    $('#modalGeneral').modal('show');
                }else{
                    toastr['error'](res.errors);
                }
            })
            .fail(function(jqXHR, textStatus, errorThrown) {
                $("#overlay").css("display", "none");
                toastr['error'](errorThrown);
            })
            .always(function() {
                $("#overlay").css("display", "none");
            });

        });

        $('body').on('submit', '#formEditCard', function(event) {
            event.preventDefault();
            $.ajax({
                url: $(this).attr('action'),
                type: 'PUT',
                dataType: 'json',
                data: $(this).serialize(),
                beforeSend: function() {
                    $("#overlay").css("display", "block");
                },
                success:function(res){
                    $("#overlay").css("display", "none");
                    if (res.success == false) {
                       
                        if (res.errors) {
                            pintar_errores(res.errors);
                        }else{
                            toastr['error'](res.catch);
                        }

                    }else{
                        $('#modalGeneral').modal('hide');
                        tabla.ajax.reload();
                        Swal.fire({
                            icon: 'success',
                            title: '¡Tarjeta editada correctamente!',
                            showConfirmButton: false,
                            timer: 1500
                        })
                    }
                }
            })
            .fail(function(jqXHR, textStatus, errorThrown) {
                $("#overlay").css("display", "none");
                toastr['error'](errorThrown);
            })
            .always(function() {
                $("#overlay").css("display", "none");
            });
        });



        $('body').on('click', '.btnLogTarjeta', function(event) {
            event.preventDefault();
            var tarjeta_id = $(this).data('tarjeta_id');
            $.ajax({
                url: baseuri + 'admin/mostrar-historial-tarjeta/'+tarjeta_id,
                type: 'GET',
                dataType: 'json',
                beforeSend:function(){
                    $("#overlay").css("display", "block");
                },
                success:function(res){
                    $('#modalHistorial #modal-body').removeClass('historico')
                    $('#modalHistorial #modal-body').addClass('historical-log')
                    $('#modalHistorial #modal-body').html(res.historico);
                    $('#modalHistorial').modal('show');
                }
            })
            .always(function() {
                $("#overlay").css("display", "none");
            });
        });



        /*=====  End of Cards User  ======*/






        /*======================================
        =            Contratos User            =
        ======================================*/

        $('body').on('click', '.btnLogContrato', function(event) {
            event.preventDefault();
            var user_id = $(this).data('contrato_id');
            $.ajax({
                url: baseuri + 'admin/mostrar-historial-contrato/'+user_id,
                type: 'GET',
                dataType: 'json',
                beforeSend:function(){
                    $("#overlay").css("display", "block");
                },
                success:function(res){
                    $('#modalHistorial #modal-body').removeClass('historico')
                    $('#modalHistorial #modal-body').addClass('historical-log')
                    $('#modalHistorial #modal-body').html(res.historico);
                    $('#modalHistorial').modal('show');
                }
            })
            .always(function() {
                $("#overlay").css("display", "none");
            });
        });

        $('#btnAddContrato').click(function(event){
            event.preventDefault();

            if (validar.user_contratos <= validar.max_contratos) {
                var user_id = $(this).data('user_id');
                $.ajax({
                    url: baseuri + 'admin/contratos/create',
                    type: 'get',
                    dataType: 'json',
                    data: {
                        user_id: user_id
                    },
                    beforeSend: function() {
                        $("#overlay").css("display", "block");
                    },
                    success:function(res){
                        $('#modalAddContrato #modal-body').html(res.view);
                        $('#modalAddContrato').modal('show');
                    }
                })
                .fail(function() {
                    $("#overlay").css("display", "none");
                })
                .always(function() {
                    $("#overlay").css("display", "none");
                });
            }else{
                Swal.fire({
                    icon: 'warning',
                    title: 'Alerta',
                    text: '¡El usuario a superado el limite de contratos registrados!',
                    showConfirmButton: true,
                    // timer: 2500
                })
            }
        });

        $('body').on('submit', '#add_contrato_user', function(event) {
            event.preventDefault();

            $estancia = $('#estancia_id option:selected').text();
            $estancia_id = $('#estancia_id').val();
            console.log($estancia_id);
            if ($estancia_id != '') {
                Swal.fire({
                    icon: 'question',
                    title: 'El contrato se generara con la estanancia: '+$estancia + '<br> ¿Desea continuar?',
                    showCancelButton: true,
                    confirmButtonText: 'Si, continuar',
                    cancelButtonText: 'Elegir nueva estancia',
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                }).then((result) => {
                    /* Read more about isConfirmed, isDenied below */
                    if (result.isConfirmed) {
                        $.ajax({
                            url: '{{ route('contratos.store') }}',
                            type: 'POST',
                            dataType: 'json',
                            data: $('#add_contrato_user').serialize(),
                            beforeSend:function(){
                                $("#overlay").css("display", "block");
                            },
                            success:function(res){
                                if (res.success==true) {
                                    tabla_contratos.ajax.reload();
                                    // toastr["success"]("!Contrato agregado exitosamente!");
                                    Toast.fire({
                                      icon: 'success',
                                      title: '!Contrato agregado exitosamente!'
                                    })
                                    $('#modalAddContrato #modalAddContratoLabel').html('Programar segmentos');
                                    $('#modalAddContrato #modal-body').html(res.view);
                                }else{
                                    pintar_errores(res.errors);
                                }
                            }
                        })
                        .fail(function(jqXHR, textStatus, errorThrown) {
                            toastr['error'](errorThrown);
                        })
                        .always(function() {
                            $("#overlay").css("display", "none");
                        });
                    }
                })
            }else{
                Swal.fire({
                  icon: 'error',
                  title: 'Oops...',
                  text: 'Selecciona una estancia',
                })
            }



            // $.ajax({
            //     url: '{{ route('contratos.store') }}',
            //     type: 'POST',
            //     dataType: 'json',
            //     data: $('#add_contrato_user').serialize(),
            //     beforeSend:function(){
            //         $("#overlay").css("display", "block");
            //     },
            //     success:function(res){
            //         if (res.success==true) {
            //             tabla_contratos.ajax.reload();
            //             toastr["success"]("!Contrato agregado exitosamente!");
            //             $('#modalAddContrato #modalAddContratoLabel').html('Programar segmentos');
            //             $('#modalAddContrato #modal-body').html(res.view);
            //         }else{
            //             pintar_errores(res.errors);
            //         }
            //     }
            // })
            // .always(function() {
            //     $("#overlay").css("display", "none");
            // });
        });

        $(document).on('click', '#btnCanbiarPadre', function(event) {
            event.preventDefault();
            var contrato_id = $(this).data('contrato_id');
            alertify.confirm('Editar vendedor', '¿Desea cambiar el vendedor?',
                function(){
                    $.ajax({
                         url: baseadmin + 'cambiar-padre/' + contrato_id,
                         type: 'GET',
                         dataType: 'JSON',
                         beforeSend:function(){
                             $("#overlay").css("display", "block");
                         },
                         success:function(res){
                            $('#modalVendedor #modal-body').html(res.view);
                            $('#modalVendedor').modal('show');
                            $('#user_id').select2({
                                dropdownParent: $('#modalVendedor')
                            });
                         }
                     })
                     .always(function() {
                        $("#overlay").css("display", "none");
                     });

                },
                function(){}
            );
        });


        $('body').on('submit', '#formVendedor', function(event) {
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
                        $('#modalVendedor').modal('hide');
                        toastr['success']('{{ __('messages.alerta.success') }}');
                        tabla_contratos.ajax.reload();
                    }else{
                        toastr['error']('¡Error, intenta mas tarde!');
                    }

                }
            })
            .fail(function() {
                toastr['error']('¡Error, intenta mas tarde!');
            })
            .always(function() {
                $("#overlay").css("display", "none");
            });
        });

        /*=====  End of Contratos User  ======*/


        /*======================================
        =            Historial User            =
        ======================================*/

        $('#showHistorial').click(function(event) {
            event.preventDefault();
            var user_id = '{{ $user->id }}';
            $.ajax({
                url: baseuri + 'admin/mostrar-historial/'+user_id,
                type: 'GET',
                dataType: 'json',
                beforeSend:function(){
                    $("#overlay").css("display", "block");
                },
                success:function(res){
                    $('#modalHistorial #modal-body').removeClass('historical-log')
                    $('#modalHistorial #modal-body').addClass('historico')
                    $('#modalHistorial #modal-body').html(res.historico);
                    $('#modalHistorial').modal('show');
                }
            })
            .always(function() {
                $("#overlay").css("display", "none");
            });
        });

        $('#btnLog').click(function(event){
            event.preventDefault();
            var user_id = $(this).data('user_id');
            $('#modalLog #formLog').append('<input type="hidden" name="user_id" id="user_id" value="'+ user_id +'"/>');
            $('#modalLog').modal('show');
        });

        $('#formLog').submit(function(event){
            event.preventDefault();
            $.ajax({
                url: '{{ route('users.log') }}',
                type: 'POST',
                dataType: 'json',
                data:$(this).serialize(),
                beforeSend: function() {
                    $("#overlay").css("display", "block");
                },
                success:function(res){
                    if (res.success == true) {
                        toastr["success"]("Log agregado exitosamente!")
                        $('#showHistorial').html(res.log);
                    }else {
                        toastr["error"]("No se pudo guardar el historial")
                    }
                },
            })
            .always(function() {
                $(this).trigger('reset');
                $('#modalLog').modal('hide');
                $("#overlay").css("display", "none");
            });
        });





        $('#btnHistorial').click(function(event) {
            event.preventDefault();
            var user_id = '{{ $user->id }}';
            $.ajax({
                url: baseuri + 'admin/mostrar-historial/'+user_id +'/log',
                type: 'GET',
                dataType: 'json',
                beforeSend:function(){
                    $("#overlay").css("display", "block");
                },
                success:function(res){
                    $('#modalHistorial #modal-body').removeClass('historical-log')
                    $('#modalHistorial #modal-body').addClass('historico')
                    $('#modalHistorial #modal-body').html(res.historico);
                    $('#modalHistorial').modal('show');
                }
            })
            .always(function() {
                $("#overlay").css("display", "none");
            });
        });

        /*=====  End of Historial User  ======*/






        $('.btn-estancia').click(function(event){
            event.preventDefault();
            var estancia_id = $(this).data('id');
            $('#estancia_id').value(estancia_id);
        })

        // $('body #estancia_id').select2({
        //     theme: 'bootstrap3',
        // });







        $('#metodo_pago').change(function(event){
            event.preventDefault();
            $val = $(this).val();
            if ($('#descuento').is(':checked')) {
                if($val == 'semanal'){
                    $('#add_pagos_contrato #rangeval').html(48);
                    $('#num_segmentos').val(48);
                }else if($val == 'mensual'){
                    $('#add_pagos_contrato #rangeval').html(12);
                    $('#num_segmentos').val(12);
                }else{
                    $('#add_pagos_contrato #rangeval').html(24);
                    $('#num_segmentos').val(24);
                }
            }else{
                if($val == 'semanal'){
                    $('#add_pagos_contrato #rangeval').html(72);
                    $('#num_segmentos').val(72);
                }else if($val == 'mensual'){
                    $('#add_pagos_contrato #rangeval').html(12);
                    $('#num_segmentos').val(12);
                }else{
                    $('#add_pagos_contrato #rangeval').html(36);
                    $('#num_segmentos').val(36);
                }
            }
        });

        // $('body #fecha_primer_descuento').datepicker({
        //     // format: 'yyyy-mm-dd',
        //     dateFormat: "yy-mm-dd",
        //     autoUpdateInput: true,
        //     startDate: '-1d',
        //     endDate: '+2m',
        //     autoclose:true,
        //     language: 'es'
        // });

        $('body #fecha_de_cobro').datepicker({
            // format: 'yyyy-mm-dd',
            dateFormat: "yy-mm-dd",
            autoUpdateInput: true,
            startDate: '-1d',
            endDate: '+1m +15d',
            autoclose:true,
            language: 'es'
        });


        /*===========================================
        =            Calculador de pagos            =
        ===========================================*/

        $('body').on('click', '#btnCalPagos', function(event) {
            event.preventDefault();
            $('#tablePagos #tableBody').html('');

            var contrato_id = $(this).data('contrato_id');
            var tipo = 'pendientes';
            $('#contrato_id').val(contrato_id);
            var estatus = $(this).data('data-estatus');

            $.ajax({
                url: baseadmin + 'listar-pagos-contrato/'+contrato_id + '/'+ tipo,
                type: 'get',
                dataType: 'json',
                beforeSend:function(){
                    $("#overlay").css("display", "block");
                },
                success:function(res){
                    // console.log(res);
                    if (res.fecha_inicial != null) {
                        $('#modalCalculador #fecha_primer_descuento').val(res.fecha_inicial);
                        $('#modalCalculador #num_segmentos').val(res.segmentos_generados);
                    }

                    $('body #add_pagos_contrato #rangeval').html(res.segmentos_generados);
                    $('body #add_pagos_contrato #num_segmentos').val(res.segmentos_generados);

                    if (res.pagados >= 1) {
                        alertify.confirm('Alerta!', 'El paquete cuenta con '+res.pagados+' pagos realizados correctamente. <br> ¿Desea recalcular los cobros restantes?',
                            function(){
                                $('#modalCalculador #modal-body').html(res.view);
                                // pintar_pagos(res.aaData)
                                $('#modalCalculador').modal('show');
                            }
                            ,function(){}
                        );
                    }else{
                        pintar_pagos(res.aaData)
                        $('#modalCalculador #modal-body').html(res.view);
                        $('#modalCalculador').modal('show');
                    }
                    $('#modified_pay').val('modified');
                },
                error: function (xhr, error, code) {
                    toastr['error'](xhr, code);
                    // table_reservaciones.ajax.reload();
                }
            })
            .always(function() {
                $("#overlay").css("display", "none");
            });
        });


        $('body').on('change', '#num_segmentos', function(event) {
            $('#tablePagos #tableBody').html('');
            event.preventDefault();
            var fecha = $('#fecha_primer_descuento').val();

            $('#rangeval').html($(this).val());


            if (fecha != '') {
                $.ajax({
                    url: '{{ route('pagos.calcular') }}',
                    type: 'POST',
                    dataType: 'json',
                    data: $('#add_pagos_contrato').serialize(),
                    beforeSend:function(){

                    },
                    success:function(res){
                        if (res.errors) {
                              toastr['error'](res.errors);
                        }else{
                            $.each(res.pagos, function(i, v) {
                                // $('body #add_pagos_contrato #tablePagos #tableBody').append('<tr><td>'+i+'</td><td>'+v[1]+'<input type="hidden" name="segmento[]" value="'+v[1]+'"/><input type="hidden" name="pago_id[]" value="'+v[8]+'"/></td><td>'+v[4]+'<br/>'+moment(v[4]).format('LL')+'<input type="hidden" name="fecha_de_cobro[]" value="'+v[4]+'"/></td><td>$ '+v[3]+'<input type="hidden" name="cantidad[]" value="'+v[3]+'"/> <input type="hidden" name="concepto[]" value="'+v.concepto+'"/></td></tr>');

                                i++;

                                $('#tablePagos #tableBody').append(' <tr><td>'+i+'</td><td>'+v.segmento+'<input type="hidden" name="segmento[]" value="'+v.segmento+'"/></td><td>'+v.fecha_de_cobro+'<br/>'+moment(v.fecha_de_cobro).format('LL')+'<input type="hidden" name="fecha_de_cobro[]" value="'+v.fecha_de_cobro+'"/></td><td>$ '+v.cantidad.toFixed(2)+'<input type="hidden" name="cantidad[]" value="'+v.cantidad.toFixed(2)+'"/> <input type="hidden" name="concepto[]" value="'+v.concepto+'"/></td></tr>');
                            });
                        }
                    }
                })
                .fail(function(jqXHR, textStatus, errorThrown) {
  
                    toastr['error'](errorThrown);
                    toastr['error'](jqXHR);
                })
                .always(function() {
                    // $("#overlay").css("display", "none");
                });
            }else{
                toastr['error']('Fecha invalida');
            }
        });


        $('body').on('click', '#btnCalcularPagos', function(event) {
            $('#tablePagos #tableBody').html('');
            event.preventDefault();
            var total = 0;
            var fecha = $('#fecha_primer_descuento').val();
            if (fecha != '') {
                $.ajax({
                    url: '{{ route('pagos.calcular') }}',
                    type: 'POST',
                    dataType: 'json',
                    data: $('#add_pagos_contrato').serialize(),
                    beforeSend:function(){
                        $("#overlay").css("display", "block");
                    },
                    success:function(res){

                        $.each(res.pagos, function(i, v) {
                            i++;
                            $('#tablePagos #tableBody').append(' <tr><td>'+i+'</td><td>'+v.segmento+'<input type="hidden" name="segmento[]" value="'+v.segmento+'"/></td><td>'+v.fecha_de_cobro+'<br/>'+moment(v.fecha_de_cobro).format('LL')+'<input type="hidden" name="fecha_de_cobro[]" value="'+v.fecha_de_cobro+'"/></td><td>$ '+v.cantidad.toFixed(2)+'<input type="hidden" name="cantidad[]" value="'+v.cantidad.toFixed(2)+'"/><input type="hidden" name="concepto[]" value="'+v.concepto+'"/></td></tr>');

                            total += v[3];
                        });

                        console.log(total);
                        $('#total').html(total);
                    }
                })
                .fail(function(jqXHR, textStatus, errorThrown) {
                    console.log(jqXHR)
                    console.log(textStatus)
                    console.log(errorThrown)
                    toastr['error'](errorThrown);
                    toastr['error'](jqXHR);
                })
                .always(function() {
                    $("#overlay").css("display", "none");
                });
            }else{
                toastr['error']('Fecha invalida');
            }
        });

        $(document).on('change', '#descuento', function(event) {
            event.preventDefault();
            if ($(this).is(':checked')) {
                toastr['info']('Se aplicara el '+ $(this).data('descuento') +'% de descuento, y vigencia de un año');
                $('#desc_text').css('display', 'block')
                $('#rangeval').html(24);
                $('#num_segmentos').val(24);
            }else{
                toastr['info']('No se aplicara descuento, con vigencia de un año y medio');
                $('#desc_text').css('display', 'none')
                $('#rangeval').html(36);
                $('#num_segmentos').val(36);
            }

            $('#btnCalcularPagos').click();
        });

        $('body').on('submit', '#add_pagos_contrato', function(event) {
            event.preventDefault();
            var fecha = $('#fecha_primer_descuento').val();

            if (fecha != '') {
                $.ajax({
                    url: '{{ route('pagos.store') }}',
                    type: 'POST',
                    dataType: 'json',
                    data: $('#add_pagos_contrato').serialize(),
                    beforeSend:function(){
                        $("#overlay").css("display", "block");
                    },
                    success:function(res){
                        if(res.success==true){
                            $('#modalCalculador').modal('hide');
                            $('#modalAddContrato').modal('hide');
                            toastr["success"]("!Pagos generados exitosamente!");

                            // setTimeout(function(){
                            // window.location.reload();
                            tabla_contratos.ajax.reload();
                            // }, 500);
                        }else{
                            toastr["error"](res.errors);
                            // toastr["error"]("!Error al generar los pagos!");
                        }
                    },
                    error:function(){
                        toastr["error"]("!Error al generar los pagos!");
                    }
                })
                .always(function() {
                    // $('#modalCalculador').modal('hide');
                    // $('#modalAddContrato').modal('hide');
                    $("#overlay").css("display", "none");
                });
            }else{
                toastr['error']('Fecha invalida');
            }
        });

        /*=====  End of Calculador de pagos  ======*/




        $('body').on('change', '#metodo_pago', function(event) {
            event.preventDefault();
             if($(this).val() == 'quincenal_preciso'){

                $("#fechas_xy").css("display", "block");
                // $('#fechas_xy').html('<div class="row"><div class="form-group col-lg-4 col-md-6"><label for="inputPassword4">Dia x del mes</label><input id="dia_x" name="dia_x" class="form-control"  type="date"/><span class="text-danger error-numero_tarjeta errors"></span></div><div class="form-group col-lg-4 col-md-6"><label for="inputPassword4">Dia y del mes</label><input class="form-control" id="dia_y" name="dia_y" type="date" /><span class="text-danger error-numero_tarjeta errors"></span></div></div>');

                // for(var i = 1;  i <= 31; i++){
                //     $('#add_pagos_contrato #dia_x').append('<option value="'+ i +'">'+ i +'<option>');
                //     $('#add_pagos_contrato #dia_y').append('<option value="'+ i +'">'+ i +'<option>');
                // }
            }else{
                // $('#fechas_xy').html('');
                $("#fechas_xy").css("display", "none");
            }
        });


        $('body').on('click', '.btnMostratPagos', function(event) {
            event.preventDefault();
            var contrato_id = $(this).val();
            var tipo = $(this).data('id');
            $('#form_delete #contrato_id_value').val(contrato_id)
            listar_pagos(tabla_pagos, contrato_id, tipo);
        });


        $(document).on('click', '.deleteRestantes', function(event) {
            event.preventDefault();
            var contrato_id = $('#form_delete #contrato_id_value').val();
            Swal.fire({
              title: "¿Desea eliminar los pagos pendientes del folio: " + contrato_id,
              text: "Se eliminaran los pagos pendientes",
              icon: "warning",
              showCancelButton: true,
              confirmButtonColor: "#3085d6",
              cancelButtonColor: "#d33",
              confirmButtonText: "Si, eliminar"
            }).then((result) => {
              if (result.isConfirmed) {
                $.ajax({
                    url: baseadmin + 'delete-restantes/' + contrato_id,
                    type: 'GET',
                    dataType: 'json',
                    beforeSend:function(){
                        $("#overlay").css("display", "block");
                    },
                    success:function(res){
                        if (res.success == true) {                            
                            Swal.fire({
                              title: "Hecho",
                              text: res.message,
                              icon: "success"
                            });
                        }else{
                            Swal.fire({
                              title: "Error",
                              text: "No se pudieron eliminar los registros",
                              icon: "error"
                            });
                        }
                    }
                })
                .fail(function(jqXHR, textStatus, errorThrown) {
                    $("#overlay").css("display", "none");
                    toastr['error'](jqXHR);
                    toastr['error'](textStatus);
                    toastr['error'](errorThrown);
                })
                .always(function() {
                     $("#overlay").css("display", "none");
                });
                
              }
            });
        });

        

        /*============================================
        =            Opciones de contrato            =
        ============================================*/
        // opciones de contrato
        $('body').on('click', '#btnReenviarContrato', function(event){
            event.preventDefault();
            var cliente = $(this).data('user_name');
            var correo = $(this).data('username');
            var folio = $(this).attr('value');
            alertify.confirm('Confirmar', '¿Desea reenviar contrato del folio: '+folio+ '?<br> A: '+ cliente + ' ('+correo+')',function(){
                $.ajax({
                    url: baseadmin + 'reenviar-contrato/' + folio,
                    type: 'GET',
                    dataType: 'json',
                    beforeSend:function(){
                        $("#overlay").css("display", "block");
                    },
                    success:function(res){
                        if (res.success == true) {
                            toastr['success']('¡Contrato reenviado exitosamente!');
                        }
                        else{
                            toastr['success']('Error al reenviar contrato');
                        }
                    }
                })
                .fail(function() {
                    toastr['error']('¡No se pudo enviar el correo, intentar mas tarde!');
                })
                .always(function() {
                    $("#overlay").css("display", "none");
                });

            }
            ,function(){});
        });

        $('body').on('click', '#btnVerContrato', function(event){
            event.preventDefault();
            var contrato_id = $(this).attr('value');
            $.ajax({
                url: baseadmin + 'mostrar-contrato/'+ contrato_id,
                type: 'GET',
                dataType: 'json',
                beforeSend:function(){
                    $("#overlay").css("display", "block");
                },
                success:function(res){
                    $('#modalVerContrato .modal-body').html('');
                    $('#modalVerContrato .modal-body').html(res.formato);
                    $('#modalVerContrato #downloadPdf').attr('href', res.name);
                    $('#modalVerContrato').modal('show');
                }
            })
            .always(function() {
                $("#overlay").css("display", "none");
            });
        });
        /*=====  End of Opciones de contrato  ======*/

        /*==========================================
        =            Convertir estancia            =
        ==========================================*/
        $('body').on('click', '.btnConvertir', function(event) {
            event.preventDefault();
            var pagos = $(this).data('pagos_concretados');
            var contrato_id = $(this).attr('value');
            $('#cambio_estancia #contrato_id').val(contrato_id);
            let estancia_id_select = $(this).data('estancia_id');
            if (pagos != 0) {
                alertify.confirm('{{ __('messages.cambio_estancia') }}', 'El contrato cuenta con: '+pagos+' concretados. <br/> ¿Desea continuar con el cambio de estancia?',
                    function(){
                        cargarEstancias(estancia_id_select);
                        $('#modalCambioEstancia').modal('show');
                    }
                    ,function(){

                    });
            }else{
                cargarEstancias(estancia_id_select);
                $('#modalCambioEstancia').modal('show');
            }
        });

        $('body').on('submit', '#cambio_estancia', function(event) {
            event.preventDefault();
            alertify.confirm('{{ __('messages.cambio_estancia') }}', '¿Desea continuar con el cambio de estancia?',
                function(){
                    $.ajax({
                        url: "{{ route('contratos.cambio_estancia') }}",
                        type: 'POST',
                        dataType: 'json',
                        data: $('#cambio_estancia').serialize(),
                        beforeSend:function(){
                            $("#overlay").css("display", "block");
                        },
                        success:function(res){
                            if (res.success == true) {
                                $('#modalCambioEstancia').modal('hide');
                                toastr['success']('{{ __('messages.alerta.success') }}');
                                // window.location.reload();
                                tabla_contratos.ajax.reload();
                            }else {
                                toastr['error']('No se pudieron aplicar los cambios, intentelo mas tarde');
                            }
                        }
                    })
                    .always(function() {
                        $("#overlay").css("display", "none");
                    });
                }
                ,function(){
                    $('#modalCambioEstancia').modal('hide');
                });
        });
        /*=====  End of Convertir estancia  ======*/

        /*=======================================
        =            Editar contrato            =
        =======================================*/
        $('body').on('click', '#btnEditarContrato', function(event) {
            event.preventDefault();
            var contrato_id = $(this).attr('value');
            $('#modalGeneral .modal-dialog').removeClass('modal-xl');
            alertify.confirm('{{ __('messages.editar_contrato') }}', '¿Desea editar el contrato seleccionado?',
                function(){
                    $.ajax({
                        url: baseadmin + 'contratos/'+contrato_id+'/edit',
                        type: 'GET',
                        dataType: 'json',
                        beforeSend:function(){
                            $("#overlay").css("display", "block");
                        },
                        success:function(res){
                            if (res.success == true) {

                                $('#modalGeneral #modalGeneralLabel').html(res.titulo);
                                $('#modalGeneral #modal-body').html(res.view);
                                $('#modalGeneral').modal('show');
                            }else{
                                toastr['error']('No se pudieron aplicar los cambios, intentelo mas tarde');
                            }
                        }
                    })
                    .always(function() {
                        $("#overlay").css("display", "none");
                    });

                }
                ,function(){
                    $('#modalGeneral').modal('hide');
                });
        });

        $('body').on('submit', '#form_editar_contrato', function (event) {
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
                        // window.location.reload();
                        tabla_contratos.ajax.reload();
                        $('#modalGeneral').modal('hide');
                        toastr['success']('{{ __('messages.alerta.success') }}');
                    }else{
                        toastr['error']('No se pudieron aplicar los cambios, intentelo mas tarde');
                    }
                }
            })
            .always(function() {
                $("#overlay").css("display", "none");
                $('#modalGeneral').modal('hide');
            });
        });
        /*=====  End of Editar contrato  ======*/



        /*================================================
        =            Cambio de metodo de pago            =
        ================================================*/
        $('body').on('click', '#btnMetodoPago', function(event) {
            event.preventDefault();
            var contrato_id = $(this).attr('value');
            $('#modalGeneral .modal-dialog').removeClass('modal-xl');
            $.ajax({
                url: $(this).data('route'),
                type: 'GET',
                dataType: 'json',
                beforeSend:function(){
                    $("#overlay").css("display", "block");
                },
                success:function(res){
                    if(res.success){
                        $('#modalGeneral #modalGeneralLabel').html(res.titulo);
                        $('#modalGeneral #modal-body').html(res.view);
                        $('#modalGeneral').modal('show');
                    }
                }
            })
            .always(function() {
                $("#overlay").css("display", "none");
            });
        });

        $('body').on('submit', '#form_editar_metodo_pago', function (event) {
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
                        tabla_contratos.ajax.reload();
                        // window.location.reload();
                        toastr['success']('{{ __('messages.alerta.success') }}');
                    }else{
                        toastr['error']('No se pudieron aplicar los cambios, intentelo mas tarde');
                    }
                }
            })
            .always(function() {
                $("#overlay").css("display", "none");
                $('#modalGeneral').modal('hide');
            });
        });

        /*=====  End of Cambio de metodo de pago  ======*/



        /*================================================
        =            Agregar pago al contrato            =
        ================================================*/

        $('body').on('click', '#btnAddPago', function(event) {
            event.preventDefault();
            $('#modalAddPago #contrato_id').val($(this).attr('value'));
            $('#modalAddPago').modal('show');
        });

        $('body').on('submit', '#form_add_pago', function(event) {
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
                    if (res.success) {
                        // window.location.reload();
                        tabla_contratos.ajax.reload();
                        toastr['success']('{{ __('messages.alerta.success') }}');
                    }else
                    {
                        toastr['error']('Error! Intentelo mas tarde');
                    }
                }
            })
            .always(function() {
                $('#modalAddPago').modal('hide');
                $("#overlay").css("display", "none");
            });

        });

        /*=====  End of Agregar pago al contrato  ======*/

        /*========================================
        =            Autorizar folios            =
        ========================================*/
        $('body').on('click', '#btnAutorizar', function(event) {
            event.preventDefault();
            var contrato_id = $(this).attr('value');
             alertify.confirm('Alerta!', '¿Desea autorizar el folio: '+ contrato_id +'?',
                function(){
                    $.ajax({
                        url: baseadmin + 'autorizar-folio',
                        type: 'POST',
                        data: {contrato_id: contrato_id},
                        dataType: 'json',
                        beforeSend:function(){
                            $("#overlay").css("display", "block");
                        },
                        success:function(res){
                            if (res.success == true) {
                                tabla_contratos.ajax.reload();
                                toastr['success']('Folio autorizado');
                                setTimeout(function(){
                                    toastr["info"]("¡Contrato enviado exitosamente!");
                                }, 100)
                            }
                        }
                    })
                    .fail(function() {
                        toastr['error']('Intentar mas tarde!');
                    })
                    .always(function() {
                          $("#overlay").css("display", "none");
                    });
                }
                ,function(){}
            );
        });
        /*=====  End of Autorizar folios  ======*/




        /*==============================================
        =            Opciones de los pagos (segmentos)            =
        ==============================================*/
        $('body').on('click', '#btnEditarPago', function(event) {
            event.preventDefault();
            var pago_id = $(this).data('pago_id');
            var tarjeta_id = $(this).data('tarjeta_id');
            var contrato_id = $(this).data('contrato_id');
            $.ajax({
                url: baseadmin + 'pagos/'+pago_id +'/edit',
                type: 'GET',
                dataType: 'JSON',
                success:function(res){
                    $('#modalShowPagos').modal('hide');
                    $('#modalGeneral #modalGeneralLabel').html('Pago');
                    $('#modalGeneral #modal-body').html(res.view);
                    $('#modalGeneral').modal('show');
                }
            })
            .always(function() {
                console.log("complete");
            });
        });


        $('body').on('click', '#modalGeneral #btnCerrar', function(event) {
            event.preventDefault();
            $('#modalGeneral').modal('hide');
            $('#modalShowPagos').modal('show');
        });



        $(document).on('submit', '#form_editar_segmento', function(event) {
            event.preventDefault();
            let contrato_id = $(this).data('contrato_id');

             $.ajax({
                url: $(this).attr('action'),
                type: $(this).attr('method'),
                dataType: 'JSON',
                data: $(this).serialize(),
                beforeSend:function(){
                    $("#overlay").css("display", "block");
                    $('#modalShowPagos').modal('hide').modal('dispose');
                },
                success:function(res){
                    if (res.success == false) {
                        pintar_errores(res.errors)
                    }else{
                        $('#modalGeneral').modal('hide');
                        tabla_contratos.ajax.reload();
                        listar_pagos(tabla_pagos, contrato_id, 'all');
                        Swal.fire({
                            icon: 'success',
                            title: 'Segmento editado correctamente',
                            showConfirmButton: false,
                            timer: 1900
                        })
                    }
                    // $('#modalShowPagos').modal('show');
                }
            })
            .fail(function(jqXHR, textStatus, errorThrown) {
                $("#overlay").css("display", "none");
                toastr['error'](jqXHR);
                toastr['error'](errorThrown);
            })
            .always(function() {
                $("#overlay").css("display", "none");
            });
        });


        $('body').on('click', '#btnDeletePago', function(event) {
            event.preventDefault();
            let pago_id = $(this).data('pago_id');
            let contrato_id = $(this).data('contrato_id');
            let segmento = $(this).data('segmento');
            let estatus = $(this).data('estatus');
            let url = $(this).data('url');

            if (estatus != 'Por Pagar') {
                toastr['warning']('No se puede eliminar el segmento seleccionado');
            }else{
                alertify.confirm('Confirmar', '¿Desea eliminar el segmento '+ segmento +'?',
                function(){
                    $.ajax({
                        url: url,
                        type: 'DELETE',
                        dataType: 'json',
                        beforeSend:function(){
                            $('#modalShowPagos').modal('hide').modal('dispose');
                            $('#modalShowPagos').modal({show: false, backdrop: 'static', keyboard: true});
                        },
                        success:function(res){
                            if (res.success != true) {
                                toastr['error']('¡Intentarlo más tarde!');
                            }

                            toastr['success']('¡Segmento eliminado correctamente!');
                            tabla_contratos.ajax.reload();
                            listar_pagos(tabla_pagos, contrato_id, 'all');
                        }
                    })
                    .always(function() {
                        console.log("complete");
                    });

                }
                ,function(){

                });
            }
        });

        $('#form_delete').submit(function(event){
            event.preventDefault();
            Swal.fire({
              title: '¿Desea eliminar los segmentos seleccionados?',
              // text: "You won't be able to revert this!",
              icon: 'warning',
              showCancelButton: true,
              confirmButtonColor: '#3085d6',
              cancelButtonColor: '#d33',
              confirmButtonText: 'Si'
            }).then((result) => {
              if (result.isConfirmed) {
                $.ajax({
                    type: $(this).attr('method'),
                    url: $(this).attr('action'),
                    data: $("#form_delete").serialize(),
                    dataType: 'json',
                    beforeSend:function(){
                        $("#overlay").css("display", "block");
                        $('#modalShowPagos').modal('hide');
                    },
                    success: function (res) {
                        if (res.success == true) {
                            toastr['success']('Se eliminaron '+res.eliminados+' segmentos correctamente!');
                            tabla_contratos.ajax.reload();
                        }else{
                            toastr['error']('Intentalo mas tarde...');
                        }
                    }
                })
                .always(function() {
                    $("#overlay").css("display", "none");
                });
              }
            })
        });


        $('body').on('click', '#btnLogPago', function(event) {
            event.preventDefault();
            var pago_id = $(this).data('pago_id');

            $.ajax({
                url: baseadmin + 'get-log-pago/' + pago_id,
                type: 'GET',
                dataType: 'JSON',
                beforeSend:function(){
                    $("#overlay").css("display", "block");
                },
                success:function(res){
                    $('#modalShowPagos').modal('hide');
                    $('#modalHistorialPagos #modal-body').removeClass('historico')
                    $('#modalHistorialPagos #modal-body').addClass('historical-log')
                    $('#modalHistorialPagos #modal-body').html(res.log_pago);
                    $('#modalHistorialPagos').modal('show');
                }
            })
            .always(function() {
                $("#overlay").css("display", "none");
            });

        });


        $('body').on('click', '#modalHistorialPagos #btnCerrar, #modalHistorialPagos #btnCerrar1', function(event) {
            event.preventDefault();
            $('#modalHistorialPagos').modal('hide');
            $('#modalShowPagos').modal('show');
        });

        $('body').on('click', '#modalShowPagos #btnCerrar, #modalShowPagos #btnCerrar1', function(event) {
            event.preventDefault();
            $('#modalShowPagos').modal('hide');
        });

        /*=====  End of Opciones de los pagos (segmentos)  ======*/


        $(document).on('click', '#btnSelect', function(event) {
            event.preventDefault();
            var estancia_id = $(this).data('estancia_id');
            var estancia_nombre = $(this).data('estancia_nombre');
            $('#estancia_id').val(estancia_id);
            toastr['info']('Se ha seleccionad la estancia: '+ estancia_nombre);

            if (estancia_id == 37728 || estancia_id == 37727) {
                // $('#div_num_pax').css('display','block');
                $('#div_num_pax').html('<label for="inputPassword4"># de adultos</label><select class="form-control" id="num_pax" name="num_pax"><option value="2">2</option><option value="3">3</option><option value="4">4</option></select><span class="text-danger error-numero_tarjeta errors"></span>');
            }else{
                $('#div_num_pax').html('');
            }
        });

        $(document).on('change', '#estancia_id', function(event) {
            event.preventDefault();

            var estancia_id = $(this).val();

            // console.log(estancia_id);

            if (estancia_id == 37728 || estancia_id == 37727) {
                // $('#div_num_pax').css('display','block');
                 $('#div_num_pax').html('<label for="inputPassword4"># de adultos</label><select class="form-control" id="num_pax" name="num_pax"><option value="2">2</option><option value="3">3</option><option value="4">4</option></select><span class="text-danger error-numero_tarjeta errors"></span>');
            }else{
                // $('#div_num_pax').css('display','none');
                 $('#div_num_pax').html('');
            }
        });


 
        ///////////////////////
        // ELiminar users // //
        ///////////////////////
        $(document).on('click', '#btnEliminar', function(event) {
            event.preventDefault();
            var url = $(this).data('url');

            alertify.confirm('Confirmar', '¿Desea eliminar el usuario? <br> No podrá revertir esta acción, se eliminara todo lo relacionado a este usuario, ¿Esta seguro?.',
                function(){
                    $.ajax({
                        url: $(this).data('url'),
                        type: 'DELETE',
                        dataType: 'json',
                        beforeSend:function(){
                             $("#overlay").css("display", "block");
                        },
                        success:function(res){
                            if (res.success == true) {
                                toastr['success'](res.message);
                                setTimeout(function(){
                                    window.location.href = res.url;
                                },500);
                            }else{
                                toastr['error'](res.message);
                            }
                        }
                    })
                    .fail(function() {
                        console.log("error");
                    })
                    .always(function() {
                        $("#overlay").css("display", "none");
                    });

                }
                ,
                function(){

                }
            );
        });


        ///////////////////////
        //Eliminar contrato  //
        ///////////////////////
        $('body').on('click', '#btnDeleteContrato', function(event) {
            event.preventDefault();

            var id = $(this).attr('value');
            var url = $(this).data('url');
            alertify.confirm('Confirmar', '¿Desea eliminar el folio: <b>'+ id +'</b>? <br> Se eliminara todo lo relacionado a este folio',
                function(){
                    $.ajax({
                        url: url,
                        type: 'DELETE',
                        dataType: 'json',
                        beforeSend:function(){
                            $("#overlay").css("display", "block");
                        }
                    })
                    .done(function(res) {
                        if (res.success == true) {
                            toastr['success']('¡Folio eliminado exitosamente!');
                            tabla_contratos.ajax.reload();
                        }else{
                            toastr['error'](res.errors);
                        }
                    })
                    .fail(function(jqXHR, textStatus, errorThrown) {
                        $("#overlay").css("display", "none");
                        toastr['error'](errorThrown);
                        toastr['error'](textStatus);
                    })
                    .always(function() {
                        $("#overlay").css("display", "none");
                    });

                }
                ,function(){}
            );
        });


        //////////////
        // Tarjetas //
        //////////////
        $('body').on('click', '#btnEliminarTarjeta', function(event) {
            event.preventDefault();
            var url         = $(this).data('url_tarjeta');
            var tarjeta     = $(this).data('tarjeta');
            const flag      = $(this).data('flag');
            const message     = $(this).data('message');
            let confirmarText = '';

            if (flag == 1) {
                // La tarjeta se encuenta vinculada a los siguientes registros: ' +
                confirmarText =  message + '<br><br> ¿Desea forzar la eliminación de la tarjeta con terminación: <b>'+ tarjeta +'</b>? <br> <small>Se desvinculara automaticamente de los registros existentes<small>';
            }else{
                confirmarText = '¿Desea eliminar la tarjeta con terminación: <b>'+ tarjeta +'</b>? <br> ';
            }

             alertify.confirm('Confirmar', confirmarText,
                function(){
                    $.ajax({
                        url: url,
                        type: 'DELETE',
                        dataType: 'json',
                        beforeSend:function(){
                            $("#overlay").css("display", "block");
                        },
                        success:function(res){
                            console.log(res);
                            if (res.success == true) {
                                toastr['success']('¡Tarjeta eliminada exitosamente!');
                                tabla.ajax.reload();
                            }else{
                                toastr['warning'](res.message);
                                toastr['error']('No se pudo eliminar la tarjeta seleccionada');
                            }
                        }
                    })
                   .fail(function(jqXHR, textStatus, errorThrown) {
                        $("#overlay").css("display", "none");
                        toastr['error'](errorThrown);
                        toastr['error'](jqXHR.responseJSON.message);
                    })
                    .always(function() {
                        $("#overlay").css("display", "none");
                    });
                },function(){}
            );
        });



        // Agregar imagenes de calidad
        $(document).on('click', '#btnCalidad', function(event) {
            event.preventDefault();
            $('#imageUploadForm').attr('action', $(this).data('url'));
            $('#contrato_id').val($(this).attr('value'));
            $('#modalAddCalidad').modal('show');
        });


        $('#imageUploadForm').on('submit', function (e) {
            e.preventDefault();
            var formData = new FormData(this);
            $.ajax({
                url: $(this).attr('action'),
                type: $(this).attr('method'),
                data: formData,
                contentType: false,
                processData: false,
                beforeSend:function(){
                     $("#overlay").css("display", "block");
                },
                success: function (data) {
                    if (data.success == true) {
                        $('#modalAddCalidad').modal('hide');
                        toastr['success']('¡Se cargaron correctamente los respaldos de calidad!')
                        $('#imageUploadForm').trigger('reset');
                        tabla_contratos.ajax.reload();
                    }else{
                        toastr['error']('No se pudieron cargar los respaldos de calidad')
                    }
                }
            })
            .fail(function(jqXHR, textStatus, errorThrown) {
                $("#overlay").css("display", "none");
                toastr['error'](errorThrown);
                toastr['error'](jqXHR.responseJSON.message);
            })
            .always(function() {
                $("#overlay").css("display", "none");
            });
        });


        $(document).on('click', '#btnVerCalidad', function(event) {
            event.preventDefault();
            var contrato_id = $(this).attr('value');
            $.ajax({
                url: $(this).data('url'),
                type: 'GET',
                dataType: 'JSON',
                beforeSend:function(){
                     $("#overlay").css("display", "block");
                },
                success:function(res){
                    $('#modalVerCalidad #titleCalidad').html('Respaldos de calidad del folio: ' + contrato_id);
                    $('#modalVerCalidad #modal-body').html(res.view);
                    $('#modalVerCalidad').modal('show');
                }
            })
            .fail(function(jqXHR, textStatus, errorThrown) {
                $("#overlay").css("display", "none");
                toastr['error'](errorThrown);
            })
            .always(function() {
                $("#overlay").css("display", "none");
            });
            
        });


        $(document).on('click', '#btnEliminarCalidad', function(event) {
            event.preventDefault();
            var imagen_id = $(this).attr('value');
            var url = $(this).attr('href');
            var nombre = $(this).data('nombre');
            var elemento = $(this).data('elemento');
            
            alertify.confirm('Eliminar respaldo de calidad', '¿Desea eliminar el archivo: '+ nombre +'?',
                function(){
                    $.ajax({
                         url: url,
                         type: 'delete',
                         dataType: 'JSON',
                         beforeSend:function(){
                             $("#overlay").css("display", "block");
                         },
                         success:function(res){
                            if (res.success == true) {
                                $('#'+elemento).remove();
                                toastr['success']('¡Archivo eliminado exitosamente!');
                                tabla_contratos.ajax.reload();
                            }else{
                                toastr['error']('¡No se pudo eliminar el archivo, intenta mas tarde!');
                            }
                         }
                    })
                    .fail(function(jqXHR, textStatus, errorThrown) {
                        $("#overlay").css("display", "none");
                        toastr['error'](errorThrown);
                    })
                     .always(function() {
                        $("#overlay").css("display", "none");
                     });

                },
                function(){}
            );
        });


    });


    function cargarEstancias(estancia_id_select) {
        var estancias = @json($estancias_global);
        $('#estancia_id').html('')
        $.each(estancias, function(index, val) {
            if (val.id == estancia_id_select) {
                $('#estancia_id').append('<option selected value="'+val.id+'">'+val.title+'</option>');
            }else{
                $('#estancia_id').append('<option value="'+val.id+'">'+val.title+'</option>');
            }
        });
    }

    function pintar_pagos(aaData) {
        $.each(aaData, function(i, v) {
            if (v[6] != 'Pagado') {
                $('body #add_pagos_contrato #tablePagos #tableBody').append('<tr><td>'+v[1]+'<input type="hidden" name="segmento[]" value="'+v[1]+'"/><input type="hidden" name="pago_id[]" value="'+v[8]+'"/></td><td>'+v[4]+'<br/>'+moment(v[4]).format('LL')+'<input type="hidden" name="fecha_de_cobro[]" value="'+v[4]+'"/></td><td>$ '+v[3]+'<input type="hidden" name="cantidad[]" value="'+v[3]+'"/> <input type="hidden" name="concepto[]" value="'+v.concepto+'"/></td></tr>');
            }
        });
    }

    function listar_pagos(tabla_pagos, contrato_id, tipo){
        $.ajax({
            url: baseuri + 'admin/listar-pagos-contrato/'+contrato_id + '/'+ tipo,
            type: 'get',
            dataType: 'json',
            beforeSend:function(){
                $("#overlay").css("display", "block");
            },
            success:function(res){
                $('#modalShowPagos').modal('show');
                $('#modalShowPagos #folioContrato').html(+contrato_id);
                tabla_pagos = $('#table_pagos').dataTable({
                    'responsive': true,
                    'searching': false,
                    "aoColumns": [{
                        "mData": "9"
                    },{
                        "mData": "1"
                    }, {
                        "mData": "2"
                    }, {
                        "mData": "3"
                    }, {
                        "mData": "4"
                    }, {
                        "mData": "5"
                    }, {
                        "mData": "7"
                    }],
                    data: res.aaData,
                    "bDestroy": true
                }).DataTable();
            }
        })
        .fail(function(jqXHR, textStatus, errorThrown) {
            $("#overlay").css("display", "none");
            toastr['error'](errorThrown + ' <br> '+ textStatus);
            toastr['error'](jqXHR);
        })
        .always(function() {
            $("#overlay").css("display", "none");
        });
    }
</script>
