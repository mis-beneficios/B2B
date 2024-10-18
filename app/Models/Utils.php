<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Auth;
use Log;
class Utils extends Model
{
    public function get_config($p_info){
        $id_usuario =  Auth::user()->id;
        Log::debug("response  sp_configuracion_sistema :: ".print_r($p_info,1));

        $response['data']=DB::select('CALL sp_configuracion_sistema(?,?,@success, @message, @log)', [$p_info,$id_usuario]);
        $response['success']=DB::select('SELECT @success AS success')[0]->success;
        $response['message']=DB::select('SELECT @message AS message')[0]->message;
        $response['log']=DB::select('SELECT @log AS log')[0]->log;
        $response=json_decode(json_encode($response), true);
        Log::debug("response  sp_configuracion_sistema :: ".print_r($response,1));
        return $response;
    }
}
