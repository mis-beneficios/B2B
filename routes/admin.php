<?php

use Illuminate\Support\Facades\Route;

/**
 * Configuracion de emaik para usuarios de reservaciones
 */

Route::get('configurar-mail', 'UserController@configurar_mail')->name('config.mail');
Route::post('configurar-mail', 'UserController@config_mail')->name('save.mail');
Route::get('perfil', 'UserController@perfil')->name('perfil');
Route::put('update-perfil/{id}', 'UserController@update_perfil')->name('users.update_perfil');

Route::get('info', function () {
    return date('Y-m-d h:i:s');
});

Route::get('logs', [\Rap2hpoutre\LaravelLogViewer\LogViewerController::class, 'index']);


Route::group(['prefix' => 'admin', 'middleware' => ['auth', 'user_active', 'config_mail','throttle:60,1']], function () {
    Route::get('/', function () {
        return redirect()->route('dashboard');
    });
    /*=========================================
    =            Dashboard por rol            =
    =========================================*/
    Route::get('dashboard', 'HomeController@dashboard')->name('dashboard');
    Route::get('sales', 'HomeController@dashboard_ventas')->name('dashboard_ventas');
    Route::get('cobranza', 'HomeController@dashboard_cobranza')->name('dashboard_cobranza');
    Route::get('control', 'HomeController@dashboard_control')->name('dashboard_control');
    Route::get('conveniant', 'HomeController@dashboard_convenios')->name('dashboard_convenios');
    Route::get('reserver', 'HomeController@dashboard_reservaciones')->name('dashboard_reservaciones');
    Route::get('collector', 'HomeController@dashboard_cobranza')->name('dashboard_cobranza');
    Route::get('buscar-usuario/{data}', 'HomeController@buscar_usuario')->name('buscar.ususario');
    Route::get('cambiar-color/{color}', 'HomeController@cambiar_color');

    /*=====  End of Dashboard por rol  ======*/

    Route::get('get-user', 'UserController@getUser');

    /*=================================
    =            Convenios            =
    =================================*/
    Route::resource('convenios', 'ConvenioController');
    Route::get('convenios-listar/{user_id?}', 'ConvenioController@get_convenios');
    Route::get('form-convenios/{convenio_id}', 'ConvenioController@form_convenios')->name('convenios.form_reasignar');
    Route::put('editar-convenio/{id}', 'ConvenioController@actualizar_convenio')->name('convenios.actualizar');
    Route::post('/ajax-image-upload', 'ConvenioController@cargar_imagen')->name('convenios.cargar_imagen');
    Route::put('asignar-convenio/{convenio_id}', 'ConvenioController@asignar_convenio')->name('convenios.asignar_convenio');
    Route::get('cambiar-estatus/{convenio_id}/{estatus}', 'ConvenioController@changeStatus')->name('convenios.changeStatus');

    Route::get('manual-convenios', function () {
        return view('admin.elementos.views.manual_convenios');
    })->name('manual_convenios');

    Route::get('list-convenios-ajax', 'ConvenioController@list_convenios_ajax')->name('list_convenios_ajax');

    /*=====  End of Convenios  ======*/

    /*=============================
    =            Users            =
    =============================*/
    Route::resource('users', 'UserController');
    Route::get('administrativos', 'UserController@show_admin')->name('users.show_admin');
    Route::get('listar-administrativos', 'UserController@listar_administrativos')->name('users.administrativos');
    Route::get('clientes', 'UserController@show_clientes')->name('users.show_clientes');
    Route::get('listar-clientes', 'UserController@listar_clientes')->name('users.clientes');
    Route::get('listar-clientes-ejecutivo/{user_id?}', 'UserController@clientes_ejecutivo')->name('users.clientes_ejecutivo');
    Route::get('listar-usuarios/{user_id?}', 'UserController@listar_usuarios')->name('users.listar');
    Route::get('listar-tarjetas/{id}', 'UserController@get_tarjetas')->name('users.tarjetas');
    Route::get('listar-contratos/{id}', 'UserController@get_contratos')->name('users.contratos');
    Route::get('mostrar-historial/{id}/{type?}', 'UserController@historial')->name('users.historial');
    Route::post('users-add-log', 'UserController@add_log')->name('users.log');
    Route::put('update-login-user/{id}', 'UserController@update_login')->name('users.update_login');
    Route::get('validar-email/{username?}', 'UserController@validar_email')->name('users.validar_email');

    /*=====  End of Users  ======*/

    /*================================
    =            Tarjetas            =
    ================================*/
    Route::resource('cards', 'TarjetaController');
    Route::get('get-tarjetas', 'TarjetaController@get_tarjetas');
    Route::get('mostrar-historial-tarjeta/{id}', 'TarjetaController@historial')->name('cards.historial');
    /*=====  End of Tarjetas  ======*/

    /*=================================
    =            Contratos            =
    =================================*/
    Route::resource('contratos', 'ContratoController');
    Route::get('listar-contratos-generados/{user_id?}', 'ContratoController@listar_contratos')->name('contratos.listar');
    Route::get('listar-contratos-ejecutivo/{user_id?}', 'ContratoController@listar_contratos_ejecutivo')->name('contratos.listar_contratos_ejecutivo');
    Route::get('mostrar-historial-contrato/{id}', 'ContratoController@historial')->name('contratos.historial');
    Route::get('reenviar-contrato/{folio}', 'ContratoController@reenviar_contrato');
    Route::get('mostrar-contrato/{folio}', 'ContratoController@mostrar_contrato');
    Route::post('cambio-estancia', 'ContratoController@cambio_estancia')->name('contratos.cambio_estancia');
    Route::get('contrato-metodo-de-pago/{id}', 'ContratoController@metodo_de_pago_show')->name('contrato.show_metodo_pago');
    Route::put('metodo-pago/{id}', 'ContratoController@metodo_pago')->name('contratos.metodo_pago');
    Route::post('autorizar-folio', 'ContratoController@autorizar_folio');
    Route::get('contratos-por-autorizar', 'ContratoController@contratos_por_autorizar')->name('contratos.listar_contratos');
    Route::get('obtener-contratos/{estatus?}/{equipo?}', 'ContratoController@obtener_contratos')->name('contratos.get_por_autorizar');
    Route::get('generar-comisiones', 'ContratoController@generar_comisiones');

    Route::get('contrato-por-convenio/{convenio_id}', 'ContratoController@contratos_por_convenio');

    Route::get('cambiar-padre/{contrato_id}', 'ContratoController@cambiar_padre');
    Route::put('modificar-padre/{contrato_id}', 'ContratoController@cambiar_vendedor')->name('contratos.cambiar_vendedor');
    Route::get('reservaciones-vinculadas/{id}', 'ContratoController@reservaciones_vinculadas')->name('contratos.reservaciones_vinculadas');
    Route::put('desvincular/{id}/{contrato_id?}', 'ContratoController@desvincular')->name('contratos.desvincular');

    Route::post('agregar-calidad', 'ContratoController@add_calidad')->name('contratos.calidad');
    Route::get('ver-calidad/{contrato_id}', 'ContratoController@ver_calidad')->name('contratos.ver_calidad');
    Route::get('descargar-calidad/{path}', 'ContratoController@download_calidad')->name('download_calidad');
    Route::delete('delete-calidad/{path}/{id}', 'ContratoController@delete_calidad')->name('delete_calidad');

    Route::get('bases', 'ContratoController@bases')->name('contratos.bases');
    Route::post('generar-base', 'ContratoController@generarBase')->name('contratos.generarBase');
    // Route::get('base-export/{id?}', 'ContratoController@exportFiltrado')->name('contratos.export_base');
    // Route::get('download-base/{name}', 'ContratoController@downloadFiltrado')->name('contratos.download_base');

    /*=====  End of Contratos  ======*/

    /*=============================
    =            Pagos            =
    =============================*/
    Route::resource('pagos', 'PagoController');
    // Route::get('crear-pagos/{contrato_id}/{fecha_de_inicio}/{tipo}/{diaX?}/{diaY?}', 'PagoController@crear_pagos')->name('pagos.crear_pagos');
    Route::get('listar-pagos-contrato/{contrato_id}/{tipo?}', 'PagoController@listar_pagos_contrato');
    Route::post('calcular-pagos', 'PagoController@calcular_pagos')->name('pagos.calcular');
    Route::post('agregar-pago', 'PagoController@add_pago')->name('pagos.add_pago');
    Route::get('get-log-pago/{pago_id}', 'PagoController@get_log');

    Route::get('delete-multiples', 'PagoController@delete_multiple')->name('pagos.delete_multiple');
    Route::get('delete-restantes/{contrato_id}', 'PagoController@delete_restantes')->name('pagos.delete_restantes');
    /*=====  End of Pagos  ======*/

    /*==================================
    =            Cimisiones            =
    ==================================*/
    Route::resource('comisiones', 'ComisionController');
    Route::get('listar-comisiones', 'ComisionController@listar_comisiones')->name('comisiones.listar');
    Route::get('comisiones-export/{id?}', 'ComisionController@exportFiltrado')->name('comisiones.export');
    Route::get('download-comisiones/{name}', 'ComisionController@downloadFiltrado')->name('comisiones.download');

    Route::get('show-comisiones', 'ComisionController@show_comisiones')->name('comisiones.show_comisiones');
    Route::get('listado-comisiones', 'ComisionController@listarComisiones')->name('comisiones.listar-comisiones');

    /*=====  End of Cimisiones  ======*/

    /*========================================
    =            Equpos de ventas            =
    ========================================*/
    Route::resource('equipos', 'SalesgroupController');
    Route::get('listar-grupos', 'SalesgroupController@listar_grupos')->name('groups.listar');
    Route::get('listar-usuarios-grupo/{grupo_id}', 'SalesgroupController@ver_usuarios_grupo');
    // Route::get('mostrar_ejecutivos/{grupo_id}', 'SalesgroupController@mostrar_ejecutivos');
    Route::get('mostrar-equipo-ejecutivos', 'SalesgroupController@mostrar_ejecutivos')->name('equipos.ejecutivos');
    Route::get('asociar-ejecutivos/{id}', 'SalesgroupController@asociar_ejecutivos')->name('equipos.asociar_ejecutivos');

    Route::post('vincular-ejecutivos', 'SalesgroupController@vincular_ejecutivos')->name('equipos.vincular_ejecutivos');
    Route::get('desvincular-ejecutivos/{id}', 'SalesgroupController@desvincular_ejecutivos')->name('equipos.desvincular');
    /*=====  End of Equpos de ventas  ======*/

    /*=====================================
    =            Reservaciones            =
    =====================================*/
    Route::resource('reservations', 'ReservacionController');
    Route::get('reservations/create/{user?}', 'ReservacionController@create')->name('reservations.create');
    Route::get('get-reservaciones/{id}', 'ReservacionController@get_reservaciones');
    Route::get('listado-global', 'ReservacionController@listado_global');
    Route::get('log-reservacion/{id}', 'ReservacionController@log_reservacion');
    Route::get('pdf-reserver/{id}', 'ReservacionController@pdf_reserver')->name('pdf_reserver');
    Route::get('pagos-reservacion/{id}', 'ReservacionController@pagos')->name('reservations.pagos');
    Route::get('confirmacion-reserva/{id}', 'ReservacionController@cuponConfirmacion')->name('reservations.cuponConfirmacion');
    Route::get('pago-pendiente-reservacion/{id}', 'ReservacionController@cuponPago')->name('reservations.cuponPago');
    Route::get('asociar-contratos-reservacion/{id?}', 'ReservacionController@asociarContrato')->name('reservations.asociarContrato');
    Route::put('ajustes/{id}', 'ReservacionController@ajustes')->name('reservations.ajustes');
    Route::put('editar-ajustes/{id}', 'ReservacionController@editarAjustes')->name('reservations.editarAjustes');
    Route::get('agregar-reservacion/{id?}', 'ReservacionController@agregarReservacion')->name('reservations.agregarReservacion');

    Route::get('cambiar-ejecutivo/{ejecutivo_id}', 'ReservacionController@cambiar_ejecutivo');
    Route::put('modificar-ejecutivo/{ejecutivo_id}', 'ReservacionController@update_ejecutivo')->name('reservacions.update_ejecutivo');

    /**
     * Enviar cupones por correo al cliente correspondiente
     */
    Route::post('enviar-cupon-confirmacion', 'ReservacionController@enviarConfirmacion')->name('reservations.enviarConfirmacion');
    Route::post('enviar-cupon-pago', 'ReservacionController@enviarPago')->name('reservations.enviarPago');

    // Route::post('store-reservacion/', 'ReservacionController@')->name('reservations.agregarReservacion');

    Route::get('mis-reservaciones-asignadas', 'ReservacionController@misAsignaciones')->name('reservations.misAsignaciones');
    Route::get('reservaciones-sin-asignar', 'ReservacionController@sinAsignar')->name('reservations.sinAsignar');
    Route::get('filtrados/{region_id}/{tipo?}', 'ReservacionController@filtradoReservaciones')->name('reservations.filtrados');
    Route::get('filtrado-reservaciones/{data?}', 'ReservacionController@getFiltrado')->name('reservations.get_filtrado');
    Route::get('create-filtrado-reservaciones', 'ReservacionController@createFiltrado')->name('reservations.createFiltrado');
    Route::get('download-filtrado-reservaciones/{name}', 'ReservacionController@downloadFiltrado')->name('reservations.downloadFiltrado');

    //asignar y tomar reservacion
    Route::get('tomar-reservacion/{id}/{user_id?}', 'ReservacionController@tomarReservacion')->name('reservations.tomarReservacion');
    Route::post('asignar-reservacion', 'ReservacionController@asignarReservacion')->name('reservations.asignarReservacion');
    Route::put('guardar-pagos/{id}', 'ReservacionController@storePagos')->name('reservations.storePagos');
    Route::get('ajustes-reservacion/{id}', 'ReservacionController@infoHotel')->name('reservations.infoHotel');
    Route::put('guardar-info-ajustes/{id}', 'ReservacionController@storeAjustes')->name('reservations.storeAjustes');

    Route::get('folio-reservacion/{contrato_id}/{reservacion_id}/{estatus?}', 'ReservacionController@folio_reservacion')->name('reservations.folio_reservacion');

    /*=====  End of Reservaciones  ======*/

    /*================================
    =            Cobranza            =
    ================================*/
    Route::resource('cobranza', 'CobranzaController');
    Route::get('terminal-ajax', 'CobranzaController@termial_ajax')->name('cobranza.terminal');
    // Route::get('terminal-live', 'CobranzaController@termial_live')->name('cobranza.terminal_live');

    // Route::get('cobranza-terminal', 'Livewire\Cobranza\Terminal')->name('cobranza.term');
    Route::get('cobranza-get-data', 'CobranzaController@get_data');
    Route::post('unlock', 'CobranzaController@unlock')->name('unlocked');
    Route::get('validar-pago', 'CobranzaController@validar_pago')->name('cobranza.validar_pago');
    Route::get('autorizar-pago/{id}', 'CobranzaController@autorizar_pago')->name('cobranza.autorizar_pago');
    Route::put('rechazar-pago/{id}', 'CobranzaController@rechazar_pago')->name('cobranza.rechazar_pago');

    Route::get('exportar-contratos', 'CobranzaController@showExportar')->name('cobranza.exportar');
    Route::get('get-contratos-exportar', 'CobranzaController@get_contratos_exportar');
    Route::get('generate-opt', 'CobranzaController@generar_opt');

    Route::group(['prefix' => 'serfin'], function () {
        Route::get('buzon-serfin', 'CobranzaController@buzon')->name('cobranza.buzon');

        Route::get('actualizar', 'CobranzaController@showActualizarSerfin')->name('cobranza.showActualizarSerfin');

        Route::get('copy-response-serfin', 'CobranzaController@copy_response')->name('copy_response');

        Route::get('daily_response', 'CobranzaController@daily_response')->name('daily_response');
        Route::get('errores', 'CobranzaController@errores')->name('errores');
        Route::get('insert', 'CobranzaController@insert_serfin')->name('insert_serfin');
        Route::get('update', 'CobranzaController@update_serfin')->name('update_serfin');
        Route::get('delete', 'CobranzaController@delete_origen')->name('delete_origen');
        Route::get('download_errores', 'CobranzaController@download_errores')->name('download_errores');

        Route::get('historial', 'CobranzaController@historial')->name('historial');
        Route::get('get-historial/{fecha}', 'CobranzaController@get_historial');
        Route::post('download', 'CobranzaController@download_file')->name('download');
        Route::get('download-sftp/{archivo}', 'CobranzaController@download_sftp')->name('downloadSFTP');
        Route::get('download-sftp-inbox/{archivo}', 'CobranzaController@download_sftp_inbox')->name('download_sftp_inbox');
        Route::get('devoluciones', 'CobranzaController@solicitar_devolucion')->name('devoluciones');
        Route::get('/respuesta', 'CobranzaController@respuesta_serfin')->name('respuesta');
        // Solo pagados
        Route::get('insert-pagados', 'CobranzaController@insert_serfin_pagados')->name('insert_serfin_pagados');
        Route::get('update-pagados', 'CobranzaController@update_serfin_pagados')->name('update_serfin_pagados');
        Route::get('download-excel/{archivo}', 'CobranzaController@download_excel')->name('download_excel');
        Route::get('ingresos', 'CobranzaController@ingresos_del_dia')->name('ingresos_del_dia');

        Route::get('cargar-archivo', 'CobranzaController@cargar_archivo')->name('cobranza.cargar_archivo');
        Route::post('cobranza', 'CobranzaController@processExcelFile')->name('cobranza.excel');

        Route::get('filtrado-cobranza', 'CobranzaController@filtrado_cobranza')->name('cobranza.filtrado_cobranza');
        Route::get('filtrado-sin-segmentos', 'CobranzaController@filtrado_sin_segmentos')->name('cobranza.filtrado_sin_segmentos');
        Route::get('descargar-filtrado-sin-segmentos/{neme}', 'CobranzaController@download_sin_segmento')->name('cobranza.download_sin_segmento');

        Route::get('filtrado-serfin', 'CobranzaController@filtrado_serfin')->name('cobranza.filtrado_serfin');
        Route::get('filtrado-suspendidos', 'CobranzaController@filtrado_suspendidos')->name('cobranza.filtrado_suspendidos');
        Route::get('filtrado-bancomer', 'CobranzaController@filtrado_bancomer')->name('cobranza.filtrado_bancomer');
        Route::get('descargar-filtrado-serfin/{neme}', 'CobranzaController@download_serfin')->name('cobranza.download_serfin');

        Route::get('get-cobranza-doble', 'CobranzaController@filtrado_doble')->name('cobranza.cobranza_dob');

        Route::get('get-clientes-doble', 'CobranzaController@filtrado_doble_clientes')->name('cobranza.cobranza_cliente');
        // Route::get('download-file-clientes/{archivo}', 'CobranzaController@download_file_clientes')->name('cobranza.download_file_clientes');

        Route::get('get-clientes-terminal', 'CobranzaController@filtrado_doble_clientes_terminal')->name('cobranza.filtrado_terminal');
        // Route::get('download-file-clientes-terminal/{archivo}', 'CobranzaController@download_file_clientes_terminal')->name('cobranza.download_file_clientes_temrinal');

        //descargar filtrados cobranza doble
        Route::get('download-file/{archivo}', 'CobranzaController@download_file')->name('cobranza.download_file');

        Route::get('historico', 'CobranzaController@historico')->name('cobranza.historico');
    });

    /*=====  End of Cobranza  ======*/

    /*=================================
    =            Estancias            =
    =================================*/

    Route::resource('estancias', 'EstanciaController');
    Route::get('estancias-listar', 'EstanciaController@listar_estancias')->name('estancias.listar');
    Route::put('estancias-activar/{id}', 'EstanciaController@activar_estancia')->name('estancias.activar');
    Route::put('estancia-actualizar-contrato/{id}', 'EstanciaController@update_contrato')->name('estancias.update_contrato');
    Route::get('estancias/{id}/create', 'EstanciaController@clonar')->name('estancias.clonar');

    /*=====  End of Estancias  ======*/

    /*================================
    =            Destinos            =w
    ================================*/
    Route::resource('destinos', 'DestinoController');

    /*=====  End of Destinos  ======*/

    /*================================
    =            Concals (seguimientos de convenios)            =
    ================================*/
    Route::resource('concals', 'ConcalController');
    Route::get('get-concals', 'ConcalController@get_concals_day');
    Route::get('get-calendar', 'ConcalController@get_calendar_concals');
    Route::get('get-log/{concal_id}', 'ConcalController@get_log');
    Route::get('modal-form/{type}/{concal_id?}', 'ConcalController@modal_form');
    Route::get('form-concals/{concal_id}', 'ConcalController@form_concals')->name('concals.form_reasignar');
    Route::put('asignar-concal/{concal_id}', 'ConcalController@asignar_concals')->name('concals.asignar_concals');

    /*=====  End of Concals (seguimientos de convenios)  ======*/

    /*===================================
    =            Actividades            =
    ===================================*/

    Route::resource('actividades', 'ActividadesController');
    Route::get('listar-ejecutivos', 'ActividadesController@get_actividades')->name('actividades.listar');
    Route::get('get-drive', 'ActividadesController@get_drive')->name('actividades.drive');
    /*=====  End of Actividades  ======*/

    /*
    Sorteos
     */

    Route::resource('sorteos', 'SorteoController');
    Route::get('sorteos-listar/{user_id?}', 'SorteoController@listarSorteos')->name('sorteos.listar');
    Route::get('buscar-convenio/{empresa?}', 'SorteoController@buscarConvenio')->name('sorteos.buscar_convenio');
    route::get('sorteos-download/{id}', 'SorteoController@download')->name('sorteos.download');
    route::get('sorteos-show/{id}', 'SorteoController@showMedia')->name('sorteos.show_media');

    /**
     * Campañas
     */

    Route::get('campanas', 'CampanaController@index')->name('campanas.index');
    Route::post('campanas', 'CampanaController@store')->name('campanas.store');
    Route::get('get-campanas', 'CampanaController@get_campanas')->name('campanas.get_campanas');

    /**
     * Filtrado de ventas
     */

    Route::get('ventas', 'HomeController@viewVentas')->name('ventas');
    Route::get('filtrar-ventar', 'HomeController@filtrarVentas')->name('ventas.show');
    Route::get('ventas-export', 'HomeController@exportFiltrado')->name('ventas.export');
    Route::get('download-filtrado/{name}', 'HomeController@downloadFiltrado')->name('ventas.download');
    Route::get('ingresos/{fecha}', 'HomeController@get_ingresos')->name('ingresos');

    Route::get('alertas', 'AlertaMxController@viewAlertas')->name('alertas');
    Route::get('filtrar-alertas', 'AlertaMxController@filtrarAlertas')->name('alertas.show');
    Route::get('alertas-export', 'AlertaMxController@exportAlertas')->name('alertas.export');
    Route::get('download-alertas/{name}', 'AlertaMxController@downloadAlertas')->name('alertas.download');

    /**
     * Bancos
     */
    Route::resource('bancos', 'BancoController');
    Route::get('get-bancos', 'BancoController@getBancos')->name('bancos.get_bancos');
    Route::get('obtener-bancos', 'BancoController@obtener_bancos')->name('bancos.obtener_bancos');

    /**
     * Regiones
     */

    Route::resource('regiones', 'RegionController');
    Route::get('get-regiones', 'RegionController@getRegiones')->name('regiones.get_regiones');

    /**
     * Temporadas
     */
    Route::resource('temporadas', 'TemporadaController');

    /**
     * Habitaciones
     */
    Route::resource('habitaciones', 'HabitacionController');
    Route::get('delete-menor/{id}/{nino_id}', 'HabitacionController@deleteMenor');
    Route::get('delete-junior/{id}/{junior_id}', 'HabitacionController@deleteJunior');
    /**
     * Configuraciones
     */
    Route::resource('settings', 'ConfiguracionController');
    Route::get('artisan-clear', 'ConfiguracionController@clear')->name('settings.clear');
    Route::get('process', 'ConfiguracionController@process')->name('settings.process');
    Route::get('eliminar-procesos', 'ConfiguracionController@eliminar_procesos')->name('settings.eliminar_procesos');
    Route::get('listar-procesos', 'ConfiguracionController@listar_procesos')->name('settings.listar_procesos');
    Route::get('kill-procesos', 'ConfiguracionController@kill_procesos')->name('settings.kill_procesos');
    Route::get('cobranza-doble', 'ConfiguracionController@show_cobranza_doble')->name('settings.cobranza_doble');

    Route::get('almacenamiento', 'ConfiguracionController@almacenamiento')->name('settings.almacenamiento');

    /*
     * Incidencias e inicios de sesion
     */

    Route::resource('incidencias', 'IncidenciaController');
    Route::get('listar-incidencias/{fecha?}', 'IncidenciaController@get_incidencias');

    Route::get('reportes', 'ReporteController@index')->name('reportes');

    Route::resource('notificaciones', 'NotificacionController');
    Route::get('obtener-notificaciones', 'NotificacionController@get_notificaciones')->name('notificaciones.get_notificaciones');
    Route::get('ocultar-notificaciones/{key_cache}', 'NotificacionController@ocultar')->name('notificaciones.ocultar');

    Route::get('respaldo-calidad', 'ImagenController@respaldo_calidad')->name('raspaldo_calidad');

    Route::resource('zoom', 'ZoomController');
    Route::get('get-meetings', 'ZoomController@get_meetings')->name('zoom.get_meetings');

    /**
     * Colas
     */
    Route::resource('jobs', 'JobNotificationsController');

});

