<?php

namespace App\Http\Livewire\Ajustes;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Configuracion;

class ImagePreload extends Component
{

    use WithFileUploads;

    public $photo;
    public $flag = false;

    public function render()
    {
        return view('livewire.ajustes.image-preload');
    }


    public function mount()
    {
        $config = Configuracion::where('name', 'preload_image')->first();

        if ($config && $config->data != null) {
            $this->photo = $config->data;
        }else
        {
            $this->photo = 'images/icono01.png';
        }
    }

    public function save()
    {
        $this->flag = true;
        $dir  = $this->photo->storeAs('images', 'preload_image.png', 'path_public');
        
        if ($dir != null) {
            $config = Configuracion::updateOrCreate(
                            ['name' => 'preload_image'],
                            ['data' => $dir]
                        );
            $this->showAlert('success', '¡Imagen cargada exitosamente!');
        }else{
            $this->showAlert('error', '¡No se pudo cargar la imagen, intentalo mas tarde...!');
        }
    }


    public function showAlert($type = 'success', $message = '')
    {
        $this->dispatchBrowserEvent('alert', ['type' => $type,  'message' => $message]);
    }
}
