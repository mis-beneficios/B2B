<?php

namespace App\Http\Livewire\Ajustes;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Configuracion;

class Images extends Component
{

    use WithFileUploads;

    public $photo;
    public $flag = false;

    public function render()
    {
        return view('livewire.ajustes.images');
    }


    public function mount()
    {
        $config = Configuracion::where('name', 'background_image')->first();

        if ($config && $config->data != null) {
            $this->photo = $config->data;
        }else
        {
            $this->photo = 'images/fondos/back2.jpg';
        }
    }

    public function save()
    {
        $this->flag = true;
        $dir  = $this->photo->storeAs('images/fondos', 'background_image.jpg', 'path_public');
        
        if ($dir != null) {
            $config = Configuracion::updateOrCreate(
                            ['name' => 'background_image'],
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
