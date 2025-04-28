<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Arr;

class CuentasResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return Arr::map($this->resource, fn ($item) => [
            "transactionId" => $item["id"],
            "refNumber" => $item["referencia_cuenta"],
            "type" => $item["tipo_de_venta"],
            "date" => $item["fecha_contrato"],
            "totalAmount" => $item["monto_contrato"],
            "totalPayment" => $item["valor_cuota"],
            "balance" => $item["saldo"],
            "status" => $item["estado"],
        ]);
    }
}
