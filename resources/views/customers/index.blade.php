<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Management | BankShield</title>

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

        /* Navigation Bar */
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

        .navbar a:hover {
            background: #1e40af;
        }

        .navbar a.active {
            background: #1e40af;
        }

        .navbar form {
            display: inline;
        }

        .logout-button {
            background: #dc2626;
            color: white;
            border: none;
            margin-left: 15px;
            padding: 10px 15px;
            border-radius: 6px;
            cursor: pointer;
            font-weight: bold;
        }

        .logout-button:hover {
            background: #b91c1c;
        }

        h1 {
            color: #1e3a8a;
        }

        .top-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 15px;
            flex-wrap: wrap;
            margin-bottom: 25px;
        }

        .search-form {
            display: flex;
            gap: 8px;
        }

        input {
            padding: 10px;
            border: 1px solid #cbd5e1;
            border-radius: 6px;
        }

        button, .add-button, .edit-button {
            background: #1e40af;
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 6px;
            cursor: pointer;
            text-decoration: none;
        }

        .add-button {
            background: #15803d;
        }

        .edit-button {
            background: #2563eb;
            padding: 7px 12px;
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

        .empty {
            text-align: center;
            padding: 25px;
            color: #64748b;
        }
    </style>
</head>

<body>

<div class="container">

    <!-- Navigation Bar -->
    <div class="navbar">
        <h2>🛡️ BankShield</h2>

        <div>
            <a href="{{ route('customers.index') }}" class="active">
                Customers
            </a>

            <a href="{{ route('accounts.index') }}">
                Accounts
            </a>

            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="logout-button">
                    Logout
                </button>
            </form>
        </div>
    </div>

    <h1>Customer Management</h1>

    @if (session('success'))
        <div class="success">
            {{ session('success') }}
        </div>
    @endif

    <div class="top-bar">

        <form action="{{ route('customers.search') }}" method="GET" class="search-form">
            <input
                type="text"
                name="search"
                placeholder="Search name, number or phone"
                value="{{ request('search') }}"
            >

            <button type="submit">Search</button>
        </form>

        <a href="{{ route('customers.create') }}" class="add-button">
            + Add New Customer
        </a>

    </div>

    <table>
        <thead>
            <tr>
                <th>Customer Number</th>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>City</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>

        <tbody>

            @forelse ($customers as $customer)
                <tr>
                    <td>{{ $customer->customer_number }}</td>

                    <td>
                        {{ $customer->first_name }}
                        {{ $customer->last_name }}
                    </td>

                    <td>{{ $customer->email ?? 'N/A' }}</td>

                    <td>{{ $customer->phone }}</td>

                    <td>{{ $customer->city ?? 'N/A' }}</td>

                    <td>{{ ucfirst($customer->status) }}</td>

                    <td>
                        <a
                            href="{{ route('customers.edit', $customer->id) }}"
                            class="edit-button"
                        >
                            Edit
                        </a>
                    </td>
                </tr>

            @empty
                <tr>
                    <td colspan="7" class="empty">
                        No customers found.
                    </td>
                </tr>
            @endforelse

        </tbody>
    </table>

</div>

</body>
</html>
