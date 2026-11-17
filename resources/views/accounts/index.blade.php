<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bank Accounts | BankShield</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f1f5f9;
            margin: 0;
            padding: 30px;
        }

        .container {
            max-width: 1100px;
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
            margin-bottom: 25px;
        }

        .navbar h2 {
            margin: 0;
            font-size: 22px;
        }

        .navbar a {
            color: white;
            text-decoration: none;
            margin-left: 20px;
            font-weight: bold;
            padding: 9px 12px;
            border-radius: 6px;
        }

        .navbar a:hover,
        .navbar a.active {
            background: #1e40af;
        }

        h1 {
            color: #1e3a8a;
        }

        .add-button {
            display: inline-block;
            background: #15803d;
            color: white;
            padding: 10px 15px;
            border-radius: 6px;
            text-decoration: none;
            margin-bottom: 15px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            padding: 13px;
            border-bottom: 1px solid #e2e8f0;
            text-align: left;
        }

        th {
            background: #1e3a8a;
            color: white;
        }

        tr:hover {
            background: #f8fafc;
        }

        .success {
            background: #dcfce7;
            color: #166534;
            padding: 12px;
            border-radius: 6px;
            margin-bottom: 20px;
        }

        .error {
            background: #fee2e2;
            color: #991b1b;
            padding: 12px;
            border-radius: 6px;
            margin-bottom: 20px;
        }

        .freeze-button {
            background: #dc2626;
            color: white;
            border: none;
            padding: 8px 12px;
            border-radius: 6px;
            cursor: pointer;
            margin-bottom: 5px;
        }

        .unfreeze-button {
            background: #15803d;
            color: white;
            border: none;
            padding: 8px 12px;
            border-radius: 6px;
            cursor: pointer;
            margin-bottom: 5px;
        }

        .close-button {
            background: #64748b;
            color: white;
            border: none;
            padding: 8px 12px;
            border-radius: 6px;
            cursor: pointer;
        }

        .freeze-button:hover {
            background: #b91c1c;
        }

        .unfreeze-button:hover {
            background: #166534;
        }

        .close-button:hover {
            background: #475569;
        }

        .empty {
            text-align: center;
            padding: 25px;
            color: #64748b;
        }
    </style>
</head>

<body>

<div class="container">

    <div class="navbar">
        <h2>🛡️ BankShield</h2>

        <div>
            <a href="{{ route('customers.index') }}">Customers</a>
            <a href="{{ route('accounts.index') }}" class="active">Accounts</a>
        </div>
    </div>

    <h1>Bank Accounts</h1>

    @if (session('success'))
        <div class="success">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="error">
            {{ session('error') }}
        </div>
    @endif

    <a href="{{ route('accounts.create') }}" class="add-button">
        + Create Account
    </a>

    <table>
        <thead>
            <tr>
                <th>Account Number</th>
                <th>Customer</th>
                <th>Account Type</th>
                <th>Balance</th>
                <th>Status</th>
                <th>Opening Date</th>
                <th>Action</th>
            </tr>
        </thead>

        <tbody>
            @forelse ($accounts as $account)
                <tr>
                    <td>{{ $account->account_number }}</td>

                    <td>
                        {{ $account->customer->first_name }}
                        {{ $account->customer->last_name }}
                    </td>

                    <td>{{ ucfirst($account->account_type) }}</td>

                    <td>৳{{ number_format($account->balance, 2) }}</td>

                    <td>{{ ucfirst($account->status) }}</td>

                    <td>{{ $account->opened_at }}</td>

                    <td>
                        @if ($account->status === 'active')

                            <form action="{{ route('accounts.freeze', $account->id) }}" method="POST">
                                @csrf
                                @method('PATCH')

                                <button type="submit" class="freeze-button">
                                    Freeze
                                </button>
                            </form>

                            <form action="{{ route('accounts.close', $account->id) }}" method="POST"
                                  onsubmit="return confirm('Are you sure you want to close this account?');">
                                @csrf
                                @method('PATCH')

                                <button type="submit" class="close-button">
                                    Close
                                </button>
                            </form>

                        @elseif ($account->status === 'frozen')

                            <form action="{{ route('accounts.unfreeze', $account->id) }}" method="POST">
                                @csrf
                                @method('PATCH')

                                <button type="submit" class="unfreeze-button">
                                    Unfreeze
                                </button>
                            </form>

                            <form action="{{ route('accounts.close', $account->id) }}" method="POST"
                                  onsubmit="return confirm('Are you sure you want to close this account?');">
                                @csrf
                                @method('PATCH')

                                <button type="submit" class="close-button">
                                    Close
                                </button>
                            </form>

                        @else

                            Closed

                        @endif
                    </td>
                </tr>

            @empty
                <tr>
                    <td colspan="7" class="empty">
                        No accounts found.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

</div>

</body>
</html>
