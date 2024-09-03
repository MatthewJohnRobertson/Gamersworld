@extends('layouts.app')

<div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-md-8 form-container p-5">
                <div class="text-center mb-4">
                    <img src="/api/placeholder/200/100" alt="Company Logo" class="img-fluid mb-3">
                    <h2 class="mb-3">Customer Registration</h2>
                    <p class="text-muted">Join our community today!</p>
                </div>
              {{--  <form action="{{ route('customer.register') }}" method="POST">--}}
                    @csrf
                    <div class="row g-4">
                        <div class="col-md-6">
                            <label for="CustomerID" class="form-label">Customer ID</label>
                            <input type="text" class="form-control" id="CustomerID" name="CustomerID" required>
                        </div>
                        <div class="col-md-6">
                            <label for="FirstName" class="form-label">First Name</label>
                            <input type="text" class="form-control" id="FirstName" name="FirstName" required>
                        </div>
                        <div class="col-md-6">
                            <label for="LastName" class="form-label">Last Name</label>
                            <input type="text" class="form-control" id="LastName" name="LastName" required>
                        </div>
                        <div class="col-md-6">
                            <label for="StreetName" class="form-label">Street Name</label>
                            <input type="text" class="form-control" id="StreetName" name="StreetName" required>
                        </div>
                        <div class="col-md-6">
                            <label for="Suburb" class="form-label">Suburb</label>
                            <input type="text" class="form-control" id="Suburb" name="Suburb" required>
                        </div>
                        <div class="col-md-6">
                            <label for="PostCode" class="form-label">Post Code</label>
                            <input type="text" class="form-control" id="PostCode" name="PostCode" required>
                        </div>
                        <div class="col-md-6">
                            <label for="DateOfBirth" class="form-label">Date of Birth</label>
                            <input type="date" class="form-control" id="DateOfBirth" name="DateOfBirth" required>
                        </div>
                        <div class="col-md-6">
                            <label for="PhNumbers" class="form-label">Phone Number</label>
                            <input type="tel" class="form-control" id="PhNumbers" name="PhNumbers" required>
                        </div>
                        <div class="col-md-6">
                            <label for="Username" class="form-label">Username</label>
                            <input type="text" class="form-control" id="Username" name="Username" required>
                        </div>
                        <div class="col-md-6">
                            <label for="Password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="Password" name="Password" required>
                        </div>
                        <div class="col-12 mt-4">
                            <button type="submit" class="btn btn-primary w-100 py-2">Register</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>