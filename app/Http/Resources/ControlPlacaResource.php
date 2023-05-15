<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Arr;

class ControlPlacaResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return Arr::map($this->resource, fn ($item) => [
            "processId" => $item["id"],
            "refNumber" => $item["referencia_cuenta"],
            "statusId" => $item["codigo_estado_seguimiento_actual"],
            "status" => $item["estado_seguimiento_actual"]["descripcion_estado"],
            "detailItem" => [
                "itemCode" => $item["articulo"]["codigo_articulo"],
                "itemName" => $item["articulo"]["nombre_articulo"],
                "itemImageUrl" => collect($item["articulo"]["imagenes"])->pluck("imagen"),
                "sku" => $item["articulo"]["unidad_medida"]["nombre_medida"],
                "price" => 0,
                "qty" => 1
            ]
        ]);
    }
}
