<?php

namespace App\Http\Livewire\Comisiones;

use App\JobNotifications;
use Auth;
use Livewire\Component;
use Storage;

class ShowFiles extends Component
{
    public $tipo;
    public $currentPath = '/';
    public $mostrar     = false;
    public $files       = []; // Array con los nombres de archivos almacenados
    public $historial   = []; // Array para almacenar el historial de archivos encontrados
    public $contador    = 0; // Contador para el historial

    protected $listeners = ['recargarData' => 'loadFiles'];

    public function mount()
    {
        // dd($this->tipo);
        $this->loadFiles();
    }

    public function loadFiles()
    {
        // Obtener archivos para el usuario y la fecha actual
        $archivos = JobNotifications::where('user_id', Auth::id())->whereDate('created_at', now())->where('tipo', $this->tipo)->get();

        foreach ($archivos as $archivo) {
            if (Storage::disk('filtrados')->exists($archivo->job_name)) {
                // Verificar si el archivo ya está en el historial
                if (!in_array($archivo->job_name, $this->historial)) {
                    // Nuevo archivo encontrado, incrementar el contador
                    $this->contador++;
                    // Agregar el archivo al historial
                    $this->historial[] = $archivo->job_name;
                    // Agregar el archivo a la lista de archivos para mostrar
                    $this->files[] = $archivo;
                    // Mostramos la alerta de que se ha creado un nuevo archivo
                    $this->showAlert('success', '¡Archivo generado exitosamente!', '¡Hecho!');
                }
            }
        }

        // Actualizar el estado para mostrar o no la información en la vista
        $this->mostrar = $this->contador > 0;
    }

    public function showAlert($type = 'success', $message = '', $title = '')
    {
        $this->dispatchBrowserEvent('alertSweet', ['type' => $type, 'message' => $message, 'title' => $title]);
    }

    public function render()
    {
        $this->loadFiles();
        return view('livewire.comisiones.show-files');
    }

    public function downloadExcel($name)
    {
        $this->showAlert('info', '', '¡Descargando archivo!');
        return Storage::disk('filtrados')->download($name);
    }
}
