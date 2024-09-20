<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $rules = [
            'name' => 'required',
            //'email' => 'required|email|unique:users,email' . ($userId ? $userId->id : null),
            'email' => 'required|email|unique:users,email',
            'cpf' => 'required',
            'password' => 'required_if:password,!=,null|min:6',
            'company_id' => 'required',
            'phone' => 'required',
            'birthday' => 'required',
            'user_profile_id' => 'required',
        ];

        if($this->method() === 'PUT'){
            $rules['email'] = [
                Rule::unique('users')->ignore($this->id),
            ];
        }

        return $rules;
    }

    public function messages(): array{
        return [
            'name.required' => 'Campo Nome é obrigatório!',
            'email.required' => 'Campo Email é obrigatório!',
            'email.email' => 'Informe um email válido',
            'email.unique' => 'Email já cadastrado',
            'cpf.required' => 'Campo CPF é obrigatório!',
            'password.required_if' => 'Campo Senha é obrigatório!',
            'password.min' => 'Senha deve ter no mínimo 6 caracteres',
            'company_id.required' => 'Campo Empresa é obrigatório!',
            'user_profile_id.required' => 'Campo Perfil é obrigatório!',
            'phone.required' => 'Campo Telefone é obrigatório!',
            'birthday.required' => 'Campo Data de Nascimento é obrigatório!',
            'user_profile_id.required' => 'Informe o perfil do usuário!',
        ] ;
    }
}
