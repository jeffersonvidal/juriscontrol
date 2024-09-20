<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CompanyRequest extends FormRequest
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
            'fantasy_name' => 'required',
            //'email' => 'required|email|unique:users,email' . ($userId ? $userId->id : null),
            'corporate_reason' => 'required',
            'email' => 'required|email|unique:companies,email',
            'cnpj' => 'required|unique:companies',
            'phone' => 'required_if:password,!=,null|min:6',
            'company_id' => 'required',
            'user_id' => 'required',
            'company_address_id' => 'required',
        ];
    }

    public function messages(): array{
        return [
            'fantasy_name.required' => 'Campo Nome Fantasia é obrigatório!',
            'corporate_reason.required' => 'Campo Razão Social é obrigatório!',
            'email.required' => 'Campo Email é obrigatório!',
            'email.email' => 'Informe um email válido',
            'email.unique' => 'Email já cadastrado',
            'cnpj.required' => 'Campo CNPJ é obrigatório!',
            'cnpj.unique' => 'CNPJ já cadastrado!',
            'phone.required' => 'Campo Telefone é obrigatório!',
            'company_id.required' => 'Campo Empresa é obrigatório!',
            'user_id.required' => 'Campo Usuário Responsável pela empresa é obrigatório!',
            'company_address_id.required' => 'Insira um endereço para a empresa!',
        ] ;
    }
}
