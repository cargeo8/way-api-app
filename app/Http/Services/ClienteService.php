<?php

namespace App\Http\Services;

class ClienteService extends BaseService
{
    public const GET_MY_CLIENT = "/api/Cliente";

    public function GetMyClient(string $codigo_cliente)
    {
        return ["codigo_cliente_enviado" => $codigo_cliente];
        // $myClient = $this->Make()->get(self::GET_MY_CLIENT . "/$codigo_cliente");
    }
}
