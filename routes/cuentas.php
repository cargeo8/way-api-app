<?php

use App\Http\Controllers\Api\CuentasController;
use Illuminate\Support\Facades\Route;

Route::get("cuentas/{user_id}", [CuentasController::class, 'GetMisCuentas']);
Route::get("cuentas/{user_id}/detalle/{referen_id}", [CuentasController::class, 'GetDetalleCuenta']);
