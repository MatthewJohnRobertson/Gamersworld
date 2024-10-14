@extends('layouts.app')
@auth('customer')


<div class="container my-5" id="main-container">
    <h1 class=" mb-4">My Account</h1>



    <div class="row">
        <div class="col-md-4">
            <div class="card mb-4">
                <div class="card-body">
                    <h5 class="card-title">Personal Information</h5>
                    <p class="card-text">Name: {{ $customer->FirstName }} {{ $customer->LastName }} </p>
                    <p class="card-text">Username: {{ $customer->Username }} </p>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card mb-4">
                <div class="card-body">
                    <h5 class="card-title">Address Information</h5>
                    <p class="card-text">Street: {{ $customer->StreetName }} </p>
                    <p class="card-text">Suburb: {{ $customer->Suburb }} </p>
                    <p class="card-text">Post Code: {{ $customer->PostCode }} </p>
                </div>
            </div>

            <div class="card mb-4">
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
echo "<h1>Exit page</h1>";
@endauth