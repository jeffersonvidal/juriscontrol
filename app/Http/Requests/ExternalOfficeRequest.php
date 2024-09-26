<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ExternalOfficeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function rules()
    {
        //$userId = $this->route('user');
        /**required|unique:posts|max:255 */
        return [
            'name' => 'required',
            'responsible' => 'required',
            'phone' => 'required',
            'email' => 'required',
            'cnpj' => 'required',
            'company_id' => 'required',
        ];
    }

    public function messages(): array{
        return [
            'name.required' => 'Campo Nome é obrigatório!',
            'responsible.required' => 'Campo Responsável é obrigatório!',
            'phone.required' => 'Campo Telefone é obrigatório!',
            'email.required' => 'Campo Email é obrigatório!',
            'cnpj.required' => 'Campo CNPJ é obrigatório!',
            'company_id.required' => 'Campo Escritório é obrigatório!',
        ] ;
    }
}
