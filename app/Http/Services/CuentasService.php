<?php

namespace App\Http\Services;

use Illuminate\Http\Client\Response;

class CuentasService extends BaseService
{
    private const GET_MIS_CUENTAS = "/api/way-app/cuentas/misCuentas";
    private const GET_DETALLE_CUENTA = "/api/way-app/cuentas/detalle";
    public function GetMisCuentas(string $codigo_cliente): Response
    {
        return  $this->Make()->get(self::GET_MIS_CUENTAS . "/$codigo_cliente");
    }
    public function GetDetalleCuenta(string $codigo_cliente, int $referen_id)
    {
        return  $this->Make()->get(self::GET_DETALLE_CUENTA . "/$codigo_cliente/$referen_id");
    }
}
