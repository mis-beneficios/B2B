<?php

namespace App\Helpers;

use App\Contrato;

class FilterHelper
{
    public function filterBase($fecha_inicio, $fecha_fin, $ejecutivos, $estatus)
    {
        $base = Contrato::with(['padre', 'cliente', 'estancia', 'convenio'])
            ->when($estatus[0] != 'all', function ($query) use ($estatus) {
                return $query->whereIn('estatus', $estatus);
            })
            ->when($ejecutivos[0] != 'all', function ($query) use ($ejecutivos) {
                return $query->whereHas('padre', function ($query) use ($ejecutivos) {
                    return $query->whereIn('title', $ejecutivos);
                });
            })
            ->whereBetween('created', [$fecha_inicio, $fecha_fin])
            ->groupBy('user_id')
            ->get();

        return $base;
    }
}
