<?php


namespace App\Http\Services;

use App\Exceptions\BaseServiceException;
use App\Models\Control;
use Exception;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Http;

class BaseService
{
    private const LOGIN_PATH = "/oauth/token";
    protected function Make(): ?PendingRequest
    {
        if (!env("WAY_API_POS_HOST")) throw new BaseServiceException("WAY_API_POS_HOST is missed!");

        return Http::withToken($this->getToken())
            ->baseUrl(env("WAY_API_POS_HOST"));
    }
    protected function getToken(): string
    {
        if (!env("WAY_API_POS_AUTH_TOKEN")) throw new BaseServiceException("WAY_API_POS_AUTH_TOKEN is missed!");

        $current_accesss_token = Control::GetWayApiPosAccessToken();
        if ($current_accesss_token) return $current_accesss_token;

        $response =  Http::withHeaders(
            [
                "Content-Type" => "application/json; charset=utf-8",
            ]
        )->post(env("WAY_API_POS_HOST") . self::LOGIN_PATH, [
            "username" => env("WAY_API_POS_AUTH_USER"),
            "password" => env("WAY_API_POS_AUTH_PASSWORD"),
            "grant_type" => "password",
            "client_id" => "2",
            "client_secret" => env("WAY_API_POS_AUTH_TOKEN"),
            "admin_flag" => true
        ]);
        Control::SaveWayApiPosAccessToken($response["access_token"]);
        return $response["access_token"];
    }
}
