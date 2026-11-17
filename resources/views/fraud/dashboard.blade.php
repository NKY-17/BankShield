<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fraud Dashboard | BankShield</title>

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
        }

        .navbar {
            background: #142d59;
            color: white;
            padding: 18px 25px;
            border-radius: 10px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .navbar h2 {
            margin: 0;
        }

        .navbar a {
            color: white;
            text-decoration: none;
            margin-left: 15px;
            font-weight: bold;
        }

        .logout-button {
            background: #dc2626;
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 6px;
            cursor: pointer;
        }

        h1 {
            color: #1e3a8a;
            margin-top: 30px;
        }

        .description {
            color: #64748b;
            margin-bottom: 30px;
        }

        .cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 25px;
        }

        .card {
            background: white;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.08);
        }

        .card h2 {
            color: #1e3a8a;
        }

        .card p {
            color: #64748b;
            line-height: 1.6;
        }

        .card a {
            display: inline-block;
            margin-top: 15px;
            background: #1e40af;
            color: white;
            padding: 11px 18px;
            border-radius: 6px;
            text-decoration: none;
            font-weight: bold;
        }

        .card a:hover {
            background: #1e3a8a;
        }
    </style>
</head>

<body>

<div class="container">

    <div class="navbar">
        <h2>BankShield | Fraud Protection</h2>

        <div>
            <a href="{{ route('customers.index') }}">Customers</a>

            <form action="{{ route('logout') }}" method="POST" style="display:inline;">
                @csrf
                <button type="submit" class="logout-button">Logout</button>
            </form>
        </div>
    </div>

    <h1>Fraud Protection Dashboard</h1>

    <p class="description">
        Manage suspicious transactions and investigate potential fraud activities.
    </p>

    <div class="cards">

        <div class="card">
            <h2>Fraud Detection</h2>

            <p>
                Check transactions for suspicious activity using predefined
                fraud detection rules.
            </p>

            <a href="{{ route('fraud.board') }}">
                View Fraud Cases
            </a>
        </div>

        <div class="card">
            <h2>Fraud Case Board</h2>

            <p>
                Review flagged transactions, add investigation notes,
                and update case stages.
            </p>

            <a href="{{ route('fraud.board') }}">
                Open Case Board
            </a>
        </div>

    </div>

</div>

</body>
</html>
