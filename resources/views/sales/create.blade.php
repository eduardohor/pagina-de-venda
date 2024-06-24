<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Nova Venda') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                        <form>
                            <div class="row mb-3">
                                <label for="customer" class="mb-1">Cliente</label>
                                <div class="col-sm-10">
                                    <div class="input-group">
                                        <select class="form-select" name="customer_id">
                                            <option selected>Selecione um cliente</option>
                                            @foreach ($customers as $customer)
                                                <option value="{{ $customer->id }}">{{ $customer->id }} - {{ $customer->name }}</option>
                                            @endforeach
                                        </select>
                                        <button class="btn btn-outline-primary" type="button" data-bs-toggle="modal" data-bs-target="#addCustomerModal">
                                            Adicionar
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal para adicionar novo cliente -->
    <div class="modal fade" id="addCustomerModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="addCustomerModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addCustomerModalLabel">Adicionar Novo Cliente</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <form method="POST" action="{{ route('customer.store') }}">
                        @csrf
                        <div class="mb-3">
                            <label for="newCustomerName" class="form-label">Nome <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror"  name="name" value="{{ old('name') }}">
                            @error('name')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="newCustomerEmail" class="form-label">Email <span class="text-danger">*</span></label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror"  name="email" value="{{ old('email') }}">
                            @error('email')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="newCustomerEmail" class="form-label">CPF <span class="text-danger">*</span></label>
                            <input type="text" class="form-control cpf-mask @error('cpf') is-invalid @enderror" name="cpf" value="{{ old('cpf') }}">
                            @error('cpf')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-primary">Adicionar Cliente</button>
                    </form>
                </div>
            </div>
        </div>
    </div>


    @section('script')

    <script>
        $(document).ready(function () {
            $('.cpf-mask').mask('000.000.000-00');

            @if(session('success'))
            console.log('success')
                toastr.success('{{ session('success') }}');
            @endif

            @if($errors->any())
                $('#addCustomerModal').modal('show');
            @endif
        });

    </script>

    @endsection


</x-app-layout>
