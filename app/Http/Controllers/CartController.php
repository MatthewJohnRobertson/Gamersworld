<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Srmklive\PayPal\Services\PayPal as PayPalClient;

class CartController extends Controller {
    public function index() {
        $cart = session()->get('cart', []);
        $total = $this->calculateTotal($cart);
        return view('cart.index', compact('cart', 'total'));
    }

    public function update(Request $request) {
        try {
            $request->validate([
                'product_id' => 'required',
                'quantity' => 'required|numeric|min:1'
            ]);

            $cart = session()->get('cart', []);

            if (isset($cart[$request->product_id])) {
                $cart[$request->product_id]['quantity'] = $request->quantity;
                session()->put('cart', $cart);

                return response()->json([
                    'success' => true,
                    'message' => 'Cart updated successfully!'
                ]);
            }

            return response()->json([
                'success' => false,
                'message' => 'Product not found in cart'
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error updating cart: ' . $e->getMessage()
            ], 500);
        }
    }

    public function remove(Request $request) {
        $cart = session()->get('cart', []);
        $id = $request->get('product_id');

        unset($cart[$id]);
        session()->put('cart', $cart);

        return back()->with('success', 'Item removed successfully');
    }

    private function calculateTotal($cart) {
        return collect($cart)->sum(function ($item) {
            return $item['ProductPrice'] * $item['quantity'];
        });
    }

    public function clear() {
        session()->forget('cart');
        return redirect()->route('cart.index')->with('success', 'Cart cleared successfully');
    }

    public function addToCart(Request $request) {
        try {
            $request->validate([
                'product_id' => 'required',
                'quantity' => 'required|numeric|min:1'
            ]);

            $product = Product::findOrFail($request->product_id);

            $cart = session()->get('cart', []);

            if (isset($cart[$request->product_id])) {
                $cart[$request->product_id]['quantity'] += $request->quantity;
            } else {
                $cart[$request->product_id] = [
                    'ProductID' => $product->id,
                    'ProductName' => $product->ProductName,
                    'ProductPrice' => $product->ProductPrice,
                    'quantity' => $request->quantity,
                    'PicUrl' => $product->PicUrl,
                    'Description' => $product->Description
                ];
            }

            session()->put('cart', $cart);
            return redirect()->back()->with('success', 'Product added to cart successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error adding product to cart: ' . $e->getMessage());
        }
    }

    public function payment(Request $request) {
        $cartItems = session('cart', []);

        // Calculate total
        $total = collect($cartItems)->sum(function ($item) {
            return $item['ProductPrice'] * $item['quantity'];
        });

        // Setup PayPal
        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $provider->getAccessToken();

        // Create PayPal order
        $response = $provider->createOrder([
            "intent" => "CAPTURE",
            "purchase_units" => [
                [
                    "amount" => [
                        "currency_code" => "AUD",
                        "value" => number_format($total, 2, '.', '')
                    ]
                ]
            ],
            "application_context" => [
                "return_url" => route('paypal.payment.success'),
                "cancel_url" => route('paypal.payment.cancel')
            ]
        ]);

        if (isset($response['id']) && $response['id']) {
            // Create database order
            $order = Order::create([
                'customer_id' => auth('customer')->id(),
                'total_amount' => $total,
                'status' => 'pending'
            ]);

            // Create order items
            foreach ($cartItems as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item['ProductID'],
                    'quantity' => $item['quantity']
                ]);
            }

            // Save order IDs to session
            session(['paypal_order_id' => $response['id']]);
            session(['laravel_order_id' => $order->id]);

            // Redirect to PayPal
            foreach ($response['links'] as $link) {
                if ($link['rel'] === 'approve') {
                    return redirect()->away($link['href']);
                }
            }
        }

        return redirect()->back()->with('error', 'Something went wrong.');
    }

    public function paymentSuccess(Request $request) {
        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));

        // Get PayPal order ID from session
        $paypalOrderId = session('paypal_order_id');

        // Capture the PayPal order
        $response = $provider->capturePaymentOrder($paypalOrderId);

        if (isset($response['status']) && $response['status'] === 'COMPLETED') {
            // Update order in database
            $order = Order::find(session('laravel_order_id'));
            $order->status = 'completed';
            $order->save();

            // Clear cart and sessions
            session()->forget(['cart', 'paypal_order_id', 'laravel_order_id']);

            return redirect()->route('orders.show', $order->id)
                ->with('success', 'Payment completed successfully!');
        }

        return redirect()->route('cart.index')->with('error', 'Payment failed.');
    }

    public function paymentCancel() {
        // Delete the pending order
        if ($orderId = session('laravel_order_id')) {
            Order::find($orderId)->delete();
        }

        // Clear sessions
        session()->forget(['paypal_order_id', 'laravel_order_id']);

        return redirect()->route('cart.index')
            ->with('error', 'Payment cancelled.');
    }
}
