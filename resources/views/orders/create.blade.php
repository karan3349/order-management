<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create Order') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="col-md-10">
                <div class="card p-4">
                    <h2>Create Order</h2>

                    <!-- @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif -->

                    <form action="{{ route('orders.store') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label for="customer_id" class="form-label">Customer</label>
                            <select name="customer_id" id="customer_id"
                                class="form-control @error('customer_id') is-invalid @enderror">
                                <option value="">Select Customer</option>
                                @foreach($customers as $customer)
                                <option value="{{ $customer->id }}"
                                    {{ old('customer_id') == $customer->id ? 'selected' : '' }}>
                                    {{ $customer->name }}
                                </option>
                                @endforeach
                            </select>
                            @error('customer_id')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <hr>

                        <table class="table" id="product-table">
                            <thead>
                                <tr>
                                    <th>Product</th>
                                    <th>Quantity</th>
                                    <th>Price</th>
                                    <th>Total</th>
                                    <th><button type="button" class="btn btn-success" id="addRow">Add Row</button></th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $oldItems = old('order_items', [['product_id' => '', 'quantity' => 1, 'price' =>
                                '', 'total' => '']]); @endphp
                                @foreach ($oldItems as $index => $item)
                                <tr>
                                    <td>
                                        <select name="order_items[{{ $index }}][product_id]"
                                            class="form-control product-select @error(" order_items.$index.product_id")
                                            is-invalid @enderror">
                                            <option value="">Select Product</option>
                                            @foreach ($products as $product)
                                            <option value="{{ $product->id }}" data-price="{{ $product->price }}"
                                                {{ $item['product_id'] == $product->id ? 'selected' : '' }}>
                                                {{ $product->name }}
                                            </option>
                                            @endforeach
                                        </select>
                                        @error("order_items.$index.product_id")
                                        <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </td>
                                    <td>
                                        <input type="number" name="order_items[{{ $index }}][quantity]"
                                            class="form-control quantity @error(" order_items.$index.quantity")
                                            is-invalid @enderror" value="{{ $item['quantity'] }}">
                                        @error("order_items.$index.quantity")
                                        <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </td>
                                    <td>
                                        <input type="number" name="order_items[{{ $index }}][price]"
                                            class="form-control price" value="{{ $item['price'] }}" readonly>
                                    </td>
                                    <td>
                                        <input type="number" name="order_items[{{ $index }}][total]"
                                            class="form-control total" value="{{ $item['total'] }}" readonly>
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-danger removeRow">Remove</button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <hr>
                        <h5>Grand Total: ₹ <span id="grandTotal">{{ old('grand_total', 0) }}</span></h5>

                        <div class="mt-6">
                            <button type="submit"
                                class="btn btn-primary bg-gray-600 hover:bg-gray-700 font-bold py-2 px-4 rounded">
                                Save
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @section('scripts')
    <script>
       let rowCount = {{ count(old('order_items', [0])) }};

    document.getElementById('addRow').addEventListener('click', function() {
        let table = document.querySelector('#product-table tbody');
        let newRow = table.rows[0].cloneNode(true);

        newRow.querySelectorAll('select, input').forEach(el => {
            if (el.name) el.name = el.name.replace(/\d+/, rowCount);
            if (el.tagName === 'INPUT') el.value = '';
            if (el.classList.contains('price') || el.classList.contains('total')) {
                el.setAttribute('readonly', true);
            }
        });

        table.appendChild(newRow);
        rowCount++;
    });

    document.querySelector('#product-table').addEventListener('change', function(e) {
        let row = e.target.closest('tr');
        if (e.target.classList.contains('product-select')) {
            let productId = e.target.value;
            let priceInput = row.querySelector('.price');
            let quantityInput = row.querySelector('.quantity');
            let totalInput = row.querySelector('.total');

            if (productId) {
                fetch(`/products/${productId}/price`)
                    .then(res => res.json())
                    .then(data => {
                        let price = parseFloat(data.price || 0);
                        let quantity = parseInt(quantityInput.value || 0);
                        priceInput.value = price.toFixed(2);
                        totalInput.value = (quantity * price).toFixed(2);
                        calculateGrandTotal();
                    });
            } else {
                priceInput.value = '';
                totalInput.value = '';
                calculateGrandTotal();
            }
        }
    });

    document.querySelector('#product-table').addEventListener('input', function(e) {
        let row = e.target.closest('tr');
        if (e.target.classList.contains('quantity')) {
            let quantity = parseInt(e.target.value || 0);
            let price = parseFloat(row.querySelector('.price').value || 0);
            row.querySelector('.total').value = (quantity * price).toFixed(2);
            calculateGrandTotal();
        }
    });

    document.querySelector('#product-table').addEventListener('click', function(e) {
        if (e.target.classList.contains('removeRow')) {
            let row = e.target.closest('tr');
            let table = document.querySelector('#product-table tbody');
            if (table.rows.length > 1) {
                row.remove();
                calculateGrandTotal();
            }
        }
    });

    function calculateGrandTotal() {
        let grandTotal = 0;
        document.querySelectorAll('.total').forEach(el => {
            grandTotal += parseFloat(el.value || 0);
        });
        document.getElementById('grandTotal').textContent = grandTotal.toFixed(2);
    }
    </script>
    @endsection
</x-app-layout>
