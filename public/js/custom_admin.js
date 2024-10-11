$(document).ready(function() {
    $('#app_search').submit(function(event) {
        event.preventDefault();
        var search = $('#text_search').val();
        if (auth == 1) {
            $.ajax({
                url: baseuri + 'admin/buscar-usuario/' + search,
                type: 'GET',
                dataType: 'json',
                beforeSend: function() {
                    $("#overlay").css("display", "block");
                },
                success: function(res) {
                    $(this).trigger('reset');
                    var tabla = $('#tableSearch').dataTable({
                        'responsive': true,
                        "aoColumns": [{
                            "mData": "convenio"
                        }, {
                            "mData": "usuario"
                        }, {
                            "mData": "username"
                        }, {
                            "mData": "btn"
                        }],
                        data: res.aaData,
                        "order": [1, 'desc'],
                        "bDestroy": true
                    }).DataTable();
                    $('#modalSearch').modal('show');
                }
            }).always(function() {
                $('#text_search').val('');
                $("#overlay").css("display", "none");
            });
        } else {
            toastr['warning']('Sesion finalizada');
            window.location.href = baseuri + 'login';
        }
    });
    $('body').on('submit', '#app_search_2', function(event) {
        event.preventDefault();
        var search = $('#text_search_2').val();
        if (auth == 1) {
            $.ajax({
                url: baseuri + 'admin/buscar-usuario/' + search,
                type: 'GET',
                dataType: 'json',
                beforeSend: function() {
                    $("#overlay").css("display", "block");
                },
                success: function(res) {
                    $(this).trigger('reset');
                    $('#modalBuscarCliente').modal('hide');
                    var tabla = $('#tableSearch').dataTable({
                        'responsive': true,
                        "aoColumns": [{
                            "mData": "convenio"
                        }, {
                            "mData": "usuario"
                        }, {
                            "mData": "username"
                        }, {
                            "mData": "btn"
                        }],
                        data: res.aaData,
                        "order": [1, 'desc'],
                        "bDestroy": true
                    }).DataTable();
                    $('#modalSearch').modal('show');
                }
            }).always(function() {
                $('#text_search_2').val('');
                $("#overlay").css("display", "none");
            });
        } else {
            toastr['warning']('Sesion finalizada');
            window.location.href = baseuri + 'login';
        }
    });
    /**
     * Eliminar cache 
     */
    // $(document).on('click', '#btnEliminarCache', function(event) {
    //     event.preventDefault();
    //     toastr['info']('eliminar cache')
    // });
    $('#btnEliminarCache').on('click', function(event) {
        event.preventDefault();
        $.ajax({
            url: baseadmin + 'artisan-clear',
            type: 'GET',
            dataType: 'json',
            beforeSend: function() {
                $('#modalClear').modal('show');
            },
            success: function(res) {
                $('#modalClear').modal('hide');
                if (res.success == true) {
                    Toast.fire({
                        icon: 'success',
                        title: '¡Comando ejecutado exitosamente!',
                    })
                    // Swal.fire({
                    //     // position: 'top-end',
                    //     icon: 'success',
                    //     title: '¡Comando ejecutado exitosamente!',
                    //     showConfirmButton: false,
                    //     timer: 3000
                    // })
                } else {
                    Toast.fire({
                        icon: 'error',
                        title: '¡No se pudo ejecutiar el comando!',
                    })
                }
            }
        }).fail(function() {}).always(function() {});
    });
});

function pintar_errores(errores = null) {
    $(".errors").html('');
    $(".errors").parent().removeClass('has-error');
    $.each(errores, function(k, v) {
        $(".error-" + k).html(v + ' <br/>');
        $(".error-" + k).parent().addClass('has-error');
    });
}