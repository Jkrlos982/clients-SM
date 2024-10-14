<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ClientPutRequest extends FormRequest
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
    public function rules(): array
    {
        $clientId = $this->route('client');

        return [
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('clients')->ignore($clientId),
            ],
            'phone' => ['required', 'regex:/^(\+\d{1,3}[-\s]?(\(\d{3}\)|\d{3})[-\s]?\d{3}[-]?\d{4}|\d{10})$/'],
            'address' => 'required|string',
        ];
    }

    /**
     * Get custom error messages for validator errors.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'name.required' => 'El nombre es obligatorio.',
            'email.required' => 'El correo electrónico es obligatorio.',
            'email.email' => 'Por favor, proporciona un correo electrónico válido.',
            'email.unique' => 'Este correo electrónico ya está registrado.',
            'phone.required' => 'El número de teléfono es obligatorio.',
            'phone.regex' => 'El número de teléfono debe estar en uno de los formatos: +(123) 456-7890, +1-757-586-4705 o 3004445909.',
            'address.required' => 'La dirección es obligatoria.',
        ];
    }
}
