<?php

use App\Http\Controllers\Api\EntregaPlacasController;
use Illuminate\Support\Facades\Route;

Route::get("entregas/{user_id}", [EntregaPlacasController::class, 'MisEntregas']);
Route::get("entregas/{user_id}/detalle/{processId}", [EntregaPlacasController::class, 'DetalleEntregas']);
