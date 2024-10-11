<?php

namespace App\Traits;

use App\Banco;
use App\IntentoCompra;
use App\Tarjeta;
use Auth;
use Carbon\Carbon;
trait PaginaMx
{

    public function crear_tarjeta($data)
    {
        if (isset($data['bank_code'])) {
            $banco    = Banco::where('clave', $data['bank_code'])->first();
            $banco_id = ($banco != null) ? $banco->id : 10;
        } else {
            if ($data['banco_id']) {
                $banco_id = $data['banco_id'];
            } else {
                $banco_id = 162;
            }
        }
        $fecha = Carbon::now();

        $tarjeta           = new Tarjeta;
        $tarjeta->user_id  = Auth::user()->id;
        $tarjeta->banco_id = $banco_id;
        $tarjeta->name     = $data['holder_name'];
        if (isset($data['brand'])) {
            $tarjeta->banco = ($data['brand'] == 'visa') ? 'VISA' : 'Master Card';
        } else {
            $tarjeta->banco = isset($data['type']) ? $data['type'] : 'VISA' ;

        }
        $tarjeta->numero               = str_replace('-', '', $data['card_number']);
        $tarjeta->tipo                 = (isset($data['type']) && $data['type'] == 'credit') ? 'Credito' : 'Debito';
        $tarjeta->mes                  = $data['expiration_month'];
        $tarjeta->ano                  = $data['expiration_year'];
        $tarjeta->cvv2                 = $data['cvv2'];
        $tarjeta->estatus              = 'Confirmada';
        $tarjeta->historico_de_pagos   = 'al_corriente';
        $tarjeta->created              = $fecha;
        $tarjeta->importado            = 0;
        $tarjeta->tipocuenta           = '03';
        $tarjeta->autorizo             = 1;
        $tarjeta->agreeterms           = 1;
        $tarjeta->firstpaymentdeducted = 0;
        // $tarjeta->payment_id           = $data['token_id'];
        $tarjeta->save();
        return $tarjeta;
    }

    public function intento_de_compra($auth, $data = null)
    {
        
        $flag = IntentoCompra::where([
            'user_id' => $auth->id,
            'estancia_id' => $data['estancia_id'],
            'estatus' => 0
        ])->first();

        if ($flag == null) {
            $intento = new IntentoCompra;
            $intento->user_id     = $auth->id;
            $intento->estancia_id = $data['estancia_id'];
            $intento->convenio_id = $data['convenio_id'];
            $intento->fecha       = date('Y-m-d');
            $intento->estatus     = false;
            $intento->intento     = 1;

            $intento->save();

            $res =  $intento->id;
        }else{
            $res = 0;
        }
    }

}
