<?php

namespace App\Http\Services;

class ClienteService extends BaseService
{
    public const GET_MY_CLIENT = "/api/Cliente";
    public const SEARCH_CLIENT_BY_PERSON_ID = "/api/way-app/cliente/searchByPersonId";

    public function GetMyClient(string $codigo_cliente)
    {
        return ["codigo_cliente_enviado" => $codigo_cliente];
        // $myClient = $this->Make()->get(self::GET_MY_CLIENT . "/$codigo_cliente");
    }
    public function SearchClientByPersonID(string $id_type, string $person_id)
    {
        return $this->Make()->get(self::SEARCH_CLIENT_BY_PERSON_ID .
            "?id_type=$id_type&person_id=$person_id");
    }
}
