<?php

namespace App\Http\Requests\Cliente;

use Illuminate\Foundation\Http\FormRequest;

class GetMyClientRequest extends FormRequest
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
            "codigo_cliente" => "required"
        ];
    }
    public function prepareForValidation()
    {
        $this->merge([
            "codigo_cliente" => $this->query("codigo_cliente")
        ]);
    }
}
