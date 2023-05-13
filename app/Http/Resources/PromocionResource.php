<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Arr;

class PromocionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return Arr::map(
            $this->resource,
            fn ($item) =>
            [
                "postId" => $item["id"],
                "url" => $item["link"],
                "url_image" => $item["image_url"],
                "title" => $item["title"],
                "subTitle" => $item["subtitle"],
                "description" => $item["descripcion"],
                "date" => Carbon::parse($item["fecha_proceso"])->format("Y-m-d")
            ]
        );
    }
}
