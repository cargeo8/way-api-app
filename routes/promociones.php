<?php

use App\Http\Controllers\Api\PromocionesController;
use Illuminate\Routing\Route;

Route::group(function () {
    Route::get("promociones/{user_id}", [PromocionesController::class, 'GetPromocionesByUser']);
});
