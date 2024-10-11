<?php

namespace App\Http\Livewire\Concal;

use App\Concal;
use App\Convenio;
use Livewire\Component;
use Carbon\Carbon;

class Edit extends Component
{
    public $concal_id;
    public $ban_editar = false;
    public $crear_convenio = false;

    protected $listeners = ['crearConvenio' => 'crearConvenio'];

    public $empresa, $pagina_web, $giro, $categoria, $no_empleados, $estado, $paise_id, $sucursales, $sucursal_lugar, $corporativo, $autoriza_logo, $redes, $metodo_pago, $estrategia, $link_beneficios, $siguiente_llamada, $estatus, $calificacion, $conmutador, $contacto, $puesto_contacto, $telefonos, $email, $asistente, $asistenten_telefono, $asistente_email;

    public function mount()
    {
        $concal = Concal::findOrFail($this->concal_id);

        $this->empresa             = $concal->empresa;
        $this->pagina_web          = $concal->pagina_web;
        $this->giro                = $concal->giro;
        $this->categoria           = $concal->categoria;
        $this->no_empleados        = $concal->no_empleados;
        $this->estado              = $concal->estado;
        $this->paise_id            = $concal->paise_id;
        $this->sucursales          = $concal->sucursales;
        $this->sucursal_lugar      = $concal->sucursal_lugar;
        $this->corporativo         = $concal->corporativo;
        $this->autoriza_logo       = $concal->autoriza_logo;
        $this->redes               = $concal->redes;
        $this->metodo_pago         = $concal->metodo_pago;
        $this->estrategia          = $concal->estrategia;
        $this->siguiente_llamada   = $concal->siguiente_llamada;
        $this->estatus             = $concal->estatus;
        $this->calificacion        = $concal->calificacion;
        $this->conmutador          = $concal->conmutador;
        $this->contacto            = $concal->contacto;
        $this->puesto_contacto     = $concal->puesto_contacto;
        $this->telefonos           = $concal->telefonos;
        $this->email               = $concal->email;
        $this->asistente           = $concal->asistente;
        $this->asistenten_telefono = $concal->asistenten_telefono;
        $this->asistente_email     = $concal->asistente_email;
    }

    public function render()
    {
        $concal = Concal::findOrFail($this->concal_id);
        return view('livewire.concal.edit', compact('concal'));
    }

    public function habilitarEdit()
    {
        if ($this->ban_editar == false) {
            $this->ban_editar = true;
            $this->showAlert('info', '¡Ahora puedes editar los datos!');
        } else {
            $this->ban_editar = false;

        }
    }

    public function update()
    {
        $update                      = Concal::findOrFail($this->concal_id);
        $update->empresa             = $this->empresa;
        $update->pagina_web          = $this->pagina_web;
        $update->giro                = $this->giro;
        $update->categoria           = $this->categoria;
        $update->no_empleados        = $this->no_empleados;
        $update->estado              = $this->estado;
        $update->paise_id            = $this->paise_id;
        $update->sucursales          = $this->sucursales;
        $update->sucursal_lugar      = $this->sucursal_lugar;
        $update->corporativo         = $this->corporativo;
        $update->autoriza_logo       = $this->autoriza_logo;
        $update->redes               = $this->redes;
        $update->metodo_pago         = $this->metodo_pago;
        $update->estrategia          = $this->estrategia;
        $update->siguiente_llamada   = $this->siguiente_llamada;
        $update->estatus             = $this->estatus;
        $update->calificacion        = $this->calificacion;
        $update->conmutador          = $this->conmutador;
        $update->contacto            = $this->contacto;
        $update->puesto_contacto     = $this->puesto_contacto;
        $update->telefonos           = $this->telefonos;
        $update->email               = $this->email;
        $update->asistente           = $this->asistente;
        $update->asistenten_telefono = $this->asistenten_telefono;
        $update->asistente_email     = $this->asistente_email;

        if ($update->save()) {
            $this->ban_editar = false;
            if( $this->crear_convenio === true ){
                $this->store_convenio($update);
            }else {
                $this->showAlertSweet('success', 'Se han actualizado correctamente los datos', '¡Hecho!');
            }
        } else {
            $this->showAlertSweet('error', 'No se pudieron actualizar los datos', '¡Hecho!');
        }
    }

    public function crearConvenio($status)
    {
        $this->crear_convenio = ($status == 'cerrado') ? true : false;
    }

    public function store_convenio($data)
    {
        $convenio_res = Convenio::where('empresa_nombre', 'like', "%" . $data->empresa . "%")->orWhere('concal_id', $data->id)->first(['empresa_nombre', 'concal_id', 'user_id', 'id']);
        $fecha = Carbon::now();
        if ($convenio_res != null) {
            if ($convenio_res->concal_id == null || $convenio_res->concal_id == 0) {
                $convenio_res->concal_id = $data->id;
                $convenio_res->save();
                $this->showAlertSweet('success', 'Se ha asociado el seguimiento al convenio localizado como:  <a href="' . route('convenios.show', $convenio_res->id) . '" class="btn btn-link"><i class="fas fa-file-pdf"></i> ' . $convenio_res->empresa_nombre . '</a>', '¡Hecho!');

            } else {
                $this->showAlertSweet('error', 'Se ha producido un error al asociar el convenio');
            }
        } else {
            try {
                $key  = explode(' ', $data->empresa);
                $text = '';

                $llave = preg_replace('([^A-Za-z])', '', $key);

                if (count($llave) > 1) {
                    for ($i = 0; $i < count($llave); $i++) {
                        $text .= substr($llave[$i], 0, 2);
                    }
                } else {
                    $text = $llave[0];
                }

                $convenio                         = new Convenio;
                $convenio->user_id                = $data->user_id;
                $convenio->llave                  = 'mx' . strtolower($text);
                $convenio->empresa_nombre         = $data->empresa;
                $convenio->welcome                = $data->empresa;
                $convenio->bienvenida_convenio    = '';
                $convenio->created                = $fecha->format('Y-m-d');
                $convenio->modified               = $fecha->format('Y-m-d');
                $convenio->activo_hasta           = env('EST_VIGENCIA');
                $convenio->disponible             = 1;
                $convenio->nomina                 = 0;
                $convenio->contrato               = '';
                $convenio->paise_id               = 1;
                $convenio->contrato_nomina        = '';
                $convenio->convenio_maestro       = 0;
                $convenio->convenio_bancario      = 1;
                $convenio->terminos_y_condiciones = '';
                $convenio->comision_conveniador   = env('COM_CONVENIO', 100.00);
                $convenio->video                  = null;
                $convenio->campana_inicio         = $fecha->subDays(10);
                $convenio->campana_fin            = $fecha->subDays(10);
                $convenio->campana_paquetes       = 0;
                $convenio->logo                   = null;
                $convenio->url                    = null;
                $convenio->grupo                  = null;
                $convenio->pago                   = ($data->metodo_pago != null) ? $data->metodo_pago : 'Banca';
                $convenio->visitas_web            = null;
                $convenio->school                 = null;
                $convenio->img                    = '';
                $convenio->img_bienvenida         = null;
                $convenio->leyenda_escuelas       = null;
                $convenio->titulo_escuelas        = null;
                $convenio->salesgroup_id          = null;
                $convenio->concal_id              = $data->id;
                $convenio->fecha_cierre           = date('Y-m-d');
                if ($convenio->save()) {
                    $this->showAlertSweet('success', 'Se ha creado una nueva liga <a href="' . route('convenios.show', $convenio->id) . '" class="btn btn-link"><i class="fas fa-file-pdf"></i> Ver</a>', '¡Hecho!');

                }
            } catch (\Exception $e) {
                $this->showAlertSweet('error', (strpos($e->getMessage(), 'Duplicate entry') ? 'El registor ya existe, comprueba el listado de convenios' : $e->getMessage()), '¡Hecho!');
            }
        }
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
