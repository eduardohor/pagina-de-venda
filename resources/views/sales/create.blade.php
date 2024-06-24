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
                            <h4 class="fs-4 fw-bold mb-3">Dados Iniciais</h4>
                            <div class="row mb-3">
                                <label for="customer" class="mb-1">Cliente</label>
                                <div class="col-sm-10">
                                    <div class="input-group">
                                        <select class="form-select" name="customer_id" id="customerSelect">
                                            <option selected>Selecione um cliente</option>
                                            @foreach ($customers as $customer)
                                                <option value="{{ $customer->id }}">{{ $customer->id }} - {{ $customer->name }}</option>
                                            @endforeach
                                        </select>
                                        <button class="btn btn-secondary" type="button" data-bs-toggle="modal" data-bs-target="#addCustomerModal">
                                            Cadastrar
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <div id="customer-info" class="card d-none mb-3 w-75">
                                <div class="card-body">
                                    <h4 class="fw-bold fs-5 mb-3">Cliente Selecionado</h4>
                                    <p class="card-text" id="customer-name"></p>
                                    <p class="card-text" id="customer-email"></p>
                                    <p class="card-text" id="customer-cpf"></p>
                                </div>
                            </div>

                            <h4 class="fs-4 fw-bold mt-5 mb-3">Itens</h4>
                            <div id="items-container">
                                <div class="row mb-3 item-row">
                                    <div class="col-sm-4">
                                        <div class="input-group">
                                            <select class="form-select" name="product_id" id=productselect>
                                                <option selected>Selecione um Produto</option>
                                                @foreach ($products as $product)
                                                    <option value="{{ $product->id }}">{{ $product->name }} | R$ {{ number_format($product->price, 2, ',', '.') }}</option>
                                                @endforeach
                                            </select>
                                            <button class="btn btn-secondary" type="button" data-bs-toggle="modal" data-bs-target="#addProductModal">
                                                Cadastrar
                                            </button>
                                        </div>
                                    </div>
                                    <div class="col-sm-2">
                                        <input type="text" class="form-control quantity" name="quantity" placeholder="Quantidade">
                                    </div>
                                    <div class="col-sm-2">
                                        <input type="text" class="form-control" name="unitary_value" id="unitary_value" placeholder="Valor Unitário" readonly>
                                    </div>
                                    <div class="col-sm-2">
                                        <input type="text" class="form-control" name="subtotal" id="subtotal" placeholder="Subtotal" readonly>
                                    </div>
                                    <div class="col-sm-1">
                                        <button type="button" class="btn btn-secondary" id="addItemBtn">Adicionar</button>
                                    </div>
                                </div>
                            </div>

                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Item</th>
                                        <th>Cód. Prod.</th>
                                        <th>Nome</th>
                                        <th>Quantidade</th>
                                        <th>Valor Unitário</th>
                                        <th>Subtotal</th>
                                        <th>Ações</th>
                                    </tr>
                                </thead>
                                <tbody id="itemsTableBody">

                                </tbody>
                            </table>

                            <h4 class="fs-4 fw-bold mt-5 mb-3">Pagamento</h4>
                            <div class="row mb-3">
                                <label for="installments" class="mb-1">Quantidade de Parcelas</label>
                                <div class="col-sm-5">
                                    <div class="input-group">
                                        <input type="number" class="form-control" id="installmentsCount">
                                        <button class="btn btn-secondary" type="button" id="generateInstallmentsBtn">
                                            Gerar Parcelas
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <div id="installmentsContainer" class="d-none">
                                <h5 class="fs-5 fw-bold mt-5 mb-3">Parcelas Geradas</h5>
                                <div id="installmentsInputs"></div>
                            </div>

                            <h5 class="my-4 fs-5 fw-bold">Valor Total: <span id="totalValue"></span></h5>

                            <button type="submit" class="btn btn-dark mt-3" disabled>Salvar Venda</button>

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
                    <h5 class="modal-title" id="addCustomerModalLabel">Cadastrar Novo Cliente</h5>
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
                        <button type="submit" class="btn btn-secondary">Cadastrar Cliente</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal para adicionar novo produto -->
    <div class="modal fade" id="addProductModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="addProductModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addProductModalLabel">Cadastrar Novo Produto</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <form method="POST" action="{{ route('product.store') }}">
                        @csrf
                        <div class="mb-3">
                            <label for="newCustomerName" class="form-label">Nome <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror"  name="name" value="{{ old('name') }}">
                            @error('name')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="newCustomerEmail" class="form-label">Preço <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('price') is-invalid @enderror" id="product_price" name="price" value="{{ old('price') }}">
                            @error('price')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-secondary">Cadastrar Produto</button>
                    </form>
                </div>
            </div>
        </div>
    </div>


    @section('script')

    <script>
        $(document).ready(function () {
            //mascaras
            $('.cpf-mask').mask('000.000.000-00');
            $('#product_price').mask('000.000.000,00', { reverse: true });
            $('#unitary_value').mask('000.000.000.00', { reverse: true });
            $('#installmentsInputs').on('input', 'input[type=text]', function () {
                $(this).mask('###.##0.00', { reverse: true });
            });

            $('.quantity').on('input', function() {
                this.value = this.value.replace(/[^0-9]/g, '');
            });

            //mensagem
            @if(session('success'))
                toastr.success('{{ session('success') }}');
            @endif

            //erros
            @if(session('error-modal') === 'customer' && $errors->any())
                $('#addCustomerModal').modal('show');
            @endif

            @if(session('error-modal') === 'product' && $errors->any())
                $('#addProductModal').modal('show');
            @endif

        });

        //clientes

        var customers = @json($customers);

        $('#customerSelect').on('change', function() {
            var customerId = $(this).val();
            var customer = customers.find(c => c.id == customerId);

            if (customer) {
                $('#customer-info').removeClass('d-none');
                $('#customer-name').text('Nome: ' + customer.name);
                $('#customer-email').text('Email: ' + customer.email);
                $('#customer-cpf').text('CPF: ' + customer.cpf);
            } else {
                $('#customer-info').addClass('d-none');
            }
        });

        //produtos

        var products = @json($products);

        $('#productselect').on('change', function() {
            var productId = $(this).val();
            var product = products.find(c => c.id == productId);

            if (product) {
                $('#unitary_value').val(product.price);
                $('.quantity').val(1);
                calculateSubtotal();

            }
        });

        // Calcular subtotal
        function calculateSubtotal() {
            var quantity = $('.quantity').val();
            var unitaryValue = parseFloat($('#unitary_value').val());

            if (!isNaN(quantity) && !isNaN(unitaryValue)) {
                var subtotal = quantity * unitaryValue;
                $('#subtotal').val(subtotal.toFixed(2));
            } else {
                $('#subtotal').val('');
            }
        }


        $('.quantity').on('input', calculateSubtotal);
        $('#unitary_value').on('input', calculateSubtotal);


        //Adicionar item
        $('#addItemBtn').on('click', function () {
            var productId = $('#productselect').val();
            var productName = $('#productselect option:selected').text().split(' | ')[0];
            var quantity = $('.quantity').val();
            var unitaryValue = $('#unitary_value').val();
            var subtotal = $('#subtotal').val()

            if (isNaN(quantity) || isNaN(unitaryValue) || quantity <= 0 || unitaryValue <= 0) {
                alert('Por favor, preencha a quantidade e o valor unitário corretamente.');
                return;
            }

            var row = `<tr>
                            <td>${$('#itemsTableBody tr').length + 1}</td>
                            <td>${productId}</td>
                            <td>${productName}</td>
                            <td>${quantity}</td>
                            <td>R$ ${unitaryValue}</td>
                            <td>R$ ${subtotal}</td>
                            <td>
                                <button type="button" class="btn btn-danger btn-sm delete-item">Excluir</button>
                            </td>
                        </tr>`;

            $('#itemsTableBody').append(row);

            calculateTotalValue();

            $('.quantity').val('');
            $('#unitary_value').val('');
            $('#subtotal').val('');
            $('#productselect').prop('selectedIndex', 0);
            resetInstallments();
        });

        //Remover Item
        $('#itemsTableBody').on('click', '.delete-item', function () {
            $(this).closest('tr').remove();
            calculateTotalValue();
            resetInstallments();
        });

        //Calcular valor total
        function calculateTotalValue() {
            var total = 0;

            $('#itemsTableBody tr').each(function () {
                var subtotal = parseFloat($(this).find('td:nth-child(6)').text().replace('R$ ', ''));
                total += subtotal;
            });

            var formattedTotal = total.toFixed(2);

            $('#totalValue').text('R$ ' + formattedTotal);
        }


        // Resetar Parcelas
        function resetInstallments() {
            $('#installmentsInputs').empty();
            $('#installmentsContainer').addClass('d-none');
        }


        $('#generateInstallmentsBtn').on('click', function() {
            var installmentsCount = $('#installmentsCount').val();
            var totalValue = parseFloat($('#totalValue').text().replace('R$ ', '').replace(',', '.'));

            if (installmentsCount <= 0) {
                alert('A quantidade de parcelas deve ser maior que zero.');
                return;
            }

            if (totalValue <= 0 || isNaN(totalValue)) {
                alert('Adicione itens na venda.');
                return;
            }

            $('#installmentsInputs').empty();
            $('#installmentsContainer').removeClass('d-none');

            // Calcula o valor inicial de cada parcela
            var installmentValue = totalValue / installmentsCount;

            // Inicializa data atual para preenchimento das datas das parcelas
            var currentDate = new Date();
            var currentDay = currentDate.getDate();
            var currentMonth = currentDate.getMonth() + 1;
            var currentYear = currentDate.getFullYear();

            // Itera sobre o número de parcelas para criar os inputs das parcelas
            for (var i = 0; i < installmentsCount; i++) {
                var formattedDate = currentYear + '-' + ('0' + currentMonth).slice(-2) + '-' + ('0' + currentDay).slice(-2);

                var input = `
                    <div class="row mb-3">
                        <div class="col-sm-2">
                            <label class="form-label">Parcela ${i + 1}</label>
                            <input type="date" class="form-control installment-date" value="${formattedDate}">
                        </div>
                        <div class="col-sm-3">
                            <label class="form-label">Valor</label>
                            <input type="text" class="form-control installment-value" value="R$ ${installmentValue.toFixed(2).replace('.', ',')}">
                        </div>
                        <div class="col-sm-5">
                            <label class="form-label">Forma de Pagamento</label>
                            <select class="form-select installment-payment-method" name="payment_method_${i}" id="payment_method_${i}">
                                <option value="Dinheiro">Dinheiro</option>
                                <option value="Cartão de Crédito">Cartão de Crédito</option>
                            </select>
                        </div>
                    </div>
                `;

                currentMonth++;

                $('#installmentsInputs').append(input);
            }

            // Adiciona evento de input para recalcular as parcelas ao alterar valor de uma parcela
            $('#installmentsInputs').on('input', '.installment-value', function () {
                var editedIndex = $(this).closest('.row').index(); // Índice da parcela editada
                var editedValue = parseFloat($(this).val().replace('R$ ', '').replace(',', '.')) || 0; // Valor da parcela editada
                var currentTotal = 0;

                // Calcula o valor total das demais parcelas já preenchidas
                $('#installmentsInputs').find('.installment-value').not(this).each(function () {
                    var value = parseFloat($(this).val().replace('R$ ', '').replace(',', '.')) || 0;
                    currentTotal += value;
                });

                // Calcula o novo valor para distribuir entre as demais parcelas
                var remainingValue = totalValue - editedValue; // Valor restante após a edição da parcela
                var numInstallments = installmentsCount; // Número total de parcelas

                // Distribui o valor restante igualmente entre as demais parcelas
                var newInstallmentValue = remainingValue / (numInstallments - 1);

                // Atualiza os valores das demais parcelas
                $('#installmentsInputs').find('.installment-value').not(this).each(function (index) {
                    var newValue = (index == editedIndex) ? editedValue : newInstallmentValue;
                    $(this).val('R$ ' + newValue.toFixed(2).replace('.', ','));
                });
            });
        });



    </script>

    @endsection

</x-app-layout>
