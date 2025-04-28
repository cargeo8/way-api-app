<?php

namespace App\Http\Services;

use Illuminate\Http\Client\Response;

class CuentasService extends BaseService
{
    private const GET_MIS_CUENTAS = "/api/way-app/cuentas/misCuentas";
    private const CUENTAS_BY_PERSONID = "/api/way-app/cuentas/cuentasByPersonId";
    private const GET_DETALLE_CUENTA = "/api/way-app/cuentas/detalle";
    public function GetMisCuentas(string $codigo_cliente): Response
    {
        return  $this->Make()->get(self::GET_MIS_CUENTAS . "/$codigo_cliente");
    }
    public function GetDetalleCuenta(string $codigo_cliente, int $referen_id)
    {
        return  $this->Make()->get(self::GET_DETALLE_CUENTA . "/$codigo_cliente/$referen_id");
    }

    /**
     * @param string $person_id dui,nit o pasaporte de la persona
     * @param string $id_type DUI,NIT o Pasaporte
     * @return Response
     */
    public function GetCuentasByPersonId(string $person_id, string $id_type)
    {
        return  $this->Make()->get(self::CUENTAS_BY_PERSONID . "?person_id=$person_id&id_type=$id_type");
    }
}
