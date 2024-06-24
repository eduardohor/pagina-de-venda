<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CustomerRequest extends FormRequest
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
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:customers,email',
            'cpf' => 'required|string',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'O nome do cliente é obrigatório.',
            'name.string' => 'O nome do cliente deve ser um texto.',
            'name.max' => 'O nome do cliente não pode ter mais que 255 caracteres.',
            'email.required' => 'O email do cliente é obrigatório.',
            'email.email' => 'O email deve ser um endereço de email válido.',
            'email.unique' => 'O email já está em uso.',
            'cpf.required' => 'O CPF do cliente é obrigatório.',
            'cpf.string' => 'O CPF do cliente deve ser uma string.'
        ];
    }

}
