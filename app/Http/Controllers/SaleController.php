<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Installment;
use App\Models\Payment;
use App\Models\Product;
use App\Models\Sale;
use App\Models\SaleItem;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SaleController extends Controller
{
    protected $sale;
    protected $customer;
    protected $product;
    protected $payment;
    protected $installment;
    protected $saleItem;

    public function __construct(Sale $sale, Customer $customer, Product $product, Payment $payment, Installment $installment, SaleItem $saleItem)
    {
        $this->sale = $sale;
        $this->customer = $customer;
        $this->product = $product;
        $this->payment = $payment;
        $this->installment = $installment;
        $this->saleItem = $saleItem;
    }

    public function index()
    {
        $sales = $this->sale->orderByDesc('created_at')->paginate(10);

        return view('sales.index', compact('sales'));

    }

    public function create(): View
    {
        $customers = $this->customer->all();
        $products = $this->product->all();
        $payments = $this->payment->all();

        return view('sales.create', compact('customers', 'products', 'payments'));
    }

    public function store(Request $request): JsonResponse
    {
        DB::beginTransaction();
        try {
            $user = Auth::user();
            $items = $request->items;
            $installments = $request->installments;
            $customer_id = $request->customer_id ?: null;


            $dataSale = [
                'user_id' => $user->id,
                'customer_id' => $customer_id,
                'total_amount' => $request->total_amount
            ];

            $sale = $this->sale->create($dataSale);

            foreach ($items as $item ) {
                $dataSaleItem = [
                    'sale_id' => $sale->id,
                    'product_id' => $item['product_id'],
                    'quantity' => $item['quantity'],
                    'price' => $item['price']
                ];

                $saleItem = $this->saleItem->create($dataSaleItem);
            }


            foreach ($installments as $installment) {
                $dateInstallment = [
                    'payment_id' => $installment['payment_id'],
                    'sale_id' => $sale->id,
                    'installment_number' => $installment['installment_number'],
                    'due_date' => $installment['due_date'],
                    'amount' => $installment['amount']
                ];

                $installmentCreate = $this->installment->create($dateInstallment);
            }

            DB::commit();
            return response()->json(['message' => 'Venda salva com sucesso'], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Erro ao salvar a venda: ' . $e->getMessage()], 500);
        }

    }

    public function destroy($id)
    {
        $sale = $this->sale->find($id);

        if (!$sale) {
            return redirect()->route('sales.index')->with('error', 'Venda não encontrada!');
        }

        $sale->delete();

        return redirect()->route('sales.index')->with('success', 'Venda excluida com sucesso!');
    }
}

