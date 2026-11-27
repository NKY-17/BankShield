<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Open Fixed Deposit | BankShield</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f1f5f9;
            margin: 0;
            padding: 30px;
        }

        .container {
            max-width: 900px;
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

        label {
            display: block;
            font-weight: bold;
            margin-bottom: 8px;
            color: #334155;
        }

        input, select {
            display: block;
            width: 100%;
            padding: 12px;
            border: 1px solid #cbd5e1;
            border-radius: 6px;
            box-sizing: border-box;
            font-size: 15px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .info-box {
            background: #eff6ff;
            border-left: 4px solid #1e40af;
            padding: 15px;
            border-radius: 6px;
            margin-bottom: 22px;
        }

        .preview-box {
            background: #f8fafc;
            padding: 20px;
            border-radius: 8px;
            margin: 25px 0;
        }

        .preview-box h3 {
            color: #1e3a8a;
            margin-top: 0;
        }

        .preview-box p {
            display: flex;
            justify-content: space-between;
            gap: 10px;
        }

        .submit-button {
            background: #1e40af;
            color: white;
            border: none;
            padding: 12px 20px;
            border-radius: 6px;
            cursor: pointer;
            font-weight: bold;
            font-size: 15px;
        }

        .submit-button:hover {
            background: #1e3a8a;
        }

        .submit-button:disabled {
            background: #94a3b8;
            cursor: not-allowed;
        }

        .cancel-button {
            display: inline-block;
            margin-left: 12px;
            color: #1e40af;
            text-decoration: none;
            font-weight: bold;
        }

        .error-box {
            background: #fee2e2;
            color: #991b1b;
            padding: 12px;
            border-radius: 6px;
            margin-bottom: 20px;
        }

        .muted {
            color: #64748b;
            font-size: 13px;
        }

        @media (max-width: 600px) {
            body {
                padding: 10px;
            }

            .container {
                padding: 18px;
            }
        }
    </style>
</head>

<body>
<div class="container">

    <div class="navbar">
        <h2>🛡️ BankShield</h2>

        <div>
            <a href="{{ route('fixed-deposits.index') }}">
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

    <h1>Open a Fixed Deposit</h1>
    <p>Choose your bank account and deposit duration.</p>

    <div class="info-box">
        <strong>Annual Interest Rate: 8%</strong>
    </div>

    @if ($errors->any())
        <div class="error-box">
            <strong>Please correct the following:</strong>
            @foreach ($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif

    @if ($accounts->isEmpty())
        <div class="error-box">
            You do not have an active account available for a fixed deposit. Please contact bank staff.
        </div>
    @endif

    <form method="POST" action="{{ route('fixed-deposits.store') }}">
        @csrf

        <div class="form-group">
            <label for="account_id">Select Bank Account</label>

            <select name="account_id" id="account_id" required>
                <option value="">Choose an account</option>

                @foreach ($accounts as $account)
                    <option
                        value="{{ $account->id }}"
                        data-balance="{{ $account->balance }}"
                        {{ old('account_id') == $account->id ? 'selected' : '' }}
                    >
                        {{ $account->account_number }}
                        ({{ ucfirst($account->account_type) }})
                        - Available: ৳{{ number_format($account->balance, 2) }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="principal_amount">Deposit Amount (৳)</label>

            <input
                type="number"
                name="principal_amount"
                id="principal_amount"
                min="1"
                step="0.01"
                value="{{ old('principal_amount') }}"
                placeholder="Enter deposit amount"
                required
            >

            <p id="balance-info" class="muted">
                Select an account to see its available balance.
            </p>
        </div>

        <div class="form-group">
            <label for="duration_months">Deposit Duration</label>

            <select name="duration_months" id="duration_months" required>
                <option value="">Choose duration</option>
                <option value="3" {{ old('duration_months') == '3' ? 'selected' : '' }}>3 Months</option>
                <option value="6" {{ old('duration_months') == '6' ? 'selected' : '' }}>6 Months</option>
                <option value="12" {{ old('duration_months') == '12' ? 'selected' : '' }}>12 Months</option>
            </select>
        </div>

        <div class="preview-box">
            <h3>Estimated Returns</h3>

            <p>
                <span>Expected Interest:</span>
                <strong id="expected-interest">৳0.00</strong>
            </p>

            <p>
                <span>Maturity Amount:</span>
                <strong id="maturity-amount">৳0.00</strong>
            </p>

            <p class="muted">
                The final values are calculated and verified by the server.
            </p>
        </div>

        <button
            type="submit"
            class="submit-button"
            {{ $accounts->isEmpty() ? 'disabled' : '' }}
        >
            Open Fixed Deposit
        </button>

        <a href="{{ route('fixed-deposits.index') }}" class="cancel-button">
            Cancel
        </a>
    </form>

</div>

<script>
    const accountSelect = document.getElementById('account_id');
    const amountInput = document.getElementById('principal_amount');
    const durationSelect = document.getElementById('duration_months');

    function updatePreview() {
        const selectedAccount = accountSelect.options[accountSelect.selectedIndex];
        const balance = parseFloat(selectedAccount.dataset.balance || 0);
        const amount = parseFloat(amountInput.value || 0);
        const duration = parseInt(durationSelect.value || 0);

        document.getElementById('balance-info').textContent =
            accountSelect.value
                ? 'Available balance: ৳' + balance.toFixed(2)
                : 'Select an account to see its available balance.';

        const interest = amount > 0 && duration > 0
            ? amount * 0.08 * (duration / 12)
            : 0;

        document.getElementById('expected-interest').textContent =
            '৳' + interest.toFixed(2);

        document.getElementById('maturity-amount').textContent =
            '৳' + (amount + interest).toFixed(2);
    }

    accountSelect.addEventListener('change', updatePreview);
    amountInput.addEventListener('input', updatePreview);
    durationSelect.addEventListener('change', updatePreview);

    updatePreview();
</script>

</body>
</html>
