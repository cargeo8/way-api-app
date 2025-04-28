<?php

namespace App\Http\Services;

use Illuminate\Http\Client\Response;

class ControlPlacasService extends BaseService
{
    private const GET_MIS_ENTREGAS = "/api/way-app/controlPlacas/misEntregas";
    private const GET_DETALLE_ENTREGA = "/api/way-app/controlPlacas/detalle";
    public function GetMisEntregas(string $codigo_cliente): Response
    {
        return  $this->Make()->get(self::GET_MIS_ENTREGAS . "/$codigo_cliente");
    }
    public function GetDetalleEntrega(string $codigo_cliente, string $control_placas_id): Response
    {
        return  $this->Make()->get(self::GET_DETALLE_ENTREGA . "?codigo_cliente=$codigo_cliente&control_placas_id=$control_placas_id");
    }
}
