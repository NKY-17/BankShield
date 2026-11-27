<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Fixed Deposits | BankShield</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f1f5f9;
            margin: 0;
            padding: 30px;
        }

        .container {
            max-width: 1300px;
            margin: auto;
            background: white;
            padding: 30px;
            border-radius: 12px;
        }

        .navbar {
            background: #142d59;
            color: white;
            padding: 15px 25px;
            border-radius: 10px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 15px;
            margin-bottom: 25px;
        }

        .navbar h2 {
            margin: 0;
            font-size: 22px;
        }

        .navbar a {
            color: white;
            text-decoration: none;
            margin-left: 10px;
            font-weight: bold;
            padding: 9px 12px;
            border-radius: 6px;
        }

        .navbar a.active,
        .navbar a:hover {
            background: #1e40af;
        }

        .navbar form {
            display: inline;
        }

        .logout-button {
            background: #dc2626;
            color: white;
            border: none;
            margin-left: 10px;
            padding: 10px 15px;
            border-radius: 6px;
            cursor: pointer;
            font-weight: bold;
        }

        h1 {
            color: #1e3a8a;
        }

        .top-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 15px;
            margin-bottom: 25px;
        }

        .add-button {
            background: #1e40af;
            color: white;
            padding: 11px 16px;
            text-decoration: none;
            border-radius: 6px;
            font-weight: bold;
        }

        .summary {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
            gap: 15px;
            margin-bottom: 25px;
        }

        .summary-card {
            background: #eff6ff;
            padding: 18px;
            border-radius: 8px;
            border-left: 4px solid #1e40af;
        }

        .summary-card p {
            margin: 0;
            color: #475569;
        }

        .summary-card h2 {
            margin-bottom: 0;
            color: #1e3a8a;
        }

        .table-wrapper {
            overflow-x: auto;
        }

        table {
            width: 100%;
            min-width: 1050px;
            border-collapse: collapse;
        }

        th, td {
            padding: 13px;
            text-align: left;
            border-bottom: 1px solid #e2e8f0;
        }

        th {
            background: #eff6ff;
            color: #1e3a8a;
        }

        tr:hover {
            background: #f8fafc;
        }

        .status {
            padding: 6px 11px;
            border-radius: 20px;
            font-size: 13px;
            font-weight: bold;
        }

        .active-status {
            background: #dbeafe;
            color: #1d4ed8;
        }

        .completed-status {
            background: #dcfce7;
            color: #166534;
        }

        .success {
            background: #dcfce7;
            color: #166534;
            padding: 12px;
            border-radius: 6px;
            margin-bottom: 18px;
        }

        .empty {
            background: #f8fafc;
            padding: 35px;
            text-align: center;
            border-radius: 8px;
        }

        @media (max-width: 600px) {
            body {
                padding: 10px;
            }

            .container {
                padding: 15px;
            }
        }
    </style>
</head>

<body>
<div class="container">

    <div class="navbar">
        <h2>🛡️ BankShield</h2>

        <div>
            <a href="{{ route('fixed-deposits.index') }}" class="active">
                My Fixed Deposits
            </a>

            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="logout-button">
                    Logout
                </button>
            </form>
        </div>
    </div>

    <div class="top-bar">
        <div>
            <h1>My Fixed Deposits</h1>
            <p>View your active and completed fixed deposits.</p>
        </div>

        <a href="{{ route('fixed-deposits.create') }}" class="add-button">
            + Open New Fixed Deposit
        </a>
    </div>

    @if (session('success'))
        <div class="success">
            {{ session('success') }}
        </div>
    @endif

    @if ($fixedDeposits->isEmpty())

        <div class="empty">
            <h2>No Fixed Deposits Yet</h2>
            <p>You have not opened any fixed deposits.</p>
            <a href="{{ route('fixed-deposits.create') }}" class="add-button">
                Open Your First Fixed Deposit
            </a>
        </div>

    @else

        <div class="summary">
            <div class="summary-card">
                <p>Total Deposits</p>
                <h2>{{ $fixedDeposits->count() }}</h2>
            </div>

            <div class="summary-card">
                <p>Active Deposits</p>
                <h2>{{ $fixedDeposits->where('status', 'active')->count() }}</h2>
            </div>

            <div class="summary-card">
                <p>Completed Deposits</p>
                <h2>{{ $fixedDeposits->where('status', 'completed')->count() }}</h2>
            </div>
        </div>

        <div class="table-wrapper">
            <table>
                <thead>
                    <tr>
                        <th>Deposit Number</th>
                        <th>Account Number</th>
                        <th>Principal</th>
                        <th>Duration</th>
                        <th>Rate</th>
                        <th>Expected Interest</th>
                        <th>Maturity Amount</th>
                        <th>Start Date</th>
                        <th>Maturity Date</th>
                        <th>Status</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($fixedDeposits as $deposit)
                        <tr>
                            <td>{{ $deposit->deposit_number }}</td>

                            <td>{{ $deposit->account->account_number ?? 'N/A' }}</td>

                            <td>৳{{ number_format($deposit->principal_amount, 2) }}</td>

                            <td>{{ $deposit->duration_months }} Months</td>

                            <td>{{ number_format($deposit->interest_rate, 2) }}%</td>

                            <td>৳{{ number_format($deposit->expected_interest, 2) }}</td>

                            <td>
                                <strong>৳{{ number_format($deposit->maturity_amount, 2) }}</strong>
                            </td>

                            <td>{{ $deposit->start_date->format('d M Y') }}</td>

                            <td>{{ $deposit->maturity_date->format('d M Y') }}</td>

                            <td>
                                @if ($deposit->status === 'active')
                                    <span class="status active-status">Active</span>
                                @else
                                    <span class="status completed-status">Completed</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    @endif

</div>
</body>
</html>
