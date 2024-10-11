<?php

namespace App\Http\Livewire\Pagina;

use Illuminate\Http\Request;
use Livewire\Component;
use Livewire\WithFileUploads;
use App\Sorteo as mSorteo;
use Carbon\Carbon;
use App\SorteoConvenio;
use App\Mail\Mx\EnviarSorteo;
use Mail;

class Sorteo extends Component
{
    use WithFileUploads;

    public $nombre, $apellidos, $email, $telefono_celular, $telefono_casa, $el_mas_chistoso, $el_mas_divertido, $el_mas_romantico, $testimonio, $uso_multimedia, $publicidad, $recaptcha, $uso_media;
    public $llave;
    public $bandera = false;
    public $folio = '';
    public $btn_message = 'Enviar';

    public function render()
    {
        $sorteo = mSorteo::where('llave', $this->llave)->first();
        return view('livewire.pagina.sorteo', compact('sorteo'));
    }

    public function save()
    {
        $this->btn_message = 'Enviando datos...';
        $sorteo = mSorteo::where('llave', $this->llave)->first();
        $validacion = SorteoConvenio::where(['folioNo' => $sorteo->id, 'email' => $this->email])->first();
        $val = ($validacion != null) ? true : false;

        $validacionData = $this->validate([
            'nombre'                 => 'required | string | max:40',
            'apellidos'              => 'required | string | max:40',
            'email'                  => ($val) ? 'required | email | unique:concursoconvenios,email' : 'required | email',
            'telefono_celular'       => 'required | numeric | digits:10',
            'telefono_casa'          => ($this->telefono_casa) ? 'numeric | digits:10' : '',
            'el_mas_chistoso'        => ($this->el_mas_chistoso) ? 'max:10240' : '', // Máximo 10 MB
            'el_mas_divertido'       => ($this->el_mas_divertido) ? 'max:10240' : '', // Máximo 10 MB
            'el_mas_romantico'       => ($this->el_mas_romantico) ? 'max:10240' : '', // Máximo 10 MB
            // 'el_mas_chistoso'        => ($this->el_mas_chistoso) ? 'file|mimes:jpeg,png,jpg,gif,mp4,avi,mov,flv|max:10240' : '', // Máximo 10 MB
            // 'el_mas_divertido'       => ($this->el_mas_divertido) ? 'file|mimes:jpeg,png,jpg,gif,mp4,avi,mov,flv|max:10240' : '', // Máximo 10 MB
            // 'el_mas_romantico'       => ($this->el_mas_romantico) ? 'file|mimes:jpeg,png,jpg,gif,mp4,avi,mov,flv|max:10240' : '', // Máximo 10 MB
            'testimonio'             => 'required',
            'uso_multimedia'         => 'accepted',
            // 'recaptcha'              => 'captcha',
        ]);

        // try {
            
        // } catch (Exception $e) {
            
        // }
        $reg = new SorteoConvenio;
        $reg->nombre_completo   = $this->nombre;
        $reg->apellidos         = $this->apellidos;
        $reg->email             = $this->email;
        $reg->empresa           = $sorteo->convenio;
        $reg->telefono_oficina  = $this->telefono_casa;
        $reg->telefono_celular  = $this->telefono_celular;
        $reg->publicidad        = $this->publicidad;
        $reg->terminos          = $this->uso_multimedia;
        $reg->folioNo           = $sorteo->id;
        $reg->testimonio        = $this->testimonio;
        

        $path = 'sorteos';
        
        if ($this->el_mas_chistoso != null) {
            $name = $this->el_mas_chistoso->getClientOriginalName(); 
            $dir  = $this->el_mas_chistoso->storeAs($path, $name, 'path_public');

            $reg->media_chistoso = $path . '/' . $name;     
        }

        if ($this->el_mas_divertido!=null) {
            $name = $this->el_mas_divertido->getClientOriginalName(); 
            $dir  = $this->el_mas_divertido->storeAs($path, $name, 'path_public');
            
            $reg->media_divertido = $path . '/' . $name;     
            
        }

        if ($this->el_mas_romantico!=null) {
            $name = $this->el_mas_romantico->getClientOriginalName(); 
            $dir  = $this->el_mas_romantico->storeAs($path, $name, 'path_public');
            
            $reg->media_romantico = $path . '/' . $name;     
        }
        
        $reg->created       = Carbon::now(); 
        $reg->modified      = Carbon::now();

        if($reg->save()){
            Mail::to($this->email)->send(new EnviarSorteo($reg));
            $this->bandera = true;
            $this->folio = $reg->id;
            $this->btn_message = '¡Listo!';
        }else{
            $this->btn_message = 'Enviar';
        }

    }
}
