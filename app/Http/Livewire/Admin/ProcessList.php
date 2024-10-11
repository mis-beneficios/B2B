<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use DB;

class ProcessList extends Component
{
    public function render()
    {
        $procesos = DB::select('show processlist');
        $datos    = json_decode(json_encode($procesos), true);

        // foreach ($datos as $val) {
        //     $data[] = array(
        //         "1" => '<div class="demo-checkbox"><input type="checkbox" id="proceso_'.$val['Id'].'" name="eliminiar[]" value="'.$val['Id'].'" class="filled-in chk-col-blue"><label for="proceso_'.$val['Id'].'"></label></div>',
        //         // "1" => '<input type="checkbox" name="eliminar[]" value="' . $val['Id'] . '">',
        //         "2" => $val['Id'],
        //         "3" => $val['User'],
        //         "4" => $val['Host'],
        //         "5" => $val['db'],
        //         "6" => $val['Command'],
        //         "7" => $val['Time'],
        //         "8" => $val['State'],
        //         "9" => $val['Info'],
        //     );
        //     $btn = '';
        // }

        return view('livewire.admin.process-list', compact('datos'));
    }
}
