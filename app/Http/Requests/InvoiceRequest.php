<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InvoiceRequest extends FormRequest
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
            'description' => 'required',
            'amount' => 'required',
            'due_at' => 'required',
            'wallet_id' => 'required',
            'invoice_category_id' => 'required',
            'repeat_when' => 'required',
            'enrollments' => 'integer|max:420',
            'type' => 'required',
            'company_id' => 'required',
            'user_id' => 'required',
        ];
    }


    public function messages(): array{
        return [
            'description.required' => 'Campo Descrição é obrigatório!',
            'wallet_id.required' => 'Informe a carteira para esse lançamento!',
            'invoice_category_id.required' => 'Informe a categoria para esse lançamento!',
            'company_id.required' => 'Campo Escritório é obrigatório!',
            'user_id.required' => 'Informe o usuário que está registrando esse lançamento!',
            'type.required' => 'Informe se esse lançamento é de Entrada ou Saída!',
            'amount.required' => 'Insira um valor para esse lançamento!',
            'due_at.required' => 'Informe o vencimento desse lançamento!',
            'repeat_when.required' => 'Informe se o lançamento é parcelado, pagamento único ou fixo!',
            'enrollments.integer' => 'O Parcelas deve ser um número inteiro.',
            'enrollments.max' => 'A quantidade de parcelas não pode ser maior que 420.',
        ] ;
    }
}
