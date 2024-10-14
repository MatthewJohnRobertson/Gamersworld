<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class CustomerController extends Controller {

    public function create() {
        return view('customer/auth/register');
    }



    public function store(Request $request) {

        $validator = Validator::make($request->all(), [
            'FirstName' => 'required|string|max:255',
            'LastName' => 'required|string|max:255',
            'StreetName' => 'required|string|max:255',
            'Suburb' => 'required|string|max:255',
            'PostCode' => 'required|string|max:10',
            'DateOfBirth' => 'required|date',
            'PhNumber' => 'required|string|max:20',
            'Username' => 'required|string|max:255|unique:customers,Username',
            'Email' => 'required|string|email|max:255|unique:customers,Email',
            'Password' => 'required|string|min:8',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput($request->except('Password'));
        }

        $validatedData = $validator->validated();
        $validatedData['Password'] = Hash::make($validatedData['Password']);

        $customer = Customer::create($validatedData);

        return redirect()->route('customers.show', ['customer' => $customer])
            ->with('success', 'Customer registered successfully');
    }

    public function show($id) {
        $customer = Customer::find($id);
        if (!$customer) {
            abort(404);
        }
        return view('customer', ['customer' => $customer]);
    }

    public function account(Request $request, $customerId = null) {
        $authCustomer = Auth::guard('customer')->user();

        if (!$authCustomer) {
            \Log::warning("No authenticated customer found");
            return redirect()->route('login');
        }

        if ($customerId && $authCustomer->id != $customerId) {
            \Log::warning("Unauthorized access attempt. Auth ID: {$authCustomer->id}, Requested ID: $customerId");
            abort(403, 'Unauthorized action.');
        }

        \Log::info("Authenticated customer ID: " . $authCustomer->id);
        return view('customer.account', ['customer' => $authCustomer]);
    }
}
