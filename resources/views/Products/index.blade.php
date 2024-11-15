@extends('layouts.app')
@section('content')
<div class="container mt-4" id="main-container">
    <h2 class="mb-4">Our Products</h2>
    <div class="row">
        @foreach($products as $product)
        <div class="col-md-4 mb-4">
            <div class="card h-100">
                <a href="{{ route('products.show', $product->id) }}">
                    <img src="{{ asset($product->PicUrl) }}"
                        class="card-img-top"
                        alt="{{ $product->ProductName }}"
                        style="height: 200px; object-fit: cover;">
                </a>
                <div class="card-body d-flex flex-column">
                    <h5 class="card-title">{{ $product->ProductName }}</h5>
                    <p class="card-text fs-4 fw-bold">${{ number_format($product->ProductPrice, 2) }}</p>
                    <p class="card-text text-muted">{{ Str::limit($product->Description, 100) }}</p>

                    <div class="mt-auto">
                        <div class="mb-3">
                            <label class="form-label">Quantity</label>
                            <div class="input-group">
                                <input type="number"
                                    class="form-control"
                                    min="1"
                                    max="100"
                                    value="1"
                                    name="quantity"
                                    style="width: 80px;">
                            </div>
                        </div>
                        <form action="{{ route('cart.add') }}" method="POST">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                            <input type="hidden" name="quantity" value="1">
                            <button type="submit" class="btn btn-primary w-100">
                                Add to Cart
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>

@if(session('success'))
<div class="position-fixed bottom-0 end-0 p-3" style="z-index: 1050;">
    <div class="alert alert-success shadow">
        {{ session('success') }}
    </div>
</div>
@endif
@endsection