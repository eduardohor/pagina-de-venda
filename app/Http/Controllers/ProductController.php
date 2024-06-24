<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    protected $product;

    public function __construct(Product $product)
    {
        $this->product = $product;
    }

    public function store(Request $request): RedirectResponse
    {
        $cleanedPrice = str_replace(',', '.', $request->price);

        $validator = Validator::make([
            'name' => $request->name,
            'price' => $cleanedPrice,
        ],  [
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
        ], [
            'name.required' => 'O nome do produto é obrigatório.',
            'name.string' => 'O nome do produto deve ser um texto.',
            'name.max' => 'O nome do produto não pode ter mais que 255 caracteres.',
            'price.required' => 'O preço do produto é obrigatório.',
            'price.numeric' => 'O preço do produto deve ser um valor numérico.',
            'price.min' => 'O preço do produto não pode ser menor que zero.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                             ->withErrors($validator)
                             ->withInput()
                             ->with('error-modal', 'product');
        }

        $this->product->create([
            'name' => $request->name,
            'price' => $cleanedPrice,
        ]);

        return redirect()->route('sales.create')->with('success', 'Produto cadastrado com sucesso!');
    }
}
