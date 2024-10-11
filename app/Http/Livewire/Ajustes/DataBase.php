<?php

namespace App\Http\Livewire\Ajustes;

use Livewire\Component;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;


class DataBase extends Component
{
    public $currentPath = 'Mis-Beneficios-Vacacionales';
    public $directories = [];
    public $files = [];
    public $base_directories = [];
    public $dir_url = [];


    public function render()
    {
        $this->loadDirectoryContents();
        return view('livewire.ajustes.data-base');
    }




    public function loadDirectoryContents()
    {
        $this->base_directories = Storage::disk('s3')->directories('/');

        // Obtener la lista de carpetas y archivos en la ruta actual
        $contents = Storage::disk('s3')->listContents($this->currentPath);

        $this->directories = collect($contents)
            ->where('type', 'dir')
            ->map(function ($item) {
                return [
                    'name' => $item['basename'],
                    'path' => $item['path'],
                    'dirname' => $item['dirname'],
                ];
            })
            ->toArray();

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
    }

    public function selectDirectory($directory)
    {
        $this->currentPath = $directory;
        $this->dir_url = explode("/", $this->currentPath);
    }


    public function delete($file)
    {
        $res = Storage::disk('s3')->delete($file);
        if ($res) {
             $this->showAlert('success', '¡Archivo eliminado exitosamente!');
            $this->loadDirectoryContents();
        }else{
             $this->showAlert('error', '¡No se pudo eliminado el archivo seleccionado!');

        }
    }


    public function showAlert($type = 'success', $message = '')
    {
        $this->dispatchBrowserEvent('alert', ['type' => $type,  'message' => $message]);
    }
}
