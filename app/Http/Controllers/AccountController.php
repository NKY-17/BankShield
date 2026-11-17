<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Customer;
use Illuminate\Http\Request;

class AccountController extends Controller
{
    // Display all accounts
    public function index()
    {
        $accounts = Account::with('customer')->latest()->get();

        return view('accounts.index', compact('accounts'));
    }

    // Show account creation form
    public function create()
    {
        $customers = Customer::where('status', 'active')->get();

        return view('accounts.create', compact('customers'));
    }

    // Store a new account
    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'account_type' => 'required|in:savings,current',
            'balance' => 'required|numeric|min:0|max:9999999999999.99',
        ]);

        $validated['account_number'] = 'ACC' . strtoupper(uniqid());
        $validated['status'] = 'active';
        $validated['opened_at'] = now()->toDateString();

        Account::create($validated);

        return redirect()
            ->route('accounts.index')
            ->with('success', 'Account created successfully.');
    }

    // Freeze an active account
    public function freeze(Account $account)
    {
        if ($account->status !== 'active') {
            return redirect()
                ->route('accounts.index')
                ->with('error', 'Only active accounts can be frozen.');
        }

        $account->update(['status' => 'frozen']);

        return redirect()
            ->route('accounts.index')
            ->with('success', 'Account frozen successfully.');
    }

    // Unfreeze a frozen account
    public function unfreeze(Account $account)
    {
        if ($account->status !== 'frozen') {
            return redirect()
                ->route('accounts.index')
                ->with('error', 'Only frozen accounts can be activated.');
        }

        $account->update(['status' => 'active']);

        return redirect()
            ->route('accounts.index')
            ->with('success', 'Account activated successfully.');
    }

    // Close an account
    public function close(Account $account)
    {
        if (!in_array($account->status, ['active', 'frozen'])) {
            return redirect()
                ->route('accounts.index')
                ->with('error', 'This account is already closed.');
        }

        if ($account->balance > 0) {
            return redirect()
                ->route('accounts.index')
                ->with('error', 'An account must have a zero balance before it can be closed.');
        }

        $account->update(['status' => 'closed']);

        return redirect()
            ->route('accounts.index')
            ->with('success', 'Account closed successfully.');
    }
    // Feature 11: Check a transaction for suspicious activity
    public function checkFraud(Request $request)
    {
        $validated = $request->validate([
            'account_id' => 'required|exists:accounts,id',
            'amount' => 'required|numeric|min:0.01',
        ]);

        $account = Account::findOrFail($validated['account_id']);

        if ($account->status !== 'active') {
            return back()->with('error', 'This account is not active.');
        }

        $amount = $validated['amount'];

        $reasons = [];

        if ($amount >= 50000) {
            $reasons[] = 'Unusually large transaction';
        }

        if (now()->hour >= 0 && now()->hour < 5) {
            $reasons[] = 'Transaction attempted during unusual hours';
        }

        if (count($reasons) > 0) {
            return back()->with(
                'error',
                'Suspicious transaction detected: ' . implode(', ', $reasons)
            );
        }

        return back()->with('success', 'Transaction passed the fraud checks.');
    }
}
