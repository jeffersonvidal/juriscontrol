<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SelfCustomerRequest extends FormRequest
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
    public function rules()
    {
        //$userId = $this->route('user');
        /**required|unique:posts|max:255 */

        return [
            /**Dados do cliente */
            'name' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
            'rg' => 'required',
            'rg_expedidor' => 'required',
            'cpf' => 'required',
            'marital_status' => 'required',
            'nationality' => 'required',
            'profession' => 'required',
            'birthday' => 'required',
            'company_id' => 'required',
            'met_us' => 'required',

            /**Endereço do cliente */
            'zipcode' => 'required',
            'street' => 'required',
            'num' => 'required',
            'neighborhood' => 'required',
            'city' => 'required',
            'state' => 'required',
            //'customer_id' => 'required',
        ];
    }

    public function messages(): array{
        return [
            /**Dados Pessoais */
            'name.required' => 'Campo Nome é obrigatório!',
            'email.required' => 'Campo email é obrigatório!',
            'email.email' => 'Informe um email válido!',
            'phone.required' => 'Campo telefone é obrigatório!',
            'rg.required' => 'Campo RG é obrigatório!',
            'rg_expedidor.required' => 'Campo Órgão Expedidor do RG é obrigatório!',
            'cpf.required' => 'Campo CPF é obrigatório!',
            'marital_status.required' => 'Campo Estado Civil é obrigatório!',
            'nationality.required' => 'Campo Nacionalidade é obrigatório!',
            'profession.required' => 'Campo Profissão é obrigatório!',
            'birthday.required' => 'Campo Data de Nascimento é obrigatório!',
            'company_id.required' => 'Campo Escritório é obrigatório!',
            'met_us.required' => 'Informe como conheceu o nosso escritório!',
            
            /**Endereço */
            'zipcode.required' => 'Campo CEP é obrigatório!',
            'street.required' => 'Campo Rua é obrigatório!',
            'num.required' => 'Campo Número é obrigatório!',
            'neighborhood.required' => 'Campo Bairro é obrigatório!',
            'city.required' => 'Campo Cidade é obrigatório!',
            'state.required' => 'Campo Estado é obrigatório!',
            //'customer_id.required' => 'Informe um cliente para esse endereço!',
        ] ;
    }
}
