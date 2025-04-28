<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PromocionResource;
use App\Http\Services\PromocionesService;
use Illuminate\Http\Request;

class PromocionesController extends Controller
{
    public function __construct(private PromocionesService $_promociones)
    {
    }
    public function GetPromocionesByUser(?int $user_id = null)
    {
        $proms = $this->_promociones->GetPromociones($user_id);

        if ($proms->failed())
            return response()->json($proms->json(), $proms->status());
        return PromocionResource::make($proms->json());
    }
    public function GetImage($path)
    {
        $proms = $this->_promociones->GetPromocionesImage($path);
        return $proms->body();
    }
}
