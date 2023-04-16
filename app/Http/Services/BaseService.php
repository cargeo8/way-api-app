<?php


namespace App\Http\Services;

use App\Exceptions\BaseServiceException;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Http;

class BaseService
{
    private const LOGIN_PATH = "/api/auth/login";
    public function Make(): ?PendingRequest
    {
        if (!env("WAY_API_POS_HOST")) throw new BaseServiceException("WAY_API_POS_HOST is missed!");

        return Http::withToken($this->getToken())
            ->baseUrl(env("WAY_API_POS_HOST"));
    }
    private function getToken(): string
    {
        if (!env("WAY_API_POS_AUTH_TOKEN")) throw new BaseServiceException("WAY_API_POS_AUTH_TOKEN is missed!");

        $response =  Http::post(env("WAY_API_POS_HOST") . self::LOGIN_PATH, [
            "email" => env("WAY_API_POS_AUTH_USER"),
            "password" => env("WAY_API_POS_AUTH_PASSWORD"),
            "grant_type" => "password",
            "client_id" => "2",
            "client_secret" => env("WAY_API_POS_AUTH_TOKEN"),
        ]);
        return $response["token"];
    }
}
