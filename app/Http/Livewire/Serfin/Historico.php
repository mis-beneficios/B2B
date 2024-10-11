<?php

namespace App\Http\Livewire\Serfin;

use Livewire\Component;
use Storage;
use Carbon\Carbon;
use App\Traits\CobranzaHelper;
use App\Exports\RespuestaExcelExport;
use Excel;
class Historico extends Component
{
    use CobranzaHelper;


    public $fecha, $year, $month, $day;
    public $base_path = 'files/cobranza/';
    public $files = [];
    public $show_files = false;
    public $content_file = false;
    public $file_data;

    public function render()
    {
        return view('livewire.serfin.historico');
    }


    public function showAlert($type = 'success', $message = '')
    {
        $this->dispatchBrowserEvent('alert', ['type' => $type,  'message' => $message]);
    }


    public function get_files()
    {
        $this->content_file = false;
        // $this->base_path = '';
        $date          = Carbon::create($this->fecha);
        $year     = $date->format('y');
        $month    = $date->format('m');
        $day      = $date->format('d');
        
        $dir = $this->base_path . $year .'/'. $month .'/'. $day;
        
        $contents = Storage::disk('public_cobra')->listContents($dir);
        
        $this->files = collect($contents)
            ->where('type', 'file')
            ->map(function ($item) {
                return [
                    'name' => $item['basename'],
                    'path' => $item['path'],
                    'dirname' => $item['dirname'],
                ];
            })
            ->toArray();
        $this->show_files = true;
        
        if ($this->files == null) {
            $this->show_files = false;
            $this->showAlert('warning', 'No se encontraron archivos en esta fecha');
        }

    }

    public function show_data($file)
    {
        // $this->show_files = false;
        $this->content_file = true;
        $this->file_data = $file;
    }

    public function download($file)
    {
        return Storage::disk('public_cobra')->download($file);
    }


    public function downloadExcel($file, $name)
    {

        $nombre_archivo  = substr($name, 0,-4) . '.xlsx';

        $archivo = public_path().'/'.$file;

        $fp   = fopen($archivo, 'r+');

        while (!feof($fp)) {
            $linea[] = fgets($fp);
        }
        fclose($fp);

        $pacific = [];

        $registros = array_splice($linea, 1, -2);
        if (isset($registros) && is_array($registros)) {
            foreach ($registros as $k => $v) {
                $opt = preg_split('/__/', substr($v, 135, 40));
                if (isset($opt[1])) {
                    if (isset($opt[2])) {
                        $aux = 1;
                        $res = 0;
                        do {
                            $opt_      = explode('_', $opt[$aux]); //NUMERO DE REFERENCIA
                            $cantidad  = substr($v, 13, 15);
                            $pacific[] = [
                                'importe'    => floatval((($cantidad) * 0.01) / 2),
                                'fecha'      => substr($v, 62, 8), //FECHA DE COBRO TIENE QUE SER UN DIA ANTERIOR
                                'fecha2'     => date('Ymd'),
                                'banco'      => (string) substr($v, 70, 3),
                                'clave'      => (string) substr($v, 73, 2),
                                'tarjeta'    => substr($v, 75, 20),
                                'cliente'    => substr($v, 95, 40), //NOMBRE DEL TITULAR
                                'referencia' => $opt[0] . '__' . $opt_[0] . '_' . $opt_[1],
                                'cliente2'   => substr($v, 95, 40),
                                'ceros'      => substr($v, 215, 15),
                                'code'       => substr($v, 230, 7),
                                'agencia'    => substr($v, 237, 40),
                                'clave2'     => substr($v, 277, 2), // CLAVE DEL PAGO
                            ];
                            $aux++;
                            $res++;
                        } while ($aux <= 2);
                    } else {
                        // Toma en cuenta Pacific y Home travel
                        $opt_      = explode('_', $opt[1]); //NUMERO DE REFERENCIA
                        $cantidad  = substr($v, 13, 15);
                        $pacific[] = [
                            'importe'    => floatval(($cantidad) * 0.01),
                            'fecha'      => substr($v, 62, 8), //FECHA DE COBRO TIENE QUE SER UN DIA ANTERIOR
                            'fecha2'     => date('Ymd'),
                            'banco'      => (string) substr($v, 70, 3),
                            'clave'      => (string) substr($v, 73, 2),
                            'tarjeta'    => substr($v, 75, 20),
                            'cliente'    => substr($v, 95, 40), //NOMBRE DEL TITULAR
                            'referencia' => $opt[0] . '__' . $opt_[0] . '_' . $opt_[1],
                            'cliente2'   => substr($v, 95, 40),
                            'ceros'      => substr($v, 215, 15),
                            'code'       => substr($v, 230, 7),
                            'agencia'    => substr($v, 237, 40),
                            'clave2'     => substr($v, 277, 2), // CLAVE DEL PAGO
                        ];
                    }
                } else {
                    $cantidad  = substr($v, 13, 15);
                    $pacific[] = [
                        'importe'    => floatval(($cantidad) * 0.01),
                        'fecha'      => substr($v, 62, 8), //FECHA DE COBRO TIENE QUE SER UN DIA ANTERIOR
                        'fecha2'     => date('Ymd'),
                        'banco'      => (string) substr($v, 70, 3),
                        'clave'      => (string) substr($v, 73, 2),
                        'tarjeta'    => substr($v, 75, 20),
                        'cliente'    => substr($v, 95, 40), //NOMBRE DEL TITULAR
                        'referencia' => $opt[0],
                        'cliente2'   => substr($v, 95, 40),
                        'ceros'      => substr($v, 215, 15),
                        'code'       => substr($v, 230, 7),
                        'agencia'    => substr($v, 237, 40),
                        'clave2'     => substr($v, 277, 2), // CLAVE DEL PAGO
                    ];
                }
            }
            return Excel::download(new RespuestaExcelExport($pacific), $nombre_archivo);
        } else {
            return false;
        }
    
    }
}
