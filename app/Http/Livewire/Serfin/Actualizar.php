<?php

namespace App\Http\Livewire\Serfin;

use Livewire\Component;
use Storage;
use App\ActualizarSerfin;
use App\Traits\CobranzaHelper;
use App\Traits\TerminalTrait;


class Actualizar extends Component
{
    use CobranzaHelper, TerminalTrait;
    

    public $files;
    public $text_estatus = 'Actualizar Serfin';
    public $validacion_estatus = false;
    public $show_res = false;
    public $actualizacion;
    public $num_registros, $num_errores, $num_insertados ,$num_actualizados;
    public $show_message = false;
    public $text_message = 'El sistema se actualizara, por favor espera a que termine el proceso...';
    



    public function mount()
    {
        $this->actualizacion = ActualizarSerfin::whereCreado(date('Y-m-d'))->first();
        if ($this->actualizacion != null) {
            $this->text_estatus = '¡Sistema actualizado!';
        }

    }



    public function render()
    {

        $this->show_message = false;
        $contents = Storage::disk('sftp')->listContents('Outbox');
        
        $this->files = collect($contents)
            ->where('type', 'file')
            // ->filter(function($item){
            //     if (substr($item['path'], 15, 8) == date('Ymd') && preg_match('/[A-Z0-9]+C/', $item['path'])) {
            //         return $item;
            //     }
            // })
            ->map(function ($item) {
                return [
                    'name' => $item['basename'],
                    'path' => $item['path'],
                    'dirname' => $item['dirname'],
                ];
            })
            ->toArray();

        return view('livewire.serfin.actualizar');
    }


    public function actualizar_serfin($archivo)
    {

       


        $directory        = "/files/cobranza/" . date('y/m/d');
        $date             = date('Ymd');
        $fileName         = $archivo;
        $directoryFile    = $directory . "/" . $fileName;
        $fileSftp         = 'Outbox/' . $fileName;        
        $dir              = $this->createDirectory();

        if ($dir == true) {
            $this->show_message = true;
            //obtenemos el archivo del buzon
            $archivo = Storage::disk('sftp')->get($fileSftp);
            //grabamos el archivo del buzon en nuestro nuevo directorio
            $path = Storage::disk('public_cobra')->put($directoryFile, $archivo);

            if ($path == true) {
                // $count = $this->origen($date, $fileName, $directoryFile, $directory);
                $count = $this->origen_doble($date, $fileName, $directoryFile, $directory);

                dd($count);

            }
        }
        // return response()->json(['estatus' => false]);
    }



    public function createDirectory()
    {
        $year   = date("y");
        $month  = date("m");
        $day    = date("d");
        $public = public_path() . "/files/cobranza/";

        if (!is_dir($public)) {
            mkdir($public, 0777, true);
        }

        if (!file_exists($public . $year)) {
            mkdir($public . $year, 0777, true);
        }

        if (!file_exists($public . $year . "/$month")) {
            mkdir($public . $year . "/$month", 0777, true);
        }

        if (!file_exists($public . $year . "/$month/$day")) {
            mkdir($public . $year . "/$month/$day", 0777, true);
        }

        return true;
    }



    public function showAlert($type = 'success', $message = '', $close = false)
    {
        $this->dispatchBrowserEvent('sweet', ['type' => $type,  'message' => $message, 'close' => $close]);
    }

    public function closeSweet()
    {
        $this->dispatchBrowserEvent('sweet-close');
    }

}
