<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReminderRequest extends FormRequest
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
     */
    public function rules(): array
    {
        return [
            'reminder_date' => 'required|date_format:Y-m-d\TH:i',
            'responsible_id' => 'required',
            'description' => 'required',
            'author_id' => 'required',
        ];
    }

    /**
     * Get the validation messages that apply to the request.
     */
    public function messages(): array
    {
        return [
            'reminder_date.required' => 'A data do lembrete é obrigatória.',
            'reminder_date.date_format' => 'Informe a data e hora do lembrete!',
            'responsible_id.required' => 'Informe para quem será o lembrete!',
            'description.required' => 'A mensagem é obrigatória!',
            'author_id.required' => 'Informe quem está cadastrando esse lembrete!',
        ];
    }
}


