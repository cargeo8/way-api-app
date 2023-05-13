<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Services\CuentasService;
use App\Models\User;
use Illuminate\Http\Request;

class CuentasController extends Controller
{
    public function __construct(private CuentasService $_cuentas)
    {
    }
    public function GetMisCuentas(User $user)
    {
        $mis_cuentas = $this->_cuentas->GetMisCuentas($user->codigo_cliente);
        return $mis_cuentas;
    }
}
