<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ExternalPetitionRequest extends FormRequest
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
            'external_office_id' => 'required',
            'wallet_id' => 'required',
            'responsible' => 'required',
            'customer_name' => 'required',
            'delivery_date' => 'required',
            'type' => 'required',
            'amount' => 'integer',
            'user_id' => 'required',
            'company_id' => 'required',
        ];
    }

    public function messages(): array{
        return [
            'external_office_id.required' => 'Informe o Escritório Parceiro proprietário dessa petição!',
            'wallet_id.required' => 'Informe a carteira para esse lançamento!',
            'responsible.required' => 'Informe o responsável por essa petição!',
            'customer_name.required' => 'Informe o Nome do cliente!',
            'delivery_date.required' => 'Informe a data de entrega da petição!',
            'type.required' => 'Informe o tipo da petição!',
            'amount.required' => 'Informe o preço cobrado pela petição!',
            'user_id.required' => 'Informe o usuário que está registrando esse lançamento!',
            'company_id.required' => 'Campo Escritório Logado é obrigatório!',
        ] ;
    }
}
