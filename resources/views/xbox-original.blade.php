@extends('layouts.app')
@section('content')
<div class="container py-5" id="main-container">
    <div class="mb-5">
        <h1 class="display-4 mb-2">Xbox Original</h1>
        <h2 class="h3 text-muted">Games Collection</h2>
    </div>
    <div class="row g-4">
        @forelse($products as $product)
        <div class="col-12 col-sm-6 col-lg-4 col-xl-3">
            <div class="card h-100">
                <!-- Image Container -->
                <div class="position-relative" style="height: 256px;">
                    @if($product->PicUrl)
                    <a href="{{ route('products.show', $product->id) }}">
                        <img src="{{ $product->PicUrl }}"
                            alt="{{ $product->ProductName }}"
                            class="card-img-top h-100 w-100"
                            style="object-fit: cover;">
                    </a>
                    @else
                    <div class="h-100 w-100 bg-light d-flex align-items-center justify-content-center">
                        <span class="text-muted">No Image</span>
                    </div>
                    @endif
                </div>
                <!-- Content Container -->
                <div class="card-body d-flex flex-column">
                    <h3 class="h5 card-title mb-3">{{ $product->ProductName }}</h3>
                    <p class="card-text text-muted small mb-4 product-description">
                        {{ $product->Description }}
                    </p>
                    <div class="mt-auto">
                        <span class="fs-4 fw-bold d-block mb-3">
                            ${{ number_format($product->ProductPrice, 2) }}
                        </span>
                        <form action="{{ route('cart.add') }}" method="POST">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                            <input type="hidden" name="quantity" value="1">
                            <button type="submit"
                                class="btn btn-primary w-100 py-2">
                                Add to Cart
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12 text-center py-5">
            <h3 class="h4 text-muted">No Xbox games found</h3>
            <p class="text-muted mt-3">Check back later for new arrivals</p>
        </div>
        @endforelse
    </div>
</div>
@if(session('success'))
<div class="position-fixed bottom-0 end-0 p-3" style="z-index: 1050;">
    <div class="alert alert-success shadow">
        {{ session('success') }}
    </div>
</div>
@endif
</section>
@push('styles')
<style>
    .product-description {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
</style>
@endpush
@endsection