<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Control extends Model
{
    use HasFactory;
    public static function GetWayApiPosAccessToken(): ?string
    {
        return Control::first()?->way_api_pos_access_token;
    }
    public static function SaveWayApiPosAccessToken(string $access_token): Control
    {
        $control = Control::find(1);
        if (!$control) $control = new Control();
        $control->way_api_pos_access_token = $access_token;
        $control->save();
        return $control;
    }
}
