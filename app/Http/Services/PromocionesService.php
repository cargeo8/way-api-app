<?php

namespace App\Http\Services;

class PromocionesService extends BaseService
{
    public const GET_PROMOCIONES = "/api/way-app/getPromocionesActivas";
    public const GET_PROMOCIONES_IMAGE = "/api/way-app/getImagePromocion";

    public function GetPromociones(?int $user)
    {
        return $this->Make()->get(self::GET_PROMOCIONES . "/" . ($user ?? ''));
    }
    public function GetPromocionesImage(string $path)
    {
        return $this->Make()->get(self::GET_PROMOCIONES_IMAGE . "/" . $path);
    }
}
