<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Account | BankShield</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f1f5f9;
            margin: 0;
            padding: 30px;
        }

        .container {
            max-width: 700px;
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

        label {
            display: block;
            margin-top: 18px;
            margin-bottom: 7px;
            font-weight: bold;
        }

        input, select {
            width: 100%;
            padding: 11px;
            border: 1px solid #cbd5e1;
            border-radius: 6px;
            box-sizing: border-box;
        }

        button {
            background: #15803d;
            color: white;
            border: none;
            padding: 12px 20px;
            border-radius: 6px;
            cursor: pointer;
            margin-top: 25px;
            font-size: 15px;
        }

        button:hover {
            background: #166534;
        }

        .error {
            color: #dc2626;
            font-size: 14px;
            margin-top: 5px;
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

    <h1>Create Bank Account</h1>

    @if ($errors->any())
        <div class="error">
            @foreach ($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif

    <form action="{{ route('accounts.store') }}" method="POST">
        @csrf

        <label>Select Customer</label>

        <select name="customer_id" required>
            <option value="">Choose a customer</option>

            @foreach ($customers as $customer)
                <option value="{{ $customer->id }}" {{ old('customer_id') == $customer->id ? 'selected' : '' }}>
                    {{ $customer->first_name }}
                    {{ $customer->last_name }}
                    ({{ $customer->customer_number }})
                </option>
            @endforeach
        </select>

        <label>Account Type</label>

        <select name="account_type" required>
            <option value="">Choose account type</option>
            <option value="savings" {{ old('account_type') == 'savings' ? 'selected' : '' }}>Savings</option>
            <option value="current" {{ old('account_type') == 'current' ? 'selected' : '' }}>Current</option>
        </select>

        <label>Initial Balance (৳)</label>

        <input
            type="number"
            name="balance"
            step="0.01"
            min="0"
            value="{{ old('balance', '0.00') }}"
            required
        >

        <button type="submit">Create Account</button>
    </form>

</div>

</body>
</html>
