<?php

namespace App\Http\Livewire\Concal;

use App\Actividad;
use App\Concal;
use Auth;
use Livewire\Component;

class Actividades extends Component
{
    public $concal_id;
    public $show_form        = false;
    public $show_actividades = true;
    public $seguimiento;
    public $actividad_text;
    // public $actividades_historial = [];

    public function mount()
    {
        $this->historial();
    }

    public function render()
    {
        return view('livewire.concal.actividades');
    }

    public function showForm()
    {
        if ($this->show_form == false) {
            $this->show_form = true;
        } else {
            $this->show_form = false;
        }
    }

    public function showActividad()
    {
        $this->historial();
        if ($this->show_actividades == false) {
            $this->show_actividades = true;
        } else {
            $this->show_actividades = false;
        }

    }

    public function save()
    {
        $actividad            = new Actividad;
        $actividad->user_id   = Auth::id();
        $actividad->concal_id = $this->concal_id;
        $actividad->notas     = $this->actividad_text;

        if ($actividad->save()) {
            $this->historial();
            $this->show_form      = false;
            $this->actividad_text = '';
            $this->showAlertSweet('success', 'Se ha agregado una nueva actividad', '¡Hecho!');
        } else {
            $this->showAlertSweet('error', 'No se pudo agregar la actividad', '¡Hecho!');
        }
    }

    public function historial()
    {
        $this->seguimiento = Concal::findOrFail($this->concal_id);

        // $this->actividades_historial = Actividad::where('concal_id', $this->concal_id)->paginate();
    }

    public function showAlert($type = 'success', $message = '')
    {
        $this->dispatchBrowserEvent('alert', ['type' => $type, 'message' => $message]);
    }

    public function showAlertSweet($type = 'success', $message = '', $title = '')
    {
        $this->dispatchBrowserEvent('alertSweet', ['type' => $type, 'message' => $message, 'title' => $title]);
    }
}
