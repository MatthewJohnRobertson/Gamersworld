@extends('layouts.app')

<div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-md-6 form-container p-5">
                <div class="text-center mb-4">
                    <img src="/api/placeholder/200/100" alt="Company Logo" class="img-fluid mb-3">
                    <h2 class="mb-3">Customer Login</h2>
                    <p class="text-muted">Welcome back! Please login to your account.</p>
                </div>
                {{-- <form action="{{ route('customer.login') }}" method="POST"> --}}
                    @csrf
                    <div class="mb-3">
                        <label for="Username" class="form-label">Username</label>
                        <input type="text" class="form-control @error('Username') is-invalid @enderror" id="Username" name="Username" required>
                        @error('Username')
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
                <div class="mt-4 text-center">
                {{--<a href="{{ route('customer.password.request') }}" class="text-decoration-none">Forgot Password?</a>--}}
                </div>
                <div class="mt-3 text-center">
                    <p>Don't have an account? {{--<a href="{{ route('customer.register') }}" class="text-decoration-none">Register here</a> --}}</p>
                </div>
            </div>
        </div>
    </div>