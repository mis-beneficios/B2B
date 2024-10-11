<?php
namespace App\Traits;

use App;
use Illuminate\Support\Facades\Http;

trait PassPacific
{
    public function get_password($password)
    {
        $pass     = trim($password);
        $response = Http::get('https://pacifictravels.mx/apirest/view/' . $pass . '.json');
        if ($response->getBody()) {
            $res = json_decode($response->getBody(), true);
        }
        return $res;
    }
}
