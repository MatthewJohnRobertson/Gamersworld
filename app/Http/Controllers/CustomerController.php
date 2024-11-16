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

        return redirect()->route('customer.account', ['customer' => $customer->id])
            ->with('success', 'Customer registered successfully');
    }

    public function show() {
        $customer = auth('customer')->user()->load(['orders' => function ($query) {
            $query->orderBy('created_at', 'desc');
        }, 'orders.orderItems', 'orders.orderItems.product']);
        return view('customer.account', compact('customer'));
    }

    public function account(Request $request, $customerId = null) {
        $authCustomer = Auth::guard('customer')->user();

        if (!$authCustomer) {
            return redirect()->route('login');
        }

        if ($customerId && $authCustomer->id != $customerId) {
            abort(403, 'Unauthorized action.');
        }


        return view('customer.account', ['customer' => $authCustomer]);
    }
}
