<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Vendas') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Lista de Vendas</h3>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th scope="col">Código</th>
                                            <th scope="col">Cliente</th>
                                            <th scope="col">Data de Registro</th>
                                            <th scope="col">Tipo de Pagamento</th>
                                            <th scope="col">Usuário</th>
                                            <th scope="col">Valor Integral</th>
                                            <th scope="col">Ações</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($sales as $sale)
                                        <tr>
                                            <td>{{ $sale->id }}</td>
                                            <td>{{ $sale->customer->name }}</td>
                                            <td>{{ $sale->created_at->format('d/m/Y H:i:s') }}</td>
                                            <td>{{ $sale->installments->first()->payment->method }}</td>
                                            <td>{{ $sale->user->name }}</td>
                                            <td>R$ {{ number_format($sale->total_amount, 2, ',', '.') }}</td>
                                            <td>
                                                <button type="button" class="btn btn-danger btn-sm delete-item">Excluir</button>
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="7" class="text-center">Nenhuma venda encontrada</td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>

                                <div class="d-flex justify-content-center">
                                    {{ $sales->links() }}
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
