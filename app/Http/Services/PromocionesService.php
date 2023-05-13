<?php

namespace App\Http\Services;

class PromocionesService extends BaseService
{
    public const GET_PROMOCIONES = "/api/way-app/getPromocionesActivas";

    public function GetPromociones(?int $user)
    {
        $promociones = $this->Make()->get(self::GET_PROMOCIONES . "/" . ($user ?? ''));
        return $promociones->json();
    }
}
