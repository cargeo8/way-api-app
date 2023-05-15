<?php

namespace App\Http\Services;

use Illuminate\Http\Client\Response;

class GarantiasService extends BaseService
{
    private const GET_MIS_GARANTIAS = "/api/way-app/garantias/misGarantias";
    private const GET_DETALLE_GARANTIA = "/api/way-app/garantias/detalle";
    public function GetMisGarantias(string $codigo_cliente): Response
    {
        return  $this->Make()->get(self::GET_MIS_GARANTIAS . "/$codigo_cliente");
    }
    public function GetDetalleGarantias(string $ods)
    {
        return  $this->Make()->get(self::GET_DETALLE_GARANTIA . "/$ods");
    }
}
