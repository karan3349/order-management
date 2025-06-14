<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreOrderRequest;
use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class OrderController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index(): View
    {
        $orders = Order::with('customer')->latest()->get();

        return view('orders.index', compact('orders'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create(): View
    {
        $customers = Customer::all();
        $products = Product::all();

        return view('orders.create', compact('customers', 'products'));

    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreOrderRequest  $request
     */
    public function store(StoreOrderRequest $request): RedirectResponse
    {
        $data = $request->validated();

        $grand_total = array_sum(array_column($data['order_items'], 'total'));

        $order = Order::create([
            'customer_id' => $data['customer_id'],
            'grand_total' => $grand_total,
        ]);
        foreach ($data['order_items'] as $item) {
            $created = OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item['product_id'],
                'quantity' => $item['quantity'],
                'price' => $item['price'],
                'total' => $item['total'],
            ]);
        }
        logger()->info('Order Item Created:', $created->toArray());

        return redirect()->route('orders.index')->with('success', 'Order created successfully!');
    }

    /**
     * Show the specified resource.
     *
     * @param  \App\Models\Order  $order
     */
    public function show(Order $order): View
    {
        $order->load('customer', 'items.product');

        return view('orders.view', compact('order'));
    }

    /**
     * Return the price of the product with the given id
     *
     * @param \Illuminate\Http\Request $request
     */
    public function getProductprice(int $id): JsonResponse
    {
        $product = Product::find($id);
        if (!$product) {
            return response()->json(['price' => 0]);
        }

        return response()->json(['price' => $product->price]);
    }

}