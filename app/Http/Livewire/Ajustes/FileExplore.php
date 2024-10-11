<?php

namespace App\Http\Livewire\Ajustes;

use Livewire\Component;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;


class FileExplore extends Component
{
    public $currentPath = '/';
    public $directories = [];
    public $files = [];
    public $base_directories = [];
    public $dir_url = [];


    public function render()
    {
        $this->loadDirectoryContents();
        return view('livewire.ajustes.file-explore');
    }




    public function loadDirectoryContents()
    {
        $this->base_directories = Storage::disk('path_public')->directories('/');

        // Obtener la lista de carpetas y archivos en la ruta actual
        $contents = Storage::disk('path_public')->listContents($this->currentPath);

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
        $res = Storage::disk('path_public')->delete($file);
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
