<?php

namespace App\Http\Requests\WayApp\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Hash;

class UpdateUser extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            "userId" => "required|exists:users,id",
            "IdType" => "in:dui,nit,passport",
            "personId" => "required_with:IdType|string", // si envias IdType eso sera requerido
            "departament" => "exists:departamentos,coddpto",
            "city" => "exists:municipios,codciud",
            "address" => "string",
            "phoneNumber" => "string",
            //se puede cambiar el email, claro el usuario ya no podra entrar con el email anterior.
            //Editar esto no cierra la session
            "email" => "email|unique:users,email",
            "password" => "string", // enviar esto para cambiar de contraseña
            "status" => "boolean" //enviar esto es para dar de baja
        ];
    }
    public function prepareForValidation()
    {
        $this->merge(
            [
                "password" => Hash::make($this->password)
            ]
        );
    }
}
