<?php

namespace App\Http\Services;

class SucursalesService extends BaseService
{
    private const GET_ALL_SUCURSALES_ENDPOINT = "/api/getSucursales";

    public function GetALlSucursales(): mixed
    {
        $allSucursales = $this->Make()->get(self::GET_ALL_SUCURSALES_ENDPOINT);
        return $allSucursales->json();
    }
}
