<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BankShield - Transaction History</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        /* Primary button: Apply Filters */
        .btn-apply {
            background: linear-gradient(135deg, #2563eb, #1d4ed8);
            color: #ffffff;
            border: none;
            padding: 14px 36px;
            font-size: 16px;
            font-weight: 700;
            border-radius: 12px;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            box-shadow: 0 6px 16px rgba(37, 99, 235, 0.4);
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }
        .btn-apply:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 22px rgba(37, 99, 235, 0.5);
        }
        .btn-apply:active {
            transform: translateY(0);
            box-shadow: 0 3px 8px rgba(37, 99, 235, 0.4);
        }
        .btn-apply:focus-visible {
            outline: 3px solid #93c5fd;
            outline-offset: 2px;
        }

        /* Secondary button: Clear Filters */
        .btn-clear {
            background-color: #f3f4f6;
            color: #374151;
            padding: 14px 28px;
            font-size: 16px;
            font-weight: 600;
            border-radius: 12px;
            border: 1px solid #d1d5db;
            display: inline-flex;
            align-items: center;
            transition: background-color 0.2s ease;
        }
        .btn-clear:hover {
            background-color: #e5e7eb;
        }

        /* Monthly statement cards */
        .statement-card {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            border: 1px solid #e5e7eb;
            border-radius: 14px;
            padding: 20px 24px;
            margin-bottom: 16px;
            background: #ffffff;
            transition: box-shadow 0.2s ease, border-color 0.2s ease;
        }
        .statement-card:last-child {
            margin-bottom: 0;
        }
        .statement-card:hover {
            border-color: #bfdbfe;
            box-shadow: 0 6px 18px rgba(37, 99, 235, 0.12);
        }
        .statement-info {
            display: flex;
            align-items: center;
            gap: 16px;
        }
        .statement-icon {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            background: #eff6ff;
            color: #2563eb;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }
        .statement-card h4 {
            font-size: 18px;
            font-weight: 700;
            color: #111827;
            margin: 0;
        }
        .statement-card p {
            font-size: 14px;
            color: #6b7280;
            margin: 4px 0 0;
        }

        /* Download PDF button */
        .btn-download {
            background: linear-gradient(135deg, #2563eb, #1d4ed8);
            color: #ffffff;
            border: none;
            padding: 14px 30px;
            font-size: 16px;
            font-weight: 700;
            border-radius: 12px;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            box-shadow: 0 6px 16px rgba(37, 99, 235, 0.4);
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }
        .btn-download svg {
            transition: transform 0.2s ease;
        }
        .btn-download:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 22px rgba(37, 99, 235, 0.5);
        }
        .btn-download:hover svg {
            transform: translateY(2px);
        }
        .btn-download:active {
            transform: translateY(0);
            box-shadow: 0 3px 8px rgba(37, 99, 235, 0.4);
        }
        .btn-download:focus-visible {
            outline: 3px solid #93c5fd;
            outline-offset: 2px;
        }

        @media print {
            body * {
                visibility: hidden;
            }
            #statement-print,
            #statement-print * {
                visibility: visible;
            }
            #statement-print {
                display: block !important;
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
                padding: 24px;
                color: #111827;
            }
            .no-print {
                display: none !important;
            }
        }
    </style>
</head>
<body class="bg-slate-100 min-h-screen">
<div class="max-w-7xl mx-auto p-4 md:p-6">
    <!-- Header -->
    <header class="bg-blue-950 text-white p-6 rounded-xl mb-7 no-print">
        <h1 class="text-3xl font-bold">BankShield</h1>
        <p class="text-blue-200 mt-1">
            Transaction History &amp; Statements
        </p>
        <p class="text-sm text-blue-200 mt-4">
            Customer Banking Portal · Demonstration data
        </p>
    </header>
    <!-- Page Title -->
    <div class="mb-6 no-print">
        <h2 class="text-2xl font-bold text-gray-800">
            Transaction History
        </h2>
        <p class="text-gray-500 mt-1">
            Search, filter, sort and review your transactions.
        </p>
        <p class="text-amber-700 text-sm mt-2">
            These 20 records are sample data for the F19 demonstration,
            not real bank transactions.
        </p>
    </div>
    <!-- Summary Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-5 mb-7 no-print">
        <div class="bg-white rounded-xl shadow-sm p-5">
            <p class="text-gray-500 text-sm">Transactions Found</p>
            <h3 class="text-3xl font-bold text-blue-900 mt-2">
                {{ $totalTransactions }}
            </h3>
        </div>
        <div class="bg-white rounded-xl shadow-sm p-5">
            <p class="text-gray-500 text-sm">Total Credits Found</p>
            <h3 class="text-2xl font-bold text-green-600 mt-2">
                ৳{{ number_format($totalCredits, 2) }}
            </h3>
        </div>
        <div class="bg-white rounded-xl shadow-sm p-5">
            <p class="text-gray-500 text-sm">Total Debits Found</p>
            <h3 class="text-2xl font-bold text-red-600 mt-2">
                ৳{{ number_format($totalDebits, 2) }}
            </h3>
        </div>
    </div>
    <!-- Search and Filters -->
    <section class="bg-white rounded-xl shadow-sm p-6 mb-7 no-print">
        <h3 class="font-bold text-lg mb-5">
            Search &amp; Filter Transactions
        </h3>
        <form action="{{ route('transactions.index') }}" method="GET">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <!-- Search -->
                <div>
                    <label for="search" class="block text-sm font-medium mb-2">
                        Search
                    </label>
                    <input
                        id="search"
                        name="search"
                        type="text"
                        value="{{ $search }}"
                        placeholder="Transaction ID or description"
                        class="w-full border rounded-lg p-3"
                    >
                </div>
                <!-- Transaction Type -->
                <div>
                    <label for="type" class="block text-sm font-medium mb-2">
                        Transaction Type
                    </label>
                    <select
                        id="type"
                        name="type"
                        class="w-full border rounded-lg p-3"
                    >
                        <option value="">All Types</option>
                        <option value="Credit"
                            {{ $type === 'Credit' ? 'selected' : '' }}>
                            Credit
                        </option>
                        <option value="Debit"
                            {{ $type === 'Debit' ? 'selected' : '' }}>
                            Debit
                        </option>
                    </select>
                </div>
                <!-- Sorting -->
                <div>
                    <label for="sort" class="block text-sm font-medium mb-2">
                        Sort By
                    </label>
                    <select
                        id="sort"
                        name="sort"
                        class="w-full border rounded-lg p-3"
                    >
                        <option value="newest"
                            {{ $sort === 'newest' ? 'selected' : '' }}>
                            Newest First
                        </option>
                        <option value="oldest"
                            {{ $sort === 'oldest' ? 'selected' : '' }}>
                            Oldest First
                        </option>
                        <option value="highest"
                            {{ $sort === 'highest' ? 'selected' : '' }}>
                            Highest Amount
                        </option>
                        <option value="lowest"
                            {{ $sort === 'lowest' ? 'selected' : '' }}>
                            Lowest Amount
                        </option>
                    </select>
                </div>
                <!-- From Date -->
                <div>
                    <label for="from" class="block text-sm font-medium mb-2">
                        From Date
                    </label>
                    <input
                        id="from"
                        type="date"
                        name="from"
                        value="{{ $from }}"
                        class="w-full border rounded-lg p-3"
                    >
                </div>
                <!-- To Date -->
                <div>
                    <label for="to" class="block text-sm font-medium mb-2">
                        To Date
                    </label>
                    <input
                        id="to"
                        type="date"
                        name="to"
                        value="{{ $to }}"
                        class="w-full border rounded-lg p-3"
                    >
                </div>
                <!-- Minimum Amount -->
                <div>
                    <label for="min_amount" class="block text-sm font-medium mb-2">
                        Minimum Amount (৳)
                    </label>
                    <input
                        id="min_amount"
                        type="number"
                        name="min_amount"
                        min="0"
                        step="0.01"
                        value="{{ $minAmount }}"
                        placeholder="Minimum amount"
                        class="w-full border rounded-lg p-3"
                    >
                </div>
                <!-- Maximum Amount -->
                <div>
                    <label for="max_amount" class="block text-sm font-medium mb-2">
                        Maximum Amount (৳)
                    </label>
                    <input
                        id="max_amount"
                        type="number"
                        name="max_amount"
                        min="0"
                        step="0.01"
                        value="{{ $maxAmount }}"
                        placeholder="Maximum amount"
                        class="w-full border rounded-lg p-3"
                    >
                </div>
            </div>
            <!-- Action Buttons -->
            <div class="flex flex-wrap items-center gap-4 mt-6">
                <!-- Apply Filters Button -->
                <button type="submit" class="btn-apply">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                         fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M3 4h18l-7 8v6l-4 2v-8L3 4z" />
                    </svg>
                    Apply Filters
                </button>
                <!-- Clear Filters Button -->
                <a href="{{ route('transactions.index') }}" class="btn-clear">
                    Clear Filters
                </a>
            </div>
        </form>
    </section>
    <!-- Transaction Table -->
    <section class="bg-white rounded-xl shadow-sm overflow-hidden mb-7 no-print">
        <div class="p-6 border-b">
            <h3 class="font-bold text-lg">All Transactions</h3>
            <p class="text-gray-500 text-sm mt-1">
                Showing {{ $totalTransactions }} matching transactions
                out of {{ count($allTransactions) }} sample records
            </p>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="bg-slate-100 text-gray-600">
                    <tr>
                        <th class="p-4">Transaction ID</th>
                        <th class="p-4">Date</th>
                        <th class="p-4">Description</th>
                        <th class="p-4">Type</th>
                        <th class="p-4">Amount</th>
                        <th class="p-4">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                    @forelse($transactions as $transaction)
                        <tr class="hover:bg-slate-50">
                            <td class="p-4 font-semibold text-blue-800">
                                {{ $transaction['id'] }}
                            </td>
                            <td class="p-4 whitespace-nowrap">
                                {{ $transaction['date'] }}
                            </td>
                            <td class="p-4">
                                {{ $transaction['description'] }}
                            </td>
                            <td class="p-4">
                                @if($transaction['type'] === 'Credit')
                                    <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs font-semibold">
                                        Credit
                                    </span>
                                @else
                                    <span class="bg-red-100 text-red-700 px-3 py-1 rounded-full text-xs font-semibold">
                                        Debit
                                    </span>
                                @endif
                            </td>
                            <td class="p-4 font-semibold whitespace-nowrap">
                                @if($transaction['type'] === 'Credit')
                                    <span class="text-green-600">
                                        +৳{{ number_format($transaction['amount'], 2) }}
                                    </span>
                                @else
                                    <span class="text-red-600">
                                        -৳{{ number_format($transaction['amount'], 2) }}
                                    </span>
                                @endif
                            </td>
                            <td class="p-4">
                                <span class="px-3 py-1 rounded-full text-xs font-semibold
                                    {{ $transaction['status'] === 'Completed'
                                        ? 'bg-green-100 text-green-700'
                                        : 'bg-yellow-100 text-yellow-700' }}">
                                    {{ $transaction['status'] }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="p-10 text-center text-gray-500">
                                No transactions found. Try changing your search or filters.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>
    <!-- Monthly Statements -->
    <section class="bg-white rounded-xl shadow-sm p-6 mb-7 no-print">
        <h3 class="text-xl font-bold mb-2">
            Monthly Account Statements
        </h3>
        <p class="text-gray-500 text-sm mb-5">
            Download or print your monthly account statements as PDF.
        </p>

        <!-- November -->
        <div class="statement-card">
            <div class="statement-info">
                <div class="statement-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                         fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                </div>
                <div>
                    <h4>November 2026</h4>
                    <p>Monthly account statement</p>
                </div>
            </div>

            <button type="button" class="btn-download" onclick="printStatement('2026-11')">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                     fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M12 3v12m0 0l-4-4m4 4l4-4M4 17v2a2 2 0 002 2h12a2 2 0 002-2v-2" />
                </svg>
                Download PDF
            </button>
        </div>

        <!-- October -->
        <div class="statement-card">
            <div class="statement-info">
                <div class="statement-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                         fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                </div>
                <div>
                    <h4>October 2026</h4>
                    <p>Monthly account statement</p>
                </div>
            </div>

            <button type="button" class="btn-download" onclick="printStatement('2026-10')">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                     fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M12 3v12m0 0l-4-4m4 4l4-4M4 17v2a2 2 0 002 2h12a2 2 0 002-2v-2" />
                </svg>
                Download PDF
            </button>
        </div>
    </section>
    <!-- Printable Statement -->
    <section id="statement-print" class="hidden">
        <div class="border-b-2 border-blue-900 pb-5 mb-6">
            <h1 class="text-3xl font-bold text-blue-950">
                BANKSHIELD
            </h1>
            <h2 class="text-xl font-semibold mt-4">
                Monthly Account Statement
            </h2>
            <p id="statement-period" class="mt-2"></p>
            <p>Account Holder: Demo Customer</p>
        </div>
        <div class="grid grid-cols-3 gap-4 mb-7">
            <div class="border p-4 rounded-lg">
                <p class="text-sm">Total Credits</p>
                <h3 id="statement-credits" class="font-bold text-xl"></h3>
            </div>
            <div class="border p-4 rounded-lg">
                <p class="text-sm">Total Debits</p>
                <h3 id="statement-debits" class="font-bold text-xl"></h3>
            </div>
            <div class="border p-4 rounded-lg">
                <p class="text-sm">Net Movement</p>
                <h3 id="statement-net" class="font-bold text-xl"></h3>
            </div>
        </div>
        <h3 class="font-bold text-lg mb-3">
            Transaction Details
        </h3>
        <table class="w-full border-collapse text-sm">
            <thead>
                <tr class="bg-gray-100">
                    <th class="border p-3 text-left">Date</th>
                    <th class="border p-3 text-left">ID</th>
                    <th class="border p-3 text-left">Description</th>
                    <th class="border p-3 text-left">Type</th>
                    <th class="border p-3 text-right">Amount</th>
                </tr>
            </thead>
            <tbody id="statement-rows"></tbody>
        </table>
        <p class="text-xs text-gray-500 mt-8">
            Demonstration statement generated using sample data.
            Not an official bank statement.
        </p>
    </section>
    <!-- Footer -->
    <footer class="text-center text-gray-500 text-sm py-5 no-print">
        © {{ date('Y') }} BankShield. All rights reserved.
    </footer>
</div>
<script>
const allTransactions = @json($allTransactions);
function printStatement(month) {
    const rows = allTransactions.filter(t => t.date.startsWith(month));
    const credits = rows
        .filter(t => t.type === 'Credit')
        .reduce((sum, t) => sum + Number(t.amount), 0);
    const debits = rows
        .filter(t => t.type === 'Debit')
        .reduce((sum, t) => sum + Number(t.amount), 0);
    const [year, monthNumber] = month.split('-').map(Number);
    const monthName = new Date(year, monthNumber - 1, 1)
        .toLocaleString('en-US', { month: 'long' });
    document.getElementById('statement-period').textContent =
        `Statement Period: ${monthName} 1 – ${new Date(year, monthNumber, 0).getDate()}, ${year}`;
    document.getElementById('statement-credits').textContent =
        '৳' + credits.toLocaleString('en-BD', {minimumFractionDigits: 2});
    document.getElementById('statement-debits').textContent =
        '৳' + debits.toLocaleString('en-BD', {minimumFractionDigits: 2});
    document.getElementById('statement-net').textContent =
        '৳' + (credits - debits).toLocaleString('en-BD', {minimumFractionDigits: 2});
    document.getElementById('statement-rows').innerHTML = rows.map(t =>
        `<tr>
            <td class="border p-3">${t.date}</td>
            <td class="border p-3">${t.id}</td>
            <td class="border p-3">${t.description}</td>
            <td class="border p-3">${t.type}</td>
            <td class="border p-3 text-right">
                ৳${Number(t.amount).toLocaleString('en-BD', {minimumFractionDigits: 2})}
            </td>
        </tr>`
    ).join('');
    window.print();
}
</script>
</body>
</html>