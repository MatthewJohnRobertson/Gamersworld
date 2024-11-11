<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class CustomerLoginController extends Controller {

    public function showLoginForm() {
        return view('customer.auth.login');
    }

    public function login(Request $request) {
        $validator = Validator::make($request->all(), [
            'Email' => 'required|string|email',
            'Password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput($request->except('Password'));
        }

        $credentials = $request->only('Email', 'Password');
        $customer = Customer::where('Email', $credentials['Email'])->first();

        if (!$customer || !Hash::check($credentials['Password'], $customer->Password)) {
            return redirect()->back()
                ->withInput($request->except('Password'))
                ->withErrors(['Email' => 'These credentials do not match our records.']);
        }

        Auth::guard('customer')->login($customer);

        // Set the session variable
        session(['customer' => $customer]);

        // Redirect to the account page with the customer ID
        return redirect()->route('customer.account', ['customer' => $customer->id]);
    }

    public function logout(Request $request) {
        Auth::guard('customer')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
