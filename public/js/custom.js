$(document).ready(function() {
    toastr.options = {
        "closeButton": true,
        "debug": false,
        "newestOnTop": false,
        "progressBar": true,
        "positionClass": "toast-top-right",
        "preventDuplicates": false,
        "onclick": null,
        "showDuration": "400",
        "hideDuration": "1000",
        "timeOut": "5000",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
    }
    $('#loginform').submit(function(e) {
        e.preventDefault();
        $.ajax({
            type: $(this).attr('method'),
            url: $(this).attr('action'),
            data: $(this).serialize(),
            dataType: "json",
            beforeSend: function() {
                $('#overlay').css('display', 'block');
                $('#btnLogin').html('Espere...');
            },
            success: function(res) {
                console.log(res);
                if (res.success == false && res.user == false) {
                    toastr['error'](res.error);
                    // } else if (res.url == false && res.success == true) {
                    //     toastr['info']('Usuario administrativo, redireccionando...');
                    //     setTimeout(function() {
                    //         window.location.href = 'http://admin.beneficiosvacacionales.mx';
                    //     }, 500)
                } else if (res.success == true) {
                    toastr['info']('Redireccionando...');
                    window.location.href = res.url;
                }
            }
        }).always(function() {
            $('#btnLogin').html('Entrar');
            $('#overlay').css('display', 'none');
        });
    });
    $('#form_reset_password').submit(function(event) {
        event.preventDefault();
        $.ajax({
            url: $(this).attr('action'),
            type: $(this).attr('method'),
            dataType: 'json',
            data: $(this).serialize(),
            beforeSend: function() {
                $('#overlay').css('display', 'block');
            },
            success: function(res) {
                toastr[(res.success == true) ? 'success' : 'error'](res.message);
            }
        }).always(function() {
            $('#overlay').css('display', 'none');
        });
    });
    $('#recoverform').submit(function(event) {
        event.preventDefault();
        $.ajax({
            url: $(this).attr('action'),
            type: $(this).attr('method'),
            dataType: 'json',
            data: $(this).serialize(),
            beforeSend: function() {
                $('#overlay').css('display', 'block');
                $('#btnLogin').html('Espere...');
            },
            success: function(res) {
                toastr[(res.success == true) ? 'success' : 'error'](res.message);
            }
        }).always(function() {
            $('#overlay').css('display', 'none');
            $('#btnLogin').html('Entrar');
        });
    });
    $('body').on('click', '.modal_hoteles', function(event) {
        event.preventDefault();
        $hotel = $(this).data('hotel');
        $('#modalHoteles #titulo').html($(this).data('titulo'));
        $('#modalHoteles .modal-body').html('<img src="' + $hotel + '" class="img-fluid" alt="Responsive image">');
        $('#modalHoteles').modal('show');
    });
    $('body').on('submit', '#form_register_alert_mx', function(event) {
        event.preventDefault();
        $.ajax({
            url: baseuri + "user-alert-mx",
            type: 'POST',
            dataType: 'json',
            data: $(this).serialize(),
            beforeSend: function() {
                $('#form_register_alert_mx #submit').html('Enviando...');
                $('#form_register_alert_mx #submit').prop("disabled", true);
            },
            success: function(res) {
                console.log(res);
                if (res.success == false) {
                    pintar_errores(res.errors);
                    grecaptcha.reset();
                }
                if (res.success == true) {
                    $('#moda_pre_registro_mx').modal('hide');
                    $('#form_register_alert_mx').trigger('reset');
                    toastr['success']('¡Gracias! <br>  En breve un asesor de ventas se pondrá en contacto con usted.');
                    toastr.options = {
                        "closeButton": true,
                        "debug": false,
                        "newestOnTop": false,
                        "progressBar": true,
                        "positionClass": "toast-top-right",
                        "preventDuplicates": false,
                        "onclick": null,
                        "showDuration": "300",
                        "hideDuration": "3000",
                        "timeOut": "8000",
                        "extendedTimeOut": "1000",
                        "showEasing": "swing",
                        "hideEasing": "linear",
                        "showMethod": "fadeIn",
                        "hideMethod": "fadeOut"
                    }
                };
            }
        }).always(function() {
            $('#form_register_alert_mx #submit').html('Enviar');
            $('#form_register_alert_mx #submit').prop("disabled", false);
        });
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