<?php

use App\Http\Controllers\Api\PromocionesController;
use Illuminate\Support\Facades\Route;

Route::get("promociones/{user_id?}", [PromocionesController::class, 'GetPromocionesByUser']);
