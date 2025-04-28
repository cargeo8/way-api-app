<?php

namespace App\Http\Services;

use App\Http\Services\BaseService;

class BannerMarcasService extends BaseService
{
    public const GET_MARCAS = "/api/way-app/getMarcas";
    public const GET_MARCAS_IMAGE = "/api/way-app/getMarcaImage";

    public function GetMarcas(?int $user)
    {
        return $this->Make()->get(self::GET_MARCAS);
    }
    public function GetMarcasImage(string $path)
    {
        return $this->Make()->get(self::GET_MARCAS_IMAGE . "/" . $path);
    }
}
