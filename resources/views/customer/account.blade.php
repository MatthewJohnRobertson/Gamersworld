@extends('layouts.app')

@section('content')
<div class="container my-5" id="main-container">
    @auth('customer')
    @php
    $customer = auth('customer')->user();
    @endphp
    <h1 class="mb-4">My Account</h1>
    <div class="row">

        <div class="row">
            <div class="col-md-6">
                <div class="card mb-6">
                    <div class="card-body">
                        <h5 class="card-title">Personal Information</h5>
                        <p class="card-text">Name: {{ $customer->FirstName }} {{ $customer->LastName }} </p>
                        <p class="card-text">Username: {{ $customer->Username }} </p>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card mb-6">
                    <div class="card-body">
                        <h5 class="card-title">Address Information</h5>
                        <p class="card-text">Street: {{ $customer->StreetName }} </p>
                        <p class="card-text">Suburb: {{ $customer->Suburb }} </p>
                        <p class="card-text">Post Code: {{ $customer->PostCode }} </p>
                    </div>
                </div>

                <div class="card mb-6">
                    <div class="card-body">
                        <h5 class="card-title">Contact Information</h5>
                        <p class="card-text">Phone: {{ $customer->PhNumber }} </p>
                        {{-- <a href="{{ route('customer.contact.edit') }}" class="btn btn-primary">Edit Contact Info</a>--}}
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Account Security</h5>
                        {{-- <a href="{{ route('customer.password.change') }}" class="btn btn-primary me-2">Change Password</a> --}
                        {{-- <a href="{{ route('customer.twofactor') }}" class="btn btn-secondary">Two-Factor Authentication</a> --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
    @else
    <div class="alert alert-danger" role="alert">
        <h4 class="alert-heading">Access Denied</h4>
        <p>You must be logged in to view this page. Please log in to access your account information.</p>
        <hr>
        <p class="mb-0">If you don't have an account, you can <a href="{{ route('customer.register') }}">register here</a>.</p>
    </div>
    <div class="text-center mt-3">
        <a href="{{ route('customer.login') }}" class="btn btn-primary">Log In</a>
    </div>
    @endauth
</div>