$(document).ready(function() {
    $('body').on('click', '#btnSiguiente', function(event) {
        event.preventDefault();
        $.ajax({
            url: baseuri + 'process-payment/create',
            type: 'GET',
            dataType: 'json',
            data: $('#form_compra_eu').serialize(),
            beforeSend: function() {
                $("#overlay").css("display", "block");
            },
            success: function(res) {
                if (res.success == false) {
                    pintar_errores(res.errors);
                }
                if (res.success == true) {
                    window.location.href = res.card;
                }
            }
        }).always(function() {
            $("#overlay").css("display", "none");
        });
    });
    var element = document.getElementById('card_number');
    var maskOptions = {
        mask: '0000-0000-0000-0000'
    };
    var mask = IMask(element, maskOptions);
    var element2 = document.getElementById('cvv2');
    var maskOptions2 = {
        mask: '0000'
    };
    var mask = IMask(element2, maskOptions2);
    var element3 = document.getElementById('expiration');
    var maskOptions3 = {
        mask: '00/00'
    };
    var mask = IMask(element3, maskOptions3);
    $('#showTerminos').on('click', function(event) {
        event.preventDefault();
        $('#modalTerminos').modal('show');
    });
    $('body').on('submit', '#paymentOpt', function(event) {
        event.preventDefault();
        $.ajax({
            type: $(this).attr('method'),
            url: $(this).attr('action'),
            data: $(this).serialize(),
            dataType: "json",
            beforeSend: function() {
                $("#overlay").css("display", "block");
            },
            success: function(res) {
                if (res.success == false || res.success_pay == false) {
                    if (res.errors) {
                        pintar_errores(res.errors);
                    } else {
                        if (res.error_code) {
                            toastr['error'](res.errorMessage[0]);
                        } else {
                            if (res.res_charge != 'Check your payment method') {
                                toastr['error'](res.res_charge);
                            } else {
                                toastr['error'](res.res_avs);
                            }
                        }
                    }
                } else if (res.success == true || res.success_pay == true) {
                    // if (res.code_pay == '00') {
                    //     toastr['success']('Succesful transaction');
                    // }
                    toastr['success']('Succesful transaction');
                    window.location = res.url;
                } else {
                    alert('sin accion');
                }
            }
        }).fail(function() {
            $("#overlay").css("display", "none");
        }).always(function() {
            $("#overlay").css("display", "none");
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