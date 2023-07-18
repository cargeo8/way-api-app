<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Arr;

class CuentasDetalleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "transactionId" => $this["id"],
            "refNumber" => $this["referencia_cuenta"],
            "type" => $this["tipo_de_venta"],
            "date" => $this["fecha_contrato"],
            "totalAmount" => $this["monto_contrato"],
            "totalPayment" => $this["valor_cuota"],
            "balance" => $this["saldo"],
            "status" => $this["estado"],
            "branch" => $this["sucursal"]["nombre"] ?? "-",
            "detailItems" => Arr::map(
                $this["prospecto"]["detalles"] ?? [],
                fn ($detalle) => [
                    "itemId" => $detalle["id"],
                    "itemCode" => $detalle["articulo"]["codigo_articulo"],
                    "itemName" => $detalle["articulo"]["nombre_articulo"],
                    "itemImagesUrl" => array_column($detalle["articulo"]["imagenes"], "imagen"),
                    "skuCode" => $detalle["articulo"]["unidad_medida"]["codmed"],
                    "sku" => $detalle["articulo"]["unidad_medida"]["nombre_medida"],
                    "price" => $detalle["precio_unitario"],
                    "qty" => $detalle["cantidad"]
                ]
            ),
            "detailPayments" => Arr::map(
                $this["pagos"],
                fn ($cobro) => [
                    "paymentId" => $cobro["id"],
                    "date" => $cobro["fecha_proceso"],
                    "paymentAmount" => $cobro["valcuota"],
                    "type" => $cobro["tipo_recibo"]["descripcion"],
                    "branch" => $cobro["sucursal"]["nombre"] ?? "-",
                    "paid" => $cobro["es_cobros_c"]
                ]
            )
        ];
    }
}
