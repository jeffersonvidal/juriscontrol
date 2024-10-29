<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfilePasswordRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'password' => 'required_if:password,!=,null|min:6',
        ];
    }

    public function messages(): array{
        return [
            'password.required_if' => 'Campo Senha é obrigatório!',
            'password.min' => 'Senha deve ter no mínimo 6 caracteres',
        ] ;
    }
}
