<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;



class TaskRequest extends FormRequest
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
            'description' => 'required',
            'priority' => 'required',
            'end_date' => 'required',
            'law_suit_case_id' => 'required',
            'owner_user_id' => 'required',
            'company_id' => 'required',
            'employees_id' => 'required',
        ];
    }

    public function messages(): array{
        return [
            'description' => 'O campo Descrição é de preenchimento obrigatório!',
            'priority' => 'O campo Prioridade é de preenchimento obrigatório!',
            'end_date' => 'O campo Data é de preenchimento obrigatório!',
            'law_suit_case_id' => 'O campo Processo ou Caso é de preenchimento obrigatório!',
            'owner_user_id' => 'O campo Autor é de preenchimento obrigatório!',
            'company_id' => 'O campo Escritório é de preenchimento obrigatório!',
            'employees_id' => 'O campo Responsável (eis) é de preenchimento obrigatório!',
        ] ;
    }
}
