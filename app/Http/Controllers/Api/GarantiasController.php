<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\GarantiaDetalleResource;
use App\Http\Resources\GarantiasResource;
use App\Http\Services\GarantiasService;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class GarantiasController extends Controller
{
    public function __construct(private GarantiasService $_garantias)
    {
    }
    public function GetMisGarantias()
    {
        $user = Auth::user();
        if (!$user->codigo_cliente)
            return response()->json(
                ["message" => "Este usuario no tiene codigo de cliente"],
                Response::HTTP_NOT_ACCEPTABLE
            );
        $misGarantias = $this->_garantias->GetMisGarantias($user->codigo_cliente);
        if ($misGarantias->failed())
            return response()->json($misGarantias->json(), $misGarantias->status());

        return GarantiasResource::make($misGarantias->json());
    }
    public function GarantiaDetalle(string $user_id, int $processId)
    {
        $user = Auth::user();
        if (!$user->codigo_cliente)
            return response()->json(
                ["message" => "Este usuario no tiene codigo de cliente"],
                Response::HTTP_NOT_ACCEPTABLE
            );
        $detalle = $this->_garantias->GetDetalleGarantias(
            codigo_cliente: $user->codigo_cliente,
            ods_id: $processId
        );
        if ($detalle->failed())
            return response()->json($detalle->json(), $detalle->status());

        return GarantiaDetalleResource::make($detalle->json());
    }
}
