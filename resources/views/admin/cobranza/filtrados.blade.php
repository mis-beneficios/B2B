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
</style>
<div class="row page-titles">
    <div class="col-md-5 col-8 align-self-center">
        <h3 class="text-themecolor text-capitalize">
            Filtrados
        </h3>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('dashboard') }}">
                    Home
                </a>
            </li>
            <li class="breadcrumb-item active">
                Filtrados
            </li>
        </ol>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item"> 
                        <a class="nav-link active" id="home-tab" data-toggle="tab" href="#serfin" role="tab" aria-controls="serfin" aria-expanded="false"><span class="hidden-sm-up">
                            <i class="ti-home"></i></span> <span class="hidden-xs-down">SERFIN</span>
                        </a> 
                    </li>
                    <li class="nav-item"> 
                        <a class="nav-link " id="profile-tab" data-toggle="tab" href="#suspendidos" role="tab" aria-controls="suspendidos" aria-expanded="true"><span class="hidden-sm-up">
                            <i class="ti-user"></i></span><span class="hidden-xs-down">Folios suspendidos</span>
                        </a>
                    </li>
                    <li class="nav-item"> 
                        <a class="nav-link " id="profile-tab" data-toggle="tab" href="#sin_segmento" role="tab" aria-controls="sin segmento" aria-expanded="true"><span class="hidden-sm-up">
                            <i class="ti-user"></i></span><span class="hidden-xs-down">Sin segmento</span>
                        </a>
                    </li>
                    <li class="nav-item"> 
                        <a class="nav-link " id="profile-tab" data-toggle="tab" href="#bbva" role="tab" aria-controls="BBVA" aria-expanded="true"><span class="hidden-sm-up">
                            <i class="ti-user"></i></span><span class="hidden-xs-down">BBVA</span>
                        </a>
                    </li>
                    <li class="nav-item"> 
                        <a class="nav-link " id="profile-tab" data-toggle="tab" href="#cobranda_doble" role="tab" aria-controls="profile" aria-expanded="true"><span class="hidden-sm-up">
                            <i class="ti-user"></i></span><span class="hidden-xs-down">Cobranza doble</span>
                        </a>
                    </li>
                </ul>
                <div class="tab-content tabcontent-border p-20" id="myTabContent">
                    <div class="tab-pane fade active show" id="serfin" role="tabpanel" aria-labelledby="home-tab" aria-expanded="true">
                        <div class="row mt-4">
                            <div class="col-lg-8 col-md-12 col-md">
                                <form action="{{ route('cobranza.filtrado_serfin') }}" id="formFiltrado" method="get" class="mb-5">
                                    @csrf
                                    <div class="form-row">
                                        <div class="form-group col-md-3 mt-3">
                                            <label>
                                                Bancos
                                            </label>
                                            <div class="form-check">
                                                <input checked="" class="form-check-input" id="sinBancomer" name="select_banco" type="radio" value="sinBancomer"/>
                                                <label class="form-check-label" for="sinBancomer">
                                                    Sin Bancomer
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input  class="form-check-input" id="soloBancomer" name="select_banco" type="radio" value="soloBancomer"/>
                                                <label class="form-check-label" for="soloBancomer">
                                                    Solo bancomer
                                                </label>
                                            </div>

                                            <div class="form-check">
                                                <input  class="form-check-input" id="todo" name="select_banco" type="radio" value="todo"/>
                                                <label class="form-check-label" for="todo">
                                                    Todos
                                                </label>
                                            </div>
                                        </div>
                                        <div class="form-group col-md">
                                            <label for="inputAddress">
                                                Fecha de inicio
                                            </label>
                                            <input autocomplete="false"  class="form-control datepicker" id="fecha_inicio" name="fecha_inicio" type="text" value="{{ date('Y-m-d') }}"/>
                                        </div>
                                        <div class="form-group col-md">
                                            <label for="inputAddress2">
                                                Fecha de fin
                                            </label>
                                            <input autocomplete="false" class="form-control datepicker" id="fecha_fin" name="fecha_fin" type="text" value="{{ date('Y-m-d') }}"/>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-md-3">
                                            <div class="demo-switch-title">Filtrar con algún segmento</div>
                                            <div class="switch">
                                                <label><input type="checkbox" id="con_filtro" name="con_filtro"><span class="lever switch-col-blue"></span></label>
                                            </div>
                                        </div>
                                        <div class="form-group col-lg-2 col-md-3" id="add_filtrado" style="display: none">
                                            <select class="form-control" id="condicion"  name="condicion" style="width:100%">
                                                <option value="solo">
                                                    Solo segmento
                                                </option>
                                                <option value="contenga">
                                                    Contenta
                                                </option>
                                                <option value="entre">
                                                    Entre
                                                </option>
                                            </select>
                                        </div>
                                        <div class="form-group col-lg-2 col-md-3" id="add_filtrado_2" style="display: none">
                                            <input autocomplete="false" class="form-control" id="segmento" name="segmento" type="text"/>
                                        </div>
                                    </div>

                                    <div class="form-row">
                                        <div class="form-group col-md-3 mt-3">
                                            <label for="inputAddress">
                                                Estatus de pago
                                            </label>
                                            <div class="form-check">
                                                <input checked="" class="form-check-input" id="por_pagar" name="estatus_pago" type="radio" value="por_pagar"/>
                                                <label class="form-check-label" for="por_pagar">
                                                    Por pagar
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input  class="form-check-input" id="rechazado" name="estatus_pago" type="radio" value="Rechazado"/>
                                                <label class="form-check-label" for="rechazado">
                                                    Rechazados
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input  class="form-check-input" id="pagados" name="estatus_pago" type="radio" value="Pagado"/>
                                                <label class="form-check-label" for="pagados">
                                                    Pagados
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <button class="btn btn-success" type="submit">
                                        <i class="fas fa-download">
                                        </i>
                                        Descargar
                                    </button>
                                </form>                        
                            </div>
                            <div class="col-lg-4 col-md-12">
                                <div class="alert alert-info alert-dismissible">
                                    <button aria-hidden="true" class="close" data-dismiss="alert" type="button">
                                        ×
                                    </button>
                                    <h5>
                                        <i class="icon fas fa-ban">
                                        </i>
                                        Info!
                                    </h5>
                                    Para filtrados con algun segmento, es importante serparar los segmentos en caso de que el filtrado sea por:
                                    <ul>
                                        <li>
                                            <b>CONTENGA: </b> Los segmentos que quieren que aparezcan en el filtrado
                                        </li>
                                        <li>
                                            <B>ENTRE: </b> Los segmentos que inicia con un primer segmento de inicio y termina con un final el cual se obtendran todos los segmentos que esten entre esos dos segmentos ingresados   
                                        </li>
                                    </ul>
                                </div>  
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="suspendidos" role="tabpanel" aria-labelledby="suspendidos-tab" aria-expanded="false">
                        <form action="{{ route('cobranza.filtrado_suspendidos') }}" id="formFiltradoSuspendidos" method="get" class="mb-5">
                            @csrf
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="form-row">
                                        <div class="form-group col-md-2">
                                            <label for="">
                                                Fecha de inicio
                                            </label>
                                            <input autocomplete="false" class="form-control datepicker" id="fecha_inicio_suspendido" name="fecha_inicio_suspendido" type="text" value="{{ date('Y-m-d') }}"/>
                                        </div>
                                        <div class="form-group col-md-2">
                                            <label for="">
                                                Fecha de fin
                                            </label>
                                            <input autocomplete="false" class="form-control datepicker" id="fecha_fin_suspendido" name="fecha_fin_suspendido" type="text" value="{{ date('Y-m-d') }}"/>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="">Cantidad:</label>
                                                <input autocomplete="false" class="form-control" id="cantidad_sus" name="cantidad_sus" type="text"/>
                                            </div>
                                        </div>
                                    </div>
                                    <button class="btn btn-success" type="submit">
                                        <i class="fas fa-download"> 
                                        </i>
                                        Descargar
                                    </button>
                                </div>
                                <div class="col-md-4">
                                    <div class="alert alert-info alert-dismissible">
                                        <button aria-hidden="true" class="close" data-dismiss="alert" type="button">
                                            ×
                                        </button>
                                        <h5>
                                            <i class="icon fas fa-ban">
                                            </i>
                                            Info!
                                        </h5>
                                        <ul>
                                            <li>
                                                Ingresa el rango de fechas en el cual se requiere obtener el filtrado de contratos suspendidos 
                                            </li>
                                            <li>
                                                Ingresa la cantidad la cual aparecera en el filtrado de los contratos suspendidos.
                                            </li>
                                        </ul>
                                    </div>  
                                </div>
                            </div>
                        </form>   
                    </div>
                    <div class="tab-pane fade" id="sin_segmento" role="tabpanel" aria-labelledby="sin_segmento-tab" aria-expanded="false">
                        <div class="row mt-2">
                            <div class="col-md-8">
                                <div class="card-body">
                                    <form action="{{ route('cobranza.filtrado_sin_segmentos') }}" id="fromSinSegmento" method="get" class="mb-5">
                                        @csrf
                                        <div class="row">
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="">Cantidad:</label>
                                                    <input autocomplete="false" class="form-control" id="cantidad" name="cantidad" type="text"/>
                                                </div>
                                            </div>
                                        </div>
                                        <button class="btn btn-success" type="submit">
                                            <i class="fas fa-download"></i>
                                            Descargar
                                        </button>
                                    </form>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="alert alert-info alert-dismissible">
                                    <button aria-hidden="true" class="close" data-dismiss="alert" type="button">
                                        ×
                                    </button>
                                    <h5>
                                        <i class="icon fas fa-ban">
                                        </i>
                                        Info!
                                    </h5>
                                    Ingresa la cantidad la cual aparecera en el filtrado de los contratos sin segmentos.
                                </div>  
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="bbva" role="tabpanel" aria-labelledby="profile-tab" aria-expanded="false">
                        <form action="{{ route('cobranza.filtrado_bancomer') }}" id="formFiltradoBancomer" method="get" class="mb-5">
                            @csrf
                            <div class="form-row">
                                <div class="form-group col-md-2">
                                    <label for="">
                                        Fecha de inicio
                                    </label>
                                    <input autocomplete="false" class="form-control datepicker" id="fecha_inicio_bancomer" name="fecha_inicio_bancomer" type="text" value="{{ date('Y-m-d') }}"/>
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="">
                                        Fecha de fin
                                    </label>
                                    <input autocomplete="false" class="form-control datepicker" id="fecha_fin_bancomer" name="fecha_fin_bancomer" type="text" value="{{ date('Y-m-d') }}"/>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-2" id="add_filtrado_bancomer">
                                    <select class="form-control" id="condicion_bancomer"  name="condicion_bancomer" style="width:100%">
                                        <option value="todos">Todos</option>
                                        <option value="solo">
                                            Solo segmento
                                        </option>
                                        <option value="contenga">
                                            Contenta
                                        </option>
                                        <option value="entre">
                                            Entre
                                        </option>
                                        <option value="excep">
                                            Excepto
                                        </option>
                                        <option value="mayor">
                                            Mayor o igual que
                                        </option>
                                    </select>
                                </div>
                                <div class="form-group col-md-2">
                                    <input autocomplete="false" class="form-control" id="segmento_bancomer" name="segmento_bancomer" type="text"/>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-md-3 mt-3">
                                    <label for="inputAddress">
                                        Estatus de pago
                                    </label>
                                    <div class="form-check">
                                        <input checked="" class="form-check-input" id="por_pagar_banc" name="estatus_pago_bancomer" type="radio" value="por_pagar"/>
                                        <label class="form-check-label" for="por_pagar_banc">
                                            Por pagar
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input  class="form-check-input" id="rechazado_banc" name="estatus_pago_bancomer" type="radio" value="Rechazado"/>
                                        <label class="form-check-label" for="rechazado_banc">
                                            Rechazados
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <button class="btn btn-success" type="submit">
                                <i class="fas fa-download">
                                </i>
                                Descargar
                            </button>
                        </form>   
                    </div>
                    <div class="tab-pane fade" id="cobranda_doble" role="tabpanel" aria-labelledby="cobranza_doble" aria-expanded="false">
                        <div class="row">
                            <div class="col-lg-8 col-md-8">
                                <div class="card">
                                    <div class="card-header">
                                        <h5 class="card-title">
                                            Filtrado
                                        </h5>
                                    </div>
                                    <div class="card-body">
                                        <form action="{{ route('cobranza.cobranza_dob') }}" id="cobranza_dob_form" method="GET">
                                            @csrf
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="row">
                                                        <div class="col-lg-6 col-md-4">
                                                            <div class="form-group">
                                                                <label for="exampleInputEmail1">
                                                                    Desde el segmento
                                                                </label>
                                                                <input aria-describedby="emailHelp" class="form-control" id="segmento_1" name="segmento_1" placeholder="7" type="text" value="7"/>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6 col-md-4">
                                                            <div class="form-group">
                                                                <label for="exampleInputPassword1">
                                                                    Hasta el segmento
                                                                </label>
                                                                <input class="form-control" id="segmento_2" name="segmento_2" placeholder="23" type="text" value="23"/>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-1">
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-lg-6 col-md-4">
                                                            <div class="form-group">
                                                                <label>
                                                                    Desde:
                                                                </label>
                                                                <div class="input-group date" id="desde">
                                                                    <input class="form-control datepicker" name="desde" type="text" value="{{date('Y')}}-12-15"/>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6 col-md-4">
                                                            <div class="form-group">
                                                                <label>
                                                                    Hasta:
                                                                </label>
                                                                <div class="input-group date">
                                                                    <input class="form-control datepicker" name="hasta" type="text" value="{{date('Y')}}-12-31"/>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group col-md-6 mt-3">
                                                            <label for="inputAddress">
                                                                Bancos
                                                            </label>
                                                            <div class="form-check">
                                                                <input checked="" class="form-check-input" id="banco_todos" name="banco" type="radio" value="todos"/>
                                                                <label class="form-check-label" for="banco_todos">
                                                                    Todos
                                                                </label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input  class="form-check-input" id="banco_sin_bancomer" name="banco" type="radio" value="sin_bancomer"/>
                                                                <label class="form-check-label" for="banco_sin_bancomer">
                                                                    Sin Bancomer
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-row">
                                                                <div class="form-group col-md-12 mt-3">
                                                                    <label for="inputAddress">
                                                                        Filtrar clientes para mail
                                                                    </label>
                                                                    <div class="form-check">
                                                                        <input checked="" class="form-check-input" id="dobles" name="cliente" type="radio" value="dobles"/>
                                                                        <label class="form-check-label" for="dobles">
                                                                            Solo clientes con referencias doble
                                                                        </label>
                                                                    </div>
                                                                    <div class="form-check">
                                                                        <input  class="form-check-input" id="todos" name="cliente" type="radio" value="todos"/>
                                                                        <label class="form-check-label" for="todos">
                                                                            Todos
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="card-footer">
                                                        <button class="btn btn-primary mr-4" type="submit">
                                                            Filtrar referencias
                                                        </button>
                                                        <button class="btn btn-success ml-5" id="filtrado_users" type="button">
                                                            Filtrar usuarios para mail
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="alert alert-danger alert-dismissible">
                                    <button aria-hidden="true" class="close" data-dismiss="alert" type="button">
                                        ×
                                    </button>
                                    <h5>
                                        <i class="icon fas fa-ban">
                                        </i>
                                        Alert!
                                    </h5>
                                    Este filtrado toma en consideracion
                                    <strong>
                                        Bancomer
                                    </strong>
                                    para mandarse por serfin.
                                </div>
                                <div class="alert alert-info alert-dismissible">
                                    <button aria-hidden="true" class="close" data-dismiss="alert" type="button">
                                        ×
                                    </button>
                                    <h5>
                                        <i class="icon fas fa-ban">
                                        </i>
                                        Info!
                                    </h5>
                                    El filtrado de usuarios se obtiene para el envio del masivo notificando la cobranza doble realizada, (no modificar los segmentos y fechas para obtener el mismo registro de las referencias)
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-8 col-md-8">
                                <div class="card">
                                    <div class="card-header">
                                        <h5 class="card-title">
                                            Filtrado usuarios con contratos cobrados por terminal
                                        </h5>
                                    </div>
                                    <div class="card-body">
                                        <form action="" id="cobranza_terminal_form" method="GET">
                                            @csrf
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="row">
                                                        <div class="col-lg-6 col-md-4">
                                                            <div class="form-group">
                                                                <label for="exampleInputEmail1">
                                                                    Desde el segmento
                                                                </label>
                                                                <input  class="form-control" id="" name="segmento_1_t" placeholder="7" type="text" value="7"/>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6 col-md-4">
                                                            <div class="form-group">
                                                                <label for="exampleInputPassword1">
                                                                    Hasta el segmento
                                                                </label>
                                                                <input class="form-control" id="" name="segmento_2_t" placeholder="23" type="text" value="23"/>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-lg-6 col-md-4">
                                                            <div class="form-group">
                                                                <label>
                                                                    Desde:
                                                                </label>
                                                                <div class="input-group date" id="desde">
                                                                    <input class="form-control datepicker" name="desde_t" type="text" value="{{date('Y')}}-12-15"/>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6 col-md-4">
                                                            <div class="form-group">
                                                                <label>
                                                                    Hasta:
                                                                </label>
                                                                <div class="input-group date">
                                                                    <input class="form-control datepicker" name="hasta_t" type="text" value="{{date('Y')}}-12-15"/>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-6">
                                                            
                                                            <label for="">
                                                                Estatus de Pago
                                                            </label>
                                                            <div class="demo-checkbox">
                                                                <input type="checkbox" id="md_checkbox_1" name="estatus_pago[]" class="chk-col-blue" value="Rechazado"/>
                                                                <label for="md_checkbox_1">Rechazados</label>
                                                                <input type="checkbox" id="md_checkbox_2" name="estatus_pago[]" class="chk-col-blue" value="Pagado"/>
                                                                <label for="md_checkbox_2">Pagados</label>
                                                                <input type="checkbox" id="md_checkbox_3" name="estatus_pago[]" class="chk-col-blue" checked="" value="Por Pagar"/>
                                                                <label for="md_checkbox_3">Pendientes</label>
                                                                <input type="checkbox" id="md_checkbox_4" name="estatus_pago[]" class="chk-col-blue" value="Anomalia"/>
                                                                <label for="md_checkbox_4">Anomalias</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="card-footer">
                                                        <button class="btn btn-primary mr-4" type="submit">
                                                            Filtrar
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
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

@endsection
@section('script')
<script>
    $(document).ready(function() {
        $('.datepicker').bootstrapMaterialDatePicker({
            weekStart: 0,
            time: false,
            lang: 'es',
        });

        $('#con_filtro').on('change', function(event) {
            event.preventDefault();
            if ($('#con_filtro').is(':checked')) {
              $('#add_filtrado').css('display', 'block');
              $('#add_filtrado_2').css('display', 'block');
            } else {
              $('#add_filtrado').css('display', 'none');
              $('#add_filtrado_2').css('display', 'none');
            }
        });       

        $('#formFiltrado').on('submit', function(event) {
            event.preventDefault();
            $.ajax({
                url: $(this).attr('action'),
                type: $(this).attr('method'),
                dataType: 'json',
                data: $(this).serialize(),
                beforeSend:function(){
                    $('#overlay').css('display','block');
                },
                success:function(res){
                    if (res.success != true) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Intenta mas tarde...',
                        });

                        toastr['error'](res.errors);
                    }else{
                        Swal.fire({
                          title: '¡Hecho!',
                          text: 'Descargando archivo...',
                          icon: 'success',
                          confirmButtonText: 'OK'
                        });
                        window.location.href = res.url;
                    }
                }
            })
            .fail(function(jqXHR, textStatus, errorThrown) {
                // console.log(jqXHR)
                // console.log(textStatus)
                // console.log(errorThrown)
                toastr['error'](errorThrown);
                $('#overlay').css('display','none');
            })
            .always(function() {
                $('#overlay').css('display','none');
            });
        });
        $('#formFiltradoBancomer').on('submit', function(event) {
            event.preventDefault();
            // toastr['warning']('¡Acción deshabilitada temporalmente!');
            
            $.ajax({
                url: $(this).attr('action'),
                type: $(this).attr('method'),
                dataType: 'json',
                data: $(this).serialize(),
                beforeSend:function(){
                    $('#overlay').css('display','block');
                },
                success:function(res){
                    if (res.success != true) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Intenta mas tarde...',
                        });

                        toastr['error'](res.errors);
                    }else{
                        Swal.fire({
                          title: '¡Hecho!',
                          text: 'Descargando archivo...',
                          icon: 'success',
                          confirmButtonText: 'OK'
                        });
                        window.location.href = res.url;
                    }
                }
            })
            .fail(function(jqXHR, textStatus, errorThrown) {
                console.log(jqXHR)
                console.log(textStatus)
                console.log(errorThrown)
                toastr['error'](errorThrown);
                $('#overlay').css('display','none');
            })
            .always(function() {
                $('#overlay').css('display','none');
            });
        });
       
        $('#fromSinSegmento').on('submit', function(event) {
            event.preventDefault();
            $.ajax({
                url: $(this).attr('action'),
                type: $(this).attr('method'),
                dataType: 'json',
                data: $(this).serialize(),
                beforeSend:function(){
                    $('#overlay').css('display','block');
                },
                success:function(res){
                    if (res.success != true) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            // text: 'Intenta mas tarde...',
                            text: res.errors,
                        });

                        // toastr['error'](res.errors);
                    }else{
                        Swal.fire({
                          title: 'Se encontraron: '+res.cont + ' registros',
                          text: 'Descargando archivo...',
                          icon: 'success',
                          confirmButtonText: 'OK'
                        });
                        window.location.href = res.url;
                    }
                }

            })
            .fail(function(jqXHR, textStatus, errorThrown) {
                console.log(jqXHR)
                console.log(textStatus)
                console.log(errorThrown)
                toastr['error'](errorThrown);
                $('#overlay').css('display','none');
            })
            .always(function() {
                $('#overlay').css('display','none');
            });
            
        });
        $('#formFiltradoSuspendidos').on('submit', function(event) {
            event.preventDefault();
            $.ajax({
                url: $(this).attr('action'),
                type: $(this).attr('method'),
                dataType: 'json',
                data: $(this).serialize(),
                beforeSend:function(){
                    $('#overlay').css('display','block');
                },
                success:function(res){
                    if (res.success != true) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            // text: 'Intenta mas tarde...',
                            text: res.errors,
                        });

                        // toastr['error'](res.errors);
                    }else{
                        Swal.fire({
                          title: 'Se encontraron: '+res.cont + ' registros',
                          text: 'Descargando archivo...',
                          icon: 'success',
                          confirmButtonText: 'OK'
                        });
                        window.location.href = res.url;
                    }
                }

            })
            .fail(function(jqXHR, textStatus, errorThrown) {
                console.log(jqXHR)
                console.log(textStatus)
                console.log(errorThrown)
                toastr['error'](errorThrown);
                $('#overlay').css('display','none');
            })
            .always(function() {
                $('#overlay').css('display','none');
            });
            
        });


        $('#cobranza_dob_form').submit(function(event) {
            event.preventDefault();
            var data = $(this).serialize();
            $.ajax({
                url: '{{route("cobranza.cobranza_dob")}}',
                type: 'GET',
                dataType: 'json',
                data: data,
                beforeSend:function(){
                    $('#overlay').css('display','block');
                    // Swal.fire({
                    //     title: 'Cobranza Doble',
                    //     html: 'Consultando y creando archivo',
                    //     allowOutsideClick:false,
                    //     onBeforeOpen: () => {
                    //         Swal.showLoading()
                    //     }
                    // });
                },
                success:function(res){
                    // Swal.DismissReason.close;
                    $('#overlay').css('display','none');
                    if(res.success == true){
                        Swal.fire({
                            title: 'Cobranza Doble',
                            text: "Descargar Archivo",
                            icon: 'success',
                            showCancelButton: false,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            confirmButtonText: 'Descargar'
                        }).then((result) => {
                            if (result.value) {
                                window.location.href = res.url;
                            }
                        })
                    }else{
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Intenta mas tarde...',
                        });
                    }
                }
            })
            .fail(function(jqXHR, textStatus, errorThrown) {
                console.log(jqXHR)
                console.log(textStatus)
                console.log(errorThrown)
                toastr['error'](jqXHR.responseText);
                toastr['error'](errorThrown);
                $('#overlay').css('display','none');
            })
            .always(function() {
                $('#overlay').css('display','none');
            });
            
        });

        $('#filtrado_users').click(function(event) {
            event.preventDefault();
            var data = $('#cobranza_dob_form').serialize();
            $.ajax({
                url: '{{route('cobranza.cobranza_cliente')}}',
                type: 'GET',
                dataType: 'json',
                data: data,
                beforeSend:function(){
                    // Swal.fire({
                    //     title: 'Cobranza Doble',
                    //     html: 'Consultando y creando archivo',
                    //     allowOutsideClick:false,
                    //     onBeforeOpen: () => {
                    //         Swal.showLoading()
                    //     }
                    // });
                    $('#overlay').css('display','block');
                },
                success:function(res){
                    // Swal.DismissReason.close;
                    $('#overlay').css('display','none');
                    if(res.success == true){
                        Swal.fire({
                            title: 'Clientes con Referencia Doble',
                            text: "Descargar Archivo",
                            icon: 'success',
                            showCancelButton: false,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            confirmButtonText: 'Descargar'
                        }).then((result) => {
                            if (result.value) {
                                window.location.href = res.url;
                            }
                        })
                    }else{
                        $('#overlay').css('display','none');
                        toastr['error'](res.errors);
                    }
                }
            })
           .fail(function(jqXHR, textStatus, errorThrown) {
                // console.log(jqXHR)
                // console.log(textStatus)
                // console.log(errorThrown)
                toastr['error'](errorThrown);
                $('#overlay').css('display','none');
            })
            .always(function() {
                $('#overlay').css('display','none');
            });
            
        });

        $('#cobranza_terminal_form').submit(function(event) {
            event.preventDefault();
            var data = $('#cobranza_terminal_form').serialize();
            $.ajax({
                url: '{{route('cobranza.filtrado_terminal')}}',
                type: 'GET',
                dataType: 'json',
                data: data,
                beforeSend:function(){
                     $('#overlay').css('display','block');
                },
                success:function(res){
                    $('#overlay').css('display','none');
                    if(res.success == true){
                        Swal.fire({
                            title: 'Contratos cobrandos por terminal',
                            text: "Descargar Archivo",
                            icon: 'success',
                            showCancelButton: false,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            confirmButtonText: 'Descargar'
                        }).then((result) => {
                            if (result.value) {
                                window.location.href = res.url;
                            }
                        })
                    }
                }
            })
           .fail(function(jqXHR, textStatus, errorThrown) {
                toastr['error']('Intenta mas tarde...');
                $('#overlay').css('display','none');
            })
            .always(function() {
                $('#overlay').css('display','none');
            });
            
        });
    });
</script>
@stop
