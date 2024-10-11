<div aria-hidden="true" aria-labelledby="modalColor" class="modal fade" data-backdrop="static" id="modalColor" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalColorLabel">
                    Seleccionar un color
                </h5>
                <button aria-label="Close" class="close" data-dismiss="modal" type="button">
                    <span aria-hidden="true">
                        ×
                    </span>
                </button>
            </div>
            <div class="modal-body">
                <p>
                    Version Beta v2.1
                </p>
                <div class="row">
                    <div class="col-md-3">
                        <label for="">
                            MX
                        </label>
                        <a class="cambiar_color" data-color="mx" href="javascript():;">
                            <img alt="" class="img-thumbnail" src="{{ asset('images/mx.png') }}">
                            </img>
                        </a>
                    </div>
                    <div class="col-md-3">
                        <label for="">
                            Navidad
                        </label>
                        <a class="cambiar_color" data-color="navidad" href="javascript():;">
                            <img alt="" class="img-thumbnail" src="{{ asset('images/navidad.png') }}">
                            </img>
                        </a>
                    </div>
                    <div class="col-md-3">
                        <label for="">
                            Halloween
                        </label>
                        <a class="cambiar_color" data-color="halloween" href="javascript():;">
                            <img alt="" class="img-thumbnail" src="{{ asset('images/halloween.png') }}">
                            </img>
                        </a>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3">
                        <label for="">
                            Blue
                        </label>
                        <a class="cambiar_color" data-color="white" href="javascript():;">
                            <img alt="" class="img-thumbnail" src="{{ asset('images/light.png') }}">
                            </img>
                        </a>
                    </div>
                    <div class="col-md-3">
                        <label for="">
                            Blue Dark
                        </label>
                        <a class="cambiar_color" data-color="black" href="javascript():;">
                            <img alt="" class="img-thumbnail" src="{{ asset('images/black.png') }}">
                            </img>
                        </a>
                    </div>
                    <div class="col-md-3">
                        <label for="">
                            Green
                        </label>
                        <a class="cambiar_color" data-color="green" href="javascript():;">
                            <img alt="" class="img-thumbnail" src="{{ asset('images/green.png') }}">
                            </img>
                        </a>
                    </div>
                    <div class="col-md-3">
                        <label for="">
                            Green Dark
                        </label>
                        <a class="cambiar_color" data-color="green-dark" href="javascript():;">
                            <img alt="" class="img-thumbnail" src="{{ asset('images/green-dark.png') }}">
                            </img>
                        </a>
                    </div>
                    <div class="col-md-3">
                        <label for="">
                            Red
                        </label>
                        <a class="cambiar_color" data-color="red" href="javascript():;">
                            <img alt="" class="img-thumbnail" src="{{ asset('images/rojo.png') }}">
                            </img>
                        </a>
                    </div>
                    <div class="col-md-3">
                        <label for="">
                            Red Dark
                        </label>
                        <a class="cambiar_color" data-color="red-dark" href="javascript():;">
                            <img alt="" class="img-thumbnail" src="{{ asset('images/red-dark.png') }}">
                            </img>
                        </a>
                    </div>
                    <div class="col-md-3">
                        <label for="">
                            Purple
                        </label>
                        <a class="cambiar_color" data-color="purple" href="javascript():;">
                            <img alt="" class="img-thumbnail" src="{{ asset('images/morado.png') }}">
                            </img>
                        </a>
                    </div>
                    <div class="col-md-3">
                        <label for="">
                            Purple Dark
                        </label>
                        <a class="cambiar_color" data-color="purple-dark" href="javascript():;">
                            <img alt="" class="img-thumbnail" src="{{ asset('images/purple-dark.png') }}">
                            </img>
                        </a>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" data-dismiss="modal" type="button">
                    Cerrar
                </button>
                <button class="btn btn-primary cambiar_color" data-color="white" type="submit">
                    No volver a mostrar
                </button>
            </div>
        </div>
    </div>
</div>
<script>
    $('body').on('click', '.cambiar_color', function(event) {
        event.preventDefault();

        // if ($(this).data('color') == 'black') {
        //     $('#theme').attr('href', "{{  asset('back/css/colors/mbv-dark.css')  }}");   
        // }else{
               
        // }

        switch($(this).data('color')) {
            case 'black':
                 $('#theme').attr('href', "{{  asset('back/css/colors/mbv-dark.css')  }}");  
                break;
            case 'white':
                $('#theme').attr('href', "{{  asset('back/css/colors/blue.css')  }}"); 
                break;

            case 'green':
                $('#theme').attr('href', "{{  asset('back/css/colors/green.css')  }}"); 
                break;

            case 'green-dark':
                $('#theme').attr('href', "{{  asset('back/css/colors/green-dark-2.css')  }}"); 
                break;

            case 'red':
                $('#theme').attr('href', "{{  asset('back/css/colors/red.css')  }}"); 
                break;
            case 'red-dark':
                $('#theme').attr('href', "{{  asset('back/css/colors/red-black-2.css')  }}"); 
                break;

            case 'purple':
                $('#theme').attr('href', "{{  asset('back/css/colors/purple.css')  }}"); 
                break;
            case 'purple-dark':
                $('#theme').attr('href', "{{  asset('back/css/colors/purple-dark-2.css')  }}"); 
                break;

            case 'mx':
                $('#theme').attr('href', "{{  asset('back/css/colors/mx.css')  }}"); 
                break; 

            case 'navidad':
                $('#theme').attr('href', "{{  asset('back/css/colors/navidad.css')  }}"); 
                break;

            case 'halloween':
                $('#theme').attr('href', "{{  asset('back/css/colors/halloween.css')  }}"); 
                break;

            default:
                $('#theme').attr('href', "{{  asset('back/css/colors/blue.css')  }}"); 

        }

        $.ajax({
            url: baseadmin + 'cambiar-color/' + $(this).data('color'),
            type: 'GET',
            dataType: 'JSON',
            success:function(res){
                    $('#modalColor').modal('hide');
                if (res.success==true) {
                    $('#modalColor').modal('hide');
                    toastr["success"]('¡Se ha cambiado el color correctamente!')
                }else{
                    toastr["error"]('¡Intenta mas tarde!')
                    $('#modalColor').modal('hide');
                }
            }
        });
    });
</script>