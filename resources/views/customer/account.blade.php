@extends('layouts.app')
@section('content')
<div class="container my-5">
    @auth('customer')
    @php
    $customer = auth('customer')->user();
    @endphp

    <h1 class="mb-4">My Account</h1>

    <div class="row">
        {{-- Left Column: Account Information --}}
        <div class="col-md-4">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">Personal Information</h5>
                </div>
                <div class="card-body">
                    <p class="mb-1"><strong>Name:</strong> {{ $customer->FirstName }} {{ $customer->LastName }}</p>
                    <p class="mb-0"><strong>Username:</strong> {{ $customer->Username }}</p>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">Address Information</h5>
                </div>
                <div class="card-body">
                    <p class="mb-1"><strong>Street:</strong> {{ $customer->StreetName }}</p>
                    <p class="mb-1"><strong>Suburb:</strong> {{ $customer->Suburb }}</p>
                    <p class="mb-0"><strong>Post Code:</strong> {{ $customer->PostCode }}</p>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">Contact Information</h5>
                </div>
                <div class="card-body">
                    <p class="mb-0"><strong>Phone:</strong> {{ $customer->PhNumber }}</p>
                </div>
            </div>
        </div>

        {{-- Right Column: Orders --}}
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Order History</h5>
                </div>
                <div class="card-body">
                    @if($customer->orders && $customer->orders->count() > 0)
                    @foreach($customer->orders as $order)
                    <div class="order-item mb-4 {{ !$loop->last ? 'border-bottom pb-3' : '' }}">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h6 class="mb-0">Order #{{ $order->id }}</h6>
                            <span class="badge bg-{{ $order->status === 'completed' ? 'success' : 'primary' }}">
                                {{ ucfirst($order->status) }}
                            </span>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <p class="mb-1"><small class="text-muted">Date: {{ $order->created_at->format('M d, Y') }}</small></p>
                                <p class="mb-0"><strong>Total: ${{ number_format($order->total_amount, 2) }}</strong></p>
                            </div>
                            <div class="col-md-6 text-md-end">
                                <button class="btn btn-sm btn-outline-secondary" type="button"
                                    data-bs-toggle="collapse"
                                    data-bs-target="#orderDetails{{ $order->id }}"
                                    aria-expanded="false"
                                    aria-controls="orderDetails{{ $order->id }}">
                                    <i class="bi bi-chevron-down"></i> View Details
                                </button>
                            </div>
                        </div>
                        <div class="collapse" id="orderDetails{{ $order->id }}">
                            <div class="table-responsive">
                                <table class="table table-sm">
                                    <thead>
                                        <tr>
                                            <th>Product</th>
                                            <th class="text-center">Quantity</th>
                                            <th class="text-end">Price</th>
                                            <th class="text-end">Subtotal</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($order->orderItems as $item)
                                        <tr>
                                            <td>{{ $item->product->ProductName }}</td>
                                            <td class="text-center">{{ $item->quantity }}</td>
                                            <td class="text-end">${{ number_format($item->product->ProductPrice, 2) }}</td>
                                            <td class="text-end">${{ number_format($item->quantity * $item->product->ProductPrice, 2) }}</td>
                                        </tr>
                                        @endforeach
                                        <tr class="border-top">
                                            <td colspan="3" class="text-end"><strong>Total:</strong></td>
                                            <td class="text-end"><strong>${{ number_format($order->total_amount, 2) }}</strong></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    @endforeach
                    @else
                    <p class="text-muted text-center mb-0">No orders found.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    @else
    <div class="alert alert-danger" role="alert">
        <h4 class="alert-heading">Access Denied</h4>
        <p>You must be logged in to view this page.</p>
        <hr>
        <p class="mb-0">If you don't have an account, you can register here.</p>
    </div>
    @endauth
</div>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js"></script>
@endsection