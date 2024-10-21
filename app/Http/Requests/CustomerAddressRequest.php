<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CustomerAddressRequest extends FormRequest
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
            /**Endereço do cliente */
            'zipcode' => 'required',
            'street' => 'required',
            'num' => 'required',
            'neighborhood' => 'required',
            'city' => 'required',
            'state' => 'required',
            //'customer_id' => 'required',
        ];
    }

    public function messages(): array{
        return [           
            /**Endereço */
            'zipcode.required' => 'Campo CEP é obrigatório!',
            'street.required' => 'Campo Rua é obrigatório!',
            'num.required' => 'Campo Número é obrigatório!',
            'neighborhood.required' => 'Campo Bairro é obrigatório!',
            'city.required' => 'Campo Cidade é obrigatório!',
            'state.required' => 'Campo Estado é obrigatório!',
            //'customer_id.required' => 'Informe um cliente para esse endereço!',
        ] ;
    }
}
