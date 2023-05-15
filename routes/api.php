<?php

use App\Http\Controllers\Api\Auth\AuthenticationController;
use App\Http\Controllers\Api\ClienteController;
use App\Http\Controllers\Api\SucursalesController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:api')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
});

Route::middleware("auth:api")
    ->get("getAllTest", [ClienteController::class, "GetMyClient"]);
Route::middleware("auth:api")
    ->get("getAllSucursales", [SucursalesController::class, "GetAllSucursales"]);
Route::middleware("api")->group(function () {
    Route::prefix("auth")->group(function () {
        Route::post("login", [AuthenticationController::class, 'login']);
        Route::post("logout", [AuthenticationController::class, 'logout']);
        Route::post("register", [AuthenticationController::class, 'register']);
    });
});
