<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
 */
Auth::routes();
Route::get('password/reset/{email}/{token}', 'Auth\ResetPasswordController@showResetForm');

Route::get('/', function () {
    if (Auth::check()){
        return redirect()->intended('/admin/dashboard');
    }
    return view('layouts.admin.login');
});

Route::get('nosotros', 'PaginaController@nosotros')->name('nosotros');
Route::get('alerta-de-fraude', 'PaginaController@fraude')->name('fraude');
Route::get('mision-y-valores', 'PaginaController@mision')->name('mision');
Route::get('aviso-de-privacidad', 'PaginaController@privacidad')->name('privacidad');
Route::get('terminos-y-condiciones', 'PaginaController@terminos_y_condiciones')->name('terminos_y_condiciones');
Route::get('bolsa-de-trabajo', 'PaginaController@bolsa_trabajo')->name('bolsa_trabajo');
Route::get('empresas-afiliadas', 'PaginaController@empresas_afiliadas')->name('empresas_afiliadas');
Route::get('beneficios-empresa', 'PaginaController@beneficios_empresa')->name('beneficios_empresa');
Route::get('beneficios-trabajadores', 'PaginaController@beneficios_trabajadores')->name('beneficios_trabajadores');
Route::get('empresas-afiliadas', 'PaginaController@empresas_afiliadas')->name('empresas_afiliadas');
// Productos
Route::get('productos/{convenio?}/{destino?}/{destino2?}', 'PaginaController@productos')->name('productos');

Route::get('empresa/{convenio?}/{destino?}/{destino2?}', 'PaginaController@empresa_productos')->name('empresa');

Route::get('destinos-nacionales/{convenio?}', 'PaginaController@nacionales')->name('nacionales');
Route::get('destinos-internacionales/{convenio?}', 'PaginaController@internacionales')->name('internacionales');
Route::get('cruceros', 'PaginaController@cruceros')->name('cruceros');
Route::get('cotizador', 'PaginaController@cotizador')->name('cotizador');
Route::get('detalle-estancia/{slug}', 'PaginaController@detalle_estancia')->name('detalle_estancia');
Route::get('detalle-estancias/destino/{id}', 'PaginaController@detalle_estancia_int')->name('detalle_estancia_int');
Route::get('cp/{cp}', 'PaginaController@buscar_cp');
Route::get('sorteo/{convenio}', 'PaginaController@sorteo')->name('sorteo');
Route::get('encuesta/{id}/{user_hash}/{reservacion_id?}', 'PaginaController@encuesta')->name('encuesta');
Route::get('hoteles-amigos', 'PaginaController@hoteles_amigos')->name('hoteles');
Route::get('preguntas-frecuentes', 'PaginaController@preguntas')->name('preguntas');
   

/**
 * paginas web para las casas de orlando
 */
Route::get('orlando', 'PaginaController@orlando')->name('orlando');
Route::get('detalle-orlando/{slug}', 'PaginaController@detalle_orlando')->name('detalle_orlando');
Route::get('validar-fechas-orlando/{fechas?}', 'PaginaController@validar_fecha')->name('validar_fecha');

/**
 * Infografia
 */
Route::get('conoce-nuestros-beneficios', 'PaginaController@beneficios')->name('beneficios');
Route::get('documentos-legales', 'PaginaController@doc_legales')->name('doc_legales');
Route::get('demo-flyer/{tipo}', 'PaginaController@demo_flyer')->name('demo_flyer');

Route::get('generar-pagos/{contrato_id}/{precio_de_compra}/{fecha_primer_cobro}', 'CompraController@generar_pagos');
Route::get('generar-comisiones/{contrato_id}/{convenio_id?}', 'CompraController@comisiones_create');

Route::post('user-alert-mx', 'AlertaMxController@alerta_mx')->name('user_alert');

// Route::resource('paquetes', 'PaqueteController');
// Route::get('listar-paquetes/{user_id}', 'PaqueteController@listar_paquetes')->name('paquetes.listar');

// Route::resource('estancias', 'EstanciaController');
Route::get('estancia-detalles/{id}', 'EstanciaController@get_estancia');

Route::resource('destinos', 'DestinoController');

//tienda en linea
Route::resource('tienda', 'CompraController');

Route::post('compra-offline', 'CompraController@store_offline')->name('tienda.store_offline');
Route::post('compra-stripe', 'CompraController@store_stripe')->name('tienda.store_stripe');

// agregar usuario, tarjeta y crear contrato
Route::get('metodo-de-pago', 'CompraController@metodo_de_pago')->name('metodo_pago');

Route::get('prueba-token', 'CompraController@prueba_token')->name('tienda.token');



// Finalizar compra
Route::get('finalizar-compra/{id}', 'CompraController@finalizar_compra')->name('finalizar_compra');
Route::get('mostrar-contrato/{id}', 'CompraController@mostrar_contrato')->name('mostrar_contrato');
Route::get('descargar-contrato/{id}', 'CompraController@descargar_contrato')->name('descargar_contrato');
Route::get('generar-pagos', 'CompraController@generar_pagos_p')->name('calcular_pagos');

//Realizar el cargo
Route::post('openpay-create-checkout', 'CompraController@create_order_checkout')->name('tienda.create_order_checkout');

Route::resource('encuestas', 'EncuestaController');

Route::get('reservaciones-tutorial', 'PaginaController@tuto_reservas')->name('tuto_reserva');

Route::resource('sorteo-convenio', 'SorteoConvenioController');
Route::post('sorteo-especial', 'SorteoConvenioController@storeSorteo')->name('sorteo-convenio.storeSorteo');

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


Route::get('gran-sorteo-beneficios-vacacionales', 'PaginaController@sorteo_especial');