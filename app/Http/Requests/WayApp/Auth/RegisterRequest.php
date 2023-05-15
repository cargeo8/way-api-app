<?php

namespace App\Http\Requests\WayApp\Auth;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
            "names" => "required",
            "surnames" => "required",
            "IdType" => "required|in:dui,nit,passport",
            "personId" => "required",
            "birthDate" => "required|date",
            "departament" => "required|exists:departamentos,coddpto",
            "city" => "required|exists:municipios,codciud",
            "address" => "required",
            "phoneNumber" => "required",
            "email" => "required|email|unique:users,email",
            "password" => "required"
        ];
    }
}
