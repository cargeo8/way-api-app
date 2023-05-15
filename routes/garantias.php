<?php

use App\Http\Controllers\Api\GarantiasController;
use Illuminate\Support\Facades\Route;

Route::get("garantias/{user}", [GarantiasController::class, 'GetMisGarantias']);
