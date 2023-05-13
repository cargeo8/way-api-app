<?php

namespace App\Http\Services;

use Illuminate\Http\Client\Response;

class CuentasService extends BaseService
{
    private const GET_MIS_CUENTAS = "/api/way-app/cuentas/misCuentas";
    public function GetMisCuentas(string $codigo_cliente): Response
    {
        return $mis_cuentas = $this->Make()->get(self::GET_MIS_CUENTAS . "/$codigo_cliente");
        // return $mis_cuentas->json();
    }
}
