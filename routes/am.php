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

Route::get('/as', 'Am\PaginaController@index')->name('am.index');
Route::get('detalles/{slide}', 'Am\PaginaController@detalle_estancia')->name('am.detalles');
Route::resource('compra', 'Am\CompraController');
Route::get('metodo-de-pago', 'Am\CompraController@metodo_de_pago')->name('am.metodo_pago');
Route::get('am-finalizar-compra/{id}', 'Am\CompraController@finalizar_compra')->name('am.finalizar_compra');
//Realizar el cargo
Route::post('am-openpay-create-checkout', 'Am\CompraController@create_order_checkout_sin_pasarela')->name('am.create_order_checkout');
Route::get('am-mostrar-contrato/{id}', 'CompraController@mostrar_contrato')->name('am.mostrar_contrato');
Route::get('am-descargar-contrato/{id}', 'CompraController@descargar_contrato')->name('am.descargar_contrato');
Route::get('am-generar-pagos', 'CompraController@generar_pagos_p')->name('am.calcular_pagos');

Route::group(['prefix' => 'mx'], function () {

    Route::get('nosotros', 'Am\PaginaController@nosotros')->name('am.nosotros');
    Route::get('alerta-de-fraude', 'Am\PaginaController@fraude')->name('am.fraude');
    Route::get('mision-y-valores', 'Am\PaginaController@mision')->name('am.mision');
    Route::get('aviso-de-privacidad', 'Am\PaginaController@privacidad')->name('am.privacidad');
    Route::get('bolsa-de-trabajo', 'Am\PaginaController@bolsa_trabajo')->name('am.bolsa_trabajo');
    Route::get('empresas-afiliadas', 'Am\PaginaController@empresas_afiliadas')->name('am.empresas_afiliadas');
    Route::get('beneficios-empresa', 'Am\PaginaController@beneficios_empresa')->name('am.beneficios_empresa');
    Route::get('beneficios-trabajadores', 'Am\PaginaController@beneficios_trabajadores')->name('am.beneficios_trabajadores');
    Route::get('empresas-afiliadas', 'Am\PaginaController@empresas_afiliadas')->name('am.empresas_afiliadas');

// Productos
    Route::get('productos/{convenio?}/{destino?}/{destino2?}', 'Am\PaginaController@productos')->name('am.productos');
    // Route::get('empresa/{convenio?}/{destino?}/{destino2?}', 'Am\PaginaController@productos')->name('am.productos');
    Route::get('destinos-nacionales/{convenio?}', 'Am\PaginaController@nacionales')->name('am.nacionales');
    Route::get('destinos-internacionales/{convenio?}', 'Am\PaginaController@internacionales')->name('am.internacionales');
    Route::get('cruceros', 'Am\PaginaController@cruceros')->name('am.cruceros');
    Route::get('cotizador', 'Am\PaginaController@cotizador')->name('am.cotizador');
    Route::get('detalle-estancia/{slug}', 'Am\PaginaController@detalle_estancia')->name('am.detalle_estancia');
    Route::get('detalle-estancias/destino/{id}', 'Am\PaginaController@detalle_estancia_int')->name('am.detalle_estancia_int');
    Route::get('cp/{cp}', 'Am\PaginaController@buscar_cp');
    Route::get('sorteo/{convenio}', 'Am\PaginaController@am.sorteo')->name('sorteo');
    Route::get('encuesta/{id}/{user_hash}', 'Am\PaginaController@encuesta')->name('am.encuesta');
    Route::get('hoteles-amigos', 'Am\PaginaController@hoteles_amigos')->name('am.hoteles');
    Route::get('preguntas-frecuentes', 'Am\PaginaController@preguntas')->name('am.preguntas');

});
