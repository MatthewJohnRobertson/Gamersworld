@extends('layouts.app')
<div class="page-heading about-page-heading" id="top main-container">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="inner-content">
                    <h2>Join us today!</h2>
                    <span>Awesomeness guaranteed</span>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-6 form-container p-5">
            <div class="text-center mb-4">
                <img src="/api/placeholder/200/100" alt="Company Logo" class="img-fluid mb-3">
                <h2 class="mb-3">Customer Login</h2>
                <p class="text-muted">Welcome back! Please login to your account.</p>
            </div>
            <form method="POST" action="{{ route('login.submit') }}">
                @csrf
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="text" class="form-control @error('Email') is-invalid @enderror" id="Eail" name="Email" required>
                    @error('Email')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="Password" class="form-label">Password</label>
                    <input type="password" class="form-control @error('Password') is-invalid @enderror" id="Password" name="Password" required>
                    @error('Password')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3 form-check">
                    <input type="checkbox" class="form-check-input" id="RememberMe" name="RememberMe">
                    <label class="form-check-label" for="RememberMe">Remember me</label>
                </div>
                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-primary py-2">Login</button>
                </div>
            </form>
            <div class="mt-3 text-center">
                <p>Don't have an account? <a href="{{ route('customers.create') }}" class="text-decoration-none">Register here</a></p>
            </div>
        </div>
    </div>
</div>