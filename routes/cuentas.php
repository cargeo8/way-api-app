<?php

use App\Http\Controllers\Api\CuentasController;
use Illuminate\Support\Facades\Route;

Route::get("cuentas/{user}", [CuentasController::class, 'GetMisCuentas']);
