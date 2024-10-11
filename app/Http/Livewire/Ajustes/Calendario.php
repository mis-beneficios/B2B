<?php

namespace App\Http\Livewire\Ajustes;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Configuracion;

class Calendario extends Component
{

    use WithFileUploads;

    public $photo;
    public $flag = false;
    public function render()
    {
        return view('livewire.ajustes.calendario');
    }



    public function mount()
    {
        $config = Configuracion::where('name', 'calendario_temporadas')->first();

        if ($config && $config->data != null) {
            $this->photo = $config->data;
        }else
        {
            $this->photo = 'images/calendario_beneficios_2022-2023.jpg';
        }
    }

    public function save()
    {
        $this->flag = true;
        $dir  = $this->photo->storeAs('images', 'calendario_temporadas.png', 'path_public');
        
        if ($dir != null) {
            $config = Configuracion::updateOrCreate(
                            ['name' => 'calendario_temporadas'],
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
