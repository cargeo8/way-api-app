<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Services\SucursalesService;
use Illuminate\Http\Request;

class SucursalesController extends Controller
{
    public function __construct(private SucursalesService $_sucursales)
    {
    }
    public function GetAllSucursales()
    {
        return $this->_sucursales->GetAllSucursales();
    }
}
