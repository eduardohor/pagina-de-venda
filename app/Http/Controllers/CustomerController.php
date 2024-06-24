<?php

namespace App\Http\Controllers;

use App\Http\Requests\CustomerRequest;
use App\Models\Customer;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    protected $customer;

    public function __construct(Customer $customer)
    {
        $this->customer = $customer;
    }

    public function store(CustomerRequest $request): RedirectResponse
    {
        $cpf = preg_replace('/\D/', '', $request->cpf);

        $this->customer->create([
            'name' => $request->name,
            'email' => $request->email,
            'cpf' => $cpf,
        ]);

        return redirect()->route('sales.create')->with('success', 'Cliente adicionado com sucesso!');
    }
}
