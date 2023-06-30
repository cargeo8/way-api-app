<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Arr;

class ControlPlacaDetalleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "processId" => $this["id"],
            "refNumber" => $this["referencia_cuenta"],
            "statusId" => $this["codigo_estado_seguimiento_actual"],
            "status" => $this["estado_seguimiento_actual"]["descripcion_estado"] ?? "Sin actualizaciones",
            "detailItem" => [
                "itemCode" => $this["articulo"]["codigo_articulo"],
                "itemName" => $this["articulo"]["nombre_articulo"],
                "itemImageUrl" => collect($this["articulo"]["imagenes"] ?? [])->pluck("imagen"),
                "sku" => $this["articulo"]["unidad_medida"]["nombre_medida"],
                "price" => 0,
                "qty" => 1
            ],
            "detailProcess" => Arr::map($this["seguimientos"] ?? [], fn ($_seguimiento) => [
                "statusId" => $_seguimiento["estado"]["id"],
                "status" => $_seguimiento["estado"]["descripcion_estado"],
                "date" => $_seguimiento["fecha_proceso"],
            ])
        ];
    }
}
