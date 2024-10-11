<?php

use Illuminate\Support\Facades\Route;

// Panel cliente
Route::group(['prefix' => 'cliente'], function () {
    Route::get('/', function () {
        return redirect()->route('inicio');
    });

    Route::get('/inicio', 'HomeController@index')->name('inicio');
    Route::resource('paquetes', 'Cliente\ContratosController');
    Route::get('obtener-contratos', 'Cliente\HomeController@obtener_contratos');
    Route::get('obtener-pagos/{contrato_id}', 'Cliente\HomeController@obtener_pagos');

    Route::resource('tarjetas', 'Cliente\TarjetaController');
    Route::get('obtener-tarjetas', 'Cliente\TarjetaController@obtener_tarjetas');
    Route::get('obtener-bancos', 'Cliente\TarjetaController@obtener_bancos');
    Route::resource('reservaciones', 'Cliente\ReservacionesController');
    Route::get('obtener-reservaciones', 'Cliente\ReservacionesController@obtener_reservaciones');
    Route::get('profile', 'Cliente\HomeController@index')->name('profile');
    Route::get('get-temporadas-reserva', 'Cliente\ReservacionesController@getTemporada')->name('get_temporadas');
});
