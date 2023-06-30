<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Arr;

class GarantiaDetalleResource extends JsonResource
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
            "refNumber" => $this["numero_orden"],
            "type" => $this["tipo_servicio"] == 1 ? "domicilar" : "en tienda",
            "statusId" => $this["codigo_estado_seguimiento"],
            "status" => $this["estado_seguimiento_actual"]["descripcion_estado"],
            "detailItem" => [
                "itemCode" => $this["articulo"]["codigo_articulo"],
                "itemName" => $this["articulo"]["nombre_articulo"],
                "itemImageUrl" => collect($this["articulo"]["imagenes"])->pluck("imagen"),
                "sku" => $this["articulo"]["unidad_medida"]["nombre_medida"],
                "price" => 0,
                "qty" => 1
            ],
            "detailProcess" => Arr::map($this["seguimientos"], fn ($_seguimiento) => [
                "statusId" => $_seguimiento["estado"]["id"],
                "status" => $_seguimiento["estado"]["descripcion_estado"],
                "description" => $_seguimiento["comentario"] ?? "N/A",
                "date" => $_seguimiento["fecha_proceso"],
            ])
        ];
    }
}
