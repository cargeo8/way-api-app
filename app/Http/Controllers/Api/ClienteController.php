<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Cliente\GetMyClientRequest;
use App\Http\Services\ClienteService;

class ClienteController extends Controller
{
    public function __construct(private ClienteService $_cliente)
    {
    }
    #/api/getAllTest?codigo_cliente=1221212
    public function GetMyClient(GetMyClientRequest $request)
    {
        return $this->_cliente->GetMyClient($request->codigo_cliente);
    }
}
