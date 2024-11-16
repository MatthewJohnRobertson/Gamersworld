<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
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
        Log::info('Payment success method started');

        try {
            // Initialize PayPal
            $provider = new PayPalClient;

            // Set API credentials from config
            $config = config('paypal');
            $provider->setApiCredentials($config);

            // Get access token first
            $token = $provider->getAccessToken();
            Log::info('Access token obtained', ['token_exists' => !empty($token)]);

            // Get PayPal order ID from session
            $paypalOrderId = session('paypal_order_id');
            Log::info('Processing PayPal Order:', ['order_id' => $paypalOrderId]);

            if (empty($paypalOrderId)) {
                throw new \Exception('PayPal Order ID not found in session');
            }

            try {
                // Create a new instance with fresh token
                $provider = new PayPalClient;
                $provider->setApiCredentials($config);
                $provider->getAccessToken();

                // Verify and capture payment
                $response = $provider->capturePaymentOrder($paypalOrderId);
                Log::info('Capture response received:', ['response' => $response]);

                if (isset($response['status']) && $response['status'] === 'COMPLETED') {
                    // Update order in database
                    $order = Order::with('orderItems.product')->find(session('laravel_order_id'));

                    if (!$order) {
                        throw new \Exception('Order not found in database');
                    }

                    $order->status = 'completed';
                    $order->save();

                    // Get the logged in customer
                    $customer = auth('customer')->user();
                    Log::info('Customer found:', ['customer_id' => $customer->id]);

                    // Clear cart and sessions
                    session()->forget(['cart', 'paypal_order_id', 'laravel_order_id']);

                    // Store order details in flash session
                    session()->flash('successOrder', $order);

                    // Redirect to account page
                    return redirect("/customer/account/{$customer->id}")
                        ->with('success', 'Payment completed successfully! Your order details are below.');
                } else {
                    Log::error('Payment status not completed', [
                        'status' => $response['status'] ?? 'unknown',
                        'details' => $response
                    ]);
                    throw new \Exception('Payment was not completed');
                }
            } catch (\Exception $e) {
                Log::error('PayPal API Error:', [
                    'message' => $e->getMessage(),
                    'paypal_order_id' => $paypalOrderId
                ]);
                throw $e;
            }
        } catch (\Exception $e) {
            Log::error('Payment processing error:', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return redirect('/cart')
                ->with('error', 'An error occurred processing your payment. Please try again.');
        }
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
