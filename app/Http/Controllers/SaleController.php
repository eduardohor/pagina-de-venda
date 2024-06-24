<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Product;
use App\Models\Sale;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class SaleController extends Controller
{
    protected $sale;
    protected $customer;
    protected $product;

    public function __construct(Sale $sale, Customer $customer, Product $product)
    {
        $this->sale = $sale;
        $this->customer = $customer;
        $this->product = $product;

    }

    public function create(): View
    {
        $customers = $this->customer->all();
        $products = $this->product->all();

        return view('sales.create', compact('customers', 'products'));
    }
}

