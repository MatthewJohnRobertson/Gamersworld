@extends('layouts.app')

@section('content')
<div class="container py-5" id="main-container">
    <h1 class="display-4 mb-4">Shopping Cart</h1>

    @if(session('success'))
    <div class="alert alert-success mb-4" role="alert">
        {{ session('success') }}
    </div>
    @endif

    @if(count($cart) > 0)
    <div class="card">
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr class="table-light">
                        <th class="text-start">Product</th>
                        <th class="text-center">Price</th>
                        <th class="text-center">Quantity</th>
                        <th class="text-center">Subtotal</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($cart as $id => $item)
                    <tr id="cart-item-{{ $id }}">
                        <td>
                            <div class="d-flex align-items-center">
                                @if($item['PicUrl'])
                                <img src="{{ $item['PicUrl'] }}" alt="{{ $item['ProductName'] }}" class="img-thumbnail me-3" style="width: 64px; height: 64px; object-fit: cover;">
                                @endif
                                <div>
                                    <h5 class="mb-1">{{ $item['ProductName'] }}</h5>
                                    <p class="text-muted small mb-0">{{ Str::limit($item['Description'], 100) }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="text-center align-middle">${{ number_format($item['ProductPrice'], 2) }}</td>
                        <td class="text-center align-middle">
                            <div class="d-flex justify-content-center">
                                <input type="number"
                                    min="1"
                                    value="{{ $item['quantity'] }}"
                                    class="form-control quantity-input"
                                    style="width: 100px;"
                                    data-product-id="{{ $id }}">
                            </div>
                        </td>
                        <td class="text-center align-middle">
                            ${{ number_format($item['ProductPrice'] * $item['quantity'], 2) }}
                        </td>
                        <td class="text-center align-middle">
                            <form action="{{ route('cart.remove') }}" method="POST" class="d-inline">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $id }}">
                                <button type="submit" class="btn btn-danger">
                                    Remove
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="3" class="text-end fw-bold">Total:</td>
                        <td class="text-center fw-bold">${{ number_format($total, 2) }}</td>
                        <td></td>
                    </tr>
                </tfoot>
            </table>
        </div>

        <div class="card-footer">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <form action="{{ route('cart.clear') }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-danger">
                            Clear Cart
                        </button>
                    </form>
                </div>

                @if(!empty($cart))
                <a href="{{ route('paypal.payment') }}" class="btn btn-success">Pay with PayPal </a>
                @endif
            </div>
        </div>
    </div>
    @else
    <div class="text-center py-5">
        <p class="text-muted fs-4 mb-4">Your cart is empty</p>
        <a href="{{ route('products.index') }}" class="btn btn-primary">
            Continue Shopping
        </a>
    </div>
    @endif
</div>

@endsection