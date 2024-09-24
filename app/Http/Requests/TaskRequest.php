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
            'title' => 'required',
            'description' => 'required',
            'delivery_date' => 'required',
            'end_date' => 'required',
            'responsible_id' => 'required',
            'author_id' => 'required',
            'priority' => 'required',
            'status' => 'required',
            'source' => 'required',
            'company_id' => 'required',
        ];
    }


    public function messages(): array{
        return [
            'title' => 'O campo Título é de preenchimento obrigatório!',
            'description' => 'O campo Descrição é de preenchimento obrigatório!',
            'delivery_date' => 'O campo Responsável (eis) é de preenchimento obrigatório!',
            'end_date' => 'O campo Data Fatal é de preenchimento obrigatório!',
            'responsible_id' => 'O campo Responsável é de preenchimento obrigatório!',
            'author_id' => 'Informe quem está cadastrando essa tarefa!',
            'priority' => 'O campo Prioridade é de preenchimento obrigatório!',
            'status' => 'O campo Status é de preenchimento obrigatório!',
            'source' => 'O campo Origem é de preenchimento obrigatório!',
            'company_id' => 'O campo Escritório é de preenchimento obrigatório!',
        ] ;
    }
}
