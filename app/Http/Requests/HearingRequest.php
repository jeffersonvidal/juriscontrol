<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class HearingRequest extends FormRequest
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
            'object' => 'required',
            'responsible' => 'required',
            'status' => 'required',
            'date_happen' => 'required',
            'time_happen' => 'required',
            'external_office_id' => 'required',
            'client' => 'required',
            'local' => 'required',
            'type' => 'required',
            'modality' => 'required',
            'amount' => 'required',
            'company_id' => 'required',
            'user_id' => 'required',
        ];
    }


    public function messages(): array{
        return [
            'object' => 'O campo Objeto é de preenchimento obrigatório!',
            'responsible' => 'O campo Responsável é de preenchimento obrigatório!',
            'status' => 'O campo Status é de preenchimento obrigatório!',
            'date_happen' => 'Informe quando acontecerá o Objeto!',
            'external_office_id' => 'Informe de qual escritório é o objeto!',
            'time_happen' => 'Informe o horário de acontecimento do objeto!',
            'client' => 'Informe o nome do cliente',
            'local' => 'Informe o Local onde acontecerá o objeto',
            'type' => 'O campo Tipo é de preenchimento obrigatório!',
            'modality' => 'O campo Modalidade é de preenchimento obrigatório!',
            'amount' => 'O campo Valor é de preenchimento obrigatório!',
            'company_id' => 'O campo Escritório Logado é de preenchimento obrigatório!',
            'user_id' => 'Informe quem está cadastrando esse registro!',
        ] ;
    }
}
