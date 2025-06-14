<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
            {{ __('Order List') }}
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="flex justify-between items-center mb-6">
                <h1 class="text-xl font-semibold text-gray-700">All Orders</h1>
                <a href="{{ route('orders.create') }}"
                    class="inline-flex items-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-md shadow-sm transition">
                    + Create Order
                </a>
            </div>

            <div class="bg-white shadow-md rounded-lg overflow-hidden">
                <table class="min-w-full table-auto border border-gray-200">
                    <thead class="bg-gray-50">
                        <tr class="text-sm text-left text-gray-600">
                            <th class="px-6 py-3">Order ID</th>
                            <th class="px-6 py-3">Order Date</th>
                            <th class="px-6 py-3">Customer</th>
                            <th class="px-6 py-3">Total</th>
                            <th class="px-6 py-3 text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($orders as $order)
                        <tr class="hover:bg-gray-50 text-sm">
                            <td class="px-6 py-4">{{ $order->id }}</td>
                            <td class="px-6 py-4">{{ $order->created_at->format('Y-m-d H:i') }}</td>
                            <td class="px-6 py-4">{{ $order->customer->name }}</td>
                            <td class="px-6 py-4">₹{{ number_format($order->grand_total, 2) }}</td>
                            <td class="px-6 py-4 text-center">
                                <a href="{{ route('orders.show', $order->id) }}"
                                    class="text-indigo-600 hover:text-indigo-800 font-medium">View</a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-6 py-4 text-center text-gray-500">
                                No orders found.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</x-app-layout>