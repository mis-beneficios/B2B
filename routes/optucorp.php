<?php

use Illuminate\Support\Facades\Route;
/**
 * Autor:    Diego Enrique Sanchez
 * Creado:   2021-08-19
 * Accion:   Rutas para la pagina web optucorp US (ingles)
 */

Route::get('verify/{token}', 'AuthController@verify_usa')->name('verify_usa');

/*Pagina USA*/
Route::get('/usa', 'PaginaUsaController@index')->name('eu.index');
Route::get('about-us', 'PaginaUsaController@nosotros')->name('eu.nosotros');
Route::get('fraud-alert', 'PaginaUsaController@fraude')->name('eu.fraude');
Route::get('mission-and-values', 'PaginaUsaController@mision')->name('eu.mision');
Route::get('privacy-notice', 'PaginaUsaController@privacidad')->name('eu.privacidad');
Route::get('job-board', 'PaginaUsaController@bolsa_trabajo')->name('eu.bolsa_trabajo');
Route::get('affiliates', 'PaginaUsaController@empresas_afiliadas')->name('eu.empresas_afiliadas');
Route::get('benefits-companies', 'PaginaUsaController@beneficios_empresa')->name('eu.beneficios_empresa');
Route::get('worker-benefits', 'PaginaUsaController@beneficios_trabajadores')->name('eu.beneficios_trabajadores');
Route::get('cruise', 'PaginaUsaController@cruceros')->name('eu.cruceros');
Route::get('quote', 'PaginaUsaController@cotizador')->name('eu.cotizador');
Route::get('cp/{cp}', 'PaginaUsaController@buscar_cp');
Route::get('lottery/{convenio}', 'PaginaUsaController@sorteo')->name('eu.sorteo');
Route::get('friendly-hotels', 'PaginaUsaController@hoteles_amigos')->name('eu.hoteles');
Route::get('faq', 'PaginaUsaController@preguntas')->name('eu.preguntas');

/**
 * rutas para los productos de la pagina web
 */
// Route::get('company/{convenio?}/{destino?}/{destino2?}', 'PaginaUsaController@productos')->name('eu.productos');
Route::get('products/{convenio?}/{destino?}/{destino2?}', 'PaginaUsaController@productos')->name('eu.productos');

Route::get('top-destination/{top}/{convenio?}', 'PaginaUsaController@listado_productos_top')->name('eu.top_productos');
Route::get('exclusive-destinations', 'PaginaUsaController@estancias_especiales')->name('eu.exclusivos');
Route::get('exclusive/{slug}/{entrada?}', 'PaginaUsaController@detalle_exclusivo')->name('eu.detalle_exclusivos');

Route::get('product-details/{id}', 'PaginaUsaController@detalle_estancia')->name('eu.detalle_estancia');
Route::get('get-info/{id}', 'PaginaUsaController@get_info_estancia');

// productos exclusivod
// Autor: Diego Sanchez
Route::get('miami/{convenio?}', 'PaginaUsaController@miami')->name('eu.miami');
Route::get('las-vegas/{convenio?}', 'PaginaUsaController@vegasnv')->name('eu.vegasnv');
Route::get('puntacana/{convenio?}', 'PaginaUsaController@puntacana')->name('eu.puntacana');
Route::get('grand-oasis/{convenio?}', 'PaginaUsaController@cancun')->name('eu.cancun');
// Route::get('cancun/{convenio?}', 'PaginaUsaController@cancun')->name('eu.cancun');
Route::get('riu-cancun/{convenio?}', 'PaginaUsaController@riu_cancun')->name('eu.riu_cancun');
Route::get('riu-santa-fe/{convenio?}', 'PaginaUsaController@riu_santa_fe')->name('eu.riu_santa_fe');
Route::get('riu-palace-jamaica/{convenio?}', 'PaginaUsaController@riu_palace_jamaica')->name('eu.riu_palace_jamaica');
Route::get('riu-palace-riviera/{convenio?}', 'PaginaUsaController@riu_palace_riviera')->name('eu.riu_palace_riviera');
Route::get('hawaii/{convenio?}', 'PaginaUsaController@hawai')->name('eu.hawai');
Route::get('riu-palace-paradise/{convenio?}', 'PaginaUsaController@bahamas')->name('eu.bahamas');
Route::get('disney-world/{convenio?}', 'PaginaUsaController@disney_world')->name('eu.disney_world');

// Route::get('disney-world/{convenio?}', 'PaginaUsaController@disney_world')->name('eu.disney_world');

/**
 * Rutas para procesar el registro de la compra
 */
Route::resource('process-payment', 'Usa\ComprarController');
Route::get('checkout-payment', 'Usa\ComprarController@payment_card')->name('process-payment.payment');
Route::get('checkout-payment-lat', 'Usa\ComprarController@payment_card_lat')->name('process-payment.payment_lat');
Route::get('create-payment-charge', 'Usa\ComprarController@hosted')->name('process-payment.hosted');
Route::get('purchase-completed/{id}', 'Usa\ComprarController@finalizar_compra')->name('process-payment.finalizar_compra');
// Route::get('show-contract/{id}', 'Usa\ComprarController@mostrar_contrato')->name('mostrar_contrato');
Route::get('download-contract/{id}', 'Usa\ComprarController@descargar_contrato')->name('download_contrato');
Route::get('generate-contract/{id}', 'Usa\ComprarController@obtener_contrato_pdf');

Route::post('user-alert-usa', 'AlertaUsaController@alerta_usa')->name('eu.user_alert');
