<!DOCTYPE html>
<html>
<head>
    <title>Verification Result - BankShield</title>
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

        .success {
            color: #15803d;
        }

        .danger {
            color: #dc2626;
        }
    </style>
</head>
<body>

<div class="container">

    @if($fraudLog->status === 'confirmed')

        <h2 class="success">Transaction Confirmed</h2>

        <p>You confirmed that this transaction was made by you.</p>

        <p>Your account remains active.</p>

    @else

        <h2 class="danger">Transaction Denied</h2>

        <p>You reported that this transaction was not made by you.</p>

        <p>Your account has been frozen for security.</p>

        <p>Please contact bank support for further assistance.</p>

    @endif

    <p>Thank you for using BankShield.</p>

</div>

</body>
</html>
