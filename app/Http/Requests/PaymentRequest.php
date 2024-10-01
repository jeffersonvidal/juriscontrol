<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PaymentRequest extends FormRequest
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
            'wallet_id' => 'required',
            'user_id' => 'required',
            'company_id' => 'required',
            'invoice_id' => 'required',
            'method' => 'required',
            'enrollment_of' => 'required',
            'amount_owed' => 'required',
            'amount_paid' => 'required',
            'pay_day' => 'required',
            'amount_remaining' => 'required',
            'status' => 'required',
        ];
    }

    public function messages(): array{
        return [
            'wallet_id.required' => 'Informe em qual carteira será lançado esse pagamento!',
            'user_id.required' => 'Informe o usuário que está executando essa operação!',
            'company_id.required' => 'Qual o escritório dessa conta?',
            'invoice_id.required' => 'Informe a conta a ser paga!',
            'method.required' => 'Qual o método de pagamento utilizado?',
            'enrollment_of.required' => 'Informe o nº da parcela referente ao pagamento!',
            'amount_owed.required' => 'Informe o valor devido!',
            'amount_paid.required' => 'Informe o valor pago!',
            'pay_day.required' => 'Informe o dia em que o pagamento foi realizado!',
            'amount_remaining.required' => 'Informe o valor restante para esse pagamento!',
            'status.required' => 'Informe o Status do pagamento!',
        ] ;
    }
}

//     id, wallet_id, user_id, company_id, invoice_id, customer_id, method, enrollment_of,
// amount_owed, amount_paid, pay_day, amount_remaining, status