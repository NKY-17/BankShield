<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class CustomerController extends Controller
{
    // Display all customers
    public function index()
    {
        $customers = Customer::with('accounts')
            ->latest()
            ->get();

        return view('customers.index', compact('customers'));
    }

    // Show customer registration form
    public function create()
    {
        return view('customers.create');
    }

    // Store a new customer and login account
    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email|unique:customers,email',
            'password' => 'required|string|min:8|confirmed',
            'phone' => 'required|string|max:30',
            'date_of_birth' => 'nullable|date',
            'gender' => 'nullable|string|max:30',
            'address' => 'nullable|string',
            'city' => 'nullable|string|max:100',
            'occupation' => 'nullable|string|max:100',
        ]);

        DB::transaction(function () use ($validated) {

            // Create customer login account
            $user = User::create([
                'name' => $validated['first_name'] . ' ' . $validated['last_name'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
                'role' => 'customer',
            ]);

            // Create customer profile
            Customer::create([
                'customer_number' => 'CUS' . strtoupper(uniqid()),
                'user_id' => $user->id,
                'first_name' => $validated['first_name'],
                'last_name' => $validated['last_name'],
                'email' => $validated['email'],
                'phone' => $validated['phone'],
                'date_of_birth' => $validated['date_of_birth'] ?? null,
                'gender' => $validated['gender'] ?? null,
                'address' => $validated['address'] ?? null,
                'city' => $validated['city'] ?? null,
                'occupation' => $validated['occupation'] ?? null,
                'created_by' => auth()->id(),
            ]);
        });

        return redirect()
            ->route('customers.index')
            ->with('success', 'Customer registered successfully. Login account created.');
    }

    // Show customer edit form
    public function edit(Customer $customer)
    {
        return view('customers.edit', compact('customer'));
    }

    // Update customer information
    public function update(Request $request, Customer $customer)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'nullable|email|unique:customers,email,' . $customer->id,
            'phone' => 'required|string|max:30',
            'date_of_birth' => 'nullable|date',
            'gender' => 'nullable|string|max:30',
            'address' => 'nullable|string',
            'city' => 'nullable|string|max:100',
            'occupation' => 'nullable|string|max:100',
        ]);

        $customer->update($validated);

        return redirect()
            ->route('customers.index')
            ->with('success', 'Customer information updated successfully.');
    }

    // Search customers
    public function search(Request $request)
    {
        $search = $request->input('search');

        $customers = Customer::with('accounts')
            ->where(function ($query) use ($search) {
                $query->where('first_name', 'like', "%{$search}%")
                    ->orWhere('last_name', 'like', "%{$search}%")
                    ->orWhere('customer_number', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%");
            })
            ->latest()
            ->get();

        return view('customers.index', compact('customers'));
    }
}
