<?php

namespace App\Http\Livewire\Comisiones;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Contrato;
use App\Comision;
use App\Pago;
use App\Imports\ComisionesImport;
use Excel;
use Storage;
use DB;


class Actualizar extends Component
{
    use WithFileUploads;

    public $archivo_comisiones;
    public $enganches = [], $comisiones = [];
    public $num_comisiones  = 0;
    public $num_enganches   = 0;

    public function render()
    {
        return view('livewire.comisiones.actualizar');
    }

    public function procesarComisiones()
    {
        $this->num_comisiones   = 0;
        $this->num_enganches    = 0;

        $this->validate([
            'archivo_comisiones' => 'required|mimes:xlsx,xls',
        ]);

        $excel = Excel::toArray(new ComisionesImport, $this->archivo_comisiones->store('temp'));


        //Eliminamos la primera fila que corresponde a la cabecera de tipos y nombre de datos que requiere el archivo
        array_shift($excel[0]);

        foreach ($excel[0] as $contrato) {
            if ($contrato[0] != null && $contrato[3] != null) {
                
                if ($contrato[3] === 'Comision') {
                    $this->num_comisiones++;
                }
                
                if($contrato[3] === 'Enganche'){
                    $this->num_enganches++;
                }

                $comision = Comision::where('contrato_id', $contrato[0])
                    ->where('tipo', $contrato[3])
                    ->update([
                        'pagado' => 1,
                        'estatus' => $contrato[1],
                        'pagado_en' => isset($contrato[2]) ? $contrato[2] : 'No definido',
                    ]);
            }
        }

        $mensajeComisinoes = $this->num_comisiones ." Comisiones actualizadas exitosamente.";
        $mensajeEnganches  = $this->num_enganches ." Enganches actualizados exitosamente.";

        $this->showAlert('success', $mensajeComisinoes ."<br>". $mensajeEnganches, '¡Hecho!');
        $this->archivo_comisiones = '';
    }



    public function showAlert($type = 'success', $message = '', $title = '')
    {
        $this->dispatchBrowserEvent('alertSweet', ['type' => $type,  'message' => $message, 'title' => $title]);
    }

    public function downloadExcel()
    {
        // return response()->download(storage_path('exports/export.csv'));
        return Storage::disk('path_public')->download('files/layout_act_comisiones.xlsx');
    }
}
