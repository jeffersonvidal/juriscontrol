<?php

namespace App\Http\Requests;

use Auth;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileRequest extends FormRequest
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
        return [
            'name' => 'required',
            //'email' => 'required|email|unique:users,email' . ($userId ? $userId->id : null),
            // 'email' => [
            //     'required',
            //     'email',
            //     Rule::unique('users')->ignore(Auth::id()),
            // ],
            'cpf' => 'required',
            'company_id' => 'required',
            'phone' => 'required',
            'birthday' => 'required',
            'user_profile_id' => 'required',
        ];
    }

    public function messages(): array{
        return [
            'name.required' => 'Campo Nome é obrigatório!',
            'cpf.required' => 'Campo CPF é obrigatório!',
            'company_id.required' => 'Campo Empresa é obrigatório!',
            'user_profile_id.required' => 'Campo Perfil é obrigatório!',
            'phone.required' => 'Campo Telefone é obrigatório!',
            'birthday.required' => 'Campo Data de Nascimento é obrigatório!',
            'user_profile_id.required' => 'Informe o perfil do usuário!',
        ] ;
    }
}
