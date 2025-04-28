<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CuentasDetalleResource;
use App\Http\Resources\CuentasResource;
use App\Http\Services\CuentasService;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class CuentasController extends Controller
{
    public function __construct(private CuentasService $_cuentas) {}
    public function GetMisCuentas(string $user_id)
    {
        $user = Auth::user();
        if (!$user->codigo_cliente)
            return response()->json(
                ["message" => "Este usuario no tiene codigo de cliente"],
                Response::HTTP_NOT_ACCEPTABLE
            );

        $mis_cuentas = $this->_cuentas->GetMisCuentas($user->codigo_cliente);

        if ($mis_cuentas->failed())
            return response()->json($mis_cuentas->json(), $mis_cuentas->status());

        return CuentasResource::make($mis_cuentas->json());
    }
    public function GetDetalleCuenta(string $user_id, int $referen_id)
    {
        $user = Auth::user();
        if (!$user->codigo_cliente)
            return response()->json(
                ["message" => "Este usuario no tiene codigo de cliente"],
                Response::HTTP_NOT_ACCEPTABLE
            );

        $detalle_cuenta = $this->_cuentas->GetDetalleCuenta($user->codigo_cliente, $referen_id);
        if ($detalle_cuenta->failed())
            return response()->json($detalle_cuenta->json(), $detalle_cuenta->status());

        return CuentasDetalleResource::make($detalle_cuenta);
    }
}
