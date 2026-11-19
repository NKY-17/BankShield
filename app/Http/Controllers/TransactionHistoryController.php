<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TransactionHistoryController extends Controller
{
    public function index(Request $request)
    {
        // Demo data only. Replace this array with database records during integration.
        $allTransactions = [
            ['id'=>'TXN1001','date'=>'2026-11-15','description'=>'Grocery Shopping','type'=>'Debit','amount'=>2500,'status'=>'Completed'],
            ['id'=>'TXN1002','date'=>'2026-11-14','description'=>'Salary Deposit','type'=>'Credit','amount'=>45000,'status'=>'Completed'],
            ['id'=>'TXN1003','date'=>'2026-11-12','description'=>'Electricity Bill','type'=>'Debit','amount'=>1800,'status'=>'Completed'],
            ['id'=>'TXN1004','date'=>'2026-11-10','description'=>'Online Shopping','type'=>'Debit','amount'=>3200,'status'=>'Pending'],
            ['id'=>'TXN1005','date'=>'2026-11-08','description'=>'Fund Transfer Received','type'=>'Credit','amount'=>12000,'status'=>'Completed'],
            ['id'=>'TXN1006','date'=>'2026-11-05','description'=>'Mobile Recharge','type'=>'Debit','amount'=>500,'status'=>'Completed'],
            ['id'=>'TXN1007','date'=>'2026-11-03','description'=>'Freelance Payment','type'=>'Credit','amount'=>8500,'status'=>'Completed'],
            ['id'=>'TXN1008','date'=>'2026-11-01','description'=>'Restaurant Payment','type'=>'Debit','amount'=>1500,'status'=>'Completed'],
            ['id'=>'TXN1009','date'=>'2026-10-28','description'=>'Cash Deposit','type'=>'Credit','amount'=>20000,'status'=>'Completed'],
            ['id'=>'TXN1010','date'=>'2026-10-25','description'=>'Internet Bill','type'=>'Debit','amount'=>1200,'status'=>'Completed'],
            ['id'=>'TXN1011','date'=>'2026-10-22','description'=>'Book Purchase','type'=>'Debit','amount'=>950,'status'=>'Completed'],
            ['id'=>'TXN1012','date'=>'2026-10-20','description'=>'Scholarship Deposit','type'=>'Credit','amount'=>15000,'status'=>'Completed'],
            ['id'=>'TXN1013','date'=>'2026-10-18','description'=>'Pharmacy Payment','type'=>'Debit','amount'=>750,'status'=>'Completed'],
            ['id'=>'TXN1014','date'=>'2026-10-15','description'=>'Tuition Payment Received','type'=>'Credit','amount'=>6000,'status'=>'Completed'],
            ['id'=>'TXN1015','date'=>'2026-10-12','description'=>'Transport Expense','type'=>'Debit','amount'=>650,'status'=>'Completed'],
            ['id'=>'TXN1016','date'=>'2026-10-09','description'=>'ATM Cash Withdrawal','type'=>'Debit','amount'=>5000,'status'=>'Completed'],
            ['id'=>'TXN1017','date'=>'2026-10-06','description'=>'Fund Transfer Received','type'=>'Credit','amount'=>7500,'status'=>'Completed'],
            ['id'=>'TXN1018','date'=>'2026-10-04','description'=>'Water Bill','type'=>'Debit','amount'=>450,'status'=>'Pending'],
            ['id'=>'TXN1019','date'=>'2026-10-02','description'=>'Online Shopping Refund','type'=>'Credit','amount'=>1800,'status'=>'Completed'],
            ['id'=>'TXN1020','date'=>'2026-10-01','description'=>'Restaurant Payment','type'=>'Debit','amount'=>2200,'status'=>'Completed'],
        ];

        $transactions = $allTransactions;
        $search = trim((string) $request->query('search', ''));

        if ($search !== '') {
            $needle = mb_strtolower($search);
            $transactions = array_filter($transactions, function ($t) use ($needle) {
                return str_contains(mb_strtolower($t['id']), $needle)
                    || str_contains(mb_strtolower($t['description']), $needle);
            });
        }

        $type = $request->query('type', '');
        if (in_array($type, ['Credit', 'Debit'], true)) {
            $transactions = array_filter($transactions, fn ($t) => $t['type'] === $type);
        } else {
            $type = '';
        }

        $from = $request->query('from', '');
        $to = $request->query('to', '');
        if ($from !== '') {
            $transactions = array_filter($transactions, fn ($t) => $t['date'] >= $from);
        }
        if ($to !== '') {
            $transactions = array_filter($transactions, fn ($t) => $t['date'] <= $to);
        }

        $minAmount = $request->query('min_amount', '');
        $maxAmount = $request->query('max_amount', '');
        if ($minAmount !== '' && is_numeric($minAmount)) {
            $transactions = array_filter($transactions, fn ($t) => $t['amount'] >= (float) $minAmount);
        } else {
            $minAmount = '';
        }
        if ($maxAmount !== '' && is_numeric($maxAmount)) {
            $transactions = array_filter($transactions, fn ($t) => $t['amount'] <= (float) $maxAmount);
        } else {
            $maxAmount = '';
        }

        $sort = $request->query('sort', 'newest');
        if (!in_array($sort, ['newest', 'oldest', 'highest', 'lowest'], true)) {
            $sort = 'newest';
        }

        usort($transactions, function ($a, $b) use ($sort) {
            return match ($sort) {
                'oldest' => strcmp($a['date'], $b['date']),
                'highest' => $b['amount'] <=> $a['amount'],
                'lowest' => $a['amount'] <=> $b['amount'],
                default => strcmp($b['date'], $a['date']),
            };
        });

        $totalTransactions = count($transactions);
        $totalCredits = array_sum(array_map(fn ($t) => $t['type'] === 'Credit' ? $t['amount'] : 0, $transactions));
        $totalDebits = array_sum(array_map(fn ($t) => $t['type'] === 'Debit' ? $t['amount'] : 0, $transactions));

        return view('transactions.index', compact(
            'transactions', 'allTransactions', 'totalTransactions',
            'totalCredits', 'totalDebits', 'search', 'type', 'sort',
            'from', 'to', 'minAmount', 'maxAmount'
        ));
    }
}
