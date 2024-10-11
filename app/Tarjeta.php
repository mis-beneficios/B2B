<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use GrahamCampbell\Markdown\Facades\Markdown;
class Tarjeta extends Model
{

    protected $table = 'tarjetas';

    protected $fillable = [
        'user_id',
        'banco_id',
        'name',
        'banco',
        'numero',
        'mes',
        'ano',
        'cvv2',
        'estatus',
        'historico_de_pagos',
        'tipo',
        'created',
        'importado',
        'padre_id',
        'tipocuenta',
        'autorizo',
        'agreeterms',
        'firstpaymentdeducted',
        'payment_id',
    ];

    public $timestamps = false;

    public function getVenceAttribute()
    {

        if ($this->mes < 10) {
            $mes = '0' . $this->mes . '/' . $this->ano;
        } else {
            $mes = $this->mes . '/' . $this->ano;
        }

        return $mes;
    }
    public function getNumeroTarjetaAttribute()
    {
        // return '****-****-****-*' . substr($this->numero, -3);
        $unlock = session('unlock_cards');

        if ($unlock == true) {
            if ($this->tipocuenta == 40) {
                $tarjeta = $this->numero;
            }else{
                $tarjeta_separada = chunk_split($this->numero, 4, '-');
                $tarjeta = substr($tarjeta_separada, 0, strlen($tarjeta_separada) - 1);
            }
        } else {
            $tarjeta = '****-****-****-' . substr($this->numero, -4);
        }

        return $tarjeta;
    }



    public function getVerCvvAttribute()
    {
    
        $unlock = session('unlock_cards');

        if ($unlock == true) {
            $cvv = '['.$this->cvv2.']';
        } else {
            $cvv = '';
        }

        return $cvv;
    }

    public function unlockCard()
    {
        $unlock = session('unlock_cards');

        if ($unlock == false) {
            $tarjeta = '****-****-****-*' . substr($this->numero, -3);
        } else {
            $tarjeta = $this->numero;
        }

        return $tarjeta;
        // return '****-****-****-*' . substr($this->numero, -3);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function contratos()
    {
        return $this->hasMany(Contrato::class, 'contrato_id');
    }

    public function pagos()
    {
        return $this->hasMany(Pago::class, 'tarjeta_id');
    }

    public function r_banco()
    {
        return $this->belongsTo(Banco::class, 'banco_id');
    }



    public function getLogTarjetaAttribute()
    {
        if ($this->log != null) {
            return Markdown::convertToHtml($this->log); // <p>foo</p>
        } else {
            return 'Sin registros';
        }
    }

}
