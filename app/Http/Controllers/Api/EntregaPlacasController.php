<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ControlPlacaDetalleResource;
use App\Http\Resources\ControlPlacaResource;
use App\Http\Services\ControlPlacasService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class EntregaPlacasController extends Controller
{
    public function __construct(private ControlPlacasService $_controlPlacas)
    {
    }
    public function MisEntregas(int $user_id)
    {
        $user = Auth::user();
        if (!$user->codigo_cliente)
            return response()->json(
                ["message" => "Este usuario no tiene codigo de cliente"],
                Response::HTTP_NOT_ACCEPTABLE
            );
        $misEntregas = $this->_controlPlacas->GetMisEntregas($user->codigo_cliente);
        if ($misEntregas->failed())
            return response()->json($misEntregas->json(), $misEntregas->status());

        return ControlPlacaResource::make($misEntregas->json(1));
    }
    public function DetalleEntregas(string $user_id, int $processId)
    {
        $user = Auth::user();
        if (!$user->codigo_cliente)
            return response()->json(
                ["message" => "Este usuario no tiene codigo de cliente"],
                Response::HTTP_NOT_ACCEPTABLE
            );
        $detalleEntrega = $this->_controlPlacas->GetDetalleEntrega(
            codigo_cliente: $user->codigo_cliente,
            control_placas_id: $processId
        );
        if ($detalleEntrega->failed())
            return response()->json($detalleEntrega->json(), $detalleEntrega->status());
        return ControlPlacaDetalleResource::make($detalleEntrega->json());
    }
}
