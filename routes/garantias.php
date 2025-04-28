<?php

use App\Http\Controllers\Api\GarantiasController;
use Illuminate\Support\Facades\Route;

Route::get("garantias/{user}", [GarantiasController::class, 'GetMisGarantias']);
Route::get("garantias/{user_id}/detalle/{processId}", [GarantiasController::class, 'GarantiaDetalle']);
