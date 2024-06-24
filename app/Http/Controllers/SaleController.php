<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Sale;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class SaleController extends Controller
{
    protected $sale;
    protected $customer;

    public function __construct(Sale $sale, Customer $customer)
    {
        $this->sale = $sale;
        $this->customer = $customer;
    }

    public function create(): View
    {
        $customers = $this->customer->all();

        return view('sales.create', compact('customers'));
    }
}

