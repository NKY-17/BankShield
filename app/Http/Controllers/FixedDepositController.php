<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\FixedDeposit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

class FixedDepositController extends Controller
{
    // Display customer's fixed deposits
    public function index()
    {
        $customer = auth()->user()->customer;

        if (!$customer) {
            abort(403, 'Customer profile not found.');
        }

        // Complete deposits that have reached maturity
        $this->processMaturedDeposits($customer->id);

        $fixedDeposits = FixedDeposit::where('customer_id', $customer->id)
            ->with('account')
            ->latest()
            ->get();

        return view('fixed-deposits.index', compact('fixedDeposits'));
    }

    // Display fixed deposit creation form
    public function create()
    {
        $customer = auth()->user()->customer;

        if (!$customer) {
            abort(403, 'Customer profile not found.');
        }

        $accounts = Account::where('customer_id', $customer->id)
            ->where('status', 'active')
            ->get();

        return view('fixed-deposits.create', compact('accounts'));
    }

    // Create a new fixed deposit
    public function store(Request $request)
    {
        $customer = auth()->user()->customer;

        if (!$customer) {
            abort(403, 'Customer profile not found.');
        }

        $validated = $request->validate([
            'account_id' => 'required|exists:accounts,id',
            'principal_amount' => 'required|numeric|min:1',
            'duration_months' => 'required|in:3,6,12',
        ]);

        $interestRate = 8.00;

        $account = DB::transaction(function () use (
            $validated,
            $customer,
            $interestRate
        ) {
            // Lock the account to prevent simultaneous deductions
            $account = Account::where('id', $validated['account_id'])
                ->where('customer_id', $customer->id)
                ->lockForUpdate()
                ->firstOrFail();

            if ($account->status !== 'active') {
                throw \Illuminate\Validation\ValidationException::withMessages([
                    'account_id' => 'This account is not active.',
                ]);
            }

            $principal = round((float) $validated['principal_amount'], 2);

            if ($principal > (float) $account->balance) {
                throw \Illuminate\Validation\ValidationException::withMessages([
                    'principal_amount' => 'Insufficient account balance.',
                ]);
            }

            $duration = (int) $validated['duration_months'];

            // Calculate simple interest
            $interest = round(
                $principal * ($interestRate / 100) * ($duration / 12),
                2
            );

            $maturityAmount = round($principal + $interest, 2);

            $startDate = Carbon::today();
            $maturityDate = $startDate->copy()->addMonths($duration);

            // Deduct the deposit amount from the account
            $account->decrement('balance', $principal);

            // Create the fixed deposit
            FixedDeposit::create([
                'customer_id' => $customer->id,
                'account_id' => $account->id,
                'deposit_number' => 'FD' . strtoupper(Str::random(12)),
                'principal_amount' => $principal,
                'interest_rate' => $interestRate,
                'duration_months' => $duration,
                'start_date' => $startDate,
                'maturity_date' => $maturityDate,
                'expected_interest' => $interest,
                'maturity_amount' => $maturityAmount,
                'status' => 'active',
            ]);

            return $account;
        });

        return redirect()
            ->route('fixed-deposits.index')
            ->with('success', 'Fixed deposit created successfully.');
    }

    // Process deposits that have reached maturity
    private function processMaturedDeposits($customerId)
    {
        $deposits = FixedDeposit::where('customer_id', $customerId)
            ->where('status', 'active')
            ->whereDate('maturity_date', '<=', Carbon::today())
            ->get();

        foreach ($deposits as $deposit) {
            DB::transaction(function () use ($deposit) {

                $lockedDeposit = FixedDeposit::where('id', $deposit->id)
                    ->lockForUpdate()
                    ->first();

                if (!$lockedDeposit || $lockedDeposit->status !== 'active') {
                    return;
                }

                $account = Account::where('id', $lockedDeposit->account_id)
                    ->lockForUpdate()
                    ->first();

                if (!$account) {
                    return;
                }

                // Return principal plus interest to the account
                $account->increment(
                    'balance',
                    $lockedDeposit->maturity_amount
                );

                $lockedDeposit->update([
                    'status' => 'completed',
                    'completed_at' => now(),
                ]);
            });
        }
    }
}
