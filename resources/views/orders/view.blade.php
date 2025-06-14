<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Order Details
        </h2>
    </x-slot>

    <div class="py-6 max-w-6xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white shadow-md rounded p-6">
            <h3 class="text-lg font-semibold text-gray-700 mb-4">Customer Information</h3>
            <p><strong>Name:</strong> {{ $order->customer->name }}</p>
            <p><strong>Order Date:</strong> {{ $order->created_at->format('Y-m-d H:i') }}</p>
            <p><strong>Grand Total:</strong> ₹ {{ number_format($order->grand_total, 2) }}</p>
        </div>

        <div class="bg-white shadow-md rounded p-6 mt-6">
            <h3 class="text-lg font-semibold text-gray-700 mb-4">Order Items</h3>
            <table class="min-w-full table-auto border border-gray-200">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-4 py-2 border">#</th>
                        <th class="px-4 py-2 border">Product</th>
                        <th class="px-4 py-2 border">Price</th>
                        <th class="px-4 py-2 border">Quantity</th>
                        <th class="px-4 py-2 border">Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($order->items as $index => $item)
                        <tr>
                            <td class="px-4 py-2 border">{{ $index + 1 }}</td>
                            <td class="px-4 py-2 border">{{ $item->product->name ?? 'N/A' }}</td>
                            <td class="px-4 py-2 border">₹ {{ number_format($item->price, 2) }}</td>
                            <td class="px-4 py-2 border">{{ $item->quantity }}</td>
                            <td class="px-4 py-2 border">₹ {{ number_format($item->total, 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-6">
            <a href="{{ route('orders.index') }}"
                class="bg-gray-600 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                Back to Orders
            </a>
        </div>
    </div>
</x-app-layout>