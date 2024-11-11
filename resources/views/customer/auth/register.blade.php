@extends('layouts.app')

@section('content')

<div class="page-heading about-page-heading" id="top main-container">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="inner-content">
                    <h2>Register with us today!</h2>
                    <span>Awesomeness guaranteed</span>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-8 form-container p-5">
            <div class="text-center mb-4">
                <img src="/api/placeholder/200/100" alt="Company Logo" class="img-fluid mb-3">
                <h2 class="mb-3">Customer Registration</h2>
                <p class="text-muted">Join our community today!</p>
            </div>
            @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif
            <form action="{{ route('customers.store') }}" method="POST">
                @csrf
                <div class="row g-4">
                    <div class="col-md-6">
                        <label for="FirstName" class="form-label">First Name</label>
                        <input type="text" class="form-control @error('FirstName') is-invalid @enderror" id="FirstName" name="FirstName" value="{{ old('FirstName') }}" required>
                        @error('FirstName')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="LastName" class="form-label">Last Name</label>
                        <input type="text" class="form-control @error('LastName') is-invalid @enderror" id="LastName" name="LastName" value="{{ old('LastName') }}" required>
                        @error('LastName')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="StreetName" class="form-label">Street Name</label>
                        <input type="text" class="form-control @error('StreetName') is-invalid @enderror" id="StreetName" name="StreetName" value="{{ old('StreetName') }}" required>
                        @error('StreetName')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="Suburb" class="form-label">Suburb</label>
                        <input type="text" class="form-control @error('Suburb') is-invalid @enderror" id="Suburb" name="Suburb" value="{{ old('Suburb') }}" required>
                        @error('Suburb')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="PostCode" class="form-label">Post Code</label>
                        <input type="text" class="form-control @error('PostCode') is-invalid @enderror" id="PostCode" name="PostCode" value="{{ old('PostCode') }}" required>
                        @error('PostCode')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="DateOfBirth" class="form-label">Date of Birth</label>
                        <input type="date" class="form-control @error('DateOfBirth') is-invalid @enderror" id="DateOfBirth" name="DateOfBirth" value="{{ old('DateOfBirth') }}" required>
                        @error('DateOfBirth')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="PhNumber" class="form-label">Phone Number</label>
                        <input type="text" class="form-control @error('PhNumber') is-invalid @enderror" id="PhNumber" name="PhNumber" value="{{ old('PhNumber') }}" required>
                        @error('PhNumber')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="Username" class="form-label">Username</label>
                        <input type="text" class="form-control @error('Username') is-invalid @enderror" id="Username" name="Username" value="{{ old('Username') }}" required>
                        @error('Username')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="Email" class="form-label">Email</label>
                        <input type="email" class="form-control @error('Email') is-invalid @enderror" id="Email" name="Email" value="{{ old('Email') }}" required>
                        @error('Email')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="Password" class="form-label">Password</label>
                        <input type="password" class="form-control @error('Password') is-invalid @enderror" id="Password" name="Password" required>
                        @error('Password')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-12 mt-4">
                        <button type="submit" class="btn btn-primary w-100 py-2">Register</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection