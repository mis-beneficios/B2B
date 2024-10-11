<?php
/**
 *  Validacion de registros con tarjetas asociadas
 *  Autor: Isw. Diego Enrique Sanchez
 *  Creado: 2024-07-01
 */
namespace App\Helpers;


use DB;

class TarjetaHelper
{
    public static function  desvincularReservas($reservaciones){
        DB::table('reservaciones')
            ->whereIn('id', $reservaciones)
            ->update([
                'tarjeta_id' => null,
            ]);
    }

    public static function  desvincularContratos($contratos){
        DB::table('contratos')
            ->whereIn('id', $contratos)
            ->update([
                'tarjeta_id' => null,
            ]);
    }
}
