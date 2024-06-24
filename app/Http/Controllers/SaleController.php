<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class SaleController extends Controller
{
    protected $sale;

    public function __construct(Sale $sale)
    {
        $this->sale = $sale;
    }

    public function create(): View
    {
        return view('sales.create');
    }
}

