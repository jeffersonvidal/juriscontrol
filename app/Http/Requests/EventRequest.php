<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EventRequest extends FormRequest
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
            'description' => 'required',
            'start' => 'required',
            'end' => 'required',
            'status' => 'required',
            'eventId' => 'required',
            'company_id' => 'required',
        ];
    }

    public function messages(): array{
        return [
            'title.required' => 'Campo Título é obrigatório!',
            'description.required' => 'Campo Descrição é obrigatório!',
            'start.required' => 'Informe o início do evento!',
            'end.required' => 'Quando o evento terminará?',
            'status.required' => 'Informe o Status do evento!',
            'eventId.required' => 'Informe o ID do evento!',
            'company_id.required' => 'Campo Escritório é obrigatório!',
        ] ;
    }
}
