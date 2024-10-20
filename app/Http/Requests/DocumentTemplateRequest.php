<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DocumentTemplateRequest extends FormRequest
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
            'title' => 'required',
            'content' => 'required',
            'type' => 'required',
            'area' => 'required',
            'author_id' => 'required',
            'company_id' => 'required',
        ];
    }

    public function messages(): array{
        return [
            'title.required' => 'Campo Título é obrigatório!',
            'content.required' => 'Campo Conteúdo é obrigatório!',
            'type.required' => 'Campo Tipo é obrigatório!',
            'area.required' => 'Campo Área é obrigatório!',
            'author_id.required' => 'Informe quem está cadastrando esse registro!',
            'company_id.required' => 'Esse documento pertence a qual escritório?',
        ] ;
    }
}
