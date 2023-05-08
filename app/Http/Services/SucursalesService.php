<?php

namespace App\Http\Services;

use Exception;

class SucursalesService extends BaseService
{
    private const GET_ALL_SUCURSALES_ENDPOINT = "/api/getSucursales";

    public function GetALlSucursales(): mixed
    {
        try {
            //code...
            $allSucursales = $this->Make()->get(self::GET_ALL_SUCURSALES_ENDPOINT);
            return $allSucursales->json();
        } catch (Exception $th) {
            return response()->json(["message" => $th->getMessage() . "\n" . $th->getTraceAsString()], 500);
        }
    }
}
