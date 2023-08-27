<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Support\Facades\Http;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with('customer', 'products')->get();

        return $this->sendResponse("Order Retrieve Successfully", $orders);
    }

    public function store(Request $request)
    {
        // Validate the request
        $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'product_ids' => 'required|array',
            'product_ids.*' => 'exists:products,id',
        ]);

        // Create the order
        $order = Order::create([
            'customer_id' => $request->input('customer_id'),
        ]);

        // Attach products with quantities to the order
        $productIdsWithQuantities = collect($request->input('product_ids'))->mapWithKeys(function ($productId) {
            return [$productId => ['quantity' => 1]]; 
        });

        $order->products()->sync($productIdsWithQuantities);

        return $this->sendResponse("Order Created Successfully", $order, 201);
    }

    public function show($id)
    {
        $order = Order::with('customer', 'products')->findOrFail($id);
        return $this->sendResponse("Order Details", $order);
    }

    public function update(Request $request, $id)
    {
        // Validate the request
        $request->validate([
            'customer_id' => 'exists:customers,id',
            'product_ids' => 'array',
            'product_ids.*' => 'exists:products,id',
        ]);

        $order = Order::findOrFail($id);
        
        // Update customer ID if provided
        if ($request->has('customer_id')) {
            $order->update(['customer_id' => $request->input('customer_id')]);
        }

        // Update products and their quantities
        if ($request->has('product_ids')) {
            $productIdsWithQuantities = collect($request->input('product_ids'))->mapWithKeys(function ($productId) {
                return [$productId => ['quantity' => 1]]; // Adjust the quantity if needed
            });

            $order->products()->sync($productIdsWithQuantities);
        }

        // Reload the order with updated data
        $order->load('products');

        return $this->sendResponse("Order Updated Successfully", $order);

    }

    public function destroy(Request $request, $id)
    {
        
        
        if(Order::find($id)){
            $order = Order::findOrFail($id)->delete();
            $response = $this->sendResponse('Order deleted successfully.',null);
        }else{
            $response = $this->sendError('Order Not found. The given data was invalid.',422);
        }
        return $response;
    }

    public function addProduct(Request $request, $id)
    {
        $request->validate([
            'product_id' => 'exists:products,id'
        ]);

        if(!Order::find($id)){
            return $response = $this->sendError('Order Not found. The given data was invalid.',422);
        }
        
        $order = Order::with('products')->findOrFail($id);

        // Check if the order is paid
        if ($order->paid) {
            return $this->sendError('Cannot add products to a paid order', 400);
        }

        $product = Product::findOrFail($request->input('product_id'));

        $order->products()->attach($product, ['quantity' => 1]);

        return $this->sendResponse('product added successfully.',$order->load('products'));
    }

    public function payOrder(Request $request, $id)
    {
        if(!Order::find($id)){
            return $response = $this->sendError('Order Not found. The given data was invalid.',422);
        }
        
        $order = Order::findOrFail($id);

        // Check if the order is already paid
        if ($order->paid) {
            return $this->sendError('Order is already paid', 400);
        }

        // Simulate payment with the Super Payment Provider
        $response = Http::post('https://superpay.view.agentur-loop.com/pay', [
            'order_id' => $order->id,
            'customer_email' => $order->customer->email,
            'value' => $order->calculateTotalAmount(),
        ]);
        // dd($response->successful(),$order->calculateTotalAmount(),$response);

        if ($response->successful()) {
            // Mark the order as paid
            $order->update(['paid' => true]);
            return $this->sendResponse('Payment Successful');
        } else {
            return $this->sendError('Payment Failed', 400);
        }
    }
}
