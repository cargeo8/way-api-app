<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Services\BannerMarcasService;
use Illuminate\Http\Request;

class BannerMarcasController extends Controller
{
    public function __construct(private BannerMarcasService $_marcas)
    {
    }
    public function GetMarcas(?int $user_id = null)
    {
        $proms = $this->_marcas->GetMarcas($user_id);

        if ($proms->failed())
            return response()->json($proms->json(), $proms->status());

        return response()->json($proms->json());
    }
    public function GetImage($path)
    {
        $proms = $this->_marcas->GetMarcasImage($path);
        return $proms->body();
    }
}
