<?php

namespace App\Http\Controllers;

use App\Models\Departamento;
use App\Models\Municipio;
use Illuminate\Http\Request;

class DepartamentosMunicipiosController extends Controller
{
    public function GetDepartamentos()
    {
        return Departamento::all();
    }
    public function GetMunicipioByCodDpto(string $coddpto)
    {
        $departamento = Departamento::where("coddpto", $coddpto)->first();;
        return Municipio::where('departamento_id', $departamento->id)->get();
    }
}
