<!DOCTYPE html>
<html>
<head>
    <title>Was This You? - BankShield</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f1f5f9;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
        }

        .container {
            background: white;
            padding: 35px;
            border-radius: 12px;
            width: 90%;
            max-width: 430px;
            text-align: center;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }

        h2 {
            color: #173b67;
        }

        .amount {
            font-size: 28px;
            font-weight: bold;
            color: #dc2626;
            margin: 20px 0;
        }

        .reason {
            background: #fff7ed;
            padding: 12px;
            border-radius: 8px;
            color: #9a3412;
            margin: 15px 0;
        }

        button {
            width: 100%;
            padding: 13px;
            border: none;
            border-radius: 7px;
            margin-top: 12px;
            font-size: 16px;
            cursor: pointer;
        }

        .yes {
            background: #15803d;
            color: white;
        }

        .no {
            background: #dc2626;
            color: white;
        }
    </style>
</head>
<body>

<div class="container">

    <h2>BankShield Security Alert</h2>

    <p>We detected a suspicious transaction on your account.</p>

    <div class="amount">
        ৳{{ number_format($fraudLog->amount, 2) }}
    </div>

    <div class="reason">
        {{ $fraudLog->reason }}
    </div>

    <h3>Was this transaction made by you?</h3>

    <form method="POST" action="{{ route('fraud.verify.submit', ['token' => $token]) }}">
        @csrf

        <button type="submit" name="decision" value="yes" class="yes">
            Yes, This Was Me
        </button>

        <button type="submit" name="decision" value="no" class="no">
            No, This Was Not Me
        </button>
    </form>

    <p style="color: #64748b; font-size: 12px; margin-top: 20px;">
        This verification link expires after 30 minutes.
    </p>

</div>

</body>
</html>
