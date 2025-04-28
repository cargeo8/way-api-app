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
            "invoice" => "required|numeric",
            "invoiceDate" => "required|date",
            "IdType" => "required|in:DUI,NIT,Pasaporte",
            "personId" => "required",
            "email" => "required|email",
            "password" => "required"
        ];
    }
}
