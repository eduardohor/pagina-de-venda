<?php

namespace App\Http\Controllers;

use App\Http\Requests\CustomerRequest;
use App\Models\Customer;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CustomerController extends Controller
{
    protected $customer;

    public function __construct(Customer $customer)
    {
        $this->customer = $customer;
    }

    public function store(Request $request): RedirectResponse
    {
        $cpf = preg_replace('/\D/', '', $request->cpf);

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:customers,email',
            'cpf' => 'required|string',
        ], [
            'name.required' => 'O nome do cliente é obrigatório.',
            'name.string' => 'O nome do cliente deve ser um texto.',
            'name.max' => 'O nome do cliente não pode ter mais que 255 caracteres.',
            'email.required' => 'O email do cliente é obrigatório.',
            'email.email' => 'O email deve ser um endereço de email válido.',
            'email.unique' => 'O email já está em uso.',
            'cpf.required' => 'O CPF do cliente é obrigatório.',
            'cpf.string' => 'O CPF do cliente deve ser uma string.'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                             ->withErrors($validator)
                             ->withInput()
                             ->with('error-modal', 'customer');
        }

        $this->customer->create([
            'name' => $request->name,
            'email' => $request->email,
            'cpf' => $cpf,
        ]);

        return redirect()->route('sales.create')->with('success', 'Cliente cadastrado com sucesso!');
    }
}
