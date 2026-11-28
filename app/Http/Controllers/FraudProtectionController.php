<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\FraudLog;
use App\Models\FraudCase;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class FraudProtectionController extends Controller
{
    // Display Fraud Protection Dashboard
    public function dashboard()
   {
       return view('fraud.dashboard');
   }
    // Feature 11: Check transaction for suspicious activity
    public function checkTransaction(Request $request)
    {
        $request->validate([
            'account_id' => 'required|exists:accounts,id',
            'amount' => 'required|numeric|min:1',
        ]);

        $account = Account::findOrFail($request->account_id);

        $amount = $request->amount;
        $reasons = [];

        // Rule 1: Large transaction
        if ($amount >= 50000) {
            $reasons[] = 'Unusually large transaction';
        }

        // Rule 2: Multiple flagged transactions within 10 minutes
        $recentTransactions = FraudLog::where('account_id', $account->id)
            ->where('created_at', '>=', now()->subMinutes(10))
            ->count();

        if ($recentTransactions >= 2) {
            $reasons[] = 'Multiple transactions within a short time';
        }

        // Rule 3: Unusual transaction hours (12 AM to 5 AM)
        if (now()->hour >= 0 && now()->hour < 5) {
            $reasons[] = 'Transaction attempted during unusual hours';
        }

        // If suspicious activity is detected
        if (count($reasons) > 0) {

            $plainToken = Str::random(64);

            $fraudLog = FraudLog::create([
                'account_id' => $account->id,
                'amount' => $amount,
                'reason' => implode(', ', $reasons),
                'status' => 'pending',
                'verification_token_hash' => hash('sha256', $plainToken),
                'verification_expires_at' => now()->addMinutes(30),
            ]);

            // Create a fraud case for staff investigation
            FraudCase::create([
                'fraud_log_id' => $fraudLog->id,
                'stage' => 'new',
            ]);

            return response()->json([
                'message' => 'Suspicious transaction detected. Verification is required.',
                'fraud_log_id' => $fraudLog->id,
                'verification_url' => route('fraud.verify.show', [
                    'token' => $plainToken,
                ]),
            ], 202);
        }

        return response()->json([
            'message' => 'Transaction passed the fraud checks.',
        ], 200);
    }

    // Display the customer verification page
    public function showVerification($token)
    {
        $fraudLog = FraudLog::where(
            'verification_token_hash',
            hash('sha256', $token)
        )->first();

        if (
            !$fraudLog ||
            !$fraudLog->verification_expires_at ||
            $fraudLog->verification_expires_at->isPast() ||
            $fraudLog->verified_at
        ) {
            abort(404, 'Verification link is invalid or expired.');
        }

        return view('fraud.verify', compact('fraudLog', 'token'));
    }

    // Process the customer's verification decision
    public function verifyTransaction(Request $request, $token)
    {
        $request->validate([
            'decision' => 'required|in:yes,no',
        ]);

        $fraudLog = FraudLog::where(
            'verification_token_hash',
            hash('sha256', $token)
        )->first();

        if (
            !$fraudLog ||
            !$fraudLog->verification_expires_at ||
            $fraudLog->verification_expires_at->isPast() ||
            $fraudLog->verified_at
        ) {
            abort(404, 'Verification link is invalid or expired.');
        }

        $fraudLog->verified_at = now();
        $fraudLog->verification_token_hash = null;

        if ($request->decision === 'yes') {

            $fraudLog->status = 'confirmed';

        } else {

            $fraudLog->status = 'denied';

            // Freeze the account if the customer denies the transaction
            $fraudLog->account->update([
                'status' => 'frozen',
            ]);
        }

        $fraudLog->save();

        return view('fraud.verification-result', compact('fraudLog'));
    }

    // Feature 12: Display the fraud case board
    public function index()
    {
        $cases = FraudCase::with([
            'fraudLog.account.customer',
            'assignedStaff'
        ])->orderBy('created_at', 'desc')->get();

        return view('fraud.board', compact('cases'));
    }

    // Update fraud case stage and investigation notes
    public function updateCase(Request $request, FraudCase $fraudCase)
    {
        $validated = $request->validate([
            'stage' => 'required|in:new,under_investigation,resolved',
            'investigation_notes' => 'nullable|string|max:2000',
        ]);

        $fraudCase->update($validated);

        return redirect()
            ->route('fraud.board')
            ->with('success', 'Fraud case updated successfully.');
    }
}
