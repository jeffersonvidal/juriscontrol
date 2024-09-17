<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LabelRequest extends FormRequest
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
            'name' => 'required',
            'hexa_color_bg' => 'required',
            'hexa_color_font' => 'required',
            'company_id' => 'required',
        ];
    }

    public function messages(): array{
        return [
            'name.required' => 'Campo Nome é obrigatório!',
            'hexa_color_bg.required' => 'Campo Cor de Fundo é obrigatório!',
            'hexa_color_font.required' => 'Campo Cor da Fonte é obrigatório!',
            'company_id.required' => 'Campo Escritório é obrigatório!',
        ] ;
    }
}
