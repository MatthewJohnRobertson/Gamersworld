@extends('layouts.app')

@section('content')
<div class="container" id="main-container">
    <div class="row">
        <div class="col-lg-6">
            <div class="section-heading">
                <h1>Create New Product</h1>
            </div>
        </div>
    </div>

    <form action="{{ route('products.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="ProductName" class="form-label">Product Name</label>
            <input type="text" class="form-control @error('ProductName') is-invalid @enderror" id="ProductName" name="ProductName" value="{{ old('ProductName') }}" required>
            @error('ProductName')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="Description" class="form-label">Description</label>
            <textarea class="form-control @error('Description') is-invalid @enderror" id="Description" name="Description" rows="3" required>{{ old('Description') }}</textarea>
            @error('Description')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="ItemType" class="form-label">Item Type</label>
            <input type="text" class="form-control @error('ItemType') is-invalid @enderror" id="ItemType" name="ItemType" value="{{ old('ItemType') }}" required>
            @error('ItemType')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="QtyRemaining" class="form-label">Quantity Remaining</label>
            <input type="number" class="form-control @error('QtyRemaining') is-invalid @enderror" id="QtyRemaining" name="QtyRemaining" value="{{ old('QtyRemaining') }}" required>
            @error('QtyRemaining')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="ProductPrice" class="form-label">Product Price</label>
            <input type="number" step="0.01" class="form-control @error('ProductPrice') is-invalid @enderror" id="ProductPrice" name="ProductPrice" value="{{ old('ProductPrice') }}" required>
            @error('ProductPrice')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">Create Product</button>
    </form>
</div>
@endsection